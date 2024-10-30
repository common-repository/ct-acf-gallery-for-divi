<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CTDAG_CtDiviUtils {

	public function __construct() {
		add_filter( 'et_builder_load_actions', array( $this, 'add_our_ajax_action' ) );
		add_action( 'wp_ajax_ctdag_get_acf_gallery_data', array( $this, 'ajax_get_acf_gallery_data' ) );
	}

	public function ajax_get_acf_gallery_data() {
		if ( isset( $_POST['props'] ) && isset( $_POST['nonce'] ) && wp_verify_nonce( sanitize_text_field( $_POST['nonce'] ), 'ctdag_get_acf_gallery_data' ) ) {
			$props = sanitize_text_field( $_POST['props'] );
			$clean = wp_kses_stripslashes( $props );
			$props = json_decode( $clean, true );
			if ( isset( $_POST['vb'] ) ) {
				$props['ctvb'] = json_decode( wp_kses_stripslashes( sanitize_text_field( $_POST['vb'] ) ), true );
			}
			$posts_data = self::get_acf_gallery_data( $props );
			wp_send_json( $posts_data );
		} else {
			wp_send_json( [ 'error' => 'Fail nonce verification' ] );
		}
	}

	public static function get_pagination_html( $posts_data, $props ): string {
		$p_html = '';
		if ( $props['s_p'] === 'on' && $posts_data['extra']['max_num_pages'] > 1 && isset( $_SERVER['REQUEST_URI'] ) ) {
			$prev = $posts_data['extra']['current_page'] > 1 ? $posts_data['extra']['current_page'] - 1 : 1;
			$next = $posts_data['extra']['current_page'] < $posts_data['extra']['max_num_pages'] ? $posts_data['extra']['current_page'] + 1 : $posts_data['extra']['max_num_pages'];

			$pb = '';
			for ( $page = 1; $page <= $posts_data['extra']['max_num_pages']; $page ++ ) {
				$pb .= sprintf( '<li class="ctdag-page-btn"><a href="%2$s" class="ctdag-page-link%3$s" data-page="%1$s">%1$s</a></li>',
					esc_attr( $page ),
					get_pagenum_link( $page ),
					$posts_data['extra']['current_page'] === $page ? ' ctdag-link-active' : '' );
			}
			if ( $props['s_pnb'] === 'on' ) {
				$pb = sprintf( '<li class="ctdag-page-btn ctdag-page-navigation ctdag-previous-page"><a href="%2$s" class="ctdag-page-link" data-page="%6$s">%4$s</a></li>%1$s<li class="ctdag-page-btn ctdag-page-navigation ctdag-next-page"><a href="%3$s" class="ctdag-page-link" data-page="%7$s">%5$s</a></li>',
					$pb,
					get_pagenum_link( $prev ),
					get_pagenum_link( $next ),
					esc_html( $props['prev_txt'] ),
					esc_html( $props['next_txt'] ),
					$prev,
					$next );
			}
			if ( $props['s_flb'] === 'on' ) {
				$pb = sprintf( '<li class="ctdag-page-btn ctdag-page-navigation ctdag-first-page"><a href="%2$s" class="ctdag-page-link" data-page="1">%4$s</a></li>%1$s<li class="ctdag-page-btn ctdag-page-navigation ctdag-last-page"><a href="%3$s" class="ctdag-page-link" data-page="%6$s">%5$s</a></li>',
					$pb,
					get_pagenum_link( 1 ),
					get_pagenum_link( $posts_data['extra']['max_num_pages'] ),
					esc_html( $props['first_txt'] ),
					esc_html( $props['last_txt'] ),
					$posts_data['extra']['max_num_pages'] );
			}
			$p_html = sprintf( '<ul class="ctdag-pagination-buttons">%1$s</ul>', $pb );

			$p_html = apply_filters( 'ctdag_pagination_html', $p_html, $props, $posts_data );
			$p_html = sprintf( '<div class="ctdag-pagination" data-current-page="%2$s" data-last-page="%3$s" data-in-last-page="%4$s" data-scroll-offset="%5$s">%1$s</div>',
				$p_html,
				esc_attr( $posts_data['extra']['current_page'] ),
				esc_attr( $posts_data['extra']['max_num_pages'] ),
				$posts_data['extra']['current_page'] === $posts_data['extra']['max_num_pages'] ? 'on' : 'off',
				esc_attr( $props['p_tbo'] ) );
		}

		return $p_html;
	}

	static function get_acf_gallery_data( $props ): array {
		global $paged;
		$posts_data = array( 'error' => false, 'data' => [], 'extra' => [] );

		$layouts_pt  = [ 'et_header_layout', 'et_body_layout', 'et_footer_layout', 'et_pb_layout' ];
		$is_singular = is_singular();
		$is_template = false;
		$run_query   = false;
		if ( isset( $props['ctvb']['type'] ) && isset( $props['ctvb']['id'] ) ) {
			$the_ID      = intval( $props['ctvb']['id'] );
			$is_template = in_array( $props['ctvb']['type'], $layouts_pt );
			$is_singular = ! $is_template;
		} else {
			$the_ID = $props['the_ID'];
		}

		$query_args = array(
			'post_type'      => 'attachment',
			'post_status'    => 'any',
			'post_mime_type' => 'image/%',
			'posts_per_page' => isset( $props['ctvb']['id'] ) & $props['s_p'] === 'on' ? $props['num'] : '-1',
			'order'          => $props['order'],
			'orderby'        => $props['order_by'],
			'paged'          => $paged,
		);

		switch ( $props['gallery_src'] ) {
			case 'custom':
				$query_args['post__in'] = explode( ',', $props['gallery_ids'] );
				$run_query              = true;
				break;
			case 'acf_gallery':
				if ( class_exists( 'ACF' ) && ! empty( $props['acf_gallery'] ) ) {
					$acf_gallery = get_field( $props['acf_gallery'], $the_ID, false );
					if ( $is_singular && ! empty( $acf_gallery ) ) {
						if ( ! is_array( $acf_gallery ) ) {
							$acf_gallery = array( $acf_gallery );
						}
						$query_args['post__in'] = $acf_gallery;
						$run_query              = true;
					} else if ( $is_template ) {
						$posts_data['extra']['template'] = true;
						$run_query                       = true;
					}
				}
			default:
				break;
		}

		if ( $run_query ) {
			$query = new WP_Query( $query_args );
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$post_data            = array(
						'id'        => get_the_ID(),
						'title'     => get_the_title(),
						'img_html'  => wp_get_attachment_image( get_the_ID(), 'post-thumbnail' ),
						'permalink' => get_the_permalink(),
						'classes'   => get_post_class(),
						'caption'   => get_the_excerpt(),
						'excerpt'   => get_the_content()
					);
					$post_data            = apply_filters( 'ctdag_get_media_data', $post_data, $props );
					$posts_data['data'][] = $post_data;
				}
			}

			$max_pages           = intval( $props['num'] ) ? ceil( $query->found_posts / $props['num'] ) : 1;
			$posts_data['extra'] = [
				'found_posts'   => $query->found_posts,
				'max_num_pages' => max( $max_pages, 1 ),
				'current_page'  => $paged !== 0 ? $paged : 1,
			];

			wp_reset_postdata();
		}

		return $posts_data;
	}

	public function add_our_ajax_action( $actions ): array {
		return array_merge( $actions, array( 'ctdag_get_acf_gallery_data' ) );
	}
}

new CTDAG_CtDiviUtils;
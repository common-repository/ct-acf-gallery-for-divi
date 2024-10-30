<?php
if ( ! class_exists( 'CTDAG_ACFGallery' ) ) {
	class CTDAG_ACFGallery extends ET_Builder_Module {

		public $slug = 'ctdag_acf_gallery';
		public $vb_support = 'on';
		public $icon = "'";

		protected $module_credits = array(
			'module_uri' => 'https://divicoding.com',
			'author'     => 'Divi Coding',
			'author_uri' => 'https://divicoding.com',
		);

		public function init() {
			$this->name             = __( 'ACF Gallery', 'ctdag-ct-divi-acf-gallery' );
			$this->folder_name      = 'divi_coding';
			$this->main_css_element = '%%order_class%%';
			/*$this->help_videos      = array(
				array(
					'id'   => 'CtSiD8B4ynw',
					'name' => __( 'An introduction to the Divi ACF Object Loop module', 'ct-dag' ),
				),
			);*/
		}

		public function get_settings_modal_toggles(): array {
			return array(
				'general'  => array(
					'toggles' => array(
						'main_content' => array(
							'title' => __( 'Content', 'ct-dag' ),
						),
						'elements'     => array(
							'title' => __( 'Elements', 'ct-dag' ),
						),
						'pagination'   => array(
							'title' => __( 'Pagination', 'ct-dag' ),
						),
						'filters'      => array(
							'title' => __( 'Filters', 'ct-dag' ),
						),
					),
				),
				'advanced' => array(
					'toggles' => array(
						'layout'  => array(
							'title' => __( 'Layout', 'ct-dag' ),
						),
						'overlay' => array(
							'title' => __( 'Overlay', 'ct-dag' ),
						),
					),
				),
			);
		}

		public function get_advanced_fields_config(): array {
			return array(
				'background'   => array(
					'use_background_image'   => false,
					'use_background_video'   => false,
					'use_background_pattern' => false,
					'use_background_mask'    => false
				),
				'link_options' => false,
				'text'         => false,
				'fonts'        => array(
					'title'   => array(
						'label'        => __( 'Title', 'ct-dag' ),
						'css'          => array( 'main' => "$this->main_css_element .ctdag-title" ),
						'header_level' => array( 'default' => 'h3' ),
						'font_size'    => array( 'default' => '18px' ),
						'line_height'  => array( 'default' => '1.2em' )
					),
					'caption' => array(
						'label'       => __( 'Link', 'ct-dag' ),
						'css'         => array( 'main' => "$this->main_css_element .ctdag-caption" ),
						'font_size'   => array( 'default' => '14px' ),
						'line_height' => array( 'default' => '1.7em' )
					),
					'excerpt' => array(
						'label'       => __( 'Description', 'ct-dag' ),
						'css'         => array( 'main' => "$this->main_css_element .ctdag-excerpt" ),
						'font_size'   => array( 'default' => '14px' ),
						'line_height' => array( 'default' => '1.7em' )
					),
				),
				'borders'      => array(
					'default' => array(
						'css'          => array(
							'main' => array(
								'border_radii'        => "$this->main_css_element .ctdag-item",
								'border_styles'       => "$this->main_css_element .ctdag-item",
								'border_styles_hover' => "$this->main_css_element .ctdag-item:hover",
							),
						),
						'defaults'     => array(
							'border_radii'  => 'on||||',
							'border_styles' => array(
								'width' => '1px',
								'color' => '#d8d8d8',
								'style' => 'solid',
							),
						),
						'label_prefix' => __( 'Item', 'ct-dag' ),
					),
				),
				'box_shadow'   => array(
					'default' => array(
						'css' => array(
							'main' => "$this->main_css_element .ctdag-item",
						),
					),
				),
				'filters'      => false
			);
		}

		public function get_fields(): array {
			return array(
				'gallery_src'         => array(
					'label'       => __( 'Images Source', 'ct-dag' ),
					'type'        => 'select',
					'options'     => array(
						'acf_gallery' => __( 'ACF Gallery Field', 'ct-dag' ),
						'custom'      => __( 'Manual Selection', 'ct-dag' ),
					),
					'default'     => 'acf_gallery',
					'toggle_slug' => 'main_content',
				),
				'gallery_ids'         => array(
					'label'       => __( 'Images', 'ct-dag' ),
					'description' => __( 'Choose the images that you would like to appear in the image gallery.', 'ct-dag' ),
					'type'        => 'upload-gallery',
					'show_if'     => array( 'gallery_src' => 'custom' ),
					'toggle_slug' => 'main_content',
				),
				'acf_gallery'         => array(
					'label'       => __( 'ACF Gallery Field Name', 'ct-dag' ),
					'description' => __( 'Enter the ACF Gallery field name.', 'ct-dag' ),
					'type'        => 'text',
					'show_if'     => array( 'gallery_src' => 'acf_gallery' ),
					'toggle_slug' => 'main_content',
				),
				'order'               => array(
					'label'       => __( 'Order', 'ct-dag' ),
					'type'        => 'select',
					'options'     => array(
						'DESC' => __( 'Descending', 'ct-dag' ),
						'ASC'  => __( 'Ascending', 'ct-dag' ),
					),
					'default'     => 'DESC',
					'toggle_slug' => 'main_content',
				),
				'order_by'            => array(
					'label'       => __( 'Order By', 'ct-dag' ),
					'type'        => 'select',
					'options'     => array(
						'post__in' => __( 'Maintain selection order', 'ct-dag' ),
						'title'    => __( 'Title', 'ct-dag' ),
						'name'     => __( 'Slug', 'ct-dag' ),
						'date'     => __( 'Date', 'ct-dag' ),
						'rand'     => __( 'Random', 'ct-dag' ),
					),
					'default'     => 'post__in',
					'toggle_slug' => 'main_content',
				),
				'show_overlay'        => array(
					'label'       => __( 'Show Overlay', 'ct-dag' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => __( 'On', 'ct-dag' ),
						'off' => __( 'Off', 'ct-dag' ),
					),
					'default'     => 'on',
					'toggle_slug' => 'elements',
				),
				'show_title'          => array(
					'label'       => __( 'Show Title', 'ct-dag' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => __( 'On', 'ct-dag' ),
						'off' => __( 'Off', 'ct-dag' ),
					),
					'default'     => 'on',
					'toggle_slug' => 'elements',
				),
				'show_caption'        => array(
					'label'       => __( 'Show Caption', 'ct-dag' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => __( 'On', 'ct-dag' ),
						'off' => __( 'Off', 'ct-dag' ),
					),
					'default'     => 'off',
					'toggle_slug' => 'elements',
				),
				'show_description'    => array(
					'label'       => __( 'Show Description', 'ct-dag' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => __( 'On', 'ct-dag' ),
						'off' => __( 'Off', 'ct-dag' ),
					),
					'default'     => 'off',
					'toggle_slug' => 'elements',
				),
				'click_action'        => array(
					'label'       => __( 'Image Click Action', 'ct-dag' ),
					'type'        => 'select',
					'options'     => array(
						'none'    => __( 'None', 'ct-dag' ),
						'popup'   => __( 'Show Image In Lightbox', 'ct-dag' ),
						'gallery' => __( 'Show All Images In Lightbox', 'ct-dag' ),
					),
					'default'     => 'none',
					'toggle_slug' => 'elements',
				),
				's_t_p'               => array(
					'label'       => __( 'Title In Lightbox', 'ct-dag' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => __( 'On', 'ct-dag' ),
						'off' => __( 'Off', 'ct-dag' ),
					),
					'show_if'     => array( 'click_action' => [ 'popup', 'gallery' ] ),
					'default'     => 'on',
					'toggle_slug' => 'elements',
				),
				's_c_p'               => array(
					'label'       => __( 'Caption In Lightbox', 'ct-dag' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => __( 'On', 'ct-dag' ),
						'off' => __( 'Off', 'ct-dag' ),
					),
					'show_if'     => array( 'click_action' => [ 'popup', 'gallery' ] ),
					'default'     => 'off',
					'toggle_slug' => 'elements',
				),
				's_d_p'               => array(
					'label'       => __( 'Description In Lightbox', 'ct-dag' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => __( 'On', 'ct-dag' ),
						'off' => __( 'Off', 'ct-dag' ),
					),
					'show_if'     => array( 'click_action' => [ 'popup', 'gallery' ] ),
					'default'     => 'off',
					'toggle_slug' => 'elements',
				),
				's_p'                 => array(
					'label'       => __( 'Show Pagination', 'ct-dag' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => __( 'On', 'ct-dag' ),
						'off' => __( 'Off', 'ct-dag' ),
					),
					'default'     => 'off',
					'toggle_slug' => 'pagination',
				),
				'num'                 => array(
					'label'       => __( 'Number', 'ct-dag' ),
					'description' => __( 'Number of images to show per page. Leave empty to show all images', 'ct-dag' ),
					'type'        => 'text',
					'show_if'     => array( 's_p' => 'on' ),
					'default'     => '12',
					'toggle_slug' => 'pagination',
				),
				'p_tbo'               => array(
					'label'       => __( 'Scroll Top Offset', 'ct-dag' ),
					'description' => __( 'Space to leave on top of the main container after pagination scroll.', 'ct-dag' ),
					'type'        => 'text',
					'default'     => 100,
					'show_if'     => array( 's_p' => 'on' ),
					'toggle_slug' => 'pagination',
				),
				's_pnb'               => array(
					'label'       => __( 'Show Previous/Next Buttons', 'ct-dag' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => __( 'On', 'ct-dag' ),
						'off' => __( 'Off', 'ct-dag' ),
					),
					'default'     => 'on',
					'show_if'     => array( 's_p' => 'on' ),
					'toggle_slug' => 'pagination',
				),
				'prev_txt'            => array(
					'label'       => __( 'Previous Page Text', 'ct-dag' ),
					'type'        => 'text',
					'default'     => __( 'Previous', 'ct-dag' ),
					'show_if'     => array( 's_p' => 'on' ),
					'toggle_slug' => 'pagination',
				),
				'next_txt'            => array(
					'label'       => __( 'Next Page Text', 'ct-dag' ),
					'type'        => 'text',
					'default'     => __( 'Next', 'ct-dag' ),
					'show_if'     => array( 's_p' => 'on' ),
					'toggle_slug' => 'pagination',
				),
				's_flb'               => array(
					'label'       => __( 'Show First/Last Buttons', 'ct-dag' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => __( 'On', 'ct-dag' ),
						'off' => __( 'Off', 'ct-dag' ),
					),
					'default'     => 'on',
					'show_if'     => array( 's_p' => 'on' ),
					'toggle_slug' => 'pagination',
				),
				'first_txt'           => array(
					'label'       => __( 'First Page Text', 'ct-dag' ),
					'type'        => 'text',
					'default'     => __( 'First', 'ct-dag' ),
					'show_if'     => array( 's_p' => 'on' ),
					'toggle_slug' => 'pagination',
				),
				'last_txt'            => array(
					'label'       => __( 'Last Page Text', 'ct-dag' ),
					'type'        => 'text',
					'default'     => __( 'Last', 'ct-dag' ),
					'show_if'     => array( 's_p' => 'on' ),
					'toggle_slug' => 'pagination',
				),
				'layout'              => array(
					'label'       => __( 'Layout', 'ct-dag' ),
					'type'        => 'select',
					'options'     => array(
						'ctdag-layout-mini-masonry'     => __( 'Mini Masonry', 'ct-dag' ),
						'ctdag-layout-masonry-desandro' => __( 'Masonry', 'ct-dag' ),
						'ctdag-layout-grid'             => __( 'Grid', 'ct-dag' ),
					),
					'default'     => 'ctdag-layout-mini-masonry',
					'toggle_slug' => 'layout',
					'tab_slug'    => 'advanced'
				),
				'm_item_w'            => array(
					'label'       => __( 'Items Width', 'ct-dag' ),
					'description' => __( 'Minimum width for the masonry items.', 'ct-dag' ),
					'type'        => 'text',
					'default'     => 240,
					'show_if'     => [ 'layout' => 'ctdag-layout-mini-masonry' ],
					'toggle_slug' => 'layout',
					'tab_slug'    => 'advanced'
				),
				'm_item_g'            => array(
					'label'       => __( 'Items Gap', 'ct-dag' ),
					'description' => __( 'Gap for the masonry items.', 'ct-dag' ),
					'type'        => 'text',
					'default'     => 20,
					'show_if'     => [ 'layout' => 'ctdag-layout-mini-masonry' ],
					'toggle_slug' => 'layout',
					'tab_slug'    => 'advanced'
				),
				'm_m'                 => array(
					'label'       => __( 'Minify', 'ct-dag' ),
					'description' => __( 'Whether or not place items on shortest column or keep exact order of list.', 'ct-dag' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => __( 'On', 'ct-dag' ),
						'off' => __( 'Off', 'ct-dag' ),
					),
					'default'     => 'on',
					'show_if'     => [ 'layout' => 'ctdag-layout-mini-masonry' ],
					'toggle_slug' => 'layout',
					'tab_slug'    => 'advanced'
				),
				'columns'             => array(
					'label'          => __( 'Columns', 'ct-dag' ),
					'description'    => __( 'Adjust the number of columns.', 'ct-dag' ),
					'type'           => 'range',
					'default'        => 4,
					'default_unit'   => '',
					'range_settings' => array(
						'min'  => 1,
						'max'  => 20,
						'step' => 1,
					),
					'mobile_options' => true,
					'validate_unit'  => false,
					'show_if'        => array(
						'layout' => array(
							'ctdag-layout-grid',
							'ctdag-layout-masonry-desandro'
						)
					),
					'toggle_slug'    => 'layout',
					'tab_slug'       => 'advanced'
				),
				'gaps'                => array(
					'label'          => __( 'Gap', 'ct-dag' ),
					'description'    => __( 'Adjust the spacing between columns and above items as needed.', 'ct-dag' ),
					'type'           => 'range',
					'default'        => '20px',
					'default_unit'   => 'px',
					'range_settings' => array(
						'min'  => 1,
						'max'  => 300,
						'step' => 1,
					),
					'mobile_options' => true,
					'validate_unit'  => true,
					'show_if'        => array(
						'layout' => array(
							'ctdag-layout-grid',
							'ctdag-layout-masonry-desandro'
						)
					),
					'toggle_slug'    => 'layout',
					'tab_slug'       => 'advanced'
				),
				'item_bg'             => array(
					'label'        => __( 'Item Background', 'ct-dag' ),
					'description'  => __( 'Image container background.', 'ct-dag' ),
					'type'         => 'color-alpha',
					'custom_color' => true,
					'toggle_slug'  => 'background',
				),
				'zoom_icon_color'     => array(
					'label'        => __( 'Overlay Icon Color', 'ct-dag' ),
					'description'  => __( 'Here you can define a custom color for the zoom icon.', 'ct-dag' ),
					'type'         => 'color-alpha',
					'custom_color' => true,
					'show_if'      => array( 'show_overlay' => 'on' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'overlay',
				),
				'hover_overlay_color' => array(
					'label'        => __( 'Overlay Background Color', 'ct-dag' ),
					'description'  => __( 'Here you can define a custom color for the overlay', 'ct-dag' ),
					'type'         => 'color-alpha',
					'custom_color' => true,
					'show_if'      => array( 'show_overlay' => 'on' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'overlay',
				),
				'hover_icon'          => array(
					'label'       => __( 'Overlay Icon', 'ct-dag' ),
					'description' => __( 'Here you can define a custom icon for the overlay', 'ct-dag' ),
					'type'        => 'select_icon',
					'class'       => array( 'et-pb-font-icon' ),
					'show_if'     => array( 'show_overlay' => 'on' ),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'overlay',
				)
			);
		}

		public function before_render() {
			add_filter( 'et_late_global_assets_list', array( $this, 'et_global_assets_list' ) );
			wp_enqueue_script( 'magnific-popup', ET_BUILDER_URI . '/feature/dynamic-assets/assets/js/magnific-popup.js', array( 'jquery' ), ET_CORE_VERSION, true );
			if ( $this->props['layout'] === 'ctdag-layout-masonry-desandro' ) {
				wp_enqueue_script( 'masonry' );
			}
		}

		public function render( $attrs, $content, $render_slug ) {
			$html_output           = '';
			$this->props['the_ID'] = get_the_ID();
			$posts_data            = CTDAG_CtDiviUtils::get_acf_gallery_data( $this->props );
			if ( ! $posts_data['error'] && ! empty( $posts_data['data'] ) ) {
				$posts_html        = '';
				$hover_icon        = $this->props['hover_icon'];
				$hover_icon_values = et_pb_responsive_options()->get_property_values( $this->props, 'hover_icon' );
				$hover_icon_tablet = $hover_icon_values['tablet'] ?? '';
				$hover_icon_phone  = $hover_icon_values['phone'] ?? '';
				$overlay_output    = 'off' === $this->props['show_overlay'] ? '' : ET_Builder_Module_Helper_Overlay::render(
					array(
						'icon'        => $hover_icon,
						'icon_tablet' => $hover_icon_tablet,
						'icon_phone'  => $hover_icon_phone,
					)
				);
				$items_counter     = 1;
				foreach ( $posts_data['data'] as $post ) {
					$item_page = intval( ceil( $items_counter / $this->props['num'] ) );
					$img_html  = sprintf( '<figure class="ctdag-image" data-title="%3$s" data-caption="%4$s" data-excerpt="%5$s">%1$s%2$s</figure>',
						$post['img_html'],
						$overlay_output,
						$this->props['s_t_p'] === 'on' ? esc_attr( $post['title'] ) : '',
						$this->props['s_c_p'] === 'on' ? esc_attr( $post['caption'] ) : '',
						$this->props['s_d_p'] === 'on' ? esc_attr( $post['excerpt'] ) : ''
					);
					$title     = $this->props['show_title'] === 'on' ? sprintf( '<%2$s class="ctdag-title">%1$s</%2$s>', $post['title'], $this->props['title_level'] ) : '';
					$caption   = $this->props['show_caption'] === 'on' && ! empty( $post['caption'] ) ? sprintf( '<div class="ctdag-caption">%1$s</div>', $post['caption'] ) : '';
					$excerpt   = $this->props['show_description'] === 'on' && ! empty( $post['excerpt'] ) ? sprintf( '<div class="ctdag-excerpt">%1$s</div>', $post['excerpt'] ) : '';

					$item_html = $img_html . $title . $caption . $excerpt;

					if ( $item_page !== $posts_data['extra']['current_page'] ) {
						$post['classes'][] = 'ctdag-hide';
					}

					$posts_html .= sprintf( '<divi class="ctdag-item %3$s" data-url="%2$s" data-page="%4$s">%1$s</divi>',
						$item_html,
						$post['permalink'],
						implode( ' ', $post['classes'] ),
						$item_page );

					$items_counter ++;
				}

				$this->css( $render_slug );
				$data_masonry = wp_json_encode( [
					$this->props['m_item_w'],
					$this->props['m_item_g'],
					$this->props['m_m']
				] );

				$html_output = sprintf( '<div class="ctdag-main-container %4$s" data-action="%2$s" data-m="%3$s" data-page="%7$s"><div class="ctdag-items">%1$s%5$s</div>%6$s</div>',
					$posts_html,
					esc_attr( $this->props['click_action'] ),
					htmlspecialchars( $data_masonry ),
					esc_attr( $this->props['layout'] ),
					$this->props['layout'] === 'ctdag-layout-masonry-desandro' ? '<div class="ctdag-dm-sizer"></div>' : '',
					CTDAG_CtDiviUtils::get_pagination_html( $posts_data, $this->props ),
					$posts_data['extra']['current_page']
				);
			}

			return $html_output;
		}

		public function css( $render_slug ) {
			$gaps_responsive_active = et_pb_get_responsive_status( $this->props['gaps_last_edited'] );
			$gaps_desktop_css       = $this->props['gaps'];
			$gaps_values            = array(
				'desktop' => $gaps_desktop_css,
				'tablet'  => $gaps_responsive_active ? $this->props['gaps_tablet'] : $gaps_desktop_css,
				'phone'   => $gaps_responsive_active ? $this->props['gaps_phone'] : $gaps_desktop_css
			);
			if ( $this->props['layout'] === 'ctdag-layout-grid' ) {
				$columns_responsive_active = et_pb_get_responsive_status( $this->props['columns_last_edited'] );
				$columns_desktop_css       = sprintf( 'repeat(%1$s, minmax(0, 1fr))', intval( $this->props['columns'] ) );
				$columns_values            = array(
					'desktop' => $columns_desktop_css,
					'tablet'  => $columns_responsive_active ? sprintf( 'repeat(%1$s, minmax(0, 1fr))', intval( $this->props['columns_tablet'] ) ) : $columns_desktop_css,
					'phone'   => $columns_responsive_active ? sprintf( 'repeat(%1$s, minmax(0, 1fr))', intval( $this->props['columns_phone'] ) ) : $columns_desktop_css
				);
				$selector                  = '%%order_class%% .' . $this->props['layout'] . ' .ctdag-items';
				et_pb_responsive_options()->generate_responsive_css( $columns_values, $selector, 'grid-template-columns', $render_slug, '', '' );
				et_pb_responsive_options()->generate_responsive_css( $gaps_values, $selector, 'grid-gap', $render_slug, '', '' );
			}
			if ( $this->props['layout'] === 'ctdag-layout-masonry-desandro' ) {
				$columns_responsive_active = et_pb_get_responsive_status( $this->props['columns_last_edited'] );
				$columns_desktop_css       = sprintf( 'calc(%1$s - %2$s)',
					( 100 / $this->props['columns'] ) . '%',
					( ( intval( $gaps_values['desktop'] ) * ( intval( $this->props['columns'] ) - 1 ) ) / intval( $this->props['columns'] ) ) . 'px'
				);
				$columns_values            = array(
					'desktop' => $columns_desktop_css,
					'tablet'  => $columns_responsive_active ? sprintf( 'calc(%1$s - %2$s)',
						( 100 / $this->props['columns_tablet'] ) . '%',
						( ( intval( $gaps_values['tablet'] ) * ( intval( $this->props['columns_tablet'] ) - 1 ) ) / intval( $this->props['columns_tablet'] ) ) . 'px'
					) : $columns_desktop_css,
					'phone'   => $columns_responsive_active ? sprintf( 'calc(%1$s - %2$s)',
						( 100 / $this->props['columns_phone'] ) . '%',
						( ( intval( $gaps_values['phone'] ) * ( intval( $this->props['columns_phone'] ) - 1 ) ) / intval( $this->props['columns_phone'] ) ) . 'px'
					) : $columns_desktop_css
				);
				$selector                  = '%%order_class%% .' . $this->props['layout'] . ' .ctdag-item';
				et_pb_responsive_options()->generate_responsive_css( $columns_values, $selector, 'width', $render_slug, '', '' );
				et_pb_responsive_options()->generate_responsive_css( $gaps_values, $selector, 'margin-bottom', $render_slug, '', '' );
				et_pb_responsive_options()->generate_responsive_css( $gaps_values, '%%order_class%% .' . $this->props['layout'] . ' .ctdag-dm-sizer', 'width', $render_slug, '', '' );
			}
			$this->generate_styles(
				array(
					'render_slug'    => $render_slug,
					'base_attr_name' => 'item_bg',
					'css_property'   => 'background-color',
					'selector'       => '%%order_class%% .ctdag-item',
					'hover_selector' => '%%order_class%% .ctdag-item:hover',
				)
			);
			$this->generate_styles(
				array(
					'hover'          => false,
					'utility_arg'    => 'icon_font_family',
					'render_slug'    => $render_slug,
					'base_attr_name' => 'hover_icon',
					'important'      => true,
					'selector'       => '%%order_class%% .et_overlay:before',
					'processor'      => array(
						'ET_Builder_Module_Helper_Style_Processor',
						'process_extended_icon',
					),
				)
			);
			$this->generate_styles(
				array(
					'hover'          => false,
					'base_attr_name' => 'zoom_icon_color',
					'selector'       => '%%order_class%% .et_overlay:before',
					'css_property'   => 'color',
					'render_slug'    => $render_slug,
					'important'      => true,
					'type'           => 'color',
				)
			);
			$this->generate_styles(
				array(
					'hover'          => false,
					'base_attr_name' => 'hover_overlay_color',
					'selector'       => '%%order_class%% .et_overlay',
					'css_property'   => array( 'background-color', 'border-color' ),
					'render_slug'    => $render_slug,
					'type'           => 'color',
				)
			);
		}

		public function et_global_assets_list( $assets_list ) {
			$assets_prefix = et_get_dynamic_assets_path();
			if ( ! ( isset( $assets['et_icons_all'] ) && isset( $assets['et_icons_fa'] ) ) ) {
				$assets_list['et_icons_all'] = array(
					'css' => "{$assets_prefix}/css/icons_all.css",
				);
				$assets_list['et_icons_fa']  = array(
					'css' => "{$assets_prefix}/css/icons_fa_all.css",
				);
			}
			if ( ! isset( $assets['et_overlay'] ) ) {
				$assets_list['et_overlay'] = array(
					'css' => "{$assets_prefix}/css/overlay.css"
				);
			}
			if ( ! isset( $assets['et_jquery_magnific_popup'] ) ) {
				$assets_list['et_jquery_magnific_popup'] = array(
					'css' => "{$assets_prefix}/css/magnific_popup.css"
				);
			}

			return $assets_list;
		}
	}

	new CTDAG_ACFGallery;
}

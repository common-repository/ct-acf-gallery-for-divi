<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class CTDAG_CtDiviAcfGallery extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'ctdag-ct-divi-acf-gallery';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'ct-divi-acf-gallery';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * CTDAG_CtDiviAcfGallery constructor.
	 *
	 * @param string $name
	 * @param array $args
	 */
	public function __construct( $name = 'ct-divi-acf-gallery', $args = array() ) {
		$this->plugin_dir       = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url   = plugin_dir_url( $this->plugin_dir );
		$this->_builder_js_data = array(
			'nonce' => array(
				'query_data' => wp_create_nonce( 'ctdag_get_acf_gallery_data' )
			)
		);
		parent::__construct( $name, $args );
	}
}

new CTDAG_CtDiviAcfGallery;

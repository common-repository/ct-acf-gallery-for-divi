<?php
/*
Plugin Name: CT Gallery for Divi and ACF
Plugin URI:  https://divicoding.com/downloads/divi-acf-masonry-gallery/
Description: Add a new module to the Divi collection that will show a gallery from an ACF gallery field or manual selection of images.
Version:     1.0.3
Author:      Divi Coding
Author URI:  https://divicoding.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: ct-divi-acf-gallery
Domain Path: /languages

CT Gallery for Divi and ACF is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

CT Gallery for Divi and ACF is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with CT Gallery for Divi and ACF. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CTDAG_VERSION', '1.0.3' );
define( 'CTDAG_FILE', __FILE__ );
define( 'CTDAG_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'CTDAG_DIR_PATH', plugin_dir_path( __FILE__ ) );

// Init extension
if ( ! function_exists( 'ctdag_initialize_extension' ) ) {
	function ctdag_initialize_extension() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/CtDAGUtils.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/CtDiviAcfGallery.php';
	}

	add_action( 'divi_extensions_init', 'ctdag_initialize_extension' );
}
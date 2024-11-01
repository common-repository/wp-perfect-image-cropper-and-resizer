<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://expresstech.io/
 * @since      1.0.0
 *
 * @package    Wp_Perfect_Image_Cropper_Resizer
 * @subpackage Wp_Perfect_Image_Cropper_Resizer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Perfect_Image_Cropper_Resizer
 * @subpackage Wp_Perfect_Image_Cropper_Resizer/includes
 * @author     Express Tech <hi@expresstech.io>
 */
class Wp_Perfect_Image_Cropper_Resizer_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-perfect-image-cropper-resizer',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

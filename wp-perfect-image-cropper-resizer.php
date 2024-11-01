<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://expresstech.io/
 * @since             1.0.0
 * @package           Wp_Perfect_Image_Cropper_Resizer
 *
 * @wordpress-plugin
 * Plugin Name:       WP Perfect Image Cropper and Resizer
 * Plugin URI:        http://expresstech.io/plugins/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Express Tech
 * Author URI:        http://expresstech.io/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-perfect-image-cropper-resizer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-perfect-image-cropper-resizer-activator.php
 */
function activate_wp_perfect_image_cropper_resizer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-perfect-image-cropper-resizer-activator.php';
	Wp_Perfect_Image_Cropper_Resizer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-perfect-image-cropper-resizer-deactivator.php
 */
function deactivate_wp_perfect_image_cropper_resizer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-perfect-image-cropper-resizer-deactivator.php';
	Wp_Perfect_Image_Cropper_Resizer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_perfect_image_cropper_resizer' );
register_deactivation_hook( __FILE__, 'deactivate_wp_perfect_image_cropper_resizer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-perfect-image-cropper-resizer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_perfect_image_cropper_resizer() {

	$plugin = new Wp_Perfect_Image_Cropper_Resizer();
	$plugin->run();

}
run_wp_perfect_image_cropper_resizer();

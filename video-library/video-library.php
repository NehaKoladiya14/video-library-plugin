<?php
/*
 * Plugin Name:       Video Library
 * Plugin URI:        #
 * Description:       A custom plugin to display video posts with filters.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Peanut Square LLP
 * Author URI:        #
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       video-library
 */

if ( ! defined( 'ABSPATH' ) ) exit;


define( 'VL_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'VL_DIR_PATH', plugin_dir_path( __FILE__ ) );

// Autoload plugin classes
require_once VL_DIR_PATH . 'includes/class-video-library-plugin.php';

function run_video_library_plugin() {
    $plugin = new Video_Library_Plugin();
    $plugin->run();
}
add_action( 'plugins_loaded', 'run_video_library_plugin' );
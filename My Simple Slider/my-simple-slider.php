<?php

/**
 * Plugin Name: My Simple Slider
 * Plugin URI: https://wordpress.org/plugins/my-simple-slider
 * Description: My Simple Slider includes the following options for your content sliding needs. Just include the ones you want to change.
 * Version: 1.0
 * Requires at least: 5.6
 * Author: Di Depan Layar
 * Author URI: https://didepanlayar.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: my-simple-slider
 * Domain Path: /languages
 */

 /*
My Simple Slider is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

My Simple Slider is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with My Simple Slider. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! class_exists( 'MS_Slider' ) ) {
    class MS_Slider {
        function __construct() {
            $this->define_constants();

            add_action( 'admin_menu', array( $this, 'add_menu' ) );

            require_once( MS_SLIDER_PATH . 'post-types/class.ms-slider-cpt.php' );
            $MS_Slider_Post_Type = new MS_Slider_Post_Type();

            require_once( MS_SLIDER_PATH . 'class.ms-slider-settings.php' );
            $MS_Slider_settings = new MS_Slider_Settings();
        }

        public function define_constants() {
            define( 'MS_SLIDER_PATH', plugin_dir_path( __FILE__ ) );
            define( 'MS_SLIDER_URL', plugin_dir_url( __FILE__ ) );
            define( 'MS_SLIDER_VERSION', '1.0.0' );
        }

        public static function activate() {
            update_option( 'rewrite_rules', '' );
        }

        public static function deactivate() {
            flush_rewrite_rules();
            unregister_post_type( 'ms-slider' );
        }

        public static function uninstall() {

        }

        public function add_menu() {
            add_menu_page(
                'Slider Options',
                'Sliders',
                'manage_options',
                'ms-slider-setting',
                array( $this, 'ms_slider_settings_page' ),
                'dashicons-images-alt2'
            );

            add_submenu_page(
                'ms-slider-setting',
                'Manage Slides',
                'Manage Slides',
                'manage_options',
                'edit.php?post_type=ms-slider',
                null,
                null
            );

            add_submenu_page(
                'ms-slider-setting',
                'Add New Slide',
                'Add New Slide',
                'manage_options',
                'post-new.php?post_type=ms-slider',
                null,
                null
            );
        }

        public function ms_slider_settings_page() {
            require( MS_SLIDER_PATH . 'views/settings-page.php' );
        }
    }
}

if( class_exists( 'MS_slider' ) ) {
    register_activation_hook( __FILE__, array( 'MS_Slider', 'activate' ) );
    register_deactivation_hook( __FILE__, array( 'MS_Slider', 'deactivate' ) );
    register_uninstall_hook( __FILE__, array( 'MS_Slider', 'uninstall' ) );

    $ms_slider = new MS_Slider();
}
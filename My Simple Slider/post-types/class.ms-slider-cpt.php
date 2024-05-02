<?php

if( ! class_exists( 'MS_Slider_Post_type' ) ) {
    class MS_Slider_Post_type {
        function __construct() {
            add_action( 'init', array( $this, 'create_post_type' ) );
        }

        function create_post_type() {
            
        }
    }
}
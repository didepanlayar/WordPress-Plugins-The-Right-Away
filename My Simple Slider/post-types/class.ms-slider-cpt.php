<?php

if( ! class_exists( 'MS_Slider_Post_Type' ) ) {
    class MS_Slider_Post_Type {
        function __construct() {
            add_action( 'init', array( $this, 'create_post_type' ) );
        }

        function create_post_type() {
            register_post_type(
                'ms-slider',
                array(
                    'label'                 => 'Slider',
                    'description'           => 'Sliders',
                    'labels'                => array(
                        'name'          => 'Sliders',
                        'singular_name' => 'Slider'
                    ),
                    'public'                => true,
                    'supports'              => array( 'title', 'editor', 'thumbnail' ),
                    'hierarchical'          => false,
                    'show_ui'               => true,
                    'show_in_menu'          => true,
                    'menu_position'         => 5,
                    'show_in_admin_bar'     => true,
                    'show_in_nav_menus'     => true,
                    'can_export'            => true,
                    'has_archive'           => false,
                    'exclude_form_search'   => false,
                    'publicly_queryable'    => true,
                    'show_in_rest'          => true,
                    'menu_icon'             => 'dashicons-images-alt2'
                )
            );
        }
    }
}
<?php

if( ! class_exists( 'MS_Slider_Post_Type' ) ) {
    class MS_Slider_Post_Type {
        function __construct() {
            add_action( 'init', array( $this, 'create_post_type' ) );
            add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
            add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
            add_filter( 'manage_ms-slider_posts_columns', array( $this, 'ms_slider_cpt_columns' ) );
            add_action( 'manage_ms-slider_posts_custom_column', array( $this, 'ms_slider_custom_columns' ), 10, 2 );
            add_filter( 'manage_edit-ms-slider_sortable_columns', array( $this, 'ms_slider_sortable_colums' ) );
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
                    'menu_icon'             => 'dashicons-images-alt2',
                    // 'register_meta_box_cb'  => array( $this, 'add_meta_boxes' )
                )
            );
        }

        public function ms_slider_cpt_columns( $columns ) {
            $columns['ms_slider_link_text']     = esc_html__( 'Link Text', 'ms-slider' );
            $columns['ms_slider_link_url']      = esc_html__( 'Link URL', 'ms-slider' );
            return $columns;
        }

        public function ms_slider_custom_columns( $column, $post_id ) {
            switch( $column ) {
                case 'ms_slider_link_text':
                    echo esc_html( get_post_meta( $post_id, 'ms_slider_link_text', true ) );
                break;
                case 'ms_slider_link_url':
                    echo esc_url( get_post_meta( $post_id, 'ms_slider_link_url', true ) );
                break;
            }
        }

        public function ms_slider_sortable_colums( $columns ) {
            $columns['ms_slider_link_text']     = 'ms_slider_link_text';
            return $columns;
        }

        public function add_meta_boxes() {
            add_meta_box(
                'ms_slider_meta_box',
                'Link Options',
                array( $this, 'add_inner_meta_boxes' ),
                'ms-slider',
                'normal',
                'high'
            );
        }

        public function add_inner_meta_boxes( $post ) {
            require_once( MS_SLIDER_PATH . 'views/ms-slider_metabox.php' );
        }

        public function save_post( $post_id ) {
            if( isset( $_POST['ms_slider_nonce'] ) ) {
                if( ! wp_verify_nonce( $_POST['ms_slider_nonce'], 'ms_slider_nonce' ) ) {
                    return;
                }
            }

            if( define( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }

            if( isset( $_POST['post_type'] ) && $_POST['post_type'] == 'ms-slider' ) {
                if( ! current_user_can( 'edit_page', $post_id ) ) {
                    return;
                } elseif( ! current_user_can( 'edit_post', $post_id ) ) {
                    return;
                }
            }

            if( isset( $_POST['action'] ) && $_POST['action'] == 'editpost' ) {
                $old_link_text  = get_post_meta( $post_id, 'ms_slider_link_text', true );
                $new_link_text  = $_POST['ms_slider_link_text'];
                $old_link_url   = get_post_meta( $post_id, 'ms_slider_link_url', true );
                $new_link_url   = $_POST['ms_slider_link_url'];

                if( empty( $new_link_text ) ) {
                    update_post_meta( $post_id, 'ms_slider_link_text', 'Slider Link Text' );
                } else {
                    update_post_meta( $post_id, 'ms_slider_link_text', sanitize_text_field( $new_link_text ), $old_link_text );
                }

                if( empty( $new_link_url ) ) {
                    update_post_meta( $post_id, 'ms_slider_link_url', '#' );
                } else {
                    update_post_meta( $post_id, 'ms_slider_link_url', sanitize_text_field( $new_link_url ), $old_link_url );
                }
            }
        }
    }
}
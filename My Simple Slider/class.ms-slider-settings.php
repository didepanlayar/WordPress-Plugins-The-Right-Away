<?php

if( ! class_exists( 'MS_Slider_Settings' ) ) {
    class MS_Slider_Settings {
        public static $options;

        public function __construct() {
            self::$options = get_option( 'ms_slider_options' );
            add_action( 'admin_init', array( $this, 'admin_init' ) );
        }

        public function admin_init() {
            register_setting( 'ms_slider_group', 'ms_slider_options', array( $this, 'ms_slider_validate' ) );
            
            add_settings_section(
                'ms_slider_main_section',
                'How does it work?',
                null,
                'ms_slider_page_1'
            );

            add_settings_section(
                'ms_slider_second_section',
                'Other Options',
                null,
                'ms_slider_page_2'
            );

            add_settings_field(
                'ms_slider_shortcode',
                'Shortcode',
                array( $this, 'ms_slider_shortcode_callback' ),
                'ms_slider_page_1',
                'ms_slider_main_section'
            );

            add_settings_field(
                'ms_slider_title',
                'Slider Title',
                array( $this, 'ms_slider_title_callback' ),
                'ms_slider_page_2',
                'ms_slider_second_section',
                array(
                    'label_for' => 'ms_slider_title'
                )
            );

            add_settings_field(
                'ms_slider_bullets',
                'Display Bullets',
                array( $this, 'ms_slider_bullets_callback' ),
                'ms_slider_page_2',
                'ms_slider_second_section',
                array(
                    'label_for' => 'ms_slider_bullets'
                )
            );

            add_settings_field(
                'ms_slider_style',
                'Slider Style',
                array( $this, 'ms_slider_style_callback' ),
                'ms_slider_page_2',
                'ms_slider_second_section',
                array(
                    'items' => array(
                        'style-1',
                        'style-2'
                    ),
                    'label_for' => 'ms_slider_style'
                )
            );
        }

        public function ms_slider_shortcode_callback() {
            ?> <span>Use the shortcode [ms_slider] to display the slider in any page, post or widget.</span> <?php
        }

        public function ms_slider_title_callback( $arg ) {
            ?> <input type="text" name="ms_slider_options[ms_slider_title]" id="ms_slider_title" value="<?php echo isset( self::$options['ms_slider_title'] ) ? esc_html( self::$options['ms_slider_title'] ) : ''; ?>"> <?php
        }

        public function ms_slider_bullets_callback( $arg ) {
            ?>
                <input type="checkbox" name="ms_slider_options[ms_slider_bullets]" id="ms_slider_bullets" value="1" <?php if( isset( self::$options['ms_slider_bullets'] ) ) { checked( "1", self::$options['ms_slider_bullets'], true ); } ?>>
                <label for="ms_slider_bullets">Wheter to dispay bullets or not.</label>
            <?php
        }

        public function ms_slider_style_callback( $arg ) {
            ?>
                <select  id="ms_slider_style" name="ms_slider_options[ms_slider_style]">
                    <?php foreach( $arg['items'] as $item ) : ?>
                        <option value="<?php echo esc_attr( $item ); ?>" <?php isset( self::$options['ms_slider_style'] ) ? selected( $item, self::$options['ms_slider_style'], true ) : ''; ?>><?php echo esc_html( ucfirst( $item ) ); ?></option>
                    <?php endforeach; ?>
                </select>
            <?php
        }

        public function ms_slider_validate( $input ) {
            $new_input = array();
            foreach( $input as $key => $value ) {
                switch( $key ) {
                    case 'ms_slider_title':
                        if( empty( $value ) ) {
                            $value = 'Please, type some text.';
                        }
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                    default:
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                }
            }
            return $new_input;
        }
    }
}
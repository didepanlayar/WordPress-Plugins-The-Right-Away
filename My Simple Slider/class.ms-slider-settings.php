<?php

if( ! class_exists( 'MS_Slider_Settings' ) ) {
    class MS_Slider_Settings {
        public static $options;

        public function __construct() {
            self::$options = get_option( 'ms_slider_options' );
            add_action( 'admin_init', array( $this, 'admin_init' ) );
        }

        public function admin_init() {
            register_setting( 'ms_slider_group', 'ms_slider_options' );
            
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
                'ms_slider_second_section'
            );

            add_settings_field(
                'ms_slider_bullets',
                'Display Bullets',
                array( $this, 'ms_slider_bullets_callback' ),
                'ms_slider_page_2',
                'ms_slider_second_section'
            );

            add_settings_field(
                'ms_slider_style',
                'Slider Style',
                array( $this, 'ms_slider_style_callback' ),
                'ms_slider_page_2',
                'ms_slider_second_section'
            );
        }

        public function ms_slider_shortcode_callback() {
            ?> <span>Use the shortcode [ms_slider] to display the slider in any page, post or widget.</span> <?php
        }

        public function ms_slider_title_callback() {
            ?> <input type="text" name="ms_slider_options[ms_slider_title]" id="ms_slider_title" value="<?php echo isset( self::$options['ms_slider_title'] ) ? esc_html( self::$options['ms_slider_title'] ) : ''; ?>"> <?php
        }

        public function ms_slider_bullets_callback() {
            ?>
                <input type="checkbox" name="ms_slider_options[ms_slider_bullets]" id="ms_slider_bullets" value="1" <?php if( isset( self::$options['ms_slider_bullets'] ) ) { checked( "1", self::$options['ms_slider_bullets'], true ); } ?>>
                <label for="ms_slider_bullets">Wheter to dispay bullets or not.</label>
            <?php
        }

        public function ms_slider_style_callback() {
            ?>
                <select  id="ms_slider_style" name="ms_slider_options[ms_slider_style]">
                    <option value="style-1" <?php isset( self::$options['ms_slider_style'] ) ? selected( 'style-1', self::$options['ms_slider_style'], true ) : ''; ?>>Style-1</option>
                    <option value="style-2" <?php isset( self::$options['ms_slider_style'] ) ? selected( 'style-2', self::$options['ms_slider_style'], true ) : ''; ?>>Style-2</option>
                </select>
            <?php
        }
    }
}
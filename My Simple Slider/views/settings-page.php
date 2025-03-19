<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'main_options'; ?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=ms-slider-setting&tab=main_options" class="nav-tab <?php echo $active_tab == 'main_options' ? 'nav-tab-active' : ''; ?>">Main</a>
        <a href="?page=ms-slider-setting&tab=other_options" class="nav-tab <?php echo $active_tab == 'other_options' ? 'nav-tab-active' : ''; ?>">Other</a>
    </h2>
    <form action="options.php" method="POST">
        <?php
            if( $active_tab == 'main_options' ) {
                settings_fields( 'ms_slider_group' );
                do_settings_sections( 'ms_slider_page_1' );
            } else {
                settings_fields( 'ms_slider_group' );
                do_settings_sections( 'ms_slider_page_2' );
            }
            submit_button( 'Save Settings' );
        ?>
    </form>
</div>
<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form action="options.php" method="POST">
        <?php
            settings_fields( 'ms_slider_group' );
            do_settings_sections( 'ms_slider_page_1' );
            do_settings_sections( 'ms_slider_page_2' );
            submit_button( 'Save Settings' );
        ?>
    </form>
</div>
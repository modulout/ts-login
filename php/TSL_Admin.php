<?php
class TSL_Admin {
    public function __construct() {
        add_action("admin_menu", array($this, "tsl_admin_menu"));
    }

    function tsl_admin_menu() {
        add_menu_page('TS Login', 'TS Login', "manage_options", 'tipster_script_login', array($this, 'tsl_display'), 'dashicons-lock');
        add_submenu_page('tipster_script_login', esc_html__('Config', "tipster_script_login"), esc_html__('Config',"tipster_script_login"), "manage_options", 'tsl_config', array($this, 'tsl_display'));
    }

    function tsl_display() {
        include_once( dirname(__FILE__) . '/tsl_config.php' );
    }

    /* Save all values */
    public function tsl_save_config() {
        $data = $_POST;

        $allowed_html = [
            'i' => [
                'class' => [],
            ],
            'svg' => [
                'xmlns'   => [],
                'viewbox' => [],
                'width'   => [],
                'height'  => [],
                'fill'    => [],
            ],
            'path' => [
                'd' => [],
            ],
        ];

        $all_data = [
            "tsl_form_template"        => sanitize_text_field($_POST['tsl_form_template']),
            "tsl_form_image"           => esc_url_raw($_POST['tsl_form_image']),
            "tsl_register_show"        => sanitize_text_field($_POST['tsl_register_show']),
            "tsl_logout_option"        => sanitize_text_field($_POST['tsl_logout_option']),
            "tsl_logout_option"        => sanitize_text_field($_POST['tsl_logout_option']),
            "tsl_bbgc"                 => sanitize_hex_color($_POST['tsl_bbgc']),
            "tsl_btc"                  => sanitize_hex_color($_POST['tsl_btc']),
            "tsl_bbc"                  => sanitize_hex_color($_POST['tsl_bbc']),
            "tsl_bhbgc"                => sanitize_hex_color($_POST['tsl_bhbgc']),
            "tsl_bhtc"                 => sanitize_hex_color($_POST['tsl_bhtc']),
            "tsl_bhbc"                 => sanitize_hex_color($_POST['tsl_bhbc']),
            "tsl_ddbgc"                => sanitize_hex_color($_POST['tsl_ddbgc']),
            "tsl_ddtc"                 => sanitize_hex_color($_POST['tsl_ddtc']),
            "tsl_ddhtc"                => sanitize_hex_color($_POST['tsl_ddhtc']),
            "tsl_hbgc"                 => sanitize_hex_color($_POST['tsl_hbgc']),
            "tsl_htc"                  => sanitize_hex_color($_POST['tsl_htc']),
            "tsl_cbgc"                 => sanitize_hex_color($_POST['tsl_cbgc']),
            "tsl_ctc"                  => sanitize_hex_color($_POST['tsl_ctc']),
            "tsl_cibgc"                => sanitize_hex_color($_POST['tsl_cibgc']),
            "tsl_citc"                 => sanitize_hex_color($_POST['tsl_citc']),
            "tsl_cibc"                 => sanitize_hex_color($_POST['tsl_cibc']),
            "tsl_sbbgc"                => sanitize_hex_color($_POST['tsl_sbbgc']),
            "tsl_sbtc"                 => sanitize_hex_color($_POST['tsl_sbtc']),
            "tsl_sbbc"                 => sanitize_hex_color($_POST['tsl_sbbc']),
            "tsl_sbhbgc"               => sanitize_hex_color($_POST['tsl_sbhbgc']),
            "tsl_sbhtc"                => sanitize_hex_color($_POST['tsl_sbhtc']),
            "tsl_sbhbc"                => sanitize_hex_color($_POST['tsl_sbhbc']),
            "tsl_pbc"                  => sanitize_hex_color($_POST['tsl_pbc']),
            "tsl_login_icon"           => wp_kses($_POST['tsl_login_icon'], $allowed_html),
            "tsl_register_icon"        => wp_kses($_POST['tsl_register_icon'], $allowed_html),
            "tsl_logout_icon"          => wp_kses($_POST['tsl_logout_icon'], $allowed_html),
            "tsl_lost_pass_icon"       => wp_kses($_POST['tsl_lost_pass_icon'], $allowed_html),
            "tsl_reset_pass_icon"      => wp_kses($_POST['tsl_reset_pass_icon'], $allowed_html),
            "tsl_success_icon"         => wp_kses($_POST['tsl_success_icon'], $allowed_html),
            "tsl_error_icon"           => wp_kses($_POST['tsl_error_icon'], $allowed_html),
            "tsl_recaptcha_enable"     => sanitize_text_field($_POST['tsl_recaptcha_enable']),
            "tsl_recaptcha_site_key"   => sanitize_text_field($_POST['tsl_recaptcha_site_key']),
            "tsl_recaptcha_secret_key" => sanitize_text_field($_POST['tsl_recaptcha_secret_key']),
            "tsl_recaptcha_badge"      => sanitize_text_field($_POST['tsl_recaptcha_badge']),
        ];
        foreach($all_data as $value => $item) {
            update_option($value, $item);
        }

        //Save all colors - only 1 request on frontend to get all colors
        $colors_data = [
            "tsl_bbgc"             => sanitize_hex_color($_POST['tsl_bbgc']),
            "tsl_btc"              => sanitize_hex_color($_POST['tsl_btc']),
            "tsl_bbc"              => sanitize_hex_color($_POST['tsl_bbc']),
            "tsl_bhbgc"            => sanitize_hex_color($_POST['tsl_bhbgc']),
            "tsl_bhtc"             => sanitize_hex_color($_POST['tsl_bhtc']),
            "tsl_bhbc"             => sanitize_hex_color($_POST['tsl_bhbc']),
            "tsl_ddbgc"            => sanitize_hex_color($_POST['tsl_ddbgc']),
            "tsl_ddtc"             => sanitize_hex_color($_POST['tsl_ddtc']),
            "tsl_ddhtc"            => sanitize_hex_color($_POST['tsl_ddhtc']),
            "tsl_hbgc"             => sanitize_hex_color($_POST['tsl_hbgc']),
            "tsl_htc"              => sanitize_hex_color($_POST['tsl_htc']),
            "tsl_cbgc"             => sanitize_hex_color($_POST['tsl_cbgc']),
            "tsl_ctc"              => sanitize_hex_color($_POST['tsl_ctc']),
            "tsl_cibgc"            => sanitize_hex_color($_POST['tsl_cibgc']),
            "tsl_citc"             => sanitize_hex_color($_POST['tsl_citc']),
            "tsl_cibc"             => sanitize_hex_color($_POST['tsl_cibc']),
            "tsl_sbbgc"            => sanitize_hex_color($_POST['tsl_sbbgc']),
            "tsl_sbtc"             => sanitize_hex_color($_POST['tsl_sbtc']),
            "tsl_sbbc"             => sanitize_hex_color($_POST['tsl_sbbc']),
            "tsl_sbhbgc"           => sanitize_hex_color($_POST['tsl_sbhbgc']),
            "tsl_sbhtc"            => sanitize_hex_color($_POST['tsl_sbhtc']),
            "tsl_sbhbc"            => sanitize_hex_color($_POST['tsl_sbhbc']),
            "tsl_pbc"              => sanitize_hex_color($_POST['tsl_pbc']),
            "tsl_recaptcha_enable" => sanitize_text_field($_POST['tsl_recaptcha_enable']),
            "tsl_recaptcha_badge"  => sanitize_text_field($_POST['tsl_recaptcha_badge']),
        ];
        update_option('tsl_custom_colors', $colors_data);

        echo "<script>window.location = 'admin.php?page=tsl_config';</script>";
    }
}
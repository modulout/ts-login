<?php
/*
Plugin Name: TS login
Plugin URI: https://github.com/modulout/ts_login
Description: With the TS login plugin, your users can log in or/and register from the front page (not needed to go to wp-admin anymore).
Author: Modulout
Version: 1.0.5
Author URI: https://www.modulout.com
*/
if(!defined('WPINC')) {
    die;
}
/* Language text domain */
add_action( 'plugins_loaded', 'tsl_load_textdomain' );
function tsl_load_textdomain() {
    load_plugin_textdomain( 'tipster_script_login', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

define("TSL_URL", plugin_dir_url(__FILE__));
define("TSL_PATH", plugin_dir_path(__FILE__));

/* Add css/js to admin area */
function tsl_admin_style_js() {
    wp_register_style("tsl_config", TSL_URL.'assets/css/main_admin.css');
    wp_register_script("tsl_config", TSL_URL.'assets/js/tsl_config.js', array('wp-color-picker'), false, true);
}
add_action('admin_enqueue_scripts', 'tsl_admin_style_js');

function tsl_include_style_script() {
    if (is_plugin_active('polylang/polylang.php')) {
        // Polylang is active, return language-specific home URL
        $current_url = pll_home_url();
    } else {
        // Polylang is not active, return the default home URL
        $current_url = home_url('/');
    }

    $register_redirect_url = add_query_arg([
        'popup' => 'tsl-login',
        'message' => 'registration-success',
    ], $current_url);

    //Google recaptcha
    $site_key = get_option("tsl_recaptcha_site_key", "");
    $recaptcha_status = get_option("tsl_recaptcha_enable", "0");

    if($recaptcha_status == "1") {
        wp_enqueue_script("recaptcha", 'https://www.google.com/recaptcha/api.js?render='.$site_key);
    }
    wp_enqueue_style('tsl-main', TSL_URL.'assets/css/main.css');
    wp_enqueue_script("tsl-main", TSL_URL.'assets/js/main.js', array('jquery'), '1.1.0', true);
    wp_localize_script('tsl-main', 'tsl_main', [
        'ajaxurl'           => admin_url('admin-ajax.php'),
        'popup_nonce'       => wp_create_nonce('tsl-popup-nonce'),
        'register_redirect' => $register_redirect_url,
        'site_key'          => $site_key,
        'recaptcha_status'  => $recaptcha_status,
        'fields_empty'      => esc_html__("The username or password field is empty!", "tipster_script_login"),
        'fields_wrong'      => esc_html__("Incorrect username or password please try again!", "tipster_script_login"),
        'rfields_empty'     => esc_html__("The username or e-mail or password field is empty!", "tipster_script_login"),
        'username_exists'   => esc_html__("The username already exists!", "tipster_script_login"),
        'email_exists'      => esc_html__("The email already exists!", "tipster_script_login"),
        'register_fail'     => esc_html__("Registration failed! Please try again.", "tipster_script_login"),
        'register_success'  => esc_html__("Registration was successful. You can log in.", "tipster_script_login"),
        'recaptcha_error'   => esc_html__("Something went wrong. Please try again later.", "tipster_script_login"),
        'email_error'       => esc_html__("Invalid email format. Please enter a valid email address.", "tipster_script_login"),
        'email_empty'       => esc_html__("Please provide an email address or username.", "tipster_script_login"),
        'unexpected_error'  => esc_html__("An unexpected error occurred. Please try again.", "tipster_script_login"),
        'short_pass'        => esc_html__("Password must be at least 12 characters long.", "tipster_script_login"),
        'invalid_reset'     => esc_html__("Invalid reset link. Please try again.", "tipster_script_login"),
        'success_icon'      => (get_option("tsl_success_icon", "") != "") ? get_option("tsl_success_icon", "")."&nbsp;" : "",
        'error_icon'        => (get_option("tsl_error_icon", "") != "") ? get_option("tsl_error_icon", "")."&nbsp;" : "",
    ]);
    
    // Always add custom colors as CSS variables
    wp_add_inline_style('tsl-main', tsl_helper_custom_style());
}
add_action('wp_enqueue_scripts', 'tsl_include_style_script');

/* Include files */
include_once TSL_PATH."php/TSL_Admin.php";
$tsl_admin = new TSL_Admin();
include_once TSL_PATH."php/Tsl_login_register.php";
include_once TSL_PATH."php/tsl_ajax.php";
/* END Include files */

/* Custom colors */
function tsl_helper_custom_color($colors, $color_name, $default_color) {
    $tsl_color = $default_color;
    if(isset($colors[$color_name]) && $colors[$color_name] != "") {
        $tsl_color = $colors[$color_name];
    }
    return $tsl_color;
}

function tsl_helper_custom_style() {
    $custom_colors = get_option("tsl_custom_colors");
    $data = "";
    $data .= "
    :root {
        --tsl-header-bg: ".tsl_helper_custom_color($custom_colors, 'tsl_hbgc', '#1a1a2e').";
        --tsl-header-text: ".tsl_helper_custom_color($custom_colors, 'tsl_htc', '#ffffff').";
        --tsl-body-bg: ".tsl_helper_custom_color($custom_colors, 'tsl_cbgc', '#f8f9fa').";
        --tsl-body-text: ".tsl_helper_custom_color($custom_colors, 'tsl_ctc', '#374151').";
        --tsl-input-bg: ".tsl_helper_custom_color($custom_colors, 'tsl_cibgc', '#ffffff').";
        --tsl-input-text: ".tsl_helper_custom_color($custom_colors, 'tsl_citc', '#1f2937').";
        --tsl-input-border: ".tsl_helper_custom_color($custom_colors, 'tsl_cibc', '#e5e7eb').";
        --tsl-popup-border: ".tsl_helper_custom_color($custom_colors, 'tsl_pbc', '#374151').";
        --tsl-btn-bg: ".tsl_helper_custom_color($custom_colors, 'tsl_sbbgc', '#6366f1').";
        --tsl-btn-text: ".tsl_helper_custom_color($custom_colors, 'tsl_sbtc', '#fff').";
        --tsl-btn-border: ".tsl_helper_custom_color($custom_colors, 'tsl_sbbc', '#6366f1').";
        --tsl-btn-hover-bg: ".tsl_helper_custom_color($custom_colors, 'tsl_sbhbgc', '#4f46e5').";
        --tsl-btn-hover-text: ".tsl_helper_custom_color($custom_colors, 'tsl_sbhtc', '#fff').";
        --tsl-btn-hover-border: ".tsl_helper_custom_color($custom_colors, 'tsl_sbhbc', '#4f46e5').";
        --tsl-dropdown-bg: ".tsl_helper_custom_color($custom_colors, 'tsl_ddbgc', '#ffffff').";
        --tsl-dropdown-text: ".tsl_helper_custom_color($custom_colors, 'tsl_ddtc', '#1f2937').";
        --tsl-dropdown-hover-text: ".tsl_helper_custom_color($custom_colors, 'tsl_ddhtc', '#111827').";
        --tsl-logout-btn-bg: ".tsl_helper_custom_color($custom_colors, 'tsl_bbgc', '#6b7280').";
        --tsl-logout-btn-text: ".tsl_helper_custom_color($custom_colors, 'tsl_btc', '#fff').";
        --tsl-logout-btn-border: ".tsl_helper_custom_color($custom_colors, 'tsl_bbc', '#6b7280').";
        --tsl-logout-btn-hover-bg: ".tsl_helper_custom_color($custom_colors, 'tsl_bhbgc', '#4b5563').";
        --tsl-logout-btn-hover-text: ".tsl_helper_custom_color($custom_colors, 'tsl_bhtc', '#fff').";
        --tsl-logout-btn-hover-border: ".tsl_helper_custom_color($custom_colors, 'tsl_bhbc', '#4b5563').";
    }
    ";
    if(isset($custom_colors["tsl_recaptcha_badge"]) && $custom_colors["tsl_recaptcha_badge"] == "2" && isset($custom_colors['tsl_recaptcha_enable']) && $custom_colors['tsl_recaptcha_enable'] == "1") {
        $data .= "
        /* Recaptcha hide */
        .grecaptcha-badge {
            visibility: hidden;
         }
        ";
    }
    return $data;
}
/* END Custom colors */

/* Template rendering functions (used by AJAX handler) */
function tsl_get_login_template_vars() {
    return [
        'recaptcha_status' => get_option("tsl_recaptcha_enable", "0"),
        'recaptcha_badge'  => get_option("tsl_recaptcha_badge", "1"),
        'register_show'    => get_option("tsl_register_show", 1),
        'args'             => [
            "echo"      => false,
            "id_submit" => "tsl_login_submit"
        ]
    ];
}

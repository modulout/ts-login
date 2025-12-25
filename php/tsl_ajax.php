<?php
/* Load all popup templates via AJAX (single request) */
add_action('wp_ajax_tsl_load_popup', 'tsl_load_popup');
add_action('wp_ajax_nopriv_tsl_load_popup', 'tsl_load_popup');
function tsl_load_popup() {
    check_ajax_referer('tsl-popup-nonce', 'nonce');

    // Get template settings
    $recaptcha_status = get_option("tsl_recaptcha_enable", "0");
    $recaptcha_badge = get_option("tsl_recaptcha_badge", "1");
    $register_show = get_option("tsl_register_show", 1);
    $template_id = get_option("tsl_form_template", "1");

    // Login form specific args
    $args = [
        "echo" => false,
        "id_submit" => "tsl_login_submit"
    ];

    $forms = [];

    // Load login template
    ob_start();
    include TSL_PATH . "php/templates/login" . $template_id . ".php";
    $forms['login'] = ob_get_clean();

    // Load register template
    ob_start();
    include TSL_PATH . "php/templates/register" . $template_id . ".php";
    $forms['register'] = ob_get_clean();

    // Load lost password template
    ob_start();
    include TSL_PATH . "php/templates/lost_password" . $template_id . ".php";
    $forms['lost_password'] = ob_get_clean();

    // Load reset password template (only needed for URL param access)
    ob_start();
    include TSL_PATH . "php/templates/reset_password" . $template_id . ".php";
    $forms['reset_password'] = ob_get_clean();

    wp_send_json_success(['forms' => $forms]);
}

/* User login */
add_action('wp_ajax_nopriv_tsl_login_form', 'tsl_login_form');
function tsl_login_form() {
    check_ajax_referer('ajax-login-nonce', 'security');

    $recaptcha_status = sanitize_text_field($_POST['recaptcha_status']);

    $info = array();
    $info['user_login'] = sanitize_user($_POST['username']);
    $info['user_password'] = $_POST['pass'];


    //Recaptcha
    if($recaptcha_status == "1") {
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = get_option("tsl_recaptcha_secret_key", "");
        $recaptcha_response = sanitize_text_field($_POST['recaptcha_response']);

        $recaptcha_data = json_decode(file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response));

        if($recaptcha_data->success == true) {
            tsl_login_user_helper($info);
        } else {
            echo wp_json_encode("4");
            die();
        }
    } else {
        tsl_login_user_helper($info);
    } 
}

function tsl_login_user_helper($info) {
    $user = wp_signon($info, false);
    if (is_wp_error($user)) {
        echo wp_json_encode("0");
    } else {
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID, isset($_POST['remember']));
        echo json_encode(['success' => true, 'redirect_url' => admin_url()]);
    }
    exit;
}
/* END User login */
/* User register*/
add_action('wp_ajax_nopriv_tsl_register_form', 'tsl_register_form');
function tsl_register_form() {
    check_ajax_referer('ajax-register-nonce', 'rsecurity');

    $recaptcha_status = sanitize_text_field($_POST['recaptcha_status']);
    $username = sanitize_user($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $pass = $_POST['pass'];

    // check if email is valid
    if(!is_email($email)) {
        echo wp_json_encode("5");
        die();
    }

    //Recaptcha
    if($recaptcha_status == "1") {
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = get_option("tsl_recaptcha_secret_key", "");
        $recaptcha_response = sanitize_text_field($_POST['recaptcha_response']);

        $recaptcha_data = json_decode(file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response));

        if($recaptcha_data->success == true) {
            tsl_register_user_helper($username, $email, $pass);
        } else {
            echo wp_json_encode("4");
            die();
        }
    } else {
        tsl_register_user_helper($username, $email, $pass);
    } 
}

function tsl_register_user_helper($username, $email, $pass) {
    //Check if username exists
    if(username_exists($username)) {
        echo wp_json_encode("0");
        die();
    } elseif(email_exists($email)) {
        echo wp_json_encode("3");
        die();
    } else {
        //Create a new user
        $new_user_id = wp_create_user($username, $pass, $email);

        if(!empty($new_user_id->errors)) {
            echo wp_json_encode("2");
            die();
        } elseif(isset($new_user_id) && $new_user_id > 0) {
            $site_name = get_bloginfo("name");
            $site_email = get_bloginfo("admin_email");

            //Send email to admin - new user registration
            $admin_title = "[".$site_name."]".esc_html__("New User Registration", "tipster_script_login");
            $admin_body = esc_html__("New user registration on your site", "tipster_script_login")." ".$site_name.":<br><br>";
            $admin_body .= esc_html__("Username", "tipster_script_login").": ".$username."<br><br>";
            $admin_body .= esc_html__("Email", "tipster_script_login").": ".$email;
            wp_mail($site_email, $admin_title, $admin_body);

            //Send email to user - registration successful
            $user_title = "[".$site_name."]".esc_html__("Registration Was Successful", "tipster_script_login");
            $user_body = esc_html__("You registered on site", "tipster_script_login")." ".$site_name.":<br><br>";
            $user_body .= esc_html__("Username", "tipster_script_login").": ".$username."<br><br>";
            $user_body .= esc_html__("Email", "tipster_script_login").": ".$email;
            wp_mail($email, $user_title, $user_body);

            echo wp_json_encode("1");
            die();
        } else {
            echo wp_json_encode("2");
            die();
        }
    }
}
/* END User register */
/* Lost password */
add_action('wp_ajax_nopriv_tsl_lost_pass_form', 'tsl_lost_pass_form');
function tsl_lost_pass_form() {
    check_ajax_referer('ajax-lost_pass-nonce', 'lsecurity');

    $recaptcha_status = sanitize_text_field($_POST['recaptcha_status']);
    $user_email = sanitize_text_field($_POST['user_email']);

    // Handle Recaptcha
    if ($recaptcha_status == "1") {
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = get_option("tsl_recaptcha_secret_key", "");
        $recaptcha_response = sanitize_text_field($_POST['recaptcha_response']);

        $recaptcha_data = json_decode(file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response));

        if ($recaptcha_data->success != true) {
            wp_send_json_error(['message' => esc_html__('Invalid reCAPTCHA verification.', 'tipster_script_login')]);
        }
    }

    tsl_lost_pass_helper($user_email);
}

function tsl_lost_pass_helper($user_email) {
    // Check if input is provided
    if (empty($user_email)) {
        wp_send_json_error(['message' => esc_html__('Please provide an email address or username.', 'tipster_script_login')]);
    }

    $user = null;
    // Determine if input is an email or username
    if (is_email($user_email)) {
        $user = get_user_by('email', $user_email);
    } else {
        $user = get_user_by('login', $user_email);
    }

    if (!$user) {
        wp_send_json_error(['message' => esc_html__('No user found with this email address or username.', 'tipster_script_login')]);
    }

    // Generate password reset key
    $reset_key = get_password_reset_key($user);
    if (is_wp_error($reset_key)) {
        wp_send_json_error(['message' => esc_html__('An error occurred. Please try again later.', 'tipster_script_login')]);
    }

    // Generate custom reset URL
    $reset_url = add_query_arg([
        'action' => 'rp',
        'key' => $reset_key,
        'login' => rawurlencode($user->user_login),
        'popup' => 'tsl-reset-password',
    ], home_url());

    // Send reset email
    $subject = __('Password Reset Request', 'tipster_script_login');

    $message = sprintf(
        __("Hi %s,", 'tipster_script_login'),
        $user->display_name
    ) . "\r\n\r\n";
    $message .= __("Someone has requested a password reset for your account. If this was you, click the link below to reset your password:", 'tipster_script_login') . "\r\n";
    $message .= $reset_url . "\r\n\r\n";
    $message .= __("If you did not request a password reset, you can safely ignore this email.", 'tipster_script_login');

    if (wp_mail($user->user_email, $subject, $message)) {
        wp_send_json_success(['message' => esc_html__('Password reset instructions have been sent to the associated email address.', 'tipster_script_login')]);
    } else {
        wp_send_json_error(['message' => esc_html__('Failed to send email. Please try again later.', 'tipster_script_login')]);
    }
}
/* END Lost password */
/* Reset password */
add_action('wp_ajax_nopriv_tsl_save_new_password', 'tsl_save_new_password_func');
function tsl_save_new_password_func() {
    check_ajax_referer('ajax-reset_pass-nonce', 'psecurity');

    $password = sanitize_text_field($_POST['password']);
    $key = sanitize_text_field($_POST['key']);
    $login = sanitize_text_field($_POST['login']);

    if (empty($password) || empty($key) || empty($login)) {
        wp_send_json_error(['message' => esc_html__('Invalid request. Please try again.', 'tipster_script_login')]);
    }

    if (strlen($password) < 12) {
        wp_send_json_error(['message' => esc_html__('Password must be at least 12 characters long.', 'tipster_script_login')]);
    }

    // Retrieve the user by their login name
    $user = get_user_by('login', $login);
    if (!$user) {
        wp_send_json_error(['message' => esc_html__('Invalid reset link.', 'tipster_script_login')]);
    }

    // Validate the reset key
    $check_key = check_password_reset_key($key, $login);
    if (is_wp_error($check_key)) {
        wp_send_json_error(['message' => esc_html__('The reset link has expired or is invalid.', 'tipster_script_login')]);
    }

    // Reset the password
    reset_password($user, $password);
    wp_send_json_success(['message' => esc_html__('Your password has been successfully updated.', 'tipster_script_login'), 'redirect_url' => home_url()]);
}
/* END Reset password */
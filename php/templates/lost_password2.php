<?php $header_img = get_option("tsl_form_image", ""); ?>
<div class="tsl_login_css tsl_lost_pass_modal tsl-popup-container">
    <?php if($header_img != "") : ?>
        <img src="<?php echo esc_url($header_img); ?>" title="<?php esc_attr_e("Lost password form", "tipster_script_login"); ?>" alt="<?php esc_attr_e("Lost password form", "tipster_script_login"); ?>" />
    <?php endif; ?>
    <div class="tsl-popup-header">
        <h4 class="tsl-popup-title">
            <?php echo (get_option("tsl_lost_pass_icon", "") != "") ? get_option("tsl_lost_pass_icon", "")."&nbsp;" : ""; ?>
            <?php esc_html_e("Forgot password?", "tipster_script_login"); ?>       
        </h4>
        <?php if($recaptcha_status == "1") : ?>
            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
        <?php endif; ?>
        <button type="button" class="tsl-popup-close" aria-label="<?php esc_attr_e("Close", "tipster_script_login"); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <div class="tsl-popup-body">
        <div id="custom-lost-password">
            <p><?php esc_html_e("Please enter your username or email address. You will receive an email message with instructions on how to reset your password.", "tipster_script_login"); ?></p>
            <label for="lost-password-email"><?php esc_html_e("Username or Email Address", "tipster_script_login"); ?></label>
            <input type="text" id="lost-password-email" class="input" required>
            <button type="button" id="lost-password-submit" class="button button-primary"><?php esc_html_e("Get New Password", "tipster_script_login"); ?></button>
        </div>
        <div class="tsl_lost_pass_footer">
            <button type="button" class="tsl_login js--tsl-login-popup">
                <?php esc_html_e("Log in", "tipster_script_login"); ?>
            </button>
        </div>
        <?php if($recaptcha_badge == "2" && $recaptcha_status == "1") : ?>
            <p class="tsl_recaptcha_message">
                <?php esc_html_e("This site is protected by reCAPTCHA and the Google", "tipster_script_login"); ?> <a href="https://policies.google.com/privacy"><?php esc_html_e("Privacy Policy", "tipster_script_login"); ?></a> <?php esc_html_e("and", "tipster_script_login"); ?> <a href="https://policies.google.com/terms"><?php esc_html_e("Terms of Service", "tipster_script_login"); ?></a> <?php esc_html_e("apply.", "tipster_script_login"); ?>
            </p>
        <?php endif; ?>
        <?php echo wp_nonce_field('ajax-lost_pass-nonce', 'lsecurity', true, false); ?>
        <p class="tsl_form_error"></p>
        <p class="tsl_lost_pass_success"></p>
    </div>
</div>
<div class="tsl_login_css tsl_login_modal tsl-popup-container">
    <div class="tsl-popup-header">
        <h4 class="tsl-popup-title">
            <?php echo (get_option("tsl_login_icon", "") != "") ? get_option("tsl_login_icon", "")."&nbsp;" : ""; ?>
            <?php esc_html_e("Sign in", "tipster_script_login"); ?>        
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
        <?php echo wp_login_form($args); ?>
        <div class="tsl_login_footer">
            <button type="button" class="tsl_forgot_password js--tsl-pass-popup">
                <?php esc_html_e("Forgot password?", "tipster_script_login"); ?>
            </button>
            <?php if($register_show == 1) : ?>
                <button type="button" class="tsl_register js--tsl-register-popup">
                    <?php esc_html_e("Register", "tipster_script_login"); ?>
                </button>
            <?php endif; ?>
        </div>
        <?php if($recaptcha_badge == "2" && $recaptcha_status == "1") : ?>
            <p class="tsl_recaptcha_message">
                <?php esc_html_e("This site is protected by reCAPTCHA and the Google", "tipster_script_login"); ?> <a href="https://policies.google.com/privacy"><?php esc_html_e("Privacy Policy", "tipster_script_login"); ?></a> <?php esc_html_e("and", "tipster_script_login"); ?> <a href="https://policies.google.com/terms"><?php esc_html_e("Terms of Service", "tipster_script_login"); ?></a> <?php esc_html_e("apply.", "tipster_script_login"); ?>
            </p>
        <?php endif; ?>
        <?php echo wp_nonce_field('ajax-login-nonce', 'security', true, false); ?>
        <p class="tsl_form_error"></p>
        <p class="tsl_register_success"></p>
    </div>
</div>
<?php $header_img = get_option("tsl_form_image", ""); ?>
<div class="tsl_login_css tsl_register_modal tsl-popup-container">
    <?php if($header_img != "") : ?>
        <img src="<?php echo esc_url($header_img); ?>" title="<?php esc_attr_e("Register form", "tipster_script_login"); ?>" alt="<?php esc_attr_e("Register form", "tipster_script_login"); ?>" />
    <?php endif; ?>
    <div class="tsl-popup-header">
        <h4 class="tsl-popup-title">
            <?php echo (get_option("tsl_register_icon", "") != "") ? get_option("tsl_register_icon", "")."&nbsp;" : ""; ?>
            <?php esc_html_e("Sign up", "tipster_script_login"); ?>           
        </h4>
        <button type="button" class="tsl-popup-close" aria-label="<?php esc_attr_e("Close", "tipster_script_login"); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <div class="tsl-popup-body">
        <p class="tsl_register">
            <label for="tsl_username"><?php esc_html_e("Username", "tipster_script_login"); ?>*</label>
            <input type="text" id="tsl_username" class="input">
        </p>
        <p class="tsl_register">
            <label for="tsl_email"><?php esc_html_e("Email", "tipster_script_login"); ?>*</label>
            <input type="text" id="tsl_email" class="input">
        </p>
        <p class="tsl_register">
            <label for="tsl_password"><?php esc_html_e("Password", "tipster_script_login"); ?>*</label>
            <input type="password" id="tsl_password" class="input">
        </p>
        <p class="tsl-register-submit">
            <input type="submit" id="tsl_register_submit" class="button button-primary" value="<?php esc_attr_e("Register", "tipster_script_login"); ?>">
        </p>
        <?php if($recaptcha_badge == "2" && $recaptcha_status == "1") : ?>
            <p class="tsl_recaptcha_message">
                <?php esc_html_e("This site is protected by reCAPTCHA and the Google", "tipster_script_login"); ?> <a href="https://policies.google.com/privacy"><?php esc_html_e("Privacy Policy", "tipster_script_login"); ?></a> <?php esc_html_e("and", "tipster_script_login"); ?> <a href="https://policies.google.com/terms"><?php esc_html_e("Terms of Service", "tipster_script_login"); ?></a> <?php esc_html_e("apply.", "tipster_script_login"); ?>
            </p>
        <?php endif; ?>
        <?php if($recaptcha_status == "1") : ?>
            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
        <?php endif; ?>
        <?php echo wp_nonce_field('ajax-register-nonce', 'rsecurity', true, false); ?>
        <p class="tsl_form_error"></p>
    </div>
</div>
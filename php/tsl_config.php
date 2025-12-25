<?php
global $tsl_admin;
wp_enqueue_style('tsl_config');
wp_enqueue_style('wp-color-picker');
wp_enqueue_script("tsl_config"); 

$form_templates_arr = [
    1 => esc_html__("Basic", "tipster_script_login"),
    2 => esc_html__("Image on top", "tipster_script_login"),
    3 => esc_html__("Image on left side", "tipster_script_login"),
];

if(isset($_GET['save_config'])) {
    $tsl_admin->tsl_save_config();
}
?>
<div id="wbody">
    <div id="wpbody-content" aria-label="Main content" tabindex="0">
        <div class="wrap">
            <h2><?php esc_html_e('Config', 'tipster_script_login'); ?></h2>
            <form action="admin.php?page=tsl_config&save_config" method="post">
                <table class="form-table">
                    <tbody>
                        <!-- Login/Register style -->
                        <tr>
                            <th>
                                <?php esc_html_e("Login/Register style", "tipster_script_login"); ?>
                            </th>
                            <td>
                                <select name="tsl_form_template" id="tsl_form_template">
                                    <?php foreach($form_templates_arr as $key => $item) : ?>
                                        <?php 
                                            $selected = "";
                                            if(get_option("tsl_form_template", "1") == $key) {
                                                $selected = " selected";
                                            }
                                        ?>
                                        <option value="<?php echo esc_attr($key); ?>"<?php echo esc_attr($selected); ?>><?php echo esc_html($item); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class=tsl_form_img>
                                    <label for=""><?php esc_html_e("Image", "tipster_script_login"); ?></label><br>
                                    <input id="tsl_form_image" type="text" name="tsl_form_image" value="<?php echo esc_attr(get_option("tsl_form_image", "")); ?>" />
                                    <input id="_btn" class="upload_image_button button button-primary" type="button" value="Upload" />
                                </div>
                            </td>
                        </tr>
                        <!-- Register option -->
                        <tr>
                            <th>
                                <?php esc_html_e("Register option", "tipster_script_login"); ?>
                            </th>
                            <td>
                                <select name="tsl_register_show" id="tsl_register_show">
                                    <option value="1"<?php echo (get_option("tsl_register_show", 1) == 1) ? ' selected' : ''; ?>><?php esc_html_e("Show", "tipster_script_login"); ?></option>
                                    <option value="0"<?php echo (get_option("tsl_register_show", 1) == 0) ? ' selected' : ''; ?>><?php esc_html_e("Hide", "tipster_script_login"); ?></option>
                                </select>
                            </td>
                        </tr>
                        <!-- Logout option -->
                        <tr>
                            <th>
                                <?php esc_html_e("Log out option", "tipster_script_login"); ?>
                            </th>
                            <td>
                                <select name="tsl_logout_option" id="tsl_logout_option">
                                    <option value="1"<?php echo (get_option("tsl_logout_option") == 1) ? ' selected' : ''; ?>><?php esc_html_e("Button", "tipster_script_login"); ?></option>
                                    <option value="2"<?php echo (get_option("tsl_logout_option") == 2) ? ' selected' : ''; ?>><?php esc_html_e("Dropdown", "tipster_script_login"); ?></option>
                                </select>
                                <div class='item tsl_logout_1'>
                                    <div class="tsl_custom_colorpicker">
                                        <label for="tsl_bbgc"><?php esc_html_e("Button background color", "tipster_script_login"); ?></label><br>
                                        <input type="text" class="tsl_colorpicker" name="tsl_bbgc" id="tsl_bbgc" value="<?php echo esc_attr(get_option("tsl_bbgc", "#565e64")); ?>" data-default-color="#565e64" />
                                    </div>
                                    <div class="tsl_custom_colorpicker">
                                        <label for="tsl_btc"><?php esc_html_e("Button text color", "tipster_script_login"); ?></label><br>
                                        <input type="text" class="tsl_colorpicker" name="tsl_btc" id="tsl_btc" value="<?php echo esc_attr(get_option("tsl_btc", "#fff")); ?>" data-default-color="#fff" />
                                    </div>
                                    <div class="tsl_custom_colorpicker">
                                        <label for="tsl_bbc"><?php esc_html_e("Button border color", "tipster_script_login"); ?></label><br>
                                        <input type="text" class="tsl_colorpicker" name="tsl_bbc" id="tsl_bbc" value="<?php echo esc_attr(get_option("tsl_bbc", "#51585e")); ?>" data-default-color="#51585e" />
                                    </div>
                                    <div class="tsl_custom_colorpicker">
                                        <label for="tsl_bhbgc"><?php esc_html_e("Button hover background color", "tipster_script_login"); ?></label><br>
                                        <input type="text" class="tsl_colorpicker" name="tsl_bhbgc" id="tsl_bhbgc" value="<?php echo esc_attr(get_option("tsl_bhbgc", "#5c636a")); ?>" data-default-color="#5c636a" />
                                    </div>
                                    <div class="tsl_custom_colorpicker">
                                        <label for="tsl_bhtc"><?php esc_html_e("Button hover text color", "tipster_script_login"); ?></label><br>
                                        <input type="text" class="tsl_colorpicker" name="tsl_bhtc" id="tsl_bhtc" value="<?php echo esc_attr(get_option("tsl_bhtc", "#fff")); ?>" data-default-color="#fff" />
                                    </div>
                                    <div class="tsl_custom_colorpicker">
                                        <label for="tsl_bhbc"><?php esc_html_e("Button hover border color", "tipster_script_login"); ?></label><br>
                                        <input type="text" class="tsl_colorpicker" name="tsl_bhbc" id="tsl_bhbc" value="<?php echo esc_attr(get_option("tsl_bhbc", "#565e64")); ?>" data-default-color="#565e64" />
                                    </div>
                                </div>
                                <div class='item tsl_logout_2'>
                                    <div class="tsl_custom_colorpicker">
                                        <label for="tsl_ddbgc"><?php esc_html_e("Dropdown background color", "tipster_script_login"); ?></label><br>
                                        <input type="text" class="tsl_colorpicker" name="tsl_ddbgc" id="tsl_ddbgc" value="<?php echo esc_attr(get_option("tsl_ddbgc", "#fff")); ?>" data-default-color="#fff" />
                                    </div>
                                    <div class="tsl_custom_colorpicker">
                                        <label for="tsl_ddtc"><?php esc_html_e("Dropdown text color", "tipster_script_login"); ?></label><br>
                                        <input type="text" class="tsl_colorpicker" name="tsl_ddtc" id="tsl_ddtc" value="<?php echo esc_attr(get_option("tsl_ddtc", "#000")); ?>" data-default-color="#000" />
                                    </div>
                                    <div class="tsl_custom_colorpicker">
                                        <label for="tsl_ddhtc"><?php esc_html_e("Dropdown hover text color", "tipster_script_login"); ?></label><br>
                                        <input type="text" class="tsl_colorpicker" name="tsl_ddhtc" id="tsl_ddhtc" value="<?php echo esc_attr(get_option("tsl_ddhtc", "#333")); ?>" data-default-color="#333" />
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="tsl_custom_colors">
                            <th colspan="2">
                                <div class="ts-admin-grid">
                                    <div class='item'>
                                        <div class="tsl_custom_colorpicker">
                                            <label for="tsl_hbgc"><?php esc_html_e("Header background color", "tipster_script_login"); ?></label><br>
                                            <input type="text" class="tsl_colorpicker" name="tsl_hbgc" id="tsl_hbgc" value="<?php echo esc_attr(get_option("tsl_hbgc", "#1a1a2e")); ?>" data-default-color="#1a1a2e" />
                                        </div>
                                        <div class="tsl_custom_colorpicker">
                                            <label for="tsl_htc"><?php esc_html_e("Header text color", "tipster_script_login"); ?></label><br>
                                            <input type="text" class="tsl_colorpicker" name="tsl_htc" id="tsl_htc" value="<?php echo esc_attr(get_option("tsl_htc", "#ffffff")); ?>" data-default-color="#ffffff" />
                                        </div>
                                        <div class="tsl_custom_colorpicker">
                                            <label for="tsl_cbgc"><?php esc_html_e("Content background color", "tipster_script_login"); ?></label><br>
                                            <input type="text" class="tsl_colorpicker" name="tsl_cbgc" id="tsl_cbgc" value="<?php echo esc_attr(get_option("tsl_cbgc", "#f8f9fa")); ?>" data-default-color="#f8f9fa" />
                                        </div>
                                        <div class="tsl_custom_colorpicker">
                                            <label for="tsl_ctc"><?php esc_html_e("Content text (label) color", "tipster_script_login"); ?></label><br>
                                            <input type="text" class="tsl_colorpicker" name="tsl_ctc" id="tsl_ctc" value="<?php echo esc_attr(get_option("tsl_ctc", "#374151")); ?>" data-default-color="#374151" />
                                        </div>
                                        <div class="tsl_custom_colorpicker">
                                            <label for="tsl_cibgc"><?php esc_html_e("Content input background color", "tipster_script_login"); ?></label><br>
                                            <input type="text" class="tsl_colorpicker" name="tsl_cibgc" id="tsl_cibgc" value="<?php echo esc_attr(get_option("tsl_cibgc", "#ffffff")); ?>" data-default-color="#ffffff" />
                                        </div>
                                        <div class="tsl_custom_colorpicker">
                                            <label for="tsl_citc"><?php esc_html_e("Content input text color", "tipster_script_login"); ?></label><br>
                                            <input type="text" class="tsl_colorpicker" name="tsl_citc" id="tsl_citc" value="<?php echo esc_attr(get_option("tsl_citc", "#1f2937")); ?>" data-default-color="#1f2937" />
                                        </div>
                                        <div class="tsl_custom_colorpicker">
                                            <label for="tsl_cibc"><?php esc_html_e("Content input border color", "tipster_script_login"); ?></label><br>
                                            <input type="text" class="tsl_colorpicker" name="tsl_cibc" id="tsl_cibc" value="<?php echo esc_attr(get_option("tsl_cibc", "#e5e7eb")); ?>" data-default-color="#e5e7eb" />
                                        </div>
                                        <div class="tsl_custom_colorpicker">
                                            <label for="tsl_pbc"><?php esc_html_e("Popup border color", "tipster_script_login"); ?></label><br>
                                            <input type="text" class="tsl_colorpicker" name="tsl_pbc" id="tsl_pbc" value="<?php echo esc_attr(get_option("tsl_pbc", "#374151")); ?>" data-default-color="#374151" />
                                        </div>
                                        <div class="tsl_custom_colorpicker">
                                            <label for="tsl_sbbgc"><?php esc_html_e("Submit button background color", "tipster_script_login"); ?></label><br>
                                            <input type="text" class="tsl_colorpicker" name="tsl_sbbgc" id="tsl_sbbgc" value="<?php echo esc_attr(get_option("tsl_sbbgc", "#6366f1")); ?>" data-default-color="#6366f1" />
                                        </div>
                                        <div class="tsl_custom_colorpicker">
                                            <label for="tsl_sbtc"><?php esc_html_e("Submit button text color", "tipster_script_login"); ?></label><br>
                                            <input type="text" class="tsl_colorpicker" name="tsl_sbtc" id="tsl_sbtc" value="<?php echo esc_attr(get_option("tsl_sbtc", "#ffffff")); ?>" data-default-color="#ffffff" />
                                        </div>
                                        <div class="tsl_custom_colorpicker">
                                            <label for="tsl_sbbc"><?php esc_html_e("Submit button border color", "tipster_script_login"); ?></label><br>
                                            <input type="text" class="tsl_colorpicker" name="tsl_sbbc" id="tsl_sbbc" value="<?php echo esc_attr(get_option("tsl_sbbc", "#6366f1")); ?>" data-default-color="#6366f1" />
                                        </div>
                                        <div class="tsl_custom_colorpicker">
                                            <label for="tsl_sbhbgc"><?php esc_html_e("Submit button hover background color", "tipster_script_login"); ?></label><br>
                                            <input type="text" class="tsl_colorpicker" name="tsl_sbhbgc" id="tsl_sbhbgc" value="<?php echo esc_attr(get_option("tsl_sbhbgc", "#4f46e5")); ?>" data-default-color="#4f46e5" />
                                        </div>
                                        <div class="tsl_custom_colorpicker">
                                            <label for="tsl_sbhtc"><?php esc_html_e("Submit button hover text color", "tipster_script_login"); ?></label><br>
                                            <input type="text" class="tsl_colorpicker" name="tsl_sbhtc" id="tsl_sbhtc" value="<?php echo esc_attr(get_option("tsl_sbhtc", "#ffffff")); ?>" data-default-color="#ffffff" />
                                        </div>
                                        <div class="tsl_custom_colorpicker">
                                            <label for="tsl_sbhbc"><?php esc_html_e("Submit button hover border color", "tipster_script_login"); ?></label><br>
                                            <input type="text" class="tsl_colorpicker" name="tsl_sbhbc" id="tsl_sbhbc" value="<?php echo esc_attr(get_option("tsl_sbhbc", "#4f46e5")); ?>" data-default-color="#4f46e5" />
                                        </div>
                                    </div>
                                    <div style="margin-top: 20px;">
                                        <button type="button" id="tsl_reset_colors" class="button"><?php esc_html_e("Reset Colors to Default", "tipster_script_login"); ?></button>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </tbody>
                </table>
                <h3><?php esc_html_e("Icons option", "tipster_script_login"); ?></h3>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th>
                                <?php esc_html_e("Log in", "tipster_script_login"); ?>
                            </th>
                            <td>
                                <textarea name="tsl_login_icon" rows="4" cols="70"><?php echo esc_html(get_option("tsl_login_icon", "")); ?></textarea><br>
                                <small><?php esc_html_e("You can insert an SVG icon or use a font icon like FontAwesome by adding the appropriate HTML code, e.g., <i class='fa fa-icon'></i>. Please ensure that FontAwesome is loaded on your site if you are using FontAwesome icons.", "tipster_script_login"); ?></small>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php esc_html_e("Register", "tipster_script_login"); ?>
                            </th>
                            <td>
                                <textarea name="tsl_register_icon" rows="4" cols="70"><?php echo esc_html(get_option("tsl_register_icon", "")); ?></textarea><br>
                                <small><?php esc_html_e("You can insert an SVG icon or use a font icon like FontAwesome by adding the appropriate HTML code, e.g., <i class='fa fa-icon'></i>. Please ensure that FontAwesome is loaded on your site if you are using FontAwesome icons.", "tipster_script_login"); ?></small>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php esc_html_e("Log out", "tipster_script_login"); ?>
                            </th>
                            <td>
                                <textarea name="tsl_logout_icon" rows="4" cols="70"><?php echo esc_html(get_option("tsl_logout_icon", "")); ?></textarea><br>
                                <small><?php esc_html_e("You can insert an SVG icon or use a font icon like FontAwesome by adding the appropriate HTML code, e.g., <i class='fa fa-icon'></i>. Please ensure that FontAwesome is loaded on your site if you are using FontAwesome icons.", "tipster_script_login"); ?></small>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php esc_html_e("Lost password", "tipster_script_login"); ?>
                            </th>
                            <td>
                                <textarea name="tsl_lost_pass_icon" rows="4" cols="70"><?php echo esc_html(get_option("tsl_lost_pass_icon", "")); ?></textarea><br>
                                <small><?php esc_html_e("You can insert an SVG icon or use a font icon like FontAwesome by adding the appropriate HTML code, e.g., <i class='fa fa-icon'></i>. Please ensure that FontAwesome is loaded on your site if you are using FontAwesome icons.", "tipster_script_login"); ?></small>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php esc_html_e("Reset password", "tipster_script_login"); ?>
                            </th>
                            <td>
                                <textarea name="tsl_reset_pass_icon" rows="4" cols="70"><?php echo esc_html(get_option("tsl_reset_pass_icon", "")); ?></textarea><br>
                                <small><?php esc_html_e("You can insert an SVG icon or use a font icon like FontAwesome by adding the appropriate HTML code, e.g., <i class='fa fa-icon'></i>. Please ensure that FontAwesome is loaded on your site if you are using FontAwesome icons.", "tipster_script_login"); ?></small>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php esc_html_e("Success message", "tipster_script_login"); ?>
                            </th>
                            <td>
                                <textarea name="tsl_success_icon" rows="4" cols="70"><?php echo esc_html(get_option("tsl_success_icon", "")); ?></textarea><br>
                                <small><?php esc_html_e("You can insert an SVG icon or use a font icon like FontAwesome by adding the appropriate HTML code, e.g., <i class='fa fa-icon'></i>. Please ensure that FontAwesome is loaded on your site if you are using FontAwesome icons.", "tipster_script_login"); ?></small>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php esc_html_e("Error message", "tipster_script_login"); ?>
                            </th>
                            <td>
                                <textarea name="tsl_error_icon" rows="4" cols="70"><?php echo esc_html(get_option("tsl_error_icon", "")); ?></textarea><br>
                                <small><?php esc_html_e("You can insert an SVG icon or use a font icon like FontAwesome by adding the appropriate HTML code, e.g., <i class='fa fa-icon'></i>. Please ensure that FontAwesome is loaded on your site if you are using FontAwesome icons.", "tipster_script_login"); ?></small>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <h3><?php esc_html_e("Google reCAPTCHA v3", "tipster_script_login"); ?></h3>
                <small>
                    <?php echo esc_html_e("You need to register your website and get the site and secret keys.", "tipster_script_login")."<a href='https://www.google.com/recaptcha/admin/create' target='blank'>More information</a>"; ?>
                </small>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th>
                                <?php esc_html_e("Status", "tipster_script_login"); ?>
                            </th>
                            <td>
                                <select name="tsl_recaptcha_enable">
                                    <option value="0"<?php echo (get_option("tsl_recaptcha_enable", "0") == "0") ? " selected" : ""; ?>><?php esC_html_e("Disable", "tipster_script_login"); ?></option>
                                    <option value="1"<?php echo (get_option("tsl_recaptcha_enable", "0") == "1") ? " selected" : ""; ?>><?php esC_html_e("Enable", "tipster_script_login"); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php esc_html_e("Site key", "tipster_script_login"); ?>
                            </th>
                            <td>
                                <input type="text" size="45" name="tsl_recaptcha_site_key" value="<?php echo esc_html(get_option("tsl_recaptcha_site_key", "")); ?>" /><br>
                                <small>
                                    <?php echo esc_html__("For test purposes, you can use the next site key", "tipster_script_login")." <b>6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI</b>"; ?>
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php esc_html_e("Secret key", "tipster_script_login"); ?>
                            </th>
                            <td>
                                <input type="text" size="45" name="tsl_recaptcha_secret_key" value="<?php echo esc_html(get_option("tsl_recaptcha_secret_key", "")); ?>" /><br>
                                <small>
                                    <?php echo esc_html__("For test purposes, you can use the next secret key", "tipster_script_login")." <b>6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe</b>"; ?>
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php esc_html_e("reCAPTCHA badge", "tipster_script_login"); ?>
                            </th>
                            <td>
                                <select name="tsl_recaptcha_badge">
                                    <option value="1"<?php echo (get_option("tsl_recaptcha_badge", "1") == "1") ? " selected" : ""; ?>><?php esc_html_e("Display", "tipster_script_login"); ?></option>
                                    <option value="2"<?php echo (get_option("tsl_recaptcha_badge", "1") == "2") ? " selected" : ""; ?>><?php esc_html_e("Hide", "tipster_script_login"); ?></option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="submit">
                    <input type="submit" name="save" value="<?php esc_html_e('Save changes', 'tipster_script_login');?>" class="button button-primary">
                </p>
            </form>
        </div>
    </div>
</div>
<?php
wp_enqueue_script('tsl-upload', TSL_URL.'assets/js/upload_image.js', array('jquery', 'media-upload', 'thickbox'));
wp_enqueue_style('thickbox');
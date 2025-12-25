<?php
class Tsl_login_register extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'Tsl_login_register',
            'TS - Login form',
            array('description' => __('TS - Login form', "tipster_script_login"))
        );
    }

    public static function tsl_register_widget() {
        return register_widget("Tsl_login_register");
    }

    function widget($args, $instance){
        extract($args, EXTR_SKIP);
        echo $before_widget;
        ?>
        <div class="tsl_login_form_header">
        <?php
        if(is_user_logged_in()) :
            $current_user = wp_get_current_user();
            $logout_value = get_option("tsl_logout_option", 1);
            ?>
            <span class="tsl_login_form_header__logged js--tsl-logged-show">
                <?php if($logout_value == 1) : ?>
                    <a href="<?php echo wp_logout_url(home_url()); ?>" class="tsl_login_form_header__logged-btn">
                        <?php echo (get_option("tsl_logout_icon", "") != "") ? get_option("tsl_logout_icon", "")."&nbsp;" : ""; ?>
                        <?php esc_html_e("Log out", "tipster_script_login"); ?>
                    </a>
                <?php else : ?>
                    <svg class="tsl-icon-user" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>&nbsp;<?php echo esc_html($current_user->display_name); ?>
                    <svg class="tsl-icon-chevron" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    <ul class="tsl_login_form_header__logged-dd">
                        <li class="tsl_login_form_header__logged-dd-item">
                            <a href="<?php echo wp_logout_url(home_url()); ?>">
                                <svg class="tsl_logout_icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                <?php esc_html_e("Log out", "tipster_script_login"); ?>
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
            </span>
            <?php
        else : 
            ?>
            <span class="tsl_login_form_header__login js--tsl-login-popup">
                <?php echo (get_option("tsl_login_icon", "") != "") ? get_option("tsl_login_icon", "")."&nbsp;" : ""; ?>
                <?php esc_attr_e("Login", "tipster_script_login"); ?>
            </span>
            <span class="tsl_login_form_header__separator">&nbsp;/&nbsp;</span>
            <span class="tsl_login_form_header__register js--tsl-register-popup">
                <?php echo (get_option("tsl_register_icon", "") != "") ? get_option("tsl_register_icon", "")."&nbsp;" : ""; ?>
                <?php esc_attr_e("Register", "tipster_script_login"); ?>
            </span>       
            <?php
        endif;
        ?>
        </div>
        <?php
        echo $after_widget;
    }
}
add_action( 'widgets_init', array('Tsl_login_register', 'tsl_register_widget') );
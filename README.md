# Ts login popup - WordPress plugin
[![License: GPLv2](https://img.shields.io/badge/License-GPLv2-green.svg)](http://www.gnu.org/licenses/gpl-2.0.html) [![version](https://img.shields.io/badge/version-1.0.5-blue.svg)](https://github.com/modulout/ts_login)

With the TS login plugin, your users can log in or/and register from the front page (not needed to go to wp-admin anymore). A simple widget is added, but you can add a class for login and a class for registration on any website element. The plugin is working with the latest WordPress version and is fully customizable. You can change colors in wp-admin to have your website look-alike feel.

There are also 3 login/register options: basic (only login or/and register form), the image on top (login or/and register form with image on top), and image on the left side (login or/and register form with image on the left side). All 3 options are fully responsive.

Google reCAPTCHA v3 is also available and you can use it with your site and secret key. By default this option is disabled.

Bootstrap library and Font-Awesome library are included.

## Installation

1. Upload the ts_login directory to the /wp-content/plugins/ directory or install through WordPress admin installer (wp-admin -> plugins -> add new)
2. Activate the plugin through the 'plugins' menu in WordPress.
3. Edit colors setting in wp-admin -> TS Login -> config

## Usage

You can use the already prepared widget TS - login form which will add login and register options (if users are not already logged in). In case the user is logged in it will be written his username (instead of login / register text).

#### Use login class

You can use a custom class on any element on your website. In this case, you need to add:  
```html
js--tsl-login-popup
```

#### Use register class

You can use a custom class on any element on your website. In this case, you need to add:  
```html
js--tsl-register-popup
```

## TO-DO

- [x] Make a standalone version
- [x] Logout from front page
- [x] Different style options for login/register popup
- [x] Add captcha option
- [x] Options to change icons or disable them
- [x] Upload to WordPress directory
- [x] Lost password and Reset password functionality in pop-up
- [x] Option to show register button on login pop-up

## Credits

Made with :heart: by [Modulout](https://www.modulout.com)

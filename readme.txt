=== TS Login – Frontend Login & Registration ===
Contributors: Modulout
Plugin Name: TS Login
Plugin URI: https://github.com/modulout/ts-login
Donate link: https://www.modulout.com/
Tags: login, register, frontend login, popup login, ajax login, membership
Requires at least: 5.0
Tested up to: 6.9
Stable tag: 1.0.5
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Frontend login, registration, and password recovery without using wp-admin.

== Description ==

With the TS Login plugin, your users can log in, register, and reset their passwords directly from the frontend, eliminating the need to access the WordPress wp-admin area. This provides a cleaner user experience and improves security for membership and subscription-based websites.

The plugin offers a lightweight popup-based login and registration system. You can trigger login or registration from any element on your website by applying predefined CSS classes - no shortcodes required.

TS Login works seamlessly with the latest WordPress versions and includes admin-side styling options, allowing you to adjust colors and layout for a consistent look and feel across your website.

= Performance & Stability (Version 1.0.5) =

Starting from version 1.0.5, TS Login has been rebuilt with a strong focus on performance and compatibility:

* Complete frontend UI rewrite
* Removed Bootstrap and Font Awesome dependencies
* No conflicts with themes or plugins using different framework versions
* Login and registration popup loaded via AJAX
* No unnecessary HTML output in the DOM
* Faster page load and improved stability

Additionally, TS Login integrates seamlessly with Tipster Script — a professional WordPress solution for managing tipster and subscription platforms. It is also the official login plugin used by the OwnTheGame service.

Learn more:
Tipster Script: https://tipsterscript.com  
OwnTheGame: https://ownthegame.app

= Key Features =

* Frontend login, registration, and password reset in popup form
* Lightweight, framework-free implementation
* AJAX-loaded popup for optimal performance
* Fully responsive design
* Customizable colors and layout via wp-admin
* Multi-language ready
* Works with any modern WordPress theme
* Official integration with Tipster Script and OwnTheGame

== Screenshots ==

1. Login form popup
2. Register form popup
3. Plugin configuration – colors
4. Plugin configuration – layout options

By default, all functionality is enabled without external dependencies. TS Login provides clean integration using CSS classes for advanced use cases.

== Installation ==

1. Upload the ts-login directory to the /wp-content/plugins/ directory or install the plugin via the WordPress admin panel (Plugins → Add New).
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Configure colors and layout in wp-admin → TS Login → Settings.

= Usage =

You can use the built-in TS Login widget to display login and registration options for logged-out users. When a user is logged in, the widget displays the current username instead of login/register buttons.

= Use login class =

Add the following class to any HTML element to trigger the login popup:

`js--tsl-login-popup`

= Use register class =

Add the following class to any HTML element to trigger the registration popup:

`js--tsl-register-popup`

== Frequently Asked Questions ==

= Is this plugin free? =
Yes. TS Login is free to use for personal and commercial projects.

= Does it replace the WordPress admin login? =
No. The default WordPress login remains available. TS Login provides a frontend alternative.

= Does it work with any theme? =
Yes. The plugin does not depend on Bootstrap or Font Awesome and works with any modern WordPress theme.

= Is the popup loaded on every page load? =
No. The popup content is loaded via AJAX only when needed.

== Upgrade Notice ==

= 1.0.5 =
Major performance and stability update. Recommended for all users.

== Changelog ==

= 1.0.5 =
* Complete frontend UI rewrite
* Removed Bootstrap and Font Awesome dependencies
* AJAX-loaded popup for improved performance
* Improved compatibility with modern themes
* Tested with WordPress 6.9

= 1.0.3 =
* Forgot password and reset password functionality in popup
* Option to customize or disable icons
* Option to show register button on login popup

= 1.0.2 =
* Compatible with WordPress 6.7.x

= 1.0.1 =
* Fixed Font Awesome issue

= 1.0.0 =
* Initial release

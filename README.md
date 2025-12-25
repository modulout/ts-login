# TS Login – Frontend Login & Registration for WordPress

[![License: GPLv2](https://img.shields.io/badge/License-GPLv2-green.svg)](https://www.gnu.org/licenses/gpl-2.0.html)
[![Version](https://img.shields.io/badge/version-1.0.5-blue.svg)](https://github.com/modulout/ts-login)

**TS Login** is a lightweight WordPress plugin that allows users to **log in, register, and reset their passwords directly from the frontend**, without accessing the WordPress `wp-admin` area.

It is built for **membership websites, subscription platforms, and frontend-only WordPress projects**, with a strong focus on **performance, stability, and compatibility**.

---

## Key Features

- Frontend login, registration, and password reset (popup-based)
- No access to `wp-admin` required for users
- Trigger login or registration from any element using CSS classes
- AJAX-loaded popup (no unnecessary markup in the DOM)
- Fast, lightweight, and conflict-free
- Fully responsive design
- Customizable colors and layout via WordPress admin
- Multi-language ready
- Compatible with modern WordPress themes and page builders
- Official login plugin for Tipster Script and OwnTheGame

---

## Performance & Stability (v1.0.5)

Starting from version **1.0.5**, TS Login has been fully rebuilt with performance and compatibility in mind:

- Complete frontend UI rewrite
- Removed Bootstrap dependency
- Removed Font Awesome dependency
- No framework conflicts with themes or plugins
- Popup content loaded via AJAX
- Faster page load and improved stability

---

## Integration

TS Login integrates seamlessly with:

- **Tipster Script** – a professional WordPress solution for tipster and subscription platforms  
  https://tipsterscript.com

- **OwnTheGame** – a hosted service built on Tipster Script for launching subscription websites  
  https://ownthegame.app

---

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

## Credits

Made with :heart: by [Modulout](https://www.modulout.com)

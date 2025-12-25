jQuery(function($) {
    // TSL Popup Manager - Hybrid approach: load all forms once, switch instantly
    var TSL_Popup = {
        overlay: null,
        formsContainer: null,
        forms: null,
        currentType: null,
        isLoading: false,
        isLoaded: false,

        // Initialize popup system
        init: function() {
            this.bindEvents();
            this.checkUrlParams();
        },

        // Create overlay and container elements
        createOverlay: function() {
            if (this.overlay) return;
            
            this.overlay = $('<div class="tsl-popup-overlay"></div>');
            this.formsContainer = $('<div class="tsl-forms-container"></div>');
            this.overlay.append(this.formsContainer);
            $('body').append(this.overlay);

            // Close on overlay click
            this.overlay.on('click', function(e) {
                if ($(e.target).hasClass('tsl-popup-overlay')) {
                    TSL_Popup.close();
                }
            });

            // Close on ESC key
            $(document).on('keydown.tslPopup', function(e) {
                if (e.key === 'Escape' && TSL_Popup.overlay && TSL_Popup.overlay.hasClass('tsl-popup-open')) {
                    TSL_Popup.close();
                }
            });
        },

        // Load all forms via single AJAX request
        loadForms: function(callback) {
            if (this.isLoading) return;
            if (this.isLoaded && this.forms) {
                if (callback) callback();
                return;
            }

            this.isLoading = true;
            var self = this;

            $.ajax({
                type: 'POST',
                url: tsl_main.ajaxurl,
                data: {
                    action: 'tsl_load_popup',
                    nonce: tsl_main.popup_nonce
                },
                success: function(response) {
                    if (response.success && response.data.forms) {
                        self.forms = response.data.forms;
                        self.isLoaded = true;
                        self.renderForms();
                        self.bindFormEvents();
                        if (callback) callback();
                    }
                    self.isLoading = false;
                },
                error: function() {
                    self.isLoading = false;
                }
            });
        },

        // Render all forms into container
        renderForms: function() {
            var self = this;
            this.formsContainer.empty();

            // Add each form wrapped in a container
            $.each(this.forms, function(type, html) {
                var formWrapper = $('<div class="tsl-form-wrapper" data-form-type="' + type + '"></div>');
                formWrapper.html(html);
                formWrapper.hide();
                self.formsContainer.append(formWrapper);
            });
        },

        // Open popup and show specific form
        open: function(formType, callback) {
            var self = this;
            this.createOverlay();

            // Load forms if not loaded yet
            if (!this.isLoaded) {
                this.loadForms(function() {
                    self.showForm(formType);
                    self.show();
                    if (callback) callback();
                });
            } else {
                this.showForm(formType);
                this.show();
                if (callback) callback();
            }
        },

        // Show specific form (instant switch, no AJAX)
        showForm: function(formType) {
            this.currentType = formType;
            
            // Hide all forms
            this.formsContainer.find('.tsl-form-wrapper').hide();
            
            // Show requested form
            this.formsContainer.find('.tsl-form-wrapper[data-form-type="' + formType + '"]').show();
            
            // Clear any previous error/success messages
            this.formsContainer.find('.tsl_form_error, .tsl_register_success, .tsl_lost_pass_success, .tsl_reset_pass_success').hide();
            this.formsContainer.find('.tsl-input-error').removeClass('tsl-input-error');
        },

        // Show the popup overlay
        show: function() {
            $('body').addClass('tsl-popup-active');
            this.overlay.addClass('tsl-popup-open');
        },

        // Close the popup
        close: function() {
            if (!this.overlay) return;
            
            $('body').removeClass('tsl-popup-active');
            this.overlay.removeClass('tsl-popup-open');
            this.currentType = null;
        },

        // Bind close button and form switch events
        bindFormEvents: function() {
            var self = this;

            // Close buttons
            this.formsContainer.on('click', '.tsl-popup-close', function() {
                self.close();
            });

            // Switch to register (instant)
            this.formsContainer.on('click', '.js--tsl-register-popup', function(e) {
                e.preventDefault();
                e.stopPropagation();
                self.showForm('register');
            });

            // Switch to login (instant)
            this.formsContainer.on('click', '.js--tsl-login-popup', function(e) {
                e.preventDefault();
                e.stopPropagation();
                self.showForm('login');
            });

            // Switch to forgot password (instant)
            this.formsContainer.on('click', '.js--tsl-pass-popup', function(e) {
                e.preventDefault();
                e.stopPropagation();
                self.showForm('lost_password');
            });

            // Bind the specific form handlers
            this.bindLoginForm();
            this.bindRegisterForm();
            this.bindLostPasswordForm();
            this.bindResetPasswordForm();
        },

        // Login form handler
        bindLoginForm: function() {
            var self = this;
            
            this.formsContainer.on("click", "#tsl_login_submit", function(e) {
                e.preventDefault();

                var form = self.formsContainer.find('.tsl-form-wrapper[data-form-type="login"]');
                var username = form.find("#user_login").val();
                var pass = form.find("#user_pass").val();
                
                if (username === "" || pass === "") {
                    self.showError(form, '.tsl_form_error', tsl_main.fields_empty);
                    form.find("#user_login, #user_pass").addClass('tsl-input-error');
                    return false;
                }

                if (tsl_main.recaptcha_status === "1") {
                    grecaptcha.ready(function() {
                        grecaptcha.execute(tsl_main.site_key, { action: 'submit' }).then(function(token) {
                            form.find('#recaptchaResponse').val(token);
                            self.submitLogin(form, username, pass);
                        });
                    });
                } else {
                    self.submitLogin(form, username, pass);
                }
            });

            // Clear errors on focus
            this.formsContainer.on("focusin", "#user_login, #user_pass", function() {
                var form = self.formsContainer.find('.tsl-form-wrapper[data-form-type="login"]');
                form.find('.tsl_form_error').hide();
                form.find("#user_login, #user_pass").removeClass('tsl-input-error');
            });
        },

        submitLogin: function(form, username, pass) {
            var self = this;
            
            $.ajax({
                type: 'POST',
                url: tsl_main.ajaxurl,
                data: {
                    action: 'tsl_login_form',
                    username: username,
                    pass: pass,
                    security: form.find('#security').val(),
                    recaptcha_status: tsl_main.recaptcha_status,
                    recaptcha_response: form.find('#recaptchaResponse').val()
                },
                success: function(data) {
                    data = JSON.parse(data);
                    if (data === '0') {
                        self.showError(form, '.tsl_form_error', tsl_main.fields_wrong);
                        form.find("#user_login, #user_pass").addClass('tsl-input-error');
                    } else {
                        if (window.location.href.indexOf('popup=tsl-login') > -1) {
                            window.location.href = '/';
                        } else {
                            document.location.reload();
                        }
                    }
                }
            });
        },

        // Register form handler
        bindRegisterForm: function() {
            var self = this;
            
            this.formsContainer.on("click", "#tsl_register_submit", function(e) {
                e.preventDefault();
                
                var form = self.formsContainer.find('.tsl-form-wrapper[data-form-type="register"]');
                var username = form.find("#tsl_username").val();
                var email = form.find("#tsl_email").val();
                var pass = form.find("#tsl_password").val();
                
                if (username === "" || email === "" || pass === "") {
                    self.showError(form, '.tsl_form_error', tsl_main.rfields_empty);
                    form.find("#tsl_username, #tsl_email, #tsl_password").addClass('tsl-input-error');
                    return false;
                }

                if (tsl_main.recaptcha_status === "1") {
                    grecaptcha.ready(function() {
                        grecaptcha.execute(tsl_main.site_key, { action: 'submit' }).then(function(token) {
                            form.find('#recaptchaResponse').val(token);
                            self.submitRegister(form, username, email, pass);
                        });
                    });
                } else {
                    self.submitRegister(form, username, email, pass);
                }
            });

            // Clear errors on focus
            this.formsContainer.on("focusin", "#tsl_username, #tsl_email, #tsl_password", function() {
                var form = self.formsContainer.find('.tsl-form-wrapper[data-form-type="register"]');
                form.find('.tsl_form_error').hide();
                form.find("#tsl_username, #tsl_email, #tsl_password").removeClass('tsl-input-error');
            });
        },

        submitRegister: function(form, username, email, pass) {
            var self = this;
            
            $.ajax({
                type: 'POST',
                url: tsl_main.ajaxurl,
                data: {
                    action: 'tsl_register_form',
                    username: username,
                    email: email,
                    pass: pass,
                    rsecurity: form.find('#rsecurity').val(),
                    recaptcha_status: tsl_main.recaptcha_status,
                    recaptcha_response: form.find('#recaptchaResponse').val()
                },
                success: function(data) {
                    data = JSON.parse(data);
                    if (data === '0') {
                        self.showError(form, '.tsl_form_error', tsl_main.username_exists);
                        form.find("#tsl_username").addClass('tsl-input-error');
                    } else if (data === '2') {
                        self.showError(form, '.tsl_form_error', tsl_main.register_fail);
                    } else if (data === '3') {
                        self.showError(form, '.tsl_form_error', tsl_main.email_exists);
                        form.find("#tsl_email").addClass('tsl-input-error');
                    } else if (data === '4') {
                        self.showError(form, '.tsl_form_error', tsl_main.recaptcha_error);
                    } else if (data === '5') {
                        self.showError(form, '.tsl_form_error', tsl_main.email_error);
                        form.find("#tsl_email").addClass('tsl-input-error');
                    } else {
                        if (tsl_main.register_redirect && tsl_main.register_redirect !== '') {
                            window.location.href = tsl_main.register_redirect;
                        }
                    }
                }
            });
        },

        // Lost password form handler
        bindLostPasswordForm: function() {
            var self = this;
            
            this.formsContainer.on("click", "#lost-password-submit", function(e) {
                e.preventDefault();
                
                var form = self.formsContainer.find('.tsl-form-wrapper[data-form-type="lost_password"]');
                var user_email = form.find("#lost-password-email").val();
                
                form.find('.tsl_form_error').hide();
                form.find('.tsl_lost_pass_success').hide();
                form.find("#lost-password-email").removeClass('tsl-input-error');

                if (user_email === "") {
                    self.showError(form, '.tsl_form_error', tsl_main.email_empty);
                    form.find("#lost-password-email").addClass('tsl-input-error');
                    return false;
                }

                if (tsl_main.recaptcha_status === "1") {
                    grecaptcha.ready(function() {
                        grecaptcha.execute(tsl_main.site_key, { action: 'submit' }).then(function(token) {
                            form.find('#recaptchaResponse').val(token);
                            self.submitLostPassword(form, user_email);
                        });
                    });
                } else {
                    self.submitLostPassword(form, user_email);
                }
            });
        },

        submitLostPassword: function(form, user_email) {
            var self = this;
            
            $.ajax({
                type: 'POST',
                url: tsl_main.ajaxurl,
                data: {
                    action: 'tsl_lost_pass_form',
                    user_email: user_email,
                    lsecurity: form.find('#lsecurity').val(),
                    recaptcha_response: form.find('#recaptchaResponse').val(),
                    recaptcha_status: tsl_main.recaptcha_status
                },
                success: function(response) {
                    if (response.success) {
                        self.showSuccess(form, '.tsl_lost_pass_success', response.data.message);
                    } else if (response.data && response.data.message) {
                        self.showError(form, '.tsl_form_error', response.data.message);
                        form.find("#lost-password-email").addClass('tsl-input-error');
                    } else {
                        self.showError(form, '.tsl_form_error', tsl_main.unexpected_error);
                    }
                },
                error: function() {
                    self.showError(form, '.tsl_form_error', tsl_main.unexpected_error);
                }
            });
        },

        // Reset password form handler
        bindResetPasswordForm: function() {
            var self = this;
            
            this.formsContainer.on("click", "#save-password-submit", function(e) {
                e.preventDefault();
                
                var form = self.formsContainer.find('.tsl-form-wrapper[data-form-type="reset_password"]');
                var password = form.find("#new-password").val();
                var key = new URLSearchParams(window.location.search).get("key");
                var login = new URLSearchParams(window.location.search).get("login");

                form.find('.tsl_form_error').hide();
                form.find('.tsl_reset_pass_success').hide();

                if (!password || password.length < 12) {
                    self.showError(form, '.tsl_form_error', tsl_main.short_pass);
                    return false;
                }

                if (!key || !login) {
                    self.showError(form, '.tsl_form_error', tsl_main.invalid_reset);
                    return false;
                }

                $.ajax({
                    type: "POST",
                    url: tsl_main.ajaxurl,
                    data: {
                        action: "tsl_save_new_password",
                        password: password,
                        key: key,
                        login: login,
                        psecurity: form.find("#psecurity").val()
                    },
                    success: function(response) {
                        if (response.success) {
                            self.showSuccess(form, '.tsl_reset_pass_success', response.data.message);
                            setTimeout(function() {
                                window.location.href = response.data.redirect_url;
                            }, 1000);
                        } else if (response.data && response.data.message) {
                            self.showError(form, '.tsl_form_error', response.data.message);
                        } else {
                            self.showError(form, '.tsl_form_error', tsl_main.unexpected_error);
                        }
                    },
                    error: function() {
                        self.showError(form, '.tsl_form_error', tsl_main.unexpected_error);
                    }
                });
            });
        },

        // Show error message
        showError: function(form, selector, message) {
            form.find(selector).show().html(tsl_main.error_icon + message);
        },

        // Show success message
        showSuccess: function(form, selector, message) {
            form.find(selector).show().html(tsl_main.success_icon + message);
        },

        // Bind trigger events (from external elements like widget)
        bindEvents: function() {
            var self = this;

            // Login popup trigger
            $(document).on("click", ".js--tsl-login-popup", function(e) {
                if (!self.overlay || !self.overlay.hasClass('tsl-popup-open')) {
                    e.preventDefault();
                    self.open('login');
                }
            });

            // Register popup trigger
            $(document).on("click", ".js--tsl-register-popup", function(e) {
                if (!self.overlay || !self.overlay.hasClass('tsl-popup-open')) {
                    e.preventDefault();
                    self.open('register');
                }
            });

            // Lost password popup trigger
            $(document).on("click", ".js--tsl-pass-popup", function(e) {
                if (!self.overlay || !self.overlay.hasClass('tsl-popup-open')) {
                    e.preventDefault();
                    self.open('lost_password');
                }
            });

            // Logged user dropdown toggle
            $(document).on("click", ".js--tsl-logged-show", function() {
                var logout_dd = $(".tsl_login_form_header__logged-dd");
                if (logout_dd.is(":hidden")) {
                    logout_dd.css("display", "block");
                } else {
                    logout_dd.hide();
                }
            });

            // Close dropdown when clicking outside
            $(document).on("click", function(e) {
                if (!$(e.target).closest('.tsl_login_form_header__logged').length) {
                    $(".tsl_login_form_header__logged-dd").hide();
                }
            });
        },

        // Check URL parameters on page load
        checkUrlParams: function() {
            var self = this;
            
            function getUrlParameter(name) {
                name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
                var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
                var results = regex.exec(window.location.search);
                return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
            }

            var popup = getUrlParameter('popup');
            var message = getUrlParameter('message');

            if (popup === 'tsl-reset-password') {
                self.open('reset_password');
            } else if (popup === 'tsl-login') {
                self.open('login', function() {
                    if (message === "registration-success") {
                        var form = self.formsContainer.find('.tsl-form-wrapper[data-form-type="login"]');
                        self.showSuccess(form, '.tsl_register_success', tsl_main.register_success);
                    }
                });
            } else if (popup === 'tsl-register') {
                self.open('register');
            }
        }
    };

    // Initialize
    TSL_Popup.init();
}); 
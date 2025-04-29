<?php
if (!defined('ABSPATH')) {
    exit;
}

// Styles und Skripte korrekt registrieren
add_action('login_enqueue_scripts', function () {
    // Dummy-Handles für Inline-Styling
    wp_register_style('macher-login-style', false);
    wp_enqueue_style('macher-login-style');

    wp_register_script('macher-login-script', false, [], null, true);
    wp_enqueue_script('macher-login-script');

    // Login CSS dynamisch erstellen
    $logo_url     = get_option('macher_backend_login_logo_url');
    $logo_width   = get_option('macher_backend_login_logo_width', '320');
    $bg_color     = get_option('macher_backend_login_bg_color');
    $text_color   = get_option('macher_backend_login_text_color');
    $button_color = get_option('macher_backend_login_button_color');

    $box_padding       = get_option('macher_backend_login_box_padding', '60');
    $box_width         = get_option('macher_backend_login_box_width', '380');
    $box_bg            = get_option('macher_backend_login_box_background', '#ffffff');
    $box_border        = get_option('macher_backend_login_box_border_color', '#dddddd');
    $box_radius        = get_option('macher_backend_login_box_radius', '10');
    $box_shadow_active = get_option('macher_backend_login_box_shadow') === '1';

    $css = '';

    if (!empty($logo_url)) {
        $css .= '
            body.login div#login h1 a {
                background-image: url("' . esc_url($logo_url) . '");
                background-size: contain;
                background-position: center;
                background-repeat: no-repeat;
                width: 100%;
                max-width: ' . intval($logo_width) . 'px;
                height: 100px;
            }';
    }

    if (!empty($bg_color)) {
        $css .= 'body.login { background-color: ' . esc_attr($bg_color) . ' !important; }';
    }

    if (!empty($text_color)) {
        $css .= '
            body.login,
            body.login label,
            body.login .message,
            body.login #nav a,
            body.login #backtoblog a {
                color: ' . esc_attr($text_color) . ' !important;
            }';
    }

    if (!empty($button_color)) {
        $css .= '
            body.login input#wp-submit.button-primary {
                background-color: ' . esc_attr($button_color) . ' !important;
                border-color: ' . esc_attr($button_color) . ' !important;
                color: #fff !important;
                text-shadow: none !important;
                box-shadow: none !important;
            }
            body.login input#wp-submit.button-primary:hover {
                opacity: 0.9;
            }';
    }

    $css .= '
        body.login #login {
            padding-top: ' . intval($box_padding) . 'px;
            width: 100%;
            max-width: ' . intval($box_width) . 'px;
            margin: auto;
        }

        body.login #loginform {
            width: 100%;
            background: ' . esc_attr($box_bg) . ';
            border: 1px solid ' . esc_attr($box_border) . ';
            border-radius: ' . intval($box_radius) . 'px;
            padding: 26px 24px;
            ' . ($box_shadow_active ? 'box-shadow: 0 0 20px rgba(0,0,0,0.08);' : '') . '
        }

        body.login #loginform label {
            font-weight: 600;
        }

        .macher-welcome-message {
            margin-bottom: 20px;
            text-align: center;
            font-size: 16px;
        }';

    if (!empty($css)) {
        wp_add_inline_style('macher-login-style', $css);
    }

    // Login JS dynamisch erstellen
    $mode = get_option('macher_backend_login_login_behavior', 'default');
    $login_mode = get_option('macher_backend_login_mode', 'default');

    $js = '';

    if ('default' !== $mode) {
        $new_label = $mode === 'email_only' ? esc_js(__('E-Mail-Adresse', 'macher-one')) : esc_js(__('Benutzername', 'macher-one'));
        $js .= '
            document.addEventListener("DOMContentLoaded", function() {
                var label = document.querySelector("label[for=\'user_login\']");
                if (label) {
                    label.textContent = "' . $new_label . '";
                }
            });';
    }

    $js .= '
        document.addEventListener("DOMContentLoaded", function() {
            document.body.setAttribute("data-macher-login-mode", "' . esc_js($login_mode) . '");
        });';

    if (!empty($js)) {
        wp_add_inline_script('macher-login-script', $js);
    }
}, 20);

// Willkommensnachricht je Sprache
add_filter('login_message', function ($message) {
    $locale = determine_locale();
    $lang = substr($locale, 0, 2);
    $langs = get_option('macher_backend_login_active_languages', ['de']);

    if (!in_array($lang, $langs, true)) {
        return $message;
    }

    $option = 'macher_backend_login_welcome_text_' . $lang;
    $text = get_option($option, '');

    if (!empty($text)) {
        return '<div class="macher-welcome-message">' . wpautop(wp_kses_post($text)) . '</div>' . $message;
    }

    return $message;
});

// Login-Eingaben prüfen (nur Benutzername oder E-Mail)
add_filter('authenticate', function ($user, $username, $password) {
    if (is_wp_error($user) || empty($username) || empty($password)) {
        return $user;
    }

    $mode = get_option('macher_backend_login_login_behavior', 'default');

    if ('username_only' === $mode && is_email($username)) {
        return new WP_Error(
            'username_only_login',
            esc_html__('Bitte gib deinen Benutzernamen ein. E-Mail-Login ist deaktiviert.', 'macher-one')
        );
    }

    if ('email_only' === $mode && !is_email($username)) {
        return new WP_Error(
            'email_only_login',
            esc_html__('Bitte gib deine E-Mail-Adresse ein. Benutzername-Login ist deaktiviert.', 'macher-one')
        );
    }

    return $user;
}, 30, 3);
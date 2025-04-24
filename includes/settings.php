<?php
if (!defined('ABSPATH')) {
    exit;
}

// Hilfsfunktion für Boolean-Werte
function macher_one_sanitize_boolean($value) {
    return $value === '1' || $value === 1 || $value === true || $value === 'true' ? true : false;
}

// Globaler Header
if (!function_exists('macher_one_get_header_html')) {
    function macher_one_get_header_html() {
        ob_start();
        ?>
        <div class="macher-suite-header" style="text-align:center; margin-bottom:40px;">
            <div class="macher-header-logo" style="background: url('<?php echo esc_url('https://macher.one/wp-content/uploads/2025/03/logo-dermacher-one-dark.webp'); ?>') no-repeat center center; background-size: contain; height: 60px; margin-bottom: 10px;"></div>
            <h2 style="margin: 0;"><?php echo esc_html__('Die Suite für Profis', 'macher-one'); ?></h2>
            <p style="font-size: 14px;"><?php echo esc_html__('Verwalte alle verfügbaren Module und Einstellungen zentral über dieses Panel.', 'macher-one'); ?></p>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Plugin-Option registrieren – PluginCheck-konform!
function macher_one_register_settings() {
    register_setting(
        'macher_one_settings',               // settings group
        'macher_fontawesome_global',         // option name
        'macher_one_sanitize_boolean'        // sanitize callback (STATIC STRING)
    );
}
add_action('admin_init', 'macher_one_register_settings');

if (!function_exists('macher_backend_login_get_languages')) {
    function macher_backend_login_get_languages() {
        return [
            'de' => esc_html__('Deutsch', 'macher-one'),
            'en' => esc_html__('Englisch', 'macher-one'),
        ];
    }
}

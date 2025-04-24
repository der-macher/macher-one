<?php
if (!defined('ABSPATH')) {
    exit;
}

// Backend-Seite
function macher_backend_login_page() {
    $languages = macher_backend_login_get_languages();

    if (!current_user_can('manage_options')) {
        wp_die(esc_html__('Du bist leider nicht berechtigt, auf diese Seite zuzugreifen.', 'macher-one'));
    }

    $active_languages = get_option('macher_backend_login_active_languages', []);
    if (!is_array($active_languages)) {
        $active_languages = [];
    }
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Backend Login Einstellungen', 'macher-one'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('macher_backend_login_options');
            do_settings_sections('macher-backend-login');

            echo '<h2>' . esc_html__('Aktive Sprachen für Willkommensnachricht', 'macher-one') . '</h2>';
            foreach ($languages as $code => $label) {
                printf(
                    '<label style="margin-right:20px;"><input type="checkbox" name="macher_backend_login_active_languages[]" value="%1$s" %2$s /> %3$s</label>',
                    esc_attr($code),
                    checked(in_array($code, $active_languages), true, false),
                    esc_html($label)
                );
            }

            echo '<p class="description">' . esc_html__('Nur aktivierte Sprachen werden im Login angezeigt. Inhalte bleiben bei Deaktivierung erhalten.', 'macher-one') . '</p>';

            foreach ($languages as $code => $label) {
                if (!in_array($code, $active_languages)) continue;

                echo '<h3 style="margin-top:30px;">' . esc_html__('Willkommensnachricht', 'macher-one') . ' (' . esc_html($label) . ')</h3>';

                wp_editor(
                    get_option('macher_backend_login_welcome_text_' . $code, ''),
                    'macher_backend_login_welcome_text_' . $code,
                    [
                        'textarea_name' => 'macher_backend_login_welcome_text_' . $code,
                        'textarea_rows' => 6,
                        'media_buttons' => false,
                    ]
                );
            }

            submit_button(esc_html__('Änderungen speichern', 'macher-one'));
            ?>
        </form>
    </div>
    <?php
}

// Optionen registrieren
add_action('admin_init', 'macher_backend_login_register_settings');

function macher_sanitize_active_languages($input) {
    if (!is_array($input)) {
        return [];
    }
    return array_map('sanitize_key', $input);
}

function macher_backend_login_register_settings() {
    // Aktive Sprachen
    register_setting('macher_backend_login_options', 'macher_backend_login_active_languages', [
        'sanitize_callback' => 'macher_sanitize_active_languages',
        'type'              => 'array',
        'default'           => [],
    ]);

    // Sprachenfelder statisch registrieren
    register_setting('macher_backend_login_options', 'macher_backend_login_welcome_text_de', [
        'sanitize_callback' => 'wp_kses_post',
        'type'              => 'string',
        'default'           => '',
    ]);
    register_setting('macher_backend_login_options', 'macher_backend_login_welcome_text_en', [
        'sanitize_callback' => 'wp_kses_post',
        'type'              => 'string',
        'default'           => '',
    ]);
    register_setting('macher_backend_login_options', 'macher_backend_login_welcome_text_fr', [
        'sanitize_callback' => 'wp_kses_post',
        'type'              => 'string',
        'default'           => '',
    ]);
    register_setting('macher_backend_login_options', 'macher_backend_login_welcome_text_it', [
        'sanitize_callback' => 'wp_kses_post',
        'type'              => 'string',
        'default'           => '',
    ]);
    register_setting('macher_backend_login_options', 'macher_backend_login_welcome_text_es', [
        'sanitize_callback' => 'wp_kses_post',
        'type'              => 'string',
        'default'           => '',
    ]);

    // Weitere Felder einzeln registrieren
    register_setting('macher_backend_login_options', 'macher_backend_login_logo_url', [
        'sanitize_callback' => 'esc_url_raw',
        'type'              => 'string',
        'default'           => '',
    ]);
    register_setting('macher_backend_login_options', 'macher_backend_login_logo_width', [
        'sanitize_callback' => 'absint',
        'type'              => 'integer',
        'default'           => 320,
    ]);
    register_setting('macher_backend_login_options', 'macher_backend_login_bg_color', [
        'sanitize_callback' => 'sanitize_hex_color',
        'type'              => 'string',
        'default'           => '',
    ]);
    register_setting('macher_backend_login_options', 'macher_backend_login_text_color', [
        'sanitize_callback' => 'sanitize_hex_color',
        'type'              => 'string',
        'default'           => '',
    ]);
    register_setting('macher_backend_login_options', 'macher_backend_login_button_color', [
        'sanitize_callback' => 'sanitize_hex_color',
        'type'              => 'string',
        'default'           => '',
    ]);
    register_setting('macher_backend_login_options', 'macher_backend_login_box_background', [
        'sanitize_callback' => 'sanitize_hex_color',
        'type'              => 'string',
        'default'           => '',
    ]);
    register_setting('macher_backend_login_options', 'macher_backend_login_box_border_color', [
        'sanitize_callback' => 'sanitize_hex_color',
        'type'              => 'string',
        'default'           => '',
    ]);
    register_setting('macher_backend_login_options', 'macher_backend_login_box_radius', [
        'sanitize_callback' => 'absint',
        'type'              => 'integer',
        'default'           => 10,
    ]);
    register_setting('macher_backend_login_options', 'macher_backend_login_box_padding', [
        'sanitize_callback' => 'absint',
        'type'              => 'integer',
        'default'           => 60,
    ]);
    register_setting('macher_backend_login_options', 'macher_backend_login_box_width', [
        'sanitize_callback' => 'absint',
        'type'              => 'integer',
        'default'           => 380,
    ]);
    register_setting('macher_backend_login_options', 'macher_backend_login_box_shadow', [
        'sanitize_callback' => 'absint',
        'type'              => 'integer',
        'default'           => 0,
    ]);
    register_setting('macher_backend_login_options', 'macher_backend_login_login_behavior', [
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'string',
        'default'           => 'default',
    ]);

    // Sektion + Felder
    add_settings_section('macher_backend_login_section', esc_html__('Login-Anpassung', 'macher-one'), null, 'macher-backend-login');

    add_settings_field('macher_backend_login_logo_url', esc_html__('Logo-URL', 'macher-one'), 'macher_backend_login_logo_url_render', 'macher-backend-login', 'macher_backend_login_section');
    add_settings_field('macher_backend_login_logo_width', esc_html__('Logo-Breite (px)', 'macher-one'), 'macher_backend_login_logo_width_render', 'macher-backend-login', 'macher_backend_login_section');

    add_settings_field('macher_backend_login_bg_color', esc_html__('Hintergrundfarbe', 'macher-one'), 'macher_backend_login_color_render', 'macher-backend-login', 'macher_backend_login_section', ['option_name' => 'macher_backend_login_bg_color']);
    add_settings_field('macher_backend_login_text_color', esc_html__('Textfarbe', 'macher-one'), 'macher_backend_login_color_render', 'macher-backend-login', 'macher_backend_login_section', ['option_name' => 'macher_backend_login_text_color']);
    add_settings_field('macher_backend_login_button_color', esc_html__('Buttonfarbe', 'macher-one'), 'macher_backend_login_color_render', 'macher-backend-login', 'macher_backend_login_section', ['option_name' => 'macher_backend_login_button_color']);
    add_settings_field('macher_backend_login_box_background', esc_html__('Box-Hintergrund', 'macher-one'), 'macher_backend_login_color_render', 'macher-backend-login', 'macher_backend_login_section', ['option_name' => 'macher_backend_login_box_background']);
    add_settings_field('macher_backend_login_box_border_color', esc_html__('Box-Rahmenfarbe', 'macher-one'), 'macher_backend_login_color_render', 'macher-backend-login', 'macher_backend_login_section', ['option_name' => 'macher_backend_login_box_border_color']);

    add_settings_field('macher_backend_login_box_radius', esc_html__('Box-Ecken (px)', 'macher-one'), 'macher_backend_login_number_render', 'macher-backend-login', 'macher_backend_login_section', ['option_name' => 'macher_backend_login_box_radius']);
    add_settings_field('macher_backend_login_box_padding', esc_html__('Abstand oben (px)', 'macher-one'), 'macher_backend_login_number_render', 'macher-backend-login', 'macher_backend_login_section', ['option_name' => 'macher_backend_login_box_padding']);
    add_settings_field('macher_backend_login_box_width', esc_html__('Box-Breite (px)', 'macher-one'), 'macher_backend_login_number_render', 'macher-backend-login', 'macher_backend_login_section', ['option_name' => 'macher_backend_login_box_width']);

    add_settings_field('macher_backend_login_box_shadow', esc_html__('Schatten aktivieren', 'macher-one'), 'macher_backend_login_checkbox_render', 'macher-backend-login', 'macher_backend_login_section', ['option_name' => 'macher_backend_login_box_shadow']);
    add_settings_field('macher_backend_login_login_behavior', esc_html__('Login-Verhalten', 'macher-one'), 'macher_backend_login_login_behavior_render', 'macher-backend-login', 'macher_backend_login_section');
}

// Eingabefelder
function macher_backend_login_logo_url_render() {
    $value = esc_url(get_option('macher_backend_login_logo_url', ''));
    ?>
    <div id="macher-logo-wrapper">
        <input type="hidden" id="macher_backend_login_logo_url" name="macher_backend_login_logo_url" value="<?php echo esc_attr($value); ?>" />
        <?php if ($value) : ?>
            <img id="macher_logo_preview" src="<?php echo esc_url($value); ?>" alt="" style="max-height: 60px;" />
        <?php else : ?>
            <img id="macher_logo_preview" src="" alt="" style="max-height: 60px; display:none;" />
        <?php endif; ?>
        <br />
        <button type="button" class="button" id="macher_logo_upload"><?php esc_html_e('Bild auswählen', 'macher-one'); ?></button>
        <button type="button" class="button" id="macher_logo_remove" style="<?php echo $value ? '' : 'display:none;'; ?>"><?php esc_html_e('Entfernen', 'macher-one'); ?></button>
    </div>
    <?php
}

function macher_backend_login_logo_width_render() {
    $value = absint(get_option('macher_backend_login_logo_width', 320));
    echo '<input type="number" name="macher_backend_login_logo_width" value="' . esc_attr($value) . '" class="small-text" min="10" max="1000" /> px';
}

function macher_backend_login_color_render($args) {
    $value = sanitize_hex_color(get_option($args['option_name'], ''));
    echo '<input type="text" name="' . esc_attr($args['option_name']) . '" value="' . esc_attr($value) . '" class="macher-color-picker" />';
}

function macher_backend_login_number_render($args) {
    $value = absint(get_option($args['option_name'], ''));
    echo '<input type="number" name="' . esc_attr($args['option_name']) . '" value="' . esc_attr($value) . '" class="small-text" />';
}

function macher_backend_login_checkbox_render($args) {
    $value = absint(get_option($args['option_name'], 0));
    echo '<input type="checkbox" name="' . esc_attr($args['option_name']) . '" value="1" ' . checked($value, 1, false) . ' />';
}

function macher_backend_login_login_behavior_render() {
    $value = get_option('macher_backend_login_login_behavior', 'default');
    ?>
    <select name="macher_backend_login_login_behavior" id="macher_backend_login_login_behavior">
        <option value="default" <?php selected($value, 'default'); ?>><?php esc_html_e('Standard (Benutzername oder E-Mail)', 'macher-one'); ?></option>
        <option value="username_only" <?php selected($value, 'username_only'); ?>><?php esc_html_e('Nur Benutzername', 'macher-one'); ?></option>
        <option value="email_only" <?php selected($value, 'email_only'); ?>><?php esc_html_e('Nur E-Mail-Adresse', 'macher-one'); ?></option>
    </select>
    <p class="description"><?php esc_html_e('Wähle aus, wie sich Benutzer beim Login identifizieren dürfen.', 'macher-one'); ?></p>
    <?php
}
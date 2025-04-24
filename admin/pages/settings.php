<?php
if (!defined('ABSPATH')) {
    exit;
}

// Header einbinden
require_once plugin_dir_path(__FILE__) . '../../includes/admin-header.php';

function macher_one_render_settings_page() {
    ?>
    <div class="wrap macher-settings-page">
        <?php
        echo wp_kses(
            macher_one_get_header_html(),
            [
                'div'    => ['class' => [], 'style' => []],
                'a'      => ['href' => [], 'target' => [], 'rel' => []],
                'img'    => ['src' => [], 'alt' => [], 'style' => []],
                'h2'     => ['style' => []],
                'p'      => ['style' => []],
                'br'     => [],
                'span'   => ['style' => []],
            ]
        );
        ?>

        <h1><?php esc_html_e('Einstellungen', 'macher-one'); ?></h1>
        <p><?php esc_html_e('Hier kannst du globale Einstellungen für die MACHER.one Suite verwalten.', 'macher-one'); ?></p>

        <div class="macher-tabs">
            <ul class="macher-tab-links">
                <li class="active"><a href="#tab-1"><i class="fas fa-cog"></i> <?php esc_html_e('Allgemein', 'macher-one'); ?></a></li>
                <?php if (get_option('macher_backend_login_enabled', false)) : ?>
                    <li><a href="#tab-2"><i class="fa-solid fa-shield-halved"></i> <?php esc_html_e('Backend Login', 'macher-one'); ?></a></li>
                <?php endif; ?>
            </ul>

            <div class="macher-tab-content">
                <div id="tab-1" class="tab active">
                    <form method="post" action="options.php">
                        <h2><?php esc_html_e('Allgemeine Optionen', 'macher-one'); ?></h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <label for="macher_fontawesome_global"><?php esc_html_e('Font Awesome global laden', 'macher-one'); ?></label>
                                </th>
                                <td class="fontawesome">
                                    <?php $global_fa = get_option('macher_fontawesome_global', '0'); ?>
                                    <input type="checkbox" name="macher_fontawesome_global" id="macher_fontawesome_global" value="1" <?php checked($global_fa, '1'); ?> />
                                    <p class="description"><?php esc_html_e('Aktiviere diese Option, um Font Awesome auf der gesamten WordPress-Website verfügbar zu machen.', 'macher-one'); ?></p>
                                </td>
                            </tr>
                        </table>
                        <?php
                        settings_fields('macher_one_settings');
                        do_settings_sections('macher_one_settings');
                        submit_button(__('Änderungen speichern', 'macher-one'));
                        ?>
                    </form>
                </div>

                <?php if (get_option('macher_backend_login_enabled', false)) : ?>
                <div id="tab-2" class="tab">
                    <form method="post" action="options.php">
                        <?php
                        settings_fields('macher_backend_login_options');
                        do_settings_sections('macher-backend-login');

                        $languages = macher_backend_login_get_languages();
                        $active_languages = get_option('macher_backend_login_active_languages', []);
                        if (!is_array($active_languages)) {
                            $active_languages = [];
                        }

                        echo '<h3>' . esc_html__('Aktive Sprachen für Willkommensnachricht', 'macher-one') . '</h3>';
                        foreach ($languages as $code => $label) {
                            echo '<label style="margin-right:20px;">';
                            echo '<input type="checkbox" name="macher_backend_login_active_languages[]" value="' . esc_attr($code) . '" ' . checked(in_array($code, $active_languages), true, false) . '> ';
                            echo esc_html($label) . '</label>';
                        }
                        echo '<p class="description">' . esc_html__('Nur aktivierte Sprachen werden im Login angezeigt. Inhalte bleiben bei Deaktivierung erhalten.', 'macher-one') . '</p>';

                        foreach ($languages as $code => $label) {
                            if (!in_array($code, $active_languages)) {
                                continue;
                            }
                            echo '<h4 style="margin-top:30px;">' . esc_html__('Willkommensnachricht', 'macher-one') . ' (' . esc_html($label) . ')</h4>';
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
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}
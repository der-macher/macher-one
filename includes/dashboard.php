<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'admin-header.php';

class Macher_Dashboard {
    public static function render_dashboard() {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';

        $ai_plugin = 'm1-ai-label/m1-ai-label.php';
        $ai_plugin_installed = file_exists(WP_PLUGIN_DIR . '/' . $ai_plugin);
        $ai_plugin_active = is_plugin_active($ai_plugin);

        // Verarbeitung Formular
        if (
            isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' &&
            isset($_POST['macher_dashboard_nonce']) &&
            wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['macher_dashboard_nonce'])), 'macher_dashboard_save')
        ) {
            // Backend Login
            $backend_active = isset($_POST['macher_backend_login_enabled']) ? '1' : '0';
            update_option('macher_backend_login_enabled', $backend_active);

            // KI Label
            $ki_active = isset($_POST['macher_ki_media_enabled']) ? '1' : '0';
            update_option('macher_ki_media_enabled', $ki_active);

            // KI Plugin bei Aktivierung starten
            if ($ki_active === '1' && $ai_plugin_installed && !$ai_plugin_active) {
                activate_plugin($ai_plugin);
            }

            add_action('admin_notices', function () {
                echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Einstellungen gespeichert.', 'macher-one') . '</p></div>';
            });
        }

        // Status laden
        $backend_active = get_option('macher_backend_login_enabled', false);
        $ki_active = get_option('macher_ki_media_enabled', false);

        $backend_status_label = $backend_active ? '🟢 ' . esc_html__('Aktiv', 'macher-one') : '🔴 ' . esc_html__('Deaktiviert', 'macher-one');
        $ki_status_label = ($ki_active && $ai_plugin_active) ? '🟢 ' . esc_html__('Aktiv', 'macher-one') : '🔴 ' . esc_html__('Deaktiviert', 'macher-one');
        ?>
        <div class="wrap macher-dashboard">
            <?php echo wp_kses_post(macher_one_get_header_html()); ?>

            <div class="macher-dashboard-grid" style="display: flex; flex-wrap: wrap; gap: 30px; align-items: flex-start;">
                <div class="macher-modules" style="flex: 1 1 60%; display: flex; flex-direction: column; gap: 30px;">
                    <form method="post">
                        <?php wp_nonce_field('macher_dashboard_save', 'macher_dashboard_nonce'); ?>

                        <!-- Backend Login Modul -->
                        <div class="macher-module-card" style="background:#fff; border:1px solid #ccd0d4; padding:20px; border-radius:8px;">
                            <div class="macher-module-header" style="display:flex; justify-content:space-between; align-items:center;">
                                <h2><?php echo esc_html__('Backend Login', 'macher-one'); ?></h2>
                                <span class="macher-status"><?php echo esc_html($backend_status_label); ?></span>
                            </div>
                            <p><?php echo esc_html__('Passe den Loginbereich deiner WordPress-Website individuell an.', 'macher-one'); ?></p>
                            <label>
                                <input type="checkbox" name="macher_backend_login_enabled" value="1" <?php checked($backend_active); ?> />
                                <?php echo esc_html__('Modul aktivieren', 'macher-one'); ?>
                            </label>
                        </div>

                        <!-- KI Label Modul -->
                        <?php if ($ai_plugin_installed): ?>
                            <div class="macher-module-card" style="background:#fff; border:1px solid #ccd0d4; padding:20px; border-radius:8px;">
                                <div class="macher-module-header" style="display:flex; justify-content:space-between; align-items:center;">
                                    <h2><?php echo esc_html__('KI Label', 'macher-one'); ?></h2>
                                    <span class="macher-status"><?php echo esc_html($ki_status_label); ?></span>
                                </div>
                                <p><?php echo esc_html__('Verwalte globale Einstellungen für KI-Bilder (Position, Stil, Text).', 'macher-one'); ?></p>
                                <label>
                                    <input type="checkbox" name="macher_ki_media_enabled" value="1" <?php checked($ki_active); ?> />
                                    <?php echo esc_html__('Modul aktivieren', 'macher-one'); ?>
                                </label>
                            </div>
                        <?php endif; ?>

                        <!-- Buttons -->
                        <div class="macher-buttons" style="margin-top:15px;">
                            <?php submit_button(esc_html__('Speichern', 'macher-one'), 'primary', 'submit', false); ?>
                            <?php if ($ki_active && $ai_plugin_active): ?>
                                <a href="<?php echo esc_url(admin_url('admin.php?page=macher-settings&tab=ki-media')); ?>" class="button">
                                    <?php echo esc_html__('Einstellungen', 'macher-one'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <!-- Pinnwand -->
                <div class="macher-pinboard" style="flex: 1 1 35%; background:#f9f9f9; border:1px solid #ccd0d4; padding:20px; border-radius:8px;">
                    <h2><?php echo esc_html__('Pinnwand', 'macher-one'); ?></h2>
                    <p><?php echo esc_html__('Was du als Nächstes von der MACHER.one Suite erwarten kannst:', 'macher-one'); ?></p>
                    <ul style="margin-left: 1.2em; list-style: disc;">
                        <li>
                            <?php echo esc_html__('Mehr Anpassungsmöglichkeiten beim Backend-Login-Modul.', 'macher-one'); ?>
                            <br><span style="font-size: 12px; color: #666;"><?php echo esc_html__('Geplant für:', 'macher-one'); ?> 01.05.2025</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    }
}
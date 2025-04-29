<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'admin-header.php';

class Macher_Dashboard {
    public static function render_dashboard() {
        if (
            isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' &&
            isset($_POST['macher_dashboard_nonce']) &&
            wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['macher_dashboard_nonce'])), 'macher_dashboard_save')
        ) {
            update_option('macher_backend_login_enabled', isset($_POST['macher_backend_login_enabled']) ? '1' : '0');

            add_action('admin_notices', function () {
                echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Einstellungen gespeichert.', 'macher-one') . '</p></div>';
            });
        }

        $active = get_option('macher_backend_login_enabled', false);
        $status_label = $active ? '🟢 ' . esc_html__('Aktiv', 'macher-one') : '🔴 ' . esc_html__('Deaktiviert', 'macher-one');
        ?>
        <div class="wrap macher-dashboard">
        <?php echo wp_kses_post( macher_one_get_header_html() ); ?>

            <div class="macher-dashboard-grid" style="display: flex; flex-wrap: wrap; gap: 30px; align-items: flex-start;">
                <div class="macher-modules" style="flex: 1 1 60%; display: flex; flex-direction: column; gap: 30px;">
                    
                    <!-- Backend Login Modul -->
                    <div class="macher-module-card" style="background:#fff; border:1px solid #ccd0d4; padding:20px; border-radius:8px;">
                        <div class="macher-module-header" style="display:flex; justify-content:space-between; align-items:center;">
                            <h2><?php echo esc_html__('Backend Login', 'macher-one'); ?></h2>
                            <span class="macher-status"><?php echo esc_html($status_label); ?></span>
                        </div>
                        <p><?php echo esc_html__('Passe den Loginbereich deiner WordPress-Website individuell an.', 'macher-one'); ?></p>
                        <form method="post">
                            <?php wp_nonce_field('macher_dashboard_save', 'macher_dashboard_nonce'); ?>
                            <label>
                                <input type="checkbox" name="macher_backend_login_enabled" value="1" <?php checked($active); ?> />
                                <?php echo esc_html__('Modul aktivieren', 'macher-one'); ?>
                            </label>
                            <div class="macher-buttons" style="margin-top:15px;">
                                <?php submit_button(esc_html__('Speichern', 'macher-one'), 'primary', 'submit', false); ?>
                                <?php if ($active): ?>
                                    <a href="<?php echo esc_url(admin_url('admin.php?page=macher-settings#tab-2')); ?>" class="button">
                                        <?php echo esc_html__('Einstellungen', 'macher-one'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>

                    <!-- KI Medien Modul (nur wenn Plugin aktiv) -->
                    <?php
                    include_once ABSPATH . 'wp-admin/includes/plugin.php';

                    if (is_plugin_active('m1-ai-label/m1-ai-label.php')) :
                        $ki_active = get_option('macher_ki_media_enabled', false);
                        $ki_status_label = $ki_active ? '🟢 ' . esc_html__('Aktiv', 'macher-one') : '🔴 ' . esc_html__('Deaktiviert', 'macher-one');
                        ?>
                        <div class="macher-module-card" style="background:#fff; border:1px solid #ccd0d4; padding:20px; border-radius:8px;">
                            <div class="macher-module-header" style="display:flex; justify-content:space-between; align-items:center;">
                                <h2><?php echo esc_html__('KI Medien', 'macher-one'); ?></h2>
                                <span class="macher-status"><?php echo esc_html($ki_status_label); ?></span>
                            </div>
                            <p><?php echo esc_html__('Verwalte globale Einstellungen für KI-Bilder (Position, Stil, Text).', 'macher-one'); ?></p>
                            <form method="post">
                                <?php wp_nonce_field('macher_dashboard_save', 'macher_dashboard_nonce'); ?>
                                <label>
                                    <input type="checkbox" name="macher_ki_media_enabled" value="1" <?php checked($ki_active); ?> />
                                    <?php echo esc_html__('Modul aktivieren', 'macher-one'); ?>
                                </label>
                                <div class="macher-buttons" style="margin-top:15px;">
                                    <?php submit_button(esc_html__('Speichern', 'macher-one'), 'primary', 'submit', false); ?>
                                    <?php if ($ki_active): ?>
                                        <a href="<?php echo esc_url(admin_url('admin.php?page=macher-settings&tab=ki-media')); ?>" class="button">
                                            <?php echo esc_html__('Einstellungen', 'macher-one'); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>


                </div>

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
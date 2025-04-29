<?php
if (!defined('ABSPATH')) {
    exit;
}

function macher_one_get_header_html() {
    ob_start();
    ?>
    <div class="macher-suite-header" style="text-align:center; margin-bottom:40px;">
        <?php
        $logo_path = MACHER_PLUGIN_URL . 'assets/images/logo-dermacher-one-dark.webp';
        if (file_exists(MACHER_PLUGIN_DIR . 'assets/images/logo-dermacher-one-dark.webp')) :
        ?>
            <a href="https://macher.one" target="_blank" rel="noopener noreferrer" style="display:inline-block;">
                <img src="<?php echo esc_url($logo_path); ?>" alt="<?php echo esc_attr__('MACHER.one Logo', 'macher-one'); ?>" />
            </a>
        <?php endif; ?>
        <h2><?php echo esc_html__('Die Suite für Profis', 'macher-one'); ?></h2>
        <p><?php echo esc_html__('Verwalte alle verfügbaren Module und Einstellungen zentral über dieses Panel.', 'macher-one'); ?></p>
    </div>
    <?php
    return ob_get_clean();
}
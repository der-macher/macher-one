<?php
if (!defined('ABSPATH')) {
    exit;
}

function macher_one_get_header_html() {
    ob_start();
    ?>
    <div class="macher-suite-header" style="text-align:center; margin-bottom:40px;">
        <a href="https://macher.one" target="_blank" rel="noopener noreferrer" style="display:inline-block;">
            <div style="
                height: 60px;
                margin-bottom: 10px;
                background-image: url('<?php echo esc_url('https://macher.one/wp-content/uploads/2025/03/logo-dermacher-one-dark.webp'); ?>');
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center;
                width: 240px;
                margin-left: auto;
                margin-right: auto;
            " title="<?php echo esc_attr__('MACHER.one Logo', 'macher-one'); ?>"></div>
        </a>
        <h2 style="margin: 0;"><?php echo esc_html__('Die Suite für Profis', 'macher-one'); ?></h2>
        <p style="font-size: 14px;"><?php echo esc_html__('Verwalte alle verfügbaren Module und Einstellungen zentral über dieses Panel.', 'macher-one'); ?></p>
    </div>
    <?php
    return ob_get_clean();
}
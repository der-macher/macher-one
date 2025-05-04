<?php
if (!defined('ABSPATH')) {
    exit;
}

$includes = [
    'includes/settings.php',
    'admin/pages/settings.php',
    'admin/modules/backend-login.php',
];

foreach ($includes as $file) {
    $path = MACHER_PLUGIN_DIR . $file;
    if (file_exists($path)) {
        require_once $path;
    }
}

// KI Label Optionen registrieren
add_action('admin_init', function () {
    register_setting('macher_ki_media_settings', 'macher_ki_rename_enabled');
    register_setting('macher_ki_media_settings', 'macher_ki_debug_enabled');
});
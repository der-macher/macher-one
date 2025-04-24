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
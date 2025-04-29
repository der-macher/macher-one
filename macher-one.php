<?php
/*
Plugin Name: MACHER.one
Description: MACHER.one suite is a core plugin for centrally managing backend modules.
Version: 1.2.1
Author: MACHER
Author URI: https://www.macher.one
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: macher-one
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit;
}

// Plugin-Konstanten definieren
define('MACHER_INTEGRATED', true);
define('MACHER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MACHER_PLUGIN_URL', plugin_dir_url(__FILE__));

// Backend: Menü und Module laden
require_once MACHER_PLUGIN_DIR . 'includes/menu-container.php';

// Backend CSS-Klasse für spezielles Layout (nur Adminbereich!)
add_filter('admin_body_class', 'macher_add_body_class');
function macher_add_body_class($classes) {
    if (is_admin()) {
        $screen = get_current_screen();
        if ($screen && $screen->id === 'toplevel_page_macher-dashboard') {
            $classes .= ' admin-macher';
        }
    }
    return $classes;
}

// Module und Frontend-Styling laden
require_once MACHER_PLUGIN_DIR . 'frontend/login-style.php';
require_once MACHER_PLUGIN_DIR . 'includes/init.php';

// Font Awesome global laden (wenn aktiv)
add_action('wp_enqueue_scripts', 'macher_enqueue_fontawesome_global', 5);
add_action('admin_enqueue_scripts', 'macher_enqueue_fontawesome_global', 5);

function macher_enqueue_fontawesome_global() {
    if (get_option('macher_fontawesome_global')) {
        wp_enqueue_style(
            'macher-fontawesome-global',
            MACHER_PLUGIN_URL . 'assets/fontawesome/css/all.min.css',
            array(),
            '6.5.0'
        );
    }
}
<?php
if (!defined('ABSPATH')) {
    exit;
}

// Lade das Dashboard-Modul
require_once plugin_dir_path(__FILE__) . 'dashboard.php';

class Macher_Menu_Container {
    public function __construct() {
        add_action('admin_menu', array($this, 'build_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('admin_menu', array($this, 'remove_duplicate_menu_item'), 1000);
    }

    public function enqueue_assets($hook_suffix) {
        // Admin-Styles (immer)
        wp_enqueue_style(
            'macher-admin-style',
            MACHER_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            '1.0.0'
        );
    
        wp_enqueue_media();
    
        wp_enqueue_script(
            'macher-backend-login-js',
            MACHER_PLUGIN_URL . 'assets/js/backend-login.js',
            array('jquery'),
            '1.0.0',
            true
        );
    
        wp_localize_script('macher-backend-login-js', 'macherLoginTexts', array(
            'title'  => __('Wähle ein Login-Logo', 'macher-one'),
            'button' => __('Logo verwenden', 'macher-one'),
        ));
    
        // Tabs – IMMER LADEN (Debug/Test) — später wieder einschränken
        wp_enqueue_style(
            'macher-tabs-style',
            MACHER_PLUGIN_URL . 'assets/css/tabs.css',
            array(),
            '1.0.0'
        );
    
        wp_enqueue_script(
            'macher-tabs-js',
            MACHER_PLUGIN_URL . 'assets/js/tabs.js',
            array('jquery'),
            '1.0.0',
            true
        );

        wp_enqueue_style(
            'macher-fontawesome',
            MACHER_PLUGIN_URL . 'assets/fontawesome/css/all.min.css',
            array(),
            '6.5.0'
        );        
    }
    

    public function build_menu() {
        // Top-Level-Menüpunkt "macher.one"
        add_menu_page(
            esc_html__('macher.one', 'macher-one'),
            esc_html__('macher.one', 'macher-one'),
            'manage_options',
            'macher-container',
            '__return_null', // Kein Inhalt auf Top-Level, reiner Container
            'dashicons-admin-tools',
            2
        );

        // Untermenü "Dashboard" – immer vorhanden
        add_submenu_page(
            'macher-container',
            __('Übersicht', 'macher-one'),
            __('Übersicht', 'macher-one'),
            'manage_options',
            'macher-dashboard',
            array('Macher_Dashboard', 'render_dashboard'),
            1
        );

        // Untermenü "Einstellungen"
        add_submenu_page(
            'macher-container',
            __('Einstellungen', 'macher-one'),
            __('Einstellungen', 'macher-one'),
            'manage_options',
            'macher-settings',
            'macher_one_render_settings_page'
        );        

        // Kind-Plugins können eigene Menüs registrieren
        do_action('macher_register_submenus');
    }

    public function remove_duplicate_menu_item() {
        remove_submenu_page('macher-container', 'macher-container');
    }
}

new Macher_Menu_Container();
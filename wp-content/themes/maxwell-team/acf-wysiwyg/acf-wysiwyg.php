<?php
/**
 * ACF WYSIWYG Custom Addons
 * 
 * Dodaje font size i color opcije u ACF WYSIWYG editor
 */

// Sprečavamo direktan pristup
if (!defined('ABSPATH')) {
    exit;
}

class ACF_WYSIWYG_Custom_Addons {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->init_hooks();
    }
    
    private function init_hooks() {
        // TinyMCE dugmad
        add_filter('mce_buttons', array($this, 'add_custom_buttons'));
        add_filter('mce_external_plugins', array($this, 'add_custom_plugins'));
        
        // Editor stilovi
        add_action('admin_enqueue_scripts', array($this, 'add_editor_styles'));
        
        // Frontend stilovi
        add_action('wp_enqueue_scripts', array($this, 'add_frontend_styles'));
        
        // Inicijalizacija TinyMCE podešavanja
        add_filter('tiny_mce_before_init', array($this, 'customize_tinymce_settings'));
    }
    
    /**
     * Dodavanje custom dugmadi u TinyMCE toolbar
     */
    public function add_custom_buttons($buttons) {
        // Dodajemo dugmad na početak toolbara
        array_unshift($buttons, 'koritim_fontsize', 'koritim_color');
        return $buttons;
    }
    
    /**
     * Registrovanje custom TinyMCE plugina
     */
    public function add_custom_plugins($plugins) {
        $plugin_url = get_stylesheet_directory_uri() . '/acf-wysiwyg/js/tinymce-koritim.js';
        $plugins['koritim_fontsize'] = $plugin_url;
        $plugins['koritim_color'] = $plugin_url;
        return $plugins;
    }
    
    /**
     * Dodavanje stilova za admin editor
     */
    public function add_editor_styles() {
        add_editor_style(get_stylesheet_directory_uri() . '/acf-wysiwyg/css/editor-style.css');
    }
    
    /**
     * Dodavanje stilova za frontend
     */
    public function add_frontend_styles() {
        wp_enqueue_style(
            'acf-wysiwyg-custom-styles',
            get_stylesheet_directory_uri() . '/acf-wysiwyg/css/frontend-style.css',
            array(),
            '1.0.0'
        );
    }
    
    /**
     * Customizacija TinyMCE podešavanja
     */
    public function customize_tinymce_settings($settings) {
        // Dodajemo custom klase u format dropdown ako je potrebno
        $style_formats = array(
            array(
                'title' => 'Font Size',
                'items' => array(
                    array(
                        'title' => 'Small',
                        'selector' => 'p',
                        'classes' => 'text-sm',
                    ),
                    array(
                        'title' => 'Medium',
                        'selector' => 'p',
                        'classes' => 'text-lg',
                    ),
                    array(
                        'title' => 'Large',
                        'selector' => 'p',
                        'classes' => 'text-xl',
                    ),
                    array(
                        'title' => 'Extra Large',
                        'selector' => 'p',
                        'classes' => 'text-2xl',
                    ),
                ),
            ),
            array(
                'title' => 'Color',
                'items' => array(
                    array(
                        'title' => 'Background',
                        'selector' => 'p',
                        'classes' => 'text-background',
                    ),
                    array(
                        'title' => 'Foreground',
                        'selector' => 'p',
                        'classes' => 'text-foreground',
                    ),
                    array(
                        'title' => 'Primary',
                        'selector' => 'p',
                        'classes' => 'text-primary',
                    ),
                    array(
                        'title' => 'Secondary',
                        'selector' => 'p',
                        'classes' => 'text-secondary',
                    ),
                    array(
                        'title' => 'Muted',
                        'selector' => 'p',
                        'classes' => 'text-muted',
                    ),
                    array(
                        'title' => 'Accent',
                        'selector' => 'p',
                        'classes' => 'text-accent',
                    ),
                ),
            ),
        );
        
        // Spajamo sa postojećim formatima ako postoje
        if (isset($settings['style_formats'])) {
            $existing_formats = json_decode($settings['style_formats'], true);
            $style_formats = array_merge($existing_formats, $style_formats);
        }
        
        $settings['style_formats'] = json_encode($style_formats);
        
        return $settings;
    }
}

// Inicijalizacija klase
ACF_WYSIWYG_Custom_Addons::get_instance();
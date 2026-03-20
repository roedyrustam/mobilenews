<?php
/**
 * Theme Setup and Widget Registration
 */

if (!defined('ABSPATH')) {
    exit;
}

function mobilenews_setup()
{
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Title tag support
    add_theme_support('title-tag');

    // Post thumbnails
    add_theme_support('post-thumbnails');

    // Custom logo
    add_theme_support('custom-logo', array(
        'height' => 60,
        'width' => 240,
        'flex-height' => true,
        'flex-width' => true,
        'header-text' => array('site-title', 'site-description'),
    ));


    // Block Editor Styles
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_editor_style(array('assets/css/main.css', 'assets/css/blocks.css'));

    // Modern Design Tools (WP 6.x)
    add_theme_support('appearance-tools');
    add_theme_support('border');
    add_theme_support('link-color');
    add_theme_support('spacing');
    add_theme_support('custom-spacing');
    add_theme_support('custom-line-height');


    // HTML5 Support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
        'navigation-widgets',
    ));


    // Register Navigation Menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'mobilenews'),
        'footer' => __('Footer Menu', 'mobilenews'),
        'mobile' => __('Mobile Menu', 'mobilenews'),
    ));

    // Load text domain for translations
    load_theme_textdomain('mobilenews', get_template_directory() . '/languages');

    // Advanced Gutenberg Support
    add_theme_support('editor-color-palette', array(
        array('name' => 'Primary', 'slug' => 'primary', 'color' => '#168098'),
        array('name' => 'Dark', 'slug' => 'dark', 'color' => '#09090b'),
        array('name' => 'Light', 'slug' => 'light', 'color' => '#f8fafc'),
        array('name' => 'Accent', 'slug' => 'accent', 'color' => '#fbbf24'),
    ));

    add_theme_support('editor-font-sizes', array(
        array('name' => 'Small', 'slug' => 'small', 'size' => 12),
        array('name' => 'Normal', 'slug' => 'normal', 'size' => 16),
        array('name' => 'Large', 'slug' => 'large', 'size' => 24),
        array('name' => 'Huge', 'slug' => 'huge', 'size' => 48),
    ));

    // Support for selective refresh in customizer
    add_theme_support('customize-selective-refresh-widgets');
}
add_action('after_setup_theme', 'mobilenews_setup');


// Include Custom Widgets classes
require_once get_template_directory() . '/inc/widgets.php';

/**
 * Register widget area and custom widgets.
 */
function mobilenews_widgets_init()
{
    register_sidebar(
        array(
            'name' => esc_html__('Main Sidebar', 'mobilenews'),
            'id' => 'main-sidebar',
            'description' => esc_html__('Add widgets here.', 'mobilenews'),
            'before_widget' => '<div id="%1$s" class="widget %2$s mb-8 bg-white dark:bg-zinc-900 dark:text-white p-6 rounded-2xl border border-gray-100 dark:border-zinc-800 shadow-sm">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget-title text-xl font-black mb-6 flex items-center gap-2 border-b border-gray-100 dark:border-gray-800 pb-3">',
            'after_title' => '</h2>',
        )
    );

    register_sidebar(array(
        'name' => esc_html__('Footer Column 1', 'mobilenews'),
        'id' => 'footer-1',
        'description' => esc_html__('Widgets for the first footer column (Branding/About).', 'mobilenews'),
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="font-bold text-lg mb-4 text-white">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Column 2', 'mobilenews'),
        'id' => 'footer-2',
        'description' => esc_html__('Widgets for the second footer column (Categories).', 'mobilenews'),
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="font-bold text-lg mb-4 text-white">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Column 3', 'mobilenews'),
        'id' => 'footer-3',
        'description' => esc_html__('Widgets for the third footer column (Company/Info).', 'mobilenews'),
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="font-bold text-lg mb-4 text-white">',
        'after_title' => '</h4>',
    ));

    // Register Custom Widgets
    register_widget('MobileNews_Weather_Widget');
    register_widget('MobileNews_Trending_Widget');
    register_widget('MobileNews_Post_List_Widget');
    register_widget('MobileNews_Author_Widget');
    register_widget('MobileNews_Newsletter_Widget');
    register_widget('MobileNews_Social_Follow_Widget');
}
add_action('widgets_init', 'mobilenews_widgets_init');

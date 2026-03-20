<?php
/**
 * Enqueue scripts and styles.
 */

if (!defined('ABSPATH')) {
    exit;
}

function mobilenews_scripts()
{
    // Google Fonts
    $heading_font = function_exists('mobilenews_get_option') ? mobilenews_get_option('heading_font', 'Epilogue') : get_theme_mod('mobilenews_heading_font', 'Epilogue');
    $body_font = function_exists('mobilenews_get_option') ? mobilenews_get_option('body_font', 'Noto Sans') : get_theme_mod('mobilenews_body_font', 'Noto Sans');
    
    // Fallback load
    wp_enqueue_style('mobilenews-fonts', 'https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;700;800&family=Noto+Sans:wght@400;500;700&display=swap', array(), null);
    wp_enqueue_style('mobilenews-icons', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap', array(), null);
    wp_enqueue_style('remix-icon', 'https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css', array(), '4.2.0');

    // Main Stylesheet
    wp_enqueue_style('mobilenews-style', get_stylesheet_uri());

    // Custom Main CSS
    wp_enqueue_style('mobilenews-main', get_template_directory_uri() . '/assets/css/main.css', array(), filemtime(get_template_directory() . '/assets/css/main.css'));

    // Block Styles
    wp_enqueue_style('mobilenews-blocks', get_template_directory_uri() . '/assets/css/blocks.css', array(), filemtime(get_template_directory() . '/assets/css/blocks.css'));


    // Main JS
    wp_enqueue_script('mobilenews-main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), filemtime(get_template_directory() . '/assets/js/main.js'), true);


    // Comment Reply Script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }


    // Pass AJAX URL and Settings to script
    wp_localize_script('mobilenews-main-js', 'mobilenews_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('mobilenews_nonce'),
        'weather_api_key' => esc_js(mobilenews_get_option('weather_api_key')),
        'bottom_nav_autohide' => esc_js(mobilenews_get_option('bottom_nav_autohide', true))
    ));


    // Inline Custom Styles from Customizer or Theme Options
    $primary_color_fetch = function_exists('mobilenews_get_option') ? mobilenews_get_option('primary_color', '#168098') : get_theme_mod('mobilenews_primary_color', '#168098');
    $secondary_color = function_exists('mobilenews_get_option') ? mobilenews_get_option('secondary_color', '#1e293b') : get_theme_mod('mobilenews_secondary_color', '#1e293b');
    $header_bg = function_exists('mobilenews_get_option') ? mobilenews_get_option('header_bg', '#ffffff') : get_theme_mod('mobilenews_header_bg', '#ffffff');
    $body_bg = function_exists('mobilenews_get_option') ? mobilenews_get_option('body_bg', '#f3f4f6') : get_theme_mod('mobilenews_body_bg', '#f3f4f6');
    $border_radius = function_exists('mobilenews_get_option') ? mobilenews_get_option('border_radius', '0.4') : get_theme_mod('mobilenews_border_radius', '0.4');
    $site_width = function_exists('mobilenews_get_option') ? mobilenews_get_option('site_width', '1280') : get_theme_mod('mobilenews_site_width', '1280');


    // Dynamic Font Loading
    $fonts_to_load = array_unique([$heading_font, $body_font]);
    foreach ($fonts_to_load as $font_name) {
        $font_id = 'mobilenews-font-' . strtolower(str_replace(' ', '-', $font_name));
        wp_enqueue_style($font_id, 'https://fonts.googleapis.com/css2?family=' . urlencode($font_name) . ':wght@400;500;700;800&display=swap', array(), null);
    }
    
    // Convert hex to rgb for effects
    $primary_rgb = '59, 130, 246'; // fallback
    if (preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $primary_color_fetch)) {
        $hex = str_replace('#', '', $primary_color_fetch);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $primary_rgb = "$r, $g, $b";
    }

    $custom_css = "
        :root {
            --color-primary: " . esc_attr($primary_color_fetch) . ";
            --color-primary-rgb: {$primary_rgb};
            --color-secondary: " . esc_attr($secondary_color) . ";

            --bg-header: " . esc_attr($header_bg) . ";
            --bg-light: " . esc_attr($body_bg) . ";
            --font-heading: '" . esc_attr($heading_font) . "', sans-serif;
            --font-body: '" . esc_attr($body_font) . "', sans-serif;
            --radius-md: " . esc_attr($border_radius) . "rem;
            --site-max-width: " . absint($site_width) . "px;
        }
        body {
            background-color: var(--bg-light);
            font-family: var(--font-body);
        }
        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: var(--font-heading);
        }
        .site-header {
            background-color: var(--bg-header);
        }
        .container, .max-w-\\[1200px\\] {
            max-width: var(--site-max-width) !important;
        }
        .rounded-xl, .rounded-2xl {
             border-radius: var(--radius-md);
        }

        /* === Logo Auto-Sizing === */
        /* Desktop top-row: Logo is centered, allow generous size */
        .site-header .custom-logo-link {
            display: flex;
            align-items: center;
            line-height: 1;
        }
        .site-header .custom-logo {
            display: block;
            width: auto;
            height: auto;
            max-height: 60px;
            max-width: 220px;
            object-fit: contain;
            transition: opacity 0.2s ease;
        }
        /* Mobile row: keep logo compact */
        @media (max-width: 1279px) {
            .site-branding .custom-logo {
                max-height: 36px;
                max-width: 130px;
            }
        }
        /* Hover effect */
        .site-header .custom-logo-link:hover .custom-logo {
            opacity: 0.85;
        }
    ";

    wp_add_inline_style('mobilenews-main', wp_strip_all_tags($custom_css));
}
add_action('wp_enqueue_scripts', 'mobilenews_scripts');

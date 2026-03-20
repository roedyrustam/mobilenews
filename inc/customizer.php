<?php
/**
 * Mobile News Customizer
 *
 * @package MobileNews
 */

function mobilenews_customize_register($wp_customize)
{
    // --- Colors Section ---
    // WordPress has a built-in 'colors' section, we will use it.

    // 1. Primary Color
    $wp_customize->add_setting('mobilenews_primary_color', array(
        'default' => '#3b82f6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh', // or 'postMessage' for JS updates
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mobilenews_primary_color', array(
        'label' => __('Primary Color', 'mobilenews'),
        'section' => 'colors',
        'settings' => 'mobilenews_primary_color',
    )));

    // 2. Secondary Color
    $wp_customize->add_setting('mobilenews_secondary_color', array(
        'default' => '#1e293b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mobilenews_secondary_color', array(
        'label' => __('Secondary Color', 'mobilenews'),
        'section' => 'colors',
        'settings' => 'mobilenews_secondary_color',
    )));

    // 3. Header Background
    $wp_customize->add_setting('mobilenews_header_bg', array(
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mobilenews_header_bg', array(
        'label' => __('Header Background', 'mobilenews'),
        'section' => 'colors',
        'settings' => 'mobilenews_header_bg',
    )));

    // 4. Body Background
    $wp_customize->add_setting('mobilenews_body_bg', array(
        'default' => '#f3f4f6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mobilenews_body_bg', array(
        'label' => __('Body Background', 'mobilenews'),
        'section' => 'colors',
        'settings' => 'mobilenews_body_bg',
    )));

    // --- Header Options ---
    $wp_customize->add_section('mobilenews_header_options', array(
        'title' => __('Header Options', 'mobilenews'),
        'priority' => 120,
    ));

    // Dark Mode Toggle Logic (Optional Visibility)
    $wp_customize->add_setting('mobilenews_show_dark_mode', array(
        'default' => true,
        'sanitize_callback' => 'mobilenews_sanitize_checkbox',
    ));

    $wp_customize->add_control('mobilenews_show_dark_mode', array(
        'label' => __('Show Dark Mode Toggle', 'mobilenews'),
        'section' => 'mobilenews_header_options',
        'settings' => 'mobilenews_show_dark_mode',
        'type' => 'checkbox',
    ));

    // Header options like Dark Mode toggle remain here, but logo is moved to Site Identity.


    // --- Typography Section ---
    $wp_customize->add_section('mobilenews_typography_options', array(
        'title' => __('Typography', 'mobilenews'),
        'priority' => 130,
    ));

    // 1. Heading Font Family
    $wp_customize->add_setting('mobilenews_heading_font', array(
        'default' => 'Epilogue',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('mobilenews_heading_font', array(
        'label' => __('Heading Font Family', 'mobilenews'),
        'section' => 'mobilenews_typography_options',
        'type' => 'select',
        'choices' => array(
            'Epilogue' => 'Epilogue (Modern)',
            'Inter' => 'Inter (Sans)',
            'Outfit' => 'Outfit (Trendy)',
            'Playfair Display' => 'Playfair Display (Serif)',
        ),
    ));

    // 2. Body Font Family
    $wp_customize->add_setting('mobilenews_body_font', array(
        'default' => 'Noto Sans',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('mobilenews_body_font', array(
        'label' => __('Body Font Family', 'mobilenews'),
        'section' => 'mobilenews_typography_options',
        'type' => 'select',
        'choices' => array(
            'Noto Sans' => 'Noto Sans',
            'Inter' => 'Inter',
            'Roboto' => 'Roboto',
            'System' => 'System Stack',
        ),
    ));

    // --- Layout Section ---
    $wp_customize->add_section('mobilenews_layout_options', array(
        'title' => __('Layout & Global Styles', 'mobilenews'),
        'priority' => 140,
    ));

    // 1. Border Radius Intensity
    $wp_customize->add_setting('mobilenews_border_radius', array(
        'default' => '0.4', // 0.4rem
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('mobilenews_border_radius', array(
        'label' => __('Border Radius Intensity (rem)', 'mobilenews'),
        'section' => 'mobilenews_layout_options',
        'type' => 'range',
        'input_attrs' => array(
            'min' => 0,
            'max' => 2,
            'step' => 0.1,
        ),
    ));

    // 2. Site Max Width
    $wp_customize->add_setting('mobilenews_site_width', array(
        'default' => '1280',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('mobilenews_site_width', array(
        'label' => __('Site Max Width (px)', 'mobilenews'),
        'section' => 'mobilenews_layout_options',
        'type' => 'number',
    ));

    // 3. Bottom Navigation Auto-hide
    $wp_customize->add_setting('mobilenews_bottom_nav_autohide', array(
        'default' => true,
        'sanitize_callback' => 'mobilenews_sanitize_checkbox',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('mobilenews_bottom_nav_autohide', array(
        'label' => __('Auto-hide Bottom Nav on Scroll', 'mobilenews'),
        'section' => 'mobilenews_layout_options',
        'type' => 'checkbox',
    ));


    // --- Footer Section ---
    $wp_customize->add_section('mobilenews_footer_options', array(
        'title' => __('Footer Settings', 'mobilenews'),
        'priority' => 150,
    ));

    // 1. Copyright Text
    $wp_customize->add_setting('mobilenews_copyright_text', array(
        'default' => '© 2026 Mobile News. All rights reserved.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('mobilenews_copyright_text', array(
        'label' => __('Copyright Text', 'mobilenews'),
        'section' => 'mobilenews_footer_options',
        'type' => 'text',
    ));

    // Footer copyright remains here.


    // --- Single Post Options ---
    $wp_customize->add_section('mobilenews_single_options', array(
        'title' => __('Single Post Settings', 'mobilenews'),
        'priority' => 155,
    ));

    // 1. Show Social Share after content
    $wp_customize->add_setting('mobilenews_show_social_share_bottom', array(
        'default' => true,
        'sanitize_callback' => 'mobilenews_sanitize_checkbox',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('mobilenews_show_social_share_bottom', array(
        'label' => __('Show Social Share After Content', 'mobilenews'),
        'section' => 'mobilenews_single_options',
        'type' => 'checkbox',
    ));


    // --- SEO & Social Section ---
    $wp_customize->add_section('mobilenews_seo_options', array(
        'title' => __('SEO & Social', 'mobilenews'),
        'priority' => 160,
    ));

    // 1. Default OpenGraph Image
    $wp_customize->add_setting('mobilenews_default_og_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mobilenews_default_og_image', array(
        'label' => __('Default OpenGraph Image', 'mobilenews'),
        'section' => 'mobilenews_seo_options',
        'settings' => 'mobilenews_default_og_image',
    )));

    // 2. Twitter Username
    $wp_customize->add_setting('mobilenews_twitter_username', array(
        'default' => '@mobilenews',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('mobilenews_twitter_username', array(
        'label' => __('Twitter Username', 'mobilenews'),
        'section' => 'mobilenews_seo_options',
        'type' => 'text',
    ));
}
add_action('customize_register', 'mobilenews_customize_register');

/**
 * Sanitize Checkbox
 */
function mobilenews_sanitize_checkbox($checked)
{
    return ((isset($checked) && true == $checked) ? true : false);
}

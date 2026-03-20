<?php
/**
 * Mobile News Theme Options
 */

// 1. Register Settings
if (!defined('ABSPATH')) {
    exit;
}

function mobilenews_theme_settings_init()
{
    // Check if Settings API is available
    if (!function_exists('is_admin') || !is_admin() || !function_exists('add_settings_section') || !function_exists('register_setting') || !function_exists('add_settings_field') || !function_exists('get_option')) {
        return;
    }

    register_setting('mobilenews_theme_options', 'mobilenews_theme_options', 'mobilenews_theme_options_sanitize');

    // --- Section: API Settings ---
    add_settings_section('mobilenews_theme_section_api', 'API Settings', 'mobilenews_theme_section_api_cb', 'mobilenews_theme_options');
    add_settings_field('google_maps_api_key', 'Google Maps API Key', 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_api', ['label_for' => 'google_maps_api_key']);
    add_settings_field('weather_api_key', 'OpenWeatherMap API Key', 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_api', ['label_for' => 'weather_api_key']);
    add_settings_field('recaptcha_site_key', 'ReCaptcha Site Key', 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_api', ['label_for' => 'recaptcha_site_key']);
    add_settings_field('recaptcha_secret_key', 'ReCaptcha Secret Key', 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_api', ['label_for' => 'recaptcha_secret_key']);

    // --- Section: Analytics ---
    add_settings_section('mobilenews_theme_section_analytics', 'Analytics & Scripts', 'mobilenews_theme_section_analytics_cb', 'mobilenews_theme_options');
    add_settings_field('header_scripts', 'Header Scripts', 'mobilenews_theme_field_textarea_code_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_analytics', ['label_for' => 'header_scripts']);
    add_settings_field('footer_scripts', 'Footer Scripts', 'mobilenews_theme_field_textarea_code_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_analytics', ['label_for' => 'footer_scripts']);

    // --- Section: Feature Management ---
    add_settings_section('mobilenews_theme_section_features', 'Feature Management', 'mobilenews_theme_section_features_cb', 'mobilenews_theme_options');
    add_settings_field('enable_live_streaming', 'Enable Live Streaming Button', 'mobilenews_theme_field_checkbox_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_features', ['label_for' => 'enable_live_streaming']);
    add_settings_field('live_streaming_url', 'Live Streaming Page URL', 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_features', ['label_for' => 'live_streaming_url']);
    add_settings_field('enable_citizen_news', 'Enable Citizen News Button', 'mobilenews_theme_field_checkbox_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_features', ['label_for' => 'enable_citizen_news']);
    add_settings_field('citizen_news_url', 'Citizen News Page URL', 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_features', ['label_for' => 'citizen_news_url']);
    add_settings_field('subscribe_url', 'Subscribe Button URL', 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_features', ['label_for' => 'subscribe_url']);

    // --- Section: Social Media ---
    add_settings_section('mobilenews_theme_section_social', 'Social Media Links', 'mobilenews_theme_section_social_cb', 'mobilenews_theme_options');
    $socials = ['facebook', 'twitter', 'instagram', 'youtube', 'tiktok'];
    foreach ($socials as $social) {
        add_settings_field('social_' . $social, ucfirst($social) . ' URL', 'mobilenews_theme_field_social_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_social', ['label_for' => 'social_' . $social]);
    }

    // --- Section: Contact Info ---
    add_settings_section('mobilenews_theme_section_contact', 'Contact Information', 'mobilenews_theme_section_contact_cb', 'mobilenews_theme_options');
    add_settings_field('contact_email', 'Email Address', 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_contact', ['label_for' => 'contact_email']);
    add_settings_field('contact_phone', 'Phone Number', 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_contact', ['label_for' => 'contact_phone']);
    add_settings_field('contact_address', 'Office Address', 'mobilenews_theme_field_textarea_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_contact', ['label_for' => 'contact_address']);

    // --- Section: Footer & Legal ---
    add_settings_section('mobilenews_theme_section_footer', 'Footer & Legal Settings', 'mobilenews_theme_section_footer_cb', 'mobilenews_theme_options');

    add_settings_field('footer_about', 'About Us Text', 'mobilenews_theme_field_textarea_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_footer', ['label_for' => 'footer_about']);
    add_settings_field('footer_copyright', 'Copyright Text', 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_footer', ['label_for' => 'footer_copyright']);
    add_settings_field('privacy_policy_url', 'Privacy Policy URL', 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_footer', ['label_for' => 'privacy_policy_url']);
    add_settings_field('terms_url', 'Terms of Service URL', 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_footer', ['label_for' => 'terms_url']);

    // --- Section: General ---
    add_settings_section('mobilenews_theme_section_general', 'General Settings', 'mobilenews_theme_section_general_cb', 'mobilenews_theme_options');

    add_settings_field('sticky_header', 'Enable Sticky Header', 'mobilenews_theme_field_checkbox_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_general', ['label_for' => 'sticky_header']);

    // --- Section: Visual Style ---
    add_settings_section('mobilenews_theme_section_style', 'Visual Style', 'mobilenews_theme_section_style_cb', 'mobilenews_theme_options');
    add_settings_field('primary_color', 'Primary Color', 'mobilenews_theme_field_color_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_style', ['label_for' => 'primary_color']);
    add_settings_field('heading_font', 'Heading Font', 'mobilenews_theme_field_font_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_style', ['label_for' => 'heading_font']);
    add_settings_field('body_font', 'Body Font', 'mobilenews_theme_field_font_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_style', ['label_for' => 'body_font']);

    // --- Section: News Ticker ---
    add_settings_section('mobilenews_theme_section_ticker', 'Breaking News Ticker', 'mobilenews_theme_section_ticker_cb', 'mobilenews_theme_options');
    add_settings_field('ticker_enable', 'Enable Ticker', 'mobilenews_theme_field_checkbox_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_ticker', ['label_for' => 'ticker_enable']);
    add_settings_field('ticker_title', 'Ticker Title', 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_ticker', ['label_for' => 'ticker_title']);
    add_settings_field('ticker_category', 'Filter by Category', 'mobilenews_theme_field_category_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_ticker', ['label_for' => 'ticker_category']);
    add_settings_field('ticker_count', 'Number of Posts', 'mobilenews_theme_field_number_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_ticker', ['label_for' => 'ticker_count']);

    // --- Section: SEO Settings ---
    add_settings_section('mobilenews_theme_section_seo', 'SEO & OpenGraph', 'mobilenews_theme_section_seo_cb', 'mobilenews_theme_options');
    add_settings_field('default_og_image', 'Default OG Image (URL)', 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_seo', ['label_for' => 'default_og_image']);

    // --- Section: Mobile Layout ---
    add_settings_section('mobilenews_theme_section_mobile', 'Mobile Layout Settings', 'mobilenews_theme_section_mobile_cb', 'mobilenews_theme_options');
    add_settings_field('mobile_compact_mode', 'Enable Compact Header & Nav', 'mobilenews_theme_field_checkbox_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_mobile', ['label_for' => 'mobile_compact_mode']);

    // --- Section: Trending Settings ---
    add_settings_section('mobilenews_theme_section_trending', 'Trending Settings', 'mobilenews_theme_section_trending_cb', 'mobilenews_theme_options');
    add_settings_field('trending_category_id', 'Trending Category', 'mobilenews_theme_field_category_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_trending', ['label_for' => 'trending_category_id']);

    // --- Section: Single Post Settings ---
    add_settings_section('mobilenews_theme_section_single', 'Single Post Settings', 'mobilenews_theme_section_single_cb', 'mobilenews_theme_options');
    add_settings_field('single_show_progress_bar', 'Show Reading Progress Bar', 'mobilenews_theme_field_checkbox_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_single', ['label_for' => 'single_show_progress_bar']);
    add_settings_field('single_show_author_meta', 'Show Author Meta', 'mobilenews_theme_field_checkbox_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_single', ['label_for' => 'single_show_author_meta']);
    add_settings_field('single_show_reading_time', 'Show Estimated Reading Time', 'mobilenews_theme_field_checkbox_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_single', ['label_for' => 'single_show_reading_time']);
    add_settings_field('single_show_related_posts', 'Show Related Posts', 'mobilenews_theme_field_checkbox_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_single', ['label_for' => 'single_show_related_posts']);
    add_settings_field('single_related_posts_count', 'Related Posts Count', 'mobilenews_theme_field_number_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_single', ['label_for' => 'single_related_posts_count']);

    // --- Section: Archive Settings ---
    add_settings_section('mobilenews_theme_section_archive', 'Archive Settings', 'mobilenews_theme_section_archive_cb', 'mobilenews_theme_options');
    add_settings_field('archive_layout', 'Archive Layout', 'mobilenews_theme_field_select_layout_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_archive', ['label_for' => 'archive_layout']);
    add_settings_field('archive_show_excerpt', 'Show Post Excerpt', 'mobilenews_theme_field_checkbox_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_archive', ['label_for' => 'archive_show_excerpt']);

    // --- Section: GitHub Update ---
    add_settings_section('mobilenews_theme_section_update', 'GitHub Update Settings', 'mobilenews_theme_section_update_cb', 'mobilenews_theme_options');
    add_settings_field('github_repo', 'GitHub Repository', 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_update', ['label_for' => 'github_repo']);
    add_settings_field('github_token', 'GitHub Access Token', 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_update', ['label_for' => 'github_token']);

    // --- Section: Homepage Settings ---
    add_settings_section('mobilenews_theme_section_homepage', 'Homepage Customization', 'mobilenews_theme_section_homepage_cb', 'mobilenews_theme_options');
    add_settings_field('homepage_hero_enable', 'Enable Hero Grid', 'mobilenews_theme_field_checkbox_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_homepage', ['label_for' => 'homepage_hero_enable']);
    add_settings_field('homepage_hero_category', 'Hero Grid Category', 'mobilenews_theme_field_category_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_homepage', ['label_for' => 'homepage_hero_category']);
    add_settings_field('homepage_spotlight_enable', 'Enable Category Spotlight', 'mobilenews_theme_field_checkbox_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_homepage', ['label_for' => 'homepage_spotlight_enable']);
    add_settings_field('homepage_spotlight_cat1', 'Spotlight Category 1', 'mobilenews_theme_field_category_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_homepage', ['label_for' => 'homepage_spotlight_cat1']);
    add_settings_field('homepage_spotlight_cat2', 'Spotlight Category 2', 'mobilenews_theme_field_category_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_homepage', ['label_for' => 'homepage_spotlight_cat2']);
    add_settings_field('homepage_local_news_enable', 'Enable Local News (Sekitarmu)', 'mobilenews_theme_field_checkbox_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_homepage', ['label_for' => 'homepage_local_news_enable']);

    // --- Section: Ads Management ---
    add_settings_section('mobilenews_theme_section_ads', 'Advertisement Management', 'mobilenews_theme_section_ads_cb', 'mobilenews_theme_options');
    
    add_settings_field('ads_enable_mock', 'Enable Ad Placeholders (Mock Ads)', 'mobilenews_theme_field_checkbox_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_ads', [
        'label_for' => 'ads_enable_mock'
    ]);

    $ad_slots = [
        'header' => 'Header Ad',
        'below_ticker' => 'Below Ticker Ad',
        'sidebar' => 'Sidebar Ad',
        'after_title' => 'After Title Ad',
        'after_content' => 'After Content Ad',
        'in_article' => 'In-Article Ad',
        'sticky_footer' => 'Sticky Footer Ad'
    ];

    foreach ($ad_slots as $slot => $label) {
        // 1. Ad Type (Code vs Image)
        add_settings_field("ads_{$slot}_type", "{$label} Type", 'mobilenews_theme_field_radio_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_ads', [
            'label_for' => "ads_{$slot}_type",
            'options' => ['code' => 'HTML/JS Code', 'image' => 'Banner Image']
        ]);

        // 2. Ad Code
        add_settings_field("ads_{$slot}", "{$label} Code", 'mobilenews_theme_field_textarea_code_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_ads', [
            'label_for' => "ads_{$slot}",
            'class' => "ad-code-field ad-slot-{$slot}"
        ]);

        // 3. Ad Image
        add_settings_field("ads_{$slot}_image", "{$label} Image", 'mobilenews_theme_field_image_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_ads', [
            'label_for' => "ads_{$slot}_image",
            'class' => "ad-image-field ad-slot-{$slot}"
        ]);

        // 4. Ad URL
        add_settings_field("ads_{$slot}_url", "{$label} Destination URL", 'mobilenews_theme_field_text_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_ads', [
            'label_for' => "ads_{$slot}_url",
            'class' => "ad-url-field ad-slot-{$slot}"
        ]);
    }

    add_settings_field("ads_in_article_paragraph", "In-Article Ad Paragraph Frequency", 'mobilenews_theme_field_number_cb', 'mobilenews_theme_options', 'mobilenews_theme_section_ads', [
        'label_for' => "ads_in_article_paragraph",
        'class' => "ad-frequency-field ad-slot-in_article"
    ]);



}
add_action('admin_init', 'mobilenews_theme_settings_init');

/**
 * Enqueue Admin Scripts & Styles
 */
function mobilenews_admin_scripts($hook)
{
    if ($hook != 'toplevel_page_mobilenews_theme_options') {
        return;
    }

    // Enqueue Google Fonts
    wp_enqueue_style('mobilenews-admin-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap', array(), null);

    // Enqueue Color Picker
    wp_enqueue_style('wp-color-picker');

    // Enqueue Admin CSS & JS
    wp_enqueue_style('mobilenews-admin-css', get_template_directory_uri() . '/assets/css/admin.css', array(), '2.0.0');
    wp_enqueue_script('mobilenews-admin-js', get_template_directory_uri() . '/assets/js/admin.js', array('jquery', 'wp-color-picker'), '2.0.0', true);

    // WordPress Media Uploader
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'mobilenews_admin_scripts');

// 2. Callbacks
function mobilenews_theme_section_social_cb()
{
    echo '<p class="description">Enter your social media profile URLs.</p>';
}
function mobilenews_theme_section_api_cb()
{
    echo '<p class="description">Configure external API keys for widget integrations.</p>';
}
function mobilenews_theme_section_analytics_cb()
{
    echo '<p class="description">Insert tracking codes (Google Analytics, GTM) or custom JavaScript here.</p>';
}
function mobilenews_theme_section_features_cb()
{
    echo '<p class="description">Toggle special theme features and manage their links.</p>';
}
function mobilenews_theme_section_contact_cb()
{
    echo '<p class="description">Details for the Contact page and Header/Footer.</p>';
}
function mobilenews_theme_section_footer_cb()
{
    echo '<p class="description">Customize your footer content.</p>';
}
function mobilenews_theme_section_general_cb()
{
    echo '<p class="description">General styling and behavior options.</p>';
}
function mobilenews_theme_section_style_cb()
{
    echo '<p class="description">Customize the visual appearance of your theme.</p>';
}
function mobilenews_theme_section_ticker_cb()
{
    echo '<p class="description">Configure the Breaking News ticker in the header.</p>';
}
function mobilenews_theme_section_seo_cb()
{
    echo '<p class="description">Global settings for SEO and social sharing fallbacks.</p>';
}
function mobilenews_theme_section_mobile_cb()
{
    echo '<p class="description">Manage how the site appears on mobile devices.</p>';
}
function mobilenews_theme_section_trending_cb()
{
    echo '<p class="description">Select the category to use for trending links.</p>';
}
function mobilenews_theme_section_single_cb()
{
    echo '<p class="description">Control elements visible on single article pages.</p>';
}
function mobilenews_theme_section_archive_cb()
{
    echo '<p class="description">Global settings for category and tag archive pages.</p>';
}
function mobilenews_theme_section_update_cb()
{
    echo '<p class="description">Configure GitHub repository for automatic theme updates.</p>';
}
function mobilenews_theme_section_homepage_cb()
{
    echo '<p class="description">Manage sections and categories displayed on your homepage.</p>';
}
function mobilenews_theme_section_ads_cb()
{
    echo '<p class="description">Place your advertisement codes (AdSense, etc.) here.</p>';
}


// Field Callbacks
function mobilenews_theme_field_social_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('mobilenews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
    echo '<input type="url" name="mobilenews_theme_options[' . esc_attr($args['label_for']) . ']" value="' . esc_attr($val) . '" class="regular-text" placeholder="https://...">';
}
function mobilenews_theme_field_text_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('mobilenews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
    echo '<input type="text" name="mobilenews_theme_options[' . esc_attr($args['label_for']) . ']" value="' . esc_attr($val) . '" class="regular-text">';
}
function mobilenews_theme_field_textarea_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('mobilenews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
    echo '<textarea name="mobilenews_theme_options[' . esc_attr($args['label_for']) . ']" rows="5" cols="50" class="large-text">' . esc_textarea($val) . '</textarea>';
}
function mobilenews_theme_field_textarea_code_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('mobilenews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
    echo '<textarea name="mobilenews_theme_options[' . esc_attr($args['label_for']) . ']" rows="8" cols="50" class="large-text code" placeholder="<script>...</script>">' . esc_textarea($val) . '</textarea>';
    echo '<p class="description">Code will be output exactly as entered.</p>';
}
function mobilenews_theme_field_checkbox_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('mobilenews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : false;
    echo '<input type="hidden" name="mobilenews_theme_options[' . esc_attr($args['label_for']) . ']" value="0">';
    echo '<input type="checkbox" name="mobilenews_theme_options[' . esc_attr($args['label_for']) . ']" value="1" ' . checked(1, $val, false) . '>';
}
function mobilenews_theme_field_number_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('mobilenews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '5';
    echo '<input type="number" name="mobilenews_theme_options[' . esc_attr($args['label_for']) . ']" value="' . esc_attr($val) . '" class="small-text" min="1" max="20">';
}
function mobilenews_theme_field_category_cb($args)
{
    if (!function_exists('get_option') || !function_exists('get_categories')) {
        return;
    }
    $options = get_option('mobilenews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
    $cats = get_categories();
    echo '<select name="mobilenews_theme_options[' . esc_attr($args['label_for']) . ']">';
    echo '<option value="">-- All Categories --</option>';
    foreach ($cats as $cat) {
        echo '<option value="' . esc_attr($cat->term_id) . '" ' . selected($val, $cat->term_id, false) . '>' . esc_html($cat->name) . '</option>';
    }
    echo '</select>';
}
function mobilenews_theme_field_color_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('mobilenews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '#168098';
    echo '<input type="text" name="mobilenews_theme_options[' . esc_attr($args['label_for']) . ']" value="' . esc_attr($val) . '" class="mobilenews-color-picker" data-default-color="#168098">';
}
function mobilenews_theme_field_font_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('mobilenews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : 'Epilogue';
    $fonts = ['Epilogue', 'Inter', 'Noto Sans', 'Lora', 'Roboto', 'Open Sans', 'Merriweather'];
    echo '<select name="mobilenews_theme_options[' . esc_attr($args['label_for']) . ']">';
    foreach ($fonts as $font) {
        echo '<option value="' . esc_attr($font) . '" ' . selected($val, $font, false) . '>' . esc_html($font) . '</option>';
    }
    echo '</select>';
}
function mobilenews_theme_field_radio_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('mobilenews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : array_key_first($args['options']);
    
    echo '<div class="mobilenews-radio-group">';
    foreach ($args['options'] as $key => $label) {
        echo '<label class="mobilenews-radio-item">';
        echo '<input type="radio" name="mobilenews_theme_options[' . esc_attr($args['label_for']) . ']" value="' . esc_attr($key) . '" ' . checked($val, $key, false) . '>';
        echo '<span>' . esc_html($label) . '</span>';
        echo '</label>';
    }
    echo '</div>';
}
function mobilenews_theme_field_image_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('mobilenews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
    
    echo '<div class="mobilenews-media-control">';
    echo '<div class="mobilenews-media-preview">';
    if (!empty($val)) {
        $image_attributes = wp_get_attachment_image_src($val, 'medium');
        if ($image_attributes) {
            echo '<img src="' . esc_url($image_attributes[0]) . '" style="max-width:200px; display:block; margin-bottom:10px; border-radius:8px; border:1px solid #ddd;">';
        }
    }
    echo '</div>';
    echo '<input type="hidden" name="mobilenews_theme_options[' . esc_attr($args['label_for']) . ']" value="' . esc_attr($val) . '" class="mobilenews-media-id-input">';
    echo '<button type="button" class="button mobilenews-image-upload-btn">Select Image</button> ';
    echo '<button type="button" class="button mobilenews-image-remove-btn text-red-500">Remove</button>';
    echo '</div>';
}
function mobilenews_theme_field_select_layout_cb($args)
{
    if (!function_exists('get_option')) {
        return;
    }
    $options = get_option('mobilenews_theme_options');
    $val = isset($options[$args['label_for']]) ? $options[$args['label_for']] : 'list';
    echo '<select name="mobilenews_theme_options[' . esc_attr($args['label_for']) . ']">';
    echo '<option value="list" ' . selected($val, 'list', false) . '>List View</option>';
    echo '<option value="grid" ' . selected($val, 'grid', false) . '>Grid View</option>';
    echo '</select>';
}

// 3. Admin Menu
function mobilenews_theme_options_page()
{
    if (!function_exists('add_menu_page')) {
        return;
    }
    add_menu_page('Mobile News', 'Mobile News', 'manage_options', 'mobilenews_theme_options', 'mobilenews_theme_options_page_html', 'dashicons-layout', 2);
    add_submenu_page('mobilenews_theme_options', 'General Settings', 'General Settings', 'manage_options', 'mobilenews_theme_options', 'mobilenews_theme_options_page_html');
}
add_action('admin_menu', 'mobilenews_theme_options_page');

// 4. Render Page (Tabbed Interface)
function mobilenews_theme_options_page_html()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    // Defensive check: Ensure Settings API functions are available
    if (!function_exists('settings_fields') || !function_exists('do_settings_sections')) {
        return;
    }
    ?>
    <div class="wrap mobilenews-admin-wrap">
        <?php settings_errors(); ?>
        <div class="mobilenews-admin-header">
            <h1><?php echo esc_html__('Mobile News Settings', 'mobilenews'); ?></h1>
            <span class="version">v2.0.0</span>
        </div>


        <div class="mobilenews-admin-main">
            <div class="mobilenews-admin-sidebar">
                <div class="mobilenews-admin-tabs">
                    <button type="button" class="mobilenews-tab-link active" data-tab="general"><span class="dashicons dashicons-admin-generic"></span> General</button>
                    <button type="button" class="mobilenews-tab-link" data-tab="homepage"><span class="dashicons dashicons-admin-home"></span> Homepage</button>

                    <button type="button" class="mobilenews-tab-link" data-tab="style"><span class="dashicons dashicons-admin-appearance"></span> Style</button>
                    <button type="button" class="mobilenews-tab-link" data-tab="seo"><span class="dashicons dashicons-search"></span> SEO</button>
                    <button type="button" class="mobilenews-tab-link" data-tab="single"><span class="dashicons dashicons-media-text"></span> Single Post</button>
                    <button type="button" class="mobilenews-tab-link" data-tab="archive"><span class="dashicons dashicons-layout"></span> Archive</button>
                    <button type="button" class="mobilenews-tab-link" data-tab="mobile"><span class="dashicons dashicons-smartphone"></span> Mobile</button>
                    <button type="button" class="mobilenews-tab-link" data-tab="trending"><span class="dashicons dashicons-chart-line"></span> Trending</button>
                    <button type="button" class="mobilenews-tab-link" data-tab="ads"><span class="dashicons dashicons-megaphone"></span> Ads</button>
                    <button type="button" class="mobilenews-tab-link" data-tab="ticker"><span class="dashicons dashicons-sos"></span> Ticker</button>
                    <button type="button" class="mobilenews-tab-link" data-tab="features"><span class="dashicons dashicons-star-filled"></span> Features</button>
                    <button type="button" class="mobilenews-tab-link" data-tab="social"><span class="dashicons dashicons-share"></span> Social</button>
                    <button type="button" class="mobilenews-tab-link" data-tab="contact"><span class="dashicons dashicons-email"></span> Contact</button>
                    <button type="button" class="mobilenews-tab-link" data-tab="footer"><span class="dashicons dashicons-editor-insertmore"></span> Footer</button>
                    <button type="button" class="mobilenews-tab-link" data-tab="updates"><span class="dashicons dashicons-update"></span> Updates</button>
                </div>

            </div>

            <div class="mobilenews-admin-content">
                <!-- Main Settings Form -->
                <form action="options.php" method="post" id="mobilenews-theme-form">
                    <?php settings_fields('mobilenews_theme_options'); ?>

                    <!-- General Tab -->
                    <div id="general" class="mobilenews-tab-content active">
                        <?php mobilenews_do_settings_section('mobilenews_theme_options', 'mobilenews_theme_section_general'); ?>
                    </div>

                    <!-- Homepage Tab -->
                    <div id="homepage" class="mobilenews-tab-content">
                        <?php mobilenews_do_settings_section('mobilenews_theme_options', 'mobilenews_theme_section_homepage'); ?>
                    </div>

                    <!-- Visual Style Tab -->
                    <div id="style" class="mobilenews-tab-content">
                        <?php mobilenews_do_settings_section('mobilenews_theme_options', 'mobilenews_theme_section_style'); ?>
                    </div>

                    <!-- SEO Tab -->
                    <div id="seo" class="mobilenews-tab-content">
                        <?php mobilenews_do_settings_section('mobilenews_theme_options', 'mobilenews_theme_section_seo'); ?>
                    </div>

                    <!-- Single Post Tab -->
                    <div id="single" class="mobilenews-tab-content">
                        <?php mobilenews_do_settings_section('mobilenews_theme_options', 'mobilenews_theme_section_single'); ?>
                    </div>

                    <!-- Archive Layout Tab -->
                    <div id="archive" class="mobilenews-tab-content">
                        <?php mobilenews_do_settings_section('mobilenews_theme_options', 'mobilenews_theme_section_archive'); ?>
                    </div>

                    <!-- Mobile Layout Tab -->
                    <div id="mobile" class="mobilenews-tab-content">
                        <?php mobilenews_do_settings_section('mobilenews_theme_options', 'mobilenews_theme_section_mobile'); ?>
                    </div>

                    <!-- Trending Tab -->
                    <div id="trending" class="mobilenews-tab-content">
                        <?php mobilenews_do_settings_section('mobilenews_theme_options', 'mobilenews_theme_section_trending'); ?>
                    </div>

                    <!-- News Ticker Tab -->
                    <div id="ticker" class="mobilenews-tab-content">
                        <?php mobilenews_do_settings_section('mobilenews_theme_options', 'mobilenews_theme_section_ticker'); ?>
                    </div>

                    <!-- Features Tab -->
                    <div id="features" class="mobilenews-tab-content">
                        <?php mobilenews_do_settings_section('mobilenews_theme_options', 'mobilenews_theme_section_features'); ?>
                    </div>

                    <!-- Social Media Tab -->
                    <div id="social" class="mobilenews-tab-content">
                        <?php mobilenews_do_settings_section('mobilenews_theme_options', 'mobilenews_theme_section_social'); ?>
                    </div>

                    <!-- Contact Tab -->
                    <div id="contact" class="mobilenews-tab-content">
                        <?php mobilenews_do_settings_section('mobilenews_theme_options', 'mobilenews_theme_section_contact'); ?>
                    </div>

                    <!-- Footer Tab -->
                    <div id="footer" class="mobilenews-tab-content">
                        <?php mobilenews_do_settings_section('mobilenews_theme_options', 'mobilenews_theme_section_footer'); ?>
                    </div>

                    <!-- API Tab -->
                    <div id="api" class="mobilenews-tab-content">
                        <?php mobilenews_do_settings_section('mobilenews_theme_options', 'mobilenews_theme_section_api'); ?>
                    </div>

                    <!-- Analytics Tab -->
                    <div id="analytics" class="mobilenews-tab-content">
                        <?php mobilenews_do_settings_section('mobilenews_theme_options', 'mobilenews_theme_section_analytics'); ?>
                    </div>
                </form>

                <!-- Updates Tab (Separate action for checking updates) -->
                <div id="updates" class="mobilenews-tab-content">
                    <h2><?php echo esc_html__('Theme Updates', 'mobilenews'); ?></h2>
                    <div class="mobilenews-update-card bg-white dark:bg-zinc-800 p-6 rounded-xl border border-gray-100 dark:border-zinc-700 shadow-sm mt-4">
                        <p class="mb-4 text-gray-600 dark:text-gray-400">
                            <?php echo esc_html__('Check for new versions of the Mobile News theme directly from the GitHub repository.', 'mobilenews'); ?>
                        </p>
                        <p class="mb-6">
                            <strong><?php echo esc_html__('Current Repository:', 'mobilenews'); ?></strong> 
                            <code>https://github.com/roedyrustam/mobilenews</code>
                        </p>
                        
                        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                            <?php wp_nonce_field('mobilenews_check_updates_nonce'); ?>
                            <input type="hidden" name="action" value="mobilenews_check_updates">
                            <button type="submit" class="button button-primary button-large">
                                <span class="dashicons dashicons-update-alt" style="vertical-align: middle; margin-right: 5px;"></span>
                                <?php echo esc_html__('Check for Updates Now', 'mobilenews'); ?>
                            </button>
                        </form>

                        <?php if (isset($_GET['update_check']) && $_GET['update_check'] === 'done'): ?>
                            <div class="updated notice is-dismissible mt-4" style="margin-left:0; margin-top:20px;">
                                <p><?php echo esc_html__('Update check completed. If a new version is available, you will see a notice in the standard WordPress updates area (Dashboard > Updates).', 'mobilenews'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Ads Manager Tab -->
                <div id="ads" class="mobilenews-tab-content">
                    <?php mobilenews_do_settings_section('mobilenews_theme_options', 'mobilenews_theme_section_ads'); ?>
                </div>
            </div>
        </div>

        <!-- Global Save Bar -->
        <div class="mobilenews-admin-save-bar">
            <div class="save-bar-info">
                <span class="dashicons dashicons-info"></span>
                <p><?php echo esc_html__('Remember to save your changes after modifying settings.', 'mobilenews'); ?></p>
            </div>
            <div class="save-bar-actions">
                <!-- Use JS to submit the correct form based on active tab, but primary focus is mobilenews-theme-form -->
                <button type="submit" form="mobilenews-theme-form" class="button button-primary button-large"><?php echo esc_html__('Save Theme Settings', 'mobilenews'); ?></button>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Custom Helper to render a specific settings section
 */
function mobilenews_do_settings_section($page, $section_id)
{
    global $wp_settings_sections, $wp_settings_fields;

    if (!isset($wp_settings_sections[$page][$section_id]))
        return;

    $section = $wp_settings_sections[$page][$section_id];

    if ($section['title'])
        echo "<h2>{$section['title']}</h2>\n";

    if ($section['callback'])
        call_user_func($section['callback'], $section);

    if (!isset($wp_settings_fields[$page][$section_id]))
        return;

    echo '<table class="form-table" role="presentation">';
    do_settings_fields($page, $section['id']);
    echo '</table>';
}

/**
 * Sanitize all theme options
 */
function mobilenews_theme_options_sanitize($input)
{
    $output = array();
    if (!is_array($input)) {
        return $output;
    }

    foreach ($input as $key => $value) {
        // Handle different field types based on key
        if (strpos($key, 'scripts') !== false || strpos($key, 'ads') !== false) {
            // Allow code in scripts and ads sections
            $output[$key] = $value; // We trust the admin for these
        } elseif (is_numeric($value)) {
            $output[$key] = intval($value);
        } elseif (strpos($key, 'url') !== false) {
            $output[$key] = esc_url_raw($value);
        } elseif (strpos($key, 'color') !== false) {
            $output[$key] = sanitize_hex_color($value);
        } else {
            $output[$key] = sanitize_text_field($value);
        }
    }
    return $output;
}

// 5. Helper Function
function mobilenews_get_option($key, $default = '')
{
    if (!function_exists('get_option')) {
        return $default;
    }
    $options = get_option('mobilenews_theme_options');
    
    // Check if key is explicitly saved in DB
    if (is_array($options) && isset($options[$key]) && $options[$key] !== '') {
        return $options[$key];
    }

    // Fallback to get_theme_mod for legacy settings
    if (function_exists('get_theme_mod')) {
        $mod1 = get_theme_mod('mobilenews_' . $key, '');
        if ($mod1 !== '') {
            return $mod1;
        }
        $mod2 = get_theme_mod($key, '');
        if ($mod2 !== '') {
            return $mod2;
        }
    }

    return $default;
}



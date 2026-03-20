<?php
/**
 * AJAX Handlers for Mobile News
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle Local News AJAX
 */
function mobilenews_get_local_news()
{
    check_ajax_referer('mobilenews_nonce', 'nonce');

    $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';

    // Automatic GEO Detection if no city provided
    if (empty($city)) {
        $user_ip = $_SERVER['REMOTE_ADDR'];
        // Basic GEO API (ip-api.com)
        $response = wp_remote_get("http://ip-api.com/json/" . $user_ip);
        if (!is_wp_error($response)) {
            $data = json_decode(wp_remote_retrieve_body($response));
            if ($data && isset($data->status) && $data->status === 'success') {
                $city = $data->city ?? '';
            }
        }
    }

    // If city is provided, try to find posts with that tag or category
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 4,
        'post_status' => 'publish',
    );

    if (!empty($city)) {
        // Try to match tag slug or name
        $args['tax_query'] = array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'post_tag',
                'field' => 'name',
                'terms' => $city, // e.g., "Jakarta"
            ),
            array(
                'taxonomy' => 'category',
                'field' => 'name',
                'terms' => $city,
            ),
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', 'card', array('layout' => 'grid'));

        }
        wp_reset_postdata();
    } else {
        echo '<p class="no-local-news">Belum ada berita spesifik untuk wilayah ' . esc_html($city) . '. Menampilkan berita nasional terkini.</p>';
        // Fallback to latest news
        $fallback_args = array(
            'post_type' => 'post',
            'posts_per_page' => 4,
            'ignore_sticky_posts' => 1
        );
        $fallback_query = new WP_Query($fallback_args);
        if ($fallback_query->have_posts()) {
            while ($fallback_query->have_posts()) {
                $fallback_query->the_post();
                get_template_part('template-parts/content', 'card', array('layout' => 'grid'));

            }
        }
        wp_reset_postdata();
    }

    wp_die();
}
add_action('wp_ajax_get_local_news', 'mobilenews_get_local_news');
add_action('wp_ajax_nopriv_get_local_news', 'mobilenews_get_local_news');


/**
 * Handle Citizen News Submission Form
 */
function mobilenews_handle_citizen_submission()
{
    // 1. Verify Nonce & Permissions
    if (!isset($_POST['citizen_news_nonce']) || !wp_verify_nonce($_POST['citizen_news_nonce'], 'citizen_news_submission')) {
        wp_die('Security check failed');
    }

    // 2. Sanitize Input
    $title = sanitize_text_field($_POST['news_title']);
    $content = sanitize_textarea_field($_POST['news_content']);
    $category_name = sanitize_text_field($_POST['news_category']);
    $location = sanitize_text_field($_POST['news_location']);
    $tags = sanitize_text_field($_POST['news_tags']);
    $anonymous = isset($_POST['post_anonymous']);

    // 3. Prepare Post Data
    $post_data = array(
        'post_title' => $title,
        'post_content' => $content . "\n\n<!-- Location: " . sanitize_text_field($location) . " -->",
        'post_status' => 'draft', // Always draft for review
        'post_type' => 'post',
        'post_author' => $anonymous ? 0 : get_current_user_id()
    );

    // 4. Insert Post
    $post_id = wp_insert_post($post_data);

    if ($post_id) {
        // Set Category
        $cat = get_term_by('name', $category_name, 'category');
        if ($cat) {
            wp_set_post_categories($post_id, array($cat->term_id));
        }

        // Set Tags
        if (!empty($tags)) {
            wp_set_post_tags($post_id, $tags);
        }

        // Handle File Upload
        if (!empty($_FILES['news_image']['name'])) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');

            $attachment_id = media_handle_upload('news_image', $post_id);
            if (!is_wp_error($attachment_id)) {
                set_post_thumbnail($post_id, $attachment_id);
            }
        }

        // Redirect back with success message
        wp_redirect(add_query_arg('submission', 'success', wp_get_referer()));
        exit;
    } else {
        wp_die('Error creating post.');
    }
}
add_action('admin_post_submit_citizen_news', 'mobilenews_handle_citizen_submission');
add_action('admin_post_nopriv_submit_citizen_news', 'mobilenews_handle_citizen_submission'); // Allow non-logged-in users

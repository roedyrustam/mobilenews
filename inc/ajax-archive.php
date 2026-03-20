<?php
/**
 * AJAX Handler for Archive Filtering
 */

function mobilenews_ajax_filter_archive()
{
    // 1. Verify Nonce
    check_ajax_referer('mobilenews_nonce', 'nonce');

    // 2. Get Params
    $cat_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $tag_id = isset($_POST['tag_id']) ? sanitize_text_field($_POST['tag_id']) : '';
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $is_home = isset($_POST['is_home']) && $_POST['is_home'] === 'true';

    // 3. Query Args
    $args = array(
        'post_status' => 'publish',
        'paged' => $paged,
        'posts_per_page' => 5, // Match homepage count
        'ignore_sticky_posts' => 1
    );

    // If on homepage, we need to handle the initial offset of 10
    if ($is_home) {
        $args['offset'] = 10 + (($paged - 1) * 5);
        $args['paged'] = 1; // When using offset, handle paged manually
    }

    if ($cat_id > 0) {
        $args['cat'] = $cat_id;
    }

    // Handle Tag Filter
    if (!empty($tag_id) && $tag_id !== 'all') {
        $args['tag_id'] = intval($tag_id);
    }

    $query = new WP_Query($args);

    // 4. Output
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', 'stream');
        }
    } else {
        if ($paged === 1) {
            echo '<p class="text-center text-gray-500 mt-8">Tidak ada berita ditemukan.</p>';
        }
    }

    wp_reset_postdata();
    wp_die();
}

add_action('wp_ajax_mobilenews_filter_archive', 'mobilenews_ajax_filter_archive');
add_action('wp_ajax_nopriv_mobilenews_filter_archive', 'mobilenews_ajax_filter_archive');

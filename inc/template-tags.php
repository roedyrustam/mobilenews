<?php
/**
 * Custom template tags for this theme.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display Breadcrumbs
 */
if (!function_exists('mobilenews_breadcrumbs')) {
    function mobilenews_breadcrumbs() {
        if (is_front_page()) {
            return;
        }

        echo '<nav class="flex items-center gap-2 mb-6 text-sm overflow-hidden whitespace-nowrap overflow-ellipsis">';
        echo '<a class="text-primary font-medium hover:underline shrink-0" href="' . esc_url(home_url('/')) . '">Beranda</a>';
        echo '<span class="text-gray-400 material-symbols-outlined text-xs shrink-0">chevron_right</span>';

        if (is_single()) {
            $categories = get_the_category();
            if (!empty($categories)) {
                echo '<a class="text-primary font-medium hover:underline shrink-0" href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
                echo '<span class="text-gray-400 material-symbols-outlined text-xs shrink-0">chevron_right</span>';
            }
            echo '<span class="text-gray-500 dark:text-gray-400 truncate">' . get_the_title() . '</span>';
        } elseif (is_page()) {
            echo '<span class="text-gray-500 dark:text-gray-400 truncate">' . get_the_title() . '</span>';
        } elseif (is_category()) {
            echo '<span class="text-gray-500 dark:text-gray-400 truncate">' . single_cat_title('', false) . '</span>';
        } elseif (is_archive()) {
            echo '<span class="text-gray-500 dark:text-gray-400 truncate">' . get_the_archive_title() . '</span>';
        } elseif (is_search()) {
            echo '<span class="text-gray-500 dark:text-gray-400 truncate">Pencarian: ' . get_search_query() . '</span>';
        }

        echo '</nav>';
    }
}

/**
 * Check if YouTube Channel is Live
 * Uses YouTube Data API v3
 */
if (!function_exists('mobilenews_is_youtube_live')) {
    function mobilenews_is_youtube_live() {
        $api_key = mobilenews_get_option('youtube_api_key');
        $channel_id = mobilenews_get_option('youtube_channel_id');

        if (empty($api_key) || empty($channel_id)) {
            return false;
        }

        $transient_key = 'mobilenews_youtube_live_' . md5($channel_id);
        $is_live = get_transient($transient_key);

        if (false === $is_live) {
            $api_url = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId={$channel_id}&type=video&eventType=live&key={$api_key}";
            $response = wp_remote_get($api_url);

            if (is_wp_error($response)) {
                return false;
            }

            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);

            $is_live = (!empty($data['items'])) ? 'yes' : 'no';
            
            // Cache for 15 minutes to avoid API quota limits
            set_transient($transient_key, $is_live, 15 * MINUTE_IN_SECONDS);
        }

        return ($is_live === 'yes');
    }
}

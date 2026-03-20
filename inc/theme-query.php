<?php
/**
 * Main Query Modifiers and Reading Time
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle Custom Query Vars for Sorting
 */
function mobilenews_add_query_vars($vars)
{
    $vars[] = 'sort';
    return $vars;
}
add_filter('query_vars', 'mobilenews_add_query_vars');

/**
 * Modify Main Query based on Sort parameter
 */
function mobilenews_pre_get_posts($query)
{
    if (!is_admin() && $query->is_main_query() && ($query->is_archive() || $query->is_home())) {
        $sort = get_query_var('sort');

        if ('oldest' === $sort) {
            $query->set('order', 'ASC');
            $query->set('orderby', 'date');
        } elseif ('popular' === $sort) {
            // Sorting by comment count as proxy for popularity
            $query->set('orderby', 'comment_count');
        } else {
            // Default to latest
            $query->set('order', 'DESC');
            $query->set('orderby', 'date');
        }
    }
}
add_action('pre_get_posts', 'mobilenews_pre_get_posts');

/**
 * Estimated Reading Time
 */
function mobilenews_estimated_reading_time()
{
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Avg 200 wpm

    if ($reading_time < 1) {
        return '1 min baca';
    }

    return $reading_time . ' min baca';
}

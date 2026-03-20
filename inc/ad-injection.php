<?php
/**
 * Mobile News Ad Injection
 */

if (!defined('ABSPATH')) {
    exit;
}

function mobilenews_inject_in_feed_ads($content)
{
    if (is_single() && !is_admin() && is_main_query()) {
        if (!function_exists('mobilenews_render_ad') || !function_exists('mobilenews_get_option')) {
            return $content;
        }

        $ad_code = mobilenews_render_ad('in_article');
        $frequency = (int) mobilenews_get_option('ads_in_article_paragraph', 3);

        if ($ad_code) {
            $paragraphs = explode('</p>', $content);
            $new_content = '';
            $count = 0;

            foreach ($paragraphs as $index => $paragraph) {
                if (trim($paragraph)) {
                    $new_content .= $paragraph . '</p>';
                    $count++;

                    if ($count > 0 && $count % $frequency === 0) {
                        $new_content .= '<div class="mobilenews-in-feed-ad my-8 text-center flex justify-center container mx-auto">';
                        $new_content .= $ad_code;
                        $new_content .= '</div>';
                    }
                }
            }
            return $new_content;
        }
    }
    return $content;
}
add_filter('the_content', 'mobilenews_inject_in_feed_ads');

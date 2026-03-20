<?php
/**
 * Ad Rendering Helper Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render an ad slot based on theme options
 */
function mobilenews_render_ad($slot) {
    if (!function_exists('mobilenews_get_option')) {
        return '';
    }

    $type = mobilenews_get_option("ads_{$slot}_type", 'code');
    
    if ($type === 'image') {
        $image_id = mobilenews_get_option("ads_{$slot}_image");
        $url = mobilenews_get_option("ads_{$slot}_url");
        
        if (empty($image_id)) {
            return '';
        }

        $image_src = wp_get_attachment_image_src($image_id, 'full');
        if (!$image_src) {
            return '';
        }

        $html = '<div class="mobilenews-image-ad flex justify-center">';
        if (!empty($url)) {
            $html .= '<a href="' . esc_url($url) . '" target="_blank" rel="nofollow">';
        }
        
        $html .= '<img src="' . esc_url($image_src[0]) . '" alt="Advertisement" class="max-w-full h-auto rounded-lg shadow-sm hover:opacity-90 transition-opacity">';
        
        if (!empty($url)) {
            $html .= '</a>';
        }
        $html .= '</div>';
        
        return $html;
    } else {
        // Default to code
        $code = mobilenews_get_option("ads_{$slot}");
        if (empty($code)) {
            return '';
        }
        return '<div class="mobilenews-code-ad flex justify-center">' . $code . '</div>';
    }
}

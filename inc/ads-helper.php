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
    $html = '';
    $has_ad = false;
    
    if ($type === 'image') {
        $image_id = mobilenews_get_option("ads_{$slot}_image");
        $url = mobilenews_get_option("ads_{$slot}_url");
        
        if (!empty($image_id)) {
            $image_src = wp_get_attachment_image_src($image_id, 'full');
            if ($image_src) {
                $has_ad = true;
                $html = '<div class="mobilenews-image-ad flex justify-center w-full my-4">';
                if (!empty($url)) {
                    $html .= '<a href="' . esc_url($url) . '" target="_blank" rel="nofollow">';
                }
                
                $html .= '<img src="' . esc_url($image_src[0]) . '" alt="Advertisement" class="max-w-full h-auto rounded-lg shadow-sm hover:opacity-90 transition-opacity">';
                
                if (!empty($url)) {
                    $html .= '</a>';
                }
                $html .= '</div>';
            }
        }
    } else {
        // Code Ad
        $code = mobilenews_get_option("ads_{$slot}");
        if (!empty(trim($code))) {
            $has_ad = true;
            $html = '<div class="mobilenews-code-ad flex justify-center w-full my-4 overflow-hidden">' . do_shortcode($code) . '</div>';
        }
    }

    // Dynamic Mock Ad Fallback
    if (!$has_ad && mobilenews_get_option('ads_enable_mock', false)) {
        $slot_labels = [
            'header'        => 'Header Ad',
            'below_ticker'  => 'Below Ticker Ad',
            'sidebar'       => 'Sidebar Ad',
            'after_title'   => 'After Title Ad',
            'after_content' => 'After Content Ad',
            'in_article'    => 'In-Article Ad',
            'sticky_footer' => 'Sticky Footer Ad'
        ];
        $label = isset($slot_labels[$slot]) ? $slot_labels[$slot] : 'Ad Space';
        
        // Responsive mock logic: Mobile first sizing, then desktop
        $mock_classes = "flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-800 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-gray-400 font-bold p-4 text-center transition-all mx-auto my-4 w-full ";
        
        if ($slot === 'sidebar') {
            $mock_classes .= "max-w-[300px] min-h-[250px]";
        } elseif ($slot === 'sticky_footer') {
            $mock_classes .= "max-w-[320px] min-h-[50px] !my-0";
        } else {
            // Horizontal banners
            $mock_classes .= "max-w-[728px] min-h-[90px] text-xs sm:text-base";
        }

        $html = '<div class="' . esc_attr($mock_classes) . '">';
        $html .= '<span class="uppercase tracking-wider">' . esc_html($label) . '</span>';
        $html .= '<span class="block text-[10px] sm:text-xs font-normal mt-1 opacity-70">Advertisement Space (Responsive)</span>';
        $html .= '</div>';
    }

    return $html;
}

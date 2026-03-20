<?php
/**
 * Mobile News Block Styles
 */

if (!defined('ABSPATH')) {
    exit;
}

function mobilenews_register_block_styles()
{
    register_block_style(
        'core/group',
        array(
            'name' => 'highlight-box',
            'label' => __('Highlight Box', 'mobilenews'),
        )
    );

    register_block_style(
        'core/quote',
        array(
            'name' => 'news-quote',
            'label' => __('News Quote', 'mobilenews'),
        )
    );
}
add_action('init', 'mobilenews_register_block_styles');

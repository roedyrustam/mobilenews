<?php
/**
 * Mobile News Theme Functions (Bootstrap)
 *
 * This file serves exclusively as a bootstrap load registry based on clean code principles.
 * All logic is strictly separated into the `/inc/` directory.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// 1. Core Config & Options (Must load first for global helpers)
require_once get_template_directory() . '/inc/theme-options.php';
require_once get_template_directory() . '/inc/performance.php';
require_once get_template_directory() . '/inc/schema.php';

// 2. Setup & Structure
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/enqueue-scripts.php';
require_once get_template_directory() . '/inc/class-mobilenews-mega-menu-walker.php';
require_once get_template_directory() . '/inc/class-mobilenews-mobile-walker.php';
require_once get_template_directory() . '/inc/template-tags.php';

// 3. Handlers & Queries
require_once get_template_directory() . '/inc/ajax-handlers.php';
require_once get_template_directory() . '/inc/theme-query.php';
require_once get_template_directory() . '/inc/ajax-archive.php';
require_once get_template_directory() . '/inc/rss-import.php';

// 4. Features & Extensions
require_once get_template_directory() . '/inc/seo.php';
require_once get_template_directory() . '/inc/block-styles.php';
require_once get_template_directory() . '/inc/ads-helper.php';
require_once get_template_directory() . '/inc/ad-injection.php';
require_once get_template_directory() . '/inc/paywall.php';

// 5. Updater Logic
require_once get_template_directory() . '/inc/class-github-updater.php';

// Initialize GitHub Updater utilizing theme options
$github_repo = mobilenews_get_option('github_repo', 'roedyrustam/mobilenews');
if (!empty($github_repo)) {
    $repo_parts = explode('/', $github_repo);
    if (count($repo_parts) === 2) {
        $updater = new MobileNews_GitHub_Updater(__FILE__);
        $updater->set_username($repo_parts[0]);
        $updater->set_repository($repo_parts[1]);
        $updater->authorize(mobilenews_get_option('github_token'));
        $updater->initialize();

        // Handle Manual Update Check
        add_action('admin_post_mobilenews_check_updates', function() use ($updater) {
            check_admin_referer('mobilenews_check_updates_nonce');
            $updater->force_check();
            wp_redirect(add_query_arg(array('page' => 'mobilenews_theme_options', 'update_check' => 'done'), admin_url('admin.php')));
            exit;
        });
    }
}

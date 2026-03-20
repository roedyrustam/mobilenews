<?php
/**
 * The sidebar containing the main widget area
 */

if (!is_active_sidebar('main-sidebar')) {
    return;
}
?>

<aside id="secondary" class="widget-area lg:col-span-4 xl:col-span-3 space-y-8">

    <!-- Wrapper for Sticky Functionality -->
    <div class="sticky top-24 space-y-8">
        <?php
        // Sidebar Ad Slot
        if (function_exists('mobilenews_render_ad')) {
            $sidebar_ad = mobilenews_render_ad('sidebar');
            if (!empty($sidebar_ad)) {
                echo '<div class="mobilenews-ad-sidebar flex justify-center mb-6 overflow-hidden">';
                echo $sidebar_ad;
                echo '</div>';
            }
        }

        dynamic_sidebar('main-sidebar');
        ?>
    </div>
</aside>
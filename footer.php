<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MobileNews
 */

if (!function_exists('mobilenews_get_option')) {
    function mobilenews_get_option($option, $default = '') {
        return get_option('mobilenews_theme_options')[$option] ?? $default;
    }
}
?>

<footer class="bg-white dark:bg-zinc-900 pt-16 pb-32 border-t border-gray-100 dark:border-white/5 transition-colors duration-300">
    <div class="container max-w-[1440px] mx-auto px-4 lg:px-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8 mb-16">
            <!-- Branding & About -->
            <div class="space-y-6">
                <div class="site-branding">
                    <?php if (has_custom_logo()): ?>
                        <?php the_custom_logo(); ?>
                    <?php else: ?>
                        <div class="flex items-center gap-3">
                            <div class="size-10 text-primary">
                                <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.57829 8.57829C5.52816 11.6284 3.451 15.5145 2.60947 19.7452C1.76794 23.9758 2.19984 28.361 3.85056 32.3462C5.50128 36.3314 8.29667 39.7376 11.8832 42.134C15.4698 44.5305 19.6865 45.8096 24 45.8096C28.3135 45.8096 32.5302 44.5305 36.1168 42.134C39.7033 39.7375 42.4987 36.3314 44.1494 32.3462C45.8002 28.361 46.2321 23.9758 45.3905 19.7452C44.549 15.5145 42.4718 11.6284 39.4217 8.57829L24 24L8.57829 8.57829Z" fill="currentColor"></path>
                                </svg>
                            </div>
                            <span class="text-xl font-black tracking-tighter dark:text-white uppercase">
                                <?php bloginfo('name'); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed max-w-xs">
                    <?php echo get_bloginfo('description'); ?>
                </p>
                <div class="flex items-center gap-3">
                    <?php
                    $socials = array('facebook', 'twitter', 'instagram', 'youtube');
                    foreach ($socials as $social):
                        $url = mobilenews_get_option('social_' . $social);
                        if ($url):
                            ?>
                            <a href="<?php echo esc_url($url); ?>" class="size-10 rounded-xl bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-400 hover:text-primary hover:bg-primary/10 transition-all duration-300">
                                <i class="ri-<?php echo $social === 'twitter' ? 'twitter-x' : $social; ?>-fill text-lg"></i>
                            </a>
                        <?php endif; endforeach; ?>
                </div>
            </div>

            <!-- Footer Menus -->
            <?php if (is_active_sidebar('footer-1')): ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-1'); ?>
                </div>
            <?php endif; ?>
            
            <?php if (is_active_sidebar('footer-2')): ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-2'); ?>
                </div>
            <?php endif; ?>

            <!-- Newsletter -->
            <div class="space-y-6">
                <h4 class="text-sm font-black uppercase tracking-widest dark:text-white"><?php esc_html_e('Newsletter', 'mobilenews'); ?></h4>
                <p class="text-xs text-gray-500 dark:text-gray-400"><?php esc_html_e('Dapatkan berita terbaru langsung di email Anda setiap hari.', 'mobilenews'); ?></p>
                <form class="relative group">
                    <input type="email" placeholder="Email Anda..." class="w-full bg-gray-50 dark:bg-white/5 border-none rounded-xl py-3 px-4 text-xs font-bold focus:ring-2 focus:ring-primary transition-all">
                    <button class="absolute right-2 top-1.5 bottom-1.5 px-4 bg-primary text-white text-[10px] font-black uppercase rounded-lg hover:brightness-110 transition-all">
                        Daftar
                    </button>
                </form>
            </div>
        </div>

        <div class="pt-8 border-t border-gray-100 dark:border-white/5 flex flex-col md:flex-row items-center justify-between gap-6">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'mobilenews'); ?>
            </p>
            <div class="flex items-center gap-6">
                <a href="#" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-primary transition-colors"><?php esc_html_e('Privacy Policy', 'mobilenews'); ?></a>
                <a href="#" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-primary transition-colors"><?php esc_html_e('Terms of Service', 'mobilenews'); ?></a>
            </div>
        </div>
    </div>
</footer>

<!-- Bottom Navigation (Mobile Only) -->
<?php
$bottomnav_enabled = mobilenews_get_option('bottomnav_enable', 1);
if ($bottomnav_enabled):
    $item2_label  = mobilenews_get_option('bottomnav_item2_label', 'Explore');
    $item2_url    = mobilenews_get_option('bottomnav_item2_url', '');
    $center_label = mobilenews_get_option('bottomnav_center_label', 'Live');
    $center_url   = mobilenews_get_option('bottomnav_center_url', mobilenews_get_option('live_streaming_url', '#'));
    $center_icon  = mobilenews_get_option('bottomnav_center_icon', 'live_tv');
    $item4_label  = mobilenews_get_option('bottomnav_item4_label', 'Trending');
    $item4_url    = mobilenews_get_option('bottomnav_item4_url', '');
    if (empty($center_url)) $center_url = '#';
?>
<nav id="mobile-bottom-nav" class="fixed bottom-0 left-0 right-0 z-[60] bg-white/95 dark:bg-zinc-900/95 backdrop-blur-md border-t border-gray-100 dark:border-white/5 xl:hidden shadow-[0_-4px_20px_-5px_rgba(0,0,0,0.1)] transition-transform duration-300">
    <div class="grid grid-cols-5 h-16 max-w-md mx-auto">
        <!-- 1. Beranda -->
        <a href="<?php echo esc_url(home_url('/')); ?>" 
           class="flex flex-col items-center justify-end w-full h-full pb-1.5 text-primary group"
           aria-label="Beranda">
            <span class="material-symbols-outlined text-[24px] mb-0.5 transition-transform group-active:scale-90">home</span>
            <span class="text-[10px] font-bold uppercase tracking-tight">Beranda</span>
        </a>

        <!-- 2. Explore (configurable) -->
        <?php if (!empty($item2_url)): ?>
        <a href="<?php echo esc_url($item2_url); ?>"
           class="flex flex-col items-center justify-end w-full h-full pb-1.5 text-gray-400 dark:text-gray-500 hover:text-primary transition-all group"
           aria-label="<?php echo esc_attr($item2_label); ?>">
        <?php else: ?>
        <button id="mobile-explore-trigger"
                class="flex flex-col items-center justify-end w-full h-full pb-1.5 text-gray-400 dark:text-gray-500 hover:text-primary transition-all group"
                aria-label="<?php echo esc_attr($item2_label); ?>">
        <?php endif; ?>
            <span class="material-symbols-outlined text-[24px] mb-0.5 transition-transform group-active:scale-90">explore</span>
            <span class="text-[10px] font-bold uppercase tracking-tight"><?php echo esc_html($item2_label); ?></span>
        <?php if (!empty($item2_url)): ?>
        </a>
        <?php else: ?>
        </button>
        <?php endif; ?>

        <!-- 3. Center Button (configurable) -->
        <div class="relative flex justify-center h-full">
            <a href="<?php echo esc_url($center_url); ?>" 
               class="absolute -top-4 size-14 bg-primary text-white rounded-full flex items-center justify-center shadow-lg shadow-primary/30 active:scale-90 transition-all border-4 border-white dark:border-zinc-900"
               aria-label="<?php echo esc_attr($center_label); ?>">
                <span class="material-symbols-outlined text-[28px] animate-pulse"><?php echo esc_html($center_icon); ?></span>
            </a>
            <div class="flex flex-col items-center justify-end h-full pb-1.5">
                <span class="text-[10px] font-bold uppercase tracking-tight text-primary"><?php echo esc_html($center_label); ?></span>
            </div>
        </div>

        <!-- 4. Trending (configurable) -->
        <?php if (!empty($item4_url)): ?>
        <a href="<?php echo esc_url($item4_url); ?>"
           class="flex flex-col items-center justify-end w-full h-full pb-1.5 text-gray-400 dark:text-gray-500 hover:text-primary transition-all group"
           aria-label="<?php echo esc_attr($item4_label); ?>">
            <span class="material-symbols-outlined text-[24px] mb-0.5 transition-transform group-active:scale-90">trending_up</span>
            <span class="text-[10px] font-bold uppercase tracking-tight"><?php echo esc_html($item4_label); ?></span>
        </a>
        <?php else: ?>
        <button class="flex flex-col items-center justify-end w-full h-full pb-1.5 text-gray-400 dark:text-gray-500 hover:text-primary transition-all group"
                aria-label="<?php echo esc_attr($item4_label); ?>">
            <span class="material-symbols-outlined text-[24px] mb-0.5 transition-transform group-active:scale-90">trending_up</span>
            <span class="text-[10px] font-bold uppercase tracking-tight"><?php echo esc_html($item4_label); ?></span>
        </button>
        <?php endif; ?>

        <!-- 5. Akun -->
        <a href="<?php echo is_user_logged_in() ? esc_url(get_edit_profile_url()) : wp_login_url(); ?>"
            class="flex flex-col items-center justify-end w-full h-full pb-1.5 text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary transition-all group"
            aria-label="Akun">
            <?php if (is_user_logged_in()): ?>
                <?php echo get_avatar(get_current_user_id(), 24, '', '', array('class' => 'rounded-full mb-0.5 border-2 border-transparent group-hover:border-primary transition-all')); ?>
            <?php else: ?>
                <span class="material-symbols-outlined text-[24px] mb-0.5 transition-transform group-active:scale-90">account_circle</span>
            <?php endif; ?>
            <span class="text-[10px] font-bold uppercase tracking-tight"><?php echo is_user_logged_in() ? 'Profil' : 'Masuk'; ?></span>
        </a>
    </div>
</nav>
<?php endif; ?>

<a href="#" id="scroll-to-top"
    class="fixed bottom-20 right-4 bg-primary text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg z-[100] hover:-translate-y-1 transition-all duration-300 opacity-0 invisible translate-y-10"
    title="Kembali ke atas">
    <span class="material-symbols-outlined">arrow_upward</span>
</a>

<?php get_template_part('template-parts/search-overlay'); ?>

<?php
// Sticky Footer Ad Logic
if (function_exists('mobilenews_render_ad')):
    $sticky_ad = mobilenews_render_ad('sticky_footer');
    if (!empty($sticky_ad)):
        ?>
        <div id="mobilenews-sticky-ad"
            class="fixed bottom-[60px] xl:bottom-0 left-0 right-0 z-50 bg-white dark:bg-zinc-900 border-t border-gray-200 dark:border-zinc-800 shadow-xl transition-transform duration-300 transform translate-y-0 text-center lg:hidden">
            <button id="close-sticky-ad"
                class="absolute -top-6 right-2 bg-gray-200 dark:bg-zinc-700 text-gray-600 dark:text-gray-300 rounded-lg p-1 text-xs shadow-sm flex items-center gap-1 px-2 hover:bg-red-100 hover:text-red-500 transition-colors">
                <span class="material-symbols-outlined text-[14px]">close</span> Tutup
            </button>
            <div class="p-2 flex justify-center sticky-ad-content">
                <?php echo $sticky_ad; ?>
            </div>
        </div>
        <script>
            document.getElementById('close-sticky-ad')?.addEventListener('click', function () {
                document.getElementById('mobilenews-sticky-ad').style.transform = 'translateY(150%)';
            });
        </script>
        <?php
    endif;
endif;
?>

<?php
if (function_exists('mobilenews_get_option')) {
    $footer_scripts = mobilenews_get_option('footer_scripts');
    if (!empty($footer_scripts)) {
        echo "<!-- Footer Scripts -->\n";
        echo $footer_scripts . "\n";
    }
}
?>

<?php wp_footer(); ?>

<?php if (is_front_page()): ?>
</div> <!-- .page-boxed-wrapper -->
<?php endif; ?>

</body>

</html>
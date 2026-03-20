<!-- Footer -->
<footer class="site-footer bg-gray-900 border-t border-gray-800 pt-16 pb-8">
    <div class="max-w-[1200px] mx-auto w-full px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <!-- Branding & About (Static/Dynamic Mix) -->
            <div class="col-span-1 md:col-span-1">
                <div class="flex items-center gap-2 mb-6">
                    <?php
                    $footer_logo = get_theme_mod('mobilenews_footer_logo');
                    if (empty($footer_logo) && function_exists('mobilenews_get_option')) {
                        $footer_logo = mobilenews_get_option('footer_logo_url');
                    }

                    if (!empty($footer_logo)): ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img src="<?php echo esc_url($footer_logo); ?>" alt="<?php bloginfo('name'); ?>"
                                class="max-h-12 w-auto object-contain">
                        </a>
                    <?php else: ?>
                        <div class="size-10 bg-primary/20 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-2xl">newspaper</span>
                        </div>
                        <span class="text-xl font-black tracking-tighter text-white">MODERN<span
                                class="text-primary">NEWS</span></span>
                    <?php endif; ?>
                </div>
                <?php
                if (is_active_sidebar('footer-1')) {
                    dynamic_sidebar('footer-1');
                } else {
                    // Fallback content if widget is empty
                    $about_text = function_exists('mobilenews_get_option') ? mobilenews_get_option('footer_about', 'Portal berita terpercaya dengan sajian informasi terkini, tajam, dan berimbang.') : 'Portal berita terpercaya...';
                    ?>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">
                        <?php echo esc_html($about_text); ?>
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <?php
                        if (function_exists('mobilenews_get_option')):
                            $socials = array(
                                'facebook' => 'ri-facebook-fill',
                                'twitter' => 'ri-twitter-x-fill',
                                'instagram' => 'ri-instagram-fill',
                                'youtube' => 'ri-youtube-fill',
                                'tiktok' => 'ri-tiktok-fill',
                                'whatsapp' => 'ri-whatsapp-line'
                            );
                            foreach ($socials as $key => $icon):
                                $link = mobilenews_get_option('social_' . $key);
                                if (!empty($link)):
                                    ?>
                                    <a href="<?php echo esc_url($link); ?>" target="_blank"
                                        class="size-9 rounded-full bg-white/10 flex items-center justify-center text-white/70 hover:bg-primary hover:text-white hover:scale-110 transition-all duration-300"
                                        aria-label="<?php echo esc_attr(ucfirst($key)); ?>">
                                        <i class="<?php echo esc_attr($icon); ?> text-lg"></i>
                                    </a>
                                    <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>

            <!-- Footer Menu 1 (Dynamic Widget Slot 2) -->
            <div>
                <?php if (is_active_sidebar('footer-2')): ?>
                    <?php dynamic_sidebar('footer-2'); ?>
                <?php else: ?>
                    <h4 class="text-white font-bold mb-6">Kategori</h4>
                    <?php wp_nav_menu(array('theme_location' => 'footer', 'container' => false, 'menu_class' => 'space-y-3', 'depth' => 1, 'fallback_cb' => false)); ?>
                <?php endif; ?>
            </div>

            <!-- Footer Menu 2 / Company (Dynamic Widget Slot 3) -->
            <div class="col-span-1 md:col-span-2"> <!-- Span 2 for the last widgets if needed, or split -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <?php if (is_active_sidebar('footer-3')): ?>
                            <?php dynamic_sidebar('footer-3'); ?>
                        <?php else: ?>
                            <h4 class="text-white font-bold mb-6">Perusahaan</h4>
                            <ul class="space-y-3">
                                <li><a href="#" class="text-gray-400 hover:text-primary text-sm transition-colors">Tentang
                                        Kami</a></li>
                                <li><a href="#"
                                        class="text-gray-400 hover:text-primary text-sm transition-colors">Redaksi</a></li>
                                <li><a href="#"
                                        class="text-gray-400 hover:text-primary text-sm transition-colors">Kontak</a></li>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <!-- Contact Info (Hardcoded fallback or Widget) -->
                    <div>
                        <h4 class="text-white font-bold mb-6">Hubungi Kami</h4>
                        <div class="space-y-4">
                            <?php if (function_exists('mobilenews_get_option')):
                                $address = mobilenews_get_option('contact_address');
                                $email = mobilenews_get_option('contact_email');
                                $phone = mobilenews_get_option('contact_phone');
                                ?>
                                <?php if ($address): ?>
                                    <div class="flex gap-3"><span
                                            class="material-symbols-outlined text-gray-500 shrink-0">location_on</span>
                                        <p class="text-gray-400 text-sm leading-relaxed">
                                            <?php echo nl2br(esc_html($address)); ?>
                                        </p>
                                    </div><?php endif; ?>
                                <?php if ($email): ?>
                                    <div class="flex gap-3 items-center"><span
                                            class="material-symbols-outlined text-gray-500 shrink-0">mail</span><a
                                            href="mailto:<?php echo esc_attr($email); ?>"
                                            class="text-gray-400 text-sm hover:text-primary"><?php echo esc_html($email); ?></a>
                                    </div><?php endif; ?>
                                <?php if ($phone): ?>
                                    <div class="flex gap-3 items-center"><span
                                            class="material-symbols-outlined text-gray-500 shrink-0">call</span><a
                                            href="tel:<?php echo esc_attr($phone); ?>"
                                            class="text-gray-400 text-sm hover:text-primary"><?php echo esc_html($phone); ?></a>
                                    </div><?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <?php
            $copyright_default = '&copy; ' . date('Y') . ' Mobile News. All rights reserved.';
            $copyright = get_theme_mod('mobilenews_copyright_text', $copyright_default);
            ?>
            <p class="text-gray-500 text-xs text-center md:text-left"><?php echo wp_kses_post($copyright); ?></p>
            <div class="flex gap-6">
                <?php
                $priv_url = function_exists('mobilenews_get_option') ? mobilenews_get_option('privacy_policy_url', '#') : '#';
                $terms_url = function_exists('mobilenews_get_option') ? mobilenews_get_option('terms_url', '#') : '#';
                ?>
                <a href="<?php echo esc_url($priv_url); ?>" class="text-gray-500 hover:text-white text-xs">Privacy
                    Policy</a>
                <a href="<?php echo esc_url($terms_url); ?>" class="text-gray-500 hover:text-white text-xs">Terms of
                    Service</a>
            </div>
        </div>
    </div>
</footer>

<!-- Mobile Bottom Navigation -->
<!-- Mobile Bottom Navigation (Premium) -->
<nav id="mobile-bottom-nav"
    class="fixed bottom-0 left-0 right-0 z-[60] xl:hidden bg-white/80 dark:bg-zinc-900/80 backdrop-blur-xl border-t border-gray-100 dark:border-zinc-800 pb-safe shadow-[0_-8px_30px_rgba(0,0,0,0.08)] transition-transform duration-500">
    <div class="grid grid-cols-5 items-stretch h-[70px] w-full">


        <!-- 1. Home -->
        <a href="<?php echo esc_url(home_url('/')); ?>"
            class="flex flex-col items-center justify-center w-full h-full text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary transition-all group <?php echo is_front_page() ? 'active text-primary dark:text-primary' : ''; ?>"
            aria-label="Beranda">
            <span class="material-symbols-outlined text-[26px] mb-0.5 group-[.active]:filled transition-transform group-active:scale-90">home</span>
            <span class="text-[9px] font-black uppercase tracking-widest opacity-80 group-[.active]:opacity-100">Beranda</span>
        </a>


        <!-- 2. Kategori / Explore -->
        <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>"
            class="flex flex-col items-center justify-center w-full h-full text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary transition-all group <?php echo is_archive() ? 'active text-primary dark:text-primary' : ''; ?>"
            aria-label="Kategori">
            <span class="material-symbols-outlined text-[26px] mb-0.5 group-[.active]:filled transition-transform group-active:scale-90">grid_view</span>
            <span class="text-[9px] font-black uppercase tracking-widest opacity-80 group-[.active]:opacity-100">Kategori</span>
        </a>


        <!-- 3. Central FAB (Menu) -->
        <div class="relative w-full h-full flex justify-center items-center">
            <div class="absolute -top-7 flex flex-col items-center">
                <button id="mobile-menu-trigger-bottom"
                    class="flex flex-col items-center justify-center w-16 h-16 bg-primary text-white rounded-full shadow-[0_12px_35px_rgba(var(--color-primary-rgb),0.4)] hover:scale-105 active:scale-90 transition-all duration-300 ring-8 ring-white/50 dark:ring-zinc-900/50"
                    aria-label="Menu">
                    <span class="material-symbols-outlined text-[32px]">menu</span>

                </button>
                <div class="h-1.5"></div>
            </div>
        </div>

        <!-- 4. Cari -->
        <button
            class="mobilenews-search-trigger flex flex-col items-center justify-end w-full h-full pb-1.5 text-gray-400 dark:text-gray-500 hover:text-primary dark:hover:text-primary transition-all group"
            aria-label="Cari">
            <span class="material-symbols-outlined text-[24px] mb-0.5 transition-transform group-active:scale-90">search</span>
            <span class="text-[10px] font-bold uppercase tracking-tight">Cari</span>
        </button>

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

<a href="#" id="scroll-to-top"
    class="fixed bottom-20 right-4 bg-primary text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg z-[100] hover:-translate-y-1 transition-all duration-300 opacity-0 invisible translate-y-10"
    title="Kembali ke atas">
    <span class="material-symbols-outlined">arrow_upward</span>
</a>

<?php get_template_part('template-parts/search-overlay'); ?>

<?php
// Sticky Footer Ad Logic
if (function_exists('mobilenews_get_ad')):
    $sticky_ad = mobilenews_get_ad('sticky_footer_ad');
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

<?php wp_footer(); ?>

<script>
    // Simple script to toggle dark mode or other UI interactions if needed
    // Tailwind Dark Mode relies on 'dark' class on HTML tag.
</script>

<?php wp_footer(); ?>
</body>

</html>
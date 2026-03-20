<!DOCTYPE html>
<html class="light" <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Performance Hints -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://www.google-analytics.com">
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">

    <?php
    $heading_font = 'Epilogue';
    $body_font = 'Noto Sans';
    $primary_color = '#168098';

    if (function_exists('mobilenews_get_option')) {
        $primary_color = mobilenews_get_option('primary_color', '#168098');
        $heading_font = mobilenews_get_option('heading_font', 'Epilogue');
        $body_font = mobilenews_get_option('body_font', 'Noto Sans');
    }
    
    $fonts_to_preload = array_unique([$heading_font, $body_font]);
    foreach ($fonts_to_preload as $font_name) {
        echo '<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=' . urlencode($font_name) . ':wght@400;500;700;800&display=swap">' . "\n    ";
    }
    ?>

    <!-- Dark Mode Init (Minimize FOUC) -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Tailwind CSS (CDN for development as requested) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Tailwind Configuration -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "var(--color-primary)",
                        "secondary": "var(--color-secondary)",
                        "background-light": "var(--background-body-light)",
                        "background-dark": "var(--background-body-dark)",
                        "surface-light": "var(--background-surface-light)",
                        "surface-dark": "var(--background-surface-dark)",
                        "accent-yellow": "#FFD600",
                    },

                    fontFamily: {
                        "display": ["var(--font-heading)", "sans-serif"],
                        "body": ["var(--font-body)", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "var(--radius-md)",
                        "lg": "calc(var(--radius-md) * 1.25)",
                        "xl": "calc(var(--radius-md) * 1.75)",
                        "2xl": "calc(var(--radius-md) * 2.5)",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <?php
    if (function_exists('mobilenews_get_option')) {
        $header_scripts = mobilenews_get_option('header_scripts');
        if (!empty($header_scripts)) {
            echo "<!-- Header Scripts -->\n";
            echo $header_scripts . "\n";
        }
    }
    ?>

    <?php wp_head(); ?>
</head>

<body <?php
$body_classes = 'antialiased font-body bg-gray-50 dark:bg-zinc-950 text-gray-900 dark:text-gray-100';
if (is_front_page()) {
    $body_classes .= ' boxed-layout';
}
body_class($body_classes); ?>>
    <?php wp_body_open(); ?>

    <?php if (is_front_page()): ?>
    <div class="page-boxed-wrapper">
    <?php endif; ?>

    <!-- Skip to Content (A11y) -->
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 z-[100] bg-primary text-white px-6 py-3 rounded-lg font-bold shadow-lg transition-all">
        Skip to Content
    </a>

    <!-- Reading Progress Bar (Single Posts Only) -->
    <?php if (is_single() && (!function_exists('mobilenews_get_option') || mobilenews_get_option('single_show_progress_bar', true))): ?>
        <div id="reading-progress-container"
            class="fixed top-0 left-0 w-full h-1 z-[60] bg-transparent pointer-events-none">
            <div id="reading-progress-bar" class="h-full bg-primary w-0 transition-all duration-100 ease-out"></div>
        </div>
    <?php endif; ?>

    <div id="mobile-menu-overlay"
        class="fixed inset-0 bg-black/50 z-[65] opacity-0 pointer-events-none backdrop-blur-sm transition-all duration-300 xl:hidden">
    </div>

    <header
        class="site-header sticky top-0 z-50 bg-white/95 dark:bg-zinc-950/95 backdrop-blur-md border-b border-gray-100 dark:border-white/5 transition-colors duration-300">

        <!-- TOP ROW: Logo centered (Desktop only) -->
        <div class="hidden xl:flex items-center justify-between px-10 py-3 border-b border-gray-100 dark:border-white/5 max-w-[1440px] mx-auto w-full">

            <!-- Left: Date / Extra Info -->
            <div class="text-xs text-gray-400 dark:text-gray-500 font-medium">
                <?php echo date_i18n('l, d F Y'); ?>
            </div>

            <!-- Center: Logo -->
            <div class="site-branding flex items-center justify-center">
                <?php
                if (has_custom_logo()):
                    the_custom_logo();
                else:
                    ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-3 group">
                        <div class="size-10 text-primary group-hover:scale-110 transition-transform duration-300">
                            <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8.57829 8.57829C5.52816 11.6284 3.451 15.5145 2.60947 19.7452C1.76794 23.9758 2.19984 28.361 3.85056 32.3462C5.50128 36.3314 8.29667 39.7376 11.8832 42.134C15.4698 44.5305 19.6865 45.8096 24 45.8096C28.3135 45.8096 32.5302 44.5305 36.1168 42.134C39.7033 39.7375 42.4987 36.3314 44.1494 32.3462C45.8002 28.361 46.2321 23.9758 45.3905 19.7452C44.549 15.5145 42.4718 11.6284 39.4217 8.57829L24 24L8.57829 8.57829Z"
                                    fill="currentColor"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col leading-tight">
                            <span class="text-2xl font-black tracking-tighter dark:text-white uppercase">
                                <?php bloginfo('name'); ?>
                            </span>
                            <?php $description = get_bloginfo('description', 'display'); ?>
                            <?php if ($description || is_customize_preview()): ?>
                                <span class="text-[10px] font-medium text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] text-center">
                                    <?php echo esc_html($description); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Right: Actions (search, subscribe, dark mode) -->
            <div class="flex items-center gap-3">
                <button
                    class="mobilenews-search-trigger flex items-center bg-gray-100 dark:bg-white/5 border border-transparent dark:border-white/5 rounded-xl px-3 py-2 text-left group transition-all hover:bg-gray-200 dark:hover:bg-white/10">
                    <span class="material-symbols-outlined text-gray-400 text-lg group-hover:text-primary transition-colors">search</span>
                    <span class="ml-2 text-sm text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300">Cari...</span>
                </button>
                <button id="theme-toggle" class="p-2 text-gray-500 hover:text-primary transition-colors"
                    title="Toggle Dark Mode">
                    <span class="material-symbols-outlined dark:hidden">dark_mode</span>
                    <span class="material-symbols-outlined hidden dark:block">light_mode</span>
                </button>
                <?php if (function_exists('mobilenews_get_option')): ?>
                    <a href="<?php echo esc_url(mobilenews_get_option('subscribe_url', '#')); ?>"
                        class="bg-primary text-white text-xs font-bold uppercase tracking-widest px-5 py-2 rounded-lg hover:brightness-110 transition-all">
                        Langganan
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- BOTTOM ROW: Navigation (Desktop only) -->
        <div class="hidden xl:flex items-center justify-center gap-8 px-10 h-11 max-w-[1440px] mx-auto w-full">
            <nav class="main-navigation flex items-center gap-6 h-full">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                        'menu_class'     => 'flex gap-6 h-full',
                        'walker'         => new MobileNews_Mega_Menu_Walker(),
                        'fallback_cb'    => false
                    ));
                }
                ?>
            </nav>
        </div>

        <!-- MOBILE ROW: Single bar with hamburger + logo centered + actions -->
        <div class="relative flex xl:hidden items-center justify-between px-4 h-14">
            <!-- Hamburger -->
            <button id="mobile-menu-toggle" class="text-gray-700 dark:text-gray-200 p-2 -ml-2 relative z-20">
                <span class="material-symbols-outlined text-2xl">menu</span>
            </button>

            <!-- Logo centered -->
            <div class="site-branding absolute left-1/2 -translate-x-1/2">
                <?php
                if (has_custom_logo()):
                    the_custom_logo();
                else:
                    ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2">
                        <div class="size-7 text-primary">
                            <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.57829 8.57829C5.52816 11.6284 3.451 15.5145 2.60947 19.7452C1.76794 23.9758 2.19984 28.361 3.85056 32.3462C5.50128 36.3314 8.29667 39.7376 11.8832 42.134C15.4698 44.5305 19.6865 45.8096 24 45.8096C28.3135 45.8096 32.5302 44.5305 36.1168 42.134C39.7033 39.7375 42.4987 36.3314 44.1494 32.3462C45.8002 28.361 46.2321 23.9758 45.3905 19.7452C44.549 15.5145 42.4718 11.6284 39.4217 8.57829L24 24L8.57829 8.57829Z" fill="currentColor"></path>
                            </svg>
                        </div>
                        <span class="text-base font-black tracking-tighter dark:text-white uppercase"><?php bloginfo('name'); ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Right actions -->
            <div class="flex items-center gap-2">
                <button class="mobilenews-search-trigger p-2 text-gray-500 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-xl">search</span>
                </button>
                <button id="theme-toggle-mobile" class="p-2 text-gray-500 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-xl dark:hidden">dark_mode</span>
                    <span class="material-symbols-outlined text-xl hidden dark:block">light_mode</span>
                </button>
            </div>
        </div>

    </header>

    <!-- Mobile Sidebar Drawer (Full content) -->
    <div id="mobile-menu-container"
        class="hidden xl:hidden bg-white dark:bg-zinc-900 fixed top-0 left-0 w-80 max-w-[85vw] h-full z-[70] shadow-2xl -translate-x-full border-r border-gray-100 dark:border-white/10 flex flex-col transition-transform duration-300">

        <!-- Drawer Header -->
        <div class="relative w-full bg-primary overflow-hidden shrink-0">
            <div class="absolute inset-0 bg-gradient-to-br from-black/20 via-transparent to-black/20"></div>
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full"></div>
            <div class="relative z-10 p-6 pt-12 pb-8 flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <div class="size-14 rounded-2xl bg-white p-1 shadow-lg">
                        <?php if (is_user_logged_in()): ?>
                            <?php echo get_avatar(get_current_user_id(), 56, '', '', array('class' => 'rounded-xl w-full h-full object-cover')); ?>
                        <?php else: ?>
                            <div class="w-full h-full rounded-xl bg-gray-50 flex items-center justify-center text-primary/40">
                                <span class="material-symbols-outlined text-3xl">person</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button id="mobile-menu-close"
                        class="size-10 flex items-center justify-center bg-white/10 backdrop-blur-md rounded-xl text-white hover:bg-white/20 active:scale-90 transition-all">
                        <span class="material-symbols-outlined text-2xl">close</span>
                    </button>
                </div>
                <div class="text-white">
                    <?php if (is_user_logged_in()):
                        $current_user = wp_get_current_user();
                        ?>
                        <h3 class="text-xl font-black truncate"><?php echo esc_html($current_user->display_name); ?></h3>
                        <p class="text-xs text-white/60"><?php echo esc_html($current_user->user_email); ?></p>
                    <?php else: ?>
                        <h3 class="text-xl font-black">Selamat Datang</h3>
                        <p class="text-xs text-white/70 mt-1">Langganan untuk akses penuh</p>
                        <?php
                        $sub_url = function_exists('mobilenews_get_option') ? mobilenews_get_option('subscribe_url', '#') : '#';
                        ?>
                        <a href="<?php echo esc_url($sub_url); ?>"
                            class="inline-flex mt-3 text-xs font-bold bg-white text-primary px-4 py-2 rounded-xl">Langganan Sekarang</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Drawer Navigation -->
        <nav class="w-full flex-1 overflow-y-auto overscroll-contain bg-white dark:bg-zinc-900/50">
            <div class="p-4 space-y-5">
                <!-- Search inside drawer -->
                <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400 text-[18px]">search</span>
                    <input type="search" name="s" placeholder="Cari berita..."
                        class="w-full bg-gray-50 dark:bg-zinc-800 border-none rounded-xl py-3 pl-10 pr-4 text-sm font-medium focus:ring-2 focus:ring-primary/20 dark:text-white">
                </form>

                <!-- Menu Links -->
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-2 mb-2">Navigasi</p>
                    <ul class="flex flex-col gap-1">
                        <li>
                            <a href="<?php echo esc_url(home_url('/')); ?>"
                                class="flex items-center gap-3 p-2.5 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gray-50 dark:hover:bg-zinc-800 transition-all group">
                                <div class="size-9 rounded-xl bg-gray-50 dark:bg-zinc-800 flex items-center justify-center text-gray-400 group-hover:text-primary group-hover:bg-primary/10 transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">home</span>
                                </div>
                                <span class="font-bold text-sm">Beranda</span>
                            </a>
                        </li>
                        <?php
                        $theme_location = has_nav_menu('mobile') ? 'mobile' : (has_nav_menu('primary') ? 'primary' : '');
                        if ($theme_location) {
                            wp_nav_menu(array(
                                'theme_location' => $theme_location,
                                'container'      => false,
                                'items_wrap'     => '%3$s',
                                'fallback_cb'    => false,
                                'walker'         => new MobileNews_Mobile_Walker()
                            ));
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Drawer Footer -->
        <div class="p-4 border-t border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-black/40 shrink-0">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-gray-400 text-lg">dark_mode</span>
                    <span class="text-xs font-bold text-gray-500">Mode Gelap</span>
                </div>
                <button id="drawer-theme-toggle"
                    class="relative inline-flex h-6 w-11 items-center rounded-full bg-gray-200 dark:bg-primary transition-colors focus:outline-none">
                    <span class="sr-only">Toggle Dark Mode</span>
                    <span class="translate-x-1 inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200 dark:translate-x-6"></span>
                </button>
            </div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">
                &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>
            </p>
        </div>
    </div>

    <!-- Breaking News Ticker -->
    <?php
    if (function_exists('mobilenews_get_option') && mobilenews_get_option('ticker_enable')):
        $ticker_title = mobilenews_get_option('ticker_title', 'Breaking News');
        $ticker_cat = mobilenews_get_option('ticker_category');
        $ticker_count = mobilenews_get_option('ticker_count', 5);
        $ticker_args = array(
            'posts_per_page' => $ticker_count,
            'ignore_sticky_posts' => 1
        );
        if ($ticker_cat) {
            $ticker_args['cat'] = $ticker_cat;
        }
        $ticker = new WP_Query($ticker_args);

        if ($ticker->have_posts()):
            ?>
            <div class="bg-accent-yellow py-2 px-4 lg:px-10 overflow-hidden">
                <div class="max-w-[1440px] mx-auto flex items-center gap-4">
                    <span
                        class="bg-black text-white text-[10px] font-black uppercase px-2 py-0.5 rounded italic shrink-0"><?php echo esc_html($ticker_title); ?></span>
                    <div class="mobilenews-ticker-wrap flex-1 text-black text-sm font-bold">
                        <div class="mobilenews-ticker-move">
                            <?php
                            while ($ticker->have_posts()):
                                $ticker->the_post();
                                ?>
                                <a href="<?php the_permalink(); ?>" class="mx-4 hover:underline">
                                    <?php the_title(); ?>
                                </a>
                                <span class="opacity-50">•</span>
                            <?php endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;
    endif;
    ?>

    <?php
    // Below Ticker Ad Display
    if (function_exists('mobilenews_render_ad')) {
        $below_ticker_ad = mobilenews_render_ad('below_ticker');
        if (!empty($below_ticker_ad)) {
            echo '<div class="below-ticker-ad-container container max-w-[1440px] mx-auto px-4 lg:px-10 py-4 flex justify-center overflow-hidden">';
            echo $below_ticker_ad;
            echo '</div>';
        }
    }

    // Header Ad Display
    if (function_exists('mobilenews_render_ad')) {
        $header_ad = mobilenews_render_ad('header');
        if (!empty($header_ad)) {
            echo '<div class="header-ad-container container max-w-[1440px] mx-auto px-4 lg:px-10 pt-0 pb-4 flex justify-center overflow-hidden">';
            echo $header_ad;
            echo '</div>';
        }
    }
    ?>
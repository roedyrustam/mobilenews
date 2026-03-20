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
        <?php
        // Fetch Dynamic Styles
        $primary_color = '#168098'; // Default
        $heading_font = 'Epilogue';
        $body_font = 'Noto Sans';

        if (function_exists('mobilenews_get_option')) {
            $primary_color = mobilenews_get_option('primary_color', '#168098');
            $heading_font = mobilenews_get_option('heading_font', 'Epilogue');
            $body_font = mobilenews_get_option('body_font', 'Noto Sans');
        }
        ?>
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

<body <?php body_class('antialiased font-body bg-gray-50 dark:bg-zinc-950 text-gray-900 dark:text-gray-100'); ?>>
    <?php wp_body_open(); ?>

    <!-- Skip to Content (A11y) -->
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 z-[100] bg-primary text-white px-6 py-3 rounded-lg font-bold shadow-lg transition-all">
        Skip to Content
    </a>

    <!-- Reading Progress Bar (Single Posts Only) -->
    <?php if (is_single()): ?>
        <div id="reading-progress-container"
            class="fixed top-0 left-0 w-full h-1 z-[60] bg-transparent pointer-events-none">
            <div id="reading-progress-bar" class="h-full bg-primary w-0 transition-all duration-100 ease-out"></div>
        </div>
    <?php endif; ?>

    <div id="mobile-menu-overlay"
        class="fixed inset-0 bg-black/50 z-[65] opacity-0 pointer-events-none backdrop-blur-sm transition-all duration-300 xl:hidden">
    </div>

    <header
        class="site-header sticky top-0 z-50 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-md border-b border-gray-100 dark:border-white/5 transition-colors duration-300">
        <div
            class="header-container container max-w-[1280px] mx-auto px-4 lg:px-10 <?php echo (mobilenews_get_option('mobile_compact_mode', true)) ? 'h-14' : 'h-20'; ?> lg:h-20 flex items-center justify-between xl:justify-between gap-6">

            <!-- Mobile Spacer -->
            <div class="flex-1 xl:hidden"></div>

            <div class="site-branding flex items-center absolute left-1/2 -translate-x-1/2 xl:relative xl:left-0 xl:translate-x-0">
                <?php
                if (has_custom_logo()):
                    the_custom_logo();
                else:
                    ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-3 group">
                        <div class="size-8 text-primary group-hover:scale-110 transition-transform duration-300">
                            <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8.57829 8.57829C5.52816 11.6284 3.451 15.5145 2.60947 19.7452C1.76794 23.9758 2.19984 28.361 3.85056 32.3462C5.50128 36.3314 8.29667 39.7376 11.8832 42.134C15.4698 44.5305 19.6865 45.8096 24 45.8096C28.3135 45.8096 32.5302 44.5305 36.1168 42.134C39.7033 39.7375 42.4987 36.3314 44.1494 32.3462C45.8002 28.361 46.2321 23.9758 45.3905 19.7452C44.549 15.5145 42.4718 11.6284 39.4217 8.57829L24 24L8.57829 8.57829Z"
                                    fill="currentColor"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col leading-tight">
                            <span class="text-lg xl:text-xl font-black tracking-tighter dark:text-white uppercase line-clamp-1">
                                <?php bloginfo('name'); ?>
                            </span>
                            <?php $description = get_bloginfo('description', 'display'); ?>
                            <?php if ($description || is_customize_preview()): ?>
                                <span class="text-[10px] font-medium text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] hidden md:block">
                                    <?php echo $description; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Desktop Nav -->
            <nav class="main-navigation hidden xl:flex items-center gap-6 h-full">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container' => false,
                        'items_wrap' => '%3$s',
                        'menu_class' => 'flex gap-6 h-full',
                        'walker' => new MobileNews_Mega_Menu_Walker(),
                        'fallback_cb' => false
                    ));
                }
                ?>
            </nav>

            <div class="flex items-center gap-4">
                <button
                    class="mobilenews-search-trigger hidden md:flex items-center bg-gray-100 dark:bg-white/5 border border-transparent dark:border-white/5 rounded-2xl px-3 py-2 w-48 xl:w-64 text-left group transition-all hover:bg-gray-200 dark:hover:bg-white/10">
                    <span
                        class="material-symbols-outlined text-gray-400 text-lg group-hover:text-primary transition-colors">search</span>
                    <span
                        class="ml-2 text-sm text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300">Cari berita...</span>
                </button>

                <button id="mobile-menu-toggle" class="xl:hidden text-gray-700 dark:text-gray-200 p-2 -mr-2 relative z-20">
                    <span class="material-symbols-outlined text-2xl lg:text-3xl">menu</span>
                </button>

                <button id="theme-toggle" class="p-2 text-gray-500 hover:text-primary transition-colors hidden xl:block"
                    title="Toggle Dark Mode">
                    <span class="material-symbols-outlined dark:hidden">dark_mode</span>
                    <span class="material-symbols-outlined hidden dark:block">light_mode</span>
                </button>

                <?php
                if (function_exists('mobilenews_get_option')):
                    $sub_url = mobilenews_get_option('subscribe_url', '#');
                    $live_enabled = mobilenews_get_option('enable_live_streaming');
                    $live_url = mobilenews_get_option('live_streaming_url', '#');

                    if ($live_enabled):
                        ?>
                        <a href="<?php echo esc_url($live_url); ?>"
                            class="hidden xl:flex items-center gap-1 text-red-600 animate-pulse border border-red-200 bg-red-50 px-3 py-1 rounded-full">
                            <span class="material-symbols-outlined text-sm">circle</span>
                            <span class="text-xs font-bold uppercase tracking-wider">Live TV</span>
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo esc_url($sub_url); ?>"
                        class="hidden md:flex bg-primary text-white text-xs font-bold uppercase tracking-widest px-6 py-2.5 rounded-lg hover:brightness-110 transition-all items-center">
                        Langganan
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Mobile Sidebar Drawer -->
    <div id="mobile-menu-container"
        class="hidden xl:hidden bg-white dark:bg-zinc-900 fixed top-0 left-0 w-80 max-w-[85vw] h-full z-[70] shadow-2xl -translate-x-full border-r border-gray-100 dark:border-white/10 flex flex-col transition-transform duration-300">
        <!-- Content handled by walker in drawer... -->
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
                <div class="max-w-[1280px] mx-auto flex items-center gap-4">
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
    // Header Ad Display
    if (function_exists('mobilenews_get_option')) {
        $header_ad = mobilenews_get_option('ads_header');
        if (!empty($header_ad)) {
            echo '<div class="header-ad-container container max-w-[1280px] mx-auto px-4 lg:px-10 py-4 flex justify-center overflow-hidden">';
            echo $header_ad;
            echo '</div>';
        }
    }
    ?>
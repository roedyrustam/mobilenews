<?php
/**
 * The template for displaying all single posts (Tailwind "Clean Article" Redesign)
 */

get_header();
?>

<!-- Reading Progress Bar (Sticky Top) -->
<?php if (mobilenews_get_option('single_show_progress_bar', true)): ?>
<div id="reading-progress-container"
    class="fixed top-0 left-0 w-full h-1 z-[60] bg-[#d1e2e6] dark:bg-gray-800 transition-all duration-300">
    <div id="reading-progress-bar" class="h-full bg-primary" style="width: 0%;"></div>
</div>
<?php endif; ?>

<main id="main-content" class="max-w-[1440px] mx-auto px-4 lg:px-10 py-8">

    <?php while (have_posts()):
        the_post();
        ?>

        <!-- Breadcrumbs -->
        <?php mobilenews_breadcrumbs(); ?>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Main Content -->
            <article id="post-<?php the_ID(); ?>" <?php post_class('lg:col-span-8 xl:col-span-9'); ?>>


                <!-- Category Label -->
                <span
                    class="inline-block bg-accent-yellow text-black text-[10px] font-black uppercase px-2 py-0.5 rounded-sm mb-4">
                    <?php $cat = get_the_category();
                    echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?>
                </span>

                <h1 class="text-4xl md:text-5xl font-extrabold leading-[1.1] tracking-tight mb-6">
                    <?php the_title(); ?>
                </h1>

                <!-- Author & Meta -->
                <div class="flex items-center justify-between border-y border-gray-100 dark:border-white/5 py-6 mb-8">

                    <div class="flex items-center gap-4">
                        <?php if (mobilenews_get_option('single_show_author_meta', true)): ?>
                        <div class="size-12 rounded-full overflow-hidden bg-gray-200 dark:bg-white/5">

                            <?php echo get_avatar(get_the_author_meta('ID'), 96, '', '', array('class' => 'w-full h-full object-cover')); ?>
                        </div>
                        <?php endif; ?>
                        <div>
                            <?php if (mobilenews_get_option('single_show_author_meta', true)): ?>
                            <p class="font-bold text-base"><?php the_author(); ?></p>
                            <?php endif; ?>
                            <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                <span><?php echo get_the_date(); ?></span>
                                <?php if (get_the_modified_time('U') > get_the_time('U') + 86400): ?>
                                    <span class="text-xs text-gray-400">• Diperbarui:
                                        <?php echo get_the_modified_date(); ?></span>
                                <?php endif; ?>
                                <?php if (mobilenews_get_option('single_show_reading_time', true)): ?>
                                <span>•</span>
                                <?php if (function_exists('mobilenews_estimated_reading_time')) {
                                    echo mobilenews_estimated_reading_time();
                                } ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <button
                        class="border border-primary text-primary px-4 py-1.5 rounded-lg text-sm font-bold hover:bg-primary hover:text-white transition-all">
                        Ikuti
                    </button>
                </div>

                <!-- Hero Image -->
                <?php if (has_post_thumbnail()): ?>
                    <figure class="mb-10">
                        <div class="aspect-[16/9] w-full bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden mb-3">
                            <?php the_post_thumbnail('full', array(
                                'class' => 'w-full h-full object-cover',
                                'fetchpriority' => 'high',
                                'loading' => 'eager'
                            )); ?>
                        </div>
                        <?php if (get_the_post_thumbnail_caption()): ?>
                            <figcaption class="text-sm text-gray-500 italic leading-relaxed">
                                <?php the_post_thumbnail_caption(); ?>
                            </figcaption>
                        <?php endif; ?>
                    </figure>
                <?php endif; ?>



                <!-- Article Body -->
                <div
                    class="entry-content prose prose-lg dark:prose-invert max-w-none leading-relaxed text-gray-800 dark:text-gray-200">
                    <?php
                    // Top Ad (After Title / Before Content)
                    if (function_exists('mobilenews_render_ad')) {
                        $ad_top = mobilenews_render_ad('after_title');
                        if (!empty($ad_top)) {
                            echo '<div class="mobilenews-ad-single-top my-8 flex justify-center overflow-hidden">';
                            echo $ad_top;
                            echo '</div>';
                        }
                    }
                    ?>

                    <?php the_content(); ?>

                    <?php
                    // Bottom Ad (After Content)
                    if (function_exists('mobilenews_render_ad')) {
                        $ad_bottom = mobilenews_render_ad('after_content');
                        if (!empty($ad_bottom)) {
                            echo '<div class="mobilenews-ad-single-bottom my-8 flex justify-center overflow-hidden">';
                            echo $ad_bottom;
                            echo '</div>';
                        }
                    }
                    ?>

                    <!-- Tags & Engagement -->
                    <div class="flex flex-wrap gap-2 mt-12 pt-8 border-t border-gray-100 dark:border-gray-800">
                        <?php
                        $tags = get_the_tags();
                        if ($tags) {
                            foreach ($tags as $tag) {
                                echo '<a class="bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-full text-xs font-semibold hover:bg-primary hover:text-white transition-all" href="' . esc_url(get_tag_link($tag->term_id)) . '">#' . esc_html($tag->name) . '</a>';
                            }
                        }
                        ?>
                    </div>

                    <!-- Post Social Share (Static) -->
                    <?php if (get_theme_mod('mobilenews_show_social_share_bottom', true)): ?>
                        <?php get_template_part('template-parts/social-share'); ?>
                    <?php endif; ?>


                    <!-- Newsletter -->
                    <div class="mt-12 bg-primary p-8 rounded-2xl text-white flex flex-col md:flex-row items-center gap-8">
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-2xl font-bold mb-2">Jangan Lewatkan Berita Penting</h3>
                            <p class="text-white/80">Dapatkan ringkasan berita terbaik langsung di inbox Anda setiap pagi.
                            </p>
                        </div>
                        <div class="w-full md:w-auto flex gap-2">
                            <input
                                class="rounded-lg border-none text-black px-4 py-2.5 w-full md:w-64 focus:ring-2 focus:ring-accent-yellow"
                                placeholder="Email Anda" type="email" />
                            <button
                                class="bg-accent-yellow text-black font-bold px-6 py-2.5 rounded-lg hover:opacity-90 transition-opacity whitespace-nowrap">Daftar</button>
                        </div>
                    </div>

                    <!-- Author Bio Box -->
                    <?php if (mobilenews_get_option('single_show_author_meta', true) && get_the_author_meta('description')): ?>
                    <div class="mt-12 p-8 bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/10 rounded-2xl flex flex-col md:flex-row gap-6 items-center md:items-start text-center md:text-left">
                        <div class="size-24 shrink-0 rounded-full overflow-hidden bg-gray-200 dark:bg-zinc-800 border-4 border-white dark:border-zinc-900 shadow-sm">
                            <?php echo get_avatar(get_the_author_meta('ID'), 192, '', '', array('class' => 'w-full h-full object-cover')); ?>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">Ditulis oleh <?php the_author_posts_link(); ?></h4>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed mb-4">
                                <?php echo wp_kses_post(nl2br(get_the_author_meta('description'))); ?>
                            </p>
                            <?php $author_url = get_the_author_meta('user_url'); ?>
                            <?php if ($author_url): ?>
                            <a href="<?php echo esc_url($author_url); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-primary font-bold text-sm hover:underline">
                                <span class="material-symbols-outlined text-[16px]">language</span> Website Penulis
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Comments Section -->
                    <?php
                    if (comments_open() || get_comments_number()):
                        comments_template();
                    endif;
                    ?>


            </article>

            <!-- Sidebar Right (Trending) -->
            <?php get_sidebar(); ?>
        </div>

        <!-- Related News Section -->
        <?php if (mobilenews_get_option('single_show_related_posts', true)): 
            $related_count = (int) mobilenews_get_option('single_related_posts_count', 3);
            ?>
        <section class="mt-20 border-t border-gray-100 dark:border-gray-800 pt-16 pb-20">
            <h3 class="text-2xl font-black mb-10 flex items-center gap-3">
                <span class="w-8 h-1 bg-primary rounded-full"></span>
                Berita Terkait
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php
                // Logic: 1. Try Tags first (more relevant)
                $tags = get_the_tags();
                $tag_ids = array();
                $rel_query = false;

                if ($tags) {
                    foreach ($tags as $tag) {
                        $tag_ids[] = $tag->term_id;
                    }
                    $args = array(
                        'tag__in' => $tag_ids,
                        'post__not_in' => array(get_the_ID()),
                        'posts_per_page' => $related_count,
                        'ignore_sticky_posts' => 1
                    );
                    $rel_query = new WP_Query($args);
                }

                // Logic: 2. Fallback to Categories if no tag matches
                if (!$rel_query || !$rel_query->have_posts()) {
                    $cats = get_the_category();
                    if ($cats) {
                        $c_ids = array();
                        foreach ($cats as $i) {
                            $c_ids[] = $i->term_id;
                        }
                        $args = array(
                            'category__in' => $c_ids,
                            'post__not_in' => array(get_the_ID()),
                            'posts_per_page' => $related_count,
                            'ignore_sticky_posts' => 1
                        );
                        $rel_query = new WP_Query($args);
                    }
                }

                // Output Loop
                if ($rel_query && $rel_query->have_posts()) {
                    while ($rel_query->have_posts()):
                        $rel_query->the_post();
                        get_template_part('template-parts/content', 'card', ['layout' => 'grid']);
                    endwhile;
                    wp_reset_postdata();
                } else {
                    echo '<p class="col-span-full text-center text-gray-500 italic">Tidak ada berita terkait saat ini.</p>';
                }
                ?>
            </div>
        </section>
        <?php endif; ?>

    <?php endwhile; // End of the loop. ?>

</main>

<?php
// JSON-LD Schema for NewsArticle
if (is_single() && have_posts()):
    while (have_posts()):
        the_post();
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => get_the_title(),
            'image' => has_post_thumbnail() ? [get_the_post_thumbnail_url(null, 'full')] : [],
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => [
                '@type' => 'Person',
                'name' => get_the_author()
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => get_template_directory_uri() . '/assets/images/logo.png' // Placeholder or dynamic if option exists
                ]
            ],
            'description' => get_the_excerpt()
        ];
        echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
    endwhile;
endif;
?>

<?php get_footer(); ?>
<?php
/**
 * Template Name: Narrow Reading (Modern News)
 * Template Post Type: post, page
 */

get_header();
?>

<main id="main-content" class="max-w-[1440px] mx-auto px-4 lg:px-10 py-16">
    <?php
    while (have_posts()):
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('max-w-[720px] mx-auto'); ?>>
            
            <!-- Breadcrumbs (Minimalist) -->
            <nav class="flex items-center gap-2 mb-10 text-xs font-bold uppercase tracking-widest text-gray-400">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-primary transition-colors">Home</a>
                <span class="material-symbols-outlined text-[12px]">chevron_right</span>
                <span class="text-gray-900 dark:text-white"><?php the_title(); ?></span>
            </nav>

            <!-- Header Section -->
            <header class="mb-12">
                <h1 class="text-4xl md:text-5xl font-black tracking-tight mb-8 leading-tight">
                    <?php the_title(); ?>
                </h1>

                <?php if (is_singular('post')): ?>
                <div class="flex items-center gap-4 py-6 border-y border-gray-100 dark:border-white/5 mb-12">
                    <div class="size-12 rounded-full overflow-hidden bg-gray-200">
                        <?php echo get_avatar(get_the_author_meta('ID'), 96, '', '', array('class' => 'w-full h-full object-cover')); ?>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-black"><?php the_author(); ?></span>
                        <span class="text-xs text-gray-500"><?php echo get_the_date(); ?> • <?php if(function_exists('mobilenews_estimated_reading_time')) echo mobilenews_estimated_reading_time(); ?></span>
                    </div>
                </div>
                <?php endif; ?>
            </header>

            <!-- Content Area (Optimized Typography) -->
            <div class="prose prose-xl dark:prose-invert max-w-none prose-p:leading-[1.8] prose-p:mb-8 prose-headings:font-black prose-img:rounded-3xl">
                <?php the_content(); ?>
            </div>

            <!-- Footer for Posts -->
            <?php if (is_singular('post')): ?>
                <footer class="mt-16 pt-12 border-t border-gray-100 dark:border-white/5">
                    <div class="flex flex-wrap gap-2 mb-10">
                        <?php
                        $tags = get_the_tags();
                        if ($tags) {
                            foreach ($tags as $tag) {
                                echo '<a class="bg-gray-50 dark:bg-white/5 px-4 py-2 rounded-xl text-xs font-bold hover:bg-primary hover:text-white transition-all" href="' . esc_url(get_tag_link($tag->term_id)) . '">#' . esc_html($tag->name) . '</a>';
                            }
                        }
                        ?>
                    </div>
                    <?php get_template_part('template-parts/social-share'); ?>
                </footer>
            <?php endif; ?>

            <!-- Comments -->
            <div class="mt-16">
                <?php if (comments_open() || get_comments_number()) comments_template(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>

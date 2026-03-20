<?php
/**
 * Template Name: Full-Width (Modern News)
 * Template Post Type: post, page
 */

get_header();
?>

<main id="main-content" class="max-w-[1440px] mx-auto px-4 lg:px-10 py-12">
    <?php
    while (have_posts()):
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('max-w-4xl mx-auto'); ?>>

            <!-- Breadcrumbs -->
            <?php mobilenews_breadcrumbs(); ?>

            <!-- Header Section -->
            <header class="mb-12 text-center">
                <?php if (is_singular('post')): ?>
                    <span class="inline-block bg-accent-yellow text-black text-[10px] font-black uppercase px-2 py-1 rounded-md mb-4 shadow-sm">
                        <?php $cat = get_the_category();
                        echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?>
                    </span>
                <?php endif; ?>

                <h1 class="text-4xl md:text-6xl font-black tracking-tight mb-6 leading-[1.1]">
                    <?php the_title(); ?>
                </h1>

                <?php if (is_singular('post')): ?>
                    <div class="flex items-center justify-center gap-4 text-sm text-gray-500 font-medium">
                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[18px]">person</span> <?php the_author(); ?></span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[18px]">schedule</span> <?php echo get_the_date(); ?></span>
                    </div>
                <?php endif; ?>
            </header>

            <!-- Featured Image (Cinema Wide) -->
            <?php if (has_post_thumbnail()): ?>
                <figure class="mb-16 rounded-[2rem] overflow-hidden aspect-[21/9] shadow-2xl">
                    <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
                </figure>
            <?php endif; ?>

            <!-- Content Area -->
            <div class="prose prose-xl dark:prose-invert max-w-4xl mx-auto leading-relaxed">
                <?php the_content(); ?>
            </div>

            <!-- Footer Meta for Posts -->
            <?php if (is_singular('post')): ?>
                <footer class="mt-16 pt-8 border-t border-gray-100 dark:border-white/5 mx-auto">
                    <?php get_template_part('template-parts/social-share'); ?>
                </footer>
            <?php endif; ?>

            <!-- Comments -->
            <div class="mt-16">
                <?php if (comments_open() || get_comments_number())
                    comments_template(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>

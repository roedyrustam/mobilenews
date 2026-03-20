<?php
/**
 * The template for displaying all pages
 */

get_header();
?>

<main id="main-content" class="max-w-[1024px] mx-auto px-6 py-8">
    <?php
    while (have_posts()):
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="mb-8 text-center">
                <h1 class="text-3xl md:text-5xl font-black tracking-tight mb-4">
                    <?php the_title(); ?>
                </h1>
                <?php if (has_excerpt()): ?>
                    <p class="text-xl text-gray-500 max-w-3xl mx-auto leading-relaxed">
                        <?php echo get_the_excerpt(); ?>
                    </p>
                <?php endif; ?>
            </header>

            <?php
            // Top Ad (After Title / Before Content)
            if (function_exists('mobilenews_render_ad')) {
                $ad_top = mobilenews_render_ad('after_title');
                if (!empty($ad_top)) {
                    echo '<div class="mobilenews-ad-page-top mb-10 flex justify-center overflow-hidden">';
                    echo $ad_top;
                    echo '</div>';
                }
            }
            ?>

            <?php if (has_post_thumbnail()): ?>
                <figure class="mb-10 rounded-3xl overflow-hidden aspect-video shadow-lg">
                    <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title_attribute(); ?>"
                        class="w-full h-full object-cover">
                </figure>
            <?php endif; ?>

            <div
                class="prose prose-lg dark:prose-invert max-w-none prose-img:rounded-xl prose-a:text-primary prose-a:no-underline hover:prose-a:underline">
                <?php the_content(); ?>
            </div>

            <?php
            // Bottom Ad (After Content)
            if (function_exists('mobilenews_render_ad')) {
                $ad_bottom = mobilenews_render_ad('after_content');
                if (!empty($ad_bottom)) {
                    echo '<div class="mobilenews-ad-page-bottom my-12 flex justify-center overflow-hidden">';
                    echo $ad_bottom;
                    echo '</div>';
                }
            }
            ?>

            <?php
            if (comments_open() || get_comments_number()):
                comments_template();
            endif;
            ?>
        </article>

    <?php endwhile; ?>
</main>

<?php
get_footer();

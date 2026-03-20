<?php
/**
 * The main template file
 */

get_header();
?>

<div class="container max-w-[1280px] mx-auto px-4 lg:px-10 py-8 grid grid-cols-1 lg:grid-cols-12 gap-12">
    <main id="main-content" class="site-main lg:col-span-8">

        <?php
        if (have_posts()):

            if (is_home() && !is_front_page()):
                ?>
                <header class="mb-8">
                    <h1 class="text-3xl font-black border-l-4 border-primary pl-4">
                        <?php single_post_title(); ?>
                    </h1>
                </header>
                <?php
            endif;

            if (is_archive()):
                ?>
                <header class="mb-8">
                    <h1 class="text-3xl font-black border-l-4 border-primary pl-4">
                        <?php the_archive_title(); ?>
                    </h1>
                </header>
                <?php
            endif;


            // Top Ad (After Title / Before Content)
            if (function_exists('mobilenews_render_ad')) {
                $ad_top = mobilenews_render_ad('after_title');
                if (!empty($ad_top)) {
                    echo '<div class="mobilenews-ad-index-top mb-10 flex justify-center overflow-hidden">';
                    echo $ad_top;
                    echo '</div>';
                }
            }


            if (is_singular()) {
                // Singular view (Page, Single Post fallback)
                while (have_posts()):
                    the_post();
                    get_template_part('template-parts/content', get_post_type());
                endwhile;
            } else {
                // Archive / Blog Index view
                echo '<div class="news-grid grid grid-cols-1 md:grid-cols-2 gap-8">';
                while (have_posts()):
                    the_post();
                    get_template_part('template-parts/content', 'card');
                endwhile;
                echo '</div>'; // End grid
        
                // Bottom Ad (After Content)
                if (function_exists('mobilenews_render_ad')) {
                    $ad_bottom = mobilenews_render_ad('after_content');
                    if (!empty($ad_bottom)) {
                        echo '<div class="mobilenews-ad-index-bottom my-12 flex justify-center overflow-hidden">';
                        echo $ad_bottom;
                        echo '</div>';
                    }
                }

                the_posts_navigation(array(
                    'prev_text' => '<span class="nav-prev-text">Previous</span>',
                    'next_text' => '<span class="nav-next-text">Next</span>',
                    'screen_reader_text' => ' '
                ));
            }

        else:

            get_template_part('template-parts/content', 'none');

        endif;
        ?>

    </main><!-- #main -->

    <?php get_sidebar(); ?>
</div>
<?php
/**
 * Template part for displaying Latest News Stream section on the homepage
 */
?>
<div class="mb-12">
    <div class="flex items-center gap-4 mb-8">
        <h2 class="text-3xl font-black tracking-tight section-title dark:text-white uppercase">Terbaru</h2>
        <div class="flex-1 h-px bg-gradient-to-r from-gray-200 via-gray-100 to-transparent dark:from-white/10 dark:via-white/5 dark:to-transparent"></div>
    </div>


    <div id="mobilenews-post-list" class="grid grid-cols-1 gap-8">
        <?php
        $latest_query = new WP_Query(array(
            'posts_per_page' => 5,
            'offset' => 10,
            'ignore_sticky_posts' => 1
        ));

        if ($latest_query->have_posts()):
            while ($latest_query->have_posts()):
                $latest_query->the_post();
                get_template_part('template-parts/content', 'stream');
            endwhile;
        endif;
        ?>
    </div>

    <!-- Load More Button -->
    <div class="text-center mt-12 mb-8">
        <button id="mobilenews-load-more" 
                data-page="1" 
                data-max-page="<?php echo $latest_query->max_num_pages; ?>"
                data-is-home="true"
                class="px-10 py-3.5 bg-white dark:bg-white/5 border border-gray-100 dark:border-white/10 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-primary hover:text-white hover:border-primary hover:shadow-xl hover:shadow-primary/20 transition-all active:scale-95">
            Lihat Semua Berita
        </button>

        <div id="load-more-spinner" class="hidden mt-4">
            <span class="inline-block w-6 h-6 border-2 border-gray-300 border-t-primary rounded-full animate-spin"></span>
        </div>
    </div>
    <?php
    wp_reset_postdata();
    ?>
</div>
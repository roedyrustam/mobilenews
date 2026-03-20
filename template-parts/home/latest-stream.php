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
                ?>
                <div
                    class="flex flex-col md:flex-row gap-6 group cursor-pointer border-b border-gray-100 dark:border-gray-800 pb-6 last:border-0 last:pb-0">
                    <a href="<?php the_permalink(); ?>" class="md:w-64 aspect-video rounded-xl overflow-hidden shrink-0 bg-gray-100 dark:bg-gray-800 block">
                        <?php if (has_post_thumbnail()): ?>
                            <img src="<?php the_post_thumbnail_url('medium_large'); ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <?php endif; ?>
                    </a>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span
                                class="text-[10px] font-bold uppercase bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded text-gray-500">
                                <?php $cat = get_the_category();
                                echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?>
                            </span>
                            <span class="text-xs text-gray-400 font-medium">
                                <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' yang lalu'; ?>
                            </span>
                        </div>
                        <h3 class="text-xl font-bold mb-3 group-hover:text-primary transition-colors">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">
                            <?php echo get_the_excerpt(); ?>
                        </p>
                    </div>
                </div>
                <?php
            endwhile;
            ?>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-12 mb-8">
            <button id="mobilenews-load-more" data-page="1" data-max-page="<?php echo $latest_query->max_num_pages; ?>"
                class="px-10 py-3.5 bg-white dark:bg-white/5 border border-gray-100 dark:border-white/10 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-primary hover:text-white hover:border-primary hover:shadow-xl hover:shadow-primary/20 transition-all active:scale-95">
                Lihat Semua Berita
            </button>

            <div id="load-more-spinner" class="hidden mt-4">
                <span
                    class="inline-block w-6 h-6 border-2 border-gray-300 border-t-primary rounded-full animate-spin"></span>
            </div>
        </div>
        <?php
        wp_reset_postdata();
        endif;
        ?>
</div>
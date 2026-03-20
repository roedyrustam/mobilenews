<?php
/**
 * Template part for displaying the Hero Grid on the homepage
 */
?>
<section class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-12">
    <?php
    // Fetch 3 posts for Hero
    $hero_query = new WP_Query(array(
        'posts_per_page' => 3,
        'ignore_sticky_posts' => 1,
    ));

    if ($hero_query->have_posts()):
        $post_count = 0;
        while ($hero_query->have_posts()):
            $hero_query->the_post();
            $post_count++;

            // Main Hero (First Post)
            if ($post_count === 1):
                ?>
                <div class="lg:col-span-8 group cursor-pointer">
                    <div class="relative aspect-video overflow-hidden rounded-xl mb-4">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="absolute inset-0 z-0">
                                <?php the_post_thumbnail('full', array(
                                    'class' => 'w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110',
                                    'fetchpriority' => 'high',
                                    'loading' => 'eager'
                                )); ?>
                            </div>
                        <?php endif; ?>


                        <div class="absolute bottom-6 left-6 right-6 p-6 lg:p-8 glass-overlay rounded-2xl group-hover:border-primary/30 transition-all duration-500">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-primary text-white text-[10px] font-black uppercase px-3 py-1 rounded-full tracking-[1.5px] shadow-lg shadow-primary/20">
                                    <?php $cat = get_the_category();
                                    echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?>
                                </span>
                                <span class="text-white/60 text-[10px] uppercase font-bold tracking-widest leading-none">Featured Story</span>
                            </div>
                            <h2 class="text-white text-3xl xl:text-5xl font-black leading-[1.1] mb-4 tracking-tighter">
                                <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <p class="text-white/70 line-clamp-2 max-w-2xl text-base font-medium leading-relaxed">
                                <?php echo get_the_excerpt(); ?>
                            </p>
                        </div>

                    </div>
                </div>

                <!-- Open Side Hero Container -->
                <div class="lg:col-span-4 flex flex-col gap-6">
                <?php else: ?>
                    <!-- Side Hero Items (2 & 3) -->
                    <div class="group cursor-pointer">
                        <div class="relative aspect-[16/10] overflow-hidden rounded-2xl shadow-lg mb-3 hover-lift border border-transparent hover:border-white/10 transition-all duration-300">
                            <?php if (has_post_thumbnail()): ?>
                                <img src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php the_title_attribute(); ?>"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                            <?php else: ?>
                                <div class="w-full h-full bg-gray-200"></div>
                            <?php endif; ?>


                            <div class="absolute top-2 left-2">
                                <span class="bg-accent-yellow text-black text-[10px] font-bold uppercase px-2 py-1 rounded">
                                    <?php $cat = get_the_category();
                                    echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?>
                                </span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold leading-snug group-hover:text-primary transition-colors">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <p class="text-xs text-gray-500 mt-2 font-medium">
                            <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' yang lalu'; ?> • Oleh
                            <?php the_author(); ?>
                        </p>
                    </div>
                <?php endif;
        endwhile;

        // Close Side Hero Container
        echo '</div>';
        wp_reset_postdata();
    endif;
    ?>
</section>
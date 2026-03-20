<?php
/**
 * Template part for displaying the Hero Grid on the homepage
 */
?>
<section class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-12">
    <?php
    // Fetch 5 posts for Hero
    $hero_query = new WP_Query(array(
        'posts_per_page' => 5,
        'ignore_sticky_posts' => 1,
    ));

    if ($hero_query->have_posts()):

        $post_count = 0;
        while ($hero_query->have_posts()):
            $hero_query->the_post();
            $post_count++;

            if ($post_count === 1):
                ?>
                <div class="lg:col-span-7 hero-grid-main group cursor-pointer relative -translate-y-0 transition-all duration-500 hover:-translate-y-2">
                    <div class="relative h-full overflow-hidden rounded-xl">


                        <?php if (has_post_thumbnail()): ?>
                            <div class="absolute inset-0 z-0 scale-100 group-hover:scale-110 transition-transform duration-1000">
                                <?php the_post_thumbnail('full', array(
                                    'class' => 'w-full h-full object-cover',
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

                <!-- Open Side Hero Container (2x2 Grid) -->
                <div class="lg:col-span-5 grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                <?php else: ?>
                    <!-- Side Hero Items (2, 3, 4, 5) -->
                    <div class="group cursor-pointer relative rounded-3xl overflow-hidden hover-lift h-full aspect-[16/10] lg:aspect-square min-h-[160px]">

                        <?php if (has_post_thumbnail()): ?>
                            <img src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php the_title_attribute(); ?>"
                                class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                        <?php endif; ?>
                        
                        <div class="absolute inset-0 bg-black/30 group-hover:bg-black/10 transition-colors duration-500 z-0"></div>

                        <!-- Content Overlay -->
                        <div class="absolute inset-0 p-4 flex flex-col justify-end z-10 glass-overlay border-0 group-hover:border-primary/20 transition-all">
                            <div class="flex flex-wrap gap-2 mb-2">
                                <span class="bg-primary/90 text-white text-[8px] font-black uppercase px-2 py-0.5 rounded-full tracking-wider">
                                    <?php $cat = get_the_category(); echo !empty($cat) ? esc_html($cat[0]->name) : 'News'; ?>
                                </span>
                            </div>
                            <h3 class="text-white text-sm xl:text-base font-black leading-tight line-clamp-2">
                                <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                        </div>
                    </div>
                <?php endif;

        endwhile;

        // Close Side Hero Container
        echo '</div>';
        wp_reset_postdata();
    endif;
    ?>
</section>
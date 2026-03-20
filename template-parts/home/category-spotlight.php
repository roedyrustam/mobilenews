<?php
/**
 * Template part for displaying Category Spotlight section on the homepage
 */
?>
<div class="flex flex-col gap-16 mb-16">
    <?php
    $cat1 = mobilenews_get_option('homepage_spotlight_cat1');
    $cat2 = mobilenews_get_option('homepage_spotlight_cat2');
    $categories_to_show = array_filter(array($cat1, $cat2));

    if (empty($categories_to_show)) {
        $categories_to_show = array('teknologi', 'gaya-hidup'); // Fallback
    }

    foreach ($categories_to_show as $cat_id_or_slug):
        if (is_numeric($cat_id_or_slug)) {
            $category = get_category($cat_id_or_slug);
        } else {
            $category = get_category_by_slug($cat_id_or_slug);
        }
        if (!$category) continue;
        $cat_slug = $category->slug;

        ?>
        <section class="category-spotlight-block">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary text-3xl"><?php echo ($cat_slug == 'teknologi') ? 'memory' : 'diamond'; ?></span>
                    <h2 class="text-3xl font-black tracking-tight dark:text-white uppercase"><?php echo esc_html($category->name); ?></h2>
                </div>
                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="group flex items-center gap-2 text-xs font-black uppercase tracking-widest text-gray-400 hover:text-primary transition-all">
                    Lihat Semua
                    <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
                <?php
                $cat_query = new WP_Query(array(
                    'cat' => $category->term_id,
                    'posts_per_page' => 5,
                    'ignore_sticky_posts' => 1
                ));

                if ($cat_query->have_posts()):
                    $c = 0;
                    while ($cat_query->have_posts()):
                        $cat_query->the_post();
                        $c++;
                        if ($c === 1): ?>
                            <!-- Large Post (Left) -->
                            <div class="xl:col-span-7 group cursor-pointer relative rounded-4xl overflow-hidden shadow-2xl hover-lift aspect-video">
                                <!-- Clickable Area -->
                                <a href="<?php the_permalink(); ?>" class="absolute inset-0 z-0 overflow-hidden">
                                    <?php if (has_post_thumbnail()): ?>
                                        <img src="<?php the_post_thumbnail_url('full'); ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000" />
                                    <?php endif; ?>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                                </a>
                                
                                <div class="absolute bottom-0 left-0 right-0 p-6 lg:p-10 bg-black/20 backdrop-blur-md border border-white/10 m-4 rounded-3xl">
                                    <h3 class="text-white text-2xl lg:text-3xl font-black leading-tight mb-4 tracking-tighter hover:text-primary transition-colors">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <p class="text-white/70 line-clamp-2 text-sm lg:text-base font-medium leading-relaxed">
                                        <?php echo get_the_excerpt(); ?>
                                    </p>
                                </div>
                            </div>

                            <!-- List Posts (Right) -->
                            <div class="xl:col-span-5 flex flex-col gap-6 justify-between">
                        <?php else: ?>
                            <article class="flex items-center gap-5 group cursor-pointer">
                                <a href="<?php the_permalink(); ?>" class="w-24 h-24 lg:w-32 lg:h-32 rounded-3xl overflow-hidden shrink-0 shadow-lg hover-lift block">
                                    <?php if (has_post_thumbnail()): ?>
                                        <img src="<?php the_post_thumbnail_url('medium'); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                                    <?php endif; ?>
                                </a>
                                <div>
                                    <div class="text-[10px] font-black uppercase text-primary tracking-widest mb-2 flex items-center gap-2">
                                        <span class="w-1 h-1 bg-primary rounded-full"></span>
                                        <?php echo get_the_date(); ?>
                                    </div>
                                    <h4 class="text-base lg:text-lg font-black leading-snug dark:text-white group-hover:text-primary transition-colors line-clamp-2">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                </div>
                            </article>
                        <?php endif;
                    endwhile;
                    echo '</div>'; // Close Col-5
                    wp_reset_postdata();
                endif; ?>
            </div>
        </section>
    <?php endforeach; ?>
</div>
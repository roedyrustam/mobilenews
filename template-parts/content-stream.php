<?php
/**
 * Template part for displaying posts in the latest news stream list (Modern Tailwind)
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('flex flex-col md:flex-row gap-6 group cursor-pointer border-b border-gray-100 dark:border-gray-800 pb-6 last:border-0 last:pb-0'); ?>>
    <!-- Thumbnail Area -->
    <a href="<?php the_permalink(); ?>" class="md:w-64 aspect-video rounded-xl overflow-hidden shrink-0 bg-gray-100 dark:bg-gray-800 block relative">
        <?php if (has_post_thumbnail()): ?>
            <img src="<?php the_post_thumbnail_url('medium_large'); ?>"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                alt="<?php the_title_attribute(); ?>" />
        <?php else: ?>
            <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700">
                <span class="material-symbols-outlined text-gray-400">image</span>
            </div>
        <?php endif; ?>
    </a>

    <!-- Content Area -->
    <div class="flex-1 flex flex-col justify-center">
        <div class="flex flex-wrap items-center gap-y-2 gap-x-4 mb-3">
            <!-- Linked Category -->
            <?php 
            $categories = get_the_category();
            if (!empty($categories)): ?>
                <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" 
                   class="text-[10px] font-black uppercase bg-primary/10 text-primary px-2.5 py-1 rounded-md hover:bg-primary hover:text-white transition-all">
                    <?php echo esc_html($categories[0]->name); ?>
                </a>
            <?php endif; ?>

            <!-- Meta: Date & Author -->
            <div class="flex items-center gap-3 text-xs text-gray-400 font-medium">
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                    <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' yang lalu'; ?>
                </span>
                <span class="w-1 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></span>
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">person</span>
                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="hover:text-primary">
                        <?php the_author(); ?>
                    </a>
                </span>
            </div>
        </div>

        <!-- Title -->
        <h3 class="text-xl lg:text-2xl font-black mb-3 group-hover:text-primary transition-colors leading-tight">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <!-- Excerpt -->
        <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base mb-2 line-clamp-2 font-medium leading-relaxed">
            <?php echo get_the_excerpt(); ?>
        </p>
    </div>
</article>

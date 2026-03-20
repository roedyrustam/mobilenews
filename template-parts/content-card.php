<?php
/**
 * Template part for displaying posts in a standard card layout (Modern Tailwind v1.8.0)
 */
$layout = isset($args['layout']) ? $args['layout'] : 'list';

// Responsive classes based on layout
$article_classes = 'group cursor-pointer bg-white dark:bg-white/5 rounded-3xl overflow-hidden border border-gray-100 dark:border-white/10 transition-all hover:shadow-2xl hover:shadow-primary/5 hover:-translate-y-1 ';
$article_classes .= ($layout === 'grid') ? 'flex flex-col' : 'flex flex-col md:flex-row gap-6 p-4 md:p-6';

$image_wrapper_classes = ($layout === 'grid') ? 'aspect-video w-full' : 'aspect-video md:w-72 shrink-0 rounded-2xl overflow-hidden';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($article_classes); ?>>
    <!-- Thumbnail Area -->
    <div class="relative overflow-hidden <?php echo esc_attr($image_wrapper_classes); ?>">
        <a href="<?php the_permalink(); ?>" class="absolute inset-0 z-0 block">
            <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-700']); ?>
            <?php else: ?>
                <div class="w-full h-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                    <span class="material-symbols-outlined text-gray-400 text-4xl">image</span>
                </div>
            <?php endif; ?>
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </a>
        
        <!-- Category Badge (Floating for Grid) -->
        <?php if ($layout === 'grid'): ?>
            <?php $categories = get_the_category(); if (!empty($categories)): ?>
                <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" 
                   class="absolute top-4 left-4 z-10 bg-primary text-white text-[10px] font-black uppercase px-2.5 py-1 rounded-md shadow-lg">
                    <?php echo esc_html($categories[0]->name); ?>
                </a>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Content Area -->
    <div class="flex-1 flex flex-col justify-center <?php echo ($layout === 'grid') ? 'p-6' : ''; ?>">
        <!-- Meta Row (List Layout) -->
        <?php if ($layout !== 'grid'): ?>
            <div class="flex items-center gap-3 mb-3">
                <?php $categories = get_the_category(); if (!empty($categories)): ?>
                    <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" 
                       class="text-[10px] font-black uppercase bg-primary/10 text-primary px-2 py-0.5 rounded">
                        <?php echo esc_html($categories[0]->name); ?>
                    </a>
                <?php endif; ?>
                <span class="flex items-center gap-1 text-[11px] text-gray-400 font-bold uppercase tracking-tight">
                    <span class="material-symbols-outlined text-xs">schedule</span>
                    <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' lalu'; ?>
                </span>
            </div>
        <?php endif; ?>

        <!-- Title -->
        <h3 class="<?php echo ($layout === 'grid') ? 'text-lg md:text-xl' : 'text-xl md:text-2xl'; ?> font-black mb-3 group-hover:text-primary transition-colors leading-tight">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <!-- Meta Row (Grid Layout) -->
        <?php if ($layout === 'grid'): ?>
            <div class="flex items-center gap-3 text-xs text-gray-400 font-medium mb-4">
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                    <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' lalu'; ?>
                </span>
                <span class="w-1 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></span>
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">person</span>
                    <?php the_author(); ?>
                </span>
            </div>
        <?php endif; ?>

        <!-- Excerpt -->
        <?php if (mobilenews_get_option('archive_show_excerpt', true)): ?>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2 leading-relaxed">
                <?php echo get_the_excerpt(); ?>
            </p>
        <?php endif; ?>

        <!-- Read More (Optional for List) -->
        <?php if ($layout !== 'grid'): ?>
            <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-1 text-xs font-black uppercase tracking-widest text-primary hover:gap-2 transition-all">
                Baca Selengkapnya
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        <?php endif; ?>
    </div>
</article>
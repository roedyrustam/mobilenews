<?php
/**
 * The template for displaying author profile pages (Standardized)
 *
 * @package MobileNews
 */

get_header();

// Get Current Author
$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
$author_id = $curauth->ID;
$user_avatar_url = get_avatar_url($author_id, ['size' => 256]);
$post_count = count_user_posts($author_id);

// Dummy Static Stats for now (could be meta fields later)
$followers = '45k';
$awards = '12';

// Featured Stories Query (Get 2 random posts from this author to "Showcase")
$featured_args = array(
    'author' => $author_id,
    'posts_per_page' => 2,
    'orderby' => 'rand',
    'ignore_sticky_posts' => 1
);
$featured_query = new WP_Query($featured_args);
?>

<main id="main-content" class="max-w-[1280px] mx-auto px-4 lg:px-10 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Sidebar (Metadata) -->
        <aside class="lg:col-span-4 order-2 lg:order-1 flex flex-col gap-8">
            <!-- Profile Card Summary -->
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-gray-100 dark:border-white/5 shadow-sm">
                <div class="flex flex-col items-center text-center">
                    <?php if ($user_avatar_url): ?>
                        <div class="size-32 rounded-full border-4 border-white dark:border-zinc-800 shadow-xl bg-cover bg-center mb-4 overflow-hidden">
                             <img src="<?php echo esc_url($user_avatar_url); ?>" alt="<?php echo esc_attr($curauth->display_name); ?>" class="w-full h-full object-cover">
                        </div>
                    <?php else: ?>
                        <div class="size-32 rounded-full border-4 border-white dark:border-zinc-800 shadow-xl bg-gray-100 dark:bg-zinc-800 flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-4xl text-gray-400">person</span>
                        </div>
                    <?php endif; ?>

                    <h1 class="text-2xl font-black mb-1">
                        <?php echo esc_html($curauth->display_name); ?>
                    </h1>
                    <p class="text-primary font-bold text-xs uppercase tracking-widest mb-4">Author / Contributor</p>

                    <div class="flex gap-4 mb-6 w-full justify-center">
                        <div class="text-center">
                            <p class="text-xl font-black">
                                <?php echo number_format($post_count); ?>
                            </p>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-tighter">Berita</p>
                        </div>
                        <div class="w-px h-8 bg-gray-100 dark:bg-zinc-800 self-center"></div>
                        <div class="text-center">
                            <p class="text-xl font-black">
                                <?php echo $followers; ?>
                            </p>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-tighter">Follower</p>
                        </div>
                        <div class="w-px h-8 bg-gray-100 dark:bg-zinc-800 self-center"></div>
                        <div class="text-center">
                            <p class="text-xl font-black">
                                <?php echo $awards; ?>
                            </p>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-tighter">Award</p>
                        </div>
                    </div>

                    <div class="flex w-full gap-2">
                        <button class="flex-1 bg-primary text-white py-3 rounded-2xl font-bold text-sm flex items-center justify-center gap-2 hover:scale-[1.02] active:scale-95 transition-all">
                            <span class="material-symbols-outlined text-lg">person_add</span> Ikuti
                        </button>
                        <button class="px-4 bg-gray-50 dark:bg-zinc-800 rounded-2xl hover:bg-gray-100 dark:hover:bg-zinc-700 transition-colors">
                            <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">share</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Regional Focus -->
            <div class="bg-gray-50 dark:bg-zinc-900/50 p-6 rounded-3xl border border-transparent dark:border-white/5">
                <h3 class="font-black text-sm uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">location_on</span>
                    Regional Focus
                </h3>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-white dark:bg-zinc-800 px-3 py-1.5 rounded-xl text-xs font-bold shadow-sm">Jakarta</span>
                    <span class="bg-white dark:bg-zinc-800 px-3 py-1.5 rounded-xl text-xs font-bold shadow-sm">Surabaya</span>
                    <span class="bg-white dark:bg-zinc-800 px-3 py-1.5 rounded-xl text-xs font-bold shadow-sm">IKN</span>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="lg:col-span-8 order-1 lg:order-2">
            <!-- Biography -->
            <section class="mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-2 h-8 bg-primary rounded-full"></div>
                    <h2 class="text-3xl font-black tracking-tight">Biografi</h2>
                </div>
                <div class="prose dark:prose-invert max-w-none text-lg leading-relaxed text-gray-600 dark:text-gray-400">
                    <?php
                    $description = get_the_author_meta('description', $author_id);
                    if ($description) {
                        echo wpautop($description);
                    } else {
                        echo '<p>Penulis ini belum menambahkan biografi.</p>';
                    }
                    ?>
                </div>
            </section>

            <!-- Featured Stories -->
            <?php if ($featured_query->have_posts()): ?>
                <section class="mb-12">
                    <h2 class="text-2xl font-black mb-6 tracking-tight">Berita Utama</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php while ($featured_query->have_posts()): $featured_query->the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="group relative overflow-hidden rounded-3xl h-64 shadow-lg block">
                                <?php if (has_post_thumbnail()): ?>
                                    <img src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php the_title_attribute(); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <?php else: ?>
                                    <div class="absolute inset-0 bg-primary/20"></div>
                                <?php endif; ?>

                                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/20 to-transparent"></div>
                                <div class="absolute bottom-0 p-6">
                                    <?php $cats = get_the_category(); if(!empty($cats)): ?>
                                        <span class="bg-primary text-white text-[10px] font-black px-2 py-0.5 rounded-lg uppercase mb-3 inline-block">
                                            <?php echo esc_html($cats[0]->name); ?>
                                        </span>
                                    <?php endif; ?>
                                    <h3 class="text-white text-xl font-bold leading-tight group-hover:underline">
                                        <?php the_title(); ?>
                                    </h3>
                                </div>
                            </a>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Latest Articles -->
            <section>
                <div class="flex items-center justify-between mb-8 border-b border-gray-100 dark:border-white/5 pb-4">
                    <h2 class="text-2xl font-black tracking-tight">Berita Terbaru</h2>
                </div>
                <div class="space-y-8">
                    <?php if (have_posts()): ?>
                        <?php while (have_posts()): the_post(); ?>
                            <?php get_template_part('template-parts/content', 'card', ['layout' => 'list']); ?>
                        <?php endwhile; ?>

                        <!-- Pagination -->
                        <div class="py-10">
                            <?php the_posts_pagination(array(
                                'prev_text' => '<span class="material-symbols-outlined">chevron_left</span>',
                                'next_text' => '<span class="material-symbols-outlined">chevron_right</span>',
                                'class' => 'mobilenews-pagination'
                            )); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12 bg-gray-50 dark:bg-zinc-900/50 rounded-3xl">
                            <p class="text-gray-500">Belum ada berita yang diterbitkan.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
</main>

<?php
get_footer();
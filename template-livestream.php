<?php
/**
 * Template Name: Live Stream (Modern News)
 */

get_header();
?>

<style>
    /* Livestream Specific Styles */
    .livestream-bg {
        background-color: #0c0c0c;
    }
    .live-indicator {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(220, 38, 38, 0.1);
        color: #ef4444;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.05em;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }
    .live-dot {
        width: 8px;
        height: 8px;
        background-color: #ef4444;
        border-radius: 50%;
        animation: blink 1.2s infinite;
    }
    @keyframes blink {
        0% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(0.8); }
        100% { opacity: 1; transform: scale(1); }
    }
    .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 */
        height: 0;
        overflow: hidden;
        background: #000;
        border-radius: 1.5rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }
    .video-container iframe,
    .video-container object,
    .video-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
</style>

<div class="livestream-bg text-white pb-20">
    <div class="max-w-[1440px] mx-auto px-4 lg:px-10">
        <!-- Live Header Info -->
        <div class="flex flex-col md:flex-row md:items-center justify-between py-10 gap-6">
            <div class="flex-1">
                <div class="live-indicator mb-4">
                    <span class="live-dot"></span>
                    LIVE STREAMING
                </div>
                <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-tight">
                    <?php the_title(); ?>
                </h1>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Watching Now</p>
                    <p class="text-2xl font-black text-accent-yellow">LIVE</p>
                </div>
                <?php get_template_part('template-parts/social-share'); ?>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Continuous Video Column -->
            <div class="lg:col-span-8">
                <div class="video-container mb-10">
                    <?php 
                    // Use Content for Video Embed
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile; 
                    ?>
                </div>

                <div class="bg-[#1a1a1a] rounded-3xl p-8 border border-white/5">
                    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">info</span>
                        Deskripsi Layanan
                    </h2>
                    <div class="prose prose-invert max-w-none text-gray-400">
                        <?php if (has_excerpt()) echo '<p class="text-lg text-white mb-6">' . get_the_excerpt() . '</p>'; ?>
                        <p>Selamat datang di siaran langsung kami. Pastikan koneksi internet Anda stabil untuk pengalaman menonton terbaik. Jika video tidak muncul, silakan segarkan halaman ini.</p>
                    </div>
                </div>
            </div>

            <!-- Interaction Column (Chat / Updates) -->
            <div class="lg:col-span-4 space-y-8">
                <!-- Live Updates Placeholder -->
                <div class="bg-[#1a1a1a] border border-white/5 rounded-3xl overflow-hidden flex flex-col h-full min-h-[500px]">
                    <div class="bg-[#222] px-6 py-4 border-b border-white/5 flex items-center justify-between">
                        <h3 class="font-black text-sm uppercase tracking-tighter">Live Updates</h3>
                        <span class="text-[10px] bg-primary/20 text-primary px-2 py-0.5 rounded font-bold">REAL-TIME</span>
                    </div>
                    <div class="flex-1 p-6">
                        <div class="space-y-6">
                            <?php
                            // Fetch 5 latest posts as "live updates" context if no chat is provided
                            $updates = new WP_Query(array('posts_per_page' => 5));
                            if ($updates->have_posts()) :
                                while ($updates->have_posts()) : $updates->the_post(); ?>
                                    <div class="flex gap-4 group">
                                        <div class="w-1 h-auto bg-primary/20 group-hover:bg-primary transition-colors rounded-full"></div>
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-500 uppercase mb-1"><?php echo get_the_time('H:i'); ?> WIB</p>
                                            <a href="<?php the_permalink(); ?>" class="text-sm font-bold text-gray-200 hover:text-primary transition-colors line-clamp-2"><?php the_title(); ?></a>
                                        </div>
                                    </div>
                                <?php endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>
                    <div class="p-4 bg-[#151515] text-center">
                        <p class="text-[10px] text-gray-600 font-medium">Automatic updates every 60 seconds</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>

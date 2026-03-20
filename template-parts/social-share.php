<?php
/**
 * Template Part: Social Share Buttons (Static Horizontal Version)
 */

// Get current URL and Title
$post_url = urlencode(get_permalink());
$post_title = urlencode(get_the_title());

// Share Links
$facebook_url = "https://www.facebook.com/sharer/sharer.php?u={$post_url}";
$twitter_url = "https://twitter.com/intent/tweet?text={$post_title}&url={$post_url}";
$whatsapp_url = "https://api.whatsapp.com/send?text={$post_title}%20{$post_url}";
$linkedin_url = "https://www.linkedin.com/shareArticle?mini=true&url={$post_url}&title={$post_title}";

?>

<div class="static-social-share mt-8 mb-12 p-6 bg-gray-50 dark:bg-white/5 rounded-2xl border border-gray-100 dark:border-white/5 flex flex-col sm:flex-row items-center justify-between gap-6 transition-colors duration-300">
    <div class="flex items-center gap-3">
        <div class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-[20px]">share</span>
        </div>
        <div>
            <h4 class="text-sm font-black uppercase tracking-wider dark:text-white">Bagikan Berita</h4>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">Bantu sebarkan informasi bermanfaat ini.</p>
        </div>
    </div>

    <div class="flex items-center gap-2 w-full sm:w-auto">
        <a href="<?php echo $facebook_url; ?>" target="_blank" rel="noopener noreferrer"
            class="flex-1 sm:flex-none h-11 px-4 flex items-center justify-center gap-2 rounded-xl bg-[#1877F2] text-white hover:brightness-110 active:scale-95 transition-all shadow-sm"
            title="Share on Facebook">
            <i class="ri-facebook-fill text-lg"></i>
            <span class="text-xs font-bold hidden md:block">Facebook</span>
        </a>
        <a href="<?php echo $twitter_url; ?>" target="_blank" rel="noopener noreferrer"
            class="flex-1 sm:flex-none h-11 px-4 flex items-center justify-center gap-2 rounded-xl bg-black text-white hover:brightness-110 active:scale-95 transition-all shadow-sm"
            title="Share on X">
            <i class="ri-twitter-x-fill text-lg"></i>
            <span class="text-xs font-bold hidden md:block">X</span>
        </a>
        <a href="<?php echo $whatsapp_url; ?>" target="_blank" rel="noopener noreferrer"
            class="flex-1 sm:flex-none h-11 px-4 flex items-center justify-center gap-2 rounded-xl bg-[#25D366] text-white hover:brightness-110 active:scale-95 transition-all shadow-sm"
            title="Share on WhatsApp">
            <i class="ri-whatsapp-line text-lg"></i>
            <span class="text-xs font-bold hidden md:block">WhatsApp</span>
        </a>
        <a href="<?php echo $linkedin_url; ?>" target="_blank" rel="noopener noreferrer"
            class="flex-1 sm:flex-none h-11 w-11 flex items-center justify-center rounded-xl bg-[#0A66C2] text-white hover:brightness-110 active:scale-95 transition-all shadow-sm"
            title="Share on LinkedIn">
            <i class="ri-linkedin-fill text-lg"></i>
        </a>
    </div>
</div>
<?php
/**
 * Landing section: Showcase carousel ("Every match, movie & show — one subscription")
 * Converted from the prerendered landing page 2026-08-20. Markup is reproduced
 * exactly; only copy and links are ACF-driven.
 *
 * @package Nordic_IPTV
 */

if (!defined('ABSPATH')) {
    exit;
}

$lp_showcase_rows = function_exists('get_field') ? get_field('lp_showcase_items', get_option('page_on_front')) : null;

if (empty($lp_showcase_rows) || !is_array($lp_showcase_rows)) {
    $lp_showcase_rows = array(
        array(
            'card_id'    => 'offering-card-live-sports-40k',
            'image'      => 'https://ibostreaming.com/wp-content/uploads/2026/08/live-sports.webp',
            'img_width'  => '1024',
            'img_height' => '1536',
            'title'      => '40,000+ Live Channels & Global Sports',
            'badge'      => '🔥 No Blackouts & Zero Lag',
            'text'       => 'Catch every goal, touchdown, and knockout live in crystal-clear quality. Zero regional blackouts, ultra-low latency streams, and full 7-day catch-up on all devices.',
            'feature'    => 'Anti-Freeze Server Network',
        ),
        array(
            'card_id'    => 'offering-card-movies-series',
            'image'      => 'https://ibostreaming.com/wp-content/uploads/2026/07/movies-series.webp',
            'img_width'  => '896',
            'img_height' => '1200',
            'title'      => '200,000+ VOD Movies & Complete Series',
            'badge'      => '🍿 Updated Daily With New Releases',
            'text'       => 'Cancel your expensive streaming apps! Instant access to over 200,000 cinema blockbusters and complete TV boxsets with multi-language subtitles & spatial audio.',
            'feature'    => 'Multi-Language Subtitles',
        ),
        array(
            'card_id'    => 'offering-card-ppv-events',
            'image'      => 'https://ibostreaming.com/wp-content/uploads/2026/07/ppv-events.webp',
            'img_width'  => '896',
            'img_height' => '1200',
            'title'      => 'Free PPV & Combat Sports Mega-Events',
            'badge'      => '🥊 Zero Pay-Per-View Fees',
            'text'       => 'Stop paying $80+ per event! Stream every MMA main card, championship boxing fight night, live wrestling event, and global pay-per-view mega-event live at no extra cost.',
            'feature'    => 'Save $80 Per Fight Night',
        ),
        array(
            'card_id'    => 'offering-card-live-news',
            'image'      => 'https://ibostreaming.com/wp-content/uploads/2026/07/live-news.webp',
            'img_width'  => '896',
            'img_height' => '1200',
            'title'      => '24/7 Worldwide Live News Networks',
            'badge'      => '⚡ Real-Time Breaking Coverage',
            'text'       => 'Stay informed around the clock with direct satellite feeds from leading international news, financial, and local world networks with zero stream delay.',
            'feature'    => 'Direct Satellite Feed',
        ),
        array(
            'card_id'    => 'offering-card-documentaries',
            'image'      => 'https://ibostreaming.com/wp-content/uploads/2026/07/documentaries.webp',
            'img_width'  => '896',
            'img_height' => '1200',
            'title'      => 'Documentaries & Nature Networks',
            'badge'      => '🌿 Unlimited Binge Watching',
            'text'       => 'Immerse yourself in breathtaking nature, science, space, true crime, and history documentary series from world-class producers in spatial surround sound.',
            'feature'    => 'Nature & Wildlife',
        ),
        array(
            'card_id'    => 'offering-card-kids-family',
            'image'      => 'https://ibostreaming.com/wp-content/uploads/2026/07/kids-family.webp',
            'img_width'  => '896',
            'img_height' => '1200',
            'title'      => 'Kids & Family Entertainment Hub',
            'badge'      => '🛡️ Parental Control Locked',
            'text'       => 'Safe, 100% commercial-free entertainment for children of all ages. Hundreds of live kids channels and animated family movies with instant multi-language audio.',
            'feature'    => '100% Commercial-Free',
        ),
    );
}

// ACF image sub-fields return an array, an ID or a URL depending on the field's
// return format. Normalise all three to a URL string.
$lp_showcase_img_url = function ($image) {
    if (is_array($image)) {
        return isset($image['url']) ? $image['url'] : '';
    }
    if (is_numeric($image)) {
        return (string) wp_get_attachment_url((int) $image);
    }
    return (string) $image;
};

$lp_showcase_total    = str_pad((string) count($lp_showcase_rows), 2, '0', STR_PAD_LEFT);
$lp_showcase_card_cta = iptv_text('lp_showcase_card_cta', 'Access');
?>
<section class="relative w-full bg-zinc-950 text-white py-10 sm:py-14 px-4 sm:px-6 lg:px-8 font-sans overflow-hidden select-none border-b border-zinc-800/60" id="whats-popular-section"><div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-full bg-[radial-gradient(ellipse_at_top,rgba(0,124,235,0.08),transparent_70%)] pointer-events-none"></div><div class="max-w-[1280px] mx-auto space-y-5 relative z-10"><div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-3 border-b border-zinc-800/80"><div class="space-y-1.5 max-w-2xl"><div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-blue-500/10 text-[#38b6ff] border border-blue-500/30 text-[10px] font-extrabold uppercase tracking-wider"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up w-3 h-3 text-[#007CEB]" aria-hidden="true"><path d="M16 7h6v6"></path><path d="m22 7-8.5 8.5-5-5L2 17"></path></svg><span><?php echo esc_html(iptv_text('lp_showcase_eyebrow', '⚡ UNLIMITED 4K ENTERTAINMENT')); ?></span></div><h2 class="font-heading font-black text-xl sm:text-2xl lg:text-3xl text-white tracking-tight uppercase"><?php echo esc_html(iptv_text('lp_showcase_title', 'EVERY MATCH, MOVIE & SHOW — ')); ?><span class="text-[#38b6ff]"><?php echo esc_html(iptv_text('lp_showcase_title_accent', 'ONE SUBSCRIPTION')); ?></span></h2><p class="font-sans text-xs sm:text-sm text-zinc-300 leading-relaxed font-normal"><?php echo esc_html(iptv_text('lp_showcase_subtitle', 'Stop paying $200+/month to expensive cable & fragmented apps. Unlock 40,000+ live HD/4K channels, 200,000+ movies, every PPV fight night, and 60FPS live sports with zero buffering on all your devices.')); ?></p></div><div class="flex items-center gap-3 self-start sm:self-end"><div class="flex items-center gap-1.5 bg-zinc-900 border border-zinc-800 px-3.5 py-1 rounded-full text-xs font-mono font-bold text-zinc-400 shadow-inner"><span class="text-white font-extrabold">01</span><span class="text-zinc-600">/</span><span><?php echo esc_html($lp_showcase_total); ?></span></div><div class="flex items-center gap-1.5"><button disabled="" class="min-h-[44px] min-w-[44px] p-2.5 rounded-full border transition-all duration-200 shadow-md active:scale-95 flex items-center justify-center bg-zinc-900/50 border-zinc-800/50 text-zinc-600 cursor-not-allowed opacity-40" aria-label="Scroll Left"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left w-4 h-4 stroke-[2.5]" aria-hidden="true"><path d="m15 18-6-6 6-6"></path></svg></button><button class="min-h-[44px] min-w-[44px] p-2.5 rounded-full border transition-all duration-200 shadow-md active:scale-95 flex items-center justify-center bg-zinc-900 border-zinc-700 hover:bg-[#007CEB] hover:text-white hover:border-blue-500 text-zinc-200 cursor-pointer" aria-label="Scroll Right"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-4 h-4 stroke-[2.5]" aria-hidden="true"><path d="m9 18 6-6-6-6"></path></svg></button></div></div></div><div class="relative group/carousel"><button class="absolute right-1 sm:right-2 top-1/2 -translate-y-1/2 z-20 p-3 sm:p-3.5 rounded-full bg-zinc-900/90 hover:bg-[#007CEB] text-white border border-zinc-700 shadow-2xl backdrop-blur-md transition-all duration-200 active:scale-95 flex items-center justify-center cursor-pointer" aria-label="Scroll Carousel Right"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-5 h-5 stroke-[2.5]" aria-hidden="true"><path d="m9 18 6-6-6-6"></path></svg></button><div class="pointer-events-none absolute right-0 top-0 bottom-0 w-12 bg-gradient-to-l from-zinc-950 via-zinc-950/80 to-transparent z-10"></div><div class="flex flex-nowrap gap-4 sm:gap-5 overflow-x-auto pb-4 pt-1 px-1 no-scrollbar snap-x snap-mandatory scroll-smooth cursor-grab active:cursor-grabbing" style="scrollbar-width: none;"><?php foreach ($lp_showcase_rows as $lp_showcase_row) :
    $lp_showcase_title_row = isset($lp_showcase_row['title']) ? $lp_showcase_row['title'] : '';
    ?><div class="snap-start flex-none"><div class="group relative flex-none w-[170px] sm:w-[190px] lg:w-[205px] bg-zinc-900/90 rounded-xl overflow-hidden select-none transition-all duration-300 border border-zinc-800/80 hover:border-blue-500/60 hover:shadow-xl hover:shadow-blue-600/15 shadow-md flex flex-col" id="<?php echo esc_attr(isset($lp_showcase_row['card_id']) ? $lp_showcase_row['card_id'] : ''); ?>"><div class="relative w-full aspect-[2/3] bg-zinc-950 overflow-hidden"><img width="<?php echo esc_attr(isset($lp_showcase_row['img_width']) ? $lp_showcase_row['img_width'] : ''); ?>" height="<?php echo esc_attr(isset($lp_showcase_row['img_height']) ? $lp_showcase_row['img_height'] : ''); ?>" alt="<?php echo esc_attr($lp_showcase_title_row); ?>" referrerpolicy="no-referrer" loading="lazy" decoding="async" class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105" src="<?php echo esc_url($lp_showcase_img_url(isset($lp_showcase_row['image']) ? $lp_showcase_row['image'] : '')); ?>"><div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/20 to-transparent opacity-80"></div><div class="absolute bottom-2 left-2 right-2 z-10"><span class="inline-block w-full text-[9px] sm:text-[10px] font-semibold text-zinc-200 bg-black/80 backdrop-blur-md px-2 py-0.5 sm:py-1 rounded border border-zinc-700/60 truncate text-center shadow-xs"><?php echo esc_html(isset($lp_showcase_row['badge']) ? $lp_showcase_row['badge'] : ''); ?></span></div></div><div class="p-2.5 sm:p-3 flex flex-col justify-between flex-1 bg-zinc-900 space-y-2"><div class="space-y-0.5"><h3 class="font-heading font-black text-xs sm:text-sm text-white leading-tight uppercase tracking-tight line-clamp-1 group-hover:text-[#38b6ff] transition-colors duration-200"><?php echo esc_html($lp_showcase_title_row); ?></h3><p class="text-[10px] sm:text-[11px] font-sans text-zinc-400 line-clamp-2 leading-snug"><?php echo esc_html(isset($lp_showcase_row['text']) ? $lp_showcase_row['text'] : ''); ?></p></div><div class="pt-1.5 border-t border-zinc-800/80 flex items-center justify-between gap-1 text-[10px] font-bold"><span class="text-zinc-300 flex items-center gap-1 truncate text-[9px] sm:text-[10px]"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles w-2.5 h-2.5 sm:w-3 sm:h-3 text-[#007CEB] flex-none" aria-hidden="true"><path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path><path d="M20 2v4"></path><path d="M22 4h-4"></path><circle cx="4" cy="20" r="2"></circle></svg><span class="truncate"><?php echo esc_html(isset($lp_showcase_row['feature']) ? $lp_showcase_row['feature'] : ''); ?></span></span><button class="bg-[#007CEB] hover:bg-[#0066c7] active:scale-95 text-white text-[9px] sm:text-[10px] font-extrabold uppercase tracking-wider px-2 sm:px-2.5 py-1 rounded-md flex items-center gap-1 shadow-sm transition-all duration-150 cursor-pointer flex-none border border-blue-400/30"><span><?php echo esc_html($lp_showcase_card_cta); ?></span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play w-2 h-2 sm:w-2.5 sm:h-2.5 fill-current" aria-hidden="true"><path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"></path></svg></button></div></div></div></div><?php endforeach; ?></div></div></div></section>

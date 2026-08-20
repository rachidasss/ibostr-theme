<?php
/**
 * Landing section: One Subscription. Every Channel Worldwide. (features)
 * Converted from the prerendered landing page 2026-08-20. Markup is reproduced
 * exactly; only copy and links are ACF-driven.
 *
 * @package iBostreaming
 */

if (!defined('ABSPATH')) {
    exit;
}

$lp_feat_front_id = get_option('page_on_front');

/** Sub-field reader: repeater rows come back with missing keys when a row is half filled. */
$lp_feat_sub = function ($row, $key) {
    return (is_array($row) && isset($row[$key]) && is_string($row[$key])) ? $row[$key] : '';
};

/**
 * Card icons. The SVG is design, not copy, so it stays in the template and the
 * repeater only carries a slug. Unknown slug renders no icon rather than markup
 * from the database.
 */
$lp_feat_icons = array(
    'tv'         => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tv w-5 h-5 stroke-[2]" aria-hidden="true"><path d="m17 2-5 5-5-5"></path><rect width="20" height="15" x="2" y="7" rx="2"></rect></svg>',
    'film'       => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-film w-5 h-5 stroke-[2]" aria-hidden="true"><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M7 3v18"></path><path d="M3 7.5h4"></path><path d="M3 12h18"></path><path d="M3 16.5h4"></path><path d="M17 3v18"></path><path d="M17 7.5h4"></path><path d="M17 16.5h4"></path></svg>',
    'zap'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-5 h-5 stroke-[2]" aria-hidden="true"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path></svg>',
    'sparkles'   => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles w-5 h-5 stroke-[2]" aria-hidden="true"><path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path><path d="M20 2v4"></path><path d="M22 4h-4"></path><circle cx="4" cy="20" r="2"></circle></svg>',
    'compass'    => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-compass w-5 h-5 stroke-[2]" aria-hidden="true"><path d="m16.24 7.76-1.804 5.411a2 2 0 0 1-1.265 1.265L7.76 16.24l1.804-5.411a2 2 0 0 1 1.265-1.265z"></path><circle cx="12" cy="12" r="10"></circle></svg>',
    'headphones' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-headphones w-5 h-5 stroke-[2]" aria-hidden="true"><path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"></path></svg>',
);

/* ---- Country chips ---- */
$lp_feat_countries = iptv_lp_list('lp_feat_countries', array(
    array('label' => '🇺🇸 USA'),
    array('label' => '🇫🇷 France'),
    array('label' => '🇨🇦 Canada'),
    array('label' => '🇩🇪 Germany'),
    array('label' => '🇬🇧 UK'),
    array('label' => '🇨🇭 Switzerland'),
), 'label');

/* ---- Trust strip ---- */
$lp_feat_stats = iptv_lp_list('lp_feat_stats', array(
    array('label' => '40k+ Worldwide Live Channels'),
    array('label' => '200k+ Movies & Multi-Lang VOD'),
    array('label' => 'Anti-Freeze™ 100Gbps Servers'),
    array('label' => 'Instant 2-Minute Activation'),
), 'label');

/* ---- Feature cards ---- */
$lp_feat_cards = iptv_lp_list('lp_feat_cards', array(
    array(
        'icon'  => 'tv',
        'badge' => 'USA • FR • CA • DE • UK • CH',
        'title' => '40,000+ Worldwide Channels',
        'text'  => 'Complete live sports & premium TV from USA, France, Canada, Germany, UK & Switzerland. Football, American football, basketball, motorsport & MMA in 60FPS.',
        'tag_1' => '✓ USA, FR, CA, DE, UK, CH',
        'tag_2' => '✓ Live Football & Cup Nights',
        'tag_3' => '✓ Live Sports in 60FPS',
    ),
    array(
        'icon'  => 'film',
        'badge' => 'MULTI-AUDIO & SUBS',
        'title' => '200,000+ 4K Movies & Series',
        'text'  => 'Latest cinema blockbusters & complete box sets from the biggest studios and networks with multi-language audio (EN, FR, DE) and subtitles.',
        'tag_1' => '✓ Cinema 4K HDR',
        'tag_2' => '✓ Multi-Audio Dubs',
        'tag_3' => '✓ Daily VOD Updates',
    ),
    array(
        'icon'  => 'zap',
        'badge' => '99.9% UPTIME GUARANTEE',
        'title' => 'Anti-Freeze™ Load Balancing',
        'text'  => 'Engineered with 100Gbps high-capacity global edge servers ensuring smooth, zero-buffer playback even during high-traffic finals and title-decider events.',
        'tag_1' => '✓ Zero Buffering Tech',
        'tag_2' => '✓ 100Gbps Edge Network',
        'tag_3' => '✓ Ultra-Low Latency',
    ),
    array(
        'icon'  => 'sparkles',
        'badge' => 'OLED & SMART TV READY',
        'title' => 'True 4K Ultra HD & 60 FPS',
        'text'  => 'Native high-bitrate streaming with vibrant HDR colors and crisp Dolby Digital 5.1 surround sound tuned for big-screen TVs.',
        'tag_1' => '✓ Uncompressed 4K',
        'tag_2' => '✓ 60 FPS Smooth Motion',
        'tag_3' => '✓ Dolby Surround',
    ),
    array(
        'icon'  => 'compass',
        'badge' => 'FULL REPLAY GUIDE',
        'title' => '7-Day Catch-Up & Smart EPG',
        'text'  => 'Never miss a goal or episode. Rewind live sports, access interactive TV program schedules, and replay past 7 days instantly.',
        'tag_1' => '✓ 7-Day Replay',
        'tag_2' => '✓ Interactive TV Guide',
        'tag_3' => '✓ Pause & Rewind Live',
    ),
    array(
        'icon'  => 'headphones',
        'badge' => '2-MIN ACTIVATION',
        'title' => 'Instant Setup & 24/7 VIP Help',
        'text'  => 'Instant login delivery right after purchase. Compatible with Smart TV, Firestick, Apple TV, Android, MAG, iOS & PC with live 24/7 setup support.',
        'tag_1' => '✓ Firestick & Smart TV',
        'tag_2' => '✓ Instant Email/WhatsApp',
        'tag_3' => '✓ 24/7 Live Support',
    ),
));
?>
<section class="relative w-full bg-[#FAFAFC] text-zinc-900 py-12 sm:py-16 px-4 sm:px-6 lg:px-8 font-sans border-t border-b border-zinc-200/80 select-none overflow-hidden" id="features-section"><div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-full bg-[radial-gradient(ellipse_at_top,rgba(0,124,235,0.06),transparent_60%)] pointer-events-none"></div><div class="max-w-6xl mx-auto space-y-8 relative z-10"><div class="text-center space-y-3 max-w-3xl mx-auto"><div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-blue-50 border border-blue-200/80 text-[#007CEB] text-[11px] font-extrabold uppercase tracking-wider shadow-2xs"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-flame w-3.5 h-3.5 fill-[#007CEB] text-[#007CEB] flex-none" aria-hidden="true"><path d="M12 3q1 4 4 6.5t3 5.5a1 1 0 0 1-14 0 5 5 0 0 1 1-3 1 1 0 0 0 5 0c0-2-1.5-3-1.5-5q0-2 2.5-4"></path></svg><span><?php echo esc_html(iptv_text('lp_feat_badge', 'WORLDWIDE PREMIUM ENTERTAINMENT')); ?></span></div><h2 class="font-heading font-black text-2xl sm:text-3xl lg:text-4xl text-zinc-950 tracking-tight leading-tight uppercase"><?php echo esc_html(iptv_text('lp_feat_title', 'One Subscription.')); ?> <span class="text-[#007CEB]"><?php echo esc_html(iptv_text('lp_feat_title_accent', 'Every Channel Worldwide.')); ?></span></h2><p class="font-sans text-xs sm:text-sm text-zinc-600 max-w-2xl mx-auto leading-relaxed font-normal"><?php echo wp_kses_post(iptv_text('lp_feat_subtitle', 'Streaming built for top demand across <strong class="text-zinc-900 font-bold">USA, France, Canada, Germany, UK &amp; Switzerland</strong>. Raw 4K streams, full sports packages, 200,000+ VODs and anti-freeze reliability.')); ?></p><div class="pt-1 flex flex-wrap items-center justify-center gap-2 text-xs font-bold text-zinc-700"><?php foreach ($lp_feat_countries as $lp_feat_country) : ?><span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white border border-zinc-200/90 shadow-2xs"><?php echo esc_html($lp_feat_sub($lp_feat_country, 'label')); ?></span><?php endforeach; ?><span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 text-[#007CEB] border border-blue-200/80 shadow-2xs font-extrabold"><?php echo esc_html(iptv_text('lp_feat_countries_more', '+ 140 More')); ?></span></div></div><div class="p-3.5 rounded-2xl bg-white border border-zinc-200/90 flex flex-wrap items-center justify-around gap-3 text-xs font-bold text-zinc-800 text-center shadow-xs"><?php foreach ($lp_feat_stats as $lp_feat_stat) : ?><div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4 text-emerald-600 flex-none" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg><span><?php echo esc_html($lp_feat_sub($lp_feat_stat, 'label')); ?></span></div><?php endforeach; ?></div><div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5"><?php
foreach ($lp_feat_cards as $lp_feat_card) :
    $lp_feat_icon_key = $lp_feat_sub($lp_feat_card, 'icon');
    $lp_feat_icon = isset($lp_feat_icons[$lp_feat_icon_key]) ? $lp_feat_icons[$lp_feat_icon_key] : '';
    $lp_feat_tags = array(
        $lp_feat_sub($lp_feat_card, 'tag_1'),
        $lp_feat_sub($lp_feat_card, 'tag_2'),
        $lp_feat_sub($lp_feat_card, 'tag_3'),
    );
    ?><div class="bg-white rounded-2xl p-5 border border-zinc-200/90 hover:border-blue-500/50 hover:shadow-xl transition-all duration-250 flex flex-col justify-between space-y-4 group relative overflow-hidden"><div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/5 rounded-bl-full pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div><div class="space-y-2.5"><div class="flex items-start justify-between gap-2"><div class="p-2.5 rounded-xl bg-blue-50 text-[#007CEB] border border-blue-200/70 flex-none group-hover:bg-[#007CEB] group-hover:text-white transition-colors duration-200"><?php echo $lp_feat_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG from the map above ?></div><span class="text-[10px] font-black uppercase bg-blue-50 text-[#007CEB] px-2.5 py-1 rounded-md border border-blue-200/80 flex-none whitespace-nowrap tracking-wide"><?php echo esc_html($lp_feat_sub($lp_feat_card, 'badge')); ?></span></div><h3 class="font-heading font-black text-base sm:text-lg text-zinc-950 tracking-tight leading-snug group-hover:text-[#007CEB] transition-colors duration-200"><?php echo esc_html($lp_feat_sub($lp_feat_card, 'title')); ?></h3><p class="font-sans text-xs sm:text-sm text-zinc-600 leading-relaxed font-normal"><?php echo esc_html($lp_feat_sub($lp_feat_card, 'text')); ?></p></div><div class="flex flex-wrap items-center gap-1.5 pt-2 border-t border-zinc-100"><?php foreach ($lp_feat_tags as $lp_feat_tag) : if ($lp_feat_tag === '') { continue; } ?><span class="text-[10px] font-mono font-bold text-zinc-700 bg-zinc-100/90 px-2 py-0.5 rounded-md border border-zinc-200/80 tracking-wider uppercase"><?php echo esc_html($lp_feat_tag); ?></span><?php endforeach; ?></div></div><?php endforeach; ?></div><div class="p-4 sm:p-5 rounded-2xl bg-zinc-900 border border-zinc-800/90 shadow-xl flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4 text-xs sm:text-sm"><div class="flex items-center gap-3 font-semibold text-left w-full sm:w-auto"><div class="p-2 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 flex-none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-5 h-5" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg></div><div class="min-w-0 flex-1"><div class="font-heading font-bold text-white text-xs sm:text-base leading-snug"><?php echo esc_html(iptv_text('lp_feat_cta_title', 'Ready for 4K streaming anywhere in the world?')); ?></div><div class="text-zinc-400 text-[11px] sm:text-xs font-normal truncate sm:whitespace-normal"><?php echo esc_html(iptv_text('lp_feat_cta_subtitle', 'Instant 2-minute setup • No contracts • Money-back guarantee')); ?></div></div></div><button class="w-full sm:w-auto bg-[#007CEB] hover:bg-[#0066c7] active:scale-95 text-white font-heading font-black text-xs py-2.5 sm:py-3 px-4 sm:px-5 rounded-xl flex items-center justify-center gap-2 uppercase tracking-wider shadow-md cursor-pointer border border-blue-400/30 transition-all duration-200 flex-none" id="features-compact-cta-btn"><span><?php echo esc_html(iptv_text('lp_feat_cta_button', 'Start Streaming — Choose Plan')); ?></span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-3.5 h-3.5 sm:w-4 sm:h-4 stroke-[2.5] flex-none" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></button></div></div></section>

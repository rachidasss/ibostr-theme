<?php
/**
 * Landing section: Hero (cinematic)
 * Converted from the prerendered landing page 2026-08-20. Markup is reproduced
 * exactly; only copy and links are ACF-driven.
 */
if (!defined('ABSPATH')) { exit; }

$lp_hero_front_id = get_option('page_on_front');

// Background artwork. src and srcset are two separate fields on purpose: the
// srcset lists WordPress' generated sizes for this exact upload, so swapping the
// image means replacing both. Keeping them in one field would silently leave the
// old sizes behind.
$lp_hero_bg_url    = iptv_text('lp_hero_bg_url', 'https://ibostreaming.com/wp-content/uploads/2026/07/hero-bg.webp');
$lp_hero_bg_srcset = iptv_text('lp_hero_bg_srcset', 'https://ibostreaming.com/wp-content/uploads/2026/07/hero-bg-768x429.webp 768w, https://ibostreaming.com/wp-content/uploads/2026/07/hero-bg-1024x572.webp 1024w, https://ibostreaming.com/wp-content/uploads/2026/07/hero-bg.webp 1376w');

// Trust row. Each item carries its own lucide icon; the key selects one of the
// four SVGs below, which are reproduced verbatim (class strings included, since
// the icon colour lives in the class string).
$lp_hero_trust_icons = array(
    'circle-check' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-3.5 h-3.5 text-emerald-400 flex-none" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>',
    'shield-check' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-3.5 h-3.5 text-emerald-400 flex-none" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg>',
    'zap'          => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-3.5 h-3.5 text-sky-400 flex-none" aria-hidden="true"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path></svg>',
    'tv'           => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tv w-3.5 h-3.5 text-purple-400 flex-none" aria-hidden="true"><path d="m17 2-5 5-5-5"></path><rect width="20" height="15" x="2" y="7" rx="2"></rect></svg>',
);

$lp_hero_trust_items = function_exists('get_field') ? get_field('lp_hero_trust_items', $lp_hero_front_id) : null;
if (empty($lp_hero_trust_items) || !is_array($lp_hero_trust_items)) {
    $lp_hero_trust_items = array(
        array('text' => 'Instant 2-Min Setup',          'icon' => 'circle-check'),
        array('text' => '7-Day Money Back Guarantee',   'icon' => 'shield-check'),
        array('text' => 'No Contract & No Hidden Fees', 'icon' => 'zap'),
        array('text' => 'Works On All Devices',         'icon' => 'tv'),
    );
}
?>
<section class="relative w-full min-h-[500px] sm:min-h-[560px] lg:min-h-[600px] flex flex-col justify-center bg-zinc-950 text-white font-sans overflow-hidden select-none border-b border-zinc-800" id="hero-cinematic-section"><div class="absolute inset-0 z-0"><img data-perfmatters-preload width="1376" height="768" decoding="async" alt="<?php echo esc_attr(iptv_text('lp_hero_bg_alt', 'iBo Streaming 4K Ultra HD Background')); ?>" class="w-full h-full object-cover object-center sm:object-right opacity-85 filter contrast-110 saturate-110" referrerpolicy="no-referrer" src="<?php echo esc_url($lp_hero_bg_url); ?>" srcset="<?php echo esc_attr($lp_hero_bg_srcset); ?>" sizes="100vw" fetchpriority="high"><div class="absolute inset-0 bg-gradient-to-r from-zinc-950/98 via-zinc-950/80 sm:via-zinc-950/50 to-transparent"></div><div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/20 to-zinc-950/40"></div></div><div class="relative z-10 w-full max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 pt-20 sm:pt-28 lg:pt-32 pb-10 sm:pb-16 my-auto"><div class="max-w-2xl space-y-4"><div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-zinc-900/90 border border-zinc-800 text-[#38b6ff] font-sans font-extrabold text-[11px] sm:text-xs uppercase tracking-wider shadow-sm backdrop-blur-md"><span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-[#007CEB]"></span></span><span><?php echo esc_html(iptv_text('lp_hero_badge', '#1 iBo Streaming Service • 4K Ultra HD')); ?></span></div><h1 class="font-heading font-black text-2xl sm:text-4xl lg:text-[44px] leading-[1.12] text-white tracking-tight"><?php echo esc_html(iptv_text('lp_hero_title', 'Every Channel You\'ve Been Missing')); ?> <span class="text-[#38b6ff]"><?php echo esc_html(iptv_text('lp_hero_title_accent', 'All in One Place.')); ?></span><span class="block text-emerald-400 font-extrabold text-xl sm:text-2xl lg:text-3xl mt-1.5"><?php echo esc_html(iptv_text('lp_hero_title_savings', 'Save $1,500/Year.')); ?></span></h1><p class="font-sans font-normal text-xs sm:text-sm lg:text-base leading-relaxed text-zinc-300 max-w-xl"><?php echo esc_html(iptv_text('lp_hero_subtitle', 'The world\'s largest IPTV service. Watch 40,000+ channels from USA, UK, Canada, Europe, Asia, and Latin America in crystal-clear 4K. No contracts. One time payment. No regional blocks. Works on any device, anywhere.')); ?></p><div class="pt-2 space-y-3"><div class="flex flex-wrap items-center gap-3"><button class="bg-gradient-to-r from-[#007CEB] to-[#005bb5] hover:from-[#0066c7] hover:to-[#004a99] text-white font-bold text-xs sm:text-sm px-5 sm:px-6 py-2.5 sm:py-3 rounded-xl flex items-center justify-center gap-2 shadow-lg shadow-blue-600/30 transition-all duration-200 active:scale-95 cursor-pointer border border-blue-400/30" id="hero-start-subscription-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles w-3.5 h-3.5 sm:w-4 sm:h-4 fill-white text-white flex-none" aria-hidden="true"><path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path><path d="M20 2v4"></path><path d="M22 4h-4"></path><circle cx="4" cy="20" r="2"></circle></svg><span><?php echo esc_html(iptv_text('lp_hero_cta_label', 'Claim Discount')); ?></span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-3.5 h-3.5 sm:w-4 sm:h-4 flex-none" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></button></div><div class="flex flex-wrap items-center gap-x-3.5 gap-y-1.5 text-[11px] sm:text-xs text-zinc-300 font-medium pt-1"><?php
$lp_hero_trust_first = true;
foreach ($lp_hero_trust_items as $lp_hero_trust_item) {
    $lp_hero_trust_text = isset($lp_hero_trust_item['text']) ? $lp_hero_trust_item['text'] : '';
    if ($lp_hero_trust_text === '') {
        continue;
    }
    $lp_hero_trust_key = isset($lp_hero_trust_item['icon']) ? $lp_hero_trust_item['icon'] : '';
    $lp_hero_trust_svg = isset($lp_hero_trust_icons[$lp_hero_trust_key]) ? $lp_hero_trust_icons[$lp_hero_trust_key] : $lp_hero_trust_icons['circle-check'];

    // The bullet divider sits *between* items, never after the last one.
    if (!$lp_hero_trust_first) {
        echo '<span class="text-zinc-700 hidden sm:inline">•</span>';
    }
    $lp_hero_trust_first = false;

    echo '<span class="flex items-center gap-1.5">' . $lp_hero_trust_svg . esc_html($lp_hero_trust_text) . '</span>';
}
?></div></div></div></div></section>

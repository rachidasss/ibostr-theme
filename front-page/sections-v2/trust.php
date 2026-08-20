<?php
/**
 * Landing section: Trust / "Tired of IPTV providers who take your money & disappear?"
 * Converted from the prerendered landing page 2026-08-20. Markup is reproduced
 * exactly; only copy and links are ACF-driven.
 *
 * @package Nordic_IPTV
 */

if (!defined('ABSPATH')) {
    exit;
}

$lp_trust_front_id = get_option('page_on_front');

$lp_trust_bad_items = function_exists('get_field') ? get_field('lp_trust_bad_items', $lp_trust_front_id) : null;
if (empty($lp_trust_bad_items) || !is_array($lp_trust_bad_items)) {
    $lp_trust_bad_items = array(
        array(
            'title' => 'Sell & Disappear (Zero Support)',
            'text'  => 'Once you pay, support tickets go unanswered right when you need help.',
        ),
        array(
            'title' => 'Buffering During Big Matches',
            'text'  => 'Cheap, overcrowded servers freeze right when the match is at peak excitement.',
        ),
        array(
            'title' => 'Confusing Setup & Broken Links',
            'text'  => 'Complex setup instructions with cryptic links that stop working without warning.',
        ),
        array(
            'title' => 'Geo-Blocked & Unstable Channels',
            'text'  => 'Channels frequently go offline or block in USA, France, Canada, Germany, UK without VPN.',
        ),
    );
}

$lp_trust_good_items = function_exists('get_field') ? get_field('lp_trust_good_items', $lp_trust_front_id) : null;
if (empty($lp_trust_good_items) || !is_array($lp_trust_good_items)) {
    $lp_trust_good_items = array(
        array(
            'title' => 'Support For Entire Subscription Duration',
            'text'  => 'Our live technical VIP team is online 24/7 on WhatsApp & Email whenever you need help.',
        ),
        array(
            'title' => 'Free Step-by-Step Installation Help',
            'text'  => 'We guide you until live TV is playing smoothly on Smart TV, Firestick, Apple TV, or phone.',
        ),
        array(
            'title' => '100Gbps Dedicated Anti-Freeze™ Servers',
            'text'  => 'Load-balanced servers engineered for live events — uncompressed 4K with 60FPS motion smoothness.',
        ),
        array(
            'title' => 'Worldwide Channels with Zero Regional Blocks',
            'text'  => '40,000+ live channels & 200,000+ VOD from USA, France, Canada, Germany, UK without VPN.',
        ),
    );
}
?>
<section class="relative w-full bg-zinc-950 text-white py-12 sm:py-16 px-4 sm:px-6 lg:px-8 font-sans overflow-hidden border-b border-zinc-800/60 select-none" id="why-us-section">
<div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-full bg-[radial-gradient(ellipse_at_top,rgba(0,124,235,0.08),transparent_70%)] pointer-events-none"></div>
<div class="max-w-6xl mx-auto space-y-8 relative z-10">
<div class="text-center max-w-2xl mx-auto space-y-2.5">
<div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-500/10 text-[#38b6ff] border border-blue-500/30 text-xs font-extrabold uppercase tracking-wider">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-3.5 h-3.5 text-[#007CEB] flex-none" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg>
<span><?php echo esc_html(iptv_text('lp_trust_eyebrow', 'THE REAL IPTV TRUTH')); ?></span>
</div>
<h2 class="font-heading font-black text-2xl sm:text-3xl lg:text-4xl text-white tracking-tight leading-tight uppercase"><?php echo esc_html(iptv_text('lp_trust_title', 'TIRED OF IPTV PROVIDERS WHO')); ?> <span class="text-red-500"><?php echo esc_html(iptv_text('lp_trust_title_accent', 'TAKE YOUR MONEY & DISAPPEAR?')); ?></span></h2>
<p class="font-sans text-xs sm:text-sm text-zinc-400 leading-relaxed font-normal"><?php echo wp_kses_post(iptv_text('lp_trust_subtitle', 'Most IPTV sellers vanish the moment you make a payment. At <strong class="text-white font-bold">iBo Streaming</strong>, we support you for every single day of your subscription — guaranteed 24/7 assistance and anti-freeze servers.')); ?></p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-6 items-stretch">
<div class="bg-zinc-900/90 rounded-2xl p-5 sm:p-6 border border-red-900/40 relative overflow-hidden flex flex-col justify-between space-y-4 shadow-xl">
<div class="space-y-2.5">
<div class="flex items-center justify-between border-b border-zinc-800/80 pb-3">
<div class="flex items-center gap-2 text-red-400 font-heading font-black text-base sm:text-lg uppercase tracking-tight">
<div class="p-1.5 rounded-lg bg-red-950/80 border border-red-800/50 text-red-400 flex-none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-x w-4 h-4 stroke-[2.5]" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="17" x2="22" y1="8" y2="13"></line><line x1="22" x2="17" y1="8" y2="13"></line></svg></div>
<span><?php echo esc_html(iptv_text('lp_trust_bad_heading', 'Other IPTV Sellers')); ?></span>
</div>
<span class="text-[10px] font-mono font-bold uppercase bg-red-950/90 text-red-300 px-2 py-0.5 rounded border border-red-800/60"><?php echo esc_html(iptv_text('lp_trust_bad_badge', '⚠️ HIGH RISK')); ?></span>
</div>
<ul class="space-y-3 pt-1">
<?php foreach ($lp_trust_bad_items as $lp_trust_bad_item) : ?>
<li class="flex items-start gap-2.5">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x w-4 h-4 text-red-500 flex-none mt-0.5" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><path d="m15 9-6 6"></path><path d="m9 9 6 6"></path></svg>
<div class="space-y-0.5">
<strong class="text-zinc-200 text-xs sm:text-sm font-bold block"><?php echo esc_html(isset($lp_trust_bad_item['title']) ? $lp_trust_bad_item['title'] : ''); ?></strong>
<p class="text-zinc-400 text-xs leading-relaxed"><?php echo esc_html(isset($lp_trust_bad_item['text']) ? $lp_trust_bad_item['text'] : ''); ?></p>
</div>
</li>
<?php endforeach; ?>
</ul>
</div>
<div class="pt-2 border-t border-zinc-800/80 text-center text-[11px] sm:text-xs text-red-400/90 font-medium"><?php echo esc_html(iptv_text('lp_trust_bad_footnote', '❌ Don\'t waste money on sellers who abandon you after day one.')); ?></div>
</div>
<div class="bg-gradient-to-b from-zinc-900 via-zinc-900 to-zinc-950 rounded-2xl p-5 sm:p-6 border border-[#007CEB]/60 relative overflow-hidden flex flex-col justify-between space-y-4 shadow-xl shadow-blue-950/20">
<div class="space-y-2.5">
<div class="flex items-center justify-between border-b border-zinc-800/80 pb-3">
<div class="flex items-center gap-2 text-white font-heading font-black text-base sm:text-lg uppercase tracking-tight">
<div class="p-1.5 rounded-lg bg-[#007CEB] text-white flex-none shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-check w-4 h-4 stroke-[2.5]" aria-hidden="true"><path d="m16 11 2 2 4-4"></path><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg></div>
<span><?php echo esc_html(iptv_text('lp_trust_good_heading', 'The iBo Streaming Guarantee')); ?></span>
</div>
<span class="text-[10px] font-mono font-bold uppercase bg-emerald-500/20 text-emerald-400 px-2 py-0.5 rounded border border-emerald-500/40 flex items-center gap-1">
<span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
<span><?php echo esc_html(iptv_text('lp_trust_good_badge', '100% RELIABLE')); ?></span>
</span>
</div>
<ul class="space-y-3 pt-1">
<?php foreach ($lp_trust_good_items as $lp_trust_good_item) : ?>
<li class="flex items-start gap-2.5">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4 text-emerald-400 flex-none mt-0.5" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
<div class="space-y-0.5">
<strong class="text-white text-xs sm:text-sm font-bold block"><?php echo esc_html(isset($lp_trust_good_item['title']) ? $lp_trust_good_item['title'] : ''); ?></strong>
<p class="text-zinc-300 text-xs leading-relaxed"><?php echo esc_html(isset($lp_trust_good_item['text']) ? $lp_trust_good_item['text'] : ''); ?></p>
</div>
</li>
<?php endforeach; ?>
</ul>
</div>
<div class="pt-1">
<button class="w-full bg-[#007CEB] hover:bg-[#0066c7] active:scale-98 text-white font-heading font-black text-xs sm:text-sm py-3 px-5 rounded-xl flex items-center justify-center gap-2 uppercase tracking-wider shadow-lg shadow-blue-600/25 transition-all duration-200 cursor-pointer border border-blue-500/40 group">
<span><?php echo esc_html(iptv_text('lp_trust_cta_label', 'GET RELIABLE STREAMING NOW')); ?></span>
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4 stroke-[2.5] group-hover:translate-x-1 transition-transform" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
</button>
</div>
</div>
</div>
</div>
</section>

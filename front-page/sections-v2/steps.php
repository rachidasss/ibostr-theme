<?php
/**
 * Landing section: Start Streaming in 3 Simple Steps
 * Converted from the prerendered landing page 2026-08-20. Markup is reproduced
 * exactly; only copy and links are ACF-driven.
 */
if (!defined('ABSPATH')) { exit; }

$lp_steps_items = iptv_lp_list('lp_steps_items', array(
    array(
        'title' => 'Select your plan',
        'text'  => 'Pick the subscription that fits you and checkout securely in seconds.',
    ),
    array(
        'title' => 'Receive credentials',
        'text'  => 'We email your login and a simple setup guide instantly. Check spam if needed.',
    ),
    array(
        'title' => 'Start watching',
        'text'  => 'Connect your device and enjoy channels, movies, and live sports right away.',
    ),
));

// Per-step icons are design, not copy: reproduced verbatim from the source and
// matched to the step by position.
$lp_steps_icons = array(
    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart w-4 h-4 stroke-[2]" aria-hidden="true"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>',
    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail w-4 h-4 stroke-[2]" aria-hidden="true"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect></svg>',
    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-play w-4 h-4 stroke-[2]" aria-hidden="true"><path d="M9 9.003a1 1 0 0 1 1.517-.859l4.997 2.997a1 1 0 0 1 0 1.718l-4.997 2.997A1 1 0 0 1 9 14.996z"></path><circle cx="12" cy="12" r="10"></circle></svg>',
);
?>
<section class="w-full bg-[#FAFAFC] text-zinc-900 py-12 sm:py-16 px-4 sm:px-6 lg:px-8 font-sans border-t border-zinc-200/80 select-none overflow-hidden" id="how-it-works-section"><div class="max-w-6xl mx-auto text-center space-y-8"><div class="space-y-2.5 max-w-2xl mx-auto"><div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs font-bold uppercase tracking-wider"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-3.5 h-3.5 text-emerald-600 stroke-[2.5]" aria-hidden="true"><path d="M20 6 9 17l-5-5"></path></svg><span><?php echo esc_html(iptv_text('lp_steps_badge', 'Quick Setup')); ?></span></div><h2 class="font-heading font-extrabold text-2xl sm:text-3xl lg:text-4xl text-zinc-950 tracking-tight"><?php echo esc_html(iptv_text('lp_steps_title', 'Start Streaming in')); ?> <span class="text-[#007CEB]"><?php echo esc_html(iptv_text('lp_steps_title_accent', '3 Simple Steps')); ?></span></h2><p class="font-sans font-normal text-xs sm:text-sm text-zinc-600 subtext-opacity max-w-lg mx-auto"><?php echo esc_html(iptv_text('lp_steps_subtitle', 'Connect in minutes. No hassle. Clear steps that work on any device.')); ?></p></div><div class="grid grid-cols-1 md:grid-cols-3 gap-5 text-left"><?php $lp_steps_i = 0; foreach ($lp_steps_items as $lp_step) : $lp_steps_icon = $lp_steps_icons[$lp_steps_i % count($lp_steps_icons)]; $lp_steps_i++; ?><div class="bg-white rounded-2xl p-5 sm:p-6 border border-zinc-200/90 shadow-xs hover:border-zinc-300 hover:shadow-md transition-all duration-300 flex flex-col justify-between space-y-3"><div class="space-y-3"><div class="flex items-center gap-2.5"><span class="w-7 h-7 rounded-full bg-zinc-950 text-white font-bold text-xs flex items-center justify-center flex-none shadow-xs"><?php echo esc_html($lp_steps_i); ?></span><div class="p-1.5 rounded-lg bg-zinc-100 text-zinc-900 border border-zinc-200/60 flex items-center justify-center"><?php echo $lp_steps_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG ?></div></div><div class="space-y-1"><h3 class="font-heading font-bold text-base sm:text-lg text-zinc-950 tracking-tight"><?php echo esc_html(isset($lp_step['title']) ? $lp_step['title'] : ''); ?></h3><p class="font-sans font-normal text-xs leading-relaxed text-zinc-600 subtext-opacity"><?php echo esc_html(isset($lp_step['text']) ? $lp_step['text'] : ''); ?></p></div></div></div><?php endforeach; ?></div><div class="pt-1 flex justify-center"><button class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-[#007CEB] hover:bg-[#0066c7] text-white font-sans font-black text-xs sm:text-sm tracking-wider uppercase shadow-md shadow-blue-900/20 transition-all duration-200 active:scale-95 cursor-pointer border border-blue-500/20 whitespace-nowrap" id="how-it-works-cta-btn"><span class="whitespace-nowrap"><?php echo esc_html(iptv_text('lp_steps_cta', 'SELECT YOUR PLAN NOW')); ?></span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4 stroke-[2.5] flex-none" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></button></div></div></section>

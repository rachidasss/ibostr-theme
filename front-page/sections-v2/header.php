<?php
/**
 * Landing section: header / navigation bar
 * Converted from the prerendered landing page 2026-08-20. Markup is reproduced
 * exactly; only copy and links are ACF-driven.
 *
 * @package iBostreaming
 */

if (!defined('ABSPATH')) { exit; }

$lp_nav_logo      = iptv_text('lp_nav_logo', 'https://ibostreaming.com/logo.png');
$lp_nav_logo_alt  = iptv_text('lp_nav_logo_alt', 'iBo Streaming IPTV');
$lp_nav_cta       = iptv_text('lp_nav_cta', 'Claim Discount');
$lp_nav_menu_aria = iptv_text('lp_nav_menu_aria', 'Toggle Navigation Menu');

$lp_nav_links = iptv_lp_list('lp_nav_links', array(
    array('label' => 'Home',       'url' => home_url('/')),
    array('label' => 'Pricing',    'url' => '#pricing-section'),
    array('label' => 'Reviews',    'url' => '#reviews-section'),
    array('label' => 'User Guide', 'url' => iptv_page_url('guide', home_url('/guide/'))),
    array('label' => 'Contact Us', 'url' => iptv_page_url('contact', home_url('/contact/'))),
    array('label' => 'FAQ’s',      'url' => '#faq-section'),
));
?>
<header class="absolute top-0 left-0 right-0 z-50 w-full pt-3 sm:pt-5 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto font-sans"><div class="relative w-full rounded-2xl bg-zinc-950/70 sm:bg-zinc-900/60 backdrop-blur-xl border border-white/10 shadow-2xl shadow-black/60 px-3 sm:px-5 h-14 sm:h-16 flex items-center justify-between gap-3"><a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2 group flex-none"><img data-perfmatters-preload width="240" height="123" decoding="async" alt="<?php echo esc_attr($lp_nav_logo_alt); ?>" class="h-6 sm:h-8 w-auto object-contain max-w-[150px] sm:max-w-[190px] transition-transform duration-200 group-hover:scale-[1.02]" src="<?php echo esc_url($lp_nav_logo); ?>" fetchpriority="high"></a><nav class="hidden lg:flex items-center gap-1 xl:gap-1.5"><?php foreach ($lp_nav_links as $lp_nav_link) : ?><a href="<?php echo esc_url($lp_nav_link['url']); ?>" class="px-3 py-1.5 rounded-full text-xs xl:text-sm font-semibold text-zinc-300 hover:text-white hover:bg-white/10 transition-all duration-200 cursor-pointer"><?php echo esc_html($lp_nav_link['label']); ?></a><?php endforeach; ?></nav><div class="hidden sm:flex items-center gap-3 flex-none"><button class="bg-gradient-to-r from-[#007CEB] to-[#005bb5] hover:from-[#0066c7] hover:to-[#004a99] active:scale-95 text-white font-bold text-xs py-2 px-4 rounded-full shadow-lg shadow-blue-600/30 transition-all duration-200 cursor-pointer flex items-center gap-1.5 border border-blue-400/30 whitespace-nowrap"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles w-3.5 h-3.5 fill-white text-white flex-none" aria-hidden="true"><path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path><path d="M20 2v4"></path><path d="M22 4h-4"></path><circle cx="4" cy="20" r="2"></circle></svg><span><?php echo esc_html($lp_nav_cta); ?></span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-3.5 h-3.5 stroke-[2.5] flex-none" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></button></div><button class="lg:hidden p-2 rounded-xl bg-white/5 hover:bg-white/10 text-zinc-200 hover:text-white border border-white/10 focus:outline-none cursor-pointer min-h-[44px] min-w-[44px] flex items-center justify-center" aria-label="<?php echo esc_attr($lp_nav_menu_aria); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu w-5 h-5" aria-hidden="true"><path d="M4 5h16"></path><path d="M4 12h16"></path><path d="M4 19h16"></path></svg></button></div></header>

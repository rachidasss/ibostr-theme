<?php
/**
 * Landing section: Trusted by 10,000+ Viewers
 * Converted from the prerendered landing page 2026-08-20. Markup is reproduced
 * exactly; only copy and links are ACF-driven.
 */
if (!defined('ABSPATH')) { exit; }

$front_page_id = get_option('page_on_front');

/**
 * Every star in this section draws the same lucide path. Held once so the six
 * review cards, the Trustpilot row and the three category rows stay identical.
 */
$lp_rev_star_path = '<path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"></path>';

/** Trustpilot green tile holding one white star. Five of these make a rating row. */
$lp_rev_star_tile = '<div class="w-4 h-4 bg-[#00b67a] rounded-xs flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star w-2.5 h-2.5 fill-white stroke-none" aria-hidden="true">' . $lp_rev_star_path . '</svg></div>';

/** Amber star used by the three category score rows inside the summary card. */
$lp_rev_star_amber = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star w-3.5 h-3.5 fill-amber-400 text-amber-400" aria-hidden="true">' . $lp_rev_star_path . '</svg>';

/** Quote glyph in the footer of every review card. */
$lp_rev_quote_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-quote w-4 h-4 text-zinc-300" aria-hidden="true"><path d="M14 14a2 2 0 0 0 2-2V8h-2"></path><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"></path><path d="M8 14a2 2 0 0 0 2-2V8H8"></path></svg>';

/** The three category score rows. Every row is five amber stars in the source. */
$lp_rev_ratings = iptv_lp_list('lp_rev_ratings', array(
    array('label' => 'Streaming Quality'),
    array('label' => 'VOD Selection'),
    array('label' => 'Support Response'),
), 'label');

/** The six scrollable review cards. Every card is five green stars in the source. */
$lp_rev_items = iptv_lp_list('lp_rev_items', array(
    array(
        'time'     => '1 week ago',
        'title'    => 'Stellar Stability and Quality',
        'text'     => '"iBo Streaming stands out for its rock-solid live football stability. I have experienced zero interruptions, making my viewing experience thoroughly enjoyable. Top service!"',
        'name'     => 'Johan S.',
        'location' => 'Stockholm, Sweden',
    ),
    array(
        'time'     => '3 days ago',
        'title'    => 'Reliability Redefined',
        'text'     => '"With iBo Streaming, I\'ve found the reliability I\'ve been searching for in an IPTV service. The 4K streams are stable and crisp on my LG OLED, making it a true pleasure to use."',
        'name'     => 'Mikkel B.',
        'location' => 'Copenhagen, Denmark',
    ),
    array(
        'time'     => '2 weeks ago',
        'title'    => 'Incredible Variety, Fantastic Value!',
        'text'     => '"Absolutely delighted with iBo Streaming! The sheer number of live channels and VOD options is mind-blowing, and all at such an affordable price. Best deal online."',
        'name'     => 'Emil T.',
        'location' => 'Oslo, Norway',
    ),
    array(
        'time'     => '5 days ago',
        'title'    => 'Outstanding Selection, Unbeatable Support',
        'text'     => '"I\'m amazed at how fast setup was on my Firestick. Reached support and got a friendly human response in under 5 minutes. The selection of channels and VOD is top-notch, far exceeding expectations!"',
        'name'     => 'Sari W.',
        'location' => 'Helsinki, Finland',
    ),
    array(
        'time'     => '2 days ago',
        'title'    => 'Value for Money',
        'text'     => '"iBo Streaming is a game-changer! It offers a fantastic array of 4K sports channels and movies at prices that do not break the bank. Highly satisfied with my subscription."',
        'name'     => 'Lars K.',
        'location' => 'Gothenburg, Sweden',
    ),
    array(
        'time'     => 'Yesterday',
        'title'    => 'Best IPTV Service',
        'text'     => '"Switched from a competitor that kept freezing during big match nights. iBo Streaming has been 100% stable with anti-freeze tech working flawlessly across my TVs."',
        'name'     => 'Astrid M.',
        'location' => 'Bergen, Norway',
    ),
));
?>
<section class="relative w-full bg-[#FAFAFC] text-zinc-900 py-14 sm:py-18 lg:py-20 px-4 sm:px-8 md:px-12 lg:px-16 font-sans border-t border-zinc-200/80 select-none overflow-hidden" id="reviews-section"><div class="max-w-[1320px] mx-auto space-y-8 sm:space-y-10 relative z-10"><div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-2 border-b border-zinc-200/60"><div class="space-y-2 max-w-2xl"><div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs font-bold uppercase tracking-wider"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big w-3.5 h-3.5 text-emerald-600 fill-emerald-600/20" aria-hidden="true"><path d="M21.801 10A10 10 0 1 1 17 3.335"></path><path d="m9 11 3 3L22 4"></path></svg><span><?php echo esc_html(iptv_text('lp_rev_badge', 'VERIFIED MEMBER REVIEWS')); ?></span></div><h2 class="font-heading font-bold text-2xl sm:text-3xl lg:text-4xl text-zinc-950 tracking-tight"><?php echo esc_html(iptv_text('lp_rev_title', 'Trusted by 10,000+ Viewers')); ?></h2><p class="font-sans font-normal text-xs sm:text-sm text-zinc-600"><?php echo esc_html(iptv_text('lp_rev_subtitle', 'Read real feedback from subscribers using iBo Streaming daily across all devices.')); ?></p></div></div><div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch"><div class="lg:col-span-4 bg-white rounded-2xl p-5 sm:p-6 border border-zinc-200/90 shadow-xs flex flex-col justify-between space-y-4"><div class="space-y-3"><div class="flex items-baseline gap-2"><span class="font-heading font-extrabold text-4xl sm:text-5xl text-zinc-950"><?php echo esc_html(iptv_text('lp_rev_score', '5.0')); ?></span><span class="font-sans font-semibold text-xs sm:text-sm text-zinc-500"><?php echo esc_html(iptv_text('lp_rev_count', 'Based on 642 Reviews')); ?></span></div><div class="flex items-center gap-2 pt-1 border-b border-zinc-100 pb-3"><div class="flex items-center gap-1 px-2.5 py-1 rounded bg-[#00b67a] text-white font-bold text-xs"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star w-3.5 h-3.5 fill-white stroke-none" aria-hidden="true"><?php echo $lp_rev_star_path; ?></svg><span><?php echo esc_html(iptv_text('lp_rev_source', 'Trustpilot')); ?></span></div><div class="flex items-center gap-0.5"><?php echo str_repeat($lp_rev_star_tile, 5); ?></div></div><div class="space-y-2.5 pt-1 text-xs font-semibold text-zinc-700"><?php foreach ($lp_rev_ratings as $lp_rev_rating) : ?><div class="flex items-center justify-between"><span><?php echo esc_html(isset($lp_rev_rating['label']) ? $lp_rev_rating['label'] : ''); ?></span><div class="flex gap-0.5"><?php echo str_repeat($lp_rev_star_amber, 5); ?></div></div><?php endforeach; ?></div></div><div class="pt-3 border-t border-zinc-100 flex items-center gap-2 text-xs font-semibold text-emerald-700"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-4 h-4 text-emerald-600 flex-none" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg><span><?php echo esc_html(iptv_text('lp_rev_verified', '100% Verified Customer Feedback')); ?></span></div></div><div class="lg:col-span-8 relative group"><button class="absolute right-2 top-1/2 -translate-y-1/2 z-30 p-3 rounded-full bg-white text-zinc-900 hover:bg-zinc-950 hover:text-white border border-zinc-300 shadow-xl transition-all duration-200 active:scale-90 cursor-pointer" aria-label="<?php echo esc_attr(iptv_text('lp_rev_scroll_label', 'Scroll Right')); ?>" id="reviews-overlay-right"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-5 h-5 stroke-[2.5]" aria-hidden="true"><path d="m9 18 6-6-6-6"></path></svg></button><div class="flex gap-4 overflow-x-auto pb-3 pt-0.5 no-scrollbar snap-x snap-mandatory scroll-smooth cursor-grab active:cursor-grabbing px-1" style="scrollbar-width: none;"><?php foreach ($lp_rev_items as $lp_rev_item) : ?><div class="snap-start flex-none w-[270px] sm:w-[300px] bg-white rounded-2xl p-5 border border-zinc-200/90 shadow-xs flex flex-col justify-between hover:border-zinc-300 transition-all duration-200 space-y-3"><div class="space-y-2.5"><div class="flex items-center justify-between"><div class="flex items-center gap-0.5"><?php echo str_repeat($lp_rev_star_tile, 5); ?></div><span class="font-sans font-normal text-[11px] text-zinc-400"><?php echo esc_html(isset($lp_rev_item['time']) ? $lp_rev_item['time'] : ''); ?></span></div><h3 class="font-heading font-bold text-[15px] leading-[20px] text-zinc-950"><?php echo esc_html(isset($lp_rev_item['title']) ? $lp_rev_item['title'] : ''); ?></h3><p class="font-sans font-normal text-xs leading-relaxed text-zinc-600 line-clamp-4"><?php echo esc_html(isset($lp_rev_item['text']) ? $lp_rev_item['text'] : ''); ?></p></div><div class="pt-3 border-t border-zinc-100 flex items-center justify-between"><div><span class="font-sans font-bold text-xs text-zinc-900 block"><?php echo esc_html(isset($lp_rev_item['name']) ? $lp_rev_item['name'] : ''); ?></span><span class="font-sans font-normal text-[10px] text-zinc-400 block"><?php echo esc_html(isset($lp_rev_item['location']) ? $lp_rev_item['location'] : ''); ?></span></div><?php echo $lp_rev_quote_icon; ?></div></div><?php endforeach; ?></div></div></div></div></section>

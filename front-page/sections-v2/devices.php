<?php
/**
 * Landing section: Works on any device, anywhere
 * Converted from the prerendered landing page 2026-08-20. Markup is reproduced
 * exactly; only copy and links are ACF-driven.
 */
if (!defined('ABSPATH')) { exit; }

$lp_dev_items = function_exists('get_field') ? get_field('lp_dev_items', get_option('page_on_front')) : null;
if (empty($lp_dev_items) || !is_array($lp_dev_items)) {
    $lp_dev_items = array(
        array('icon' => 'tv',         'title' => 'Smart TV',         'text' => 'Samsung, LG, Android'),
        array('icon' => 'zap',        'title' => 'Streaming Sticks', 'text' => 'Firestick, Apple TV, Roku'),
        array('icon' => 'smartphone', 'title' => 'Mobile & Tablet',  'text' => 'iOS, iPad, Android'),
        array('icon' => 'hard-drive', 'title' => 'IPTV Boxes',       'text' => 'MAG, Formuler, BuzzTV'),
        array('icon' => 'monitor',    'title' => 'PC & Laptop',      'text' => 'Windows, Mac, Web'),
    );
}

/**
 * Lucide icon markup, copied verbatim from the prerendered page. The repeater's
 * `icon` sub-field picks one by key, so rows can be reordered in the editor
 * without the icons staying behind on the wrong card. Unknown keys fall back to
 * the first icon rather than rendering an empty box.
 */
$lp_dev_icons = array(
    'tv'         => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tv w-4 h-4 stroke-[2]" aria-hidden="true"><path d="m17 2-5 5-5-5"></path><rect width="20" height="15" x="2" y="7" rx="2"></rect></svg>',
    'zap'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 stroke-[2]" aria-hidden="true"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path></svg>',
    'smartphone' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-smartphone w-4 h-4 stroke-[2]" aria-hidden="true"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"></rect><path d="M12 18h.01"></path></svg>',
    'hard-drive' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hard-drive w-4 h-4 stroke-[2]" aria-hidden="true"><line x1="22" x2="2" y1="12" y2="12"></line><path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path><line x1="6" x2="6.01" y1="16" y2="16"></line><line x1="10" x2="10.01" y1="16" y2="16"></line></svg>',
    'monitor'    => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-monitor w-4 h-4 stroke-[2]" aria-hidden="true"><rect width="20" height="14" x="2" y="3" rx="2"></rect><line x1="8" x2="16" y1="21" y2="21"></line><line x1="12" x2="12" y1="17" y2="21"></line></svg>',
);
?>
<section class="w-full bg-[#FAFAFC] text-zinc-900 py-8 sm:py-10 px-4 sm:px-6 lg:px-8 font-sans border-t border-b border-zinc-200/80 select-none overflow-hidden" id="compatible-devices-section">
    <div class="max-w-5xl mx-auto space-y-4 text-center">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-blue-50 border border-blue-200 text-[#007CEB] text-[10px] font-extrabold uppercase tracking-wider">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-3.5 h-3.5 text-emerald-600" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
                <span><?php echo esc_html(iptv_text('lp_dev_badge', 'UNIVERSAL COMPATIBILITY')); ?></span>
            </div>
            <h2 class="font-heading font-black text-xl sm:text-2xl text-zinc-950 tracking-tight uppercase"><?php echo esc_html(iptv_text('lp_dev_title_pre', 'WORKS ON')); ?> <span class="text-[#007CEB]"><?php echo esc_html(iptv_text('lp_dev_title_accent', 'ANY DEVICE')); ?></span><?php echo esc_html(iptv_text('lp_dev_title_post', ', ANYWHERE.')); ?></h2>
            <p class="font-sans text-xs sm:text-sm text-zinc-600 max-w-2xl mx-auto"><?php echo esc_html(iptv_text('lp_dev_subtitle', 'Plug-and-play setup in less than 2 minutes on all Smart TVs, Firestick, Apple TV, iOS, Android, MAG & PC.')); ?></p>
        </div>
        <div class="pt-2 grid grid-cols-2 sm:grid-cols-5 gap-2.5 sm:gap-3">
<?php foreach ($lp_dev_items as $lp_dev_item) :
    $lp_dev_key   = isset($lp_dev_item['icon']) ? (string) $lp_dev_item['icon'] : '';
    $lp_dev_svg   = isset($lp_dev_icons[$lp_dev_key]) ? $lp_dev_icons[$lp_dev_key] : reset($lp_dev_icons);
    $lp_dev_title = isset($lp_dev_item['title']) ? $lp_dev_item['title'] : '';
    $lp_dev_text  = isset($lp_dev_item['text']) ? $lp_dev_item['text'] : '';
?>
            <div class="bg-white rounded-xl p-3 border border-zinc-200/90 hover:border-blue-500/50 hover:shadow-md transition-all duration-200 cursor-pointer flex items-center sm:flex-col sm:justify-center text-left sm:text-center gap-2.5 group">
                <div class="p-2 rounded-lg bg-blue-50 text-[#007CEB] group-hover:bg-[#007CEB] group-hover:text-white transition-colors flex-none"><?php echo $lp_dev_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- literal markup from $lp_dev_icons ?></div>
                <div class="min-w-0">
                    <div class="font-heading font-bold text-xs text-zinc-900 group-hover:text-[#007CEB] transition-colors truncate"><?php echo esc_html($lp_dev_title); ?></div>
                    <div class="text-[10px] text-zinc-500 truncate font-medium"><?php echo esc_html($lp_dev_text); ?></div>
                </div>
            </div>
<?php endforeach; ?>
        </div>
    </div>
</section>

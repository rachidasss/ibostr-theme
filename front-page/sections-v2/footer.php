<?php
/**
 * Landing section: Footer
 *
 * Converted from the prerendered landing page 2026-08-20. Markup is reproduced
 * exactly; only copy and links are ACF-driven.
 *
 * The three nav columns collapse into accordions below `md` — the <ul>s ship
 * `hidden md:block`, which is the state the prerendered HTML is in. The toggle
 * behaviour is wired separately in vanilla JS.
 */

if (!defined('ABSPATH')) { exit; }

$lp_front_id = get_option('page_on_front');

/**
 * Reader for the three link repeaters: the ACF rows, or the defaults
 * transcribed from the source.
 *
 * The rows come from the page editor, so the sub-fields are not assumed to be
 * there — a renamed sub-field would otherwise emit an "undefined array key"
 * warning on PHP 8, and a half-filled row would render an empty <a href="">,
 * which is both a dead link and an accessibility failure. Rows with no label
 * are dropped instead.
 *
 * @param string $key      Repeater field name on the front page.
 * @param array  $defaults Rows to use when the field is empty or ACF is inactive.
 * @return array<int,array{label:string,url:string}>
 */
$lp_footer_rows = function ($key, $defaults) use ($lp_front_id) {
    $rows = function_exists('get_field') ? get_field($key, $lp_front_id) : null;

    if (empty($rows) || !is_array($rows)) {
        return $defaults;
    }

    $clean = array();
    foreach ($rows as $row) {
        $label = (is_array($row) && isset($row['label'])) ? trim((string) $row['label']) : '';
        $url   = (is_array($row) && isset($row['url']))   ? trim((string) $row['url'])   : '';

        if ($label !== '' && $url !== '') {
            $clean[] = array('label' => $label, 'url' => $url);
        }
    }

    return $clean ? $clean : $defaults;
};

// Logo. ACF image fields return an array; a plain URL string is accepted too so
// the field can be swapped to a URL type without touching this template. The
// source's own width/height are the fallback, so the markup is unchanged until
// somebody actually uploads a different file.
$lp_footer_logo     = function_exists('get_field') ? get_field('lp_footer_logo', $lp_front_id) : null;
$lp_footer_logo_url = (is_array($lp_footer_logo) && !empty($lp_footer_logo['url']))
    ? $lp_footer_logo['url']
    : ((is_string($lp_footer_logo) && $lp_footer_logo !== '') ? $lp_footer_logo : 'https://ibostreaming.com/logo.png');
$lp_footer_logo_w = (is_array($lp_footer_logo) && !empty($lp_footer_logo['width']))  ? (int) $lp_footer_logo['width']  : 240;
$lp_footer_logo_h = (is_array($lp_footer_logo) && !empty($lp_footer_logo['height'])) ? (int) $lp_footer_logo['height'] : 123;

// Panel checkout endpoint. The plan links must keep their query string intact —
// the panel derives the plan from plan_type/connections/duration.
$lp_footer_checkout = iptv_config('checkout_base_url', 'https://panel.ibostreaming.com/checkout');

$lp_footer_col1 = $lp_footer_rows('lp_footer_col1_links', array(
    array('label' => 'Home',                'url' => home_url('/')),
    array('label' => 'How To Install IPTV', 'url' => iptv_page_url('guide', home_url('/guide/'))),
    array('label' => 'Channel Lists',       'url' => home_url('/en/channels/')),
    array('label' => 'Pricing',             'url' => '#pricing-section'),
    array('label' => 'Help Center',         'url' => iptv_page_url('help-center', home_url('/help-center/'))),
    array('label' => 'M3U Converter',       'url' => home_url('/free-m3u-to-xtream-codes-converter-2025/')),
    array('label' => 'Become Reseller',     'url' => iptv_page_url('contact', home_url('/contact/'))),
));

$lp_footer_col2 = $lp_footer_rows('lp_footer_col2_links', array(
    array('label' => 'Refund Policy',    'url' => iptv_page_url('refund-returns', home_url('/refund-returns/'))),
    array('label' => 'Privacy Policy',   'url' => iptv_page_url('privacy-policy', home_url('/privacy-policy/'))),
    array('label' => 'Terms of Service', 'url' => iptv_page_url('terms-of-service', home_url('/terms-of-service/'))),
));

$lp_footer_col3 = $lp_footer_rows('lp_footer_col3_links', array(
    array('label' => '12 Months Plan', 'url' => $lp_footer_checkout . '?plan_type=m3u&connections=1&duration=12&source=landing_page'),
    array('label' => '6 Months Plan',  'url' => $lp_footer_checkout . '?plan_type=m3u&connections=1&duration=6&source=landing_page'),
    array('label' => '3 Months Plan',  'url' => $lp_footer_checkout . '?plan_type=m3u&connections=1&duration=3&source=landing_page'),
    array('label' => '1 Month Plan',   'url' => $lp_footer_checkout . '?plan_type=m3u&connections=1&duration=1&source=landing_page'),
));
?>
<footer id="ibo-footer" class="w-full bg-zinc-950 text-white font-sans border-t border-zinc-800/80 relative select-none overflow-hidden">
<div class="h-[2px] w-full bg-gradient-to-r from-[#007ceb] via-[#38b6ff] to-[#007ceb] opacity-80"></div>
<div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-48 bg-[radial-gradient(ellipse_at_top,rgba(0,124,235,0.08),transparent_70%)] pointer-events-none"></div>
<div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 pt-10 sm:pt-14 pb-8 relative z-10">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
<div class="lg:col-span-4 flex flex-col gap-4">
<a href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(iptv_text('lp_footer_logo_aria', 'iBostreaming Home')); ?>" class="inline-flex items-center w-fit transition-transform hover:scale-[1.02]"><img width="<?php echo esc_attr($lp_footer_logo_w); ?>" height="<?php echo esc_attr($lp_footer_logo_h); ?>" decoding="async" alt="<?php echo esc_attr(iptv_text('lp_footer_logo_alt', 'iBo Streaming IPTV')); ?>" class="h-8 sm:h-9 w-auto object-contain max-w-[200px]" loading="lazy" src="<?php echo esc_url($lp_footer_logo_url); ?>"></a>
<p class="text-xs sm:text-sm text-zinc-400 leading-relaxed max-w-sm font-normal"><?php echo esc_html(iptv_text('lp_footer_tagline', 'Premium 4K IPTV streaming service delivering 40,000+ live channels and 200,000+ VOD releases worldwide. Reliable, secure, and zero-buffering.')); ?></p>
<div class="flex flex-wrap items-center gap-2 pt-0.5">
<span class="inline-flex items-center gap-1.5 px-3 py-1 border border-blue-500/25 rounded-full bg-blue-500/10 text-[#38b6ff] text-[10px] sm:text-xs font-extrabold uppercase tracking-wider"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big w-3.5 h-3.5 text-[#38b6ff]" aria-hidden="true"><path d="M21.801 10A10 10 0 1 1 17 3.335"></path><path d="m9 11 3 3L22 4"></path></svg><?php echo esc_html(iptv_text('lp_footer_badge_support', '24/7 Support')); ?></span>
<span class="inline-flex items-center gap-1.5 px-3 py-1 border border-emerald-500/25 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] sm:text-xs font-extrabold uppercase tracking-wider"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-3.5 h-3.5 text-emerald-400" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg><?php echo esc_html(iptv_text('lp_footer_badge_quality', '4K Ultra HD Quality')); ?></span>
</div>
<div class="flex flex-col gap-2 pt-1">
<span class="text-[11px] font-extrabold uppercase tracking-widest text-[#38b6ff] relative pb-1 w-fit border-b-2 border-[#007ceb]"><?php echo esc_html(iptv_text('lp_footer_social_title', 'Follow Us')); ?></span>
<ul class="flex items-center gap-2.5 pt-1">
<li><a class="w-9 h-9 rounded-xl bg-zinc-900 hover:bg-[#007ceb] border border-zinc-800 hover:border-blue-400/40 text-zinc-400 hover:text-white flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 shadow-md cursor-pointer" href="https://www.instagram.com/ibostreaming_iptv/" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(iptv_text('lp_footer_social_instagram_aria', 'Follow iBostreaming on Instagram')); ?>" title="<?php echo esc_attr(iptv_text('lp_footer_social_instagram_title', 'Instagram')); ?>"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.849.07 1.366.062 2.633.336 3.608 1.311.975.975 1.249 2.242 1.311 3.608.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.062 1.366-.336 2.633-1.311 3.608-.975.975-2.242 1.249-3.608 1.311-1.265.058-1.645.069-4.849.069-3.205 0-3.584-.012-4.849-.069-1.366-.062-2.633-.336-3.608-1.311-.975-.975-1.249-2.242-1.311-3.608C2.175 15.647 2.163 15.268 2.163 12s.012-3.584.07-4.849c.062-1.366.336-2.633 1.311-3.608.975-.975 2.242-1.249 3.608-1.311C8.416 2.175 8.796 2.163 12 2.163zm0 1.802c-3.141 0-3.506.012-4.745.068-1.014.046-1.565.215-1.932.358-.486.189-.832.414-1.197.779-.365.365-.59.711-.779 1.197-.143.367-.312.918-.358 1.932-.056 1.239-.068 1.604-.068 4.745s.012 3.506.068 4.745c.046 1.014.215 1.565.358 1.932.189.486.414.832.779 1.197.365.365.711.59 1.197.779.367.143.918.312 1.932.358 1.239.056 1.604.068 4.745.068s3.506-.012 4.745-.068c1.014-.046 1.565-.215 1.932-.358.486-.189.832-.414 1.197-.779.365-.365.59-.711.779-1.197.143-.367.312-.918.358-1.932.056-1.239.068-1.604.068-4.745s-.012-3.506-.068-4.745c-.046-1.014-.215-1.565-.358-1.932-.189-.486-.414-.832-.779-1.197-.365-.365-.711-.59-1.197-.779-.367-.143-.918-.312-1.932-.358-1.239-.056-1.604-.068-4.745-.068zM12 6.865a5.135 5.135 0 1 1 0 10.27 5.135 5.135 0 0 1 0-10.27zm0 8.468a3.333 3.333 0 1 0 0-6.666 3.333 3.333 0 0 0 0 6.666zm5.338-9.87a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4z"></path></svg></a></li>
<li><a class="w-9 h-9 rounded-xl bg-zinc-900 hover:bg-[#007ceb] border border-zinc-800 hover:border-blue-400/40 text-zinc-400 hover:text-white flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 shadow-md cursor-pointer" href="https://www.facebook.com/ibostreaming" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(iptv_text('lp_footer_social_facebook_aria', 'Follow iBostreaming on Facebook')); ?>" title="<?php echo esc_attr(iptv_text('lp_footer_social_facebook_title', 'Facebook')); ?>"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path></svg></a></li>
<li><a class="w-9 h-9 rounded-xl bg-zinc-900 hover:bg-[#007ceb] border border-zinc-800 hover:border-blue-400/40 text-zinc-400 hover:text-white flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 shadow-md cursor-pointer" href="https://x.com/iBostreaming" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(iptv_text('lp_footer_social_x_aria', 'Follow iBostreaming on X')); ?>" title="<?php echo esc_attr(iptv_text('lp_footer_social_x_title', 'X')); ?>"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path></svg></a></li>
<li><a class="w-9 h-9 rounded-xl bg-zinc-900 hover:bg-[#007ceb] border border-zinc-800 hover:border-blue-400/40 text-zinc-400 hover:text-white flex items-center justify-center transition-all duration-200 hover:-translate-y-0.5 shadow-md cursor-pointer" href="https://www.reddit.com/user/ibostreaming/" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(iptv_text('lp_footer_social_reddit_aria', 'Follow iBostreaming on Reddit')); ?>" title="<?php echo esc_attr(iptv_text('lp_footer_social_reddit_title', 'Reddit')); ?>"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm6.67 10.37c.03.18.04.37.04.55 0 3.42-3.86 6.18-8.61 6.18-4.76 0-8.61-2.76-8.61-6.18 0-.19.01-.37.04-.55-.62-.35-1.05-1.02-1.05-1.79 0-1.14.92-2.06 2.06-2.06.55 0 1.05.22 1.42.57 1.39-.93 3.25-1.52 5.32-1.6l1.01-4.76c.02-.1.09-.18.18-.23.09-.04.2-.04.29 0l3.3 1.05c.23-.47.71-.79 1.26-.79.78 0 1.41.63 1.41 1.41s-.63 1.41-1.41 1.41c-.76 0-1.37-.6-1.41-1.35l-2.95-.94-.9 4.25c2.03.1 3.85.69 5.23 1.61.37-.35.86-.57 1.41-.57 1.14 0 2.06.92 2.06 2.06 0 .76-.43 1.43-1.05 1.78zM8.57 11.57c-.78 0-1.41.63-1.41 1.41s.63 1.41 1.41 1.41 1.41-.63 1.41-1.41-.63-1.41-1.41-1.41zm6.86 0c-.78 0-1.41.63-1.41 1.41s.63 1.41 1.41 1.41 1.41-.63 1.41-1.41-.63-1.41-1.41-1.41zm-1.08 3.77c-.39.39-1.23.53-1.99.53s-1.6-.14-1.99-.53c-.11-.11-.3-.11-.42 0-.11.11-.11.3 0 .42.62.62 1.81.67 2.41.67s1.79-.05 2.41-.67c.11-.11.11-.3 0-.42-.11-.11-.3-.11-.42 0z"></path></svg></a></li>
</ul>
</div>
</div>
<nav class="lg:col-span-8 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8" aria-label="<?php echo esc_attr(iptv_text('lp_footer_nav_aria', 'Footer navigation')); ?>">
<div class="border-b md:border-b-0 border-zinc-800/80 pb-3 md:pb-0"><button type="button" class="w-full flex items-center justify-between md:block text-left cursor-pointer md:cursor-default py-1 md:py-0"><h3 class="text-xs font-extrabold uppercase tracking-widest text-[#38b6ff] relative pb-1 border-b-2 border-[#007ceb] md:inline-block"><?php echo esc_html(iptv_text('lp_footer_col1_title', 'Quick Links')); ?></h3><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 text-zinc-400 md:hidden transition-transform duration-200" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg></button><ul class="mt-3 space-y-2 text-xs sm:text-sm font-medium text-zinc-400 hidden md:block">
<?php foreach ($lp_footer_col1 as $lp_row) : ?>
<li><a href="<?php echo esc_url($lp_row['url']); ?>" class="hover:text-white transition-colors py-1 inline-block"><?php echo esc_html($lp_row['label']); ?></a></li>
<?php endforeach; ?>
</ul></div>
<div class="border-b md:border-b-0 border-zinc-800/80 pb-3 md:pb-0"><button type="button" class="w-full flex items-center justify-between md:block text-left cursor-pointer md:cursor-default py-1 md:py-0"><h3 class="text-xs font-extrabold uppercase tracking-widest text-[#38b6ff] relative pb-1 border-b-2 border-[#007ceb] md:inline-block"><?php echo esc_html(iptv_text('lp_footer_col2_title', 'Legal')); ?></h3><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 text-zinc-400 md:hidden transition-transform duration-200" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg></button><ul class="mt-3 space-y-2 text-xs sm:text-sm font-medium text-zinc-400 hidden md:block">
<?php foreach ($lp_footer_col2 as $lp_row) : ?>
<li><a href="<?php echo esc_url($lp_row['url']); ?>" class="hover:text-white transition-colors py-1 inline-block"><?php echo esc_html($lp_row['label']); ?></a></li>
<?php endforeach; ?>
</ul></div>
<div class="pb-3 md:pb-0"><button type="button" class="w-full flex items-center justify-between md:block text-left cursor-pointer md:cursor-default py-1 md:py-0"><h3 class="text-xs font-extrabold uppercase tracking-widest text-[#38b6ff] relative pb-1 border-b-2 border-[#007ceb] md:inline-block"><?php echo esc_html(iptv_text('lp_footer_col3_title', 'Subscriptions')); ?></h3><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 text-zinc-400 md:hidden transition-transform duration-200" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg></button><ul class="mt-3 space-y-2 text-xs sm:text-sm font-medium text-zinc-400 hidden md:block">
<?php foreach ($lp_footer_col3 as $lp_row) : ?>
<li><a href="<?php echo esc_url($lp_row['url']); ?>" class="hover:text-white transition-colors py-1 inline-block"><?php echo esc_html($lp_row['label']); ?></a></li>
<?php endforeach; ?>
</ul></div>
</nav>
</div>
<div class="mt-10 pt-6 border-t border-zinc-900 flex flex-wrap items-center justify-between gap-4 text-xs text-zinc-400 font-medium">
<div class="flex flex-wrap items-center gap-4 text-xs">
<span class="inline-flex items-center gap-1.5 text-zinc-300"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock w-3.5 h-3.5 text-emerald-400" aria-hidden="true"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg><?php echo esc_html(iptv_text('lp_footer_trust_ssl', '256-Bit SSL Encrypted & Secured')); ?></span>
<span class="text-zinc-800 hidden sm:inline">•</span>
<span class="inline-flex items-center gap-1.5 text-zinc-300"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe w-3.5 h-3.5 text-[#38b6ff]" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path><path d="M2 12h20"></path></svg><?php echo esc_html(iptv_text('lp_footer_trust_servers', '100Gbps European Ultra-Fast Servers')); ?></span>
</div>
<div class="inline-flex items-center gap-1.5 text-[11px] text-zinc-400 bg-zinc-900/80 px-3 py-1 rounded-full border border-zinc-800"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span><span><?php echo esc_html(iptv_text('lp_footer_uptime', '99.99% Server Uptime Guaranteed')); ?></span></div>
</div>
<div class="mt-6 pt-4 border-t border-zinc-900 flex flex-col-reverse sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
<p class="text-xs font-normal text-zinc-500"><?php echo esc_html(iptv_text('lp_footer_copyright', '© 2025 iBostreaming 4K IPTV. All rights reserved. · Designed for ultimate streaming experience')); ?></p>
<button type="button" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-zinc-900 hover:bg-[#007ceb] border border-zinc-800 text-xs font-bold text-zinc-300 hover:text-white transition-all duration-200 hover:-translate-y-0.5 cursor-pointer shadow-md" aria-label="<?php echo esc_attr(iptv_text('lp_footer_top_aria', 'Scroll to top')); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up w-3.5 h-3.5 stroke-[2.2]" aria-hidden="true"><path d="m5 12 7-7 7 7"></path><path d="M12 19V5"></path></svg><span><?php echo esc_html(iptv_text('lp_footer_top_label', 'Back to top')); ?></span></button>
</div>
</div>
</footer>

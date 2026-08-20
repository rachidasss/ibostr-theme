<?php
/**
 * Landing section: Pricing / plan configurator ("Choose your plan that fits you")
 *
 * Converted from the prerendered landing page 2026-08-20. Markup is reproduced
 * exactly; only copy and links are ACF-driven.
 *
 * The picker is rendered in its prerendered default state: 1 Screen selected,
 * 12 Months selected. Selection, price recalculation, the countdown and the
 * checkout redirect are wired separately in vanilla JS.
 *
 * @package Nordic_IPTV
 */

if (!defined('ABSPATH')) {
    exit;
}

$lp_price_front_id = get_option('page_on_front');

/* -----------------------------------------------------------------------
 * The price matrix, for the configurator.
 *
 * The markup below renders ONE screen column - the 1-screen ladder the server
 * picked - because that is the state the prerendered page was captured in. The
 * other twelve of the sixteen prices are not in the DOM at all, so a script
 * cannot reprice the panel by reading what is on the page: clicking "2 Screens"
 * moved the picker and left the numbers alone.
 *
 * So publish the whole table. Same source as everything else that quotes a
 * price - IPTV_Currency_Settings::get_price_table(), keyed
 * [duration][device][currency] - which means the configurator, the schema and
 * the panel cannot drift apart. The React build did the same thing; its matrix
 * just lived inside the bundle.
 * -------------------------------------------------------------------- */
$lp_price_table = class_exists('IPTV_Currency_Settings')
    ? IPTV_Currency_Settings::get_price_table()
    : array();

if (!empty($lp_price_table)) : ?>
<script>
    window.iptvPrices = <?php echo wp_json_encode($lp_price_table); ?>;
</script>
<?php endif; ?>
<?php

/* -----------------------------------------------------------------------
 * Step 1 – screen count buttons
 * -------------------------------------------------------------------- */
$lp_price_screens = function_exists('get_field') ? get_field('lp_price_screens', $lp_price_front_id) : null;
if (empty($lp_price_screens) || !is_array($lp_price_screens)) {
    $lp_price_screens = array(
        array('label' => '1 Screen',  'badge' => '',        'selected' => true),
        array('label' => '2 Screens', 'badge' => 'POPULAR', 'selected' => false),
        array('label' => '3 Screens', 'badge' => '',        'selected' => false),
        array('label' => '4 Screens', 'badge' => '',        'selected' => false),
    );
}

/* -----------------------------------------------------------------------
 * Step 2 – duration buttons
 * -------------------------------------------------------------------- */
$lp_price_durations = function_exists('get_field') ? get_field('lp_price_durations', $lp_price_front_id) : null;
if (empty($lp_price_durations) || !is_array($lp_price_durations)) {
    $lp_price_durations = array(
        array('label' => '1 Month',   'badge' => '',           'price' => '$13.99', 'per_month' => '$13.99/mo', 'selected' => false),
        array('label' => '3 Months',  'badge' => 'Save 35%',   'price' => '$24.99', 'per_month' => '$8.33/mo',  'selected' => false),
        array('label' => '6 Months',  'badge' => 'Save 47%',   'price' => '$34.99', 'per_month' => '$5.83/mo',  'selected' => false),
        array('label' => '12 Months', 'badge' => 'Best value', 'price' => '$59.99', 'per_month' => '$5.00/mo',  'selected' => true),
    );
}

/* -----------------------------------------------------------------------
 * "Every plan is fully loaded" checklist
 * -------------------------------------------------------------------- */
$lp_price_features = iptv_lp_list('lp_price_features', 'text', array(
    array('text' => '40,000+ Live TV Channels'),
    array('text' => '200,000+ Movies & Series (VOD)'),
    array('text' => '4K, Ultra HD & HD quality'),
    array('text' => 'Full TV guide (EPG)'),
    array('text' => 'Hockey, football & handball'),
    array('text' => 'Auto-updating channels & VOD'),
    array('text' => 'Stable, fast servers'),
    array('text' => 'Anti-Buffer™ 9.8'),
    array('text' => 'Pay-Per-View (PPV) events'),
    array('text' => '24/7 priority support'),
));

/* -----------------------------------------------------------------------
 * Trust cards. The icon and its colour tone are design, not copy, so they stay
 * in the template and each row only picks one by key.
 * -------------------------------------------------------------------- */
$lp_price_card_icons = array(
    'lock' => array(
        'tone' => 'text-emerald-600 bg-emerald-50 border-emerald-200',
        'svg'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock w-4 h-4 stroke-[2]" aria-hidden="true"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>',
    ),
    'zap' => array(
        'tone' => 'text-amber-600 bg-amber-50 border-amber-200',
        'svg'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-4 h-4 stroke-[2]" aria-hidden="true"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path></svg>',
    ),
    'clock' => array(
        'tone' => 'text-blue-600 bg-blue-50 border-blue-200',
        'svg'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-4 h-4 stroke-[2]" aria-hidden="true"><path d="M12 6v6l4 2"></path><circle cx="12" cy="12" r="10"></circle></svg>',
    ),
    'award' => array(
        'tone' => 'text-red-600 bg-red-50 border-red-200',
        'svg'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-award w-4 h-4 stroke-[2]" aria-hidden="true"><path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"></path><circle cx="12" cy="8" r="6"></circle></svg>',
    ),
);

$lp_price_cards = function_exists('get_field') ? get_field('lp_price_cards', $lp_price_front_id) : null;
if (empty($lp_price_cards) || !is_array($lp_price_cards)) {
    $lp_price_cards = array(
        array(
            'icon'  => 'lock',
            'badge' => 'BANK-GRADE SECURITY',
            'title' => '256-Bit SSL Encrypted',
            'text'  => '100% encrypted and PCI-DSS compliant checkout. Your payment and privacy are fully protected.',
        ),
        array(
            'icon'  => 'zap',
            'badge' => 'ANTI-FREEZE™ TECH',
            'title' => '99.9% Server Uptime',
            'text'  => 'High-speed 100Gbps European servers with failover protection ensure zero buffering during major sports.',
        ),
        array(
            'icon'  => 'clock',
            'badge' => '< 2 MIN ACTIVATION',
            'title' => 'Instant Automated Delivery',
            'text'  => 'Credentials and easy setup guides delivered directly to your email and WhatsApp within 120 seconds.',
        ),
        array(
            'icon'  => 'award',
            'badge' => 'MONEY-BACK GUARANTEE',
            'title' => 'Risk-Free Guarantee',
            'text'  => 'Not satisfied? Contact our support team for a swift, hassle-free refund policy.',
        ),
    );
}

$lp_price_card_verified = iptv_text('lp_price_card_verified', 'Verified & Protected');

/* -----------------------------------------------------------------------
 * Payment method badges
 * -------------------------------------------------------------------- */
$lp_price_payments = function_exists('get_field') ? get_field('lp_price_payments', $lp_price_front_id) : null;
if (empty($lp_price_payments) || !is_array($lp_price_payments)) {
    $lp_price_payments = array(
        array('label' => 'VISA',       'accent' => false),
        array('label' => 'MASTERCARD', 'accent' => false),
        array('label' => 'APPLE PAY',  'accent' => false),
        array('label' => 'GOOGLE PAY', 'accent' => false),
        array('label' => 'CRYPTO',     'accent' => true),
    );
}

// Panel checkout endpoint. The button carries no href in the prerendered page —
// JS builds the URL from the selected screen count and duration — so this is
// exposed to that script rather than rendered as a link.
$lp_price_checkout_base = iptv_config('checkout_base_url', 'https://panel.ibostreaming.com/checkout');
?>
<section class="relative w-full bg-slate-50 text-slate-900 py-10 sm:py-14 px-3 sm:px-6 lg:px-8 font-sans overflow-hidden select-none border-t border-slate-200" id="pricing-section">
    <div class="max-w-2xl sm:max-w-3xl mx-auto space-y-5 relative z-10">
        <div class="text-center space-y-1.5 max-w-lg mx-auto">
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-blue-100 text-[#007CEB] font-extrabold text-[10px] sm:text-[11px] uppercase tracking-wider border border-blue-200"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-flame w-3 h-3 fill-[#007CEB] text-[#007CEB]" aria-hidden="true"><path d="M12 3q1 4 4 6.5t3 5.5a1 1 0 0 1-14 0 5 5 0 0 1 1-3 1 1 0 0 0 5 0c0-2-1.5-3-1.5-5q0-2 2.5-4"></path></svg><span><?php echo esc_html(iptv_text('lp_price_eyebrow', 'INSTANT ACTIVATION & SAVINGS')); ?></span></div>
            <h2 class="font-heading font-black text-2xl sm:text-3xl lg:text-4xl text-slate-950 tracking-tight"><?php echo esc_html(iptv_text('lp_price_title', 'Choose your plan that fits you')); ?></h2>
            <p class="font-sans text-xs sm:text-sm text-slate-600 leading-relaxed"><?php echo esc_html(iptv_text('lp_price_subtitle', 'Unlock unbeatable value and embrace remarkable savings with the best-priced IPTV available today!')); ?></p>
        </div>
        <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 border border-slate-200 shadow-xl shadow-slate-200/50 space-y-5">
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2"><span class="w-5 h-5 rounded-full bg-[#007CEB] text-white font-extrabold text-[11px] flex items-center justify-center"><?php echo esc_html(iptv_text('lp_price_step1_num', '1')); ?></span><h3 class="font-heading font-extrabold text-xs sm:text-sm text-slate-950 uppercase tracking-wide"><?php echo esc_html(iptv_text('lp_price_step1_title', 'How many screens?')); ?></h3></div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
<?php foreach ($lp_price_screens as $lp_price_screen) :
    $lp_price_is_on = !empty($lp_price_screen['selected']);
    $lp_price_btn   = $lp_price_is_on
        ? 'relative py-2 px-3 rounded-xl font-heading font-extrabold text-xs transition-all duration-200 cursor-pointer flex items-center justify-center border bg-slate-950 text-white border-slate-950 shadow-md scale-[1.01]'
        : 'relative py-2 px-3 rounded-xl font-heading font-extrabold text-xs transition-all duration-200 cursor-pointer flex items-center justify-center border bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100';
?>
                    <button class="<?php echo esc_attr($lp_price_btn); ?>"><?php if (!empty($lp_price_screen['badge'])) : ?><span class="absolute -top-2 px-1.5 py-0.2 rounded-full text-[8px] font-black uppercase tracking-wider bg-[#007CEB] text-white shadow-sm"><?php echo esc_html($lp_price_screen['badge']); ?></span><?php endif; ?><span><?php echo esc_html($lp_price_screen['label']); ?></span></button>
<?php endforeach; ?>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex items-center gap-2"><span class="w-5 h-5 rounded-full bg-[#007CEB] text-white font-extrabold text-[11px] flex items-center justify-center"><?php echo esc_html(iptv_text('lp_price_step2_num', '2')); ?></span><h3 class="font-heading font-extrabold text-xs sm:text-sm text-slate-950 uppercase tracking-wide"><?php echo esc_html(iptv_text('lp_price_step2_title', 'How long?')); ?></h3></div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
<?php foreach ($lp_price_durations as $lp_price_duration) :
    $lp_price_is_on = !empty($lp_price_duration['selected']);
    $lp_price_btn   = $lp_price_is_on
        ? 'relative p-2.5 rounded-xl transition-all duration-200 cursor-pointer flex flex-col items-center justify-center text-center space-y-0.5 border bg-[#007CEB] text-white border-[#007CEB] shadow-md scale-[1.01]'
        : 'relative p-2.5 rounded-xl transition-all duration-200 cursor-pointer flex flex-col items-center justify-center text-center space-y-0.5 border bg-slate-50 text-slate-900 border-slate-200 hover:bg-slate-100';
    $lp_price_badge_cls = $lp_price_is_on
        ? 'absolute -top-2 px-1.5 py-0.2 rounded-full text-[8px] font-black uppercase tracking-wider bg-slate-950 text-white'
        : 'absolute -top-2 px-1.5 py-0.2 rounded-full text-[8px] font-black uppercase tracking-wider bg-slate-200 text-slate-700';
    $lp_price_label_cls = $lp_price_is_on
        ? 'text-[9px] font-bold uppercase tracking-wider text-white/80'
        : 'text-[9px] font-bold uppercase tracking-wider text-slate-500';
    $lp_price_per_cls = $lp_price_is_on
        ? 'text-[9px] font-mono font-medium text-white/90'
        : 'text-[9px] font-mono font-medium text-slate-500';
?>
                    <button class="<?php echo esc_attr($lp_price_btn); ?>"><?php if (!empty($lp_price_duration['badge'])) : ?><span class="<?php echo esc_attr($lp_price_badge_cls); ?>"><?php echo esc_html($lp_price_duration['badge']); ?></span><?php endif; ?><span class="<?php echo esc_attr($lp_price_label_cls); ?>"><?php echo esc_html($lp_price_duration['label']); ?></span><span class="font-heading font-black text-sm sm:text-base leading-tight"><?php echo esc_html($lp_price_duration['price']); ?></span><span class="<?php echo esc_attr($lp_price_per_cls); ?>"><?php echo esc_html($lp_price_duration['per_month']); ?></span></button>
<?php endforeach; ?>
                </div>
            </div>
            <div class="bg-slate-950 text-white rounded-2xl p-4 sm:p-5 space-y-3 shadow-lg border border-slate-800">
                <div class="flex items-center justify-between"><span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest"><?php echo esc_html(iptv_text('lp_price_total_label', 'YOUR TOTAL')); ?></span><span class="text-emerald-400 font-mono text-[10px] font-extrabold bg-emerald-950/90 px-2 py-0.5 rounded-full border border-emerald-500/30"><?php echo esc_html(iptv_text('lp_price_total_save', 'SAVE $107.89 (64%)')); ?></span></div>
                <div class="flex items-baseline justify-between gap-2">
                    <div class="flex items-baseline gap-2"><span class="font-heading font-black text-2xl sm:text-3xl text-white tracking-tight"><?php echo esc_html(iptv_text('lp_price_total_price', '$59.99')); ?></span><span class="line-through text-slate-500 font-bold text-xs sm:text-sm"><?php echo esc_html(iptv_text('lp_price_total_strike', '$167.88')); ?></span></div>
                    <div class="text-slate-400 text-[10px] font-mono"><?php echo esc_html(iptv_text('lp_price_total_note', 'one-time · $5.00/mo')); ?></div>
                </div>
                <div class="pt-2 border-t border-slate-800/80 flex items-center justify-between text-[10px] sm:text-[11px] font-medium text-slate-300">
                    <div class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-3.5 h-3.5 text-blue-400 animate-pulse" aria-hidden="true"><path d="M12 6v6l4 2"></path><circle cx="12" cy="12" r="10"></circle></svg><span><?php echo esc_html(iptv_text('lp_price_timer_label', 'Discount locked for:')); ?> <span class="font-mono font-extrabold text-blue-300"><?php echo esc_html(iptv_text('lp_price_timer_initial', '03:36:29')); ?></span></span></div>
                </div>
                <div class="pt-1"><button class="w-full bg-[#007CEB] hover:bg-[#0066c7] active:scale-[0.99] text-white font-heading font-black text-xs sm:text-sm py-3 px-4 rounded-xl shadow-lg shadow-blue-600/30 transition-all duration-200 cursor-pointer flex items-center justify-center gap-2 tracking-wider uppercase border border-blue-500/30" id="pricing-checkout-btn" data-checkout-base="<?php echo esc_url($lp_price_checkout_base); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles w-4 h-4 fill-white text-white flex-none" aria-hidden="true"><path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path><path d="M20 2v4"></path><path d="M22 4h-4"></path><circle cx="4" cy="20" r="2"></circle></svg><span class="whitespace-nowrap truncate"><?php echo esc_html(iptv_text('lp_price_cta', 'GET INSTANT ACCESS · $59.99')); ?></span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4 stroke-[2.5] flex-none" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg></button></div>
                <div class="flex flex-wrap items-center justify-center gap-3 pt-1 text-[10px] sm:text-[11px] font-bold text-slate-300"><span class="flex items-center gap-1 text-emerald-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-3.5 h-3.5" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg> <?php echo esc_html(iptv_text('lp_price_guarantee_1', '7-day money-back')); ?></span><span class="flex items-center gap-1 text-emerald-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-3.5 h-3.5" aria-hidden="true"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"></path></svg> <?php echo esc_html(iptv_text('lp_price_guarantee_2', 'Instant activation')); ?></span><span class="flex items-center gap-1 text-emerald-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-3.5 h-3.5 stroke-[3]" aria-hidden="true"><path d="M20 6 9 17l-5-5"></path></svg> <?php echo esc_html(iptv_text('lp_price_guarantee_3', 'No auto-renew')); ?></span></div>
            </div>
            <div class="space-y-2.5 pt-1 border-t border-slate-100">
                <div class="text-center">
                    <h4 class="font-heading font-black text-xs sm:text-sm text-slate-950 uppercase tracking-tight"><?php echo esc_html(iptv_text('lp_price_features_title', 'Every plan is fully loaded')); ?></h4>
                    <p class="text-[10px] sm:text-[11px] text-slate-500"><?php echo esc_html(iptv_text('lp_price_features_subtitle', 'All features included in every subscription with zero hidden fees')); ?></p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5 text-xs font-semibold text-slate-800">
<?php foreach ($lp_price_features as $lp_price_feature) : ?>
                    <div class="flex items-center gap-2 p-1.5 px-2.5 rounded-lg bg-slate-50 border border-slate-200/80 text-[10px] sm:text-[11px]"><div class="w-3.5 h-3.5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-2.5 h-2.5 stroke-[3]" aria-hidden="true"><path d="M20 6 9 17l-5-5"></path></svg></div><span class="truncate"><?php echo esc_html($lp_price_feature['text']); ?></span></div>
<?php endforeach; ?>
                </div>
            </div>
            <div class="text-center text-[10px] sm:text-[11px] font-extrabold text-slate-600 flex items-center justify-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-flame w-3.5 h-3.5 text-[#007CEB] fill-[#007CEB]" aria-hidden="true"><path d="M12 3q1 4 4 6.5t3 5.5a1 1 0 0 1-14 0 5 5 0 0 1 1-3 1 1 0 0 0 5 0c0-2-1.5-3-1.5-5q0-2 2.5-4"></path></svg><span><?php echo esc_html(iptv_text('lp_price_scarcity', 'Only 34 activation slots left this month')); ?></span></div>
        </div>
        <div class="w-full space-y-4 pt-2">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
<?php foreach ($lp_price_cards as $lp_price_card) :
    $lp_price_icon_key = isset($lp_price_card['icon']) && isset($lp_price_card_icons[$lp_price_card['icon']])
        ? $lp_price_card['icon']
        : 'lock';
    $lp_price_icon = $lp_price_card_icons[$lp_price_icon_key];
?>
                <div class="bg-white text-slate-900 rounded-xl p-3.5 border border-slate-200 hover:border-slate-300 transition-all duration-200 shadow-xs flex flex-col justify-between space-y-2.5 group">
                    <div class="flex items-center justify-between gap-2"><div class="p-2 rounded-lg border <?php echo esc_attr($lp_price_icon['tone']); ?> flex-none"><?php echo $lp_price_icon['svg']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static template markup ?></div><span class="text-[8px] sm:text-[9px] font-extrabold uppercase bg-slate-100 text-slate-700 px-2 py-0.5 rounded-md border border-slate-200 truncate"><?php echo esc_html($lp_price_card['badge']); ?></span></div>
                    <div><h4 class="font-heading font-extrabold text-xs sm:text-sm text-slate-950 tracking-tight"><?php echo esc_html($lp_price_card['title']); ?></h4><p class="font-sans text-[11px] text-slate-600 leading-snug mt-1"><?php echo esc_html($lp_price_card['text']); ?></p></div>
                    <div class="flex items-center gap-1 text-[10px] font-mono text-emerald-600 font-semibold pt-1 border-t border-slate-100"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-3 h-3 text-emerald-600 flex-none" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg><span><?php echo esc_html($lp_price_card_verified); ?></span></div>
                </div>
<?php endforeach; ?>
            </div>
            <div class="bg-white rounded-xl p-3 border border-slate-200 flex flex-wrap items-center justify-between gap-3 text-slate-700 text-xs shadow-xs">
                <div class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-4 h-4 text-emerald-600 flex-none" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg><span class="font-semibold text-[11px] sm:text-xs"><?php echo esc_html(iptv_text('lp_price_secure_label', 'Guaranteed Secure 256-Bit Checkout')); ?></span></div>
                <div class="flex items-center gap-1.5 flex-wrap"><?php foreach ($lp_price_payments as $lp_price_payment) :
                    $lp_price_pay_cls = 'px-2 py-1 rounded bg-slate-100 text-slate-800 border border-slate-200 text-[10px] font-extrabold tracking-wider';
                    if (!empty($lp_price_payment['accent'])) {
                        $lp_price_pay_cls .= ' text-emerald-600';
                    }
                ?><span class="<?php echo esc_attr($lp_price_pay_cls); ?>"><?php echo esc_html($lp_price_payment['label']); ?></span><?php endforeach; ?></div>
            </div>
        </div>
    </div>
</section>

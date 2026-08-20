<?php
/**
 * Landing section: Frequently Asked Questions
 * Converted from the prerendered landing page 2026-08-20. Markup is reproduced
 * exactly; only copy and links are ACF-driven.
 *
 * The prerendered page is React output, so only the OPEN panel (item 1) has its
 * answer in the DOM. Every answer is rendered here, the closed ones carrying the
 * `hidden` attribute, so the accordion has something to open and so the eight
 * closed answers stay in the HTML for Google (they back the FAQPage schema).
 * Nothing else about the markup changes.
 */
if (!defined('ABSPATH')) { exit; }

$faq_rows = iptv_lp_list('lp_faq_items', array(
    array(
        'question'  => 'What happens right after I pay?',
        'answer'    => 'Your IPTV subscription is activated automatically — nothing is queued for manual approval. Within about 2 to 5 minutes you get an email with your login details: an M3U playlist link plus your Xtream Codes username and password. The same line also appears under My IPTV Lines in your member panel. Paste the link into a free player such as TiviMate, IPTV Smarters or IBO Player Pro and you are watching in 4K. If the email is not there, check your spam folder before anything else.',
        'link_text' => 'Step-by-step setup guide',
        'link_url'  => iptv_page_url('guide', 'https://ibostreaming.com/guide/'),
    ),
    array(
        'question'  => 'Do I need to create an account before I buy?',
        'answer'    => 'Your order and your account are the same flow, so there is no separate signup to get out of the way first. Checkout runs inside the iBostreaming member panel, which means by the time your subscription is live you already have an account — and that account is where your IPTV credentials, your order history and your renewals live. Use the same email address throughout and everything stays in one place.',
        'link_text' => '',
        'link_url'  => '',
    ),
    array(
        'question'  => 'Can I try it before paying?',
        'answer'    => 'We do not offer a free IPTV trial. Free-trial links are the standard way throwaway resellers harvest email addresses, and we would rather not run that playbook. So the risk sits with us instead: start on the 1-month plan at $13.99 and you are covered by our 7-day money-back guarantee. Every plan carries the identical channel list, VOD library and 4K servers — the only difference between them is length and how many screens stream at once.',
        'link_text' => '',
        'link_url'  => '',
    ),
    array(
        'question'  => 'Is it refundable if it doesn\'t work for me?',
        'answer'    => 'Yes. Every plan includes a 7-day money-back guarantee. If we cannot get the service running properly on your device, contact support within 7 days of purchase and you get your money back. Worth knowing: most "it doesn\'t work" cases turn out to be one wrong setting in the player app or an ISP block, and our team clears those in a couple of minutes — so message us before you ask for a refund. It is usually the faster fix.',
        'link_text' => 'Contact support',
        'link_url'  => iptv_page_url('contact', 'https://ibostreaming.com/contact/'),
    ),
    array(
        'question'  => 'How many devices can I use, and does everyone share one login?',
        'answer'    => 'You pick the number of connections at checkout, from 1 to 4, and that is how many devices can stream at the same time. You may install your playlist on as many devices as you own — the limit is on simultaneous streams, not installations. So a single login on a 1-connection plan works on your TV, phone and tablet, but only one screen plays at a time. Two people watching different channels at once needs 2 connections; a whole family usually takes 3 or 4.',
        'link_text' => '',
        'link_url'  => '',
    ),
    array(
        'question'  => 'Will this renew automatically / get charged again?',
        'answer'    => 'No. Every plan is a one-time flat-rate payment for the period you choose — 1, 3, 6 or 12 months. There is no stored subscription, no automatic renewal and no second charge. When your time is nearly up you place a renewal order yourself from the member panel, which means you are never billed for something you did not ask for.',
        'link_text' => '',
        'link_url'  => '',
    ),
    array(
        'question'  => 'Who am I actually paying — is the checkout secure?',
        'answer'    => 'You are paying iBostreaming directly, never a third-party reseller. Checkout runs on our own member panel at panel.ibostreaming.com over an encrypted HTTPS/SSL connection, and all prices are in USD. Every order gets its own reference number and a receipt you can open any time under Orders in your panel — that reference is also what support asks for if you ever need to query a payment.',
        'link_text' => '',
        'link_url'  => '',
    ),
    array(
        'question'  => 'What if my credentials never arrive, or stop working later?',
        'answer'    => 'Message us — support is staffed 24/7. If nothing has arrived after about 10 minutes it is almost always the spam folder or a typo in the order email, and we resend to the correct address. If a line that was working stops later, that is normally a server switch or an expired plan rather than anything lost, and we re-issue or repoint your line. Fastest route is WhatsApp on +1 939 699 3536, or email support@ibostreaming.com.',
        'link_text' => 'Get help now',
        'link_url'  => iptv_page_url('contact', 'https://ibostreaming.com/contact/'),
    ),
    array(
        'question'  => 'What devices does this work on?',
        'answer'    => 'Essentially anything you already own. Smart TVs (Samsung, LG, Sony, Android TV), Amazon Firestick and Fire TV Cube, Apple TV, Android phones and tablets, iPhone and iPad, Windows and Mac computers, plus MAG and Formuler set-top boxes. You do not need to buy new hardware: install a free IPTV player like TiviMate, IPTV Smarters or IBO Player Pro, paste in your playlist, and the full channel list and VOD library load automatically.',
        'link_text' => 'See the device setup guides',
        'link_url'  => iptv_page_url('guide', 'https://ibostreaming.com/guide/'),
    ),
));

$faq_open_class   = 'bg-white rounded-2xl border transition-all duration-200 overflow-hidden border-zinc-300 shadow-sm ring-1 ring-zinc-200/60';
$faq_closed_class = 'bg-white rounded-2xl border transition-all duration-200 overflow-hidden border-zinc-200/90 hover:border-zinc-300 shadow-xs';
$faq_icon_open    = 'p-1.5 rounded-full border transition-all duration-200 flex-none bg-zinc-950 text-white border-zinc-950 rotate-180';
$faq_icon_closed  = 'p-1.5 rounded-full border transition-all duration-200 flex-none bg-zinc-100 text-zinc-600 border-zinc-200 group-hover:border-zinc-300';
?>
<section class="w-full bg-[#FAFAFC] text-zinc-900 py-16 sm:py-20 lg:py-24 px-4 sm:px-8 md:px-12 lg:px-16 font-sans border-t border-zinc-200/80 select-none overflow-hidden" id="faq-section"><div class="max-w-[1000px] mx-auto space-y-10 sm:space-y-12"><div class="text-center space-y-4 max-w-2xl mx-auto"><div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-emerald-50 border border-emerald-200/80 text-emerald-800 text-xs font-bold uppercase tracking-wider"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-question-mark w-3.5 h-3.5 text-emerald-600 stroke-[2.5]" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><path d="M12 17h.01"></path></svg><span><?php echo esc_html(iptv_text('lp_faq_badge', 'Got Questions?')); ?></span></div><h2 class="font-heading font-extrabold text-3xl sm:text-4xl lg:text-5xl text-zinc-950 tracking-tight"><?php echo esc_html(iptv_text('lp_faq_title', 'Frequently Asked')); ?> <span class="text-[#007CEB]"><?php echo esc_html(iptv_text('lp_faq_title_accent', 'Questions')); ?></span></h2><p class="font-sans font-normal text-sm sm:text-base text-zinc-600 subtext-opacity max-w-xl mx-auto"><?php echo esc_html(iptv_text('lp_faq_subtitle', 'Straight answers on payment, activation, refunds, devices and how many screens you get.')); ?></p></div><div class="space-y-3.5 max-w-3xl mx-auto"><?php
$faq_index = 0;
foreach ($faq_rows as $faq_row) {
    if (empty($faq_row['question'])) {
        continue;
    }

    $faq_index++;
    $faq_is_open = ($faq_index === 1);
    $faq_link_text = isset($faq_row['link_text']) ? $faq_row['link_text'] : '';
    $faq_link_url  = isset($faq_row['link_url']) ? $faq_row['link_url'] : '';
?><div class="<?php echo esc_attr($faq_is_open ? $faq_open_class : $faq_closed_class); ?>"><button class="w-full px-6 py-5 sm:py-5 flex items-center justify-between text-left gap-4 focus:outline-none cursor-pointer group" aria-expanded="<?php echo $faq_is_open ? 'true' : 'false'; ?>" id="faq-btn-faq-<?php echo (int) $faq_index; ?>"><span class="font-heading font-bold text-base sm:text-lg text-zinc-950 tracking-tight group-hover:text-[#007CEB] transition-colors duration-150"><?php echo esc_html($faq_row['question']); ?></span><div class="<?php echo esc_attr($faq_is_open ? $faq_icon_open : $faq_icon_closed); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 stroke-[2.5]" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg></div></button><div class="px-6 pb-5 pt-1 border-t border-zinc-100 text-xs sm:text-sm leading-relaxed font-sans text-zinc-600 subtext-opacity animate-fadeIn"<?php echo $faq_is_open ? '' : ' hidden'; ?>><?php echo esc_html(isset($faq_row['answer']) ? $faq_row['answer'] : ''); ?><?php if ($faq_link_text !== '' && $faq_link_url !== '') : ?><span style="display: block; margin-top: 12px;"><a href="<?php echo esc_url($faq_link_url); ?>" style="color: rgb(0, 124, 235); font-weight: 700; margin-right: 18px; text-decoration: none; white-space: nowrap;"><?php echo esc_html($faq_link_text); ?> →</a></span><?php endif; ?></div></div><?php
}
?></div><div class="max-w-2xl mx-auto p-4 rounded-2xl bg-zinc-100/80 border border-zinc-200/70 flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left"><div class="flex items-center gap-2.5"><div class="p-2 rounded-xl bg-white text-emerald-600 border border-zinc-200/60 flex-none shadow-xs"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles w-4 h-4" aria-hidden="true"><path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path><path d="M20 2v4"></path><path d="M22 4h-4"></path><circle cx="4" cy="20" r="2"></circle></svg></div><span class="font-sans font-medium text-xs sm:text-sm text-zinc-700"><?php echo esc_html(iptv_text('lp_faq_cta_text', 'Have a question that isn\'t answered here?')); ?></span></div><a href="#need-help-section" class="text-xs font-bold text-[#007CEB] hover:underline uppercase tracking-wide flex-none"><?php echo esc_html(iptv_text('lp_faq_cta_link_text', 'Ask Support →')); ?></a></div></div></section>

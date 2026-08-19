<?php
/**
 * Section: FAQ (Design v2)
 * Single-column accordion; content still comes from the ACF faq_list repeater.
 */
$faq_title    = iptv_text('faq_title', 'Frequently Asked Questions');
$faq_subtitle = iptv_text('faq_subtitle', 'Got questions? We have answers.');

$faq_items = [];
if (function_exists('get_field')) {
    $front_page_id = get_option('page_on_front');
    $acf_items     = $front_page_id ? get_field('faq_list', $front_page_id) : get_field('faq_list');
    if (!empty($acf_items) && is_array($acf_items)) {
        foreach ($acf_items as $row) {
            if (!empty($row['question'])) {
                $faq_items[] = ['q' => $row['question'], 'a' => isset($row['answer']) ? $row['answer'] : ''];
            }
        }
    }
}

if (empty($faq_items)) {
    // The nine questions the live ibostreaming.com homepage already answers,
    // copied verbatim on 2026-08-19. The theme's original bundled set was
    // factually wrong for this business: it promised a 24-hour free trial
    // (we do not offer one) and a 30-day money-back guarantee (it is 7 days).
    // Those claims are also the ones the FAQPage schema publishes, so they
    // must match the refund policy page exactly.
    $faq_items = [
        ['q' => 'What happens right after I pay?', 'a' => 'Your IPTV subscription is activated automatically — nothing is queued for manual approval. Within about 2 to 5 minutes you get an email with your login details: an M3U playlist link plus your Xtream Codes username and password. The same line also appears under My IPTV Lines in your member panel. Paste the link into a free player such as TiviMate, IPTV Smarters or IBO Player Pro and you are watching in 4K. If the email is not there, check your spam folder before anything else.'],
        ['q' => 'Do I need to create an account before I buy?', 'a' => 'Your order and your account are the same flow, so there is no separate signup to get out of the way first. Checkout runs inside the iBostreaming member panel, which means by the time your subscription is live you already have an account — and that account is where your IPTV credentials, your order history and your renewals live. Use the same email address throughout and everything stays in one place.'],
        ['q' => 'Can I try it before paying?', 'a' => 'We do not offer a free IPTV trial. Free-trial links are the standard way throwaway resellers harvest email addresses, and we would rather not run that playbook. So the risk sits with us instead: start on the 1-month plan at $13.99 and you are covered by our 7-day money-back guarantee. Every plan carries the identical channel list, VOD library and 4K servers — the only difference between them is length and how many screens stream at once.'],
        ['q' => 'Is it refundable if it doesn\'t work for me?', 'a' => 'Yes. Every plan includes a 7-day money-back guarantee. If we cannot get the service running properly on your device, contact support within 7 days of purchase and you get your money back. Worth knowing: most \\"it doesn\'t work\\" cases turn out to be one wrong setting in the player app or an ISP block, and our team clears those in a couple of minutes — so message us before you ask for a refund. It is usually the faster fix.'],
        ['q' => 'How many devices can I use, and does everyone share one login?', 'a' => 'You pick the number of connections at checkout, from 1 to 4, and that is how many devices can stream at the same time. You may install your playlist on as many devices as you own — the limit is on simultaneous streams, not installations. So a single login on a 1-connection plan works on your TV, phone and tablet, but only one screen plays at a time. Two people watching different channels at once needs 2 connections; a whole family usually takes 3 or 4.'],
        ['q' => 'Will this renew automatically / get charged again?', 'a' => 'No. Every plan is a one-time flat-rate payment for the period you choose — 1, 3, 6 or 12 months. There is no stored subscription, no automatic renewal and no second charge. When your time is nearly up you place a renewal order yourself from the member panel, which means you are never billed for something you did not ask for.'],
        ['q' => 'Who am I actually paying — is the checkout secure?', 'a' => 'You are paying iBostreaming directly, never a third-party reseller. Checkout runs on our own member panel at panel.ibostreaming.com over an encrypted HTTPS/SSL connection, and all prices are in USD. Every order gets its own reference number and a receipt you can open any time under Orders in your panel — that reference is also what support asks for if you ever need to query a payment.'],
        ['q' => 'What if my credentials never arrive, or stop working later?', 'a' => 'Message us — support is staffed 24/7. If nothing has arrived after about 10 minutes it is almost always the spam folder or a typo in the order email, and we resend to the correct address. If a line that was working stops later, that is normally a server switch or an expired plan rather than anything lost, and we re-issue or repoint your line. Fastest route is WhatsApp on +1 939 699 3536, or email <a href="mailto:support@ibostreaming.com">support@ibostreaming.com</a>.'],
        ['q' => 'What devices does this work on?', 'a' => 'Essentially anything you already own. Smart TVs (Samsung, LG, Sony, Android TV), Amazon Firestick and Fire TV Cube, Apple TV, Android phones and tablets, iPhone and iPad, Windows and Mac computers, plus MAG and Formuler set-top boxes. You do not need to buy new hardware: install a free IPTV player like TiviMate, IPTV Smarters or IBO Player Pro, paste in your playlist, and the full channel list and VOD library load automatically.'],
    ];
}
?>
<section class="faq dv2-section" id="faq">
    <div class="faq-container">
        <div class="dv2-section-head">
            <h2><?php echo esc_html($faq_title); ?></h2>
            <p><?php echo esc_html($faq_subtitle); ?></p>
        </div>

        <div class="dv2-faq-list">
            <?php foreach ($faq_items as $item) :
                if (empty($item['q'])) {
                    continue;
                }
                ?>
                <div class="dv2-faq-item">
                    <button class="dv2-faq-q" type="button" aria-expanded="false">
                        <span><?php echo esc_html($item['q']); ?></span>
                        <span class="dv2-faq-icon" aria-hidden="true">›</span>
                    </button>
                    <div class="dv2-faq-a">
                        <div class="dv2-faq-a-inner"><?php echo wp_kses_post($item['a']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
    // One panel open at a time, matching the mockup's behaviour.
    document.querySelectorAll('.dv2-faq-q').forEach(function (button) {
        button.addEventListener('click', function () {
            var item = button.parentElement;
            var willOpen = !item.classList.contains('open');

            document.querySelectorAll('.dv2-faq-item.open').forEach(function (openItem) {
                openItem.classList.remove('open');
                var q = openItem.querySelector('.dv2-faq-q');
                if (q) q.setAttribute('aria-expanded', 'false');
            });

            if (willOpen) {
                item.classList.add('open');
                button.setAttribute('aria-expanded', 'true');
            }
        });
    });
</script>

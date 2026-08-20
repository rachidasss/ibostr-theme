<?php
/**
 * Front page Product + FAQPage schema, and the FAQ list both it and the
 * accordion read.
 *
 * WHY THIS EXISTS
 *
 * The live front page carries two JSON-LD blocks:
 *   <script class="rank-math-schema-pro">  Organization, WebSite, WebPage, ...
 *   <script id="ibo-schema">               Product, AggregateOffer, FAQPage
 *
 * The first is Rank Math and is attached to the page, so it survives whatever
 * template renders it. The second is injected by a mu-plugin that only fires on
 * the Elementor landing pages - verified: present on / and /fr/, absent on
 * /about/, /shop/ and every theme-rendered page. The moment the front page moves
 * to this theme's template that block stops being emitted, and the page loses
 * its Product schema, its AggregateOffer price range and all nine FAQ entries -
 * the price and FAQ rich results with them.
 *
 * So the theme emits its own equivalent, built from the data it already renders:
 * prices from IPTV_Currency_Settings, questions from the same list the accordion
 * uses. That also closes the drift the audit flagged - the visible FAQ and the
 * FAQ schema had two independent sources and nothing kept them in step. Now
 * there is one source, iptv_front_page_faq_items(), and both read it.
 *
 * @package iBostreaming
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('iptv_front_page_faq_items')) {
    /**
     * The front page FAQ, from ACF when filled and these defaults otherwise.
     *
     * Single source for the accordion (front-page/sections/faq.php) and the
     * FAQPage schema below. Answers may contain inline HTML; callers decide
     * whether to keep it (accordion) or strip it (schema).
     *
     * @return array List of ['q' => string, 'a' => string].
     */
    function iptv_front_page_faq_items()
    {
        $items = array();

        if (function_exists('get_field')) {
            $front_page_id = get_option('page_on_front');
            $acf_items     = $front_page_id ? get_field('faq_list', $front_page_id) : get_field('faq_list');

            if (!empty($acf_items) && is_array($acf_items)) {
                foreach ($acf_items as $row) {
                    if (!empty($row['question'])) {
                        $items[] = array(
                            'q' => $row['question'],
                            'a' => isset($row['answer']) ? $row['answer'] : '',
                        );
                    }
                }
            }
        }

        if (!empty($items)) {
            return $items;
        }

        // The nine questions the live homepage answers, copied verbatim.
        return array(
            array('q' => 'What happens right after I pay?', 'a' => 'Your IPTV subscription is activated automatically — nothing is queued for manual approval. Within about 2 to 5 minutes you get an email with your login details: an M3U playlist link plus your Xtream Codes username and password. The same line also appears under My IPTV Lines in your member panel. Paste the link into a free player such as TiviMate, IPTV Smarters or IBO Player Pro and you are watching in 4K. If the email is not there, check your spam folder before anything else.'),
            array('q' => 'Do I need to create an account before I buy?', 'a' => 'Your order and your account are the same flow, so there is no separate signup to get out of the way first. Checkout runs inside the iBostreaming member panel, which means by the time your subscription is live you already have an account — and that account is where your IPTV credentials, your order history and your renewals live. Use the same email address throughout and everything stays in one place.'),
            array('q' => 'Can I try it before paying?', 'a' => 'We do not offer a free IPTV trial. Free-trial links are the standard way throwaway resellers harvest email addresses, and we would rather not run that playbook. So the risk sits with us instead: start on the 1-month plan at $13.99 and you are covered by our 7-day money-back guarantee. Every plan carries the identical channel list, VOD library and 4K servers — the only difference between them is length and how many screens stream at once.'),
            array('q' => 'Is it refundable if it doesn\'t work for me?', 'a' => 'Yes. Every plan includes a 7-day money-back guarantee. If we cannot get the service running properly on your device, contact support within 7 days of purchase and you get your money back. Worth knowing: most \\"it doesn\'t work\\" cases turn out to be one wrong setting in the player app or an ISP block, and our team clears those in a couple of minutes — so message us before you ask for a refund. It is usually the faster fix.'),
            array('q' => 'How many devices can I use, and does everyone share one login?', 'a' => 'You pick the number of connections at checkout, from 1 to 4, and that is how many devices can stream at the same time. You may install your playlist on as many devices as you own — the limit is on simultaneous streams, not installations. So a single login on a 1-connection plan works on your TV, phone and tablet, but only one screen plays at a time. Two people watching different channels at once needs 2 connections; a whole family usually takes 3 or 4.'),
            array('q' => 'Will this renew automatically / get charged again?', 'a' => 'No. Every plan is a one-time flat-rate payment for the period you choose — 1, 3, 6 or 12 months. There is no stored subscription, no automatic renewal and no second charge. When your time is nearly up you place a renewal order yourself from the member panel, which means you are never billed for something you did not ask for.'),
            array('q' => 'Who am I actually paying — is the checkout secure?', 'a' => 'You are paying iBostreaming directly, never a third-party reseller. Checkout runs on our own member panel at panel.ibostreaming.com over an encrypted HTTPS/SSL connection, and all prices are in USD. Every order gets its own reference number and a receipt you can open any time under Orders in your panel — that reference is also what support asks for if you ever need to query a payment.'),
            array('q' => 'What if my credentials never arrive, or stop working later?', 'a' => 'Message us — support is staffed 24/7. If nothing has arrived after about 10 minutes it is almost always the spam folder or a typo in the order email, and we resend to the correct address. If a line that was working stops later, that is normally a server switch or an expired plan rather than anything lost, and we re-issue or repoint your line. Fastest route is WhatsApp on +1 939 699 3536, or email <!--email_off--><a href="mailto:support@ibostreaming.com">support@ibostreaming.com</a><!--/email_off-->.'),
            array('q' => 'What devices does this work on?', 'a' => 'Essentially anything you already own. Smart TVs (Samsung, LG, Sony, Android TV), Amazon Firestick and Fire TV Cube, Apple TV, Android phones and tablets, iPhone and iPad, Windows and Mac computers, plus MAG and Formuler set-top boxes. You do not need to buy new hardware: install a free IPTV player like TiviMate, IPTV Smarters or IBO Player Pro, paste in your playlist, and the full channel list and VOD library load automatically.'),
        );
    }
}

if (!function_exists('iptv_front_page_schema')) {
    /**
     * Emit Product + AggregateOffer + FAQPage for the front page.
     *
     * Deliberately mirrors the mu-plugin's <script id="ibo-schema"> block, using
     * the same @id anchors so nothing that already references them breaks. The
     * numbers are read from the live price table rather than hard-coded, so the
     * AggregateOffer can never claim a range the page does not actually sell -
     * which is the failure the old iBostreaming price list caused.
     */
    function iptv_front_page_schema()
    {
        if (!iptv_is_front_page_template()) {
            return;
        }

        // The mu-plugin still fires on the Elementor landing pages. If it has
        // already put its block on the page, adding a second Product/FAQPage
        // would be a duplicate, which is worse than none.
        if (defined('IBO_SCHEMA_EMITTED')) {
            return;
        }

        $home = function_exists('pll_home_url') ? pll_home_url() : home_url('/');
        $home = trailingslashit($home);

        // ---- prices ---------------------------------------------------------
        $low = $high = null;
        $count = 0;

        if (class_exists('IPTV_Currency_Settings')) {
            $table = IPTV_Currency_Settings::get_price_table();

            foreach (array('1_month', '3_months', '6_months', '12_months') as $duration) {
                if (empty($table[$duration]) || !is_array($table[$duration])) {
                    continue;
                }
                foreach ($table[$duration] as $device => $prices) {
                    if (empty($prices['usd'])) {
                        continue;
                    }
                    $value = (float) $prices['usd'];
                    if ($value <= 0) {
                        continue;
                    }
                    $count++;
                    $low  = ($low === null) ? $value : min($low, $value);
                    $high = ($high === null) ? $value : max($high, $value);
                }
            }
        }

        $graph = array();

        if ($count > 0) {
            $checkout = iptv_config('checkout_base_url', 'https://panel.ibostreaming.com/checkout');

            $graph[] = array(
                '@type'       => 'Product',
                '@id'         => $home . '#product',
                'name'        => iptv_text('schema_product_name', 'iBostreaming IPTV Subscription'),
                'description' => iptv_text(
                    'schema_product_description',
                    'IPTV subscription with 40,000+ live channels and 200,000+ movies and series in 4K, on 1 to 4 screens. One-time payment, no contract and no auto-renew.'
                ),
                'brand'       => array(
                    '@type' => 'Brand',
                    'name'  => iptv_text('schema_brand_name', 'iBostreaming'),
                ),
                'url'         => $home,
                'offers'      => array(
                    '@type'         => 'AggregateOffer',
                    'priceCurrency' => 'USD',
                    'lowPrice'      => number_format($low, 2, '.', ''),
                    'highPrice'     => number_format($high, 2, '.', ''),
                    'offerCount'    => $count,
                    'availability'  => 'https://schema.org/InStock',
                    'url'           => $checkout . '?connections=1&duration=1',
                ),
            );
        }

        // ---- FAQ ------------------------------------------------------------
        $faq = function_exists('iptv_front_page_faq_items') ? iptv_front_page_faq_items() : array();
        $entities = array();

        foreach ($faq as $item) {
            if (empty($item['q']) || empty($item['a'])) {
                continue;
            }

            // Schema wants the answer as text. wp_strip_all_tags on the answer
            // the accordion renders keeps the two in step by construction: same
            // source, one of them just without markup.
            $entities[] = array(
                '@type'          => 'Question',
                'name'           => wp_strip_all_tags($item['q']),
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => wp_strip_all_tags($item['a']),
                ),
            );
        }

        if (!empty($entities)) {
            $graph[] = array(
                '@type'      => 'FAQPage',
                '@id'        => $home . '#faq',
                'mainEntity' => $entities,
            );
        }

        if (empty($graph)) {
            return;
        }

        $payload = array(
            '@context' => 'https://schema.org',
            '@graph'   => $graph,
        );

        echo "\n" . '<script type="application/ld+json" id="ibo-theme-schema">'
            . wp_json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            . '</script>' . "\n";
    }

    add_action('wp_head', 'iptv_front_page_schema', 20);
}

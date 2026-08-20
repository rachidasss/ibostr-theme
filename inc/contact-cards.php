<?php
/**
 * Contact cards
 *
 * The support cards on the front page — email, WhatsApp, Telegram — extracted so
 * the Contact page can show the same thing instead of a form.
 *
 * The cards come from the `contact_cards` ACF repeater on the front page, which
 * Polylang resolves per language, so one shortcode renders correctly translated
 * cards on all six Contact pages. Pasting the markup into each page's content
 * would have meant six copies to keep in step.
 *
 * Usage in a page: [nordictv_contact]
 *   heading="1"  also render the section's <h2> (the page template already
 *                prints the page title, so this is off by default)
 *   intro="0"    drop the intro paragraph
 *
 * @package Nordic_IPTV
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('iptv_contact_cards')) {
    /**
     * The support cards, translated for the current language.
     *
     * @return array<int,array{label:string,value:string,link:string,blank:bool}>
     */
    function iptv_contact_cards()
    {
        $cards = array();

        $rows = function_exists('get_field')
            ? get_field('contact_cards', get_option('page_on_front'))
            : null;

        if (is_array($rows)) {
            foreach ($rows as $row) {
                if (empty($row['card_label'])) {
                    continue;
                }
                $cards[] = array(
                    'label' => $row['card_label'],
                    'value' => isset($row['card_value']) ? $row['card_value'] : '',
                    'link'  => isset($row['card_link']) ? $row['card_link'] : '',
                    'blank' => !empty($row['card_blank']),
                );
            }
        }

        if (empty($cards)) {
            $cards = array(
                array(
                    'label' => iptv_text('contact_card_email_label', 'Email Support'),
                    'value' => iptv_text('contact_card_email_value', 'support@ibostreaming.com'),
                    'link'  => 'mailto:support@ibostreaming.com',
                    'blank' => false,
                ),
                array(
                    'label' => iptv_text('contact_card_whatsapp_label', 'WhatsApp'),
                    'value' => iptv_text('contact_card_whatsapp_value', 'Chat with us live'),
                    'link'  => 'https://wa.me/19396993536',
                    'blank' => true,
                ),
                array(
                    'label' => iptv_text('contact_card_telegram_label', 'Telegram'),
                    'value' => iptv_text('contact_card_telegram_value', '@iBostreaming'),
                    'link'  => 'https://t.me/iBostreaming',
                    'blank' => true,
                ),
            );
        }

        return $cards;
    }
}

if (!function_exists('iptv_contact_card_channel')) {
    /**
     * Which service a card points at, derived from its link.
     *
     * Keyed off the link rather than the label because the label is translated
     * — the Finnish card says "Sähköposti", not "Email" — so matching on text
     * would only ever work for English.
     *
     * @param string $link
     * @return string One of: email, whatsapp, telegram, other.
     */
    function iptv_contact_card_channel($link)
    {
        $link = strtolower($link);

        if (strpos($link, 'mailto:') === 0) {
            return 'email';
        }
        if (strpos($link, 'wa.me') !== false || strpos($link, 'whatsapp') !== false) {
            return 'whatsapp';
        }
        if (strpos($link, 't.me') !== false || strpos($link, 'telegram') !== false) {
            return 'telegram';
        }

        return 'other';
    }
}

if (!function_exists('iptv_contact_whatsapp_number')) {
    /**
     * The WhatsApp number to print on the card, read out of its own wa.me link
     * so the two can never disagree.
     *
     * Grouped as "+CC NNN NNN NNN", which suits the numbers in use here. An
     * explicit `contact_card_whatsapp_number` value wins if one is set, since
     * no generic grouping is right for every country.
     *
     * @param string $link
     * @return string Empty when no digits can be read out of the link.
     */
    function iptv_contact_whatsapp_number($link)
    {
        $override = iptv_text('contact_card_whatsapp_number', '');
        if ($override) {
            return $override;
        }

        $digits = preg_replace('/\D+/', '', $link);
        if (!$digits) {
            return '';
        }

        // Two-digit country code, then the national part in threes.
        $cc       = substr($digits, 0, 2);
        $national = substr($digits, 2);

        return '+' . $cc . ' ' . trim(chunk_split($national, 3, ' '));
    }
}

if (!function_exists('iptv_email_off')) {
    /**
     * Shield email addresses in editor content from Cloudflare's obfuscation.
     *
     * Cloudflare Scrape Shield rewrites every mailto: link it finds into
     * <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
     * data-cfemail="..."> with the words "[email protected]" as the visible
     * text, and only a script restores the real address. A crawler that does
     * not run that script — and any tool reading the raw HTML — sees the
     * placeholder. On /about/ the entire "Getting hold of a human" section
     * offered readers "[email protected]".
     *
     * The theme's own templates wrap their addresses at the point of output,
     * but addresses typed into the editor are not covered by that, and there is
     * no reason to hand-edit every page. <!--email_off--> is Cloudflare's
     * documented opt-out; it strips the comments from the response, so nothing
     * extra is shipped.
     *
     * Preferred over switching Email Obfuscation off in the dashboard, because
     * panel.ibostreaming.com sits on the same Cloudflare zone and that setting
     * is zone-wide.
     *
     * @param string $html Post content.
     * @return string
     */
    function iptv_email_off($html)
    {
        if (!is_string($html) || $html === '') {
            return $html;
        }

        // Already wrapped by a template: leave it alone rather than nest.
        if (strpos($html, '<!--email_off-->') !== false) {
            return $html;
        }

        // Cloudflare rewrites BARE addresses in text, not just mailto: links.
        // /about/ has no mailto: anywhere — it prints the address as plain text
        // and Cloudflare turned that into an obfuscated anchor by itself. So
        // matching links alone misses the common case.
        //
        // Wrapping the whole body rather than each address: the markers are a
        // region opt-out, one balanced pair is all Cloudflare needs, and it
        // avoids a regex that has to tell an address in text from one inside an
        // attribute. Nothing here is a link Cloudflare should be rewriting.
        if (!preg_match('/[\w.+-]+@[\w-]+\.[\w.-]+/', $html)) {
            return $html;
        }

        return '<!--email_off-->' . $html . '<!--/email_off-->';
    }

    add_filter('the_content', 'iptv_email_off', 20);
    add_filter('widget_text', 'iptv_email_off', 20);
}

if (!function_exists('iptv_contact_cards_grid')) {
    /**
     * The cards themselves, without any section chrome.
     *
     * @return string
     */
    function iptv_contact_cards_grid()
    {
        $cards = iptv_contact_cards();
        if (empty($cards)) {
            return '';
        }

        // Per-channel call to action. WhatsApp is green because that is the
        // colour people already associate with it; the other two take the
        // brand blue.
        $ctas = array(
            'email'    => array('label' => iptv_text('contact_cta_email', 'Send an email'), 'variant' => 'blue'),
            'whatsapp' => array('label' => iptv_text('contact_cta_whatsapp', 'Send a WhatsApp message'), 'variant' => 'green'),
            'telegram' => array('label' => iptv_text('contact_cta_telegram', 'Message on Telegram'), 'variant' => 'blue'),
        );

        $out = '<div class="dv2-support-grid">';

        foreach ($cards as $card) {
            $target  = $card['blank'] ? ' target="_blank" rel="noopener noreferrer"' : '';
            $channel = iptv_contact_card_channel($card['link']);

            $value = $card['value'];
            if ($channel === 'whatsapp') {
                $number = iptv_contact_whatsapp_number($card['link']);
                if ($number) {
                    $value = $number;
                }
            }

            $cta = isset($ctas[$channel]) ? $ctas[$channel] : null;

            // Cloudflare's Scrape Shield rewrites any mailto: link and any email
            // it finds in the HTML into <a href="/cdn-cgi/l/email-protection">
            // with the address hidden in a data-cfemail attribute and the words
            // "[email protected]" as the visible text. A crawler that does not
            // execute the accompanying script sees exactly that string — so the
            // support address, one of the strongest trust signals on the page,
            // reached Google as a placeholder.
            //
            // <!--email_off--> is Cloudflare's own documented opt-out and is the
            // fix that does not require turning obfuscation off for the whole
            // zone (panel.ibostreaming.com shares it). Cloudflare strips these
            // comments from the response, so nothing extra is shipped.
            $card_markup = sprintf(
                '<a href="%s" class="dv2-support-card dv2-support-card--%s"%s><h3>%s</h3><p>%s</p>%s</a>',
                esc_url($card['link']),
                esc_attr($channel),
                $target,
                esc_html($card['label']),
                esc_html($value),
                $cta
                    ? sprintf(
                        // A span, not a nested <a>: the whole card is already
                        // the link, and anchors cannot legally nest.
                        '<span class="dv2-support-cta dv2-support-cta--%s">%s</span>',
                        esc_attr($cta['variant']),
                        esc_html($cta['label'])
                    )
                    : ''
            );

            // Only the email card needs the opt-out; wrapping the others would
            // be noise Cloudflare has to strip for nothing.
            if ($channel === 'email') {
                $card_markup = '<!--email_off-->' . $card_markup . '<!--/email_off-->';
            }

            $out .= $card_markup;
        }

        return $out . '</div>';
    }
}

/**
 * [nordictv_contact] — the front page's support cards, for use on the Contact
 * page in place of a contact form.
 */
add_shortcode('nordictv_contact', function ($atts) {
    $atts = shortcode_atts(array(
        'heading' => '0',
        'intro'   => '1',
    ), $atts, 'nordictv_contact');

    $out = '<div class="dv2-contact-page">';

    if ($atts['heading'] !== '0') {
        $out .= '<h2>' . esc_html(iptv_text('contact_title', 'We\'re here to help')) . '</h2>';
    }

    if ($atts['intro'] !== '0') {
        $out .= '<p class="dv2-contact-page-intro">' . esc_html(iptv_text(
            'contact_subtitle',
            'Reach out anytime via email, WhatsApp, or Telegram. Our support team typically responds within minutes.'
        )) . '</p>';
    }

    $out .= iptv_contact_cards_grid();

    return $out . '</div>';
});

<?php
/**
 * Section: FAQ (Design v2)
 * Single-column accordion; content still comes from the ACF faq_list repeater.
 */
$faq_title    = iptv_text('faq_title', 'Frequently Asked Questions');
$faq_subtitle = iptv_text('faq_subtitle', 'Straight answers on payment, activation, refunds, devices and how many screens you get.');

// One source for the accordion and the FAQPage schema.
//
// These used to be two independent lists: this file held the questions the page
// renders, and a mu-plugin held the questions it published as schema. Nothing
// kept them in step, so an edit here silently disagreed with what Google was
// told. iptv_front_page_faq_items() (inc/front-page-schema.php) is now the only
// definition, and inc/front-page-schema.php builds the JSON-LD from it.
$faq_items = function_exists('iptv_front_page_faq_items')
    ? iptv_front_page_faq_items()
    : array();
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

<?php
/**
 * Section: iBostreaming vs. traditional services (Design v2)
 */

$comp_rows = [
    1 => ['40,000+ channels from 198 countries',      '200–500 (cable) or none (streaming)'],
    2 => ['200,000+ movies & series, all genres',     'Limited per platform (~5,000 each)'],
    3 => ['All sports included — every league',       'Paid add-on or separate subscription'],
    4 => ['4K & 8K Ultra HD included',                '4K only on premium tier (+cost)'],
    5 => ['Up to 4 devices at once',                  '1–2 per service'],
    6 => ['From $8/mo — everything included',         '$60–$100+/mo across services'],
    7 => ['90% average savings vs. combined services', 'Billed monthly, price rises every year'],
];
?>
<section class="comparison dv2-section">
    <div class="comparison-inner">
        <div class="dv2-section-head">
            <h2><?php echo esc_html(iptv_text('comp_title_main', 'Tired of IPTV Providers Who Take Your Money & Disappear?')); ?></h2>
            <p>
                <?php echo esc_html(iptv_text('comp_desc', 'Most IPTV sellers vanish the moment you make a payment. At iBo Streaming, we support you for every single day of your subscription — guaranteed 24/7 assistance and anti-freeze servers.')); ?>
            </p>
        </div>

        <div class="dv2-compare">
            <div class="dv2-compare-head">
                <div class="dv2-compare-head-ours">
                    <div class="dv2-compare-head-label"><?php echo esc_html(iptv_text('comp_ours_label', 'iBostreaming')); ?></div>
                    <div class="dv2-compare-head-price"><?php echo esc_html(iptv_text('comp_ours_price', 'from $8/mo')); ?></div>
                </div>
                <div class="dv2-compare-head-theirs">
                    <div class="dv2-compare-head-label"><?php echo esc_html(iptv_text('comp_theirs_label', 'Other IPTV Sellers')); ?></div>
                    <div class="dv2-compare-head-price"><?php echo esc_html(iptv_text('comp_theirs_price', '$60–$100+/mo')); ?></div>
                </div>
            </div>

            <?php foreach ($comp_rows as $n => $row) : ?>
                <div class="dv2-compare-row">
                    <div class="dv2-compare-good"><?php echo esc_html(iptv_text("comp_row_{$n}_good", $row[0])); ?></div>
                    <div class="dv2-compare-bad"><?php echo esc_html(iptv_text("comp_row_{$n}_bad", $row[1])); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

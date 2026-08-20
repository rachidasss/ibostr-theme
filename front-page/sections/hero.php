<?php
/**
 * Section: Hero (Design v2 — iBostreaming Blue & White)
 */

// Hero backdrop. This is deliberately a *new* key rather than the old
// `hero_image_url`: that one holds each language's foreground artwork, which
// carried baked-in text and was never built to sit behind copy. Reusing it
// would have pulled those per-language images in as backgrounds.
$hero_bg_url = iptv_text(
    'hero_background_url',
    'https://ibostreaming.com/wp-content/uploads/2026/07/hero-bg.webp'
);

$primary_label   = iptv_text('hero_primary_cta_label', 'Get Access Now');
$primary_url     = iptv_text('hero_primary_cta_url', '#pricing');
$secondary_label = iptv_text('hero_secondary_cta_label', 'Pricing & Plans ↓');
$secondary_url   = iptv_text('hero_secondary_cta_url', '#pricing');
?>
<section class="dv2-hero dv2-hero--backdrop">
    <?php
    // The backdrop is its own layer rather than a background on the section so
    // the scrim (.dv2-hero-bg::after) can sit between the photo and the copy.
    // The section is full-bleed, so the shell moves to .dv2-hero-inner.
    ?>
    <?php
    // A real <img>, not a CSS background.
    //
    // This artwork is the page's Largest Contentful Paint element. As a
    // background-image it could not be fetched until the stylesheet had been
    // parsed and the element laid out, so the browser's preload scanner - which
    // reads the raw HTML before any of that - never saw it. A plain <img> with
    // fetchpriority="high" is discovered in the first pass of the markup and
    // starts downloading immediately, which is the single biggest lever on LCP
    // here.
    //
    // It stays decorative: alt="" and aria-hidden on the wrapper, because the
    // scrim over it means it carries no information. Explicit width/height give
    // the browser the aspect ratio up front so nothing shifts (the file is
    // 1376x768). object-fit/object-position in the CSS reproduce the previous
    // background-size:cover and background-position:center right exactly.
    ?>
    <div class="dv2-hero-bg" aria-hidden="true">
        <img class="dv2-hero-bg-img"
             src="<?php echo esc_url($hero_bg_url); ?>"
             alt=""
             width="1376" height="768"
             fetchpriority="high" decoding="async">
    </div>

    <div class="dv2-hero-inner">
        <div class="dv2-hero-copy">
            <div class="dv2-trustpilot">
                <span class="dv2-trustpilot-name">★ Trustpilot</span>
                <span><?php echo esc_html(iptv_text('hero_trust_label', 'Excellent')); ?></span>
                <span class="dv2-trustpilot-stars" aria-hidden="true">
                    <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                </span>
                <span>
                    <strong><?php echo esc_html(iptv_text('hero_trust_score', '4.9')); ?></strong>
                    <?php echo esc_html(iptv_text('hero_trust_suffix', 'out of 5')); ?>
                </span>
            </div>

            <?php
            // Two lines, each a block so the break is deliberate rather than left to
            // wrapping. The second line is split so only its opening phrase
            // (hero_title_span) takes the blue accent.
            ?>
            <?php
            // Copy matches the live ibostreaming.com homepage verbatim (taken
            // 2026-08-19) so replacing that page with this template does not
            // change a word of what visitors and Google already see. The three
            // parts reassemble into the live H1:
            //   "Every Channel You've Been Missing All in One Place. Save $1,500/Year."
            ?>
            <h1 class="dv2-hero-title">
                <span class="dv2-hero-line">
                    <?php echo esc_html(iptv_text('hero_title', 'Every Channel You\'ve Been Missing')); ?>
                </span>
                <span class="dv2-hero-line">
                    <span class="dv2-hero-accent"><?php echo esc_html(iptv_text('hero_title_span', 'All in One Place.')); ?></span>
                    <?php echo esc_html(iptv_text('hero_title_3', 'Save $1,500/Year.')); ?>
                </span>
            </h1>

            <p class="dv2-hero-sub">
                <?php echo wp_kses_post(iptv_text('hero_subtitle', 'The world\'s largest IPTV service. Watch 40,000+ channels from USA, UK, Canada, Europe, Asia, and Latin America in crystal-clear 4K. No contracts. One time payment. No regional blocks. Works on any device, anywhere.')); ?>
            </p>

            <div class="dv2-hero-actions">
                <a href="<?php echo esc_url($primary_url); ?>" class="dv2-btn dv2-btn-primary dv2-btn-lg">
                    ▶ <?php echo esc_html($primary_label); ?>
                </a>
                <a href="<?php echo esc_url($secondary_url); ?>" class="dv2-btn dv2-btn-lg dv2-hero-link">
                    <?php echo esc_html($secondary_label); ?>
                </a>
            </div>
        </div>
    </div>
</section>

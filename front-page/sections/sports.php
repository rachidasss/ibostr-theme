<?php
/**
 * Section: Sports (Design v2)
 * Split panel with a single artwork alongside the copy.
 */

$sports_cta_field  = function_exists('get_field') ? get_field('sports_cta', get_option('page_on_front')) : null;
$sports_cta_url    = (!empty($sports_cta_field['url'])) ? $sports_cta_field['url'] : '#pricing';
$sports_cta_label  = (!empty($sports_cta_field['title'])) ? $sports_cta_field['title'] : iptv_text('sports_cta', 'Watch live sport now');
$sports_cta_target = (!empty($sports_cta_field['target'])) ? ' target="' . esc_attr($sports_cta_field['target']) . '"' : '';

// The six-tile mosaic was replaced by a single artwork. The sport_N_name fields
// it used are still in the ACF group and still drive the sport landing pages.
?>
<section class="dv2-split">
    <div class="dv2-split-copy">
        <h2 class="dv2-split-title">
            <?php echo esc_html(iptv_text('sports_title', 'Every sport.')); ?>
            <em><?php echo esc_html(iptv_text('sports_title_span', 'Every match.')); ?></em>
        </h2>
        <p>
            <?php echo esc_html(iptv_text('sports_desc', 'Never miss a game again. Every major league, every tournament, every PPV event — football, basketball, motorsport, boxing and more, in HD and 4K.')); ?>
        </p>
        <a href="<?php echo esc_url($sports_cta_url); ?>" class="dv2-btn dv2-btn-white"<?php echo $sports_cta_target; ?>>
            <?php echo esc_html($sports_cta_label); ?>
            <span class="dv2-btn-arrow" aria-hidden="true">→</span>
        </a>
    </div>

    <div class="dv2-sport-mosaic dv2-sport-mosaic--image">
        <?php // 528px in the split at full width, full-bleed once it stacks at 1024px. ?>
        <?php
        // The original upload had no intermediate sizes, so this was a bare
        // <img> with a sizes attribute and nothing for it to describe - every
        // viewport pulled the full 1024x1536 file. Re-uploaded through the media
        // library so WordPress generated the 683w and 768w copies, and rendered
        // through the attachment so it builds the srcset itself.
        echo iptv_responsive_image(
            'https://ibostreaming.com/wp-content/uploads/2026/08/live-sports-responsive.webp',
            iptv_text('sports_image_alt', 'Live sport available on iBostreaming'),
            'large',
            '(max-width: 1024px) calc(100vw - 152px), (max-width: 1280px) calc((100vw - 224px) / 2), 528px',
            array('loading' => 'lazy')
        );
        ?>
    </div>
</section>

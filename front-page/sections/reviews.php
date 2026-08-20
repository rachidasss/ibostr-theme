<?php
/**
 * Section: Reviews (Design v2)
 * Score card plus a grid of customer reviews.
 */

$title    = iptv_text('reviews_title', 'Trusted by 10,000+ Viewers');
$subtitle = iptv_text('reviews_subtitle', 'Real feedback from viewers who switched to iBostreaming.');

// Reviews come from the `reviews_list` repeater on the front page, so they are
// translated per language alongside the rest of the page copy. Title and date are
// optional; a row without text and author is skipped.
$reviews = [];
$review_rows = function_exists('get_field') ? get_field('reviews_list', get_option('page_on_front')) : null;

if (is_array($review_rows)) {
    foreach ($review_rows as $row) {
        $text   = $row['review_text']   ?? '';
        $author = $row['review_author'] ?? '';

        if ($text && $author) {
            $reviews[] = [
                'text'   => $text,
                'author' => $author,
                'title'  => $row['review_title'] ?? '',
                'when'   => $row['review_when'] ?? '',
            ];
        }
    }
}

if (empty($reviews)) {
    // These are the six reviews the live ibostreaming.com homepage already
    // publishes, copied verbatim on 2026-08-19 so this template shows exactly
    // what the Elementor homepage it replaces showed. They are NOT the theme's
    // original bundled set — that was a different, invented list carried over
    // from the iBostreaming build and it must not come back.
    $reviews = [
        ['title' => 'Stellar Stability and Quality', 'when' => '1 week ago', 'author' => 'Johan S. · Stockholm, Sweden', 'text' => 'iBo Streaming stands out for its rock-solid live football stability. I have experienced zero interruptions, making my viewing experience thoroughly enjoyable. Top service!'],
        ['title' => 'Reliability Redefined', 'when' => '3 days ago', 'author' => 'Mikkel B. · Copenhagen, Denmark', 'text' => 'With iBo Streaming, I\'ve found the reliability I\'ve been searching for in an IPTV service. The 4K streams are stable and crisp on my LG OLED, making it a true pleasure to use.'],
        ['title' => 'Incredible Variety, Fantastic Value!', 'when' => '2 weeks ago', 'author' => 'Emil T. · Oslo, Norway', 'text' => 'Absolutely delighted with iBo Streaming! The sheer number of live channels and VOD options is mind-blowing, and all at such an affordable price. Best deal online.'],
        ['title' => 'Outstanding Selection, Unbeatable Support', 'when' => '5 days ago', 'author' => 'Sari W. · Helsinki, Finland', 'text' => 'I\'m amazed at how fast setup was on my Firestick. Reached support and got a friendly human response in under 5 minutes. The selection of channels and VOD is top-notch, far exceeding expectations!'],
        ['title' => 'Value for Money', 'when' => '2 days ago', 'author' => 'Lars K. · Gothenburg, Sweden', 'text' => 'iBo Streaming is a game-changer! It offers a fantastic array of 4K sports channels and movies at prices that do not break the bank. Highly satisfied with my subscription.'],
        ['title' => 'Best IPTV Service', 'when' => 'Yesterday', 'author' => 'Astrid M. · Bergen, Norway', 'text' => 'Switched from a competitor that kept freezing during big match nights. iBo Streaming has been 100% stable with anti-freeze tech working flawlessly across my TVs.'],
    ];
}

/**
 * Score summary shown above the reviews: one headline score, then a breakdown
 * bar per category. Values are iptv_text keys so they stay editable per
 * language rather than being frozen into the template.
 */
$score_overall = iptv_text('reviews_score', '4.8');
$score_label   = iptv_text('reviews_score_label', 'Our review score');

$score_bars = [
    1 => [iptv_text('reviews_bar_1_label', 'Library'), iptv_text('reviews_bar_1_value', '4.9')],
    2 => [iptv_text('reviews_bar_2_label', 'Stability'), iptv_text('reviews_bar_2_value', '4.7')],
    3 => [iptv_text('reviews_bar_3_label', 'Device support'), iptv_text('reviews_bar_3_value', '4.9')],
    4 => [iptv_text('reviews_bar_4_label', 'Value'), iptv_text('reviews_bar_4_value', '4.8')],
];

/**
 * Renders one review card.
 */
$render_review = function ($review) {
    ?>
    <div class="dv2-review-card">
        <div class="dv2-review-top">
            <span class="dv2-review-stars" aria-hidden="true">★★★★★</span>
            <?php if (!empty($review['when'])) : ?>
                <span class="dv2-review-when"><?php echo esc_html($review['when']); ?></span>
            <?php endif; ?>
        </div>
        <?php if (!empty($review['title'])) : ?>
            <div class="dv2-review-title"><?php echo esc_html($review['title']); ?></div>
        <?php endif; ?>
        <p class="dv2-review-body"><?php echo esc_html($review['text']); ?></p>
        <div class="dv2-review-name"><?php echo esc_html($review['author']); ?></div>
    </div>
    <?php
};
?>
<section class="reviews dv2-section">
    <div class="container">
        <div class="dv2-section-head">
            <h2><?php echo esc_html($title); ?></h2>
            <p><?php echo esc_html($subtitle); ?></p>
        </div>

        <div class="dv2-review-summary">
            <div class="dv2-review-score">
                <span class="dv2-review-score-value"><?php echo esc_html($score_overall); ?></span>
                <span class="dv2-review-score-meta">
                    <span class="dv2-review-score-stars" aria-hidden="true">★★★★★</span>
                    <span class="dv2-review-score-label"><?php echo esc_html($score_label); ?></span>
                </span>
            </div>

            <div class="dv2-review-bars">
                <?php foreach ($score_bars as $bar) : ?>
                    <?php
                    // Bars are scored out of 5. Clamped so a bad value cannot
                    // render a bar wider than its track.
                    $pct = max(0, min(100, ((float) str_replace(',', '.', $bar[1]) / 5) * 100));
                    ?>
                    <div class="dv2-review-bar">
                        <div class="dv2-review-bar-head">
                            <span><?php echo esc_html($bar[0]); ?></span>
                            <strong><?php echo esc_html($bar[1]); ?></strong>
                        </div>
                        <div class="dv2-review-bar-track">
                            <span class="dv2-review-bar-fill" style="width:<?php echo esc_attr(round($pct, 1)); ?>%"></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php
    // A single scroll-snapped row, advanced by the arrows only — no autoplay.
    // data-review-carousel is what front-page/js/reviews.js binds to.
    ?>
    <div class="dv2-review-carousel" data-review-carousel>
        <button type="button" class="dv2-review-nav dv2-review-nav--prev" data-review-prev
                aria-label="<?php echo esc_attr(iptv_text('reviews_prev', 'Previous reviews')); ?>">
            <span aria-hidden="true">‹</span>
        </button>

        <div class="dv2-review-viewport" data-review-viewport>
            <div class="dv2-review-track">
                <?php foreach ($reviews as $review) {
                    $render_review($review);
                } ?>
            </div>
        </div>

        <button type="button" class="dv2-review-nav dv2-review-nav--next" data-review-next
                aria-label="<?php echo esc_attr(iptv_text('reviews_next', 'More reviews')); ?>">
            <span aria-hidden="true">›</span>
        </button>
    </div>
</section>

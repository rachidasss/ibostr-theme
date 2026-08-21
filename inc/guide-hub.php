<?php
/**
 * Device guide hub on /guide/.
 *
 * The page renders eight device panels through the [ibo_guide] shortcode and
 * hides seven of them behind tabs - 1,238 of its 2,049 words. The content is in
 * the HTML so Google indexes it, but a tab panel is a weaker relevance signal
 * than visible copy, and it leaves the page with no single clear subject.
 *
 * Unhiding the panels is the wrong fix. We already own full articles for most of
 * these devices, and duplicating their content into a tab would put two of our
 * own pages in front of Google for the same query. So this renders a visible
 * index instead: one row per device, with descriptive anchor text pointing at
 * the article that covers it.
 *
 * That does three things a tab cannot. It gives /guide/ a visible, crawlable
 * path to seven articles that currently sit on almost no internal links; it
 * makes /guide/ a hub and those articles its spokes, which is the shape Google
 * reads as topical authority; and it gives a reader on the wrong tab somewhere
 * to go.
 *
 * Styles are inlined for the same reason as inc/shop-plans.php: the compiled
 * Tailwind bundle only contains classes the original design used, so a new class
 * would render unstyled.
 *
 * @package iBostreaming
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('iptv_guide_hub_rows')) {
    /**
     * The devices, in the order the tabs present them.
     *
     * `url` is the article that covers this device in full. Devices with no
     * article of their own point at the on-page panel, so every row still leads
     * somewhere rather than being a dead label.
     *
     * @return array<int,array<string,string>>
     */
    function iptv_guide_hub_rows()
    {
        return array(
            array(
                'device' => 'Amazon Fire TV Stick',
                'anchor' => 'How to set up IPTV on a Firestick',
                'blurb'  => 'Downloader, the IBO Player Pro install and your first playlist.',
                'url'    => home_url('/setup-iptv-on-firestick-complete-guide/'),
            ),
            array(
                'device' => 'Samsung &amp; LG Smart TV',
                'anchor' => 'IBO Player Pro setup for Samsung and LG',
                'blurb'  => 'Installing from the TV store and pairing the device with your line.',
                'url'    => home_url('/ibo-player-instructions/'),
            ),
            array(
                'device' => 'Roku',
                'anchor' => 'How to install IPTV on Roku',
                'blurb'  => 'What Roku allows, and the route that actually works on it.',
                'url'    => home_url('/how-to-install-iptv-on-roku-beginners-guide-2025/'),
            ),
            array(
                'device' => 'Android Phone &amp; Tablet, iPhone &amp; iPad',
                'anchor' => 'Best IPTV apps for Android and iOS',
                'blurb'  => 'Which mobile players are worth installing, and how they differ.',
                'url'    => home_url('/iptv-apps-best-mobile-streaming-android-ios/'),
            ),
            array(
                'device' => 'Android TV &amp; Google TV boxes',
                'anchor' => 'Fixing Android 14 TV box problems',
                'blurb'  => 'AV1 playback, storage limits and frame-rate issues on newer boxes.',
                'url'    => home_url('/android-14-tv-box-problems-av1-storage-frame-rate-fix/'),
            ),
            array(
                'device' => 'Choosing a device',
                'anchor' => 'Best IPTV boxes compared',
                'blurb'  => 'Five streaming devices ranked, and what separates them in practice.',
                'url'    => home_url('/best-iptv-boxes-2025-top-5-iptv-streaming-devices/'),
            ),
            array(
                'device' => 'MAG, Formuler, Windows &amp; Mac',
                'anchor' => 'Setup steps for MAG, Formuler and desktop',
                'blurb'  => 'Covered in the panels above - open the tab for your device.',
                'url'    => '',
            ),
        );
    }
}

if (!function_exists('iptv_guide_hub_html')) {
    /**
     * The hub markup.
     *
     * @return string
     */
    function iptv_guide_hub_html()
    {
        $rows = iptv_guide_hub_rows();

        ob_start();
        ?>
        <section class="ibo-guide-hub" aria-labelledby="device-guides">
            <h2 id="device-guides"><?php esc_html_e('Full setup guide for your device', 'iptv'); ?></h2>
            <p class="ibo-guide-hub__intro"><?php
                esc_html_e('The steps above cover every device in short form. Where we have written the guide out in full, the link takes you straight to it.', 'iptv');
            ?></p>

            <ul class="ibo-guide-hub__list">
                <?php foreach ($rows as $row) : ?>
                    <li class="ibo-guide-hub__item">
                        <span class="ibo-guide-hub__device"><?php echo wp_kses_post($row['device']); ?></span>
                        <?php if ($row['url'] !== '') : ?>
                            <a class="ibo-guide-hub__link" href="<?php echo esc_url($row['url']); ?>">
                                <?php echo esc_html($row['anchor']); ?>
                            </a>
                        <?php else : ?>
                            <span class="ibo-guide-hub__link ibo-guide-hub__link--plain"><?php echo esc_html($row['anchor']); ?></span>
                        <?php endif; ?>
                        <span class="ibo-guide-hub__blurb"><?php echo esc_html($row['blurb']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>

            <p class="ibo-guide-hub__foot"><?php
                printf(
                    /* translators: 1: link to the blog, 2: link to the plans page */
                    wp_kses(
                        __('More walkthroughs live on the <a href="%1$s">IPTV blog</a>. If you have not picked a plan yet, all sixteen are listed on the <a href="%2$s">subscription page</a>.', 'iptv'),
                        array('a' => array('href' => array()))
                    ),
                    esc_url(home_url('/iptv-blog/')),
                    esc_url(home_url('/shop/'))
                );
            ?></p>
        </section>
        <?php

        return (string) ob_get_clean();
    }
}

/**
 * Append the hub to /guide/.
 */
add_filter('the_content', function ($content) {
    if (is_admin() || !is_singular('page') || !in_the_loop() || !is_main_query()) {
        return $content;
    }

    $post = get_post();

    if (!$post || $post->post_name !== 'guide') {
        return $content;
    }

    if (strpos($content, 'ibo-guide-hub') !== false) {
        return $content;
    }

    return $content . iptv_guide_hub_html();
});

/**
 * Styles. Inlined - under a kilobyte, and it renders on one page.
 */
add_action('wp_head', function () {
    if (!is_page()) {
        return;
    }

    $post = get_post();

    if (!$post || $post->post_name !== 'guide') {
        return;
    }
    ?>
    <style id="ibo-guide-hub-css">
    .ibo-guide-hub{margin:3rem 0 0;padding-top:2rem;border-top:1px solid rgba(15,23,42,.12)}
    .ibo-guide-hub h2{margin:0 0 .6rem;font-size:1.5rem;line-height:1.25}
    .ibo-guide-hub__intro{margin:0 0 1.4rem;color:#475569;max-width:62ch}
    .ibo-guide-hub__list{list-style:none;margin:0;padding:0;display:grid;gap:.55rem}
    .ibo-guide-hub__item{display:grid;gap:.15rem;padding:.85rem 1rem;border:1px solid rgba(15,23,42,.1);border-radius:.6rem;background:#fff}
    .ibo-guide-hub__device{font-size:.78rem;text-transform:uppercase;letter-spacing:.06em;color:#64748b;font-weight:600}
    .ibo-guide-hub__link{font-size:1.02rem;font-weight:700;color:#007CEB;text-decoration:none}
    .ibo-guide-hub__link:hover,.ibo-guide-hub__link:focus{text-decoration:underline}
    .ibo-guide-hub__link--plain{color:#0f172a}
    .ibo-guide-hub__blurb{font-size:.9rem;color:#475569}
    .ibo-guide-hub__foot{margin:1.3rem 0 0;font-size:.92rem;color:#475569}
    .ibo-guide-hub__foot a{color:#007CEB}
    </style>
    <?php
}, 20);

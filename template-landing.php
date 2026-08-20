<?php
/**
 * Template Name: Landing Page (ACF)
 *
 * The site's real landing-page design, rebuilt as server-rendered PHP.
 *
 * Where this came from: the homepage was a React bundle prerendered into an
 * Elementor HTML widget. Every heading, price and review existed only inside
 * that bundle, so nothing on the page could be edited without opening Elementor,
 * and the markup arrived as one opaque blob. This template renders the same
 * design from front-page/sections-v2/, with the copy in ACF fields.
 *
 * Design fidelity is the whole point. The sections carry the landing page's own
 * Tailwind class strings verbatim, so the compiled bundle in
 * front-page/css/landing.css is what styles them. That bundle is the design -
 * do not "tidy" the class attributes in the sections.
 *
 * This is deliberately NOT front-page.php. The two are different designs, and
 * the front page stays on whatever it is until this one is signed off.
 *
 * @package iBostreaming
 */

get_header();

$iptv_landing_dir = get_template_directory() . '/front-page/sections-v2';

// Order follows the live landing page top to bottom.
$iptv_landing_sections = array(
    'hero',
    'showcase',   // channels / movies / sports carousel
    'trust',      // "Tired of IPTV providers who take your money & disappear?"
    'features',   // One Subscription. Every Channel Worldwide.
    'pricing',    // plan configurator
    'steps',      // Start Streaming in 3 Simple Steps
    'devices',    // Works on Any Device, Anywhere.
    'reviews',    // Trusted by 10,000+ Viewers
    'faq',
    'guarantee',  // Guaranteed 0% Buffering During Big Matches
    'contact',    // Need Instant Help?
);

/**
 * Render one section file.
 *
 * include, not require: a missing section should cost that band, not the page.
 */
$iptv_landing_render = function ($slug) use ($iptv_landing_dir) {
    $path = $iptv_landing_dir . '/' . $slug . '.php';

    if (file_exists($path)) {
        include $path;
    }
};

$iptv_landing_render('header');
?>

<main id="content">
    <?php
    foreach ($iptv_landing_sections as $iptv_landing_section) {
        $iptv_landing_render($iptv_landing_section);
    }
    ?>
</main>

<?php
$iptv_landing_render('footer');

get_footer();

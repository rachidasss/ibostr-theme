<?php
/**
 * Template Name: Front Page
 * Description: Modular IPTV Landing Page - Each section is in a separate file
 */
get_header();

// Define file paths
$front_page_dir = get_template_directory() . '/front-page';
$sections_dir = $front_page_dir . '/sections';
?>

<?php
// The thirteen stylesheets that used to be concatenated into a <style> block
// right here are now enqueued in functions.php (iptv_front_page_style_handles).
// Inlining them put 141KB of unminified CSS inside <body> ahead of all content,
// re-sent on every page view because inline CSS is not cacheable and cannot be
// shared with any other page. Enqueued, each gets a filemtime version string
// and an immutable far-future cache.
?>

<?php
// Page-wide backdrop: a fixed, masked grid that sits behind every section.
// Rendered once here rather than inside a section, since it belongs to the page
// rather than to any one band of it. See .dv2-grid-wash in design-v2.css.
?>
<div class="dv2-grid-wash" aria-hidden="true"></div>

<?php
// Load all sections in order
// Order follows the "iBostreaming Blue & White" design.
// Split into three groups so the <main> landmark can wrap the page's actual
// content without swallowing the banner and contentinfo landmarks. <main> must
// not contain <header> or <footer>.
$sections_before = array(
    'header',           // Front-page header (source of truth for all headers)
);

$sections = array(
    'hero',             // Backdrop hero with Trustpilot badge
    'content-showcase', // Channels panel + VOD panel
    'sports',           // Sports panel with mosaic
    'comparison',       // "Other IPTV sellers" vs us - re-enabled 2026-08-20
    'cta-bar',          // Full-width savings bar
    // Features sits directly above pricing and closes on a CTA into it, so the
    // capability pitch lands immediately before the plan configurator.
    'features',         // Eight capability cards
    'pricing',          // Device/duration configurator (WooCommerce)
    'steps',            // Onboarding panel - sits directly under pricing
    'unlock',           // Supported device chips
    'reviews',          // Score card + two-row review marquee
    'faq',              // Accordion
    'dark-cta',         // Zero-buffering guarantee band - re-enabled 2026-08-20
    'contact',          // Support cards
    // Not in this list (files and styles still exist - add the slug back to
    // render them again):
    //   'brands'      - logo strip; no ACF fields behind it
    //   'dashboard'   - Member area promo
    //   'xlinks'      - "Good to know". See the note below.
);

$sections_after = array(
    'footer'
);

// 'comparison' and 'dark-cta' were commented out of this list while the page it
// replaces still rendered both bands ("TIRED OF IPTV PROVIDERS WHO TAKE YOUR
// MONEY & DISAPPEAR?" and "Guaranteed 0% Buffering During Big Matches"). Both
// section files and their ACF fields already existed - 35 comp_* fields and 7
// cta_* fields - so this is a re-enable, not new work.
//
// 'xlinks' — the "Good to know" block — is built (front-page/sections/xlinks.php)
// but deliberately NOT in the list above.
//
// It was written on the assumption that the mu-plugin injecting that block fired
// only on the Elementor landing pages and would stop once this template took
// over. It does not: it gates on the page ID, so after the switch it still runs
// and the page rendered "Good to know" twice — once from the theme inside <main>,
// once from the plugin after the footer.
//
// The plugin's copy cannot be removed from here, so the theme's is the one that
// gives way. Re-add 'xlinks' the moment that mu-plugin is gone, or on any page
// where it does not fire: the section is better placed than the plugin's, which
// sits outside <main>, and those three links into /shop/, /guide/ and /contact/
// are the front page's only contextual internal links.
?>

<?php
// Three plain loops rather than one helper: the sections are included, not
// required into a function, so they share this template's variable scope. Moving
// them inside a closure would quietly change that for every section at once.
foreach ($sections_before as $section) {
    $path = $sections_dir . '/' . $section . '.php';
    if (file_exists($path)) {
        include $path;
    }
}
?>

<?php // Every other template in this theme has a <main> landmark; this one did not. ?>
<main id="content">
<?php
foreach ($sections as $section) {
    $path = $sections_dir . '/' . $section . '.php';
    if (file_exists($path)) {
        include $path;
    }
}
?>
</main>
<?php
foreach ($sections_after as $section) {
    $path = $sections_dir . '/' . $section . '.php';
    if (file_exists($path)) {
        include $path;
    }
}

// Activity Ticker (Social Proof)
include $front_page_dir . '/partials/activity-ticker.php';
?>

<?php
// The seven scripts that used to be concatenated into a <script> block here are
// enqueued in the footer instead (iptv_front_page_script_handles in
// functions.php). Concatenated inline, a single top-level error in any one of
// them silently killed every script after it, and none of it was cacheable.
//
// The inline window.iptvPrices block printed by the pricing section still runs
// before them, which is the ordering pricing.js needs.
?>

<?php get_footer(); ?>
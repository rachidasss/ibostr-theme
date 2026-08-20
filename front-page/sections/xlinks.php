<?php
/**
 * Section: "Good to know" — contextual internal links
 *
 * Replaces the <section class="ibo-xlinks"> block that a mu-plugin injects into
 * the Elementor landing pages. That hook only fires on those pages (verified:
 * present on / and /fr/, absent on /about/, /shop/ and every theme-rendered
 * page), so the block disappears the moment this template renders the front
 * page — taking with it the homepage's only contextual links into /shop/,
 * /guide/ and /contact/.
 *
 * Those three links are the reason this section exists. Money and support pages
 * are otherwise reachable from the front page only through the footer, and a
 * link inside the content body carries more weight than a footer link.
 *
 * Every string and every row is an ACF field on the front page, read through
 * iptv_text() / get_field() like the rest of the template, so the block is
 * editable in wp-admin and translatable per language. The defaults below are the
 * copy the mu-plugin currently outputs, verbatim.
 *
 * @package iBostreaming
 */

if (!defined('ABSPATH')) {
    exit;
}

$xlinks_title    = iptv_text('xlinks_title', 'Good to know');
$xlinks_subtitle = iptv_text('xlinks_subtitle', 'Three things worth reading before you decide:');

// Rows come from the `xlinks_items` repeater on the front page. Each row is a
// label plus either a page slug (resolved per language) or an explicit URL.
$xlinks_items = array();
$xlinks_rows  = function_exists('get_field')
    ? get_field('xlinks_items', get_option('page_on_front'))
    : null;

if (is_array($xlinks_rows)) {
    foreach ($xlinks_rows as $row) {
        $label = isset($row['label']) ? trim((string) $row['label']) : '';
        $slug  = isset($row['slug']) ? trim((string) $row['slug']) : '';
        $url   = isset($row['url']) ? trim((string) $row['url']) : '';

        if ($label === '') {
            continue;
        }

        // A slug is resolved against the real page so the link follows the page
        // if it is ever renamed; an explicit URL wins when one is given.
        if ($url === '' && $slug !== '' && function_exists('iptv_page_url')) {
            $url = iptv_page_url($slug);
        }

        if ($url === '') {
            continue;
        }

        $xlinks_items[] = array('label' => $label, 'url' => $url);
    }
}

if (empty($xlinks_items)) {
    // Same three links, same anchor text, as the block this replaces.
    // pll_home_url() rather than home_url() so a translated front page links to
    // that language's pages — the mistake this theme's footer used to make.
    $xlinks_home = function_exists('pll_home_url') ? pll_home_url() : home_url('/');

    $xlinks_defaults = array(
        array('slug' => 'shop',    'path' => 'shop/',    'label' => 'All IPTV subscription plans and prices'),
        array('slug' => 'guide',   'path' => 'guide/',   'label' => 'Setup guide for Smart TV, Firestick and Android'),
        array('slug' => 'contact', 'path' => 'contact/', 'label' => 'Contact our support team, available 24/7'),
    );

    foreach ($xlinks_defaults as $row) {
        $fallback = trailingslashit($xlinks_home) . $row['path'];
        $url      = function_exists('iptv_page_url')
            ? iptv_page_url($row['slug'], $fallback)
            : $fallback;

        $xlinks_items[] = array('label' => $row['label'], 'url' => $url);
    }
}

if (empty($xlinks_items)) {
    return;
}
?>
<section class="ibo-xlinks dv2-section" aria-labelledby="ibo-xlinks-title">
    <div class="container">
        <h2 id="ibo-xlinks-title" class="ibo-xlinks-title"><?php echo esc_html($xlinks_title); ?></h2>

        <?php if ($xlinks_subtitle !== '') : ?>
            <p class="ibo-xlinks-sub"><?php echo esc_html($xlinks_subtitle); ?></p>
        <?php endif; ?>

        <ul class="ibo-xlinks-list">
            <?php foreach ($xlinks_items as $item) : ?>
                <li>
                    <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

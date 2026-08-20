<?php
/**
 * Template Name: Standalone Content (page supplies its own header)
 *
 * As template-standalone.php, but without the site header.
 *
 * /iptv-france/ is hand-built HTML that ships its own navigation - logo, menu
 * and CTA - inside the post content. Giving it the theme header as well would
 * stack two navigation bars on top of each other, and removing the one in the
 * content would mean rewriting 84 KB of the page's stored HTML, which is not
 * worth the risk on a page that ranks.
 *
 * It still gets the site footer, which it never had, and it no longer needs
 * Elementor to render.
 *
 * If that in-content header is ever replaced by the theme's, switch the page to
 * template-standalone.php and delete this file - it exists for exactly one
 * situation.
 *
 * @package iBostreaming
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    // No <title> here on purpose - see the note in page.php. wp_head() is where
    // title-tag support and Rank Math print the real one; adding a second makes
    // the first one win and discards the Rank Math title.
    ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <main id="content">
        <?php
        while (have_posts()) :
            the_post();
            the_content();
        endwhile;
        ?>
    </main>

    <?php include get_template_directory() . '/front-page/sections-v2/footer.php'; ?>

    <?php wp_footer(); ?>
</body>

</html>

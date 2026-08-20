<?php
/**
 * Template Name: Standalone Content
 *
 * Site header and footer around content that is already a finished page.
 *
 * Some pages are hand-built HTML pasted into the editor, complete with their own
 * hero, their own <style> blocks and their own H1. They were rendering through
 * Elementor's header/footer template, which is the only reason Elementor could
 * not be removed from the site.
 *
 * page.php cannot take them: it prints a .page-header block containing
 * <h1><?php the_title(); ?></h1>, so a page that already has an H1 would end up
 * with two - and two H1s on a ranking page is a real problem, not a cosmetic
 * one. This template is page.php without that block.
 *
 * The content is echoed exactly as stored. No wrapper, no container, no max
 * width: these pages lay themselves out and anything wrapped around them fights
 * their own CSS.
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
    // No <title> here on purpose - same reason as page.php. This template builds
    // its own <head> and also calls wp_head(), which is where the title-tag
    // support and Rank Math print the real title. Hardcoding one here produces
    // two <title> tags, and the first one wins, which silently discards every
    // Rank Math title.
    ?>
    <?php wp_head(); ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/front-page/css/variables.css?ver=<?php echo esc_attr(iptv_asset_version('front-page/css/variables.css')); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/front-page/css/redesign-theme.css?ver=<?php echo esc_attr(iptv_asset_version('front-page/css/redesign-theme.css')); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/front-page/css/base.css?ver=<?php echo esc_attr(iptv_asset_version('front-page/css/base.css')); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/front-page/css/header.css?ver=<?php echo esc_attr(iptv_asset_version('front-page/css/header.css')); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/front-page/css/footer.css?ver=<?php echo esc_attr(iptv_asset_version('front-page/css/footer.css')); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/front-page/css/responsive.css?ver=<?php echo esc_attr(iptv_asset_version('front-page/css/responsive.css')); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/front-page/css/design-v2.css?ver=<?php echo esc_attr(iptv_asset_version('front-page/css/design-v2.css')); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/front-page/css/design-v2-sections.css?ver=<?php echo esc_attr(iptv_asset_version('front-page/css/design-v2-sections.css')); ?>">
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <?php include get_template_directory() . '/inc/universal-header.php'; ?>

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

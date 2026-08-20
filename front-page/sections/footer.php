<!-- Footer Section (Design v2) -->
<?php
// Hoisted out of the "Quick Links" column: the Legal column's fallbacks use it
// too, and that column sits in its own has_nav_menu() else-branch. If a menu was
// ever assigned to the footer_1 location, the Quick Links branch would not run,
// $home would be undefined by the time the Legal column read it, and every Legal
// fallback would resolve against an empty string (plus a PHP 8 warning).
// home_url() ignores the current language, hence pll_home_url() first — that is
// what stopped this column sending Swedish visitors to the English blog.
$home = function_exists('pll_home_url') ? pll_home_url() : home_url('/');
?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">
                    <?php
                    // Light (white) logo, matching the header — the footer is dark.
                    // Same responsive set as the header; see the note there.
                    $iptv_footer_logo_dir = get_template_directory_uri() . '/images/logo/';
                    $iptv_footer_logo_2x  = $iptv_footer_logo_dir . 'light-logo-230x69.png';
                    $iptv_footer_logo_3x  = $iptv_footer_logo_dir . rawurlencode('light logo 500_150.png');
                    ?>
                    <img src="<?php echo esc_url($iptv_footer_logo_2x); ?>"
                        srcset="<?php echo esc_url($iptv_footer_logo_2x); ?> 230w, <?php echo esc_url($iptv_footer_logo_3x); ?> 500w"
                        sizes="120px" width="500" height="150" loading="lazy" decoding="async"
                        alt="iBostreaming" class="footer-logo-img">
                </div>
                <p class="footer-desc">
                    <?php echo esc_html(iptv_text('footer_desc', 'The leading IPTV service provider — 40,000+ live channels, 200,000+ movies and series, every sport, in 4K and 8K.')); ?>
                </p>

                <!-- Language selector -->
                <div class="footer-language-selector">
                    <div class="footer-country-selector" id="footerCountrySelector">
                        <button class="footer-country-btn" onclick="toggleFooterDropdown()">
                            <span id="footerSelectedFlag">🇺🇸</span>
                            <span id="footerSelectedCode">English</span>
                            <svg width="10" height="10" viewBox="0 0 10 10">
                                <path d="M1 3L5 7L9 3" stroke="currentColor" stroke-width="1.5" fill="none" />
                            </svg>
                        </button>
                        <div class="footer-country-dropdown" id="footerCountryDropdown">
                            <?php
                            // Was six hardcoded <div onclick> entries offering Norsk, Dansk,
                            // Suomi and Islenska - four languages this site does not publish,
                            // whose links went nowhere - and offering none for French, German
                            // or Dutch. Real anchors now, from the same list the header uses,
                            // so the translated home pages are reachable without JavaScript
                            // and Google has a crawlable link to each.
                            $iptv_footer_current = iptv_lp_lang();

                            foreach (iptv_languages() as $iptv_footer_lang) :
                                $iptv_footer_is_current = ($iptv_footer_lang['code'] === $iptv_footer_current);
                                ?>
                                <a class="footer-country-option<?php echo $iptv_footer_is_current ? ' footer-country-option--current' : ''; ?>"
                                   href="<?php echo esc_url(home_url($iptv_footer_lang['path'])); ?>"
                                   hreflang="<?php echo esc_attr($iptv_footer_lang['code']); ?>"
                                   lang="<?php echo esc_attr($iptv_footer_lang['code']); ?>"
                                   data-currency="<?php echo esc_attr($iptv_footer_lang['currency']); ?>"
                                   <?php echo $iptv_footer_is_current ? ' aria-current="true"' : ''; ?>><?php
                                    echo esc_html($iptv_footer_lang['flag'] . ' ' . $iptv_footer_lang['name']);
                                ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            // Get all menu locations
            $locations = get_nav_menu_locations();

            // Helper to get menu name safely
            if (!function_exists('iptv_get_menu_title')) {
                function iptv_get_menu_title($loc, $default)
                {
                    global $locations;
                    if (isset($locations[$loc])) {
                        $menu = wp_get_nav_menu_object($locations[$loc]);
                        if ($menu)
                            return $menu->name;
                    }
                    return $default;
                }
            }
            ?>

            <div class="footer-col">
                <h4><?php echo esc_html(iptv_get_menu_title('footer_1', iptv_text('footer_head_plans', 'Plans'))); ?></h4>
                <?php if (has_nav_menu('footer_1')): ?>
                    <?php wp_nav_menu(array(
                        'theme_location' => 'footer_1',
                        'container' => false,
                        'fallback_cb' => false,
                    )); ?>
                <?php else: ?>
                    <?php
                    // These were four hardcoded "#pricing" anchors with English
                    // labels, so every language showed "1 Month Plan" and every
                    // one of them jumped to a section that only exists on the
                    // front page — on any other page the link did nothing.
                    //
                    // iptv_plan_url() resolves the plan page for the *current*
                    // language and iptv_plan_label() its duration in that
                    // language. Both are already used by the plan templates, so
                    // the footer cannot drift from them. iptv_plan_url() caches
                    // per months|lang, so this is four queries on a cache miss
                    // and none on a LiteSpeed hit.
                    $footer_home = function_exists('pll_home_url') ? pll_home_url() : home_url('/');
                    ?>
                    <div>
                        <?php foreach (array(1, 3, 6, 12) as $footer_plan_months) : ?>
                            <?php
                            $footer_plan_url = function_exists('iptv_plan_url')
                                ? iptv_plan_url($footer_plan_months)
                                : '';

                            // No plan page published for this length yet: keep a
                            // usable link rather than a dead one.
                            if (!$footer_plan_url) {
                                $footer_plan_url = trailingslashit($footer_home) . '#pricing';
                            }

                            $footer_plan_label = function_exists('iptv_plan_label')
                                ? iptv_plan_label($footer_plan_months)
                                : '';
                            if (!$footer_plan_label) {
                                continue;
                            }
                            ?>
                            <a href="<?php echo esc_url($footer_plan_url); ?>"><?php echo esc_html($footer_plan_label); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="footer-col">
                <h4><?php echo esc_html(iptv_get_menu_title('footer_2', iptv_text('footer_head_links', 'Useful Links'))); ?></h4>
                <?php if (has_nav_menu('footer_2')): ?>
                    <?php wp_nav_menu(array(
                        'theme_location' => 'footer_2',
                        'container' => false,
                        'fallback_cb' => false,
                    )); ?>
                <?php else: ?>
                    <?php
                    // $home is defined at the top of this file — see the note there.
                    // Slugs corrected 2026-08-20 against the pages that actually
                    // exist. Every one of these was stale: iptv_page_url() finds
                    // no page, so the entry either fell back to a wrong URL or
                    // was dropped from the column entirely (see the skip in
                    // inc/page-links.php). Symptoms in the live footer were
                    // "Setup Guide" linking to the homepage and M3U Converter /
                    // Contact Us simply not rendering.
                    //   blog -> iptv-blog (the /blog/ fallback 301-redirected)
                    //   iptv-guide-setup-apps-devices-tips -> guide
                    //   contact-us -> contact
                    // The M3U converter is a POST, not a page, so it cannot be
                    // resolved by page slug — it is linked by URL like My Account.
                    iptv_footer_links(array(
                        array('slug' => 'iptv-blog', 'key' => 'footer_link_blog', 'label' => 'Blog',
                              'fallback' => trailingslashit($home) . 'iptv-blog/'),
                        array('slug' => 'guide', 'key' => 'footer_link_guide', 'label' => 'Setup Guide',
                              'fallback' => trailingslashit($home) . 'guide/'),
                        array('slug' => 'help-center', 'key' => 'footer_link_help', 'label' => 'Help Center',
                              'fallback' => trailingslashit($home) . 'help-center/'),
                        array('url' => trailingslashit($home) . 'free-m3u-to-xtream-codes-converter-2025/',
                              'key' => 'footer_link_m3u', 'label' => 'M3U Converter'),
                        array('slug' => 'contact', 'key' => 'footer_link_contact', 'label' => 'Contact Us',
                              'fallback' => trailingslashit($home) . 'contact/'),
                        array('url' => 'https://panel.ibostreaming.com/login', 'key' => 'footer_link_account', 'label' => 'My Account'),
                    ));
                    ?>
                <?php endif; ?>
            </div>

            <div class="footer-col">
                <h4><?php echo esc_html(iptv_get_menu_title('footer_3', iptv_text('footer_head_legal', 'Legal'))); ?></h4>
                <?php if (has_nav_menu('footer_3')): ?>
                    <?php wp_nav_menu(array(
                        'theme_location' => 'footer_3',
                        'container' => false,
                        'fallback_cb' => false,
                    )); ?>
                <?php else: ?>
                    <?php
                    // These four all existed as pages while this column pointed
                    // every one of them at '#'. Slugs corrected again 2026-08-20:
                    // three of the four were still wrong (about-us,
                    // terms-of-services, return-refund-policy), so the whole
                    // Legal column rendered as a single Privacy Policy link.
                    iptv_footer_links(array(
                        array('slug' => 'about', 'key' => 'footer_link_about', 'label' => 'About Us',
                              'fallback' => trailingslashit($home) . 'about/'),
                        array('slug' => 'privacy-policy', 'key' => 'footer_link_privacy', 'label' => 'Privacy Policy',
                              'fallback' => trailingslashit($home) . 'privacy-policy/'),
                        array('slug' => 'terms-of-service', 'key' => 'footer_link_terms', 'label' => 'Terms of Service',
                              'fallback' => trailingslashit($home) . 'terms-of-service/'),
                        array('slug' => 'refund-returns', 'key' => 'footer_link_refund', 'label' => 'Refund & Returns Policy',
                              'fallback' => trailingslashit($home) . 'refund-returns/'),
                    ));
                    ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="footer-bottom">
            iBostreaming | <?php echo esc_html(iptv_text('footer_copyright', 'All Rights Reserved')); ?>
            <?php echo date('Y'); ?>
        </div>
    </div>
</footer>

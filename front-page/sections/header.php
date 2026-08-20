<!-- Header Section -->
<?php
// Current-language detection lives in $iptv_languages below, which is keyed on
// the URL path. The block that used to sit here detected a *subsite* slug and
// mapped it through a fixed sv/no/dk/fi/is language table to set the
// switcher label. Both of its outputs, $default_flag and $default_name, were
// then overwritten unconditionally further down, and none of those five
// languages exists on this site - so it was dead code naming the wrong
// languages. Removed 2026-08-20.

// Polylang filters home_url() only when the path is empty or '/'. Anything with
// a path or fragment — home_url('/#features') — comes back as the English URL,
// which is why every anchor link in this nav pointed at the English front page
// from /no/, /sv/ and the rest while the labels were correctly translated.
$nav_home = function_exists('pll_home_url') ? pll_home_url() : home_url('/');
$nav_home = trailingslashit($nav_home);

// The guide's real slug. home_url('/user-guide/') was a 404 in every language,
// and 'iptv-guide-setup-apps-devices-tips' no longer matches any page either —
// it silently fell back to $nav_home, so "User Guide" linked to the homepage.
// The page lives at /guide/.
$nav_guide = function_exists('iptv_page_url')
    ? iptv_page_url('guide', trailingslashit($nav_home) . 'guide/')
    : trailingslashit($nav_home) . 'guide/';

// The five languages this site publishes, rendered as real <a href> below so
// each translated home page is reachable without JavaScript. The list and the
// reasoning live in iptv_languages(), which the footer switcher shares.
$iptv_languages = iptv_languages();

// Which one we are on, so the current language can be marked and the button
// label can show it. Longest path first so '/' does not match everything.
$iptv_current_lang = $iptv_languages[0];
$iptv_request_path = isset($_SERVER['REQUEST_URI'])
    ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
    : '/';

foreach ($iptv_languages as $iptv_lang) {
    if ($iptv_lang['path'] !== '/' && strpos((string) $iptv_request_path, $iptv_lang['path']) === 0) {
        $iptv_current_lang = $iptv_lang;
        break;
    }
}

$default_flag = $iptv_current_lang['flag'];
$default_name = $iptv_current_lang['name'];
?>
<header class="site-header" id="site-header">
    <div class="container nav-container">
        <a href="<?php echo esc_url($nav_home); ?>" class="logo">
            <?php
            // Light (white) logo: the bar is dark on every page.
            //
            // The lockup renders 34px tall, so ~113px wide. The 500px original
            // was the only file, which meant every visitor downloaded four
            // times the pixels they could see; the 230px copy covers 1x and 2x
            // and the original stays in the set for 3x screens. The original's
            // name contains spaces, so it has to be encoded — srcset splits on
            // whitespace and would otherwise read it as several candidates.
            $iptv_logo_dir = get_template_directory_uri() . '/images/logo/';
            $iptv_logo_2x  = $iptv_logo_dir . 'light-logo-230x69.png';
            $iptv_logo_3x  = $iptv_logo_dir . rawurlencode('light logo 500_150.png');
            ?>
            <img src="<?php echo esc_url($iptv_logo_2x); ?>"
                srcset="<?php echo esc_url($iptv_logo_2x); ?> 230w, <?php echo esc_url($iptv_logo_3x); ?> 500w"
                sizes="115px" width="500" height="150" alt="iBostreaming"
                class="logo-img" fetchpriority="high">
        </a>
        <?php if (has_nav_menu('primary')): ?>
            <?php wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => 'nav',
                'container_class' => 'nav-links',
                'menu_class' => '',
                'fallback_cb' => false,
            )); ?>
        <?php else: ?>
            <nav class="nav-links">
                <a href="<?php echo esc_url($nav_home); ?>"><?php echo esc_html(iptv_text('nav_link_home', 'Home')); ?></a>
                <a href="<?php echo esc_url($nav_home . '#features'); ?>"><?php echo esc_html(iptv_text('nav_link_features', 'Features')); ?></a>
                <a href="<?php echo esc_url($nav_home . '#pricing'); ?>"><?php echo esc_html(iptv_text('nav_link_pricing', 'Pricing')); ?></a>
                <!-- Blog lives in the footer only. -->
                <a href="<?php echo esc_url($nav_guide); ?>"><?php echo esc_html(iptv_text('nav_link_guide', 'User Guide')); ?></a>
                <a href="<?php echo esc_url($nav_home . '#contact'); ?>"><?php echo esc_html(iptv_text('nav_link_contact', 'Contact')); ?></a>
                <a href="https://panel.ibostreaming.com/login"><?php echo esc_html(iptv_text('nav_link_account', 'My Account')); ?></a>
            </nav>
        <?php endif; ?>
        <div class="nav-right">
            <div class="country-selector" id="countrySelector">
                <button class="country-btn" onclick="toggleCountryDropdown()">
                    <span class="country-flag" id="selectedFlag"><?php echo $default_flag; ?></span>
                    <span class="country-code" id="selectedCode"><?php echo $default_name; ?></span>
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="currentColor">
                        <path d="M1 3L5 7L9 3" stroke="currentColor" stroke-width="1.5" fill="none" />
                    </svg>
                </button>
                <div class="country-dropdown" id="countryDropdown">
                    <?php
                    // Real anchors, not divs: this is the site's only crawlable
                    // path from any page to the four translated home pages.
                    $iptv_symbols = array('usd' => '$', 'eur' => '€', 'sek' => 'kr');
                    foreach ($iptv_languages as $iptv_lang) :
                        $iptv_is_current = ($iptv_lang['code'] === $iptv_current_lang['code']);
                        $iptv_symbol     = isset($iptv_symbols[$iptv_lang['currency']]) ? $iptv_symbols[$iptv_lang['currency']] : '$';
                        ?>
                        <a class="country-option<?php echo $iptv_is_current ? ' country-option--current' : ''; ?>"
                           href="<?php echo esc_url(home_url($iptv_lang['path'])); ?>"
                           hreflang="<?php echo esc_attr($iptv_lang['code']); ?>"
                           lang="<?php echo esc_attr($iptv_lang['code']); ?>"
                           data-currency="<?php echo esc_attr($iptv_lang['currency']); ?>"
                           data-symbol="<?php echo esc_attr($iptv_symbol); ?>"
                           data-flag="<?php echo esc_attr($iptv_lang['flag']); ?>"
                           <?php echo $iptv_is_current ? ' aria-current="true"' : ''; ?>>
                            <span class="country-flag" aria-hidden="true"><?php echo esc_html($iptv_lang['flag']); ?></span><span><?php echo esc_html($iptv_lang['name']); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <a href="<?php echo esc_url($nav_home . '#pricing'); ?>" class="nav-btn nav-btn-primary"><?php echo esc_html(iptv_text('nav_cta_label', 'Get Access Now')); ?></a>
        </div>
        <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobile-menu">
    <button class="mobile-menu-close" onclick="toggleMobileMenu()">&times;</button>

    <?php if (has_nav_menu('primary')): ?>
        <?php wp_nav_menu(array(
            'theme_location' => 'primary',
            'container' => false,
            'menu_class' => '',
            'fallback_cb' => false,
        )); ?>
    <?php else: ?>
        <a href="<?php echo esc_url($nav_home); ?>"><?php echo esc_html(iptv_text('nav_link_home', 'Home')); ?></a>
        <a href="<?php echo esc_url($nav_home . '#features'); ?>"><?php echo esc_html(iptv_text('nav_link_features', 'Features')); ?></a>
        <a href="<?php echo esc_url($nav_home . '#pricing'); ?>"><?php echo esc_html(iptv_text('nav_link_pricing', 'Pricing')); ?></a>
        <!-- Blog lives in the footer only. -->
        <a href="<?php echo esc_url($nav_guide); ?>"><?php echo esc_html(iptv_text('nav_link_guide', 'User Guide')); ?></a>
        <a href="<?php echo esc_url($nav_home . '#contact'); ?>"><?php echo esc_html(iptv_text('nav_link_contact', 'Contact')); ?></a>
        <a href="https://panel.ibostreaming.com/login"><?php echo esc_html(iptv_text('nav_link_account', 'My Account')); ?></a>
    <?php endif; ?>

    <!-- Language Selector in Mobile Menu -->
    <div class="mobile-language-selector">
        <span class="mobile-language-label"><?php echo esc_html(iptv_text('nav_region_label', 'Language')); ?></span>
        <div class="mobile-language-options">
            <?php
            // Anchors here too. These were <button onclick="redirectToRegion()">,
            // so on mobile the language links did not exist in the HTML either.
            foreach ($iptv_languages as $iptv_lang) :
                $iptv_is_current = ($iptv_lang['code'] === $iptv_current_lang['code']);
                ?>
                <a class="mobile-lang-btn<?php echo $iptv_is_current ? ' mobile-lang-btn--current' : ''; ?>"
                   href="<?php echo esc_url(home_url($iptv_lang['path'])); ?>"
                   hreflang="<?php echo esc_attr($iptv_lang['code']); ?>"
                   lang="<?php echo esc_attr($iptv_lang['code']); ?>"
                   data-currency="<?php echo esc_attr($iptv_lang['currency']); ?>"
                   <?php echo $iptv_is_current ? ' aria-current="true"' : ''; ?>>
                    <span aria-hidden="true"><?php echo esc_html($iptv_lang['flag']); ?></span> <?php echo esc_html($iptv_lang['name']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <a href="<?php echo esc_url($nav_home . '#pricing'); ?>" class="nav-btn nav-btn-primary" style="margin-top:1rem;"
        onclick="toggleMobileMenu()"><?php echo esc_html(iptv_text('nav_cta_label', 'Get Access Now')); ?></a>
</div>
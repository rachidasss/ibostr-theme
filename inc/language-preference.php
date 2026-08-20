<?php
/**
 * Language preference
 *
 * Replaces inc/geo-redirect.php, which picked a visitor's language for them from
 * their IP (WooCommerce geolocation) and their Accept-Language header. Language
 * is now the visitor's own choice and nothing else.
 *
 * The rules:
 *   - Whatever URL you ask for is the language you get. Landing on English keeps
 *     you on English, however your browser is configured and wherever you are.
 *   - Choosing a language in the switcher stores it in the `ibostreaming_lang`
 *     cookie for a year.
 *   - On a later visit, arriving at the *front page* in a language other than
 *     the stored one sends you to the stored one's front page. That is the only
 *     redirect left in the theme.
 *   - Deep links are never redirected, so a shared or bookmarked URL always
 *     opens the page it names.
 *   - Bots are never redirected, so every language stays crawlable under its own
 *     URL and hreflang keeps working.
 *
 * The cookie is deliberately not HttpOnly: the language switcher writes it from
 * JavaScript (see front-page/js/currency.js) as well as through ?set_lang=,
 * which is the no-JavaScript path.
 *
 * @package iBostreaming
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('IPTV_LANG_COOKIE')) {
    define('IPTV_LANG_COOKIE', 'ibostreaming_lang');
}

if (!defined('IPTV_LANG_COOKIE_DAYS')) {
    define('IPTV_LANG_COOKIE_DAYS', 365);
}

/**
 * Active language slugs, straight from Polylang.
 *
 * @return string[]
 */
function iptv_lang_slugs()
{
    static $slugs = null;

    if ($slugs !== null) {
        return $slugs;
    }

    $slugs = array();

    if (function_exists('pll_languages_list')) {
        $list = pll_languages_list(array('fields' => 'slug'));
        if (is_array($list)) {
            $slugs = $list;
        }
    }

    return $slugs;
}

/**
 * Which language each currency in the switcher corresponds to.
 *
 * The switcher is built around currencies, the redirect around Polylang slugs,
 * so the two need reconciling somewhere. Doing it here rather than in JS keeps
 * one source of truth, and lets the pairs be filtered.
 *
 * Entries whose language is not active in Polylang are dropped, so disabling a
 * language in wp-admin is enough to take it out of circulation.
 *
 * @return array<string,string> currency code => language slug
 */
function iptv_lang_by_currency()
{
    // This site publishes English, French, German, Swedish and Dutch. The map
    // used to list no, dk, fi and is - four languages that do not exist here -
    // and because the filter below only drops inactive entries when Polylang is
    // running, all four were shipping to every visitor in the inline script.
    //
    // eur covers French, German and Dutch alike, so it cannot pick a language on
    // its own. It resolves to French to match front-page/js/currency.js; the
    // switcher prefers each anchor's own href, which is language-specific, so
    // this map is only ever the last-resort fallback.
    $map = apply_filters('iptv_lang_by_currency', array(
        'usd' => 'en',
        'eur' => 'fr',
        'sek' => 'sv',
    ));

    $active = iptv_lang_slugs();
    if (empty($active)) {
        return $map;
    }

    return array_filter($map, function ($slug) use ($active) {
        return in_array($slug, $active, true);
    });
}

/**
 * Store a language preference, if it names a language this site actually has.
 *
 * @param string $slug Polylang language slug.
 * @return bool Whether the preference was accepted.
 */
function iptv_remember_language($slug)
{
    $slug   = sanitize_key($slug);
    $active = iptv_lang_slugs();

    if (!$slug || (!empty($active) && !in_array($slug, $active, true))) {
        return false;
    }

    // Reflected into $_COOKIE so the redirect below sees it on this same
    // request, not only on the next one.
    $_COOKIE[IPTV_LANG_COOKIE] = $slug;

    if (!headers_sent()) {
        setcookie(
            IPTV_LANG_COOKIE,
            $slug,
            time() + (IPTV_LANG_COOKIE_DAYS * DAY_IN_SECONDS),
            COOKIEPATH ? COOKIEPATH : '/',
            COOKIE_DOMAIN,
            is_ssl(),
            false // readable by the switcher's JavaScript
        );
    }

    return true;
}

/**
 * The stored preference, or '' if there is none worth acting on.
 *
 * @return string
 */
function iptv_stored_language()
{
    if (empty($_COOKIE[IPTV_LANG_COOKIE])) {
        return '';
    }

    $slug   = sanitize_key(wp_unslash($_COOKIE[IPTV_LANG_COOKIE]));
    $active = iptv_lang_slugs();

    if (!empty($active) && !in_array($slug, $active, true)) {
        return '';
    }

    return $slug;
}

/**
 * ?set_lang=sv — the no-JavaScript way to record a choice.
 */
add_action('init', function () {
    if (empty($_GET['set_lang'])) {
        return;
    }

    iptv_remember_language(wp_unslash($_GET['set_lang']));
});

/**
 * Send a returning visitor to the language they picked last time.
 *
 * Front page only, and only when the stored language differs from the one being
 * viewed.
 */
add_action('template_redirect', function () {
    if (is_admin() || wp_doing_ajax() || is_feed() || is_embed()) {
        return;
    }

    // Only the front page. A deep link keeps whatever language it names.
    if (!is_front_page()) {
        return;
    }

    // Let editors see exactly the URL they asked for.
    if (is_user_logged_in() && current_user_can('manage_options')) {
        return;
    }

    // Never bounce a crawler — each language has to stay reachable at its own
    // URL for hreflang to mean anything.
    if (iptv_is_bot()) {
        return;
    }

    // Escape hatch, and what the switcher appends when it sends you somewhere
    // on purpose, so the redirect cannot fight the click.
    if (isset($_GET['nolangredirect'])) {
        return;
    }

    $preferred = iptv_stored_language();
    if (!$preferred) {
        return;
    }

    $current = function_exists('pll_current_language') ? pll_current_language('slug') : '';
    if (!$current || $current === $preferred) {
        return;
    }

    $target = function_exists('pll_home_url') ? pll_home_url($preferred) : '';
    if (!$target) {
        return;
    }

    wp_safe_redirect($target, 302);
    exit;
});

/**
 * Keep the page cache from swallowing the redirect.
 *
 * LiteSpeed serves a cached page before PHP runs, so a cache hit would skip the
 * redirect above entirely. Two measures, in order of preference:
 *
 *   - Vary the front page on the preference cookie, so each language gets its
 *     own cache entry rather than one shared one.
 *   - Additionally bypass the cache when a preference is actually set, so the
 *     redirect is guaranteed to run for the visitors it applies to. Anyone
 *     without a preference — the overwhelming majority, and every first-time
 *     visitor — still gets a fully cached page.
 *
 * The old code disabled caching on the front page for everyone.
 */
add_action('template_redirect', function () {
    if (!is_front_page() || headers_sent()) {
        return;
    }

    header('X-LiteSpeed-Vary: cookie=' . IPTV_LANG_COOKIE);

    if (iptv_stored_language()) {
        header('X-LiteSpeed-Cache-Control: no-cache');
    }
}, 1);

/**
 * Hand the switcher what it needs: the cookie name, the current language, and
 * the currency/language pairs.
 */
add_action('wp_head', function () {
    // Where each language's copy of *this* page lives. Polylang works this out
    // per request and falls back to that language's front page when no
    // translation exists, which is exactly the behaviour the switcher wants.
    //
    // Without this the switcher only knew the language roots, so changing
    // language from /sv/about-us dropped you on /no/ instead of /no/about-us.
    $urls = array();
    if (function_exists('pll_the_languages')) {
        $list = pll_the_languages(array(
            'raw'                    => 1,
            'echo'                   => 0,
            'hide_if_no_translation' => 0,
        ));

        if (is_array($list)) {
            foreach ($list as $entry) {
                if (!empty($entry['slug']) && !empty($entry['url'])) {
                    $urls[$entry['slug']] = $entry['url'];
                }
            }
        }
    }

    $data = array(
        'cookie'     => IPTV_LANG_COOKIE,
        'days'       => IPTV_LANG_COOKIE_DAYS,
        'current'    => function_exists('pll_current_language') ? pll_current_language('slug') : '',
        'slugs'      => array_values(iptv_lang_slugs()),
        'byCurrency' => (object) iptv_lang_by_currency(),
        'urls'       => (object) $urls,
    );

    echo '<script>window.ibostreamingLang=' . wp_json_encode($data) . ';';

    // Shared by both copies of the switcher — front-page/js/currency.js and the
    // inline one in inc/universal-header.php — so they cannot drift apart again.
    echo 'window.ibostreamingLangUrl=function(c){'
        . 'var g=window.ibostreamingLang;if(!g||!g.byCurrency)return null;'
        . 'var s=g.byCurrency[c];if(!s)return null;'
        . 'return (g.urls&&g.urls[s])||null;};';

    echo '</script>' . "\n";
}, 5);

/**
 * Is this request a crawler?
 *
 * Carried over from inc/geo-redirect.php, which is where the list was built.
 *
 * @return bool
 */
function iptv_is_bot()
{
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        return false;
    }

    $user_agent = strtolower(wp_unslash($_SERVER['HTTP_USER_AGENT']));

    $bots = array(
        'googlebot',
        'bingbot',
        'slurp',
        'duckduckbot',
        'baiduspider',
        'yandexbot',
        'sogou',
        'exabot',
        'facebot',
        'facebookexternalhit',
        'ia_archiver',
        'mj12bot',
        'ahrefsbot',
        'semrushbot',
        'dotbot',
        'rogerbot',
        'screaming frog',
        'gtmetrix',
        'pingdom',
        'uptimerobot',
        'petalbot',
        'applebot',
        'twitterbot',
        'linkedinbot',
        'slackbot',
        'telegrambot',
        'whatsapp',
        'discordbot',
        'bot',
        'crawler',
        'spider',
    );

    foreach ($bots as $bot) {
        if (strpos($user_agent, $bot) !== false) {
            return true;
        }
    }

    return false;
}

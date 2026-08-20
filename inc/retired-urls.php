<?php
/**
 * Retired URLs
 *
 * A page that is removed still has its address in inboxes, chat histories,
 * bookmarks and whatever linked to it from outside the site. Deleting it without
 * a redirect turns every one of those into a 404, so each retirement gets a 301
 * to the page that took over its job.
 *
 * Matched on the request path rather than is_404(), so the redirect holds
 * whether the old page is trashed, deleted outright, or still present.
 *
 * @package iBostreaming
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('iptv_retired_urls')) {
    /**
     * Retired path => where it goes now.
     *
     * Keys are compared without surrounding slashes, so 'thank-you' matches
     * /thank-you, /thank-you/ and /thank-you/?utm_source=...
     *
     * @return array<string,string>
     */
    function iptv_retired_urls()
    {
        return array(
            // Removed 2026-08-20. It told visitors the payment system was being
            // updated and to arrange payment over WhatsApp or Telegram, which
            // stopped being true once checkout moved to the member panel.
            // Support contact is what it was really for, so that is where it goes.
            'thank-you' => '/contact/',
        );
    }
}

add_action('template_redirect', function () {
    if (is_admin() || wp_doing_ajax()) {
        return;
    }

    $uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '';
    $path = trim((string) parse_url($uri, PHP_URL_PATH), '/');

    if ($path === '') {
        return;
    }

    $retired = iptv_retired_urls();

    if (!isset($retired[$path])) {
        return;
    }

    $target = home_url($retired[$path]);

    // Keep any query string: campaign parameters on an old link are still worth
    // recording against the page that answers it now.
    $query = parse_url($uri, PHP_URL_QUERY);
    if ($query) {
        $target .= (strpos($target, '?') === false ? '?' : '&') . $query;
    }

    wp_safe_redirect($target, 301);
    exit;
}, 0);

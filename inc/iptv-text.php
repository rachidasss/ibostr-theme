<?php
/**
 * iptv_text() – front page copy lookup
 *
 * Every string on the front page (and in the header and footer, which render on
 * every template) goes through this function.
 *
 * Resolution order:
 *   1. ACF field on the front page. Polylang filters `page_on_front`, so this
 *      returns the English page on `/` and the Swedish one under `/sv/` — which is
 *      what makes the whole page translatable from the page editor.
 *   2. The Polylang string translation of the English default, for the handful of
 *      strings registered in inc/front-page-strings.php. pll__() returns its input
 *      unchanged for anything unregistered, so this is a safe catch-all.
 *   3. The English default written into the template.
 *
 * This replaces IPTV_Content_Settings::get_text(), which also consulted an
 * `iptv_content` option keyed by the site slugs of the old multisite install
 * (se/no/dk/fi/is). Polylang's Swedish slug is `sv`, so that layer never matched
 * and always fell through to English.
 *
 * @package Nordic_IPTV
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('iptv_text')) {
    /**
     * Get the current language's copy for a front page key.
     *
     * @param string $key     Field name on the front page ACF group.
     * @param string $default English fallback, also the Polylang lookup key.
     * @return string
     */
    function iptv_text($key, $default = '')
    {
        // Keys backed by an ACF link field (an array). Templates read those
        // directly, so the lookup here would only ever return the wrong shape.
        static $acf_skip_keys = array('hero_cta');

        // NOTE: the old get_text() mapped 'hero_title_span' to a field named
        // 'hero_title_gradient_text'. No such field exists — the ACF field is
        // named 'hero_title_span' and only its *label* says "Gradient Text" — so
        // the lookup always missed and the hero's second line silently fell back
        // to the template default, ignoring whatever was typed in the editor.

        $front_page_id = get_option('page_on_front');

        // Which pages to consult, in order.
        //
        // This used to read the front page and nothing else, which was correct
        // while the front page was the only page these strings appeared on.
        // It stops being correct the moment a translated landing page renders
        // through the same template: /fr/, /de/ and /sv/ are their own pages, so
        // every field lookup resolved against the English front page and the
        // translated copy was unreachable. Polylang used to paper over this by
        // filtering page_on_front per language; it is no longer installed.
        //
        // Current page first, front page as the fallback. A translated page that
        // has not been filled in yet therefore shows the English copy rather than
        // an empty section, which is the right failure mode.
        $sources = array();

        $current_id = get_queried_object_id();
        if ($current_id && get_post_type($current_id) === 'page') {
            $sources[] = $current_id;
        }

        if ($front_page_id && !in_array($front_page_id, $sources, true)) {
            $sources[] = $front_page_id;
        }

        foreach ($sources as $source_id) {
            if (function_exists('get_field') && !in_array($key, $acf_skip_keys, true)) {
                $value = get_field($key, $source_id);

                if ($value !== null && $value !== '' && !is_array($value)) {
                    return $value;
                }
            }

            // get_field() resolves nothing for a field ACF has not registered,
            // which is the case for any field added to acf-json/ but not yet
            // synced into the database. The value is still plain post meta under
            // the same key, so read it directly rather than falling through to
            // the English default.
            $meta = get_post_meta($source_id, $key, true);
            if (is_string($meta) && $meta !== '') {
                return $meta;
            }
        }

        if ($default !== '' && function_exists('pll__')) {
            return pll__($default);
        }

        return $default;
    }
}

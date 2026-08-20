<?php
/**
 * Copy a landing page's current wording into its own ACF fields, once.
 *
 * Every landing string has a default in the section templates, and every
 * translated string has one in inc/landing-i18n/. That renders correctly but
 * leaves the editor showing empty boxes, which matters most for the repeaters:
 * a list is all or nothing, so adding a single FAQ row to an empty repeater
 * replaces all nine rather than adding a tenth.
 *
 * Seeding fixes that by writing what the page already shows into the fields, so
 * the editor starts from the real content instead of a blank slate.
 *
 * Run it by visiting the page itself with ?iptv_seed_fields=1 while logged in as
 * an administrator. Rendering on the front end is deliberate: it is the only
 * context where the language, the queried page and every conditional resolve
 * exactly as a visitor sees them.
 *
 * Safe to repeat. Fields that already hold a value are never touched, so a
 * second run is a no-op and nothing an editor has typed can be overwritten.
 *
 * @package Nordic_IPTV
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Values collected during the render. Null means "not collecting".
 *
 * @var array<string,mixed>|null
 */
$GLOBALS['iptv_lp_seed'] = null;

if (!function_exists('iptv_lp_seed_record')) {
    /**
     * Note the value a resolver returned. No-op unless a seed run is active.
     *
     * @param string $key
     * @param mixed  $value
     * @return void
     */
    function iptv_lp_seed_record($key, $value)
    {
        if (!isset($GLOBALS['iptv_lp_seed']) || !is_array($GLOBALS['iptv_lp_seed'])) {
            return;
        }

        // First writer wins: a key rendered twice on one page is the same value,
        // and the first is the one nearest the top of the page.
        if (!array_key_exists($key, $GLOBALS['iptv_lp_seed'])) {
            $GLOBALS['iptv_lp_seed'][$key] = $value;
        }
    }
}

if (!function_exists('iptv_lp_seed_requested')) {
    /**
     * Whether this request is an authorised seed run.
     *
     * @return bool
     */
    function iptv_lp_seed_requested()
    {
        if (empty($_GET['iptv_seed_fields'])) {
            return false;
        }

        if (!is_user_logged_in() || !current_user_can('manage_options')) {
            return false;
        }

        return function_exists('iptv_is_landing_template') && iptv_is_landing_template();
    }
}

if (!function_exists('iptv_lp_seed_attachment_id')) {
    /**
     * Attachment ID for an image URL, or 0 when the file is not in the library.
     *
     * ACF stores an image field as an attachment ID and turns it back into a URL
     * on read. Writing a bare URL would therefore not round-trip: the next render
     * asks acf_get_attachment() for a post that does not exist and gets nothing,
     * so the image silently disappears.
     *
     * @param mixed $value
     * @return int
     */
    function iptv_lp_seed_attachment_id($value)
    {
        if (is_numeric($value)) {
            return (int) $value;
        }

        if (!is_string($value) || $value === '' || !function_exists('attachment_url_to_postid')) {
            return 0;
        }

        return (int) attachment_url_to_postid($value);
    }
}

if (!function_exists('iptv_lp_seed_prepare')) {
    /**
     * Convert a rendered value into what ACF needs stored, or null to skip it.
     *
     * @param string $key
     * @param mixed  $value
     * @param int    $post_id
     * @return mixed Null when the value cannot be stored safely.
     */
    function iptv_lp_seed_prepare($key, $value, $post_id)
    {
        // acf_get_field() reads the definition straight from the field group,
        // sub_fields included. get_field_object() does not always carry them,
        // and a missing sub_fields list means an image sub-field goes unnoticed.
        $field = function_exists('acf_get_field') ? acf_get_field($key) : null;

        if (!$field && function_exists('get_field_object')) {
            $field = get_field_object($key, $post_id, false, false);
        }

        if (!$field || empty($field['type'])) {
            return $value;
        }

        if ($field['type'] === 'image') {
            $id = iptv_lp_seed_attachment_id($value);

            return $id ? $id : null;
        }

        // A one-column list is a textarea holding one item per line, but
        // iptv_lp_list() hands back the row shape every template expects.
        // Storing that array unchanged puts an array where ACF expects a
        // string, and the editor fatals the moment it tries to render it -
        // silently truncating the form from that field onwards.
        if (is_array($value) && in_array($field['type'], array('textarea', 'text'), true)) {
            $lines = array();

            foreach ($value as $row) {
                $cell = is_array($row) ? reset($row) : $row;

                if (is_scalar($cell) && trim((string) $cell) !== '') {
                    $lines[] = trim((string) $cell);
                }
            }

            return $lines ? implode("\n", $lines) : null;
        }

        if ($field['type'] !== 'repeater' || !is_array($value)) {
            return $value;
        }

        $types = array();
        foreach ((array) $field['sub_fields'] as $sub) {
            if (!empty($sub['name'])) {
                $types[$sub['name']] = $sub['type'];
            }
        }

        foreach ($value as $i => $row) {
            if (!is_array($row)) {
                continue;
            }

            foreach ($row as $col => $cell) {
                if (!isset($types[$col]) || $types[$col] !== 'image') {
                    continue;
                }

                $id = iptv_lp_seed_attachment_id($cell);

                // A list is stored as a whole. Seeding rows whose image cannot
                // be resolved would replace working defaults with broken rows,
                // so the entire list is left alone instead.
                if (!$id) {
                    return null;
                }

                $value[$i][$col] = $id;
            }
        }

        return $value;
    }
}

if (!function_exists('iptv_lp_seed_lost_content')) {
    /**
     * Whether reading a value back lost something that was there before.
     *
     * Deliberately one-directional: ACF is free to add keys, reformat or reorder
     * on the way out. The only failure worth catching is content going missing.
     *
     * @param mixed $before Value the page rendered.
     * @param mixed $after  Value ACF returns now that it is stored.
     * @return bool
     */
    function iptv_lp_seed_lost_content($before, $after)
    {
        if (is_array($before)) {
            if (!is_array($after) || count($after) < count($before)) {
                return true;
            }

            foreach ($before as $k => $v) {
                if (!array_key_exists($k, $after)
                    || iptv_lp_seed_lost_content($v, $after[$k])) {
                    return true;
                }
            }

            return false;
        }

        $b = is_scalar($before) ? trim((string) $before) : '';
        $a = is_scalar($after) ? trim((string) $after) : '';

        return $b !== '' && $a === '';
    }
}

if (!function_exists('iptv_lp_seed_clear')) {
    /**
     * Remove every seeded lp_* value from one page.
     *
     * The counterpart to seeding. A page with nothing stored falls back to its
     * language file and then to the template defaults, so clearing is how a page
     * is put back to "whatever the theme ships" - which is also the fix if a
     * seed run ever stores the wrong language.
     *
     * @param int $post_id
     * @return array Keys that were removed.
     */
    function iptv_lp_seed_clear($post_id)
    {
        global $wpdb;

        $keys = $wpdb->get_col($wpdb->prepare(
            "SELECT DISTINCT meta_key FROM {$wpdb->postmeta}
             WHERE post_id = %d AND meta_key LIKE %s",
            $post_id,
            'lp\_%'
        ));

        $removed = array();

        foreach ($keys as $key) {
            // Repeaters also store per-row keys (lp_faq_items_0_question) and an
            // underscore-prefixed field reference for each. delete_post_meta on
            // the row keys is what actually empties the list.
            delete_post_meta($post_id, $key);
            delete_post_meta($post_id, '_' . $key);
            $removed[] = $key;
        }

        if (function_exists('acf_flush_value_cache')) {
            acf_flush_value_cache($post_id);
        }

        wp_cache_delete($post_id, 'post_meta');

        return $removed;
    }
}

// Start collecting before the template runs.
add_action('template_redirect', function () {
    if (!empty($_GET['iptv_clear_fields'])
        && is_user_logged_in() && current_user_can('manage_options')
        && function_exists('iptv_is_landing_template') && iptv_is_landing_template()) {
        $removed = iptv_lp_seed_clear(get_queried_object_id());

        wp_die(esc_html(sprintf(
            'Cleared %d stored values from page %d. Reload the page to see the theme defaults.',
            count($removed),
            get_queried_object_id()
        )), 'Fields cleared', array('response' => 200));
    }

    if (iptv_lp_seed_requested()) {
        $GLOBALS['iptv_lp_seed'] = array();
    }
}, 1);

// Write once the page has rendered and every resolver has reported in.
add_action('wp_footer', function () {
    if (!is_array($GLOBALS['iptv_lp_seed'])) {
        return;
    }

    $collected = $GLOBALS['iptv_lp_seed'];
    $GLOBALS['iptv_lp_seed'] = null;

    $post_id = get_queried_object_id();
    if (!$post_id || !function_exists('update_field')) {
        return;
    }

    $written = array();
    $skipped = array();

    foreach ($collected as $key => $value) {
        if (strpos($key, 'lp_') !== 0) {
            continue;
        }

        $existing = get_field($key, $post_id);

        // Only fill genuinely empty fields. "0" is a real value; empty() is not
        // safe here.
        $is_empty = ($existing === null || $existing === '' || $existing === false
            || (is_array($existing) && count($existing) === 0));

        if (!$is_empty) {
            $skipped[] = $key;
            continue;
        }

        if ($value === null || $value === '' || (is_array($value) && !$value)) {
            continue;
        }

        $value = iptv_lp_seed_prepare($key, $value, $post_id);

        if ($value === null) {
            $skipped[] = $key . ' (image not in the media library)';
            continue;
        }

        if (!update_field($key, $value, $post_id)) {
            continue;
        }

        // An array stored in a string field renders fine on the front end and
        // kills the editor, so shape is checked as well as content.
        $stored = get_field($key, $post_id);

        if (is_array($stored) !== is_array($value)) {
            if (function_exists('delete_field')) {
                delete_field($key, $post_id);
            }

            $skipped[] = $key . ' (stored shape does not match the field)';
            continue;
        }

        // Never trust the write. ACF stores several types in a different shape
        // than it returns them, so a value that does not survive a read would
        // quietly replace working copy with nothing - which is exactly how the
        // showcase images came back as src="" the first time this ran.
        if (iptv_lp_seed_lost_content($collected[$key], get_field($key, $post_id))) {
            if (function_exists('delete_field')) {
                delete_field($key, $post_id);
            }

            $skipped[] = $key . ' (did not survive a read - left on the template default)';
            continue;
        }

        $written[] = $key;
    }

    printf(
        '<pre style="position:fixed;inset:auto 1rem 1rem auto;z-index:99999;max-width:32rem;'
        . 'max-height:60vh;overflow:auto;background:#111;color:#0f0;padding:1rem;'
        . 'font:12px/1.5 monospace;border-radius:8px">%s</pre>',
        esc_html(sprintf(
            "iBostreaming field seeding\npage %d (%s)\n\nfilled   %d\nalready set %d\n\n%s",
            $post_id,
            iptv_lp_lang(),
            count($written),
            count($skipped),
            implode("\n", $written)
        ))
    );
}, 99);

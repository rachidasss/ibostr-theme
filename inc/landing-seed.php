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
        $field = function_exists('get_field_object')
            ? get_field_object($key, $post_id, false, false)
            : null;

        if (!$field || empty($field['type'])) {
            return $value;
        }

        if ($field['type'] === 'image') {
            $id = iptv_lp_seed_attachment_id($value);

            return $id ? $id : null;
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

// Start collecting before the template runs.
add_action('template_redirect', function () {
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

        if (update_field($key, $value, $post_id)) {
            $written[] = $key;
        }
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

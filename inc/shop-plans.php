<?php
/**
 * The plan table on /shop/.
 *
 * The page opened with "Every iBostreaming IPTV subscription below…" and then
 * listed nothing. WooCommerce is not active, so the product loop that used to
 * fill it renders nothing and the four /product/… URLs it linked to return 404.
 * Twelve blog posts now point at this page, so it has to actually show the plans.
 *
 * Server-rendered from IPTV_Currency_Settings so the prices have one source of
 * truth - the same array the landing page configurator reads. No JavaScript: the
 * whole table is in the HTML, which is the point.
 *
 * Plain semantic markup rather than the landing page's Tailwind, because /shop/
 * runs page.php and does not load the compiled bundle.
 *
 * @package iBostreaming
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('iptv_shop_plan_rows')) {
    /**
     * The 16 SKUs, as rows of duration => per-screen prices.
     *
     * @return array<string,array<string,float>>
     */
    function iptv_shop_plan_rows()
    {
        if (class_exists('IPTV_Currency_Settings')
            && method_exists('IPTV_Currency_Settings', 'get_price_table')) {
            $table = IPTV_Currency_Settings::get_price_table();

            // The table is keyed by duration then device count, each holding a
            // map of currency => price. Only USD is sold, so flatten to that.
            $rows = array();

            foreach ($table as $duration => $devices) {
                if (!is_array($devices)) {
                    continue;
                }

                foreach ($devices as $device => $prices) {
                    if (is_array($prices) && isset($prices['usd'])) {
                        $rows[$duration][$device] = $prices['usd'];
                    } elseif (is_numeric($prices)) {
                        $rows[$duration][$device] = $prices;
                    }
                }
            }

            if (!empty($rows)) {
                return $rows;
            }
        }

        return array();
    }
}

if (!function_exists('iptv_shop_checkout_url')) {
    /**
     * Panel checkout link for one plan.
     *
     * @param string $duration e.g. 12_months
     * @param string $device   e.g. 2_devices
     * @return string
     */
    function iptv_shop_checkout_url($duration, $device)
    {
        $base = function_exists('iptv_config')
            ? iptv_config('checkout_base_url', 'https://panel.ibostreaming.com/checkout')
            : 'https://panel.ibostreaming.com/checkout';

        return add_query_arg(array(
            'plan_type'   => 'm3u',
            'connections' => (int) $device,
            'duration'    => (int) $duration,
            'source'      => 'shop_page',
        ), $base);
    }
}

if (!function_exists('iptv_shop_plans_html')) {
    /**
     * The plan table.
     *
     * @return string
     */
    function iptv_shop_plans_html()
    {
        $rows = iptv_shop_plan_rows();

        if (empty($rows)) {
            return '';
        }

        $duration_labels = array(
            '1_month'   => __('1 Month', 'iptv'),
            '3_months'  => __('3 Months', 'iptv'),
            '6_months'  => __('6 Months', 'iptv'),
            '12_months' => __('12 Months', 'iptv'),
        );

        $device_labels = array(
            '1_device'  => __('1 screen', 'iptv'),
            '2_devices' => __('2 screens', 'iptv'),
            '3_devices' => __('3 screens', 'iptv'),
            '4_devices' => __('4 screens', 'iptv'),
        );

        $devices = array('1_device', '2_devices', '3_devices', '4_devices');

        ob_start();
        ?>
        <div class="iptv-shop-plans">
            <h2 id="plans"><?php esc_html_e('IPTV subscription plans and prices', 'iptv'); ?></h2>

            <div class="iptv-shop-plans__scroll">
                <table class="iptv-shop-plans__table">
                    <caption class="screen-reader-text"><?php
                        esc_html_e('iBostreaming IPTV plans: price by subscription length and number of simultaneous screens.', 'iptv');
                    ?></caption>
                    <thead>
                        <tr>
                            <th scope="col"><?php esc_html_e('Plan length', 'iptv'); ?></th>
                            <?php foreach ($devices as $device) : ?>
                                <th scope="col"><?php echo esc_html($device_labels[$device]); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($duration_labels as $duration => $duration_label) : ?>
                            <?php if (empty($rows[$duration])) { continue; } ?>
                            <tr>
                                <th scope="row"><?php echo esc_html($duration_label); ?></th>
                                <?php foreach ($devices as $device) :
                                    $price = isset($rows[$duration][$device]) ? $rows[$duration][$device] : null;
                                    ?>
                                    <td>
                                        <?php if ($price === null) : ?>
                                            &mdash;
                                        <?php else : ?>
                                            <a class="iptv-shop-plans__price"
                                               href="<?php echo esc_url(iptv_shop_checkout_url($duration, $device)); ?>"
                                               rel="nofollow">
                                                $<?php echo esc_html(number_format((float) $price, 2)); ?>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <p class="iptv-shop-plans__note"><?php
                esc_html_e('Every plan carries the same channel list, the same film and series library and the same 4K servers. Only the length and the number of simultaneous screens change the price. Each is a single payment with no automatic renewal, activated in about two to five minutes, and covered by a 7-day money-back guarantee.', 'iptv');
            ?></p>
        </div>
        <?php
        return (string) ob_get_clean();
    }
}

/**
 * Append the table to /shop/.
 *
 * Filtered onto the content rather than written into the page body, so the
 * prices stay generated from one source and the page keeps whatever intro copy
 * the editor writes above them.
 */
add_filter('the_content', function ($content) {
    if (is_admin() || !is_singular('page') || !in_the_loop() || !is_main_query()) {
        return $content;
    }

    $post = get_post();

    if (!$post || $post->post_name !== 'shop') {
        return $content;
    }

    // Belt and braces: never print it twice if the filter runs more than once.
    if (strpos($content, 'iptv-shop-plans') !== false) {
        return $content;
    }

    return $content . iptv_shop_plans_html();
});

/**
 * Styles for the table.
 *
 * Inlined rather than enqueued: it is under a kilobyte and only ever renders on
 * one page, so a separate request would cost more than it saves.
 */
add_action('wp_head', function () {
    if (!is_page()) {
        return;
    }

    $post = get_post();

    if (!$post || $post->post_name !== 'shop') {
        return;
    }
    ?>
    <style id="iptv-shop-plans-css">
    .iptv-shop-plans{margin:2.5rem 0 0}
    .iptv-shop-plans h2{margin:0 0 1rem;font-size:1.5rem;line-height:1.25}
    .iptv-shop-plans__scroll{overflow-x:auto;-webkit-overflow-scrolling:touch}
    .iptv-shop-plans__table{width:100%;border-collapse:collapse;font-size:.95rem;min-width:32rem}
    .iptv-shop-plans__table th,.iptv-shop-plans__table td{padding:.7rem .9rem;text-align:left;border-bottom:1px solid rgba(15,23,42,.12)}
    .iptv-shop-plans__table thead th{font-size:.8rem;text-transform:uppercase;letter-spacing:.05em;color:#475569;white-space:nowrap}
    .iptv-shop-plans__table tbody th{white-space:nowrap;font-weight:700}
    .iptv-shop-plans__table td{font-variant-numeric:tabular-nums}
    .iptv-shop-plans__price{display:inline-block;padding:.35rem .8rem;border-radius:999px;background:#007CEB;color:#fff;font-weight:700;text-decoration:none;white-space:nowrap}
    .iptv-shop-plans__price:hover,.iptv-shop-plans__price:focus{background:#0063bd;color:#fff}
    .iptv-shop-plans__note{margin:1.1rem 0 0;font-size:.9rem;color:#475569;max-width:60ch}
    .screen-reader-text{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(1px,1px,1px,1px);white-space:nowrap}
    </style>
    <?php
}, 20);

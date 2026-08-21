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

            <?php
            /*
             * Buying guidance.
             *
             * The page was 246 words - a price table and a sentence - while twelve
             * blog posts link to it as the place to buy. Thin for a commercial page,
             * and it answered none of the questions a first-time buyer actually has:
             * how many screens they need, what arrives after paying, whether it
             * renews. Every claim below is the same one the refund policy, the
             * checkout and the FAQ already make, so nothing new is promised here.
             */
            ?>
            <h2 id="choosing"><?php esc_html_e('Choosing between the sixteen plans', 'iptv'); ?></h2>

            <p><?php esc_html_e('Only two things change the price, and neither of them changes what you can watch.', 'iptv'); ?></p>

            <h3><?php esc_html_e('How long you want it for', 'iptv'); ?></h3>
            <p><?php
                esc_html_e('Plans run for 1, 3, 6 or 12 months. The longer terms cost less per month, and because nothing renews automatically, a 12-month plan is simply one payment that lasts a year rather than a commitment you have to remember to cancel. A 1-month plan is the sensible way to see whether the service suits you before paying for longer.', 'iptv');
            ?></p>

            <h3><?php esc_html_e('How many screens you need at once', 'iptv'); ?></h3>
            <p><?php
                esc_html_e('This is the one people get wrong. It is not how many devices you own - it is how many are watching at the same moment. Your line works on any device you install it on; the screen count only limits simultaneous streams.', 'iptv');
            ?></p>
            <ul class="iptv-shop-plans__list">
                <li><?php esc_html_e('1 screen - one person watching at a time, on as many devices as you like.', 'iptv'); ?></li>
                <li><?php esc_html_e('2 screens - two people watching different channels at once, the usual choice for a couple.', 'iptv'); ?></li>
                <li><?php esc_html_e('3 or 4 screens - a family watching separately, or a second home.', 'iptv'); ?></li>
            </ul>
            <p><?php
                esc_html_e('Buying more screens than you need is the most common way to overpay. Start with the number of people who genuinely watch at the same time.', 'iptv');
            ?></p>

            <h2 id="included"><?php esc_html_e('What every plan includes', 'iptv'); ?></h2>
            <p><?php
                printf(
                    /* translators: %s: link to the setup guide */
                    wp_kses(
                        __('The same live channels, the same film and series library and the same 4K servers on all sixteen plans - the cheapest and the most expensive differ only in length and screen count. Your line works on Firestick, Samsung and LG Smart TVs, Android TV boxes, Android and iOS phones and tablets, MAG and Formuler boxes, Windows and Mac. The <a href="%s">setup guide</a> has the steps for each one.', 'iptv'),
                        array('a' => array('href' => array()))
                    ),
                    esc_url(home_url('/guide/'))
                );
            ?></p>

            <h2 id="after-payment"><?php esc_html_e('What happens after you pay', 'iptv'); ?></h2>
            <p><?php
                esc_html_e('Activation is automatic - nothing waits on manual approval. Within roughly two to five minutes you receive an email with your credentials: an M3U playlist link, plus an Xtream Codes username and password. The same line also appears under "My IPTV Lines" in your account, so you are never dependent on that email arriving.', 'iptv');
            ?></p>
            <p><?php
                printf(
                    /* translators: %s: link to the setup guide */
                    wp_kses(
                        __('Paste the link into a free player such as TiviMate, IPTV Smarters or IBO Player Pro and you are watching. If the email has not arrived, check your spam folder first - that is where it usually is. Step-by-step instructions for each device are in the <a href="%s">setup guide</a>.', 'iptv'),
                        array('a' => array('href' => array()))
                    ),
                    esc_url(home_url('/guide/'))
                );
            ?></p>

            <h2 id="payment"><?php esc_html_e('Payment, renewal and refunds', 'iptv'); ?></h2>
            <p><?php
                printf(
                    /* translators: %s: link to the refund policy */
                    wp_kses(
                        __('Every plan is a single payment. There is no subscription to cancel and no card stored for automatic renewal - when the term ends, it simply ends, and you choose whether to buy again. If the service is not what you expected, the <a href="%s">refund policy</a> gives you a full refund within 7 days of purchase.', 'iptv'),
                        array('a' => array('href' => array()))
                    ),
                    esc_url(home_url('/refund-returns/'))
                );
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
    .iptv-shop-plans h2{margin:2.4rem 0 .7rem;font-size:1.4rem;line-height:1.28}
    .iptv-shop-plans h3{margin:1.6rem 0 .4rem;font-size:1.08rem;line-height:1.3}
    .iptv-shop-plans p{margin:0 0 1rem;max-width:66ch}
    .iptv-shop-plans a{color:#007CEB}
    .iptv-shop-plans__list{margin:0 0 1rem;padding-left:1.15rem;max-width:66ch}
    .iptv-shop-plans__list li{margin-bottom:.35rem}
    .screen-reader-text{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(1px,1px,1px,1px);white-space:nowrap}
    </style>
    <?php
}, 20);

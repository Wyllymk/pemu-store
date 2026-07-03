<?php
/**
 * WooCommerce cart/cart-totals.php — Pemu override
 * @version 2.3.6
 */
defined('ABSPATH') || exit;
?>
<div
    class="cart_totals bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden">

    <!-- Header -->
    <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-800">
        <h2 class="font-display font-bold text-lg text-slate-800 dark:text-slate-200">
            <?php esc_html_e('Order Summary','woocommerce'); ?></h2>
    </div>

    <div class="p-6 space-y-0">
        <table cellspacing="0" class="shop_table shop_table_responsive w-full text-sm">
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">

                <tr class="cart-subtotal">
                    <th class="py-3.5 text-left font-medium text-slate-500 dark:text-slate-400 w-1/2 text-sm">
                        <?php esc_html_e('Subtotal','woocommerce'); ?></th>
                    <td class="py-3.5 text-right font-semibold text-slate-800 dark:text-slate-200 text-sm"
                        data-title="<?php esc_attr_e('Subtotal','woocommerce'); ?>">
                        <?php wc_cart_totals_subtotal_html(); ?>
                    </td>
                </tr>

                <?php foreach (WC()->cart->get_coupons() as $code => $coupon): ?>
                <tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
                    <th class="py-3 text-left font-medium text-brand-green text-sm">
                        <?php wc_cart_totals_coupon_label($coupon); ?>
                        <a href="<?php echo esc_url(add_query_arg('remove_coupon',urlencode($code),wc_get_cart_url())); ?>"
                            class="ml-1 text-red-400 hover:text-red-600 text-xs no-underline"
                            aria-label="Remove coupon">✕</a>
                    </th>
                    <td class="py-3 text-right font-semibold text-brand-green text-sm"
                        data-title="<?php echo esc_attr(wc_cart_totals_coupon_label($coupon,false)); ?>">
                        <?php wc_cart_totals_coupon_html($coupon); ?>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()): ?>
                <tr class="woocommerce-shipping-totals shipping">
                    <th class="py-3.5 text-left font-medium text-slate-500 dark:text-slate-400 align-top text-sm">
                        <?php esc_html_e('Delivery','woocommerce'); ?></th>
                    <td class="py-3.5 text-right text-sm" data-title="<?php esc_attr_e('Delivery','woocommerce'); ?>">
                        <?php wc_cart_totals_shipping_html(); ?>
                    </td>
                </tr>
                <?php endif; ?>

                <?php foreach (WC()->cart->get_fees() as $fee): ?>
                <tr class="fee">
                    <th class="py-3 text-left font-medium text-slate-500 dark:text-slate-400 text-sm">
                        <?php echo esc_html($fee->name); ?></th>
                    <td class="py-3 text-right font-semibold text-slate-800 dark:text-slate-200 text-sm"
                        data-title="<?php echo esc_attr($fee->name); ?>">
                        <?php wc_cart_totals_fee_html($fee); ?>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()):
          $taxrates = WC()->cart->get_tax_totals();
          if (!empty($taxrates)): foreach ($taxrates as $code => $tax): ?>
                <tr class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?>">
                    <th class="py-3 text-left font-medium text-slate-500 dark:text-slate-400 text-sm">
                        <?php echo esc_html($tax->label); ?></th>
                    <td class="py-3 text-right text-slate-800 dark:text-slate-200 text-sm"
                        data-title="<?php echo esc_attr($tax->label); ?>">
                        <?php echo wp_kses_post($tax->formatted_amount); ?>
                    </td>
                </tr>
                <?php endforeach; endif; endif; ?>

            </tbody>
        </table>

        <div class="border-t border-slate-200 dark:border-slate-700 my-4"></div>

        <div class="flex items-center justify-between">
            <span
                class="font-display font-bold text-lg text-slate-800 dark:text-slate-200"><?php esc_html_e('Total','woocommerce'); ?></span>
            <div class="text-right">
                <div class="font-display font-extrabold text-2xl text-brand-green">
                    <?php wc_cart_totals_order_total_html(); ?></div>
                <?php if (WC()->cart->display_prices_including_tax()): ?>
                <p class="text-[10px] text-slate-500 dark:text-slate-400">
                    <?php esc_html_e('Including tax','woocommerce'); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-5 space-y-3">
            <?php do_action('woocommerce_proceed_to_checkout'); ?>

            <a href="<?php echo esc_url(wc_get_checkout_url()); ?>"
                class="block w-full text-center bg-brand-green hover:bg-brand-green-dark !text-white dark:!text-white font-bold py-4 rounded-xl shadow-md shadow-brand-green/30 transition-colors no-underline">
                <?php esc_html_e('Proceed to Checkout','woocommerce'); ?>
            </a>

            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
                class="block w-full text-center text-sm text-slate-600 dark:text-slate-300 hover:text-brand-green transition-colors py-2 no-underline">
                ← <?php esc_html_e('Continue Shopping','pemu'); ?>
            </a>
        </div>

        <div
            class="mt-5 pt-5 border-t border-slate-200 dark:border-slate-700 grid grid-cols-3 gap-2 text-center text-[10px] text-slate-500 dark:text-slate-400">
            <div>
                <div class="text-lg mb-0.5">🔒</div>SSL Secured
            </div>
            <div>
                <div class="text-lg mb-0.5">🌿</div>100% Natural
            </div>
            <div>
                <div class="text-lg mb-0.5">✅</div>Authentic
            </div>
        </div>
    </div>
</div>
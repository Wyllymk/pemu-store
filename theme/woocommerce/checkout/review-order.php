<?php
/**
 * Review order table — Pemu theme override
 * Cards styled via CSS on tfoot rows so WooCommerce's AJAX replaceWith covers everything.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */
defined( 'ABSPATH' ) || exit;
?>

<table class="shop_table woocommerce-checkout-review-order-table">
    <thead>
        <tr>
            <th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
            <th class="product-total"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        do_action( 'woocommerce_review_order_before_cart_contents' );

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                ?>
                <tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                    <td class="product-name">
                        <?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?>
                        <?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </td>
                    <td class="product-total">
                        <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </td>
                </tr>
                <?php
            }
        }

        do_action( 'woocommerce_review_order_after_cart_contents' );
        ?>
    </tbody>
    <tfoot>

        <?php /* Coupons */ ?>
        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
            <tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                <th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
                <td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
            </tr>
        <?php endforeach; ?>

        <?php /* Taxes */ ?>
        <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
            <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
                <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
                    <tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                        <th><?php echo esc_html( $tax->label ); ?></th>
                        <td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr class="tax-total">
                    <th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
                    <td><?php wc_cart_totals_taxes_total_html(); ?></td>
                </tr>
            <?php endif; ?>
        <?php endif; ?>

        <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

        <?php /* ── Subtotal card row ── */ ?>
        <tr class="cart-subtotal pemu-card-row">
            <td colspan="2">
                <div class="pemu-summary-card pemu-summary-subtotal">
                    <div class="pemu-summary-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <path d="M16 10a4 4 0 0 1-8 0"/>
                        </svg>
                    </div>
                    <div class="pemu-summary-label"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></div>
                    <div class="pemu-summary-value"><?php wc_cart_totals_subtotal_html(); ?></div>
                </div>
            </td>
        </tr>

        <?php /* ── Shipping card row ── */ ?>
        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
            <?php
            do_action( 'woocommerce_review_order_before_shipping' );

            // Collect chosen shipping rates across packages
            $chosen_methods = (array) WC()->session->get( 'chosen_shipping_methods', [] );
            $packages       = WC()->shipping()->get_packages();
            $rate_labels    = [];

            foreach ( $packages as $i => $package ) {
                $chosen_id = $chosen_methods[ $i ] ?? '';
                if ( ! empty( $package['rates'][ $chosen_id ] ) ) {
                    $rate        = $package['rates'][ $chosen_id ];
                    $rate_labels[] = $rate->label;
                    // Output required hidden input so WC can process the chosen method on submit
                    printf(
                        '<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method">',
                        absint( $i ),
                        esc_attr( sanitize_title( $chosen_id ) ),
                        esc_attr( $chosen_id )
                    );
                }
            }

            $method_label = implode( ', ', $rate_labels );
            $shipping_total = WC()->cart->get_cart_shipping_total();
            ?>
            <tr class="shipping pemu-card-row">
                <td colspan="2">
                    <div class="pemu-summary-card pemu-summary-shipping">
                        <div class="pemu-summary-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="1" y="3" width="15" height="13" rx="1"/>
                                <path d="M16 8h4l3 5v3h-7V8z"/>
                                <circle cx="5.5" cy="18.5" r="2.5"/>
                                <circle cx="18.5" cy="18.5" r="2.5"/>
                            </svg>
                        </div>
                        <div class="pemu-summary-label"><?php esc_html_e( 'Shipment', 'woocommerce' ); ?></div>
                        <div class="pemu-summary-value text-right">
                            <?php if ( $method_label ) : ?>
                                <span class="block text-[0.7rem] font-medium text-slate-400 dark:text-slate-500 leading-none mb-0.5">
                                    <?php echo esc_html( $method_label ); ?>
                                </span>
                            <?php endif; ?>
                            <?php echo wp_kses_post( $shipping_total ); ?>
                        </div>
                    </div>
                </td>
            </tr>
            <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
        <?php endif; ?>

        <?php /* ── Fee card rows ── */ ?>
        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
            <tr class="fee pemu-card-row">
                <td colspan="2">
                    <div class="pemu-summary-card pemu-summary-fee">
                        <div class="pemu-summary-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="1" x2="12" y2="23"/>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                            </svg>
                        </div>
                        <div class="pemu-summary-label"><?php echo esc_html( $fee->name ); ?></div>
                        <div class="pemu-summary-value"><?php wc_cart_totals_fee_html( $fee ); ?></div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php /* ── Total card row ── */ ?>
        <tr class="order-total pemu-card-row">
            <td colspan="2">
                <div class="pemu-summary-card pemu-summary-total">
                    <div class="pemu-summary-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <div class="pemu-summary-label"><?php esc_html_e( 'Total', 'woocommerce' ); ?></div>
                    <div class="pemu-summary-value"><?php wc_cart_totals_order_total_html(); ?></div>
                </div>
            </td>
        </tr>

        <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

    </tfoot>
</table>

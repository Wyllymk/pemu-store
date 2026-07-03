<?php
/**
 * WooCommerce — cart/mini-cart.php
 * Pemu override: styled mini-cart drawer content.
 * @version 10.0.0
 */
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' );

if ( ! WC()->cart->is_empty() ) : ?>

<div class="flex-1 overflow-y-auto overscroll-contain px-5 py-4 space-y-4" role="list"
    aria-label="<?php esc_attr_e( 'Cart items', 'pemu' ); ?>">
    <?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
			$_product  = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
			$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_mini_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail' ), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_subtotal  = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
			?>
    <div class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item pemu-cart-item', $cart_item, $cart_item_key ) ); ?> flex gap-3 pb-4 border-b border-slate-200 dark:border-slate-700 last:border-0 last:pb-0"
        role="listitem">
        <div
            class="w-20 h-20 shrink-0 rounded-xl overflow-hidden bg-gray-100 dark:bg-slate-800 flex items-center justify-center">
            <?php if ( ! $product_permalink ) : ?>
            <?php echo $thumbnail; // phpcs:ignore ?>
            <?php else : ?>
            <a href="<?php echo esc_url( $product_permalink ); ?>" tabindex="-1" aria-hidden="true"
                class="block w-full h-full">
                <?php echo $thumbnail; // phpcs:ignore ?>
            </a>
            <?php endif; ?>
        </div>

        <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-2">
                <div class="min-w-0">
                    <?php if ( ! $product_permalink ) : ?>
                    <span
                        class="font-semibold text-sm text-slate-800 dark:text-slate-200 leading-snug"><?php echo wp_kses_post( $product_name ); ?></span>
                    <?php else : ?>
                    <a href="<?php echo esc_url( $product_permalink ); ?>"
                        class="font-semibold text-sm text-slate-800 dark:text-slate-200 leading-snug hover:text-brand-green transition-colors line-clamp-2">
                        <?php echo wp_kses_post( $product_name ); ?>
                    </a>
                    <?php endif; ?>

                    <?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore ?>

                    <div class="flex items-center gap-2 mt-2">
                        <div
                            class="inline-flex items-center border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden">
                            <button
                                class="px-2.5 py-1.5 text-sm text-slate-500 dark:text-slate-400 hover:text-brand-green hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors"
                                onclick="pemuUpdateCartQty('<?php echo esc_attr( $cart_item_key ); ?>', Math.max(1, <?php echo (int)$cart_item['quantity']; ?> - 1))"
                                aria-label="<?php esc_attr_e( 'Decrease quantity', 'pemu' ); ?>">−</button>
                            <span
                                class="px-3 py-1.5 text-sm font-semibold text-slate-800 dark:text-slate-200 tabular-nums min-w-[32px] text-center"><?php echo (int) $cart_item['quantity']; ?></span>
                            <button
                                class="px-2.5 py-1.5 text-sm text-slate-500 dark:text-slate-400 hover:text-brand-green hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors"
                                onclick="pemuUpdateCartQty('<?php echo esc_attr( $cart_item_key ); ?>', <?php echo (int)$cart_item['quantity']; ?> + 1)"
                                aria-label="<?php esc_attr_e( 'Increase quantity', 'pemu' ); ?>">+</button>
                        </div>
                        <span
                            class="font-display font-bold text-sm text-brand-green"><?php echo $product_subtotal; // phpcs:ignore ?></span>
                    </div>
                </div>

                <?php
						$remove_link = apply_filters( 'woocommerce_cart_item_remove_link',
							sprintf(
								'<a href="%s" class="remove remove_from_cart_button shrink-0 w-7 h-7 rounded-full flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-red-500 hover:bg-red-500/10 transition-colors" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">%s</a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								esc_html( __( 'Remove', 'pemu' ) . ' ' . $product_name ),
								esc_attr( $product_id ),
								esc_attr( $cart_item_key ),
								esc_attr( $_product->get_sku() ),
								pemu_icon( 'close', [ 'class' => 'w-3.5 h-3.5' ] )
							),
							$cart_item_key
						);
						echo $remove_link; // phpcs:ignore
						?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>

    <?php do_action( 'woocommerce_mini_cart_contents' ); ?>
</div>

<div class="px-5 py-4 border-t border-slate-200 dark:border-slate-700 space-y-4 bg-gray-100 dark:bg-slate-800">
    <div class="flex items-center justify-between text-sm">
        <span class="font-medium text-slate-500 dark:text-slate-400"><?php esc_html_e( 'Subtotal', 'pemu' ); ?></span>
        <span class="font-display font-bold text-slate-800 dark:text-slate-200">
            <?php echo WC()->cart->get_cart_subtotal(); // phpcs:ignore ?>
        </span>
    </div>

    <?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

    <div class="grid grid-cols-2 gap-3">
        <?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?>
    </div>

    <?php if ( function_exists( 'pemu_cart_whatsapp_message' ) ) : ?>
    <a href="<?php echo esc_url( pemu_whatsapp_url( pemu_cart_whatsapp_message() ) ); ?>" target="_blank"
        rel="noopener noreferrer"
        class="group flex items-center justify-center gap-2 w-full py-3 rounded-xl border-2 border-green-500 dark:border-green-400 text-green-600 dark:text-green-400 hover:bg-green-500 dark:hover:bg-green-400 hover:!text-white dark:hover:!text-slate-900 transition-all duration-200 text-sm font-semibold">
        <?php echo pemu_icon( 'whatsapp', [ 'class' => 'w-4 h-4 shrink-0' ] ); ?>
        <span><?php esc_html_e( 'Order via WhatsApp', 'pemu' ); ?></span>
    </a>
    <?php endif; ?>

    <?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
</div>

<?php else : ?>
<div class="flex flex-col items-center justify-center flex-1 px-8 py-16 text-center">
    <div class="w-20 h-20 rounded-full bg-gray-100 dark:bg-slate-800 flex items-center justify-center mb-5">
        <svg class="w-9 h-9 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5"
            viewBox="0 0 24 24" aria-hidden="true">
            <path d="M3 3h2l2.5 12.5a2 2 0 002 1.5h9a2 2 0 002-1.5L22 7H6" stroke-linecap="round"
                stroke-linejoin="round" />
            <circle cx="9" cy="20" r="1.5" fill="currentColor" stroke="none" />
            <circle cx="18" cy="20" r="1.5" fill="currentColor" stroke="none" />
        </svg>
    </div>
    <p class="font-display font-bold text-lg text-slate-800 dark:text-slate-200 mb-2">
        <?php esc_html_e( 'Your cart is empty', 'pemu' ); ?></p>
    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">
        <?php esc_html_e( 'Add some supplements to get started!', 'pemu' ); ?></p>
    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
        class="inline-flex items-center gap-2 bg-brand-green hover:bg-brand-green-dark text-white font-bold px-6 py-3 rounded-xl transition-colors text-sm">
        <?php echo pemu_icon( 'package', [ 'class' => 'w-4 h-4' ] ); ?>
        <?php esc_html_e( 'Browse Products', 'pemu' ); ?>
    </a>
</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
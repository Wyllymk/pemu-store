<?php
/**
 * Pemu Health Supplements — inc/woocommerce.php
 *
 * All WooCommerce hooks, filters, and fragment callbacks.
 *
 * RULE: If WooCommerce already does it, use the WC hook/filter.
 *       Only extend here — never replace business logic.
 */

defined( 'ABSPATH' ) || exit;

// -----------------------------------------------------------------
// 1. Replace default WC content wrappers with our own
// -----------------------------------------------------------------
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'pemu_wc_wrapper_start', 10 );
function pemu_wc_wrapper_start(): void {
	echo '<main id="main-content" class="pemu-wc-main min-h-screen">';
}

add_action( 'woocommerce_after_main_content', 'pemu_wc_wrapper_end', 10 );
function pemu_wc_wrapper_end(): void {
	echo '</main>';
}

// -----------------------------------------------------------------
// 2. Move breadcrumb above product title on single product
// -----------------------------------------------------------------
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'woocommerce_before_single_product', 'woocommerce_breadcrumb', 5 );

// -----------------------------------------------------------------
// 3. Default loop columns and products per page
// -----------------------------------------------------------------
add_filter( 'loop_shop_columns', fn() => 4 );
add_filter( 'loop_shop_per_page', fn() => 12 );

// -----------------------------------------------------------------
// 4. WhatsApp button after Add to Cart on single product page
// -----------------------------------------------------------------
add_action( 'woocommerce_after_add_to_cart_button', 'pemu_product_whatsapp_button' );
function pemu_product_whatsapp_button(): void {
	global $product;
	if ( ! $product instanceof WC_Product ) {
		return;
	}
	$message = sprintf(
		"Hi Pemu Health! 👋\n\nI'd like to order:\n\n🛒 *%s*\n💰 Price: %s\n🔗 %s\n\nPlease confirm availability and delivery. Thank you!",
		$product->get_name(),
		strip_tags( $product->get_price_html() ),
		get_permalink()
	);
	$url = pemu_whatsapp_url( $message );
	?>
<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"
    class="pemu-wa-btn-product flex items-center justify-center gap-2 w-full mt-3 py-3 px-6 rounded-xl border-2 border-[#25D366] text-[#25D366] font-semibold hover:bg-[#25D366] hover:text-white transition-all duration-200">
    <?php echo pemu_icon( 'whatsapp', [ 'class' => 'w-5 h-5 flex-shrink-0' ] ); ?>
    <?php esc_html_e( 'Order via WhatsApp', 'pemu' ); ?>
</a>
<?php
}

// -----------------------------------------------------------------
// 5. WhatsApp icon on product cards in loop
// -----------------------------------------------------------------
add_action( 'woocommerce_after_shop_loop_item', 'pemu_loop_whatsapp_button', 20 );
function pemu_loop_whatsapp_button(): void {
	global $product;
	if ( ! $product instanceof WC_Product ) {
		return;
	}
	$message = sprintf(
		"Hi Pemu Health! 👋 I'd like to order: *%s*\n%s",
		$product->get_name(),
		get_permalink()
	);
	$url = pemu_whatsapp_url( $message );
	?>
<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"
    class="pemu-loop-wa-btn absolute bottom-3 right-3 flex items-center justify-center w-9 h-9 rounded-full bg-[#25D366] text-white shadow-md hover:scale-110 transition-transform duration-150 z-10"
    aria-label="<?php echo esc_attr( sprintf( __( 'Order %s via WhatsApp', 'pemu' ), $product->get_name() ) ); ?>">
    <?php echo pemu_icon( 'whatsapp', [ 'class' => 'w-4 h-4', 'viewBox' => '0 0 24 24' ] ); ?>
</a>
<?php
}

// -----------------------------------------------------------------
// 6. Cart fragments — header cart count badge + mini cart content
// -----------------------------------------------------------------
add_filter( 'woocommerce_add_to_cart_fragments', 'pemu_cart_fragments' );
function pemu_cart_fragments( array $fragments ): array {
	// Cart count badge.
	$count = WC()->cart->get_cart_contents_count();
	ob_start();
	?>
<span class="pemu-cart-count<?php echo 0 === $count ? ' hidden' : ''; ?>"
    aria-label="<?php echo esc_attr( sprintf( _n( '%d item in cart', '%d items in cart', $count, 'pemu' ), $count ) ); ?>">
    <?php echo esc_html( $count ); ?>
</span>
<?php
	$fragments['.pemu-cart-count'] = ob_get_clean();

	// Mini cart drawer content.
	ob_start();
	echo '<div class="pemu-mini-cart-inner">';
	woocommerce_mini_cart();
	echo '</div>';
	$fragments['.pemu-mini-cart-inner'] = ob_get_clean();

	return $fragments;
}

// -----------------------------------------------------------------
// 7. Breadcrumb styling
// -----------------------------------------------------------------
add_filter( 'woocommerce_breadcrumb_defaults', function( array $defaults ): array {
	$defaults['delimiter']   = '<span class="mx-2 text-[var(--color-text-muted)] select-none">/</span>';
	$defaults['wrap_before'] = '<nav aria-label="' . esc_attr__( 'Breadcrumb', 'pemu' ) . '" class="pemu-breadcrumb py-3"><ol class="flex flex-wrap items-center gap-1 text-sm text-[var(--color-text-muted)]">';
	$defaults['wrap_after']  = '</ol></nav>';
	$defaults['before']      = '<li class="breadcrumb-item">';
	$defaults['after']       = '</li>';
	return $defaults;
} );

// -----------------------------------------------------------------
// 8. Sale badge text and markup
// -----------------------------------------------------------------
add_filter( 'woocommerce_sale_flash', function( string $html, \WP_Post $post, WC_Product $product ): string {
	$percentage = '';
	if ( $product->get_regular_price() && $product->get_sale_price() ) {
		$regular = (float) $product->get_regular_price();
		$sale    = (float) $product->get_sale_price();
		if ( $regular > 0 ) {
			$percentage = ' -' . round( ( ( $regular - $sale ) / $regular ) * 100 ) . '%';
		}
	}
	return '<span class="pemu-sale-badge absolute top-2 left-2 z-10 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-red-500 text-white tracking-wide">'
		. esc_html__( 'SALE', 'pemu' ) . esc_html( $percentage )
		. '</span>';
}, 10, 3 );

// -----------------------------------------------------------------
// 9. Disable WC default sidebar (we build our own filter panel)
// -----------------------------------------------------------------
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// -----------------------------------------------------------------
// 10. Custom "No products found" message
// -----------------------------------------------------------------
add_filter( 'woocommerce_no_products_found_text', function(): string {
	return wp_kses(
		sprintf(
			/* translators: %s: shop URL */
			__( 'No products found matching your selection. <a href="%s" class="text-brand-green underline">Browse all products →</a>', 'pemu' ),
			esc_url( wc_get_page_permalink( 'shop' ) )
		),
		[ 'a' => [ 'href' => [], 'class' => [] ] ]
	);
} );

// -----------------------------------------------------------------
// 11. WhatsApp CTA on cart page (above proceed to checkout)
// -----------------------------------------------------------------
add_action( 'woocommerce_proceed_to_checkout', 'pemu_cart_whatsapp_cta', 5 );
function pemu_cart_whatsapp_cta(): void {
	if ( ! function_exists( 'pemu_cart_whatsapp_message' ) ) {
		return;
	}
	$url = pemu_whatsapp_url( pemu_cart_whatsapp_message() );
	?>
<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"
    class="flex items-center justify-center gap-2 w-full mb-3 py-3 px-6 rounded-xl border-2 border-[#25D366] text-[#25D366] font-semibold hover:bg-[#25D366] hover:text-white transition-all duration-200 text-center">
    <?php echo pemu_icon( 'whatsapp', [ 'class' => 'w-5 h-5 flex-shrink-0' ] ); ?>
    <?php esc_html_e( 'Order via WhatsApp', 'pemu' ); ?>
</a>
<?php
}

// -----------------------------------------------------------------
// 12. Thank you page — WhatsApp tracking CTA
// -----------------------------------------------------------------
add_action( 'woocommerce_thankyou', 'pemu_thankyou_whatsapp_cta', 15 );
function pemu_thankyou_whatsapp_cta( int $order_id ): void {
	$order = wc_get_order( $order_id );
	if ( ! $order instanceof WC_Order ) {
		return;
	}
	$message = sprintf(
		"Hi Pemu Health! 👋 I just placed Order #%s. Please confirm and update me on delivery. Thank you!",
		$order->get_order_number()
	);
	$url = pemu_whatsapp_url( $message );
	?>
<div class="pemu-thankyou-wa mt-8 p-6 rounded-2xl border border-[#25D366]/30 bg-[#25D366]/5 text-center">
    <p class="text-[var(--color-text)] font-medium mb-3">
        <?php esc_html_e( 'Get order updates directly on WhatsApp', 'pemu' ); ?>
    </p>
    <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"
        class="inline-flex items-center justify-center gap-2 py-3 px-8 rounded-xl bg-[#25D366] text-white font-bold hover:bg-[#1db954] transition-colors duration-200">
        <?php echo pemu_icon( 'whatsapp', [ 'class' => 'w-5 h-5 flex-shrink-0' ] ); ?>
        <?php esc_html_e( 'Track Order via WhatsApp', 'pemu' ); ?>
    </a>
</div>
<?php
}

// -----------------------------------------------------------------
// 13. Style checkout form fields with Tailwind classes
// -----------------------------------------------------------------
add_filter( 'woocommerce_form_field_args', 'pemu_style_checkout_fields', 10, 3 );
function pemu_style_checkout_fields( array $args, string $key, mixed $value ): array {
	$args['class']       = [ 'form-row', 'pemu-field-wrap' ];
	$args['input_class'] = [ 'pemu-input' ];
	$args['label_class'] = [ 'pemu-label' ];
	return $args;
}

// -----------------------------------------------------------------
// 14. Add Kenyan +254 hint and inputmode to phone field
// -----------------------------------------------------------------
add_filter( 'woocommerce_checkout_fields', 'pemu_checkout_field_enhancements' );
function pemu_checkout_field_enhancements( array $fields ): array {
	if ( isset( $fields['billing']['billing_phone'] ) ) {
		$fields['billing']['billing_phone']['placeholder'] = '0712 345 678';
		$fields['billing']['billing_phone']['custom_attributes'] = [
			'inputmode'    => 'tel',
			'autocomplete' => 'tel',
			'pattern'      => '[0-9+ ()-]{7,20}',
		];
	}
	if ( isset( $fields['billing']['billing_email'] ) ) {
		$fields['billing']['billing_email']['custom_attributes'] = [
			'inputmode'    => 'email',
			'autocomplete' => 'email',
		];
	}
	return $fields;
}

// -----------------------------------------------------------------
// 15. Trust badges below payment on checkout
// -----------------------------------------------------------------
add_action( 'woocommerce_review_order_after_payment', 'pemu_checkout_trust_badges' );
function pemu_checkout_trust_badges(): void {
	get_template_part( 'template-parts/components/trust-badges' );
}

// -----------------------------------------------------------------
// 16. Remove default WC "add to cart" text replacement
//     (we use our own product card template)
// -----------------------------------------------------------------
add_filter( 'woocommerce_loop_add_to_cart_args', function( array $args ): array {
	$args['class'] = implode( ' ', array_filter( [
		'pemu-loop-atc-btn',
		isset( $args['class'] ) ? $args['class'] : '',
	] ) );
	return $args;
} );

// -----------------------------------------------------------------
// 17. Pagination — ensure it's output after loop
// -----------------------------------------------------------------
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

// -----------------------------------------------------------------
// 18. Rating HTML — ensure star icons use our classes
// -----------------------------------------------------------------
add_filter( 'woocommerce_product_get_rating_html', 'pemu_rating_html', 10, 3 );
function pemu_rating_html( string $html, float $rating, int $count ): string {
	if ( 0 === $count ) {
		return '<span class="pemu-star-rating text-[var(--color-text-muted)] text-xs">' . esc_html__( 'No reviews', 'pemu' ) . '</span>';
	}
	$stars = '';
	for ( $i = 1; $i <= 5; $i++ ) {
		$filled  = $i <= $rating;
		$half    = ! $filled && ( $i - 0.5 ) <= $rating;
		$class   = $filled ? 'text-amber-400' : ( $half ? 'text-amber-300' : 'text-[var(--color-border)]' );
		$stars  .= '<span class="' . esc_attr( $class ) . '">' . pemu_icon( 'star-filled', [ 'class' => 'w-3.5 h-3.5 inline' ] ) . '</span>';
	}
	return '<span class="pemu-star-rating flex items-center gap-0.5" role="img" aria-label="' . esc_attr( sprintf( __( 'Rated %s out of 5', 'pemu' ), $rating ) ) . '">'
		. $stars
		. '<span class="ml-1 text-xs text-[var(--color-text-muted)]">(' . esc_html( $count ) . ')</span>'
		. '</span>';
}

// -----------------------------------------------------------------
// 19. Defer WooCommerce scripts that don't need to be blocking
// -----------------------------------------------------------------
add_filter( 'script_loader_tag', 'pemu_wc_defer_scripts', 10, 2 );
function pemu_wc_defer_scripts( string $tag, string $handle ): string {
	// These WC scripts are safe to defer on non-checkout pages.
	$deferrable = [ 'wc-add-to-cart', 'wc-cart-fragments' ];
	if ( in_array( $handle, $deferrable, true ) && ! is_checkout() ) {
		return str_replace( ' src=', ' defer src=', $tag );
	}
	return $tag;
}

// -----------------------------------------------------------------
// 20. Stock scarcity indicator in product loop
// -----------------------------------------------------------------
add_action( 'woocommerce_after_shop_loop_item_title', 'pemu_loop_stock_indicator', 15 );
function pemu_loop_stock_indicator(): void {
	global $product;
	if ( ! $product instanceof WC_Product ) {
		return;
	}
	$indicator = pemu_stock_indicator( $product );
	if ( ! empty( $indicator ) && in_array( $indicator['class'], [ 'text-red-500', 'text-amber-500' ], true ) ) {
		echo '<span class="block text-xs mt-0.5 ' . esc_attr( $indicator['class'] ) . '">'
			. esc_html( $indicator['label'] )
			. '</span>';
	}
}

// add_action( 'after_setup_theme', function() {

//     remove_theme_support( 'wc-product-gallery-zoom' );
//     remove_theme_support( 'wc-product-gallery-lightbox' );
//     remove_theme_support( 'wc-product-gallery-slider' );

// }, 100 );
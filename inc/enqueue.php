<?php
/**
 * Pemu Health Supplements — inc/enqueue.php
 *
 * Asset enqueueing — conditional loading per page type.
 * WooCommerce's own scripts are never overridden here.
 */

defined( 'ABSPATH' ) || exit;

// -----------------------------------------------------------------
// Main asset enqueueing
// -----------------------------------------------------------------
add_action( 'wp_enqueue_scripts', 'pemu_enqueue_assets' );
function pemu_enqueue_assets(): void {
	$ver = wp_get_theme()->get( 'Version' );

	// 1. Theme-toggle script — INLINE in <head> to prevent FOUC.
	//    Registered with no src, script added inline immediately.
	$toggle_path = get_theme_file_path( 'assets/js/theme-toggle.js' );
	if ( file_exists( $toggle_path ) ) {
		wp_register_script( 'pemu-theme-toggle', '' );
		wp_enqueue_script( 'pemu-theme-toggle' );
		wp_add_inline_script( 'pemu-theme-toggle', file_get_contents( $toggle_path ) );
	}

	// 2. Main stylesheet (Tailwind compiled output).
	wp_enqueue_style(
		'pemu-main',
		get_theme_file_uri( 'assets/css/main.css' ),
		[],
		$ver
	);

	// 3. Alpine.js — deferred, footer.
	wp_enqueue_script(
		'alpinejs',
		get_theme_file_uri( 'assets/js/vendor/alpine.min.js' ),
		[],
		'3.13.10',
		[ 'strategy' => 'defer', 'in_footer' => true ]
	);

	// 4. App JS — deferred, footer.
	wp_enqueue_script(
		'pemu-app',
		get_theme_file_uri( 'assets/js/app.js' ),
		[ 'alpinejs' ],
		$ver,
		[ 'strategy' => 'defer', 'in_footer' => true ]
	);

	// Pass PHP data to JS.
	wp_localize_script( 'pemu-app', 'pemuData', [
		'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
		'homeUrl'        => home_url( '/' ),
		'shopUrl'        => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ),
		'cartUrl'        => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart' ),
		'checkoutUrl'    => function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/checkout' ),
		'nonce'          => wp_create_nonce( 'pemu-nonce' ),
		'whatsappNumber' => get_option( 'pemu_whatsapp_number', '254700000000' ),
		'currency'       => function_exists( 'get_woocommerce_currency' ) ? get_woocommerce_currency() : 'KES',
		'i18n'           => [
			'addedToCart'  => __( 'Added to cart', 'pemu' ),
			'removing'     => __( 'Removing…', 'pemu' ),
			'cartEmpty'    => __( 'Your cart is empty', 'pemu' ),
			'viewCart'     => __( 'View Cart', 'pemu' ),
			'checkout'     => __( 'Checkout', 'pemu' ),
		],
	] );

	// 5. WooCommerce pages — our cart drawer JS only.
	if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
		wp_enqueue_script(
			'pemu-cart',
			get_theme_file_uri( 'assets/js/cart.js' ),
			[ 'jquery', 'wc-cart-fragments', 'alpinejs' ],
			$ver,
			[ 'in_footer' => true ]
		);
	}

	// 6. Product gallery — single product pages only.
	if ( function_exists( 'is_product' ) && is_product() ) {
		wp_enqueue_script(
			'pemu-product-gallery',
			get_theme_file_uri( 'assets/js/product-gallery.js' ),
			[ 'alpinejs' ],
			$ver,
			[ 'strategy' => 'defer', 'in_footer' => true ]
		);
	}

	// 7. Shop filters — archive / category pages only.
	if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_category() || is_product_tag() ) ) {
		wp_enqueue_script(
			'pemu-shop-filters',
			get_theme_file_uri( 'assets/js/shop-filters.js' ),
			[ 'alpinejs' ],
			$ver,
			[ 'strategy' => 'defer', 'in_footer' => true ]
		);
	}

	// 8. Checkout enhancements — checkout page only.
	if ( function_exists( 'is_checkout' ) && is_checkout() ) {
		wp_enqueue_script(
			'pemu-checkout',
			get_theme_file_uri( 'assets/js/checkout.js' ),
			[ 'jquery', 'wc-checkout', 'alpinejs' ],
			$ver,
			[ 'in_footer' => true ]
		);
	}

	// 9. Comment / review reply script (native WP, only where needed).
	if ( is_singular() && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

// -----------------------------------------------------------------
// Remove WooCommerce's own CSS (Tailwind handles all styling)
// -----------------------------------------------------------------
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// -----------------------------------------------------------------
// Inline the theme-toggle script in <head> before any paint
// (separate hook to guarantee ordering)
// -----------------------------------------------------------------
add_action( 'wp_head', 'pemu_inline_theme_toggle', 1 );
function pemu_inline_theme_toggle(): void {
	$path = get_theme_file_path( 'assets/js/theme-toggle.js' );
	if ( ! file_exists( $path ) ) {
		return;
	}
	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	echo '<script id="pemu-theme-toggle">' . file_get_contents( $path ) . '</script>' . "\n";
}

// -----------------------------------------------------------------
// Preload critical resources
// -----------------------------------------------------------------
add_action( 'wp_head', 'pemu_preload_hints', 2 );
function pemu_preload_hints(): void {
	// Preload main CSS.
	echo '<link rel="preload" href="' . esc_url( get_theme_file_uri( 'assets/css/main.css' ) ) . '" as="style">' . "\n";

	// Preload hero image on front page.
	if ( is_front_page() ) {
		$hero_image = get_theme_mod( 'pemu_hero_image', '' );
		if ( $hero_image ) {
			echo '<link rel="preload" href="' . esc_url( $hero_image ) . '" as="image" fetchpriority="high">' . "\n";
		}
	}

	// Preload product main image on single product.
	if ( function_exists( 'is_product' ) && is_product() ) {
		global $product;
		if ( $product instanceof WC_Product ) {
			$img_url = wp_get_attachment_image_url( $product->get_image_id(), 'pemu-product-single' );
			if ( $img_url ) {
				echo '<link rel="preload" href="' . esc_url( $img_url ) . '" as="image" fetchpriority="high">' . "\n";
			}
		}
	}

	// DNS prefetch.
	echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
	echo '<link rel="dns-prefetch" href="//wa.me">' . "\n";
	echo '<link rel="dns-prefetch" href="//fonts.gstatic.com" crossorigin>' . "\n";
}

// -----------------------------------------------------------------
// Admin: show outdated WooCommerce templates notice
// -----------------------------------------------------------------
// add_action( 'admin_notices', 'pemu_wc_template_notice' );
function pemu_wc_template_notice(): void {
	if ( ! function_exists( 'wc_get_template' ) || ! current_user_can( 'manage_woocommerce' ) ) {
		return;
	}
	// WooCommerce exposes this method for detecting outdated overrides.
	if ( function_exists( 'WC' ) ) {
		$outdated = WC()->theme_support->get_outdated_templates();
		if ( ! empty( $outdated ) ) {
			echo '<div class="notice notice-warning"><p>';
			printf(
				/* translators: %s: WooCommerce system status URL */
				esc_html__( 'Pemu Theme: %d WooCommerce template override(s) are outdated. Please update them.', 'pemu' ),
				count( $outdated )
			);
			echo '</p></div>';
		}
	}
}
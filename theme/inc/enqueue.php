<?php
/**
 * Pemu — inc/enqueue.php
 * Alpine.js loaded via CDN in header.php (core + persist + mask plugins).
 * Only theme-specific JS assets are enqueued here.
 */
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'pemu_enqueue_assets' );
function pemu_enqueue_assets(): void {
	$ver = wp_get_theme()->get( 'Version' );


	/* 1. Theme-toggle — INLINE in <head> to prevent FOUC (loaded via wp_head hook) */
	wp_enqueue_style( 'pemu-css', get_stylesheet_uri(), array(), $ver );

	wp_enqueue_style(
        'pemu-google-fonts',
        'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700;800&family=Nunito:wght@400;600;700&display=swap',
        array(),
        null
    );
	/* Single unified JS file — all Alpine components + WC bridge */
	wp_enqueue_script( 'pemu-js', get_template_directory_uri() . '/js/script.min.js', array('jquery'), $ver, true );

	wp_localize_script( 'pemu-js', 'pemuData', [
		'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
		'wcAjaxUrl'   => class_exists( 'WC_AJAX' ) ? WC_AJAX::get_endpoint( '%%endpoint%%' ) : '',
		'homeUrl'     => home_url( '/' ),
		'shopUrl'     => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ),
		'cartUrl'     => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart' ),
		'checkoutUrl' => function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/checkout' ),
		'nonce'       => wp_create_nonce( 'pemu-nonce' ),
		'wcNonce'     => wp_create_nonce( 'woocommerce-cart' ),
		'currency'    => function_exists( 'get_woocommerce_currency' ) ? get_woocommerce_currency() : 'KES',
		'cartCount'   => ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0,
	] );

	if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() || is_front_page() ) ) {
		wp_enqueue_script( 'wc-cart-fragments' );
	}

	if ( is_singular() && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

function pemu_font_preconnect() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action('wp_head', 'pemu_font_preconnect', 1);

/* Remove WC default CSS — Tailwind CDN handles all styling */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/* Inline theme-toggle in <head> before any paint (for FOUC prevention) */
add_action( 'wp_head', 'pemu_inline_theme_toggle', 1 );
function pemu_inline_theme_toggle(): void {
	$path = get_theme_file_path( 'js/script.min.js' );
	if ( file_exists( $path ) ) {
		$content = file_get_contents( $path );
		if ( preg_match( '#/\*\s*THEME_TOGGLE_START\s*\*/(.*?)/\*\s*THEME_TOGGLE_END\s*\*/#s', $content, $matches ) ) {
			echo '<script id="pemu-theme-toggle">' . trim( $matches[1] ) . '</script>' . "\n"; // phpcs:ignore
		}
	}
}

/* Admin notice — outdated templates (safe version) */
add_action( 'admin_notices', 'pemu_wc_template_notice' );
function pemu_wc_template_notice(): void {
	if ( ! current_user_can( 'manage_woocommerce' ) || ! function_exists( 'WC' ) ) return;
	if ( ! class_exists( 'WC_Admin_Status' ) ) return;
	$outdated = [];
	try {
		$core_templates = WC_Admin_Status::scan_template_files( WC()->plugin_path() . '/templates/' );
		foreach ( $core_templates as $file ) {
			$theme_file = locate_template( [ 'woocommerce/' . $file, $file ] );
			if ( ! $theme_file ) continue;
			$core_version  = WC_Admin_Status::get_file_version( WC()->plugin_path() . '/templates/' . $file );
			$theme_version = WC_Admin_Status::get_file_version( $theme_file );
			if ( $core_version && $theme_version && version_compare( $theme_version, $core_version, '<' ) ) {
				$outdated[] = $file;
			}
		}
	} catch ( \Throwable $e ) { return; }
	if ( ! empty( $outdated ) ) {
		echo '<div class="notice notice-warning"><p>' . esc_html( sprintf( __( 'Pemu Theme: %d WooCommerce template override(s) may be outdated.', 'pemu' ), count( $outdated ) ) ) . '</p></div>';
	}
}
<?php
/**
 * Pemu Health Supplements — inc/helpers.php
 *
 * Utility functions used across the theme.
 * No WordPress hooks registered here — this file is pure functions.
 */

defined( 'ABSPATH' ) || exit;

// -----------------------------------------------------------------
// SVG Icon Helper
// -----------------------------------------------------------------
/**
 * Returns an inline SVG icon string.
 *
 * @param string $name   Icon name (see switch below).
 * @param array  $attrs  Extra HTML attributes e.g. ['class' => 'w-5 h-5'].
 * @return string        SVG markup.
 */
function pemu_icon( string $name, array $attrs = [] ): string {
	$default_attrs = [
		'class'       => 'w-5 h-5',
		'aria-hidden' => 'true',
		'focusable'   => 'false',
		'fill'        => 'none',
		'stroke'      => 'currentColor',
		'viewBox'     => '0 0 24 24',
		'xmlns'       => 'http://www.w3.org/2000/svg',
	];
	$attrs = array_merge( $default_attrs, $attrs );

	$attr_string = '';
	foreach ( $attrs as $key => $value ) {
		$attr_string .= ' ' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
	}

	$paths = [
		'sun'          => '<circle cx="12" cy="12" r="5" stroke-width="2"/><line x1="12" y1="1" x2="12" y2="3" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="21" x2="12" y2="23" stroke-width="2" stroke-linecap="round"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64" stroke-width="2" stroke-linecap="round"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78" stroke-width="2" stroke-linecap="round"/><line x1="1" y1="12" x2="3" y2="12" stroke-width="2" stroke-linecap="round"/><line x1="21" y1="12" x2="23" y2="12" stroke-width="2" stroke-linecap="round"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36" stroke-width="2" stroke-linecap="round"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22" stroke-width="2" stroke-linecap="round"/>',
		'moon'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>',
		'monitor'      => '<rect x="2" y="3" width="20" height="14" rx="2" ry="2" stroke-width="2"/><line x1="8" y1="21" x2="16" y2="21" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="17" x2="12" y2="21" stroke-width="2" stroke-linecap="round"/>',
		'cart'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>',
		'search'       => '<circle cx="11" cy="11" r="8" stroke-width="2"/><path d="m21 21-4.35-4.35" stroke-width="2" stroke-linecap="round"/>',
		'menu'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>',
		'close'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>',
		'chevron-down' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>',
		'chevron-right'=> '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 18l6-6-6-6"/>',
		'chevron-left' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 18l-6-6 6-6"/>',
		'star'         => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" stroke-width="1.5" stroke-linejoin="round"/>',
		'star-filled'  => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" fill="currentColor" stroke-width="0"/>',
		'check'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L9 17l-5-5"/>',
		'check-circle' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>',
		'truck'        => '<rect x="1" y="3" width="15" height="13" rx="1" stroke-width="2"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8" stroke-width="2" stroke-linejoin="round"/><circle cx="5.5" cy="18.5" r="2.5" stroke-width="2"/><circle cx="18.5" cy="18.5" r="2.5" stroke-width="2"/>',
		'shield'       => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
		'award'        => '<circle cx="12" cy="8" r="6" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.21 13.89L7 23l5-3 5 3-1.21-9.12"/>',
		'zap'          => '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" stroke-linejoin="round" stroke-width="2"/>',
		'heart'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>',
		'eye'          => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3" stroke-width="2"/>',
		'user'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4" stroke-width="2"/>',
		'home'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>',
		'package'      => '<line x1="16.5" y1="9.4" x2="7.5" y2="4.21" stroke-width="2" stroke-linecap="round"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/><line x1="12" y1="22.08" x2="12" y2="12" stroke-width="2" stroke-linecap="round"/>',
		'arrow-right'  => '<line x1="5" y1="12" x2="19" y2="12" stroke-width="2" stroke-linecap="round"/><polyline points="12 5 19 12 12 19" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>',
		'arrow-left'   => '<line x1="19" y1="12" x2="5" y2="12" stroke-width="2" stroke-linecap="round"/><polyline points="12 19 5 12 12 5" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>',
		'plus'         => '<line x1="12" y1="5" x2="12" y2="19" stroke-width="2" stroke-linecap="round"/><line x1="5" y1="12" x2="19" y2="12" stroke-width="2" stroke-linecap="round"/>',
		'minus'        => '<line x1="5" y1="12" x2="19" y2="12" stroke-width="2" stroke-linecap="round"/>',
		'trash'        => '<polyline points="3 6 5 6 21 6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/><line x1="10" y1="11" x2="10" y2="17" stroke-width="2" stroke-linecap="round"/><line x1="14" y1="11" x2="14" y2="17" stroke-width="2" stroke-linecap="round"/>',
		'whatsapp'     => '<path fill="currentColor" stroke="none" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>',
		'tiktok'       => '<path fill="currentColor" stroke="none" d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.34 6.34 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.27 8.27 0 004.84 1.55V6.79a4.85 4.85 0 01-1.07-.1z"/>',
		'instagram'    => '<rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke-width="2"/><path stroke-width="2" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5" stroke-width="2" stroke-linecap="round"/>',
		'facebook'     => '<path fill="currentColor" stroke="none" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>',
		'map-pin'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3" stroke-width="2"/>',
		'phone'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.49 12a19.79 19.79 0 01-3.07-8.67A2 2 0 013.4 1.26h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.91 8.1a16 16 0 006 6l.62-.62a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>',
		'mail'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>',
		'refresh'      => '<polyline points="23 4 23 10 17 10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/>',
		'filter'       => '<polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" stroke-linejoin="round" stroke-width="2"/>',
		'grid'         => '<rect x="3" y="3" width="7" height="7" stroke-width="2"/><rect x="14" y="3" width="7" height="7" stroke-width="2"/><rect x="14" y="14" width="7" height="7" stroke-width="2"/><rect x="3" y="14" width="7" height="7" stroke-width="2"/>',
		'list'         => '<line x1="8" y1="6" x2="21" y2="6" stroke-width="2" stroke-linecap="round"/><line x1="8" y1="12" x2="21" y2="12" stroke-width="2" stroke-linecap="round"/><line x1="8" y1="18" x2="21" y2="18" stroke-width="2" stroke-linecap="round"/><line x1="3" y1="6" x2="3.01" y2="6" stroke-width="2" stroke-linecap="round"/><line x1="3" y1="12" x2="3.01" y2="12" stroke-width="2" stroke-linecap="round"/><line x1="3" y1="18" x2="3.01" y2="18" stroke-width="2" stroke-linecap="round"/>',
		'info'         => '<circle cx="12" cy="12" r="10" stroke-width="2"/><line x1="12" y1="16" x2="12" y2="12" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="8" x2="12.01" y2="8" stroke-width="2" stroke-linecap="round"/>',
		'alert'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="17" x2="12.01" y2="17" stroke-width="2" stroke-linecap="round"/>',
		'lock'         => '<rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11V7a5 5 0 0110 0v4"/>',
		'credit-card'  => '<rect x="1" y="4" width="22" height="16" rx="2" ry="2" stroke-width="2"/><line x1="1" y1="10" x2="23" y2="10" stroke-width="2"/>',
		'tag'          => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7" stroke-width="2" stroke-linecap="round"/>',
		'share'        => '<circle cx="18" cy="5" r="3" stroke-width="2"/><circle cx="6" cy="12" r="3" stroke-width="2"/><circle cx="18" cy="19" r="3" stroke-width="2"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49" stroke-width="2" stroke-linecap="round"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49" stroke-width="2" stroke-linecap="round"/>',
	];

	$path = $paths[ $name ] ?? '<circle cx="12" cy="12" r="10" stroke-width="2"/>';

	return sprintf( '<svg%s>%s</svg>', $attr_string, $path );
}

// -----------------------------------------------------------------
// CSS Class Builder
// -----------------------------------------------------------------
/**
 * Conditionally join CSS classes.
 *
 * @param array $classes Map of class => condition (true|false).
 * @return string
 */
function pemu_classes( array $classes ): string {
	return implode( ' ', array_keys( array_filter( $classes ) ) );
}

// -----------------------------------------------------------------
// Vite Asset Helper
// -----------------------------------------------------------------
/**
 * Returns the correct asset URL, supporting Vite manifest for cache-busting.
 *
 * @param string $asset  Relative path from /assets/.
 * @return string        Full URL to asset.
 */
function pemu_asset( string $asset ): string {
	$manifest_path = get_theme_file_path( 'assets/.vite/manifest.json' );

	if ( file_exists( $manifest_path ) ) {
		static $manifest = null;
		if ( null === $manifest ) {
			$manifest = json_decode( file_get_contents( $manifest_path ), true ) ?? [];
		}
		// Vite manifest keys are relative to the src directory
		$key = 'src/' . ltrim( $asset, '/' );
		if ( isset( $manifest[ $key ]['file'] ) ) {
			return get_theme_file_uri( 'assets/' . $manifest[ $key ]['file'] );
		}
	}

	return get_theme_file_uri( 'assets/' . ltrim( $asset, '/' ) );
}

// -----------------------------------------------------------------
// Breadcrumb Helper
// -----------------------------------------------------------------
/**
 * Returns an array of breadcrumb items for the current page.
 * Used as fallback when WooCommerce breadcrumb is not available.
 *
 * @return array [ ['label' => string, 'url' => string|null] ]
 */
function pemu_get_breadcrumbs(): array {
	$crumbs = [ [ 'label' => __( 'Home', 'pemu' ), 'url' => home_url( '/' ) ] ];

	if ( is_single() || is_page() ) {
		$crumbs[] = [ 'label' => get_the_title(), 'url' => null ];
	} elseif ( is_search() ) {
		$crumbs[] = [ 'label' => sprintf( __( 'Search: %s', 'pemu' ), get_search_query() ), 'url' => null ];
	} elseif ( is_404() ) {
		$crumbs[] = [ 'label' => __( '404 — Not Found', 'pemu' ), 'url' => null ];
	}

	return $crumbs;
}

// -----------------------------------------------------------------
// Stock Level Indicator
// -----------------------------------------------------------------
/**
 * Returns stock urgency label and class for a product.
 *
 * @param WC_Product $product
 * @return array [ 'label' => string, 'class' => string ] or empty array.
 */
function pemu_stock_indicator( WC_Product $product ): array {
	if ( ! $product->managing_stock() ) {
		return [];
	}
	$qty = $product->get_stock_quantity();
	if ( null === $qty ) {
		return [];
	}
	if ( $qty <= 0 ) {
		return [ 'label' => __( 'Out of Stock', 'pemu' ), 'class' => 'text-red-500' ];
	}
	if ( $qty <= 5 ) {
		return [ 'label' => sprintf( __( 'Only %d left!', 'pemu' ), $qty ), 'class' => 'text-amber-500' ];
	}
	if ( $qty <= 10 ) {
		return [ 'label' => __( 'Low Stock', 'pemu' ), 'class' => 'text-amber-400' ];
	}
	return [ 'label' => __( 'In Stock', 'pemu' ), 'class' => 'text-brand-green' ];
}

// -----------------------------------------------------------------
// Sanitize WhatsApp Number
// -----------------------------------------------------------------
/**
 * Strips non-numeric characters from a phone number.
 *
 * @param string $number
 * @return string
 */
function pemu_sanitize_phone( string $number ): string {
	return preg_replace( '/[^0-9]/', '', $number );
}

// -----------------------------------------------------------------
// Template Part with Args (WP 5.5+)
// -----------------------------------------------------------------
/**
 * Wrapper for get_template_part() that passes args cleanly.
 *
 * @param string $slug
 * @param string|null $name
 * @param array $args
 */
function pemu_get_part( string $slug, ?string $name = null, array $args = [] ): void {
	get_template_part( $slug, $name, $args );
}

// -----------------------------------------------------------------
// Format price in KES
// -----------------------------------------------------------------
/**
 * Returns formatted price string in KES.
 *
 * @param float|int $amount
 * @return string
 */
function pemu_format_price( $amount ): string {
	return 'KES ' . number_format( (float) $amount, 0, '.', ',' );
}

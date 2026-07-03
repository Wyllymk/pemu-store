<?php
/**
 * Pemu Health Supplements — inc/setup.php
 *
 * Theme supports declaration, nav menu registration, widget areas,
 * and custom image sizes. No business logic here — purely WordPress setup.
 */

defined( 'ABSPATH' ) || exit;

// -----------------------------------------------------------------
// Theme Setup
// -----------------------------------------------------------------
add_action( 'after_setup_theme', 'pemu_theme_setup' );
function pemu_theme_setup(): void {
	// Load theme text domain.
	load_theme_textdomain( 'pemu', get_theme_file_path( 'languages' ) );

	// --- WooCommerce Support (MUST be declared before WC initialises) ---
	add_theme_support( 'woocommerce', [
		'thumbnail_image_width'         => 600,
		'single_image_width'            => 900,
		'product_grid'                  => [
			'default_rows'    => 4,
			'min_rows'        => 2,
			'default_columns' => 4,
			'min_columns'     => 2,
			'max_columns'     => 6,
		],
	] );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// --- Standard WordPress Supports ---
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	] );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );

	// Editor colour palette matching brand tokens.
	add_theme_support( 'editor-color-palette', [
		[ 'name' => 'Brand Green',  'slug' => 'brand-green', 'color' => '#6DB33F' ],
		[ 'name' => 'Brand Navy',   'slug' => 'brand-navy',  'color' => '#1E4D6B' ],
		[ 'name' => 'Accent Light', 'slug' => 'accent-light','color' => '#F0F7E8' ],
	] );

	// --- Navigation Menus ---
	register_nav_menus( [
		'primary'  => __( 'Primary Navigation', 'pemu' ),
		'footer-1' => __( 'Footer Column 1', 'pemu' ),
		'footer-2' => __( 'Footer Column 2', 'pemu' ),
		'mobile'   => __( 'Mobile Bottom Nav', 'pemu' ),
	] );

	// --- Custom Image Sizes ---
	add_image_size( 'pemu-product-card',   600, 600, true );
	add_image_size( 'pemu-product-single', 900, 900, true );
	add_image_size( 'pemu-category-thumb', 400, 300, true );
	add_image_size( 'pemu-hero',          1920, 900, true );
	add_image_size( 'pemu-og',            1200, 630, true );
}

// -----------------------------------------------------------------
// Widget Areas
// -----------------------------------------------------------------
add_action( 'widgets_init', 'pemu_register_sidebars' );
function pemu_register_sidebars(): void {
	$default = [
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title text-sm font-bold uppercase tracking-widest mb-3 text-slate-800 dark:text-slate-200">',
		'after_title'   => '</h3>',
	];

	register_sidebar( array_merge( $default, [
		'name'        => __( 'Shop Filters Sidebar', 'pemu' ),
		'id'          => 'shop-filters',
		'description' => __( 'Widgets for the WooCommerce shop filter panel.', 'pemu' ),
	] ) );

	register_sidebar( array_merge( $default, [
		'name'        => __( 'Footer Widget Area', 'pemu' ),
		'id'          => 'footer-widgets',
		'description' => __( 'Widgets in the site footer.', 'pemu' ),
	] ) );
}

// -----------------------------------------------------------------
// Expose custom image sizes to the media library
// -----------------------------------------------------------------
add_filter( 'image_size_names_choose', function( array $sizes ): array {
	return array_merge( $sizes, [
		'pemu-product-card'   => __( 'Product Card (600×600)', 'pemu' ),
		'pemu-product-single' => __( 'Product Single (900×900)', 'pemu' ),
		'pemu-category-thumb' => __( 'Category Thumbnail (400×300)', 'pemu' ),
		'pemu-hero'           => __( 'Hero Banner (1920×900)', 'pemu' ),
	] );
} );

// -----------------------------------------------------------------
// Clean up <head> — remove bloat
// -----------------------------------------------------------------
add_action( 'init', 'pemu_clean_head' );
function pemu_clean_head(): void {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
	// REST API link leaks information, not needed for frontend.
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
}

// -----------------------------------------------------------------
// Remove jQuery Migrate (WooCommerce doesn't need it on frontend)
// -----------------------------------------------------------------
add_action( 'wp_default_scripts', function( \WP_Scripts $scripts ): void {
	if ( is_admin() ) {
		return;
	}
	// Re-register jQuery without jquery-migrate dependency.
	$scripts->remove( 'jquery' );
	$scripts->add( 'jquery', false, [ 'jquery-core' ], '3.x' );
} );

// -----------------------------------------------------------------
// Content width (for embeds, etc.)
// -----------------------------------------------------------------
if ( ! isset( $content_width ) ) {
	$content_width = 1280;
}

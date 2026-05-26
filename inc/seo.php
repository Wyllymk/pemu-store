<?php
/**
 * Pemu Health Supplements — inc/seo.php
 * JSON-LD structured data, Open Graph & Twitter Card meta.
 * Critical for TikTok link previews and Google Rich Results.
 */
defined( 'ABSPATH' ) || exit;

/* ----------------------------------------------------------------
 * 1. Product JSON-LD (single product pages)
 * ---------------------------------------------------------------- */
add_action( 'wp_head', 'pemu_product_jsonld' );
function pemu_product_jsonld(): void {
	if ( ! function_exists( 'is_product' ) || ! is_product() ) return;
	global $product;
	if ( ! $product instanceof WC_Product ) $product = wc_get_product( get_the_ID() );
	if ( ! $product ) return;

	$schema = [
		'@context'    => 'https://schema.org',
		'@type'       => 'Product',
		'name'        => $product->get_name(),
		'image'       => wp_get_attachment_image_url( $product->get_image_id(), 'full' ) ?: get_theme_file_uri( 'assets/images/fallback-product.webp' ),
		'description' => wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() ),
		'sku'         => $product->get_sku() ?: (string) $product->get_id(),
		'brand'       => [ '@type' => 'Brand', 'name' => 'Pemu Health Supplements' ],
		'offers'      => [
			'@type'         => 'Offer',
			'priceCurrency' => get_woocommerce_currency(),
			'price'         => $product->get_price(),
			'availability'  => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
			'url'           => get_permalink(),
			'seller'        => [ '@type' => 'Organization', 'name' => get_bloginfo( 'name' ) ],
			'priceValidUntil' => gmdate( 'Y-12-31', strtotime( '+1 year' ) ),
		],
	];

	if ( $product->get_rating_count() > 0 ) {
		$schema['aggregateRating'] = [
			'@type'       => 'AggregateRating',
			'ratingValue' => $product->get_average_rating(),
			'reviewCount' => $product->get_review_count(),
			'bestRating'  => '5',
			'worstRating' => '1',
		];
	}

	// Include gallery images.
	$gallery_ids = $product->get_gallery_image_ids();
	if ( $gallery_ids ) {
		$images = array_filter( array_map( fn( $id ) => wp_get_attachment_image_url( $id, 'full' ), $gallery_ids ) );
		if ( $images ) {
			$schema['image'] = array_values( array_merge( (array) $schema['image'], $images ) );
		}
	}

	echo '<script type="application/ld+json">'
		. wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT )
		. '</script>' . "\n";
}

/* ----------------------------------------------------------------
 * 2. Organisation JSON-LD (all non-product pages)
 * ---------------------------------------------------------------- */
add_action( 'wp_head', 'pemu_org_jsonld' );
function pemu_org_jsonld(): void {
	if ( function_exists( 'is_product' ) && is_product() ) return; // Product page has its own schema.

	$logo_url = get_theme_file_uri( 'assets/images/logo.svg' );
	$schema   = [
		'@context'     => 'https://schema.org',
		'@type'        => 'Organization',
		'name'         => 'Pemu Health Supplements',
		'url'          => home_url( '/' ),
		'logo'         => $logo_url,
		'description'  => 'Kenya\'s trusted supplement store. 100% authentic, lab-tested, discreetly delivered.',
		'sameAs'       => array_values( array_filter( [
			get_option( 'pemu_social_tiktok' ),
			get_option( 'pemu_social_instagram' ),
			get_option( 'pemu_social_facebook' ),
		] ) ),
		'contactPoint' => [
			'@type'             => 'ContactPoint',
			'telephone'         => '+' . pemu_sanitize_phone( get_option( 'pemu_whatsapp_number', '254700000000' ) ),
			'contactType'       => 'customer service',
			'areaServed'        => 'KE',
			'availableLanguage' => [ 'English', 'Swahili' ],
		],
		'address' => [
			'@type'           => 'PostalAddress',
			'addressLocality' => 'Nairobi',
			'addressCountry'  => 'KE',
		],
	];

	echo '<script type="application/ld+json">'
		. wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
		. '</script>' . "\n";
}

/* ----------------------------------------------------------------
 * 3. WebSite / Sitelinks Searchbox JSON-LD
 * ---------------------------------------------------------------- */
add_action( 'wp_head', 'pemu_website_jsonld' );
function pemu_website_jsonld(): void {
	if ( ! is_front_page() ) return;

	$schema = [
		'@context'        => 'https://schema.org',
		'@type'           => 'WebSite',
		'name'            => 'Pemu Health Supplements',
		'url'             => home_url( '/' ),
		'potentialAction' => [
			'@type'       => 'SearchAction',
			'target'      => [
				'@type'       => 'EntryPoint',
				'urlTemplate' => home_url( '/?s={search_term_string}&post_type=product' ),
			],
			'query-input' => 'required name=search_term_string',
		],
	];

	echo '<script type="application/ld+json">'
		. wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
		. '</script>' . "\n";
}

/* ----------------------------------------------------------------
 * 4. Open Graph + Twitter Card (essential for TikTok link previews)
 * ---------------------------------------------------------------- */
add_action( 'wp_head', 'pemu_social_meta', 1 );
function pemu_social_meta(): void {
	global $product;
	if ( function_exists( 'is_product' ) && is_product() && ! $product instanceof WC_Product ) {
		$product = wc_get_product( get_the_ID() );
	}

	$is_product = $product instanceof WC_Product;

	$title       = $is_product ? $product->get_name() . ' — Pemu Health Supplements' : ( is_front_page() ? get_bloginfo( 'name' ) . ' — Performance Supplements, Kenyan Prices' : wp_title( '—', false ) . ' — Pemu Health' );
	$description = $is_product
		? wp_strip_all_tags( $product->get_short_description() ?: substr( $product->get_description(), 0, 160 ) )
		: get_bloginfo( 'description' );
	$image       = $is_product
		? wp_get_attachment_image_url( $product->get_image_id(), 'pemu-og' )
		: get_theme_file_uri( 'assets/images/og-default.jpg' );
	$url         = $is_product ? get_permalink() : ( is_singular() ? get_permalink() : home_url( add_query_arg( [] ) ) );
	$type        = $is_product ? 'product' : 'website';

	$title       = $title ?: get_bloginfo( 'name' );
	$description = $description ?: get_bloginfo( 'description' );
	$image       = $image ?: get_theme_file_uri( 'assets/images/og-default.jpg' );

	// Canonical URL.
	echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";

	// Meta description.
	if ( $description ) {
		echo '<meta name="description" content="' . esc_attr( wp_trim_words( $description, 25 ) ) . '">' . "\n";
	}

	// Open Graph.
	$og_tags = [
		'og:type'        => $type,
		'og:title'       => $title,
		'og:description' => wp_trim_words( $description, 25 ),
		'og:image'       => $image,
		'og:image:width' => '1200',
		'og:image:height'=> '630',
		'og:url'         => $url,
		'og:site_name'   => 'Pemu Health Supplements',
		'og:locale'      => 'en_KE',
	];

	if ( $is_product ) {
		$og_tags['product:price:amount']   = $product->get_price();
		$og_tags['product:price:currency'] = 'KES';
		$og_tags['product:availability']   = $product->is_in_stock() ? 'in stock' : 'out of stock';
	}

	foreach ( $og_tags as $property => $content ) {
		if ( $content ) {
			echo '<meta property="' . esc_attr( $property ) . '" content="' . esc_attr( $content ) . '">' . "\n";
		}
	}

	// Twitter / X Card.
	$twitter_tags = [
		'twitter:card'        => 'summary_large_image',
		'twitter:title'       => $title,
		'twitter:description' => wp_trim_words( $description, 25 ),
		'twitter:image'       => $image,
		'twitter:site'        => '@pemuhealth',
	];

	foreach ( $twitter_tags as $name => $content ) {
		if ( $content ) {
			echo '<meta name="' . esc_attr( $name ) . '" content="' . esc_attr( $content ) . '">' . "\n";
		}
	}
}

/* ----------------------------------------------------------------
 * 5. BreadcrumbList JSON-LD on inner pages
 * ---------------------------------------------------------------- */
add_action( 'wp_head', 'pemu_breadcrumb_jsonld' );
function pemu_breadcrumb_jsonld(): void {
	if ( is_front_page() || is_home() ) return;

	$items    = [];
	$position = 1;

	$items[] = [
		'@type'    => 'ListItem',
		'position' => $position++,
		'name'     => __( 'Home', 'pemu' ),
		'item'     => home_url( '/' ),
	];

	if ( function_exists( 'is_product' ) && is_product() ) {
		$terms = get_the_terms( get_the_ID(), 'product_cat' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			$term    = reset( $terms );
			$items[] = [
				'@type'    => 'ListItem',
				'position' => $position++,
				'name'     => $term->name,
				'item'     => get_term_link( $term ),
			];
		}
		$items[] = [
			'@type'    => 'ListItem',
			'position' => $position,
			'name'     => get_the_title(),
			'item'     => get_permalink(),
		];
	} elseif ( function_exists( 'is_product_category' ) && is_product_category() ) {
		$items[] = [
			'@type'    => 'ListItem',
			'position' => $position,
			'name'     => single_term_title( '', false ),
			'item'     => get_term_link( get_queried_object() ),
		];
	} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		$items[] = [
			'@type'    => 'ListItem',
			'position' => $position,
			'name'     => woocommerce_page_title( false ),
			'item'     => wc_get_page_permalink( 'shop' ),
		];
	} elseif ( is_page() || is_single() ) {
		$items[] = [
			'@type'    => 'ListItem',
			'position' => $position,
			'name'     => get_the_title(),
			'item'     => get_permalink(),
		];
	}

	if ( count( $items ) < 2 ) return;

	$schema = [
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $items,
	];

	echo '<script type="application/ld+json">'
		. wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
		. '</script>' . "\n";
}

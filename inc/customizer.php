<?php
/**
 * Pemu Health Supplements — inc/customizer.php
 * WordPress Customizer panels, sections, settings and controls.
 */
defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', 'pemu_customizer_settings' );
function pemu_customizer_settings( WP_Customize_Manager $wp_customize ): void {

	/* ── Master panel ───────────────────────────────────────────── */
	$wp_customize->add_panel( 'pemu_panel', [
		'title'    => __( '🌿 Pemu Theme Settings', 'pemu' ),
		'priority' => 30,
	] );

	/* ── Section helper ─────────────────────────────────────────── */
	$add_section = static function( string $id, string $title, int $priority = 10 ) use ( $wp_customize ): void {
		$wp_customize->add_section( $id, [
			'title'    => $title,
			'panel'    => 'pemu_panel',
			'priority' => $priority,
		] );
	};

	/* ── Text setting helper ────────────────────────────────────── */
	$add_text = static function( string $key, string $label, string $section, string $default = '', string $type = 'text' ) use ( $wp_customize ): void {
		$wp_customize->add_setting( $key, [
			'default'           => $default,
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		] );
		$wp_customize->add_control( $key, [
			'label'   => $label,
			'section' => $section,
			'type'    => $type,
		] );
	};

	/* ────────────────────────────────────────────────────────────
	 * SECTION: Contact & Social
	 * ──────────────────────────────────────────────────────────── */
	$add_section( 'pemu_contact', __( '📞 Contact & Social', 'pemu' ), 10 );

	$add_text( 'pemu_whatsapp_number', __( 'WhatsApp Number (no +, e.g. 254712345678)', 'pemu' ), 'pemu_contact', '254700000000' );
	$add_text( 'pemu_email',           __( 'Email Address', 'pemu' ),     'pemu_contact', 'hello@pemuhealthsupplements.co.ke', 'email' );
	$add_text( 'pemu_address',         __( 'Physical Address', 'pemu' ),  'pemu_contact', 'Nairobi, Kenya' );
	$add_text( 'pemu_social_tiktok',   __( 'TikTok URL', 'pemu' ),        'pemu_contact' );
	$add_text( 'pemu_social_instagram',__( 'Instagram URL', 'pemu' ),     'pemu_contact' );
	$add_text( 'pemu_social_facebook', __( 'Facebook URL', 'pemu' ),      'pemu_contact' );

	$wp_customize->add_setting( 'pemu_free_delivery_threshold', [
		'default'           => '2000',
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	] );
	$wp_customize->add_control( 'pemu_free_delivery_threshold', [
		'label'   => __( 'Free Delivery Threshold (KES)', 'pemu' ),
		'section' => 'pemu_contact',
		'type'    => 'number',
	] );

	/* ────────────────────────────────────────────────────────────
	 * SECTION: Announcement Bar
	 * ──────────────────────────────────────────────────────────── */
	$add_section( 'pemu_announcement', __( '📢 Announcement Bar', 'pemu' ), 20 );

	$wp_customize->add_setting( 'pemu_announcement_enabled', [
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'refresh',
	] );
	$wp_customize->add_control( 'pemu_announcement_enabled', [
		'label'   => __( 'Show announcement bar', 'pemu' ),
		'section' => 'pemu_announcement',
		'type'    => 'checkbox',
	] );

	$add_text(
		'pemu_announcement_text',
		__( 'Announcement Text', 'pemu' ),
		'pemu_announcement',
		'🚚 Free delivery on orders above KES 2,000 · Order discreetly via WhatsApp 📱'
	);

	$wp_customize->add_setting( 'pemu_announcement_link', [
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	] );
	$wp_customize->add_control( 'pemu_announcement_link', [
		'label'   => __( 'Announcement Link URL (optional)', 'pemu' ),
		'section' => 'pemu_announcement',
		'type'    => 'url',
	] );

	/* ────────────────────────────────────────────────────────────
	 * SECTION: Homepage Hero
	 * ──────────────────────────────────────────────────────────── */
	$add_section( 'pemu_hero', __( '🦸 Homepage Hero', 'pemu' ), 30 );

	$add_text( 'pemu_hero_headline',    __( 'Headline', 'pemu' ),         'pemu_hero', 'Performance Supplements. Kenyan Prices.' );
	$add_text( 'pemu_hero_subheadline', __( 'Sub-headline', 'pemu' ),     'pemu_hero', 'Lab-tested protein, creatine, pre-workout & wellness essentials. Delivered countrywide, paid on M-Pesa.' );
	$add_text( 'pemu_hero_cta_primary', __( 'Primary CTA Label', 'pemu' ),'pemu_hero', 'Shop Now' );
	$add_text( 'pemu_hero_cta_wa',      __( 'WhatsApp CTA Label', 'pemu' ),'pemu_hero', 'Order via WhatsApp' );
	$add_text( 'pemu_hero_badge',       __( 'Trust Badge Text', 'pemu' ), 'pemu_hero', '100% Authentic · Discreet Shipping' );

	$wp_customize->add_setting( 'pemu_hero_image', [
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	] );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'pemu_hero_image', [
		'label'   => __( 'Hero Background Image', 'pemu' ),
		'section' => 'pemu_hero',
	] ) );

	$add_text( 'pemu_hero_social_proof', __( 'Social Proof Text (e.g. "Trusted by 12,000+ Kenyans")', 'pemu' ), 'pemu_hero', 'Trusted by 12,000+ Kenyans' );

	/* ────────────────────────────────────────────────────────────
	 * SECTION: Homepage Sections
	 * ──────────────────────────────────────────────────────────── */
	$add_section( 'pemu_homepage', __( '🏠 Homepage Sections', 'pemu' ), 40 );

	foreach ( [
		'pemu_show_trust_bar'    => __( 'Show Trust Bar', 'pemu' ),
		'pemu_show_categories'   => __( 'Show Category Grid', 'pemu' ),
		'pemu_show_bestsellers'  => __( 'Show Best Sellers', 'pemu' ),
		'pemu_show_new_arrivals' => __( 'Show New Arrivals', 'pemu' ),
		'pemu_show_tiktok'       => __( 'Show TikTok Strip', 'pemu' ),
		'pemu_show_testimonials' => __( 'Show Testimonials', 'pemu' ),
	] as $key => $label ) {
		$wp_customize->add_setting( $key, [
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport'         => 'refresh',
		] );
		$wp_customize->add_control( $key, [
			'label'   => $label,
			'section' => 'pemu_homepage',
			'type'    => 'checkbox',
		] );
	}

	$wp_customize->add_setting( 'pemu_bestsellers_count', [
		'default'           => '8',
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	] );
	$wp_customize->add_control( 'pemu_bestsellers_count', [
		'label'   => __( 'Number of Best Sellers to Show', 'pemu' ),
		'section' => 'pemu_homepage',
		'type'    => 'number',
	] );

	/* ────────────────────────────────────────────────────────────
	 * SECTION: Footer
	 * ──────────────────────────────────────────────────────────── */
	$add_section( 'pemu_footer', __( '🦶 Footer', 'pemu' ), 50 );

	$add_text( 'pemu_footer_tagline', __( 'Footer Tagline', 'pemu' ), 'pemu_footer', "Kenya's trusted supplement store. 100% authentic, discreetly delivered." );
	$add_text( 'pemu_footer_copyright', __( 'Copyright Text', 'pemu' ), 'pemu_footer', '© 2026 Pemu Health Supplements. All rights reserved.' );

	/* ────────────────────────────────────────────────────────────
	 * SECTION: TikTok / UGC Strip
	 * ──────────────────────────────────────────────────────────── */
	$add_section( 'pemu_tiktok', __( '🎬 TikTok / Social Proof', 'pemu' ), 60 );
	$add_text( 'pemu_tiktok_handle', __( 'TikTok Handle (e.g. @pemuhealth)', 'pemu' ), 'pemu_tiktok', '@pemuhealth' );
	$add_text( 'pemu_tiktok_cta',    __( 'TikTok CTA Button Label', 'pemu' ), 'pemu_tiktok', 'Follow @pemuhealth' );
}

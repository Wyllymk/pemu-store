<?php
/**
 * Pemu Health Supplements — inc/whatsapp.php
 * WhatsApp URL builder, message formatters, and button components.
 */
defined( 'ABSPATH' ) || exit;

/**
 * Build a wa.me deep-link URL with optional pre-filled message.
 */
function pemu_whatsapp_url( string $message = '' ): string {
	$phone = pemu_sanitize_phone( get_option( 'pemu_whatsapp_number', '254715631147' ) );
	if ( $message ) {
		return 'https://wa.me/' . $phone . '?text=' . rawurlencode( $message );
	}
	return 'https://wa.me/' . $phone;
}

/**
 * Build a WhatsApp message from the current cart contents.
 */
function pemu_cart_whatsapp_message(): string {
	if ( ! function_exists( 'WC' ) || WC()->cart->is_empty() ) {
		return 'Hi Pemu Health! 👋 I\'d like to place an order. Please help me.';
	}

	$lines = [ "Hi Pemu Health! 👋", "I'd like to order the following:", "" ];
	foreach ( WC()->cart->get_cart() as $item ) {
		/** @var WC_Product $product */
		$product  = $item['data'];
		$qty      = $item['quantity'];
		$subtotal = strip_tags( wc_price( $item['line_subtotal'] ) );
		$lines[]  = "• {$product->get_name()} × {$qty} — {$subtotal}";
	}

	$lines[] = '';
	$lines[] = '💰 Total: ' . strip_tags( WC()->cart->get_cart_total() );
	$lines[] = '';
	$lines[] = 'Please confirm and send payment details. Thank you!';

	return implode( "\n", $lines );
}

/**
 * Output the floating WhatsApp button component.
 */
function pemu_floating_whatsapp_btn(): void {
	$url = pemu_whatsapp_url( 'Hi Pemu Health! 👋 I have a question about your products.' );
	get_template_part( 'template-parts/components/whatsapp-fab', null, [ 'url' => $url ] );
}
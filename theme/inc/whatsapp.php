<?php
/**
 * Pemu — inc/whatsapp.php
 */
defined('ABSPATH') || exit;

function pemu_whatsapp_url(string $message=''): string {
    $phone = preg_replace('/[^0-9]/', '', get_option('pemu_whatsapp_number','254707551484'));
    if ($message) return 'https://wa.me/'.$phone.'?text='.rawurlencode($message);
    return 'https://wa.me/'.$phone;
}

function pemu_cart_whatsapp_message(): string {
    if (!function_exists('WC') || WC()->cart->is_empty())
        return "Hi Pemu Ventures! 👋 I'd like to place an order. Please help me.";
    $lines = ["Hi Pemu Ventures! 👋", "I'd like to order:", ""];
    foreach (WC()->cart->get_cart() as $item) {
        $p = $item['data']; $qty = $item['quantity'];
        $sub = strip_tags(wc_price($item['line_subtotal']));
        $lines[] = "• {$p->get_name()} × {$qty} — {$sub}";
    }
    $lines[] = '';
    $lines[] = '💰 Total: '.strip_tags(WC()->cart->get_cart_total());
    $lines[] = '';
    $lines[] = 'Please confirm and send payment details. Thank you!';
    return implode("\n", $lines);
}

function pemu_floating_whatsapp_btn(): void {
    $url = pemu_whatsapp_url("Hi Pemu Ventures! 👋 I have a question about your products.");
    get_template_part('template-parts/components/whatsapp-fab', null, ['url'=>$url]);
}

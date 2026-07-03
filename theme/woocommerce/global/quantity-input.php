<?php
/**
 * WooCommerce — global/quantity-input.php (Pemu override)
 * @version 10.1.0
 */
defined( 'ABSPATH' ) || exit;

$input_id     = uniqid( 'quantity_' );
$max_value    = $max_value ?? '';
$min_value    = $min_value ?? 0;
$step         = $step      ?? 1;
$input_value  = $input_value ?? 1;
$input_name   = ! empty( $input_name ) ? $input_name : 'quantity';
$product_name = isset( $product ) ? $product->get_name() : '';
?>
<div class="quantity inline-flex items-center border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden bg-gray-100 dark:bg-slate-800"
	x-data="qtyInput({value: <?php echo (int)$input_value; ?>, min: <?php echo (int)$min_value; ?>, max: <?php echo (int)($max_value ?: 99); ?>, step: <?php echo (int)$step; ?>})">
	<button type="button" @click="decrement()"
	        class="w-10 h-11 flex items-center justify-center shrink-0 bg-none border-none text-lg font-bold text-slate-500 dark:text-slate-400 cursor-pointer transition-colors hover:text-brand-green hover:bg-white dark:hover:bg-slate-800 leading-none"
	        aria-label="<?php esc_attr_e( 'Decrease quantity', 'pemu' ); ?>">−</button>

	<input type="number"
	       x-ref="input"
	       x-model.number="value"
	       id="<?php echo esc_attr( $input_id ); ?>"
	       class="input-text qty text w-12 text-center border-none border-x border-slate-200 dark:border-slate-700 bg-none p-2.5 text-sm font-bold text-slate-800 dark:text-slate-200 [-moz-appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none focus:bg-white dark:focus:bg-slate-800 outline-none"
	       name="<?php echo esc_attr( $input_name ); ?>"
	       value="<?php echo esc_attr( $input_value ); ?>"
	       step="<?php echo esc_attr( $step ); ?>"
	       min="<?php echo esc_attr( $min_value ); ?>"
	       max="<?php echo esc_attr( $max_value ?: '' ); ?>"
	       inputmode="numeric"
	       autocomplete="off"
	       title="<?php esc_attr_e( 'Qty', 'woocommerce' ); ?>"
	       size="4"
	       aria-label="<?php echo $product_name ? esc_attr( sprintf( __( 'Quantity of %s', 'pemu' ), $product_name ) ) : esc_attr__( 'Quantity', 'pemu' ); ?>">

	<button type="button" @click="increment()"
	        class="w-10 h-11 flex items-center justify-center shrink-0 bg-none border-none text-lg font-bold text-slate-500 dark:text-slate-400 cursor-pointer transition-colors hover:text-brand-green hover:bg-white dark:hover:bg-slate-800 leading-none"
	        aria-label="<?php esc_attr_e( 'Increase quantity', 'pemu' ); ?>">+</button>
</div>

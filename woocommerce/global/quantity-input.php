<?php
/**
 * WooCommerce — global/quantity-input.php
 * Pemu override: styled quantity stepper.
 * @version 9.1.0
 */
defined( 'ABSPATH' ) || exit;

/* translators: %s: Product title */
$input_id      = uniqid( 'quantity_' );
$max_value     = $max_value ?? '';
$min_value     = $min_value ?? 0;
$step          = $step      ?? 1;
$input_value   = $input_value ?? 1;
$classes       = ! empty( $classes ) ? (array) $classes : [];
$input_name    = ! empty( $input_name ) ? $input_name : 'quantity';
$product_name  = isset( $product ) ? $product->get_name() : '';
$autocomplete  = 'on';
$size          = 4;
?>
<div class="quantity inline-flex items-center border border-[var(--color-border)] rounded-xl overflow-hidden bg-[var(--color-bg-muted)]">
	<button type="button"
	        class="minus w-10 h-11 flex items-center justify-center text-[var(--color-text-muted)] hover:text-brand-green hover:bg-[var(--color-surface)] transition-colors text-lg font-bold"
	        aria-label="<?php esc_attr_e( 'Decrease quantity', 'pemu' ); ?>">
		−
	</button>
	<input
		type="number"
		id="<?php echo esc_attr( $input_id ); ?>"
		class="input-text qty text w-12 text-center border-x border-[var(--color-border)] bg-transparent text-[var(--color-text)] font-bold py-2.5 focus:outline-none"
		step="<?php echo esc_attr( $step ); ?>"
		min="<?php echo esc_attr( $min_value ); ?>"
		max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
		name="<?php echo esc_attr( $input_name ); ?>"
		value="<?php echo esc_attr( $input_value ); ?>"
		title="<?php esc_attr_e( 'Qty', 'woocommerce' ); ?>"
		size="<?php echo esc_attr( $size ); ?>"
		inputmode="numeric"
		autocomplete="<?php echo esc_attr( $autocomplete ); ?>"
		aria-label="<?php echo $product_name ? esc_attr( sprintf( __( 'Quantity of %s', 'pemu' ), $product_name ) ) : esc_attr__( 'Quantity', 'pemu' ); ?>"
	/>
	<button type="button"
	        class="plus w-10 h-11 flex items-center justify-center text-[var(--color-text-muted)] hover:text-brand-green hover:bg-[var(--color-surface)] transition-colors text-lg font-bold"
	        aria-label="<?php esc_attr_e( 'Increase quantity', 'pemu' ); ?>">
		+
	</button>
</div>

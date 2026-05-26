<?php
/**
 * Template part: Sticky Add-to-Cart bar (single product).
 * Visibility controlled by Alpine.js scroll watcher in product-gallery.js.
 * Args: $args['product'] — WC_Product instance.
 */
defined( 'ABSPATH' ) || exit;

/** @var WC_Product $product */
$product = $args['product'] ?? null;
if ( ! $product instanceof WC_Product ) return;

$name      = $product->get_name();
$price     = $product->get_price_html();
$img_id    = $product->get_image_id();
$in_stock  = $product->is_in_stock();
$prod_id   = $product->get_id();
?>
<div x-show="$store.product.stickyATCVisible"
     x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-4"
     class="fixed bottom-[60px] lg:bottom-0 inset-x-0 z-30 bg-[var(--color-surface)] border-t border-[var(--color-border)] shadow-2xl shadow-black/10"
     aria-label="<?php esc_attr_e( 'Quick add to cart', 'pemu' ); ?>">
	<div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-4">
		<!-- Thumbnail -->
		<div class="w-12 h-12 rounded-xl bg-brand-light dark:bg-[#1C2B38] flex items-center justify-center shrink-0 overflow-hidden">
			<?php if ( $img_id ) : ?>
			<?php echo wp_get_attachment_image( $img_id, [ 48, 48 ], false, [ 'class' => 'w-full h-full object-contain', 'loading' => 'lazy' ] ); ?>
			<?php else : ?>
			<span class="text-2xl" aria-hidden="true">💊</span>
			<?php endif; ?>
		</div>

		<!-- Name + Price -->
		<div class="flex-1 min-w-0">
			<p class="font-semibold text-sm truncate text-[var(--color-text)]"><?php echo esc_html( $name ); ?></p>
			<div class="text-brand-green font-display font-bold text-sm"><?php echo wp_kses_post( $price ); ?></div>
		</div>

		<?php if ( $in_stock ) : ?>
		<!-- ATC Button -->
		<?php if ( $product->is_type( 'simple' ) ) : ?>
		<form method="post" class="shrink-0">
			<?php woocommerce_quantity_input( [ 'input_value' => 1 ], $product ); ?>
			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $prod_id ); ?>">
			<button type="submit"
			        name="add-to-cart"
			        value="<?php echo esc_attr( $prod_id ); ?>"
			        class="bg-brand-green hover:bg-brand-green-dark text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-colors whitespace-nowrap shadow-md shadow-brand-green/30">
				<?php esc_html_e( 'Add to Cart', 'pemu' ); ?>
			</button>
		</form>
		<?php else : ?>
		<a href="<?php echo esc_url( $product->get_permalink() ); ?>#product-options"
		   class="shrink-0 bg-brand-green hover:bg-brand-green-dark text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-colors whitespace-nowrap shadow-md shadow-brand-green/30">
			<?php esc_html_e( 'Select Options', 'pemu' ); ?>
		</a>
		<?php endif; ?>
		<?php else : ?>
		<span class="shrink-0 text-sm font-semibold text-[var(--color-text-muted)] bg-[var(--color-bg-muted)] px-5 py-2.5 rounded-xl">
			<?php esc_html_e( 'Out of Stock', 'pemu' ); ?>
		</span>
		<?php endif; ?>
	</div>
</div>

<?php
/**
 * Template part: Sticky Add-to-Cart bar (single product).
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

// Build x-data config safely: esc_attr() HTML-encodes quotes so the attribute
// closes correctly; Alpine re-decodes them before evaluating the JS expression.
$x_data_config = esc_attr( wp_json_encode([
    'productId'   => (int) $prod_id,
    'productName' => $name,
]) );
?>
<div x-show="$store.product.stickyATCVisible"
     x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-4"
     class="fixed bottom-[60px] lg:bottom-0 inset-x-0 z-30 bg-white/95 dark:bg-slate-800/95 backdrop-blur-md border-t border-slate-200 dark:border-slate-700 shadow-2xl shadow-black/10"
     aria-label="<?php esc_attr_e( 'Quick add to cart', 'pemu' ); ?>">

	<div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-3 sm:gap-4">

		<!-- Thumbnail -->
		<div class="w-11 h-11 rounded-xl bg-green-50 dark:bg-slate-900 flex items-center justify-center shrink-0 overflow-hidden border border-slate-100 dark:border-slate-700">
			<?php if ( $img_id ) : ?>
			<?php echo wp_get_attachment_image( $img_id, [ 44, 44 ], false, [ 'class' => 'w-full h-full object-contain', 'loading' => 'lazy' ] ); ?>
			<?php else : ?>
			<span class="text-xl" aria-hidden="true">💊</span>
			<?php endif; ?>
		</div>

		<!-- Name + Price -->
		<div class="flex-1 min-w-0 hidden sm:block">
			<p class="font-semibold text-sm truncate text-slate-900 dark:text-slate-100"><?php echo esc_html( $name ); ?></p>
			<div class="text-brand-green font-display font-bold text-sm leading-tight"><?php echo wp_kses_post( $price ); ?></div>
		</div>

		<?php if ( $in_stock ) : ?>
		<?php if ( $product->is_type( 'simple' ) ) : ?>

		<!-- Qty + AJAX ATC — uses named Alpine component to avoid escaping issues -->
		<div class="flex items-center gap-2 sm:gap-3 shrink-0 ml-auto sm:ml-0"
		     x-data="stickyAtc(<?php echo $x_data_config; ?>)">

			<!-- Qty stepper -->
			<div class="inline-flex items-center border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden bg-slate-100 dark:bg-slate-900">
				<button type="button"
				        @click="qty = Math.max(1, qty - 1)"
				        class="w-9 h-10 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-brand-green hover:bg-white dark:hover:bg-slate-800 transition-colors text-lg font-bold leading-none"
				        aria-label="<?php esc_attr_e( 'Decrease quantity', 'pemu' ); ?>">−</button>
				<span x-text="qty"
				      class="w-9 text-center text-sm font-bold text-slate-800 dark:text-slate-200 select-none"
				      aria-live="polite">1</span>
				<button type="button"
				        @click="qty++"
				        class="w-9 h-10 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-brand-green hover:bg-white dark:hover:bg-slate-800 transition-colors text-lg font-bold leading-none"
				        aria-label="<?php esc_attr_e( 'Increase quantity', 'pemu' ); ?>">+</button>
			</div>

			<!-- ATC button -->
			<button type="button"
			        @click="add()"
			        :disabled="loading"
			        class="flex items-center gap-2 bg-brand-green hover:bg-brand-green-dark disabled:opacity-70 disabled:cursor-not-allowed text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-all duration-200 whitespace-nowrap shadow-md shadow-brand-green/30 hover:shadow-lg hover:shadow-brand-green/40 hover:-translate-y-px active:translate-y-0">

				<!-- Spinner: hidden by default (loading=false), Alpine shows when loading -->
				<svg x-show="loading" style="display:none"
				     class="animate-spin w-4 h-4 shrink-0" viewBox="0 0 24 24" aria-hidden="true">
					<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
					<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
				</svg>

				<!-- Cart icon: visible by default (loading=false), Alpine hides when loading -->
				<svg x-show="!loading" style="display:inline"
				     class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
					<path d="M3 3h2l2.5 12.5a2 2 0 002 1.5h9a2 2 0 002-1.5L22 7H6" stroke-linecap="round" stroke-linejoin="round"/>
					<circle cx="9" cy="20" r="1.5" fill="currentColor" stroke="none"/>
					<circle cx="18" cy="20" r="1.5" fill="currentColor" stroke="none"/>
				</svg>

				<span x-text="loading ? '<?php echo esc_js( __( 'Adding…', 'pemu' ) ); ?>' : '<?php echo esc_js( __( 'Add to Cart', 'pemu' ) ); ?>'">
					<?php esc_html_e( 'Add to Cart', 'pemu' ); ?>
				</span>
			</button>
		</div>

		<?php else : ?>
		<a href="<?php echo esc_url( $product->get_permalink() ); ?>#product-options"
		   class="shrink-0 ml-auto flex items-center gap-2 bg-brand-green hover:bg-brand-green-dark text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-colors whitespace-nowrap shadow-md shadow-brand-green/30">
			<?php esc_html_e( 'Select Options', 'pemu' ); ?>
		</a>
		<?php endif; ?>
		<?php else : ?>
		<span class="shrink-0 ml-auto text-sm font-semibold text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-900 px-5 py-2.5 rounded-xl">
			<?php esc_html_e( 'Out of Stock', 'pemu' ); ?>
		</span>
		<?php endif; ?>
	</div>
</div>

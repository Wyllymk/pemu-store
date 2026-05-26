<?php
/**
 * Template part: Reusable product card.
 *
 * Used in homepage best-sellers, new arrivals, related products, and WC loop.
 *
 * Args:
 *   $args['product']       WC_Product instance (required)
 *   $args['show_brand']    bool — show brand/vendor (default true)
 *   $args['show_rating']   bool — show star rating (default true)
 */
defined( 'ABSPATH' ) || exit;

/** @var WC_Product $product */
$product = $args['product'] ?? null;
if ( ! $product instanceof WC_Product ) {
	return;
}

$show_brand  = $args['show_brand'] ?? true;
$show_rating = $args['show_rating'] ?? true;

$permalink      = $product->get_permalink();
$name           = $product->get_name();
$price_html     = $product->get_price_html();
$regular_price  = (float) $product->get_regular_price();
$sale_price     = (float) $product->get_sale_price();
$on_sale        = $product->is_on_sale();
$is_new         = ( time() - strtotime( $product->get_date_created() ) ) < ( 30 * DAY_IN_SECONDS );
$is_featured    = $product->is_featured();
$in_stock       = $product->is_in_stock();
$avg_rating     = (float) $product->get_average_rating();
$review_count   = (int) $product->get_review_count();
$brand          = get_post_meta( $product->get_id(), '_brand', true ) ?: '';

// Badge
$badge_text  = '';
$badge_class = '';
if ( ! $in_stock ) {
	$badge_text  = __( 'Sold Out', 'pemu' );
	$badge_class = 'bg-[var(--color-text-muted)]';
} elseif ( $is_featured ) {
	$badge_text  = __( 'BESTSELLER', 'pemu' );
	$badge_class = 'bg-brand-green';
} elseif ( $on_sale && $regular_price > 0 ) {
	$pct         = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
	$badge_text  = '-' . $pct . '%';
	$badge_class = 'bg-red-500';
} elseif ( $is_new ) {
	$badge_text  = __( 'NEW', 'pemu' );
	$badge_class = 'bg-brand-navy';
}

// WhatsApp order message
$wa_message = sprintf(
	"Hi Pemu Health! 👋 I'd like to order: *%s*\n%s",
	$name,
	$permalink
);
$wa_url = pemu_whatsapp_url( $wa_message );

// Product image
$img_id   = $product->get_image_id();
$img_html = $img_id
	? wp_get_attachment_image( $img_id, 'pemu-product-card', false, [
		'class'  => 'w-full h-full object-contain transition-transform duration-500 group-hover:scale-105',
		'alt'    => esc_attr( $name ),
		'loading'=> 'lazy',
	] )
	: '<span class="text-7xl select-none" aria-hidden="true">💊</span>';
?>

<article class="group relative bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl overflow-hidden hover:shadow-xl hover:shadow-black/5 hover:-translate-y-1 transition-all duration-300 flex flex-col">

	<!-- Image area -->
	<a href="<?php echo esc_url( $permalink ); ?>"
	   class="relative block aspect-square bg-gradient-to-br from-brand-light to-white dark:from-[#1C2B38] dark:to-[#0F1923] overflow-hidden flex items-center justify-center"
	   tabindex="-1" aria-hidden="true">
		<?php echo $img_html; ?>
		<?php if ( ! $in_stock ) : ?>
		<div class="absolute inset-0 bg-[var(--color-surface)]/60 flex items-center justify-center">
			<span class="text-xs font-bold text-[var(--color-text-muted)]"><?php esc_html_e( 'Out of Stock', 'pemu' ); ?></span>
		</div>
		<?php endif; ?>
	</a>

	<!-- Badge -->
	<?php if ( $badge_text ) : ?>
	<span class="absolute top-2.5 left-2.5 z-10 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold text-white tracking-wide <?php echo esc_attr( $badge_class ); ?>">
		<?php echo esc_html( $badge_text ); ?>
	</span>
	<?php endif; ?>

	<!-- WhatsApp quick-order (appears on hover) -->
	<?php if ( $in_stock ) : ?>
	<a href="<?php echo esc_url( $wa_url ); ?>"
	   target="_blank" rel="noopener noreferrer"
	   class="absolute top-2.5 right-2.5 z-10 w-8 h-8 rounded-full bg-[#25D366] text-white flex items-center justify-center shadow-md opacity-0 group-hover:opacity-100 translate-y-1 group-hover:translate-y-0 transition-all duration-200"
	   aria-label="<?php echo esc_attr( sprintf( __( 'Order %s via WhatsApp', 'pemu' ), $name ) ); ?>">
		<?php echo pemu_icon( 'whatsapp', [ 'class' => 'w-3.5 h-3.5' ] ); ?>
	</a>
	<?php endif; ?>

	<!-- Content -->
	<div class="flex flex-col flex-1 p-4 gap-2">
		<?php if ( $show_brand && $brand ) : ?>
		<p class="text-[10px] font-bold tracking-widest uppercase text-[var(--color-text-muted)]"><?php echo esc_html( $brand ); ?></p>
		<?php endif; ?>

		<a href="<?php echo esc_url( $permalink ); ?>"
		   class="font-semibold text-sm leading-snug line-clamp-2 text-[var(--color-text)] hover:text-brand-green transition-colors">
			<?php echo esc_html( $name ); ?>
		</a>

		<?php if ( $show_rating && $review_count > 0 ) : ?>
		<div class="flex items-center gap-1.5">
			<div class="flex" aria-label="<?php echo esc_attr( sprintf( __( 'Rated %.1f out of 5', 'pemu' ), $avg_rating ) ); ?>">
				<?php for ( $s = 1; $s <= 5; $s++ ) : ?>
				<svg class="w-3 h-3 <?php echo $s <= $avg_rating ? 'text-amber-400' : 'text-[var(--color-border)]'; ?>" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
				<?php endfor; ?>
			</div>
			<span class="text-xs text-[var(--color-text-muted)]">(<?php echo esc_html( $review_count ); ?>)</span>
		</div>
		<?php endif; ?>

		<!-- Price + ATC row -->
		<div class="flex items-end justify-between mt-auto pt-2">
			<div class="flex flex-col">
				<span class="font-display font-bold text-brand-green text-base leading-tight"><?php echo wp_kses_post( $price_html ); ?></span>
			</div>
			<?php if ( $in_stock ) : ?>
			<?php
			$atc_url = add_query_arg( [
				'add-to-cart' => $product->get_id(),
				'quantity'    => 1,
			], wc_get_cart_url() );
			?>
			<a href="<?php echo esc_url( $product->is_type( 'simple' ) ? $atc_url : $permalink ); ?>"
			   <?php if ( $product->is_type( 'simple' ) ) : ?>
			   data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
			   aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'pemu' ), $name ) ); ?>"
			   class="add_to_cart_button ajax_add_to_cart product_type_simple"
			   <?php else : ?>
			   aria-label="<?php echo esc_attr( sprintf( __( 'View %s options', 'pemu' ), $name ) ); ?>"
			   <?php endif; ?>
			   class="shrink-0 w-9 h-9 rounded-full bg-brand-navy hover:bg-brand-green text-white flex items-center justify-center transition-colors duration-200 shadow-sm">
				<?php echo pemu_icon( 'plus', [ 'class' => 'w-4 h-4' ] ); ?>
			</a>
			<?php endif; ?>
		</div>
	</div>
</article>

<?php
/**
 * Template part: New Arrivals
 */
defined( 'ABSPATH' ) || exit;

$products = wc_get_products( [
	'limit'   => 4,
	'orderby' => 'date',
	'order'   => 'DESC',
	'status'  => 'publish',
] );

if ( empty( $products ) ) return;
?>

<section class="max-w-7xl mx-auto px-4 py-14 lg:py-20" aria-labelledby="new-arrivals-heading">
	<div class="flex items-end justify-between mb-8">
		<div>
			<p class="text-xs font-bold tracking-widest uppercase text-brand-green mb-2">✨ <?php esc_html_e( 'Just Landed', 'pemu' ); ?></p>
			<h2 id="new-arrivals-heading" class="font-display font-extrabold text-3xl lg:text-4xl text-[var(--color-text)]">
				<?php esc_html_e( 'New Arrivals', 'pemu' ); ?>
			</h2>
		</div>
		<a href="<?php echo esc_url( add_query_arg( 'orderby', 'date', wc_get_page_permalink( 'shop' ) ) ); ?>"
		   class="hidden sm:inline-flex items-center gap-1.5 text-brand-green font-semibold text-sm hover:underline">
			<?php esc_html_e( 'View all new', 'pemu' ); ?>
			<?php echo pemu_icon( 'arrow-right', [ 'class' => 'w-4 h-4' ] ); ?>
		</a>
	</div>

	<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5">
		<?php foreach ( $products as $product ) : ?>
		<?php get_template_part( 'template-parts/components/product-card', null, [ 'product' => $product ] ); ?>
		<?php endforeach; ?>
	</div>
</section>

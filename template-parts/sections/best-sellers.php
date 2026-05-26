<?php
/**
 * Template part: Best Sellers
 */
defined( 'ABSPATH' ) || exit;

$limit    = absint( get_theme_mod( 'pemu_bestsellers_count', 8 ) );
$products = wc_get_products( [
	'limit'   => $limit,
	'orderby' => 'popularity',
	'order'   => 'DESC',
	'status'  => 'publish',
] );

if ( empty( $products ) ) return;
?>

<section class="bg-[var(--color-bg-muted)]" aria-labelledby="bestsellers-heading">
	<div class="max-w-7xl mx-auto px-4 py-14 lg:py-20">
		<!-- Header -->
		<div class="flex items-end justify-between mb-8">
			<div>
				<p class="text-xs font-bold tracking-widest uppercase text-brand-green mb-2">🔥 <?php esc_html_e( 'Hot Right Now', 'pemu' ); ?></p>
				<h2 id="bestsellers-heading" class="font-display font-extrabold text-3xl lg:text-4xl text-[var(--color-text)]">
					<?php esc_html_e( 'Best Sellers', 'pemu' ); ?>
				</h2>
			</div>
			<a href="<?php echo esc_url( add_query_arg( 'orderby', 'popularity', wc_get_page_permalink( 'shop' ) ) ); ?>"
			   class="hidden sm:inline-flex items-center gap-1.5 text-brand-green font-semibold text-sm hover:underline">
				<?php esc_html_e( 'View all', 'pemu' ); ?>
				<?php echo pemu_icon( 'arrow-right', [ 'class' => 'w-4 h-4' ] ); ?>
			</a>
		</div>

		<!-- Product grid -->
		<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-5">
			<?php foreach ( $products as $product ) : ?>
			<?php get_template_part( 'template-parts/components/product-card', null, [ 'product' => $product ] ); ?>
			<?php endforeach; ?>
		</div>

		<!-- Mobile view all -->
		<div class="mt-8 flex justify-center sm:hidden">
			<a href="<?php echo esc_url( add_query_arg( 'orderby', 'popularity', wc_get_page_permalink( 'shop' ) ) ); ?>"
			   class="inline-flex items-center gap-1.5 bg-brand-green hover:bg-brand-green-dark text-white font-bold px-7 py-3 rounded-xl transition-colors text-sm">
				<?php esc_html_e( 'Shop Best Sellers', 'pemu' ); ?>
				<?php echo pemu_icon( 'arrow-right', [ 'class' => 'w-4 h-4' ] ); ?>
			</a>
		</div>
	</div>
</section>

<?php
/**
 * Pemu Health Supplements — search.php
 */
defined( 'ABSPATH' ) || exit;
get_header(); ?>
<main id="main-content" class="max-w-7xl mx-auto px-4 py-10 min-h-screen">
	<div class="mb-8">
		<h1 class="font-display font-extrabold text-3xl text-[var(--color-text)]">
			<?php
			printf(
				/* translators: %s: search query */
				esc_html__( 'Search: "%s"', 'pemu' ),
				'<span class="text-brand-green">' . esc_html( get_search_query() ) . '</span>'
			);
			?>
		</h1>
		<?php if ( have_posts() ) : ?>
		<p class="text-[var(--color-text-muted)] mt-2 text-sm">
			<?php printf( esc_html( _n( '%d result found', '%d results found', $wp_query->found_posts, 'pemu' ) ), (int) $wp_query->found_posts ); ?>
		</p>
		<?php endif; ?>
	</div>

	<?php if ( have_posts() ) : ?>
	<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-5">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php
			if ( 'product' === get_post_type() ) {
				$product = wc_get_product( get_the_ID() );
				if ( $product ) {
					get_template_part( 'template-parts/components/product-card', null, [ 'product' => $product ] );
				}
			} else { ?>
			<article class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-5 hover:border-brand-green transition-colors">
				<h2 class="font-semibold text-sm text-[var(--color-text)] mb-2">
					<a href="<?php the_permalink(); ?>" class="hover:text-brand-green"><?php the_title(); ?></a>
				</h2>
				<p class="text-xs text-[var(--color-text-muted)] line-clamp-3"><?php the_excerpt(); ?></p>
			</article>
			<?php } ?>
		<?php endwhile; ?>
	</div>
	<div class="mt-10 flex justify-center"><?php the_posts_pagination(); ?></div>
	<?php else : ?>
	<div class="text-center py-20">
		<p class="text-5xl mb-4" aria-hidden="true">🔍</p>
		<p class="text-[var(--color-text-muted)] text-lg"><?php esc_html_e( 'No results found. Try a different search term.', 'pemu' ); ?></p>
		<div class="mt-8 max-w-md mx-auto"><?php get_search_form(); ?></div>
	</div>
	<?php endif; ?>
</main>
<?php get_footer(); ?>

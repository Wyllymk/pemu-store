<?php
/**
 * Pemu Health Supplements — index.php
 */
defined( 'ABSPATH' ) || exit;

get_header(); ?>
<main id="main-content" class="max-w-4xl mx-auto px-4 py-12 min-h-screen">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-12 pb-12 border-b border-slate-200 dark:border-slate-700 last:border-0' ); ?>>
		<h2 class="font-display font-extrabold text-2xl text-slate-800 dark:text-slate-200 mb-4">
			<a href="<?php the_permalink(); ?>" class="hover:text-brand-green transition-colors"><?php the_title(); ?></a>
		</h2>
		<div class="text-slate-500 dark:text-slate-400 text-xs mb-4"><?php echo get_the_date(); ?></div>
		<div class="prose max-w-none leading-relaxed"><?php the_excerpt(); ?></div>
	</article>
	<?php endwhile; ?>
	<div class="flex justify-center"><?php the_posts_pagination(); ?></div>
	<?php else : ?>
	<div class="text-center py-20">
		<p class="text-slate-500 dark:text-slate-400"><?php esc_html_e( 'No posts found.', 'pemu' ); ?></p>
	</div>
	<?php endif; ?>
</main>
<?php get_footer(); ?>

<?php
/**
 * Pemu Health Supplements — 404.php
 */
defined( 'ABSPATH' ) || exit;
get_header(); ?>
<main id="main-content" class="min-h-[70vh] flex items-center justify-center px-4 py-16">
	<div class="text-center max-w-lg mx-auto">
		<p class="text-[120px] leading-none mb-4 select-none" aria-hidden="true">🏋️</p>
		<h1 class="font-display font-extrabold text-5xl lg:text-6xl text-brand-green mb-3">404</h1>
		<h2 class="font-display font-bold text-2xl text-slate-800 dark:text-slate-200 mb-4">
			<?php esc_html_e( 'Page Not Found', 'pemu' ); ?>
		</h2>
		<p class="text-slate-500 dark:text-slate-400 text-lg mb-8">
			<?php esc_html_e( 'Looks like this page skipped leg day. Let\'s get you back on track.', 'pemu' ); ?>
		</p>
		<div class="flex flex-wrap gap-3 justify-center">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
			   class="inline-flex items-center gap-2 bg-brand-green hover:bg-brand-green-dark text-white font-bold px-7 py-3.5 rounded-xl transition-colors shadow-md shadow-brand-green/30">
				<?php echo pemu_icon( 'home', [ 'class' => 'w-4 h-4' ] ); ?>
				<?php esc_html_e( 'Go Home', 'pemu' ); ?>
			</a>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
			   class="inline-flex items-center gap-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-brand-green text-slate-800 dark:text-slate-200 font-bold px-7 py-3.5 rounded-xl transition-colors">
				<?php echo pemu_icon( 'package', [ 'class' => 'w-4 h-4' ] ); ?>
				<?php esc_html_e( 'Shop Products', 'pemu' ); ?>
			</a>
		</div>
		<!-- Search -->
		<div class="mt-10">
			<p class="text-sm text-slate-500 dark:text-slate-400 mb-3"><?php esc_html_e( 'Or search for a product:', 'pemu' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>

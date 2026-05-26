<?php
/**
 * Pemu Health Supplements — front-page.php
 * Homepage template. Sections controlled via Customizer toggles.
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content">

	<?php get_template_part( 'template-parts/sections/hero' ); ?>

	<?php if ( get_theme_mod( 'pemu_show_trust_bar', true ) ) : ?>
	<?php get_template_part( 'template-parts/sections/trust-bar' ); ?>
	<?php endif; ?>

	<?php if ( get_theme_mod( 'pemu_show_categories', true ) ) : ?>
	<?php get_template_part( 'template-parts/sections/featured-categories' ); ?>
	<?php endif; ?>

	<?php if ( get_theme_mod( 'pemu_show_bestsellers', true ) ) : ?>
	<?php get_template_part( 'template-parts/sections/best-sellers' ); ?>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/sections/why-choose' ); ?>

	<?php if ( get_theme_mod( 'pemu_show_new_arrivals', true ) ) : ?>
	<?php get_template_part( 'template-parts/sections/new-arrivals' ); ?>
	<?php endif; ?>

	<?php if ( get_theme_mod( 'pemu_show_tiktok', true ) ) : ?>
	<?php get_template_part( 'template-parts/sections/tiktok-strip' ); ?>
	<?php endif; ?>

	<?php if ( get_theme_mod( 'pemu_show_testimonials', true ) ) : ?>
	<?php get_template_part( 'template-parts/sections/testimonials' ); ?>
	<?php endif; ?>

	<!-- ── Final CTA ─────────────────────────────────────────── -->
	<section class="max-w-7xl mx-auto px-4 pb-20">
		<div class="relative rounded-3xl bg-gradient-to-br from-brand-green via-brand-navy to-brand-navy p-10 lg:p-16 text-white text-center overflow-hidden">
			<!-- Decorative circles -->
			<div class="absolute -top-20 -right-20 w-72 h-72 rounded-full bg-white/5 pointer-events-none" aria-hidden="true"></div>
			<div class="absolute -bottom-20 -left-20 w-72 h-72 rounded-full bg-white/5 pointer-events-none" aria-hidden="true"></div>
			<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full bg-brand-green/10 blur-3xl pointer-events-none" aria-hidden="true"></div>

			<div class="relative">
				<p class="text-xs font-bold tracking-widest uppercase text-brand-green/80 mb-3"><?php esc_html_e( 'Get Started', 'pemu' ); ?></p>
				<h2 class="font-display font-extrabold text-3xl lg:text-5xl leading-tight">
					<?php esc_html_e( 'Ready to Level Up?', 'pemu' ); ?>
				</h2>
				<p class="mt-4 text-lg text-white/80 max-w-xl mx-auto leading-relaxed">
					<?php esc_html_e( 'Browse the full catalogue or chat with our team on WhatsApp for personalised supplement recommendations.', 'pemu' ); ?>
				</p>
				<div class="mt-8 flex flex-wrap gap-3 justify-center">
					<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
					   class="inline-flex items-center gap-2 bg-white text-brand-navy font-bold px-7 py-4 rounded-xl hover:bg-white/90 hover:scale-105 transition-all duration-200 text-sm shadow-lg">
						<?php echo pemu_icon( 'package', [ 'class' => 'w-4 h-4 text-brand-navy' ] ); ?>
						<?php esc_html_e( 'Shop the Catalogue', 'pemu' ); ?>
					</a>
					<a href="<?php echo esc_url( pemu_whatsapp_url( 'Hi Pemu Health! 👋 I\'d like recommendations for my fitness goals.' ) ); ?>"
					   target="_blank" rel="noopener noreferrer"
					   class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#1db954] text-white font-bold px-7 py-4 rounded-xl hover:scale-105 transition-all duration-200 text-sm shadow-lg">
						<?php echo pemu_icon( 'whatsapp', [ 'class' => 'w-5 h-5' ] ); ?>
						<?php esc_html_e( 'WhatsApp Us Now', 'pemu' ); ?>
					</a>
				</div>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>

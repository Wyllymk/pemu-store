<?php
/**
 * Template part: Why Choose Pemu
 */
defined( 'ABSPATH' ) || exit;

$features = [
	[
		'icon'  => '🧪',
		'title' => __( 'Lab Tested', 'pemu' ),
		'desc'  => __( 'Every batch is independently verified for purity, potency, and banned-substance compliance.', 'pemu' ),
		'color' => 'bg-brand-green/10 text-brand-green',
	],
	[
		'icon'  => '🚀',
		'title' => __( 'Fast Delivery', 'pemu' ),
		'desc'  => __( 'Same-day Nairobi & Mombasa. 24–48hr nationwide via G4S & Wells Fargo.', 'pemu' ),
		'color' => 'bg-orange-500/10 text-orange-500',
	],
	[
		'icon'  => '💯',
		'title' => __( 'Real Results', 'pemu' ),
		'desc'  => __( 'Athletes, lifters, and wellness seekers — backed by over 10,000 verified reviews.', 'pemu' ),
		'color' => 'bg-brand-navy/10 text-brand-navy dark:bg-blue-400/10 dark:text-blue-400',
	],
	[
		'icon'  => '📦',
		'title' => __( 'Discreet Shipping', 'pemu' ),
		'desc'  => __( 'Plain packaging with no branding — your order arrives privately every time.', 'pemu' ),
		'color' => 'bg-purple-500/10 text-purple-500',
	],
	[
		'icon'  => '📱',
		'title' => __( 'M-Pesa Payments', 'pemu' ),
		'desc'  => __( 'Pay via M-Pesa STK push, cash on delivery, or card. Whatever works for you.', 'pemu' ),
		'color' => 'bg-brand-green/10 text-brand-green',
	],
	[
		'icon'  => '🔄',
		'title' => __( 'Easy Returns', 'pemu' ),
		'desc'  => __( '7-day return policy on unopened items. No questions asked via WhatsApp.', 'pemu' ),
		'color' => 'bg-red-500/10 text-red-500',
	],
];
?>

<section class="max-w-7xl mx-auto px-4 py-14 lg:py-20" aria-labelledby="why-heading">
	<div class="text-center max-w-2xl mx-auto mb-12">
		<p class="text-xs font-bold tracking-widest uppercase text-brand-green mb-2"><?php esc_html_e( 'Why Pemu', 'pemu' ); ?></p>
		<h2 id="why-heading" class="font-display font-extrabold text-3xl lg:text-4xl text-[#1a1a2e] dark:text-[#e8edf2]">
			<?php esc_html_e( 'Why 12,000+ Kenyans Choose Pemu', 'pemu' ); ?>
		</h2>
		<p class="text-slate-500 dark:text-slate-400 mt-3">
			<?php esc_html_e( 'We import directly. We test every batch. We deliver discreetly.', 'pemu' ); ?>
		</p>
	</div>
	<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
		<?php foreach ( $features as $f ) : ?>
		<div class="bg-white dark:bg-[#162333] border border-slate-200 dark:border-[#2a3f52] rounded-2xl p-6 hover:border-brand-green hover:shadow-lg transition-all duration-200 group">
			<div class="w-12 h-12 rounded-2xl <?php echo esc_attr( $f['color'] ); ?> flex items-center justify-center text-2xl mb-4">
				<span aria-hidden="true"><?php echo $f['icon']; ?></span>
			</div>
			<h3 class="font-display font-bold text-lg text-[#1a1a2e] dark:text-[#e8edf2] mb-2"><?php echo esc_html( $f['title'] ); ?></h3>
			<p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed"><?php echo esc_html( $f['desc'] ); ?></p>
		</div>
		<?php endforeach; ?>
	</div>
</section>

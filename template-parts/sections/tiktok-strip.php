<?php
/**
 * Template part: TikTok / UGC Social Proof Strip
 */
defined( 'ABSPATH' ) || exit;

$tiktok_handle = get_theme_mod( 'pemu_tiktok_handle', '@pemuhealth' );
$tiktok_cta    = get_theme_mod( 'pemu_tiktok_cta', 'Follow ' . $tiktok_handle );
$tiktok_url    = get_option( 'pemu_social_tiktok', '#' );

// Static UGC cards — in a real deployment these could come from a custom post type or ACF
$ugc_cards = [
	[ 'handle' => '@gymrat_ke',    'quote' => '"This whey is unreal 🔥 best I\'ve tried in Nairobi"', 'gradient' => 'from-pink-500 via-purple-600 to-brand-navy', 'views' => '42K' ],
	[ 'handle' => '@aisha_fitness','quote' => '"Same-day delivery?? Pemu is the real deal 💯"',         'gradient' => 'from-orange-400 via-red-500 to-purple-700',  'views' => '28K' ],
	[ 'handle' => '@ken_lifts',    'quote' => '"Creatine gains are insane, shukrani Pemu 💪"',          'gradient' => 'from-brand-navy via-blue-600 to-cyan-500',   'views' => '65K' ],
	[ 'handle' => '@nairobi_gym',  'quote' => '"Discreet packaging, no one knew 😂 10/10"',            'gradient' => 'from-emerald-500 via-brand-green to-teal-600','views' => '19K' ],
];
?>

<section class="bg-brand-navy text-white overflow-hidden" aria-labelledby="tiktok-heading">
	<div class="max-w-7xl mx-auto px-4 py-14 lg:py-20">

		<!-- Header -->
		<div class="flex items-center justify-between mb-10">
			<div>
				<p class="text-xs font-bold tracking-widest uppercase text-brand-green mb-2"><?php esc_html_e( 'As Seen On', 'pemu' ); ?></p>
				<h2 id="tiktok-heading" class="font-display font-extrabold text-3xl lg:text-4xl">
					<?php esc_html_e( 'TikTok Reviews', 'pemu' ); ?> 🎬
				</h2>
			</div>
			<?php if ( $tiktok_url && '#' !== $tiktok_url ) : ?>
			<a href="<?php echo esc_url( $tiktok_url ); ?>"
			   target="_blank" rel="noopener noreferrer"
			   class="hidden sm:inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-bold px-5 py-2.5 rounded-full transition-colors text-sm border border-white/20">
				<?php echo pemu_icon( 'tiktok', [ 'class' => 'w-4 h-4', 'viewBox' => '0 0 24 24' ] ); ?>
				<?php echo esc_html( $tiktok_cta ); ?>
			</a>
			<?php endif; ?>
		</div>

		<!-- UGC Grid -->
		<div class="grid grid-cols-2 md:grid-cols-4 gap-3 lg:gap-4">
			<?php foreach ( $ugc_cards as $card ) : ?>
			<div class="relative aspect-[9/16] rounded-2xl overflow-hidden group cursor-pointer">
				<!-- Gradient background -->
				<div class="absolute inset-0 bg-gradient-to-br <?php echo esc_attr( $card['gradient'] ); ?> transition-transform duration-500 group-hover:scale-105"></div>

				<!-- Noise texture overlay -->
				<div class="absolute inset-0 opacity-10"
				     style="background-image:url(\"data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E\");background-size:200px;"
				     aria-hidden="true"></div>

				<!-- Play button -->
				<div class="absolute inset-0 flex items-center justify-center">
					<div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:scale-110 group-hover:bg-white/30 transition-all duration-300 shadow-xl">
						<svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
							<path d="M8 5v14l11-7z"/>
						</svg>
					</div>
				</div>

				<!-- Views badge -->
				<div class="absolute top-3 right-3 bg-black/40 backdrop-blur-sm rounded-full px-2 py-0.5 flex items-center gap-1 text-white text-[10px] font-bold">
					<svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
					<?php echo esc_html( $card['views'] ); ?>
				</div>

				<!-- Bottom content -->
				<div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/80 via-black/40 to-transparent">
					<p class="font-bold text-xs text-white"><?php echo esc_html( $card['handle'] ); ?></p>
					<p class="text-[10px] text-white/80 mt-0.5 leading-tight line-clamp-2"><?php echo esc_html( $card['quote'] ); ?></p>
				</div>
			</div>
			<?php endforeach; ?>
		</div>

		<!-- Mobile follow CTA -->
		<?php if ( $tiktok_url && '#' !== $tiktok_url ) : ?>
		<div class="mt-8 flex justify-center sm:hidden">
			<a href="<?php echo esc_url( $tiktok_url ); ?>"
			   target="_blank" rel="noopener noreferrer"
			   class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-bold px-6 py-3 rounded-full transition-colors text-sm border border-white/20">
				<?php echo pemu_icon( 'tiktok', [ 'class' => 'w-4 h-4', 'viewBox' => '0 0 24 24' ] ); ?>
				<?php echo esc_html( $tiktok_cta ); ?>
			</a>
		</div>
		<?php endif; ?>
	</div>
</section>

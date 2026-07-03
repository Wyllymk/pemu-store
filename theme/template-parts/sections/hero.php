<?php
/**
 * Template part: Homepage Hero Section.
 */
defined( 'ABSPATH' ) || exit;

$headline    = get_option( 'pemu_hero_headline',    'Performance Supplements. Kenyan Prices.' );
$subheadline = get_option( 'pemu_hero_subheadline', 'Lab-tested protein, creatine, pre-workout & wellness essentials. Delivered countrywide, paid on M-Pesa.' );
$cta_primary = get_option( 'pemu_hero_cta_primary', 'Shop Now' );
$cta_wa      = get_option( 'pemu_hero_cta_wa',      'Order via WhatsApp' );
$badge       = get_option( 'pemu_hero_badge',       '100% Authentic · Discreet Shipping' );
$social_text = get_option( 'pemu_hero_social_proof','Trusted by 12,000+ Kenyans' );
$hero_product_image = get_option( 'pemu_hero_product_image', '' );
$wa_url            = pemu_whatsapp_url( 'Hi Pemu Health! 👋 I\'d like to place an order.' );
$shop_url    = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' );

// Split headline at last full stop for two-tone effect
preg_match( '/^(.+\\.) (.+)$/', $headline, $parts );
$headline_1 = ! empty( $parts[1] ) ? $parts[1] : $headline;
$headline_2 = ! empty( $parts[2] ) ? $parts[2] : '';
?>

<section class="relative overflow-hidden min-h-[85vh] flex items-center" aria-labelledby="hero-heading">
	<!-- Background -->
	<div class="absolute inset-0 -z-10" aria-hidden="true">
		<div class="absolute inset-0 bg-gradient-to-br from-green-50 via-white to-white dark:from-slate-900 dark:via-slate-800 dark:to-slate-900"></div>
		<!-- Decorative blobs -->
		<div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full bg-brand-green/10 blur-3xl"></div>
		<div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full bg-brand-navy/15 blur-3xl"></div>
	</div>

	<div class="max-w-7xl mx-auto px-4 py-16 lg:py-24 grid lg:grid-cols-2 gap-10 lg:gap-16 items-center w-full">

		<!-- Left: Copy -->
		<div class="max-w-xl">
			<!-- Trust badge pill -->
			<div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand-green/10 border border-brand-green/20 mb-6">
				<span class="w-2 h-2 rounded-full bg-brand-green animate-pulse shrink-0" aria-hidden="true"></span>
				<span class="text-brand-green text-xs font-bold tracking-wide uppercase"><?php echo esc_html( $badge ); ?></span>
			</div>

			<h1 id="hero-heading" class="font-display font-extrabold text-4xl sm:text-5xl lg:text-6xl xl:text-7xl leading-[1.05] tracking-tight">
				<?php if ( $headline_2 ) : ?>
				<span class="text-[#1a1a2e] dark:text-[#e8edf2] block"><?php echo esc_html( $headline_1 ); ?></span>
				<span class="text-brand-green block mt-1"><?php echo esc_html( $headline_2 ); ?></span>
				<?php else : ?>
				<span class="text-[#1a1a2e] dark:text-[#e8edf2]"><?php echo esc_html( $headline ); ?></span>
				<?php endif; ?>
			</h1>

			<p class="mt-5 text-lg text-slate-500 dark:text-slate-400 leading-relaxed max-w-lg">
				<?php echo esc_html( $subheadline ); ?>
			</p>

			<!-- CTAs -->
			<div class="mt-8 flex flex-wrap gap-3">
				<a href="<?php echo esc_url( $shop_url ); ?>"
				   class="inline-flex items-center gap-2 bg-brand-green hover:bg-brand-green-dark text-white font-bold px-7 py-4 rounded-xl shadow-lg shadow-brand-green/30 hover:shadow-brand-green/50 transition-all duration-200 hover:-translate-y-0.5 text-sm">
					<?php echo esc_html( $cta_primary ); ?>
					<?php echo pemu_icon( 'arrow-right', [ 'class' => 'w-4 h-4 shrink-0' ] ); ?>
				</a>
				<a href="<?php echo esc_url( $wa_url ); ?>"
				   target="_blank" rel="noopener noreferrer"
				   class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#1db954] text-white font-bold px-7 py-4 rounded-xl transition-all duration-200 hover:-translate-y-0.5 text-sm">
					<?php echo pemu_icon( 'whatsapp', [ 'class' => 'w-5 h-5 shrink-0' ] ); ?>
					<?php echo esc_html( $cta_wa ); ?>
				</a>
			</div>

			<!-- Social proof avatars -->
			<div class="mt-10 flex items-center gap-4">
				<div class="flex -space-x-2.5" aria-hidden="true">
					<?php
					$avatars = [
						[ 'initials' => 'JM', 'bg' => 'bg-brand-green' ],
						[ 'initials' => 'AK', 'bg' => 'bg-brand-navy' ],
						[ 'initials' => 'SW', 'bg' => 'bg-amber-500' ],
						[ 'initials' => 'NK', 'bg' => 'bg-purple-500' ],
					];
					foreach ( $avatars as $a ) : ?>
					<div class="w-9 h-9 rounded-full <?php echo esc_attr( $a['bg'] ); ?> border-2 border-white dark:border-[#0f1923] flex items-center justify-center text-white text-xs font-bold shrink-0">
						<?php echo esc_html( $a['initials'] ); ?>
					</div>
					<?php endforeach; ?>
				</div>
				<div>
					<div class="flex items-center gap-0.5 text-amber-400" aria-label="<?php esc_attr_e( 'Five star rating', 'pemu' ); ?>">
						<?php for ( $i = 0; $i < 5; $i++ ) : ?>
						<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
						<?php endfor; ?>
					</div>
					<p class="text-sm text-slate-500 dark:text-slate-400"><?php echo esc_html( $social_text ); ?></p>
				</div>
			</div>
		</div>

		<!-- Right: Visual -->
		<div class="relative hidden lg:block" aria-hidden="true">
			<div class="relative mx-auto w-full max-w-md aspect-square">
				<!-- Main product showcase -->
				<div class="relative w-full h-full rounded-3xl overflow-hidden bg-gradient-to-br from-brand-navy to-brand-green p-1 shadow-2xl shadow-brand-green/20">
					<div class="w-full h-full rounded-3xl bg-white dark:bg-[#162333] flex items-center justify-center">
						<?php
						// Use admin-uploaded hero product image, or fallback to featured product, or emoji
						if ( $hero_product_image ) : ?>
							<img src="<?php echo esc_url( $hero_product_image ); ?>"
							     alt=""
							     class="w-4/5 h-4/5 object-contain drop-shadow-2xl"
							     loading="eager"
							     fetchpriority="high">
						<?php
						else :
							$featured = function_exists( 'wc_get_products' ) ? wc_get_products( [ 'featured' => true, 'limit' => 1, 'status' => 'publish' ] ) : [];
							if ( ! empty( $featured ) ) :
								$fp = $featured[0];
								echo wp_get_attachment_image( $fp->get_image_id(), 'pemu-product-single', false, [
									'class' => 'w-4/5 h-4/5 object-contain drop-shadow-2xl',
									'alt'   => esc_attr( $fp->get_name() ),
								] );
							else : ?>
							<span class="text-[160px] drop-shadow-lg select-none">💪</span>
							<?php endif;
						endif; ?>
					</div>
				</div>
				<!-- Floating card: Delivery -->
				<div class="absolute -bottom-5 -left-8 bg-white dark:bg-[#162333] border border-slate-200 dark:border-[#2a3f52] rounded-2xl px-4 py-3 shadow-xl flex items-center gap-3 animate-bounce">
					<div class="w-10 h-10 rounded-full bg-brand-green/10 flex items-center justify-center text-brand-green shrink-0">
						<?php echo pemu_icon( 'zap', [ 'class' => 'w-5 h-5' ] ); ?>
					</div>
					<div>
						<p class="font-bold text-sm text-[#1a1a2e] dark:text-[#e8edf2] leading-tight"><?php esc_html_e( 'Same-Day Delivery', 'pemu' ); ?></p>
						<p class="text-[11px] text-slate-500 dark:text-slate-400"><?php esc_html_e( 'Nairobi & Mombasa', 'pemu' ); ?></p>
					</div>
				</div>
				<!-- Floating card: Secure -->
				<div class="absolute -top-5 -right-8 bg-white dark:bg-[#162333] border border-slate-200 dark:border-[#2a3f52] rounded-2xl px-4 py-3 shadow-xl flex items-center gap-3">
					<div class="w-10 h-10 rounded-full bg-brand-navy/10 flex items-center justify-center text-brand-navy dark:text-blue-300 shrink-0">
						<?php echo pemu_icon( 'lock', [ 'class' => 'w-5 h-5' ] ); ?>
					</div>
					<div>
						<p class="font-bold text-sm text-[#1a1a2e] dark:text-[#e8edf2] leading-tight"><?php esc_html_e( 'M-Pesa Secured', 'pemu' ); ?></p>
						<p class="text-[11px] text-slate-500 dark:text-slate-400"><?php esc_html_e( 'Pay on delivery', 'pemu' ); ?></p>
					</div>
				</div>
				<!-- Floating card: Rating -->
				<div class="absolute top-1/2 -right-12 -translate-y-1/2 bg-white dark:bg-[#162333] border border-slate-200 dark:border-[#2a3f52] rounded-2xl px-3 py-2.5 shadow-xl">
					<div class="flex items-center gap-0.5 text-amber-400">
						<?php for ( $i = 0; $i < 5; $i++ ) : ?>
						<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
						<?php endfor; ?>
					</div>
					<p class="text-xs font-bold text-[#1a1a2e] dark:text-[#e8edf2] mt-0.5">4.9/5</p>
					<p class="text-[10px] text-slate-500 dark:text-slate-400">10k+ reviews</p>
				</div>
			</div>
		</div>

	</div>
</section>

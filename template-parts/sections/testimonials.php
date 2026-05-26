<?php
/**
 * Template part: Testimonials
 */
defined( 'ABSPATH' ) || exit;

$reviews = [
	[ 'name' => 'James M.',  'loc' => 'Nairobi',   'avatar' => 'JM', 'color' => 'bg-brand-green',  'rating' => 5, 'title' => 'Best supplement store in Kenya',    'body' => 'Ordered Friday night, delivered Saturday morning. Quality is top tier. The protein powder mixes smoothly and the flavour is exactly as advertised. Pemu is now my only plug.' ],
	[ 'name' => 'Aisha K.',  'loc' => 'Mombasa',   'avatar' => 'AK', 'color' => 'bg-brand-navy',   'rating' => 5, 'title' => 'Worth every shilling',              'body' => 'I was sceptical about ordering supplements online in Kenya but the packaging was discreet, products are legit and customer care on WhatsApp is outstanding. 10/10.' ],
	[ 'name' => 'Steve W.',  'loc' => 'Kisumu',    'avatar' => 'SW', 'color' => 'bg-amber-500',    'rating' => 5, 'title' => 'Pre-workout is the real deal',       'body' => 'Pre-workout slaps. The energy is clean — no crash, no jitters. Customer service answered every question on WhatsApp within minutes. Will always come back.' ],
	[ 'name' => 'Njeri K.',  'loc' => 'Nakuru',    'avatar' => 'NK', 'color' => 'bg-purple-500',   'rating' => 5, 'title' => 'Authentic & fast',                  'body' => 'Been burned by fake supplements before. Pemu is different — my creatine has the original seal and QR code matches. Delivery to Nakuru was next day. Impressed.' ],
	[ 'name' => 'Brian O.',  'loc' => 'Nairobi',   'avatar' => 'BO', 'color' => 'bg-red-500',      'rating' => 5, 'title' => 'Gains are real 💪',                  'body' => 'Using Pemu\'s stack for 3 months — whey + creatine + multivitamin. Recovery is noticeably faster and I\'ve added 8kg to my bench. These products are genuine.' ],
	[ 'name' => 'Fatuma A.', 'loc' => 'Mombasa',   'avatar' => 'FA', 'color' => 'bg-teal-500',     'rating' => 5, 'title' => 'Wellness supplements are top class', 'body' => 'Ordered the omega-3 and multivitamins. Packaging was beautiful and professional. Arrived on the same day. I\'ve now subscribed to a monthly reorder.' ],
];
?>

<section class="max-w-7xl mx-auto px-4 py-14 lg:py-20" aria-labelledby="reviews-heading">
	<div class="text-center mb-12">
		<p class="text-xs font-bold tracking-widest uppercase text-brand-green mb-2"><?php esc_html_e( 'Customer Stories', 'pemu' ); ?></p>
		<h2 id="reviews-heading" class="font-display font-extrabold text-3xl lg:text-4xl text-[var(--color-text)]">
			<?php esc_html_e( 'Real Reviews. Real Gains.', 'pemu' ); ?>
		</h2>
		<!-- Aggregate rating display -->
		<div class="mt-4 inline-flex items-center gap-3">
			<div class="flex items-center gap-0.5" aria-label="<?php esc_attr_e( 'Five star rating', 'pemu' ); ?>">
				<?php for ( $i = 0; $i < 5; $i++ ) : ?>
				<svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
				<?php endfor; ?>
			</div>
			<span class="font-display font-bold text-xl text-[var(--color-text)]">4.9</span>
			<span class="text-sm text-[var(--color-text-muted)]"><?php esc_html_e( 'from 2,400+ reviews', 'pemu' ); ?></span>
		</div>
	</div>

	<!-- Review grid — masonry-like using CSS columns -->
	<div class="columns-1 sm:columns-2 lg:columns-3 gap-5 space-y-5">
		<?php foreach ( $reviews as $r ) : ?>
		<div class="break-inside-avoid bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-6 hover:border-brand-green/40 hover:shadow-lg transition-all duration-200">
			<!-- Stars -->
			<div class="flex gap-0.5 mb-3" aria-label="<?php echo esc_attr( sprintf( __( 'Rated %d out of 5', 'pemu' ), $r['rating'] ) ); ?>">
				<?php for ( $s = 1; $s <= 5; $s++ ) : ?>
				<svg class="w-3.5 h-3.5 <?php echo $s <= $r['rating'] ? 'text-amber-400' : 'text-[var(--color-border)]'; ?>" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
				<?php endfor; ?>
			</div>

			<p class="font-bold text-sm text-[var(--color-text)] mb-1"><?php echo esc_html( $r['title'] ); ?></p>
			<p class="text-sm text-[var(--color-text-muted)] leading-relaxed">&ldquo;<?php echo esc_html( $r['body'] ); ?>&rdquo;</p>

			<!-- Reviewer -->
			<div class="flex items-center gap-3 mt-4 pt-4 border-t border-[var(--color-border)]">
				<div class="w-9 h-9 rounded-full <?php echo esc_attr( $r['color'] ); ?> flex items-center justify-center text-white text-xs font-bold shrink-0" aria-hidden="true">
					<?php echo esc_html( $r['avatar'] ); ?>
				</div>
				<div>
					<p class="font-semibold text-sm text-[var(--color-text)] leading-none"><?php echo esc_html( $r['name'] ); ?></p>
					<p class="text-xs text-[var(--color-text-muted)] mt-0.5">
						<?php echo pemu_icon( 'map-pin', [ 'class' => 'w-3 h-3 inline -mt-px' ] ); ?>
						<?php echo esc_html( $r['loc'] ); ?>
					</p>
				</div>
				<div class="ml-auto">
					<span class="inline-flex items-center gap-1 text-[10px] font-semibold text-brand-green bg-brand-green/10 px-2 py-0.5 rounded-full">
						<?php echo pemu_icon( 'check-circle', [ 'class' => 'w-3 h-3' ] ); ?>
						<?php esc_html_e( 'Verified', 'pemu' ); ?>
					</span>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</section>

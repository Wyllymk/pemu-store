<?php
/**
 * Template part: Trust Bar
 */
defined( 'ABSPATH' ) || exit;

$threshold = absint( get_theme_mod( 'pemu_free_delivery_threshold', 2000 ) );
$items = [
	[ 'icon' => 'truck',      'title' => sprintf( __( 'Free Delivery', 'pemu' ) ),  'sub' => sprintf( __( 'Orders above %s', 'pemu' ), wc_price( $threshold ) ) ],
	[ 'icon' => 'check-circle','title' => __( '100% Authentic', 'pemu' ),            'sub' => __( 'Lab-tested products', 'pemu' ) ],
	[ 'icon' => 'package',    'title' => __( 'Discreet Packaging', 'pemu' ),         'sub' => __( 'No branding outside', 'pemu' ) ],
	[ 'icon' => 'whatsapp',   'title' => __( '24/7 Support', 'pemu' ),               'sub' => __( 'WhatsApp anytime', 'pemu' ) ],
];
?>
<section class="border-y border-[var(--color-border)] bg-[var(--color-bg-muted)]" aria-label="<?php esc_attr_e( 'Why shop with us', 'pemu' ); ?>">
	<div class="max-w-7xl mx-auto px-4 py-6">
		<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
			<?php foreach ( $items as $item ) : ?>
			<div class="flex items-center gap-3">
				<div class="w-10 h-10 rounded-xl bg-brand-green/10 flex items-center justify-center shrink-0 text-brand-green">
					<?php echo pemu_icon( $item['icon'], [ 'class' => 'w-5 h-5' ] ); ?>
				</div>
				<div>
					<p class="font-bold text-sm text-[var(--color-text)] leading-tight"><?php echo esc_html( $item['title'] ); ?></p>
					<p class="text-xs text-[var(--color-text-muted)] mt-0.5"><?php echo wp_kses_post( $item['sub'] ); ?></p>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
/**
 * Template part: Trust badges row.
 */
$badges = [
	[ 'icon' => 'lock',        'title' => __( 'SSL Secured', 'pemu' ),       'sub' => __( '256-bit encryption', 'pemu' ) ],
	[ 'icon' => 'refresh',     'title' => __( '7-Day Returns', 'pemu' ),     'sub' => __( 'Unopened items', 'pemu' ) ],
	[ 'icon' => 'check-circle','title' => __( '100% Authentic', 'pemu' ),    'sub' => __( 'Lab tested', 'pemu' ) ],
	[ 'icon' => 'truck',       'title' => __( 'Fast Delivery', 'pemu' ),     'sub' => __( 'Same-day Nairobi', 'pemu' ) ],
];
$show_sub = $args['show_sub'] ?? true;
$compact  = $args['compact'] ?? false;
?>
<div class="flex flex-wrap items-center justify-center gap-<?php echo $compact ? '3' : '4'; ?> py-4">
	<?php foreach ( $badges as $badge ) : ?>
	<div class="flex flex-col items-center text-center gap-1 min-w-[60px]">
		<span class="text-brand-green"><?php echo pemu_icon( $badge['icon'], [ 'class' => 'w-5 h-5' ] ); ?></span>
		<span class="text-[10px] font-bold text-[#1a1a2e] dark:text-[#e8edf2] leading-tight"><?php echo esc_html( $badge['title'] ); ?></span>
		<?php if ( $show_sub ) : ?>
		<span class="text-[9px] text-slate-500 dark:text-slate-400 leading-tight"><?php echo esc_html( $badge['sub'] ); ?></span>
		<?php endif; ?>
	</div>
	<?php endforeach; ?>
</div>

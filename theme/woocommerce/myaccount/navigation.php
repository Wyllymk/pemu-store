<?php
/**
 * WooCommerce — myaccount/navigation.php
 * @version 9.3.0
 */
defined( 'ABSPATH' ) || exit;

$nav_icons = [
	'dashboard'       => 'home',
	'orders'          => 'package',
	'downloads'       => 'arrow-right',
	'edit-address'    => 'map-pin',
	'payment-methods' => 'credit-card',
	'edit-account'    => 'user',
	'customer-logout' => 'close',
];
?>
<nav class="woocommerce-MyAccount-navigation bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden"
     aria-label="<?php esc_attr_e( 'Account navigation', 'pemu' ); ?>">
	<ul class="list-none p-2 m-0 space-y-0.5">
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) :
			$icon    = $nav_icons[ $endpoint ] ?? 'arrow-right';
			$is_active = wc_get_account_endpoint_url( $endpoint ) === remove_query_arg( 'paged' );
			if ( 'customer-logout' === $endpoint ) :
		?>
		<li class="mt-2 pt-2 border-t border-slate-200 dark:border-slate-700">
			<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"
			   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-red-500 hover:bg-red-500/10 transition-colors group">
				<?php echo pemu_icon( 'close', [ 'class' => 'w-4 h-4 shrink-0' ] ); ?>
				<?php echo esc_html( $label ); ?>
			</a>
		</li>
		<?php else : ?>
		<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
			<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"
			   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-colors group <?php echo $is_active ? 'bg-brand-green/10 text-brand-green' : 'text-slate-800 dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-brand-green'; ?>">
				<?php echo pemu_icon( $icon, [ 'class' => 'w-4 h-4 shrink-0' ] ); ?>
				<?php echo esc_html( $label ); ?>
			</a>
		</li>
		<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</nav>

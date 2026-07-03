<?php
/**
 * WooCommerce — notices/notice.php (info)
 * @version 10.4.0
 */
defined( 'ABSPATH' ) || exit;
if ( ! $notices ) return;
?>
<div role="status" class="woocommerce-info pemu-notice-info w-full max-w-4xl mx-auto mt-6 mb-6 px-4 space-y-3 z-50 relative" tabindex="-1">
	<?php foreach ( $notices as $notice ) : ?>
	<div class="flex items-start sm:items-center gap-4 bg-white dark:bg-slate-800 border-l-4 border-blue-500 rounded-r-2xl p-4 sm:p-5 shadow-lg">
		<span class="shrink-0 text-blue-500 bg-blue-500/10 rounded-full p-2">
			<?php echo pemu_icon( 'info', [ 'class' => 'w-5 h-5 sm:w-6 sm:h-6' ] ); ?>
		</span>
		<div class="flex-1 text-slate-800 dark:text-slate-200 text-sm sm:text-base font-medium leading-relaxed [&_a]:text-blue-600 dark:[&_a]:text-blue-400 [&_a]:font-semibold [&_a]:underline [&_a:hover]:text-blue-700 dark:[&_a:hover]:text-blue-300 [&_a:hover]:decoration-2">
			<?php echo wp_kses_post( $notice['notice'] ); ?>
		</div>
	</div>
	<?php endforeach; ?>
</div>

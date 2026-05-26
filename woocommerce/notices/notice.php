<?php
/**
 * WooCommerce — notices/notice.php (info)
 * @version 8.1.0
 */
defined( 'ABSPATH' ) || exit;
if ( ! $notices ) return;
?>
<div role="status" class="woocommerce-info pemu-notice-info">
    <?php foreach ( $notices as $notice ) : ?>
    <div class="flex items-start gap-3 bg-blue-500/8 border border-blue-500/25 rounded-xl p-4 mb-3 text-sm w-full">
        <span class="shrink-0 text-blue-500 mt-0.5"><?php echo pemu_icon( 'info', [ 'class' => 'w-5 h-5' ] ); ?></span>
        <div class="flex-1 text-[var(--color-text)]"><?php echo wp_kses_post( $notice['notice'] ); ?></div>
    </div>
    <?php endforeach; ?>
</div>
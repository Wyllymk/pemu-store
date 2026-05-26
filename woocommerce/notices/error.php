<?php
/**
 * WooCommerce — notices/error.php
 * @version 8.1.0
 */
defined( 'ABSPATH' ) || exit;
if ( ! $notices ) return;
?>
<div role="alert" class="woocommerce-error pemu-notice-error">
    <?php foreach ( $notices as $notice ) : ?>
    <div class="flex items-start gap-3 bg-red-500/8 border border-red-500/25 rounded-xl p-4 mb-3 text-sm w-full">
        <span class="shrink-0 text-red-500 mt-0.5"><?php echo pemu_icon( 'alert', [ 'class' => 'w-5 h-5' ] ); ?></span>
        <div class="flex-1 text-[var(--color-text)]"><?php echo wp_kses_post( $notice['notice'] ); ?></div>
    </div>
    <?php endforeach; ?>
</div>
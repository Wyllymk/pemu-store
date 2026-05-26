<?php
/**
 * WooCommerce — notices/success.php
 * Pemu override: styled success notice.
 * @version 3.9.0
 */
defined( 'ABSPATH' ) || exit;

if ( ! $notices ) return;
?>
<div role="alert" class="woocommerce-message pemu-notice-success">
    <?php foreach ( $notices as $notice ) : ?>
    <div
        class="flex items-start gap-3 bg-brand-green/8 border border-brand-green/25 rounded-xl p-4 mb-3 text-sm w-full">
        <span
            class="shrink-0 text-brand-green mt-0.5"><?php echo pemu_icon( 'check-circle', [ 'class' => 'w-5 h-5' ] ); ?></span>
        <div class="flex-1 text-[var(--color-text)]"><?php echo wp_kses_post( $notice['notice'] ); ?></div>
    </div>
    <?php endforeach; ?>
</div>
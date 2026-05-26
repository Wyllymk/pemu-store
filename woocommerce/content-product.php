<?php
/**
 * WooCommerce — content-product.php
 * Pemu override: single product card in shop loops.
 * All WC hooks preserved.
 *
 * @version 3.6.0
 */
defined( 'ABSPATH' ) || exit;

global $product;
if ( ! $product instanceof WC_Product ) return;

// Ensure WC loop setup.
$post_object = get_post();
setup_postdata( $post_object );

$permalink     = $product->get_permalink();
$name          = $product->get_name();
$in_stock      = $product->is_in_stock();
$is_on_sale    = $product->is_on_sale();
$is_featured   = $product->is_featured();
$avg_rating    = (float) $product->get_average_rating();
$review_count  = (int)   $product->get_review_count();
$reg_price     = (float) $product->get_regular_price();
$sale_price    = (float) $product->get_sale_price();
$img_id        = $product->get_image_id();
$brand         = get_post_meta( $product->get_id(), '_brand', true ) ?: '';
$is_new        = $product->get_date_created() && ( time() - $product->get_date_created()->getTimestamp() ) < 30 * DAY_IN_SECONDS;

// Badge
$badge_text  = '';
$badge_class = '';
if ( ! $in_stock ) {
	$badge_text  = __( 'Sold Out', 'pemu' );
	$badge_class = 'bg-[var(--color-text-muted)]';
} elseif ( $is_featured ) {
	$badge_text  = __( 'BESTSELLER', 'pemu' );
	$badge_class = 'bg-brand-green';
} elseif ( $is_on_sale && $reg_price > 0 && $sale_price > 0 ) {
	$pct         = round( ( ( $reg_price - $sale_price ) / $reg_price ) * 100 );
	$badge_text  = '-' . $pct . '%';
	$badge_class = 'bg-red-500';
} elseif ( $is_new ) {
	$badge_text  = __( 'NEW', 'pemu' );
	$badge_class = 'bg-brand-navy';
}

// WhatsApp URL
$wa_msg = "Hi Pemu Health! 👋 I'd like to order: *{$name}*\n{$permalink}";
$wa_url = pemu_whatsapp_url( $wa_msg );

// Thumbnail
$img_html = $img_id
	? wp_get_attachment_image( $img_id, 'pemu-product-card', false, [
		'class'   => 'w-full h-full object-contain transition-transform duration-500 group-hover:scale-105',
		'loading' => 'lazy',
		'alt'     => esc_attr( $name ),
	] )
	: '<span class="text-7xl select-none" aria-hidden="true">💊</span>';
?>

<li
    <?php wc_product_class( 'group relative bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl overflow-hidden hover:shadow-xl hover:shadow-black/5 hover:-translate-y-1 transition-all duration-300 flex flex-col list-none', $product ); ?>>

    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

    <!-- Image -->
    <a href="<?php echo esc_url( $permalink ); ?>"
        class="block relative bg-gradient-to-br from-brand-light to-white dark:from-[#1C2B38] dark:to-[#0F1923] overflow-hidden flex items-center justify-center"
        <?php do_action( 'woocommerce_product_loop_item_link_open' ); ?>>

        <?php
		/**
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );
		?>

        <?php echo $img_html; // phpcs:ignore ?>

        <!-- Out of stock overlay -->
        <?php if ( ! $in_stock ) : ?>
        <div class="absolute inset-0 bg-[var(--color-surface)]/60 flex items-center justify-center pointer-events-none">
            <span
                class="text-xs font-bold text-[var(--color-text-muted)] bg-[var(--color-surface)] px-3 py-1 rounded-full border border-[var(--color-border)]">
                <?php esc_html_e( 'Out of Stock', 'pemu' ); ?>
            </span>
        </div>
        <?php endif; ?>
    </a>

    <?php do_action( 'woocommerce_product_loop_item_link_close' ); ?>

    <!-- Badge -->
    <?php if ( $badge_text ) : ?>
    <span
        class="absolute top-2.5 left-2.5 z-10 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold text-white tracking-wide <?php echo esc_attr( $badge_class ); ?>">
        <?php echo esc_html( $badge_text ); ?>
    </span>
    <?php endif; ?>

    <!-- WhatsApp quick-order (hover) -->
    <?php if ( $in_stock ) : ?>
    <a href="<?php echo esc_url( $wa_url ); ?>" target="_blank" rel="noopener noreferrer"
        class="absolute top-2.5 right-2.5 z-10 w-8 h-8 rounded-full bg-[#25D366] text-white flex items-center justify-center shadow-md opacity-0 group-hover:opacity-100 translate-y-1 group-hover:translate-y-0 transition-all duration-200"
        aria-label="<?php echo esc_attr( sprintf( __( 'Order %s via WhatsApp', 'pemu' ), $name ) ); ?>">
        <?php echo pemu_icon( 'whatsapp', [ 'class' => 'w-3.5 h-3.5' ] ); ?>
    </a>
    <?php endif; ?>

    <!-- Card body -->
    <div class="flex flex-col flex-1 p-4 gap-2">

        <?php if ( $brand ) : ?>
        <p class="text-[10px] font-bold tracking-widest uppercase text-[var(--color-text-muted)]">
            <?php echo esc_html( $brand ); ?></p>
        <?php endif; ?>

        <h2 class="woocommerce-loop-product__title">
            <a href="<?php echo esc_url( $permalink ); ?>"
                class="font-semibold text-sm leading-snug line-clamp-2 text-[var(--color-text)] hover:text-brand-green transition-colors">
                <?php echo esc_html( $name ); ?>
            </a>
        </h2>

        <?php
		/**
		 * @hooked woocommerce_template_loop_rating  - 5
		 */
		// do_action( 'woocommerce_after_shop_loop_item_title' );
		?>

        <!-- Price + ATC row -->
        <div class="flex items-end justify-between mt-auto pt-2">
            <div class="flex flex-col gap-0.5">
                <?php
				/**
				 * @hooked woocommerce_template_loop_price - 10
				 */
				do_action( 'woocommerce_after_shop_loop_item_title_price' );
				echo '<span class="font-display font-bold text-brand-green text-base leading-tight">';
				echo wp_kses_post( $product->get_price_html() );
				echo '</span>';
				?>
            </div>

            <?php if ( $in_stock ) : ?>
            <?php
			/**
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			?>
            <!-- <a href="<?php echo esc_url( $product->is_type( 'simple' ) ? add_query_arg( [ 'add-to-cart' => $product->get_id(), 'quantity' => 1 ], wc_get_cart_url() ) : $permalink ); ?>"
                <?php if ( $product->is_type( 'simple' ) ) : ?>
                data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
                data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
                aria-label="<?php echo esc_attr( sprintf( __( 'Add %s to cart', 'pemu' ), $name ) ); ?>" rel="nofollow"
                class="add_to_cart_button ajax_add_to_cart product_type_simple shrink-0 w-9 h-9 rounded-full bg-brand-navy hover:bg-brand-green text-white flex items-center justify-center transition-colors duration-200 shadow-sm"
                <?php else : ?> aria-label="<?php echo esc_attr( sprintf( __( 'View %s', 'pemu' ), $name ) ); ?>"
                class="shrink-0 w-9 h-9 rounded-full bg-brand-navy hover:bg-brand-green text-white flex items-center justify-center transition-colors duration-200 shadow-sm"
                <?php endif; ?>>
                <?php echo pemu_icon( 'plus', [ 'class' => 'w-4 h-4' ] ); ?>
            </a> -->
            <?php endif; ?>
        </div>

    </div>

    <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
</li>
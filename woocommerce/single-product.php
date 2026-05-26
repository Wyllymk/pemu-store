<?php
/**
 * WooCommerce — single-product.php
 * Pemu override. All WC hooks preserved.
 *
 * @version 1.6.4
 */
defined( 'ABSPATH' ) || exit;

get_header();

global $product;
if ( ! $product instanceof WC_Product ) {
	$product = wc_get_product( get_the_ID() );
}
?>

<main id="main-content" class="min-h-screen">

    <?php while ( have_posts() ) : the_post(); ?>

    <?php do_action( 'woocommerce_before_single_product' ); ?>

    <article id="product-<?php the_ID(); ?>" <?php wc_product_class( 'pemu-single-product', $product ); ?>>

        <!-- Breadcrumb -->
        <div class="max-w-7xl mx-auto px-4 pt-5">
            <?php woocommerce_breadcrumb(); ?>
        </div>

        <!-- Product area -->
        <div class="max-w-7xl mx-auto px-4 py-6 lg:py-10">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-14" id="product-options">

                <!-- ── GALLERY COLUMN ─────────────────────────────── -->
                <div x-data="productGallery()" x-init="init()" class="product-gallery">
                    <?php
					/**
					 * woocommerce_before_single_product_summary hook.
					 * @hooked woocommerce_show_product_sale_flash - 10
					 * @hooked woocommerce_show_product_images - 20
					 */
					do_action( 'woocommerce_before_single_product_summary' );
					?>
                </div>

                <!-- ── SUMMARY COLUMN ────────────────────────────────── -->
                <div class="product-summary flex flex-col gap-4" id="product-summary">
                    <?php
					/**
					 * woocommerce_single_product_summary hook.
					 * @hooked woocommerce_template_single_title       - 5
					 * @hooked woocommerce_template_single_rating       - 10
					 * @hooked woocommerce_template_single_price        - 10
					 * @hooked woocommerce_template_single_excerpt      - 20
					 * @hooked woocommerce_template_single_add_to_cart  - 30
					 * @hooked woocommerce_template_single_meta         - 40
					 * @hooked woocommerce_template_single_sharing      - 50
					 * @hooked WC_Structured_Data::generate_product_data() - 60
					 */
					do_action( 'woocommerce_single_product_summary' );
					?>

                    <!-- Trust badges -->
                    <div class="mt-6 pt-6 border-t border-[var(--color-border)]">
                        <?php get_template_part( 'template-parts/components/trust-badges', null, [ 'compact' => true ] ); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── TABS + RELATED ──────────────────────────────────── -->
        <div class="max-w-7xl mx-auto p-4">
            <?php
			/**
			 * woocommerce_after_single_product_summary hook.
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display           - 15
			 * @hooked woocommerce_output_related_products  - 20
			 */
			do_action( 'woocommerce_after_single_product_summary' );
			?>
        </div>

        <?php do_action( 'woocommerce_after_single_product' ); ?>
    </article>

    <?php endwhile; ?>

    <!-- Sticky ATC -->
    <?php
	if ( $product instanceof WC_Product ) {
		get_template_part( 'template-parts/components/sticky-atc', null, [ 'product' => $product ] );
	}
	?>

</main>

<?php get_footer(); ?>
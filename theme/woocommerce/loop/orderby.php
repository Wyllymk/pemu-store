<?php
/**
 * WooCommerce — loop/orderby.php
 * @version 9.7.0
 */
defined( 'ABSPATH' ) || exit;

$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', [
	'menu_order' => __( 'Default sorting', 'woocommerce' ),
	'popularity' => __( 'Sort by popularity', 'woocommerce' ),
	'rating'     => __( 'Sort by average rating', 'woocommerce' ),
	'date'       => __( 'Sort by latest', 'woocommerce' ),
	'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
	'price-desc' => __( 'Sort by price: high to low', 'woocommerce' ),
] );

$orderby = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );
?>
<form class="woocommerce-ordering my-4" method="get">
    <select name="orderby"
        class="orderby px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-green cursor-pointer"
        aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
        <?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
        <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>>
            <?php echo esc_html( $name ); ?></option>
        <?php endforeach; ?>
    </select>
    <?php wc_query_string_form_fields( null, [ 'orderby', 'submit', 'paged', 'product-page' ] ); ?>
</form>

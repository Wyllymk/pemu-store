<?php
/**
 * Pemu Health Supplements — sidebar.php
 * WooCommerce will call this for its sidebar hook.
 * We disable the default WC sidebar in inc/woocommerce.php.
 */
defined( 'ABSPATH' ) || exit;

if ( is_active_sidebar( 'shop-filters' ) ) {
	dynamic_sidebar( 'shop-filters' );
}

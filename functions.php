<?php
/**
 * Pemu Health Supplements — functions.php
 *
 * Bootstraps all theme modules. No logic lives here.
 * Decision tree: if WooCommerce already does it, use the WC hook/filter.
 */

defined( 'ABSPATH' ) || exit;

// -----------------------------------------------------------------
// Autoload inc/ modules
// -----------------------------------------------------------------
$pemu_modules = [
	'inc/helpers.php',
	'inc/setup.php',
	'inc/enqueue.php',
	'inc/woocommerce.php',
	'inc/seo.php',
	'inc/whatsapp.php',
	'inc/customizer.php',
];

foreach ( $pemu_modules as $module ) {
	$path = get_theme_file_path( $module );
	if ( file_exists( $path ) ) {
		require_once $path;
	}
}

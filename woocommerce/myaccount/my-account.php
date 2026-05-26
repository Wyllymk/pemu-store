<?php
/**
 * WooCommerce — myaccount/my-account.php
 * Pemu override: account dashboard wrapper.
 * @version 3.5.0
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="main-content" class="min-h-screen bg-[var(--color-bg-muted)]">
<div class="max-w-6xl mx-auto px-4 py-8 lg:py-12">

	<!-- Page header -->
	<div class="mb-8">
		<h1 class="font-display font-extrabold text-3xl lg:text-4xl text-[var(--color-text)]">
			<?php
			if ( is_user_logged_in() ) {
				printf(
					/* translators: %s: display name */
					esc_html__( 'Welcome back, %s 👋', 'pemu' ),
					esc_html( wp_get_current_user()->display_name )
				);
			} else {
				esc_html_e( 'My Account', 'pemu' );
			}
			?>
		</h1>
		<p class="text-[var(--color-text-muted)] mt-2 text-sm">
			<?php esc_html_e( 'Manage your orders, address, and account settings.', 'pemu' ); ?>
		</p>
	</div>

	<div class="grid lg:grid-cols-[240px_1fr] gap-6 items-start">

		<!-- Navigation sidebar -->
		<div class="lg:sticky lg:top-24">
			<?php do_action( 'woocommerce_account_navigation' ); ?>
		</div>

		<!-- Content area -->
		<div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-6 lg:p-8">
			<?php
			/**
			 * @hooked woocommerce_account_content
			 */
			do_action( 'woocommerce_account_content' );
			?>
		</div>
	</div>
</div>
</main>
<?php get_footer(); ?>

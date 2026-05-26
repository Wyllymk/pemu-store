<?php
/**
 * WooCommerce — checkout/form-checkout.php
 * Pemu override: styled checkout with progress steps.
 * ALL WC ACTION HOOKS PRESERVED — never remove them.
 *
 * @version 3.5.0
 */
defined( 'ABSPATH' ) || exit;

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
?>

<?php get_header(); ?>

<main id="main-content" class="min-h-screen bg-[var(--color-bg-muted)]">

	<!-- Progress Steps -->
	<div class="bg-[var(--color-surface)] border-b border-[var(--color-border)]">
		<div class="max-w-6xl mx-auto px-4 py-5">
			<ol class="flex items-center justify-center gap-2 sm:gap-6 text-xs sm:text-sm" aria-label="<?php esc_attr_e( 'Checkout progress', 'pemu' ); ?>">
				<!-- Step 1: Cart (complete) -->
				<li class="flex items-center gap-2 text-brand-green" aria-label="<?php esc_attr_e( 'Cart - Complete', 'pemu' ); ?>">
					<span class="w-7 h-7 rounded-full bg-brand-green text-white font-bold flex items-center justify-center text-xs" aria-hidden="true">
						<?php echo pemu_icon( 'check', [ 'class' => 'w-4 h-4' ] ); ?>
					</span>
					<span class="font-bold hidden sm:inline"><?php esc_html_e( 'Cart', 'pemu' ); ?></span>
				</li>
				<li class="w-8 sm:w-16 h-0.5 bg-brand-green rounded" aria-hidden="true"></li>
				<!-- Step 2: Checkout (current) -->
				<li class="flex items-center gap-2 text-brand-green" aria-current="step" aria-label="<?php esc_attr_e( 'Checkout - Current', 'pemu' ); ?>">
					<span class="w-7 h-7 rounded-full bg-brand-green text-white font-bold flex items-center justify-center text-xs" aria-hidden="true">2</span>
					<span class="font-bold hidden sm:inline"><?php esc_html_e( 'Checkout', 'pemu' ); ?></span>
				</li>
				<li class="w-8 sm:w-16 h-0.5 bg-[var(--color-border)] rounded" aria-hidden="true"></li>
				<!-- Step 3: Confirmation (pending) -->
				<li class="flex items-center gap-2 text-[var(--color-text-muted)]" aria-label="<?php esc_attr_e( 'Confirmation - Pending', 'pemu' ); ?>">
					<span class="w-7 h-7 rounded-full bg-[var(--color-border)] text-[var(--color-text-muted)] font-bold flex items-center justify-center text-xs" aria-hidden="true">3</span>
					<span class="font-bold hidden sm:inline"><?php esc_html_e( 'Confirmation', 'pemu' ); ?></span>
				</li>
			</ol>
		</div>
	</div>

	<div class="max-w-6xl mx-auto px-4 py-8">
		<?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>

		<!-- WooCommerce validates nonce, security + form fields via its own js/php -->
		<form name="checkout" method="post"
		      class="checkout woocommerce-checkout grid lg:grid-cols-[1fr_400px] gap-8 items-start"
		      action="<?php echo esc_url( wc_get_checkout_url() ); ?>"
		      enctype="multipart/form-data">

			<!-- ── LEFT: FORM FIELDS ─────────────────────────── -->
			<div class="space-y-6">

				<?php if ( $checkout->get_checkout_fields() ) : ?>
				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<!-- Contact -->
				<section class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-6">
					<div class="flex items-center justify-between mb-5">
						<h2 class="font-display font-bold text-xl text-[var(--color-text)]"><?php esc_html_e( 'Contact', 'pemu' ); ?></h2>
						<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
						<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'dashboard' ) ); ?>"
						   class="text-xs text-brand-green font-semibold hover:underline">
							<?php esc_html_e( 'Log in', 'pemu' ); ?>
						</a>
						<?php endif; ?>
					</div>
					<div id="customer_details">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div>
				</section>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
				<?php endif; ?>

				<!-- Shipping method -->
				<section class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-6">
					<h2 class="font-display font-bold text-xl text-[var(--color-text)] mb-5"><?php esc_html_e( 'Shipping Method', 'pemu' ); ?></h2>
					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</section>

				<!-- Order notes -->
				<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>
				<section class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-6">
					<h2 class="font-display font-bold text-xl text-[var(--color-text)] mb-4"><?php esc_html_e( 'Delivery Notes', 'pemu' ); ?></h2>
					<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
					<?php endforeach; ?>
				</section>
				<?php endif; ?>

			</div>

			<!-- ── RIGHT: ORDER SUMMARY + PAYMENT ──────────────── -->
			<div class="lg:sticky lg:top-24 space-y-5">

				<!-- Order Review -->
				<div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-6">
					<h2 class="font-display font-bold text-xl text-[var(--color-text)] mb-5"><?php esc_html_e( 'Order Summary', 'pemu' ); ?></h2>
					<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
				</div>

				<!-- Payment -->
				<div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-6">
					<?php do_action( 'woocommerce_review_order_before_payment' ); ?>
					<?php do_action( 'woocommerce_checkout_payment' ); ?>
					<?php do_action( 'woocommerce_review_order_after_payment' ); ?>
				</div>

				<!-- Terms + footer links -->
				<p class="text-[11px] text-[var(--color-text-muted)] text-center leading-relaxed px-2">
					<?php
					printf(
						/* translators: %1$s: terms URL, %2$s: privacy URL */
						wp_kses(
							__( 'By placing your order you agree to our <a href="%1$s" class="underline hover:text-brand-green">Terms</a> &amp; <a href="%2$s" class="underline hover:text-brand-green">Privacy Policy</a>.', 'pemu' ),
							[ 'a' => [ 'href' => [], 'class' => [] ] ]
						),
						esc_url( get_permalink( get_page_by_path( 'terms-conditions' ) ) ?: '#' ),
						esc_url( get_privacy_policy_url() ?: '#' )
					);
					?>
				</p>
			</div>

		</form>

		<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
	</div>

</main>

<?php get_footer(); ?>

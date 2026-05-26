<?php
/**
 * WooCommerce — checkout/thankyou.php
 * Pemu override: polished order confirmation page.
 *
 * @version 3.7.0
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="main-content" class="min-h-screen bg-[var(--color-bg-muted)]">
<div class="max-w-3xl mx-auto px-4 py-12">

<?php if ( $order ) : ?>

	<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

	<!-- Success animation header -->
	<div class="text-center mb-10">
		<div class="relative inline-flex items-center justify-center w-24 h-24 rounded-full bg-brand-green/10 mb-6 mx-auto">
			<div class="w-16 h-16 rounded-full bg-brand-green flex items-center justify-center animate-[ping_1s_ease-out_1]" aria-hidden="true">
				<?php echo pemu_icon( 'check', [ 'class' => 'w-8 h-8 text-white' ] ); ?>
			</div>
			<div class="absolute inset-0 rounded-full border-4 border-brand-green/20"></div>
		</div>
		<p class="text-xs font-bold tracking-widest uppercase text-brand-green mb-2">
			<?php esc_html_e( 'Order Confirmed', 'pemu' ); ?>
		</p>
		<h1 class="font-display font-extrabold text-3xl lg:text-4xl text-[var(--color-text)]">
			<?php
			printf(
				/* translators: %s: first name */
				esc_html__( 'Thank you, %s! 🎉', 'pemu' ),
				esc_html( $order->get_billing_first_name() )
			);
			?>
		</h1>
		<p class="mt-3 text-[var(--color-text-muted)] text-lg">
			<?php esc_html_e( 'Your order has been received and is being processed.', 'pemu' ); ?>
		</p>
	</div>

	<!-- Order meta cards -->
	<div class="grid sm:grid-cols-3 gap-4 mb-8">
		<div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-5 text-center">
			<div class="text-2xl mb-2" aria-hidden="true">📦</div>
			<p class="text-xs font-bold uppercase tracking-widest text-[var(--color-text-muted)] mb-1"><?php esc_html_e( 'Order Number', 'pemu' ); ?></p>
			<p class="font-display font-bold text-xl text-[var(--color-text)]">#<?php echo esc_html( $order->get_order_number() ); ?></p>
		</div>
		<div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-5 text-center">
			<div class="text-2xl mb-2" aria-hidden="true">💰</div>
			<p class="text-xs font-bold uppercase tracking-widest text-[var(--color-text-muted)] mb-1"><?php esc_html_e( 'Total', 'pemu' ); ?></p>
			<p class="font-display font-bold text-xl text-brand-green"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></p>
		</div>
		<div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-5 text-center">
			<div class="text-2xl mb-2" aria-hidden="true">📱</div>
			<p class="text-xs font-bold uppercase tracking-widest text-[var(--color-text-muted)] mb-1"><?php esc_html_e( 'Payment', 'pemu' ); ?></p>
			<p class="font-semibold text-sm text-[var(--color-text)]"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></p>
		</div>
	</div>

	<!-- WooCommerce fills order details table here -->
	<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<!-- Email notice -->
	<?php if ( $order->get_billing_email() ) : ?>
	<div class="flex items-start gap-3 bg-brand-green/5 border border-brand-green/20 rounded-2xl p-5 mb-6">
		<?php echo pemu_icon( 'mail', [ 'class' => 'w-5 h-5 text-brand-green shrink-0 mt-0.5' ] ); ?>
		<p class="text-sm text-[var(--color-text)]">
			<?php
			printf(
				/* translators: %s: email */
				esc_html__( 'A confirmation email has been sent to %s', 'pemu' ),
				'<strong class="text-brand-green">' . esc_html( $order->get_billing_email() ) . '</strong>'
			);
			?>
		</p>
	</div>
	<?php endif; ?>

	<!-- CTA buttons -->
	<div class="flex flex-col sm:flex-row gap-3 mt-8">
		<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>"
		   class="flex-1 flex items-center justify-center gap-2 py-4 rounded-xl bg-brand-navy hover:bg-brand-navy/90 text-white font-bold transition-colors">
			<?php echo pemu_icon( 'package', [ 'class' => 'w-5 h-5' ] ); ?>
			<?php esc_html_e( 'View My Orders', 'pemu' ); ?>
		</a>
		<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
		   class="flex-1 flex items-center justify-center gap-2 py-4 rounded-xl bg-[var(--color-surface)] border border-[var(--color-border)] hover:border-brand-green text-[var(--color-text)] font-bold transition-colors">
			<?php echo pemu_icon( 'arrow-left', [ 'class' => 'w-5 h-5' ] ); ?>
			<?php esc_html_e( 'Continue Shopping', 'pemu' ); ?>
		</a>
	</div>

<?php else : ?>

	<!-- Guest confirmation (no order object) -->
	<div class="text-center py-20">
		<div class="text-6xl mb-6" aria-hidden="true">✅</div>
		<h1 class="font-display font-extrabold text-3xl text-[var(--color-text)]">
			<?php esc_html_e( 'Thank you for your order!', 'pemu' ); ?>
		</h1>
		<p class="mt-3 text-[var(--color-text-muted)]">
			<?php echo wp_kses_post( apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Your order has been received. We\'ll be in touch shortly.', 'pemu' ), null ) ); ?>
		</p>
		<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
		   class="inline-flex items-center gap-2 mt-8 bg-brand-green hover:bg-brand-green-dark text-white font-bold px-8 py-4 rounded-xl transition-colors">
			<?php esc_html_e( 'Continue Shopping', 'pemu' ); ?>
		</a>
	</div>

<?php endif; ?>

</div>
</main>
<?php get_footer(); ?>

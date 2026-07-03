<?php
/**
 * WooCommerce checkout/form-checkout.php — Pemu override
 * ALL WC hooks preserved.
 * @version 9.4.0
 */
defined('ABSPATH') || exit;

if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
  echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.','woocommerce')));
  get_footer(); return;
}

get_header();
?>
<main id="main-content" class="min-h-screen bg-gray-100 dark:bg-slate-800">

<style>
/* Minimal check: invalid/valid state overrides (cannot do via filter) */
.woocommerce-invalid input { border-color: #ef4444 !important; }
.woocommerce-invalid label { color: #ef4444 !important; }
.woocommerce-validated input { border-color: #6DB33F !important; }
/* Checkout coupon form — styled to match theme */
form.checkout_coupon.woocommerce-form-coupon {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 1rem;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.25rem;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.75rem;
}
.dark form.checkout_coupon.woocommerce-form-coupon {
    background: #1e293b;
    border-color: #334155;
}
form.checkout_coupon .form-row-first {
    flex: 1;
    min-width: 160px;
    margin: 0;
}
form.checkout_coupon .form-row-last {
    margin: 0;
}
form.checkout_coupon input#coupon_code.input-text {
    width: 100%;
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    font-size: 0.875rem;
    color: #1e293b;
    transition: all 0.2s;
}
.dark form.checkout_coupon input#coupon_code.input-text {
    background: #1e293b;
    border-color: #334155;
    color: #e2e8f0;
}
form.checkout_coupon input#coupon_code.input-text:focus {
    outline: none;
    border-color: #6DB33F !important;
    box-shadow: 0 0 0 3px rgba(109,179,63,0.15);
}
.woocommerce form.checkout_coupon button[name="apply_coupon"],
.woocommerce form.checkout_coupon button.button[name="apply_coupon"] {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 0.375rem !important;
    padding: 0.75rem 1.5rem !important;
    border-radius: 0.75rem !important;
    background: #6DB33F !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    font-size: 0.875rem !important;
    border: none !important;
    cursor: pointer !important;
    transition: all 0.2s !important;
    white-space: nowrap !important;
    text-decoration: none !important;
    box-shadow: 0 4px 6px -1px rgba(109,179,63,0.2) !important;
}
.woocommerce form.checkout_coupon button[name="apply_coupon"]:hover,
.woocommerce form.checkout_coupon button.button[name="apply_coupon"]:hover {
    background: #559030 !important;
    color: #ffffff !important;
    box-shadow: 0 6px 10px -1px rgba(109,179,63,0.3) !important;
}
form.checkout_coupon .clear { display: none; }
</style>

    <!-- Progress steps -->
    <div class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 py-5">
            <ol class="flex items-center justify-center gap-2 sm:gap-6 text-xs sm:text-sm"
                aria-label="Checkout progress">
                <li class="flex items-center gap-2 text-brand-green">
                    <span
                        class="w-7 h-7 rounded-full bg-brand-green text-white font-bold flex items-center justify-center text-xs">✓</span>
                    <span class="font-bold hidden sm:inline">Cart</span>
                </li>
                <li class="w-8 sm:w-16 h-0.5 bg-brand-green rounded"></li>
                <li class="flex items-center gap-2 text-brand-green" aria-current="step">
                    <span
                        class="w-7 h-7 rounded-full bg-brand-green text-white font-bold flex items-center justify-center text-xs">2</span>
                    <span class="font-bold hidden sm:inline">Checkout</span>
                </li>
                <li class="w-8 sm:w-16 h-0.5 bg-slate-200 dark:bg-slate-700 rounded"></li>
                <li class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
                    <span
                        class="w-7 h-7 rounded-full bg-slate-200 dark:bg-slate-700 font-bold flex items-center justify-center text-xs">3</span>
                    <span class="font-bold hidden sm:inline">Confirmation</span>
                </li>
            </ol>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 py-8">
        <?php do_action('woocommerce_before_checkout_form', $checkout); ?>

        <form name="checkout" method="post" class="checkout woocommerce-checkout"
            action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data"
            x-data="{...placeOrderBtn, ...checkoutScroll}" x-init="init()">

            <div class="grid lg:grid-cols-[1fr_380px] gap-6 items-start">

                <!-- LEFT: FIELDS -->
                <div class="space-y-5">

                    <?php if ($checkout->get_checkout_fields()): ?>
                    <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                    <!-- Contact -->
                    <section class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="font-display font-bold text-xl text-slate-800 dark:text-slate-200">Contact</h2>
                            <?php if (!is_user_logged_in() && $checkout->is_registration_enabled()): ?>
                            <a href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>"
                                class="text-xs text-brand-green font-semibold hover:underline">Have an account? Log
                                in</a>
                            <?php endif; ?>
                        </div>
                        <div id="customer_details">
                            <?php do_action('woocommerce_checkout_billing'); ?>
                        </div>
                    </section>

                    <?php do_action('woocommerce_checkout_after_customer_details'); ?>
                    <?php endif; ?>

                    <!-- Delivery Note -->
                    <?php if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments','yes'))): ?>
                    <section class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6">
                        <h2 class="font-display font-bold text-xl text-slate-800 dark:text-slate-200 mb-4">Delivery Notes <span
                                class="text-slate-500 dark:text-slate-400 font-normal text-base">(optional)</span></h2>
                        <?php foreach ($checkout->get_checkout_fields('order') as $key => $field): ?>
                        <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
                        <?php endforeach; ?>
                    </section>
                    <?php endif; ?>

                </div><!-- /left -->

                <!-- RIGHT: SUMMARY + PAYMENT -->
                <div class="space-y-5 lg:sticky lg:top-24">

                    <!-- Order review -->
                    <div
                        class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden">
                        <div class="px-6 py-4 bg-gray-100 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
                            <h2 class="font-display font-bold text-lg text-slate-800 dark:text-slate-200">Order Summary</h2>
                        </div>
                        <div class="p-6" x-data="shippingMethods">
                            <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
                            <?php do_action('woocommerce_checkout_order_review'); ?>
                        </div>
                    </div>

                    <!-- Payment -->
                    <div
                        class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden">
                        <div class="px-6 py-4 bg-gray-100 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
                            <h2 class="font-display font-bold text-lg text-slate-800 dark:text-slate-200">Payment Method</h2>
                        </div>
                        <div class="p-6">
                            <?php do_action('woocommerce_review_order_before_payment'); ?>
                            <?php do_action('woocommerce_checkout_payment'); ?>
                            <?php do_action('woocommerce_review_order_after_payment'); ?>
                        </div>
                    </div>

                    <!-- Terms -->
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 text-center leading-relaxed">
                        By placing your order you agree to our
                        <a href="<?php echo esc_url(get_privacy_policy_url() ?: '#'); ?>"
                            class="underline hover:text-brand-green">Privacy Policy</a>.
                    </p>
                </div><!-- /right -->

            </div><!-- /grid -->
        </form>

        <?php do_action('woocommerce_after_checkout_form', $checkout); ?>
    </div>

</main>
<?php get_footer(); ?>

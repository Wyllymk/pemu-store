<?php
/**
 * WooCommerce — myaccount/my-account.php
 * @version 3.5.0
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="main-content" class="min-h-screen bg-gray-100 dark:bg-slate-800">

<style>
/* My Account form styling — overrides WC default styles */
.woocommerce-account .woocommerce-MyAccount-content .form-row { margin-bottom: 1rem; }
.woocommerce-account .woocommerce-MyAccount-content .form-row label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.375rem;
    color: #1e293b;
}
.dark .woocommerce-account .woocommerce-MyAccount-content .form-row label {
    color: #e2e8f0;
}
.woocommerce-account .woocommerce-MyAccount-content .form-row input[type="text"],
.woocommerce-account .woocommerce-MyAccount-content .form-row input[type="email"],
.woocommerce-account .woocommerce-MyAccount-content .form-row input[type="tel"],
.woocommerce-account .woocommerce-MyAccount-content .form-row input[type="password"],
.woocommerce-account .woocommerce-MyAccount-content .form-row textarea,
.woocommerce-account .woocommerce-MyAccount-content .form-row select {
    width: 100%;
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    font-size: 0.875rem;
    color: #1e293b;
    transition: all 0.2s;
}
.dark .woocommerce-account .woocommerce-MyAccount-content .form-row input,
.dark .woocommerce-account .woocommerce-MyAccount-content .form-row textarea,
.dark .woocommerce-account .woocommerce-MyAccount-content .form-row select {
    background: #1e293b;
    border-color: #334155;
    color: #e2e8f0;
}
.woocommerce-account .woocommerce-MyAccount-content .form-row input:focus,
.woocommerce-account .woocommerce-MyAccount-content .form-row textarea:focus,
.woocommerce-account .woocommerce-MyAccount-content .form-row select:focus {
    outline: none;
    border-color: #6DB33F !important;
    box-shadow: 0 0 0 3px rgba(109,179,63,0.15);
}
.woocommerce-account .woocommerce-MyAccount-content .button,
.woocommerce-account .woocommerce-MyAccount-content button[type="submit"],
.woocommerce-account .woocommerce-MyAccount-content input[type="submit"] {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 0.5rem !important;
    padding: 0.875rem 1.75rem !important;
    border-radius: 0.75rem !important;
    background: #6DB33F !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    font-size: 0.9375rem !important;
    border: none !important;
    cursor: pointer !important;
    transition: all 0.2s !important;
    text-decoration: none !important;
    line-height: 1.4 !important;
}
.woocommerce-account .woocommerce-MyAccount-content .button:hover,
.woocommerce-account .woocommerce-MyAccount-content button[type="submit"]:hover,
.woocommerce-account .woocommerce-MyAccount-content input[type="submit"]:hover {
    background: #559030 !important;
    color: #ffffff !important;
}
.woocommerce-account .woocommerce-MyAccount-content legend {
    font-family: "DM Sans", ui-sans-serif, system-ui, sans-serif;
    font-weight: 700;
    font-size: 1.25rem;
    color: #1e293b;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #e2e8f0;
    width: 100%;
}
.dark .woocommerce-account .woocommerce-MyAccount-content legend {
    color: #e2e8f0;
    border-color: #334155;
}
.woocommerce-account address {
    font-style: normal;
    line-height: 1.7;
    color: #475569;
}
.dark .woocommerce-account address {
    color: #94a3b8;
}
.woocommerce-account .woocommerce-MyAccount-content .col-1,
.woocommerce-account .woocommerce-MyAccount-content .col-2 {
    width: 100%;
    margin-bottom: 1rem;
}
.woocommerce-account .woocommerce-MyAccount-content .edit-account fieldset {
    margin-bottom: 1.5rem;
    padding: 0;
    border: none;
}
.woocommerce-account .woocommerce-MyAccount-content .u-columns {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}
@media (min-width: 768px) {
    .woocommerce-account .woocommerce-MyAccount-content .u-columns {
        grid-template-columns: 1fr 1fr;
    }
}
.woocommerce-account .woocommerce-MyAccount-content p {
    margin-bottom: 0.75rem;
    color: #475569;
}
.dark .woocommerce-account .woocommerce-MyAccount-content p {
    color: #94a3b8;
}
.woocommerce-account .woocommerce-MyAccount-content .woocommerce-Address-title a {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    background: #6DB33F !important;
    color: #ffffff !important;
    font-weight: 600 !important;
    font-size: 0.8125rem !important;
    text-decoration: none !important;
    transition: background 0.2s;
}
.woocommerce-account .woocommerce-MyAccount-content .woocommerce-Address-title a:hover {
    background: #559030 !important;
    color: #ffffff !important;
}
/* Password visibility toggle fix */
.woocommerce-account .woocommerce-MyAccount-content .password-input {
    position: relative;
    display: block;
}
.woocommerce-account .woocommerce-MyAccount-content .show-password-input {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 0.75rem;
    color: #94a3b8;
}
/* !text-white overrides — force text colors against WC overrides */
.woocommerce-account .woocommerce-MyAccount-content p,
.woocommerce-account .woocommerce-MyAccount-content li,
.woocommerce-account .woocommerce-MyAccount-content td,
.woocommerce-account .woocommerce-MyAccount-content th,
.woocommerce-account .woocommerce-MyAccount-content span,
.woocommerce-account .woocommerce-MyAccount-content strong,
.woocommerce-account .woocommerce-MyAccount-content .woocommerce-Address-title a,
.woocommerce-account .woocommerce-MyAccount-content a:not(.button):not(.woocommerce-Button) {
    color: #1e293b !important;
    text-decoration: none !important;
}
.dark .woocommerce-account .woocommerce-MyAccount-content p,
.dark .woocommerce-account .woocommerce-MyAccount-content li,
.dark .woocommerce-account .woocommerce-MyAccount-content td,
.dark .woocommerce-account .woocommerce-MyAccount-content th,
.dark .woocommerce-account .woocommerce-MyAccount-content span,
.dark .woocommerce-account .woocommerce-MyAccount-content strong,
.dark .woocommerce-account .woocommerce-MyAccount-content .woocommerce-Address-title a,
.dark .woocommerce-account .woocommerce-MyAccount-content a:not(.button):not(.woocommerce-Button) {
    color: #e2e8f0 !important;
}
.woocommerce-account .woocommerce-MyAccount-content a:not(.button):not(.woocommerce-Button):hover {
    color: #6DB33F !important;
}
</style>
<div class="max-w-6xl mx-auto px-4 py-8 lg:py-12">

	<div class="mb-8">
		<h1 class="font-display font-extrabold text-3xl lg:text-4xl text-slate-800 dark:text-slate-200">
			<?php
			if ( is_user_logged_in() ) {
				printf(
					esc_html__( 'Welcome back, %s 👋', 'pemu' ),
					esc_html( wp_get_current_user()->display_name )
				);
			} else {
				esc_html_e( 'My Account', 'pemu' );
			}
			?>
		</h1>
		<p class="text-slate-500 dark:text-slate-400 mt-2 text-sm">
			<?php esc_html_e( 'Manage your orders, address, and account settings.', 'pemu' ); ?>
		</p>
	</div>

	<div class="grid lg:grid-cols-[240px_1fr] gap-6 items-start">

		<div class="lg:sticky lg:top-24">
			<?php do_action( 'woocommerce_account_navigation' ); ?>
		</div>

		<div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 lg:p-8">
			<?php
			do_action( 'woocommerce_account_content' );
			?>
		</div>
	</div>
</div>
</main>
<?php get_footer(); ?>

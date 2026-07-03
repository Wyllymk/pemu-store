<?php
/**
 * WooCommerce — myaccount/form-lost-password.php
 * @version 9.2.0
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="main-content" class="min-h-screen bg-gray-100 dark:bg-slate-800 flex items-center justify-center py-12 px-4 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40rem] h-[40rem] bg-brand-navy/10 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40rem] h-[40rem] bg-brand-green/10 rounded-full blur-[100px]"></div>
    </div>

    <div class="w-full max-w-lg relative z-10">

        <div class="text-center mb-10">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex items-center gap-3 mb-6 hover:scale-105 transition-transform duration-300">
                <svg viewBox="0 0 40 40" class="w-12 h-12">
                    <polygon points="20,2 36,11 36,29 20,38 4,29 4,11" fill="none" stroke="#6DB33F" stroke-width="2.5" />
                    <polygon points="20,9 29,14.5 29,25.5 20,31 11,25.5 11,14.5" fill="#1E4D6B" />
                    <path d="M14.5 18 L20 24 L25.5 18" stroke="#6DB33F" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>

        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-8 sm:p-10 shadow-xl">
            <h2 class="font-display font-bold text-2xl text-slate-800 dark:text-slate-200 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-brand-green" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                <?php esc_html_e( 'Lost your password?', 'pemu' ); ?>
            </h2>

            <div class="mb-6 text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                <?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?>
            </div>

            <form method="post" class="woocommerce-ResetPassword lost_reset_password space-y-6">

                <div>
                    <label for="user_login" class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1.5"><?php esc_html_e( 'Username or email', 'pemu' ); ?></label>
                    <input type="text" class="w-full bg-gray-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-brand-green focus:ring-4 focus:ring-brand-green/20 transition-all duration-200" name="user_login" id="user_login" autocomplete="username" required>
                </div>

                <div class="clear"></div>

                <?php do_action( 'woocommerce_lostpassword_form' ); ?>

                <div>
                    <input type="hidden" name="wc_reset_password" value="true" />
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-brand-green to-brand-green-dark hover:from-brand-green-dark hover:to-brand-green text-white font-bold py-4 rounded-xl transition-all duration-300 shadow-lg shadow-brand-green/30 hover:shadow-brand-green/50 hover:-translate-y-0.5 text-base" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>">
                        <?php esc_html_e( 'Reset Password', 'pemu' ); ?>
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>

                <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

            </form>

            <div class="mt-8 text-center">
                <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-brand-green transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <?php esc_html_e( 'Back to login', 'pemu' ); ?>
                </a>
            </div>
        </div>

    </div>
</main>
<?php get_footer(); ?>

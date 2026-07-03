<?php
/**
 * WooCommerce — myaccount/form-login.php
 * @version 9.9.0
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="main-content" class="min-h-screen bg-gray-100 dark:bg-slate-800 flex items-center justify-center py-12 px-4 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40rem] h-[40rem] bg-brand-green/10 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40rem] h-[40rem] bg-brand-navy/10 rounded-full blur-[100px]"></div>
    </div>

    <div class="w-full max-w-5xl relative z-10" x-data="{ activeTab: 'login' }">

        <div class="text-center mb-10">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex items-center gap-3 mb-6 hover:scale-105 transition-transform duration-300">
                <svg viewBox="0 0 40 40" class="w-12 h-12">
                    <polygon points="20,2 36,11 36,29 20,38 4,29 4,11" fill="none" stroke="#6DB33F" stroke-width="2.5" />
                    <polygon points="20,9 29,14.5 29,25.5 20,31 11,25.5 11,14.5" fill="#1E4D6B" />
                    <path d="M14.5 18 L20 24 L25.5 18" stroke="#6DB33F" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="font-display font-extrabold text-2xl text-slate-800 dark:text-slate-200">Pemu Health</span>
            </a>
            <h1 class="font-display font-extrabold text-3xl lg:text-4xl text-slate-800 dark:text-slate-200 tracking-tight">
                <?php esc_html_e( 'Welcome Back', 'pemu' ); ?>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2 font-medium">Log in or create an account to continue.</p>
        </div>

        <div class="flex lg:hidden mb-8 bg-white dark:bg-slate-800 rounded-xl p-1 border border-slate-200 dark:border-slate-700 shadow-sm max-w-md mx-auto">
            <button @click="activeTab='login'"
                :class="activeTab==='login' ? 'bg-brand-green text-white shadow-md' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200'"
                class="flex-1 py-3 rounded-lg text-sm font-bold transition-all duration-200">
                <?php esc_html_e( 'Log In', 'pemu' ); ?>
            </button>
            <button @click="activeTab='register'"
                :class="activeTab==='register' ? 'bg-brand-green text-white shadow-md' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200'"
                class="flex-1 py-3 rounded-lg text-sm font-bold transition-all duration-200">
                <?php esc_html_e( 'Register', 'pemu' ); ?>
            </button>
        </div>

        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 max-w-4xl mx-auto items-start">

            <!-- Login -->
            <div x-show="activeTab === 'login'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="lg:col-span-2 max-w-md mx-auto w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-8 sm:p-10 shadow-xl">
                <h2 class="font-display font-bold text-2xl text-slate-800 dark:text-slate-200 mb-8 flex items-center gap-2">
                    <svg class="w-6 h-6 text-brand-green" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    <?php esc_html_e( 'Log In', 'pemu' ); ?>
                </h2>

                <?php do_action( 'woocommerce_before_customer_login_form' ); ?>

                <form class="woocommerce-form woocommerce-form-login login" method="post">
                    <?php do_action( 'woocommerce_login_form_start' ); ?>

                    <div class="space-y-5">
                        <div>
                            <label for="username" class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1.5"><?php esc_html_e( 'Email or username', 'pemu' ); ?>
                                <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full bg-gray-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-brand-green focus:ring-4 focus:ring-brand-green/20 transition-all duration-200" name="username" id="username"
                                autocomplete="username email" inputmode="email" required
                                value="<?php echo esc_attr( isset( $_POST['username'] ) ? wp_unslash( sanitize_text_field( $_POST['username'] ) ) : '' ); ?>">
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password" class="block text-sm font-semibold text-slate-800 dark:text-slate-200 m-0"><?php esc_html_e( 'Password', 'pemu' ); ?>
                                    <span class="text-red-500">*</span></label>
                                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"
                                    class="text-sm font-semibold text-brand-green hover:text-brand-green-dark hover:underline transition-colors"><?php esc_html_e( 'Forgot password?', 'pemu' ); ?></a>
                            </div>
                            <input type="password" class="w-full bg-gray-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-brand-green focus:ring-4 focus:ring-brand-green/20 transition-all duration-200" name="password" id="password"
                                autocomplete="current-password" required>
                        </div>

                        <label class="flex items-center gap-3 text-sm cursor-pointer group">
                            <input class="w-5 h-5 rounded border-slate-200 dark:border-slate-700 text-brand-green focus:ring-brand-green focus:ring-offset-0 bg-gray-100 dark:bg-slate-800 transition-all"
                                name="rememberme" type="checkbox" id="rememberme" value="forever">
                            <span class="text-slate-800 dark:text-slate-200 font-medium group-hover:text-brand-green transition-colors"><?php esc_html_e( 'Remember me', 'pemu' ); ?></span>
                        </label>
                    </div>

                    <?php do_action( 'woocommerce_login_form' ); ?>

                    <div class="mt-8">
                        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                        <input type="hidden" name="redirect"
                            value="<?php echo esc_url( apply_filters( 'woocommerce_login_redirect', wc_get_page_permalink( 'myaccount' ), null ) ); ?>">
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-brand-green to-brand-green-dark hover:from-brand-green-dark hover:to-brand-green text-white font-bold py-4 rounded-xl transition-all duration-300 shadow-lg shadow-brand-green/30 hover:shadow-brand-green/50 hover:-translate-y-0.5 text-base"
                            name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>">
                            <?php esc_html_e( 'Log In Securely', 'pemu' ); ?>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                    <?php do_action( 'woocommerce_login_form_end' ); ?>
                </form>

                <?php do_action( 'woocommerce_after_customer_login_form' ); ?>
            </div>

            <!-- Register -->
            <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
            <div x-show="activeTab === 'register'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="lg:col-span-2 max-w-md mx-auto w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-8 sm:p-10 shadow-xl">
                <h2 class="font-display font-bold text-2xl text-slate-800 dark:text-slate-200 mb-8 flex items-center gap-2">
                    <svg class="w-6 h-6 text-brand-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    <?php esc_html_e( 'Create Account', 'pemu' ); ?>
                </h2>

                <form method="post" class="woocommerce-form woocommerce-form-register register">
                    <?php do_action( 'woocommerce_register_form_start' ); ?>

                    <div class="space-y-5">
                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                        <div>
                            <label for="reg_username" class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1.5"><?php esc_html_e( 'Username', 'pemu' ); ?>
                                <span class="text-red-500">*</span></label>
                            <input type="text" class="w-full bg-gray-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-brand-navy focus:ring-4 focus:ring-brand-navy/20 transition-all duration-200" name="username" id="reg_username"
                                autocomplete="username" required
                                value="<?php echo esc_attr( isset( $_POST['username'] ) ? wp_unslash( sanitize_text_field( $_POST['username'] ) ) : '' ); ?>">
                        </div>
                        <?php endif; ?>

                        <div>
                            <label for="reg_email" class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1.5"><?php esc_html_e( 'Email address', 'pemu' ); ?>
                                <span class="text-red-500">*</span></label>
                            <input type="email" class="w-full bg-gray-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-brand-navy focus:ring-4 focus:ring-brand-navy/20 transition-all duration-200" name="email" id="reg_email" autocomplete="email"
                                inputmode="email" required
                                value="<?php echo esc_attr( isset( $_POST['email'] ) ? wp_unslash( sanitize_email( $_POST['email'] ) ) : '' ); ?>">
                        </div>

                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                        <div>
                            <label for="reg_password" class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1.5"><?php esc_html_e( 'Password', 'pemu' ); ?>
                                <span class="text-red-500">*</span></label>
                            <input type="password" class="w-full bg-gray-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:border-brand-navy focus:ring-4 focus:ring-brand-navy/20 transition-all duration-200" name="password" id="reg_password"
                                autocomplete="new-password" required>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php do_action( 'woocommerce_register_form' ); ?>

                    <div class="mt-8 space-y-4">
                        <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-brand-navy to-[#153a52] hover:from-[#153a52] hover:to-brand-navy text-white font-bold py-4 rounded-xl transition-all duration-300 shadow-lg shadow-brand-navy/30 hover:shadow-brand-navy/50 hover:-translate-y-0.5 text-base"
                            name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>">
                            <?php esc_html_e( 'Create Account', 'pemu' ); ?>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </button>
                        <p class="text-xs text-slate-500 dark:text-slate-400 text-center leading-relaxed max-w-xs mx-auto">
                            <?php
                            printf(
                                wp_kses( __( 'Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="%s" class="font-bold underline hover:text-brand-navy transition-colors">Privacy Policy</a>.', 'woocommerce' ), [ 'a' => [ 'href' => [], 'class' => [] ] ] ),
                                esc_url( get_privacy_policy_url() )
                            );
                            ?>
                        </p>
                    </div>

                    <?php do_action( 'woocommerce_register_form_end' ); ?>
                </form>
            </div>
            <?php endif; ?>

        </div>
    </div>
</main>
<?php get_footer(); ?>

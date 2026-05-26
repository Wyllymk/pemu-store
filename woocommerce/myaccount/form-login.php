<?php
/**
 * WooCommerce — myaccount/form-login.php
 * Pemu override: two-panel login + register.
 * ALL WC hooks preserved.
 * @version 9.2.0
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="main-content" class="min-h-screen bg-[var(--color-bg-muted)] flex items-center justify-center py-12 px-4">
<div class="w-full max-w-5xl" x-data="{ activeTab: 'login' }">

	<!-- Header -->
	<div class="text-center mb-8">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex items-center gap-2 mb-6">
			<svg viewBox="0 0 40 40" class="w-10 h-10"><polygon points="20,2 36,11 36,29 20,38 4,29 4,11" fill="none" stroke="#6DB33F" stroke-width="2.5"/><polygon points="20,9 29,14.5 29,25.5 20,31 11,25.5 11,14.5" fill="#1E4D6B"/><path d="M14.5 18 L20 24 L25.5 18" stroke="#6DB33F" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
			<span class="font-display font-extrabold text-xl text-[var(--color-text)]">Pemu Health</span>
		</a>
		<h1 class="font-display font-extrabold text-3xl text-[var(--color-text)]">
			<?php esc_html_e( 'Your Account', 'pemu' ); ?>
		</h1>
	</div>

	<!-- Tab switcher (mobile) -->
	<div class="flex lg:hidden mb-6 bg-[var(--color-surface)] rounded-xl p-1 border border-[var(--color-border)]">
		<button @click="activeTab='login'"
		        :class="activeTab==='login' ? 'bg-brand-green text-white shadow-sm' : 'text-[var(--color-text-muted)]'"
		        class="flex-1 py-2.5 rounded-lg text-sm font-bold transition-all">
			<?php esc_html_e( 'Log In', 'pemu' ); ?>
		</button>
		<button @click="activeTab='register'"
		        :class="activeTab==='register' ? 'bg-brand-green text-white shadow-sm' : 'text-[var(--color-text-muted)]'"
		        class="flex-1 py-2.5 rounded-lg text-sm font-bold transition-all">
			<?php esc_html_e( 'Register', 'pemu' ); ?>
		</button>
	</div>

	<div class="grid lg:grid-cols-2 gap-6">

		<!-- Login form -->
		<div x-show="activeTab === 'login'" class="lg:block bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-7">
			<h2 class="font-display font-bold text-2xl text-[var(--color-text)] mb-6"><?php esc_html_e( 'Log In', 'pemu' ); ?></h2>

			<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

			<form class="woocommerce-form woocommerce-form-login login" method="post">

				<?php do_action( 'woocommerce_login_form_start' ); ?>

				<div class="space-y-4">
					<div>
						<label for="username" class="pemu-label"><?php esc_html_e( 'Email or username', 'pemu' ); ?> <span class="text-red-500">*</span></label>
						<input type="text" class="pemu-input" name="username" id="username"
						       autocomplete="username email" inputmode="email" required
						       value="<?php echo esc_attr( isset( $_POST['username'] ) ? wp_unslash( sanitize_text_field( $_POST['username'] ) ) : '' ); ?>">
					</div>

					<div>
						<div class="flex items-center justify-between mb-1.5">
							<label for="password" class="pemu-label m-0"><?php esc_html_e( 'Password', 'pemu' ); ?> <span class="text-red-500">*</span></label>
							<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="text-xs text-brand-green hover:underline"><?php esc_html_e( 'Forgot password?', 'pemu' ); ?></a>
						</div>
						<input type="password" class="pemu-input" name="password" id="password"
						       autocomplete="current-password" required>
					</div>

					<label class="flex items-center gap-2 text-sm cursor-pointer">
						<input class="rounded text-brand-green focus:ring-brand-green focus:ring-offset-0" name="rememberme" type="checkbox" id="rememberme" value="forever">
						<span class="text-[var(--color-text)]"><?php esc_html_e( 'Remember me', 'pemu' ); ?></span>
					</label>
				</div>

				<?php do_action( 'woocommerce_login_form' ); ?>

				<div class="mt-5">
					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<input type="hidden" name="redirect" value="<?php echo esc_url( apply_filters( 'woocommerce_login_redirect', wc_get_page_permalink( 'myaccount' ), null ) ); ?>">
					<button type="submit" class="w-full bg-brand-green hover:bg-brand-green-dark text-white font-bold py-3.5 rounded-xl transition-colors shadow-md shadow-brand-green/30 text-sm" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>">
						<?php esc_html_e( 'Log In', 'pemu' ); ?>
					</button>
				</div>

				<?php do_action( 'woocommerce_login_form_end' ); ?>
			</form>

			<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
		</div>

		<!-- Register form -->
		<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
		<div x-show="activeTab === 'register'" class="lg:block bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-7">
			<h2 class="font-display font-bold text-2xl text-[var(--color-text)] mb-6"><?php esc_html_e( 'Create Account', 'pemu' ); ?></h2>

			<form method="post" class="woocommerce-form woocommerce-form-register register">

				<?php do_action( 'woocommerce_register_form_start' ); ?>

				<div class="space-y-4">
					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
					<div>
						<label for="reg_username" class="pemu-label"><?php esc_html_e( 'Username', 'pemu' ); ?> <span class="text-red-500">*</span></label>
						<input type="text" class="pemu-input" name="username" id="reg_username" autocomplete="username" required
						       value="<?php echo esc_attr( isset( $_POST['username'] ) ? wp_unslash( sanitize_text_field( $_POST['username'] ) ) : '' ); ?>">
					</div>
					<?php endif; ?>

					<div>
						<label for="reg_email" class="pemu-label"><?php esc_html_e( 'Email address', 'pemu' ); ?> <span class="text-red-500">*</span></label>
						<input type="email" class="pemu-input" name="email" id="reg_email" autocomplete="email" inputmode="email" required
						       value="<?php echo esc_attr( isset( $_POST['email'] ) ? wp_unslash( sanitize_email( $_POST['email'] ) ) : '' ); ?>">
					</div>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
					<div>
						<label for="reg_password" class="pemu-label"><?php esc_html_e( 'Password', 'pemu' ); ?> <span class="text-red-500">*</span></label>
						<input type="password" class="pemu-input" name="password" id="reg_password" autocomplete="new-password" required>
					</div>
					<?php endif; ?>
				</div>

				<?php do_action( 'woocommerce_register_form' ); ?>

				<div class="mt-5 space-y-3">
					<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
					<button type="submit" class="w-full bg-brand-navy hover:bg-brand-navy/90 text-white font-bold py-3.5 rounded-xl transition-colors text-sm" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>">
						<?php esc_html_e( 'Create Account', 'pemu' ); ?>
					</button>
					<p class="text-[10px] text-[var(--color-text-muted)] text-center leading-relaxed">
						<?php
						printf(
							wp_kses( __( 'Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="%s" class="underline hover:text-brand-green">Privacy Policy</a>.', 'woocommerce' ), [ 'a' => [ 'href' => [], 'class' => [] ] ] ),
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

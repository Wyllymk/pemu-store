<?php
/**
 * Pemu Health Supplements — footer.php
 */
defined( 'ABSPATH' ) || exit;
?>

<!-- ════════════════════════════════════════════════════════════
     FOOTER
════════════════════════════════════════════════════════════ -->
<footer class="bg-[var(--color-bg-muted)] border-t border-[var(--color-border)] pb-20 lg:pb-0 mt-auto">
	<div class="max-w-7xl mx-auto px-4 pt-14 pb-10">
		<div class="grid md:grid-cols-2 lg:grid-cols-5 gap-10">

			<!-- Brand column -->
			<div class="lg:col-span-2">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex items-center gap-2.5 mb-4" aria-label="<?php esc_attr_e( 'Pemu Health Supplements – Home', 'pemu' ); ?>">
					<svg viewBox="0 0 40 40" class="w-10 h-10 shrink-0" aria-hidden="true">
						<polygon points="20,2 36,11 36,29 20,38 4,29 4,11" fill="none" stroke="#6DB33F" stroke-width="2.5"/>
						<polygon points="20,9 29,14.5 29,25.5 20,31 11,25.5 11,14.5" fill="#1E4D6B"/>
						<path d="M14.5 18 L20 24 L25.5 18" stroke="#6DB33F" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					<div class="flex flex-col leading-tight">
						<span class="font-display font-extrabold text-lg text-[var(--color-text)]">Pemu Health</span>
						<span class="text-[10px] font-semibold tracking-widest uppercase text-[var(--color-text-muted)]">Supplements</span>
					</div>
				</a>
				<p class="text-sm text-[var(--color-text-muted)] leading-relaxed max-w-sm">
					<?php echo esc_html( get_theme_mod( 'pemu_footer_tagline', "Kenya's trusted supplement store. 100% authentic, lab-tested, discreetly delivered." ) ); ?>
				</p>
				<!-- Social icons -->
				<div class="flex items-center gap-3 mt-5">
					<?php
					$socials = [
						[ 'key' => 'pemu_social_tiktok',    'icon' => 'tiktok',    'label' => 'TikTok' ],
						[ 'key' => 'pemu_social_instagram', 'icon' => 'instagram', 'label' => 'Instagram' ],
						[ 'key' => 'pemu_social_facebook',  'icon' => 'facebook',  'label' => 'Facebook' ],
					];
					foreach ( $socials as $s ) :
						$url = get_option( $s['key'], '' );
						if ( ! $url ) continue;
					?>
					<a href="<?php echo esc_url( $url ); ?>"
					   target="_blank" rel="noopener noreferrer"
					   aria-label="<?php echo esc_attr( sprintf( __( 'Follow us on %s', 'pemu' ), $s['label'] ) ); ?>"
					   class="w-9 h-9 rounded-full bg-[var(--color-surface)] border border-[var(--color-border)] flex items-center justify-center text-[var(--color-text-muted)] hover:text-brand-green hover:border-brand-green transition-colors">
						<?php echo pemu_icon( $s['icon'], [ 'class' => 'w-4 h-4', 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor' ] ); ?>
					</a>
					<?php endforeach; ?>
					<!-- WhatsApp -->
					<a href="<?php echo esc_url( pemu_whatsapp_url() ); ?>"
					   target="_blank" rel="noopener noreferrer"
					   aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'pemu' ); ?>"
					   class="w-9 h-9 rounded-full bg-[#25D366] flex items-center justify-center text-white hover:bg-[#1db954] transition-colors">
						<?php echo pemu_icon( 'whatsapp', [ 'class' => 'w-4 h-4' ] ); ?>
					</a>
				</div>
			</div>

			<!-- Shop column -->
			<div>
				<h3 class="font-display font-bold text-sm uppercase tracking-widest mb-4 text-[var(--color-text)]"><?php esc_html_e( 'Shop', 'pemu' ); ?></h3>
				<ul class="space-y-2.5 text-sm text-[var(--color-text-muted)]">
					<?php
					$shop_links = [
						add_query_arg( 'product_cat', 'protein', wc_get_page_permalink( 'shop' ) )    => __( 'Protein', 'pemu' ),
						add_query_arg( 'product_cat', 'pre-workout', wc_get_page_permalink( 'shop' ) ) => __( 'Pre-Workout', 'pemu' ),
						add_query_arg( 'product_cat', 'creatine', wc_get_page_permalink( 'shop' ) )   => __( 'Creatine', 'pemu' ),
						add_query_arg( 'product_cat', 'vitamins', wc_get_page_permalink( 'shop' ) )   => __( 'Vitamins & Wellness', 'pemu' ),
						add_query_arg( 'product_cat', 'fat-burners', wc_get_page_permalink( 'shop' ) )=> __( 'Fat Burners', 'pemu' ),
						add_query_arg( 'product_cat', 'bundles', wc_get_page_permalink( 'shop' ) )    => __( 'Bundles & Stacks', 'pemu' ),
					];
					foreach ( $shop_links as $url => $label ) : ?>
					<li><a href="<?php echo esc_url( $url ); ?>" class="hover:text-brand-green transition-colors"><?php echo esc_html( $label ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<!-- Help column -->
			<div>
				<h3 class="font-display font-bold text-sm uppercase tracking-widest mb-4 text-[var(--color-text)]"><?php esc_html_e( 'Help', 'pemu' ); ?></h3>
				<ul class="space-y-2.5 text-sm text-[var(--color-text-muted)]">
					<?php
					$help_links = [
						pemu_whatsapp_url( 'Hi! I need help with my order.' ) => __( 'WhatsApp Support', 'pemu' ),
						get_permalink( get_page_by_path( 'shipping-info' ) )  => __( 'Shipping Info', 'pemu' ),
						get_permalink( get_page_by_path( 'returns' ) )        => __( 'Returns Policy', 'pemu' ),
						get_permalink( get_page_by_path( 'faq' ) )            => __( 'FAQ', 'pemu' ),
						wc_get_account_endpoint_url( 'orders' )               => __( 'Track My Order', 'pemu' ),
					];
					foreach ( $help_links as $url => $label ) :
						if ( ! $url ) continue;
					?>
					<li><a href="<?php echo esc_url( $url ); ?>" class="hover:text-brand-green transition-colors"><?php echo esc_html( $label ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<!-- Contact column -->
			<div>
				<h3 class="font-display font-bold text-sm uppercase tracking-widest mb-4 text-[var(--color-text)]"><?php esc_html_e( 'Contact', 'pemu' ); ?></h3>
				<ul class="space-y-3 text-sm text-[var(--color-text-muted)]">
					<?php $wa_number = get_option( 'pemu_whatsapp_number', '254700000000' ); ?>
					<li class="flex items-start gap-2">
						<?php echo pemu_icon( 'whatsapp', [ 'class' => 'w-4 h-4 mt-0.5 shrink-0 text-[#25D366]' ] ); ?>
						<a href="<?php echo esc_url( pemu_whatsapp_url() ); ?>" target="_blank" rel="noopener" class="hover:text-brand-green transition-colors">
							+<?php echo esc_html( $wa_number ); ?>
						</a>
					</li>
					<?php $email = get_option( 'pemu_email', 'hello@pemuhealthsupplements.co.ke' ); ?>
					<li class="flex items-start gap-2">
						<?php echo pemu_icon( 'mail', [ 'class' => 'w-4 h-4 mt-0.5 shrink-0 text-brand-green' ] ); ?>
						<a href="mailto:<?php echo esc_attr( $email ); ?>" class="hover:text-brand-green transition-colors"><?php echo esc_html( $email ); ?></a>
					</li>
					<?php $address = get_option( 'pemu_address', 'Nairobi, Kenya' ); ?>
					<li class="flex items-start gap-2">
						<?php echo pemu_icon( 'map-pin', [ 'class' => 'w-4 h-4 mt-0.5 shrink-0 text-brand-green' ] ); ?>
						<span><?php echo esc_html( $address ); ?></span>
					</li>
				</ul>
				<!-- Secure badges -->
				<div class="mt-5 flex flex-wrap gap-2 text-xs text-[var(--color-text-muted)]">
					<span class="inline-flex items-center gap-1 border border-[var(--color-border)] rounded-full px-2.5 py-1">
						<?php echo pemu_icon( 'lock', [ 'class' => 'w-3 h-3' ] ); ?> SSL Secured
					</span>
					<span class="inline-flex items-center gap-1 border border-[var(--color-border)] rounded-full px-2.5 py-1">
						<?php echo pemu_icon( 'check-circle', [ 'class' => 'w-3 h-3 text-brand-green' ] ); ?> Authentic
					</span>
				</div>
			</div>
		</div>
	</div>

	<!-- Bottom bar -->
	<div class="border-t border-[var(--color-border)]">
		<div class="max-w-7xl mx-auto px-4 py-4 flex flex-wrap items-center justify-between gap-3 text-xs text-[var(--color-text-muted)]">
			<p><?php echo esc_html( get_theme_mod( 'pemu_footer_copyright', '© 2026 Pemu Health Supplements. All rights reserved.' ) ); ?></p>
			<div class="flex items-center gap-4">
				<a href="<?php echo esc_url( get_privacy_policy_url() ); ?>" class="hover:text-brand-green transition-colors"><?php esc_html_e( 'Privacy Policy', 'pemu' ); ?></a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'terms-conditions' ) ) ?: '#' ); ?>" class="hover:text-brand-green transition-colors"><?php esc_html_e( 'Terms', 'pemu' ); ?></a>
			</div>
		</div>
	</div>
</footer>

<!-- ════════════════════════════════════════════════════════════
     FLOATING WHATSAPP BUTTON
════════════════════════════════════════════════════════════ -->
<?php pemu_floating_whatsapp_btn(); ?>

<!-- ════════════════════════════════════════════════════════════
     MOBILE BOTTOM NAVIGATION (hidden on lg+)
════════════════════════════════════════════════════════════ -->
<nav class="fixed bottom-0 inset-x-0 z-40 lg:hidden bg-[var(--color-surface)] border-t border-[var(--color-border)] safe-area-inset-bottom"
     aria-label="<?php esc_attr_e( 'Mobile bottom navigation', 'pemu' ); ?>">
	<div class="grid grid-cols-5 h-[60px]">
		<?php
		$bottom_nav = [
			[ 'url' => home_url( '/' ), 'label' => __( 'Home', 'pemu' ), 'icon_path' => 'M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z', 'active' => is_front_page() ],
			[ 'url' => wc_get_page_permalink( 'shop' ), 'label' => __( 'Shop', 'pemu' ), 'icon_path' => 'M3 9h18l-2 11H5zM8 9V6a4 4 0 118 0v3', 'active' => function_exists( 'is_shop' ) && ( is_shop() || is_product_category() ) ],
			[ 'url' => '#', 'label' => __( 'Search', 'pemu' ), 'icon_path' => 'M21 21l-3.5-3.5M17 11a6 6 0 11-12 0 6 6 0 0112 0z', 'active' => false, 'alpine_click' => '$store.ui.searchOpen = true' ],
			[ 'url' => '#', 'label' => __( 'Cart', 'pemu' ), 'icon_path' => 'M3 3h2l2.5 12.5a2 2 0 002 1.5h9a2 2 0 002-1.5L22 7H6', 'active' => function_exists( 'is_cart' ) && is_cart(), 'alpine_click' => '$store.ui.cartDrawerOpen = true', 'badge' => $count ],
			[ 'url' => wc_get_account_endpoint_url( 'dashboard' ), 'label' => __( 'Account', 'pemu' ), 'icon_path' => 'M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z', 'active' => function_exists( 'is_account_page' ) && is_account_page() ],
		];
		foreach ( $bottom_nav as $item ) :
			$is_btn = ! empty( $item['alpine_click'] );
			$tag    = $is_btn ? 'button' : 'a';
			$active = ! empty( $item['active'] );
			$classes = 'flex flex-col items-center justify-center gap-0.5 text-[10px] font-semibold transition-colors relative '
				. ( $active ? 'text-brand-green' : 'text-[var(--color-text-muted)] hover:text-[var(--color-text)]' );
		?>
		<<?php echo esc_attr( $tag ); ?>
			<?php if ( ! $is_btn ) : ?>href="<?php echo esc_url( $item['url'] ); ?>"<?php endif; ?>
			<?php if ( $is_btn ) : ?>@click="<?php echo esc_attr( $item['alpine_click'] ); ?>" type="button"<?php endif; ?>
			class="<?php echo esc_attr( $classes ); ?>"
			aria-label="<?php echo esc_attr( $item['label'] ); ?>"
			<?php if ( $active ) : ?>aria-current="page"<?php endif; ?>>
			<?php if ( ! empty( $item['badge'] ) && $item['badge'] > 0 ) : ?>
			<span class="absolute top-2 right-[18%] pemu-cart-count min-w-[16px] h-4 px-0.5 flex items-center justify-center rounded-full bg-brand-green text-white text-[9px] font-bold leading-none" aria-hidden="true">
				<?php echo esc_html( $item['badge'] ); ?>
			</span>
			<?php endif; ?>
			<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
				<path d="<?php echo esc_attr( $item['icon_path'] ); ?>" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
			<span><?php echo esc_html( $item['label'] ); ?></span>
		</<?php echo esc_attr( $tag ); ?>>
		<?php endforeach; ?>
	</div>
</nav>

<?php wp_footer(); ?>
</body>
</html>

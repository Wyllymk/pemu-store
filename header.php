<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class( 'min-h-screen antialiased' ); ?>
      x-data
      x-init="
        $store.ui.init();
        document.addEventListener('keydown', e => { if(e.key==='Escape') $store.ui.closeAll(); });
      "
>
<?php wp_body_open(); ?>

<!-- ════════════════════════════════════════════════════════════
     ANNOUNCEMENT BAR
════════════════════════════════════════════════════════════ -->
<?php if ( get_theme_mod( 'pemu_announcement_enabled', true ) ) :
	$ann_text = get_theme_mod( 'pemu_announcement_text', '🚚 Free delivery on orders above KES 2,000 · Order discreetly via WhatsApp 📱' );
	$ann_link = get_theme_mod( 'pemu_announcement_link', '' );
?>
<div x-data="{ visible: !localStorage.getItem('pemu-ann-dismissed') }"
     x-show="visible"
     x-cloak
     class="bg-brand-navy text-white text-xs sm:text-sm">
	<div class="max-w-7xl mx-auto px-4 py-2.5 flex items-center gap-3">
		<div class="flex-1 text-center font-medium tracking-wide">
			<?php if ( $ann_link ) : ?>
				<a href="<?php echo esc_url( $ann_link ); ?>" class="hover:underline">
					<?php echo esc_html( $ann_text ); ?>
				</a>
			<?php else : ?>
				<span><?php echo esc_html( $ann_text ); ?></span>
			<?php endif; ?>
		</div>
		<button @click="visible=false; localStorage.setItem('pemu-ann-dismissed','1')"
		        aria-label="<?php esc_attr_e( 'Dismiss announcement', 'pemu' ); ?>"
		        class="shrink-0 opacity-60 hover:opacity-100 transition-opacity p-1 rounded">
			<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/></svg>
		</button>
	</div>
</div>
<?php endif; ?>

<!-- ════════════════════════════════════════════════════════════
     MAIN HEADER
════════════════════════════════════════════════════════════ -->
<header id="site-header"
        class="sticky top-0 z-40 backdrop-blur-md border-b border-[var(--color-border)] transition-shadow duration-200"
        style="background: color-mix(in oklab, var(--color-surface) 88%, transparent);"
        x-bind:class="{ 'shadow-lg shadow-black/5' : $store.ui.scrolled }">
	<div class="max-w-7xl mx-auto px-4 h-16 flex items-center gap-3 lg:gap-5">

		<!-- Skip link -->
		<a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[200] focus:bg-brand-green focus:text-white focus:px-4 focus:py-2 focus:rounded-lg focus:font-semibold">
			<?php esc_html_e( 'Skip to content', 'pemu' ); ?>
		</a>

		<!-- Hamburger (mobile only) -->
		<button @click="$store.ui.mobileMenuOpen = true"
		        aria-label="<?php esc_attr_e( 'Open menu', 'pemu' ); ?>"
		        aria-expanded="false"
		        :aria-expanded="$store.ui.mobileMenuOpen.toString()"
		        class="lg:hidden p-2 rounded-lg hover:bg-[var(--color-bg-muted)] transition-colors">
			<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round"/></svg>
		</button>

		<!-- Logo -->
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2.5 shrink-0" aria-label="<?php esc_attr_e( 'Pemu Health Supplements – Home', 'pemu' ); ?>">
			<svg viewBox="0 0 40 40" class="w-9 h-9 shrink-0" aria-hidden="true">
				<polygon points="20,2 36,11 36,29 20,38 4,29 4,11" fill="none" stroke="#6DB33F" stroke-width="2.5"/>
				<polygon points="20,9 29,14.5 29,25.5 20,31 11,25.5 11,14.5" fill="#1E4D6B"/>
				<path d="M14.5 18 L20 24 L25.5 18" stroke="#6DB33F" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
			<span class="hidden sm:flex flex-col leading-none">
				<span class="font-display font-extrabold text-base tracking-tight text-[var(--color-text)]">Pemu</span>
				<span class="text-[9px] font-semibold tracking-widest uppercase text-[var(--color-text-muted)]">Health Supplements</span>
			</span>
		</a>

		<!-- Desktop nav -->
		<nav class="hidden lg:flex items-center gap-1 ml-2" aria-label="<?php esc_attr_e( 'Primary navigation', 'pemu' ); ?>">
			<?php
			$nav_items = [
				home_url( '/' )       => __( 'Home', 'pemu' ),
				wc_get_page_permalink( 'shop' ) => __( 'Shop', 'pemu' ),
				add_query_arg( 'product_cat', 'performance', wc_get_page_permalink( 'shop' ) ) => __( 'Performance', 'pemu' ),
				add_query_arg( 'product_cat', 'wellness', wc_get_page_permalink( 'shop' ) )    => __( 'Wellness', 'pemu' ),
				add_query_arg( 'product_cat', 'bundles', wc_get_page_permalink( 'shop' ) )     => __( 'Bundles', 'pemu' ),
			];
			$current = home_url( add_query_arg( [] ) );
			foreach ( $nav_items as $url => $label ) :
				$is_active = rtrim( $current, '/' ) === rtrim( $url, '/' );
			?>
			<a href="<?php echo esc_url( $url ); ?>"
			   class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors duration-150 <?php echo $is_active ? 'text-brand-green bg-brand-green/5' : 'text-[var(--color-text)] hover:text-brand-green hover:bg-[var(--color-bg-muted)]'; ?>">
				<?php echo esc_html( $label ); ?>
			</a>
			<?php endforeach; ?>
		</nav>

		<div class="flex-1"></div>

		<!-- Search button -->
		<button @click="$store.ui.searchOpen = !$store.ui.searchOpen"
		        aria-label="<?php esc_attr_e( 'Search products', 'pemu' ); ?>"
		        :aria-expanded="$store.ui.searchOpen.toString()"
		        class="p-2 rounded-lg text-[var(--color-text-muted)] hover:text-[var(--color-text)] hover:bg-[var(--color-bg-muted)] transition-colors">
			<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5" stroke-linecap="round"/></svg>
		</button>

		<!-- Theme toggle (desktop) -->
		<div class="hidden sm:flex items-center gap-0.5 p-1 rounded-full bg-[var(--color-bg-muted)] border border-[var(--color-border)]"
		     x-data="{ theme: localStorage.getItem('pemu-theme') || 'system' }"
		     role="group"
		     aria-label="<?php esc_attr_e( 'Colour theme', 'pemu' ); ?>">
			<?php
			$modes = [
				'light'  => [ 'label' => __( 'Light', 'pemu' ),  'icon' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 7a5 5 0 1 1 0 10A5 5 0 0 1 12 7z' ],
				'dark'   => [ 'label' => __( 'Dark', 'pemu' ),   'icon' => 'M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z' ],
				'system' => [ 'label' => __( 'System', 'pemu' ), 'icon' => 'M3 5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2zM8 21h8M12 17v4' ],
			];
			foreach ( $modes as $mode => $data ) : ?>
			<button @click="theme='<?php echo esc_attr( $mode ); ?>'; window.pemuSetTheme('<?php echo esc_attr( $mode ); ?>')"
			        :class="theme==='<?php echo esc_attr( $mode ); ?>' ? 'bg-brand-green text-white shadow-sm' : 'text-[var(--color-text-muted)] hover:text-[var(--color-text)]'"
			        class="p-1.5 rounded-full transition-all duration-150 text-xs"
			        aria-label="<?php echo esc_attr( $data['label'] ); ?> <?php esc_attr_e( 'mode', 'pemu' ); ?>">
				<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
					<path d="<?php echo esc_attr( $data['icon'] ); ?>" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</button>
			<?php endforeach; ?>
		</div>

		<!-- Cart icon -->
		<button @click="$store.ui.cartDrawerOpen = true"
		        aria-label="<?php esc_attr_e( 'Open cart', 'pemu' ); ?>"
		        :aria-expanded="$store.ui.cartDrawerOpen.toString()"
		        class="relative p-2 rounded-lg text-[var(--color-text-muted)] hover:text-[var(--color-text)] hover:bg-[var(--color-bg-muted)] transition-colors">
			<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
				<path d="M3 3h2l2.5 12.5a2 2 0 0 0 2 1.5h9a2 2 0 0 0 2-1.5L22 7H6" stroke-linecap="round" stroke-linejoin="round"/>
				<circle cx="9" cy="20" r="1.5" fill="currentColor" stroke="none"/>
				<circle cx="18" cy="20" r="1.5" fill="currentColor" stroke="none"/>
			</svg>
			<?php $count = function_exists( 'WC' ) ? WC()->cart->get_cart_contents_count() : 0; ?>
			<span class="pemu-cart-count absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] px-1 flex items-center justify-center rounded-full bg-brand-green text-white text-[10px] font-bold leading-none<?php echo 0 === $count ? ' hidden' : ''; ?>"
			      aria-hidden="true">
				<?php echo esc_html( $count ); ?>
			</span>
		</button>

	</div><!-- /inner -->

	<!-- ── Search overlay ─────────────────────────────────────── -->
	<div x-show="$store.ui.searchOpen"
	     x-cloak
	     x-transition:enter="transition ease-out duration-200"
	     x-transition:enter-start="opacity-0 -translate-y-2"
	     x-transition:enter-end="opacity-100 translate-y-0"
	     x-transition:leave="transition ease-in duration-150"
	     x-transition:leave-start="opacity-100 translate-y-0"
	     x-transition:leave-end="opacity-0 -translate-y-2"
	     class="absolute inset-x-0 top-full border-b border-[var(--color-border)] bg-[var(--color-surface)] shadow-xl px-4 py-4 z-50"
	     @click.outside="$store.ui.searchOpen = false">
		<div class="max-w-2xl mx-auto">
			<?php get_search_form(); ?>
			<p class="mt-2 text-xs text-[var(--color-text-muted)] text-center"><?php esc_html_e( 'Search products, brands, categories…', 'pemu' ); ?></p>
		</div>
	</div>

</header>

<!-- ════════════════════════════════════════════════════════════
     MOBILE MENU DRAWER
════════════════════════════════════════════════════════════ -->
<div x-show="$store.ui.mobileMenuOpen"
     x-cloak
     class="fixed inset-0 z-[60] lg:hidden"
     aria-label="<?php esc_attr_e( 'Mobile navigation', 'pemu' ); ?>"
     role="dialog"
     aria-modal="true"
     @keydown.escape.window="$store.ui.mobileMenuOpen = false">
	<!-- Backdrop -->
	<div x-show="$store.ui.mobileMenuOpen"
	     x-transition:enter="transition-opacity ease-out duration-300"
	     x-transition:enter-start="opacity-0"
	     x-transition:enter-end="opacity-100"
	     x-transition:leave="transition-opacity ease-in duration-200"
	     x-transition:leave-start="opacity-100"
	     x-transition:leave-end="opacity-0"
	     class="absolute inset-0 bg-black/60 backdrop-blur-sm"
	     @click="$store.ui.mobileMenuOpen = false"
	     aria-hidden="true"></div>
	<!-- Panel -->
	<aside x-show="$store.ui.mobileMenuOpen"
	       x-transition:enter="transition transform ease-out duration-300"
	       x-transition:enter-start="-translate-x-full"
	       x-transition:enter-end="translate-x-0"
	       x-transition:leave="transition transform ease-in duration-200"
	       x-transition:leave-start="translate-x-0"
	       x-transition:leave-end="-translate-x-full"
	       class="absolute left-0 top-0 bottom-0 w-80 max-w-[85vw] flex flex-col bg-[var(--color-surface)] shadow-2xl overflow-y-auto">
		<!-- Panel header -->
		<div class="flex items-center justify-between px-5 py-4 border-b border-[var(--color-border)]">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2">
				<svg viewBox="0 0 40 40" class="w-8 h-8"><polygon points="20,2 36,11 36,29 20,38 4,29 4,11" fill="none" stroke="#6DB33F" stroke-width="2.5"/><polygon points="20,9 29,14.5 29,25.5 20,31 11,25.5 11,14.5" fill="#1E4D6B"/><path d="M14.5 18 L20 24 L25.5 18" stroke="#6DB33F" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
				<span class="font-display font-extrabold text-[var(--color-text)]">Pemu Health</span>
			</a>
			<button @click="$store.ui.mobileMenuOpen = false"
			        aria-label="<?php esc_attr_e( 'Close menu', 'pemu' ); ?>"
			        class="p-2 rounded-lg hover:bg-[var(--color-bg-muted)] text-[var(--color-text-muted)] hover:text-[var(--color-text)] transition-colors">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</button>
		</div>
		<!-- Nav links -->
		<nav class="flex-1 flex flex-col gap-0.5 p-4" aria-label="<?php esc_attr_e( 'Mobile navigation', 'pemu' ); ?>">
			<?php
			$mobile_nav = [
				[ 'url' => home_url( '/' ), 'label' => __( 'Home', 'pemu' ), 'icon' => 'M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z' ],
				[ 'url' => wc_get_page_permalink( 'shop' ), 'label' => __( 'Shop All', 'pemu' ), 'icon' => 'M3 9h18l-2 11H5zM8 9V6a4 4 0 118 0v3' ],
				[ 'url' => add_query_arg( 'product_cat', 'performance', wc_get_page_permalink( 'shop' ) ), 'label' => __( 'Performance', 'pemu' ), 'icon' => 'M13 2L3 14h9l-1 8 10-12h-9l1-8z' ],
				[ 'url' => add_query_arg( 'product_cat', 'wellness', wc_get_page_permalink( 'shop' ) ), 'label' => __( 'Wellness', 'pemu' ), 'icon' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z' ],
				[ 'url' => wc_get_account_endpoint_url( 'orders' ), 'label' => __( 'My Account', 'pemu' ), 'icon' => 'M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z' ],
			];
			foreach ( $mobile_nav as $item ) : ?>
			<a href="<?php echo esc_url( $item['url'] ); ?>"
			   @click="$store.ui.mobileMenuOpen = false"
			   class="flex items-center gap-3 px-3 py-3.5 rounded-xl text-base font-semibold text-[var(--color-text)] hover:bg-[var(--color-bg-muted)] hover:text-brand-green transition-colors group">
				<svg class="w-5 h-5 shrink-0 text-[var(--color-text-muted)] group-hover:text-brand-green transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
					<path d="<?php echo esc_attr( $item['icon'] ); ?>" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<?php echo esc_html( $item['label'] ); ?>
			</a>
			<?php endforeach; ?>
		</nav>
		<!-- Bottom: WhatsApp CTA + theme toggle -->
		<div class="p-4 border-t border-[var(--color-border)] space-y-3">
			<a href="<?php echo esc_url( pemu_whatsapp_url( 'Hi Pemu Health! 👋 I need help with an order.' ) ); ?>"
			   target="_blank" rel="noopener noreferrer"
			   class="flex items-center justify-center gap-2 w-full bg-[#25D366] hover:bg-[#1db954] text-white font-bold py-3 rounded-xl transition-colors">
				<?php echo pemu_icon( 'whatsapp', [ 'class' => 'w-5 h-5 flex-shrink-0' ] ); ?>
				<?php esc_html_e( 'WhatsApp Us', 'pemu' ); ?>
			</a>
			<!-- Mobile theme toggle -->
			<div class="flex items-center justify-center gap-1 p-1 rounded-full bg-[var(--color-bg-muted)]"
			     x-data="{ theme: localStorage.getItem('pemu-theme') || 'system' }">
				<?php foreach ( $modes as $mode => $data ) : ?>
				<button @click="theme='<?php echo esc_attr( $mode ); ?>'; window.pemuSetTheme('<?php echo esc_attr( $mode ); ?>')"
				        :class="theme==='<?php echo esc_attr( $mode ); ?>' ? 'bg-brand-green text-white' : 'text-[var(--color-text-muted)]'"
				        class="flex-1 py-2 text-xs font-semibold rounded-full transition-all duration-150">
					<?php echo esc_html( $data['label'] ); ?>
				</button>
				<?php endforeach; ?>
			</div>
		</div>
	</aside>
</div>

<!-- ════════════════════════════════════════════════════════════
     CART DRAWER
════════════════════════════════════════════════════════════ -->
<div x-show="$store.ui.cartDrawerOpen"
     x-cloak
     class="fixed inset-0 z-[60]"
     aria-label="<?php esc_attr_e( 'Shopping cart', 'pemu' ); ?>"
     role="dialog"
     aria-modal="true">
	<!-- Backdrop -->
	<div x-show="$store.ui.cartDrawerOpen"
	     x-transition:enter="transition-opacity ease-out duration-300"
	     x-transition:enter-start="opacity-0"
	     x-transition:enter-end="opacity-100"
	     x-transition:leave="transition-opacity ease-in duration-200"
	     x-transition:leave-start="opacity-100"
	     x-transition:leave-end="opacity-0"
	     class="absolute inset-0 bg-black/60 backdrop-blur-sm"
	     @click="$store.ui.cartDrawerOpen = false"
	     aria-hidden="true"></div>
	<!-- Panel -->
	<aside x-show="$store.ui.cartDrawerOpen"
	       x-transition:enter="transition transform ease-out duration-300"
	       x-transition:enter-start="translate-x-full"
	       x-transition:enter-end="translate-x-0"
	       x-transition:leave="transition transform ease-in duration-200"
	       x-transition:leave-start="translate-x-0"
	       x-transition:leave-end="translate-x-full"
	       class="absolute right-0 top-0 bottom-0 w-[420px] max-w-[92vw] flex flex-col bg-[var(--color-surface)] shadow-2xl">
		<!-- Cart header -->
		<div class="flex items-center justify-between px-5 py-4 border-b border-[var(--color-border)]">
			<div class="flex items-center gap-2">
				<svg class="w-5 h-5 text-brand-green" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3h2l2.5 12.5a2 2 0 002 1.5h9a2 2 0 002-1.5L22 7H6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="20" r="1.5" fill="currentColor" stroke="none"/><circle cx="18" cy="20" r="1.5" fill="currentColor" stroke="none"/></svg>
				<h2 class="font-display font-bold text-lg text-[var(--color-text)]">
					<?php esc_html_e( 'Your Cart', 'pemu' ); ?>
					<?php if ( $count > 0 ) : ?>
					<span class="ml-1 text-sm font-normal text-[var(--color-text-muted)]">(<?php echo esc_html( $count ); ?>)</span>
					<?php endif; ?>
				</h2>
			</div>
			<button @click="$store.ui.cartDrawerOpen = false"
			        aria-label="<?php esc_attr_e( 'Close cart', 'pemu' ); ?>"
			        class="p-2 rounded-lg hover:bg-[var(--color-bg-muted)] text-[var(--color-text-muted)] hover:text-[var(--color-text)] transition-colors">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</button>
		</div>
		<!-- Mini cart content (WooCommerce fragment) -->
		<div class="pemu-mini-cart-inner flex-1 overflow-y-auto">
			<?php woocommerce_mini_cart(); ?>
		</div>
	</aside>
</div>

<!-- ════════════════════════════════════════════════════════════
     PAGE CONTENT BEGINS
════════════════════════════════════════════════════════════ -->

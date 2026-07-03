<?php
/**
 * Pemu Health — footer.php
 */
defined( 'ABSPATH' ) || exit;

// Safely get cart count — avoid undefined variable
$cart_count = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
?>

<footer class="bg-gray-100 dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 pb-20 lg:pb-0 mt-auto">
    <div class="max-w-7xl mx-auto px-4 pt-14 pb-10">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">

            <!-- Brand -->
            <div class="lg:col-span-1">
                <a href="<?php echo esc_url( home_url('/') ); ?>" class="inline-flex items-center gap-2.5 mb-4">
                    <svg viewBox="0 0 40 40" class="w-10 h-10 shrink-0" aria-hidden="true">
                        <polygon points="20,2 36,11 36,29 20,38 4,29 4,11" fill="none" stroke="#6DB33F"
                            stroke-width="2.5" />
                        <polygon points="20,9 29,14.5 29,25.5 20,31 11,25.5 11,14.5" fill="#1E4D6B" />
                        <path d="M14.5 18 L20 24 L25.5 18" stroke="#6DB33F" stroke-width="2.5" fill="none"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex flex-col leading-tight">
                        <span class="font-display font-extrabold text-lg text-slate-800 dark:text-slate-200">Pemu
                            Ventures</span>
                        <span class="text-[10px] font-medium tracking-wide text-slate-500 dark:text-slate-400">Your
                            health, Our priority.</span>
                    </div>
                </a>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed max-w-xs">
                    <?php echo esc_html( get_option( 'pemu_footer_tagline', 'Natural health, real results! Trusted organic products for energy, immunity, detox &amp; hormone balance.' ) ); ?>
                </p>
                <!-- Socials -->
                <div class="flex items-center gap-3 mt-5">
                    <?php
				$tiktok_url    = get_option( 'pemu_social_tiktok', 'https://tiktok.com/@pemuventures' );
				$instagram_url = get_option( 'pemu_social_instagram', 'https://instagram.com/pesh_muturi' );
				?>
                    <?php if ( $tiktok_url ) : ?>
                    <a href="<?php echo esc_url( $tiktok_url ); ?>" target="_blank" rel="noopener noreferrer"
                        aria-label="TikTok"
                        class="w-9 h-9 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-brand-green hover:border-brand-green transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.34 6.34 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.27 8.27 0 004.84 1.55V6.79a4.85 4.85 0 01-1.07-.1z" />
                        </svg>
                    </a>
                    <?php endif; ?>
                    <?php if ( $instagram_url ) : ?>
                    <a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer"
                        aria-label="Instagram"
                        class="w-9 h-9 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-brand-green hover:border-brand-green transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                            <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" />
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
                        </svg>
                    </a>
                    <?php endif; ?>
                    <a href="<?php echo esc_url( pemu_whatsapp_url('Hi Pemu Ventures! 👋 I have a question.') ); ?>"
                        target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"
                        class="w-9 h-9 rounded-full bg-green-500 flex items-center justify-center text-white hover:bg-green-600 transition-colors">
                        <svg class="w-4 h-4" fill="black" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Shop -->
            <div>
                <h3
                    class="font-display font-bold text-sm uppercase tracking-widest mb-4 text-slate-800 dark:text-slate-200">
                    <?php esc_html_e('Shop','pemu'); ?></h3>
                <ul class="list-none pl-0 space-y-2.5 text-sm text-slate-500 dark:text-slate-400">
                    <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
                            class="hover:text-brand-green transition-colors"><?php esc_html_e('All Products','pemu'); ?></a>
                    </li>
                    <li><a href="<?php echo esc_url(get_term_link('body-enhancement-supplements','product_cat') ?: wc_get_page_permalink('shop')); ?>"
                            class="hover:text-brand-green transition-colors"><?php esc_html_e('Body Enhancement','pemu'); ?></a>
                    </li>
                    <li><a href="<?php echo esc_url(get_term_link('supplements-and-vitamins','product_cat') ?: wc_get_page_permalink('shop')); ?>"
                            class="hover:text-brand-green transition-colors"><?php esc_html_e('Supplements & Vitamins','pemu'); ?></a>
                    </li>
                    <li><a href="<?php echo esc_url(get_term_link('weight-control-supplements','product_cat') ?: wc_get_page_permalink('shop')); ?>"
                            class="hover:text-brand-green transition-colors"><?php esc_html_e('Weight Control','pemu'); ?></a>
                    </li>
                </ul>
            </div>

            <!-- Help -->
            <div>
                <h3
                    class="font-display font-bold text-sm uppercase tracking-widest mb-4 text-slate-800 dark:text-slate-200">
                    <?php esc_html_e('Help','pemu'); ?></h3>
                <ul class="list-none pl-0 space-y-2.5 text-sm text-slate-500 dark:text-slate-400">
                    <li><a href="<?php echo esc_url(pemu_whatsapp_url('Hi! I need help with my order.')); ?>"
                            target="_blank" rel="noopener"
                            class="hover:text-brand-green transition-colors"><?php esc_html_e('WhatsApp Support','pemu'); ?></a>
                    </li>
                    <li><a href="<?php echo esc_url(home_url('/faq/')); ?>"
                            class="hover:text-brand-green transition-colors"><?php esc_html_e('FAQ','pemu'); ?></a></li>
                    <li><a href="<?php echo esc_url(get_privacy_policy_url() ?: '#'); ?>"
                            class="hover:text-brand-green transition-colors"><?php esc_html_e('Privacy Policy','pemu'); ?></a>
                    </li>
                    <li><a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>"
                            class="hover:text-brand-green transition-colors"><?php esc_html_e('My Orders','pemu'); ?></a>
                    </li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3
                    class="font-display font-bold text-sm uppercase tracking-widest mb-4 text-slate-800 dark:text-slate-200">
                    <?php esc_html_e('Contact','pemu'); ?></h3>
                <ul class="list-none pl-0 space-y-3 text-sm text-slate-500 dark:text-slate-400">
                    <?php
					$wa_phone = get_option( 'pemu_phone', '0707 551 484' );
					$email    = get_option( 'pemu_email', 'Pemuherbalsupplements@gmail.com' );
					$address  = get_option( 'pemu_address', 'Nairobi, Kenya' );
					?>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        <a href="<?php echo esc_url( pemu_whatsapp_url() ); ?>" target="_blank" rel="noopener"
                            class="hover:text-brand-green transition-colors"><?php echo esc_html( $wa_phone ); ?></a>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-brand-green" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>"
                            class="hover:text-brand-green transition-colors break-all"><?php echo esc_html( $email ); ?></a>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-brand-green" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        <span><?php echo esc_html( $address ); ?><br><small
                                class="text-[10px]"><?php esc_html_e( 'Countrywide Delivery', 'pemu' ); ?></small></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Bottom bar -->
    <div class="border-t border-slate-200 dark:border-slate-700">
        <div
            class="max-w-7xl mx-auto px-4 py-4 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-500 dark:text-slate-400">
            <p><?php echo esc_html( get_option('pemu_footer_copyright','© '.date('Y').' Pemu Ventures. All rights reserved.') ); ?>
            </p>
            <div class="flex flex-wrap items-center gap-3">
                <span
                    class="inline-flex items-center gap-1 border border-slate-200 dark:border-slate-700 rounded-full px-2.5 py-1">🔒
                    SSL</span>
                <span
                    class="inline-flex items-center gap-1 border border-slate-200 dark:border-slate-700 rounded-full px-2.5 py-1">🌿
                    Organic</span>
                <span
                    class="inline-flex items-center gap-1 border border-slate-200 dark:border-slate-700 rounded-full px-2.5 py-1">✅
                    Authentic</span>
            </div>
        </div>
    </div>
</footer>

<!-- Floating WhatsApp -->
<?php pemu_floating_whatsapp_btn(); ?>

<!-- Back to Top Button -->
<button x-show="scrolled" x-transition.opacity.duration.300ms @click="window.scrollTo({top:0, behavior:'smooth'})"
    aria-label="Back to top"
    class="fixed bottom-24 lg:bottom-6 left-4 lg:left-6 z-[45] w-12 h-12 rounded-full bg-brand-navy text-white flex items-center justify-center shadow-lg shadow-brand-navy/30 hover:bg-brand-green hover:-translate-y-1 transition-all duration-300"
    x-cloak>
    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
    </svg>
</button>

<!-- Mobile bottom navigation -->
<nav class="fixed bottom-0 inset-x-0 z-40 lg:hidden bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700"
    aria-label="<?php esc_attr_e('Mobile navigation','pemu'); ?>">
    <div class="grid grid-cols-4 h-[60px]">
        <?php
		$bottom_nav = [
			['url' => home_url('/'),                     'label' => __('Home','pemu'),    'icon' => 'M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z',                    'active' => is_front_page()],
			['url' => wc_get_page_permalink('shop'),     'label' => __('Shop','pemu'),    'icon' => 'M3 9h18l-2 11H5zM8 9V6a4 4 0 118 0v3',                            'active' => (function_exists('is_shop') && (is_shop()||is_product_category()))],
			['url' => wc_get_cart_url(),                 'label' => __('Cart','pemu'),    'icon' => 'M3 3h2l2.5 12.5a2 2 0 002 1.5h9a2 2 0 002-1.5L22 7H6',           'active' => (function_exists('is_cart') && is_cart()), 'badge' => $cart_count],
			['url' => wc_get_account_endpoint_url('dashboard'), 'label' => __('Account','pemu'), 'icon' => 'M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z', 'active' => (function_exists('is_account_page') && is_account_page())],
		];
		foreach ( $bottom_nav as $item ) :
			$active = !empty($item['active']);
		?>
        <a href="<?php echo esc_url($item['url']); ?>"
            class="flex flex-col items-center justify-center gap-0.5 text-[10px] font-semibold transition-colors relative <?php echo $active ? 'text-brand-green' : 'text-slate-500 dark:text-slate-400'; ?>"
            <?php if ($active) echo 'aria-current="page"'; ?>>
            <?php if ( !empty($item['badge']) && $item['badge'] > 0 ) : ?>
            <span x-data x-text="$store.cart.count" x-show="$store.cart.count > 0"
                :class="{'scale-125': $store.cart.animating}"
                class="pemu-cart-count absolute -top-1.5 -right-1.5 min-w-[20px] h-[20px] px-1 flex items-center justify-center rounded-full bg-brand-green text-white text-[11px] font-bold leading-none ring-2 ring-white dark:ring-slate-800 transition-transform duration-300"
                aria-hidden="true"></span>
            <?php endif; ?>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                aria-hidden="true">
                <path d="<?php echo esc_attr($item['icon']); ?>" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span><?php echo esc_html($item['label']); ?></span>
        </a>
        <?php endforeach; ?>
    </div>
</nav>

</div><!-- /#pemu-app -->

<?php wp_footer(); ?>



</body>

</html>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="icon" type="image/png"
        href="<?php echo get_template_directory_uri(); ?>/assets/favicon/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png"
        href="<?php echo get_template_directory_uri(); ?>/assets/favicon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/svg+xml"
        href="<?php echo get_template_directory_uri(); ?>/assets/favicon/favicon.svg" />
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180"
        href="<?php echo get_template_directory_uri(); ?>/assets/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Wilson Devops" />
    <meta name="application-name" content="Wilson Devops" />
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/assets/favicon/site.webmanifest" />
    <?php wp_head(); ?>
</head>

<body
    <?php body_class('min-h-screen antialiased bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 font-body'); ?>>
    <?php wp_body_open(); ?>

    <!-- Alpine global state -->
    <div id="pemu-app" x-data="{
       mobileMenuOpen: false,
       cartDrawerOpen: false,
       searchOpen: false,
       filtersOpen: false,
       scrolled: false,
       theme: localStorage.getItem('pemu-theme') || 'system',
       setTheme(v){ this.theme=v; window.pemuSetTheme(v); },
       init(){
         window.addEventListener('scroll', ()=>{ this.scrolled = window.scrollY>10; }, {passive:true});
       }
     }" x-init="init()">

        <!-- Toast notifications (Alpine-managed) -->
        <div x-data x-show="$store.cart.toastVisible" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-4"
            class="fixed top-20 right-4 z-[70] max-w-sm w-full bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 p-4 flex items-start gap-3 pointer-events-auto"
            role="alert">
            <span class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center"
                :class="$store.cart.toastType === 'error' ? 'bg-red-500/10 text-red-500' : 'bg-brand-green/10 text-brand-green'">
                <svg x-show="$store.cart.toastType === 'success'" class="w-4 h-4" fill="none" stroke="currentColor"
                    stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <svg x-show="$store.cart.toastType === 'error'" class="w-4 h-4" fill="none" stroke="currentColor"
                    stroke-width="2.5" viewBox="0 0 24 24" style="display:none;">
                    <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <line x1="12" y1="9" x2="12" y2="13" stroke-linecap="round" stroke-linejoin="round" />
                    <line x1="12" y1="17" x2="12.01" y2="17" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
            <div class="flex-1 min-w-0">
                <p class="font-bold text-sm text-slate-800 dark:text-slate-200" x-text="$store.cart.toastMessage">Added
                    to cart!</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5" x-text="$store.cart.toastSubtitle">Your
                    cart has been updated.</p>
            </div>
            <button @click="$store.cart.toastVisible = false"
                class="shrink-0 p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"
                aria-label="Dismiss">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" />
                </svg>
            </button>
        </div>

        <?php
        /* Announcement bar */
        if ( get_theme_mod('pemu_announcement_enabled', true) ) :
        $ann = get_theme_mod('pemu_announcement_text','🌿 Natural health, real results! Trusted organic products — countrywide delivery available.');
        ?>
        <div x-data="{show:!localStorage.getItem('pemu-ann-v2')}" x-show="show" x-cloak
            class="bg-brand-navy text-white text-xs sm:text-sm">
            <div class="max-w-7xl mx-auto px-4 py-2.5 flex items-center gap-3">
                <p class="flex-1 text-center font-medium"><?php echo esc_html($ann); ?></p>
                <button @click="show=false;localStorage.setItem('pemu-ann-v2','1')" aria-label="Dismiss"
                    class="shrink-0 opacity-60 hover:opacity-100 p-1 rounded transition-opacity">✕</button>
            </div>
        </div>
        <?php endif; ?>

        <!-- HEADER -->
        <header id="site-header" :class="{'shadow-lg shadow-black/5': scrolled}"
            class="sticky top-0 z-40 border-b border-slate-200 dark:border-slate-700 bg-white/70 dark:bg-slate-800/75 backdrop-blur-xl transition-shadow duration-200">
            <div class="max-w-7xl mx-auto px-4 h-16 flex items-center gap-3">

                <!-- Logo -->
                <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2.5 shrink-0"
                    aria-label="Pemu Ventures – Home">
                    <svg viewBox="0 0 40 40" class="w-9 h-9 shrink-0" aria-hidden="true">
                        <polygon points="20,2 36,11 36,29 20,38 4,29 4,11" fill="none" stroke="#6DB33F"
                            stroke-width="2.5" />
                        <polygon points="20,9 29,14.5 29,25.5 20,31 11,25.5 11,14.5" fill="#1E4D6B" />
                        <path d="M14.5 18 L20 24 L25.5 18" stroke="#6DB33F" stroke-width="2.5" fill="none"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="hidden sm:flex flex-col leading-none">
                        <span class="font-display font-extrabold text-[15px] text-slate-800 dark:text-slate-200">Pemu
                            Ventures</span>
                        <span class="text-[9px] text-slate-500 dark:text-slate-400 font-medium tracking-wide">Your
                            health,
                            Our priority.</span>
                    </div>
                </a>

                <!-- Desktop nav -->
                <nav class="hidden lg:flex items-center gap-0.5 ml-4" aria-label="Primary navigation">
                    <?php
                    $shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
                    $cats = [
                        $shop_url => 'All Products',
                        get_term_link('body-enhancement-supplements','product_cat') ?: add_query_arg('product_cat','body-enhancement-supplements',$shop_url) => 'Body Enhancement',
                        get_term_link('supplements-and-vitamins','product_cat')     ?: add_query_arg('product_cat','supplements-and-vitamins',$shop_url)     => 'Supplements & Vitamins',
                        get_term_link('weight-control-supplements','product_cat')   ?: add_query_arg('product_cat','weight-control-supplements',$shop_url)   => 'Weight Control',
                    ];
                    foreach ($cats as $url => $label) :
                        if (is_wp_error($url)) $url = $shop_url;
                        $active = rtrim($_SERVER['REQUEST_URI'],'/') !== '' && strpos($_SERVER['REQUEST_URI'], parse_url((string)$url, PHP_URL_PATH)) !== false;
                    ?>
                    <a href="<?php echo esc_url((string)$url); ?>"
                        class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors <?php echo $active ? 'text-brand-green bg-brand-green/8' : 'text-slate-800 dark:text-slate-200 hover:text-brand-green hover:bg-gray-100 dark:hover:bg-slate-800'; ?>">
                        <?php echo esc_html($label); ?>
                    </a>
                    <?php endforeach; ?>
                </nav>

                <div class="flex-1"></div>

                <!-- Search -->
                <button @click="searchOpen=!searchOpen" :aria-expanded="searchOpen.toString()"
                    aria-label="Search products"
                    class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <circle cx="11" cy="11" r="7" />
                        <path d="m20 20-3.5-3.5" stroke-linecap="round" />
                    </svg>
                </button>

                <!-- Theme toggle (desktop) -->
                <div class="hidden sm:flex items-center gap-0.5 p-1 rounded-full bg-gray-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700"
                    role="group" aria-label="Theme">
                    <button @click="setTheme('light')"
                        :class="theme==='light'?'bg-brand-green text-white':'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200'"
                        class="p-1.5 rounded-full transition-all text-xs" aria-label="Light mode">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="5" />
                            <path
                                d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"
                                stroke-linecap="round" />
                        </svg>
                    </button>
                    <button @click="setTheme('dark')"
                        :class="theme==='dark'?'bg-brand-green text-white':'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200'"
                        class="p-1.5 rounded-full transition-all" aria-label="Dark mode">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button @click="setTheme('system')"
                        :class="theme==='system'?'bg-brand-green text-white':'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200'"
                        class="p-1.5 rounded-full transition-all text-xs" aria-label="System mode">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="2" y="3" width="20" height="14" rx="2" />
                            <path d="M8 21h8M12 17v4" stroke-linecap="round" />
                        </svg>
                    </button>
                </div>

                <!-- Cart icon -->
                <?php $cart_count = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0; ?>
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>"
                    class="relative p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors"
                    aria-label="View cart">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path d="M3 3h2l2.5 12.5a2 2 0 002 1.5h9a2 2 0 002-1.5L22 7H6" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <circle cx="9" cy="20" r="1.5" fill="currentColor" stroke="none" />
                        <circle cx="18" cy="20" r="1.5" fill="currentColor" stroke="none" />
                    </svg>
                    <span x-data x-text="$store.cart.count" x-show="$store.cart.count > 0"
                        :class="{'scale-125': $store.cart.animating}"
                        class="pemu-cart-count absolute top-0 right-0 min-w-[20px] h-[20px] px-1 flex items-center justify-center rounded-full bg-brand-green text-white text-[11px] font-bold leading-none ring-2 ring-white dark:ring-slate-800 transition-transform duration-300"
                        aria-hidden="true"></span>
                </a>
                <?php /* Hidden element: WC swaps this via fragments to pass count to Alpine. The badge above is Alpine-managed and never touched by WC. */ ?>
                <span data-pemu-cart-count="<?php echo esc_attr($cart_count); ?>" style="display:none;"
                    aria-hidden="true"></span>

                <!-- Mobile menu button -->
                <button @click="mobileMenuOpen=true" :aria-expanded="mobileMenuOpen.toString()" aria-label="Open menu"
                    class="lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors text-slate-800 dark:text-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" />
                    </svg>
                </button>
            </div>

            <!-- Search overlay -->
            <div x-show="searchOpen" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                @click.outside="searchOpen=false"
                class="absolute inset-x-0 top-full bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 shadow-xl px-4 py-4 z-50">
                <div class="max-w-2xl mx-auto">
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="flex gap-2">
                        <input type="search" name="s" placeholder="<?php esc_attr_e('Search products…','pemu'); ?>"
                            class="flex-1 px-4 py-3 rounded-xl bg-gray-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-green"
                            x-ref="searchInput" x-effect="if(searchOpen) $nextTick(()=>$refs.searchInput?.focus())"
                            autocomplete="off">
                        <input type="hidden" name="post_type" value="product">
                        <button type="submit"
                            class="px-5 py-3 bg-brand-green hover:bg-brand-green-dark text-white font-bold rounded-xl transition-colors text-sm">
                            <?php esc_html_e('Search','pemu'); ?>
                        </button>
                        <button type="button" @click="searchOpen=false"
                            class="px-3 py-3 text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors"
                            aria-label="Close search">✕</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- MOBILE MENU -->
        <div x-show="mobileMenuOpen" x-cloak class="fixed inset-0 z-[60] lg:hidden" role="dialog" aria-modal="true"
            aria-label="Mobile menu">
            <div x-show="mobileMenuOpen" x-transition:enter="transition-opacity ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" @click="mobileMenuOpen=false"
                class="absolute inset-0 bg-black/60 backdrop-blur-sm" aria-hidden="true"></div>
            <aside x-show="mobileMenuOpen" x-transition:enter="transition transform ease-out duration-300"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="absolute left-0 top-0 bottom-0 w-80 max-w-[85vw] flex flex-col bg-white dark:bg-slate-800 shadow-2xl overflow-y-auto">
                <div
                    class="flex items-center justify-between px-5 py-4 border-b border-slate-200 dark:border-slate-700">
                    <span class="font-display font-bold text-lg text-slate-800 dark:text-slate-200">Menu</span>
                    <button @click="mobileMenuOpen=false"
                        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 text-slate-500 dark:text-slate-400"
                        aria-label="Close menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" />
                        </svg>
                    </button>
                </div>
                <nav class="flex-1 flex flex-col gap-0.5 p-4">
                    <?php
      $shop = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
      $mobile_links = [
        home_url('/') => ['label'=>'Home','icon'=>'M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z'],
        $shop => ['label'=>'All Products','icon'=>'M3 9h18l-2 11H5zM8 9V6a4 4 0 118 0v3'],
        (get_term_link('body-enhancement-supplements','product_cat') ?: $shop) => ['label'=>'Body Enhancement','icon'=>'M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 00-2.91-.09z M12 15l-3-3a22 22 0 012-3.95A12.88 12.88 0 0122 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 01-4 2z'],
        (get_term_link('supplements-and-vitamins','product_cat') ?: $shop) => ['label'=>'Supplements & Vitamins','icon'=>'M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18'],
        (get_term_link('weight-control-supplements','product_cat') ?: $shop) => ['label'=>'Weight Control','icon'=>'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3'],
        home_url('/faq/') => ['label'=>'FAQ','icon'=>'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        wc_get_account_endpoint_url('dashboard') => ['label'=>'My Account','icon'=>'M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z'],
      ];
      foreach ($mobile_links as $url => $data) :
        if (is_wp_error($url)) $url = $shop;
      ?>
                    <a href="<?php echo esc_url((string)$url); ?>" @click="mobileMenuOpen=false"
                        class="flex items-center gap-3 px-3 py-3.5 rounded-xl text-sm font-semibold text-slate-800 dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-brand-green transition-colors group">
                        <svg class="w-5 h-5 shrink-0 text-slate-500 dark:text-slate-400 group-hover:text-brand-green"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="<?php echo esc_attr($data['icon']); ?>" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <?php echo esc_html($data['label']); ?>
                    </a>
                    <?php endforeach; ?>
                </nav>
                <div class="p-4 border-t border-slate-200 dark:border-slate-700 space-y-3">
                    <a href="<?php echo esc_url(pemu_whatsapp_url('Hi Pemu Ventures! 👋')); ?>" target="_blank"
                        rel="noopener noreferrer"
                        class="flex items-center justify-center gap-2 w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        WhatsApp Us
                    </a>
                    <!-- Mobile theme -->
                    <div class="flex items-center rounded-xl bg-gray-100 dark:bg-slate-800 p-1 gap-1">
                        <button @click="setTheme('light')"
                            :class="theme==='light'?'bg-brand-green text-white':'text-slate-500 dark:text-slate-400'"
                            class="flex-1 py-2 rounded-lg text-xs font-bold transition-all">☀️ Light</button>
                        <button @click="setTheme('dark')"
                            :class="theme==='dark' ?'bg-brand-green text-white':'text-slate-500 dark:text-slate-400'"
                            class="flex-1 py-2 rounded-lg text-xs font-bold transition-all">🌙 Dark</button>
                        <button @click="setTheme('system')"
                            :class="theme==='system'?'bg-brand-green text-white':'text-slate-500 dark:text-slate-400'"
                            class="flex-1 py-2 rounded-lg text-xs font-bold transition-all">💻 Auto</button>
                    </div>
                </div>
            </aside>
        </div>

        <!-- Mini-cart drawer (desktop) -->
        <div x-show="cartDrawerOpen" x-cloak class="fixed inset-0 z-[60] hidden lg:block" role="dialog"
            aria-modal="true" aria-label="Shopping cart">
            <div @click="cartDrawerOpen=false" class="absolute inset-0 bg-black/50" aria-hidden="true"></div>
            <aside x-show="cartDrawerOpen" x-transition:enter="transition transform ease-out duration-300"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="absolute right-0 top-0 bottom-0 w-[420px] flex flex-col bg-white dark:bg-slate-800 shadow-2xl">
                <div
                    class="flex items-center justify-between px-5 py-4 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="font-display font-bold text-lg text-slate-800 dark:text-slate-200">
                        <?php esc_html_e('Your Cart','pemu'); ?></h2>
                    <button @click="cartDrawerOpen=false"
                        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 text-slate-500 dark:text-slate-400"
                        aria-label="Close cart">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" />
                        </svg>
                    </button>
                </div>
                <div class="pemu-mini-cart-inner flex-1 flex flex-col overflow-hidden">
                    <?php woocommerce_mini_cart(); ?>
                </div>
            </aside>
        </div>

        <!-- #pemu-app continues into page templates and closes in footer.php -->
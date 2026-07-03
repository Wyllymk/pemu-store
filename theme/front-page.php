<?php
/**
 * Pemu — front-page.php
 */
defined('ABSPATH') || exit;
get_header();
?>
<main id="main-content">
    <?php get_template_part('template-parts/sections/hero'); ?>
    <?php if (get_theme_mod('pemu_show_trust_bar',true)):  get_template_part('template-parts/sections/trust-bar'); endif; ?>
    <?php if (get_theme_mod('pemu_show_categories',true)): get_template_part('template-parts/sections/featured-categories'); endif; ?>
    <?php if (get_theme_mod('pemu_show_bestsellers',true)): get_template_part('template-parts/sections/best-sellers'); endif; ?>
    <?php get_template_part('template-parts/sections/why-choose'); ?>
    <?php if (get_theme_mod('pemu_show_new_arrivals',true)): get_template_part('template-parts/sections/new-arrivals'); endif; ?>
    <?php if (get_theme_mod('pemu_show_testimonials',true)): get_template_part('template-parts/sections/testimonials'); endif; ?>

    <!-- My Account Quick Access Section -->
    <section class="max-w-7xl mx-auto px-4 pb-10">
        <div class="relative rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-10 lg:p-14 shadow-xl overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand-green/10 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-brand-navy/10 rounded-full blur-[80px] translate-y-1/2 -translate-x-1/2 pointer-events-none"></div>
            
            <div class="relative z-10 text-center">
                <h2 class="font-display font-extrabold text-3xl lg:text-4xl text-slate-800 dark:text-slate-200 mb-4 tracking-tight">Your Account</h2>
                <?php if ( is_user_logged_in() ) : 
                    $current_user = wp_get_current_user();
                ?>
                    <p class="text-lg text-slate-500 dark:text-slate-400 mb-8 max-w-xl mx-auto leading-relaxed">
                        Welcome back, <strong class="text-slate-800 dark:text-slate-200"><?php echo esc_html( $current_user->display_name ); ?></strong>. Access your orders, manage your subscriptions, and update your profile details.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="<?php echo esc_url( wc_get_endpoint_url( 'orders', '', wc_get_page_permalink( 'myaccount' ) ) ); ?>" class="inline-flex items-center gap-2 bg-gray-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-brand-green hover:text-brand-green text-slate-800 dark:text-slate-200 font-bold px-7 py-3.5 rounded-xl transition-all duration-300">
                            📦 My Orders
                        </a>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-navy to-[#153a52] hover:from-[#153a52] hover:to-brand-navy text-white font-bold px-7 py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-brand-navy/20 hover:-translate-y-0.5">
                            ⚙️ Dashboard
                        </a>
                    </div>
                <?php else : ?>
                    <p class="text-lg text-slate-500 dark:text-slate-400 mb-8 max-w-xl mx-auto leading-relaxed">
                        Track your orders, save your favorites, and enjoy a faster, more personalised checkout experience.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-green to-brand-green-dark hover:from-brand-green-dark hover:to-brand-green text-white font-bold px-8 py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-brand-green/30 hover:shadow-brand-green/50 hover:-translate-y-0.5 text-base">
                            Log In / Register
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="max-w-7xl mx-auto px-4 pb-20">
        <div
            class="relative rounded-3xl bg-gradient-to-br from-brand-green via-brand-navy to-brand-navy p-10 lg:p-16 text-white text-center overflow-hidden">
            <div class="absolute -top-20 -right-20 w-72 h-72 rounded-full bg-white/5 pointer-events-none"
                aria-hidden="true"></div>
            <div class="absolute -bottom-20 -left-20 w-72 h-72 rounded-full bg-white/5 pointer-events-none"
                aria-hidden="true"></div>
            <div class="relative">
                <p class="text-xs font-bold tracking-widest uppercase text-white/60 mb-3">Natural Health</p>
                <h2 class="font-display font-extrabold text-3xl lg:text-5xl text-white">Ready to Feel Better?
                </h2>
                <p class="mt-4 text-lg text-white/80 max-w-xl mx-auto leading-relaxed">
                    All natural, no GMO, organic, gluten free &amp; vegan. Browse our full range or chat with us on
                    WhatsApp for personalised advice.
                </p>
                <div class="mt-8 flex flex-wrap gap-3 justify-center">
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
                        class="inline-flex items-center gap-2 bg-white text-brand-navy font-bold px-7 py-4 rounded-xl hover:bg-white/90 hover:scale-105 transition-all text-sm shadow-lg"
                        >
                        🌿 Shop Now
                    </a>
                    <a href="<?php echo esc_url(pemu_whatsapp_url("Hi Pemu Ventures! 👋 I'd like recommendations for my health goals.")); ?>"
                        target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold px-7 py-4 rounded-xl hover:scale-105 transition-all text-sm shadow-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        WhatsApp Us
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>

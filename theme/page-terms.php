<?php
/**
 * Template Name: Terms & Conditions
 * Pemu Ventures — Terms & Conditions page
 */
defined('ABSPATH') || exit;

get_header();
?>

<main id="main-content" class="min-h-screen bg-gray-100 dark:bg-slate-800 relative overflow-hidden">

    <!-- Decorative blobs -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full bg-brand-green/5 blur-3xl pointer-events-none" aria-hidden="true"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full bg-brand-navy/10 blur-3xl pointer-events-none" aria-hidden="true"></div>

    <div class="max-w-4xl mx-auto px-4 py-12 lg:py-16 relative z-10">

        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand-green/10 border border-brand-green/20 mb-5">
                <span class="w-2 h-2 rounded-full bg-brand-green shrink-0" aria-hidden="true"></span>
                <span class="text-brand-green text-xs font-bold tracking-wide uppercase"><?php esc_html_e('Legal', 'pemu'); ?></span>
            </div>
            <h1 class="font-display font-extrabold text-4xl lg:text-5xl text-slate-800 dark:text-slate-200 tracking-tight">
                <?php esc_html_e('Terms & Conditions', 'pemu'); ?>
            </h1>
            <p class="mt-4 text-lg text-slate-500 dark:text-slate-400 max-w-xl mx-auto leading-relaxed">
                <?php esc_html_e('Please read these terms carefully before using our website or placing an order.', 'pemu'); ?>
            </p>
            <p class="mt-2 text-sm text-slate-400 dark:text-slate-500">
                <?php esc_html_e('Last updated:', 'pemu'); ?> <?php echo esc_html(date_i18n('F j, Y')); ?>
            </p>
        </div>

        <div class="space-y-8">

            <!-- Section -->
            <section class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 shadow-sm">
                <h2 class="font-display font-bold text-xl text-slate-800 dark:text-slate-200 mb-3 flex items-center gap-2">
                    <span class="w-1.5 h-6 rounded-full bg-brand-green shrink-0"></span>
                    <?php esc_html_e('1. Introduction', 'pemu'); ?>
                </h2>
                <div class="text-slate-500 dark:text-slate-400 text-[15px] leading-relaxed space-y-3">
                    <p><?php esc_html_e('Welcome to Pemu Ventures. By accessing our website and/or placing an order, you agree to be bound by these Terms & Conditions. If you do not agree with any part of these terms, please do not use our website or services.', 'pemu'); ?></p>
                    <p><?php esc_html_e('Pemu Ventures is a Kenyan-based supplier of natural health supplements, body enhancement products, and wellness essentials. We deliver countrywide across all 47 counties in Kenya.', 'pemu'); ?></p>
                </div>
            </section>

            <!-- Section -->
            <section class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 shadow-sm">
                <h2 class="font-display font-bold text-xl text-slate-800 dark:text-slate-200 mb-3 flex items-center gap-2">
                    <span class="w-1.5 h-6 rounded-full bg-brand-green shrink-0"></span>
                    <?php esc_html_e('2. Products & Health Disclaimer', 'pemu'); ?>
                </h2>
                <div class="text-slate-500 dark:text-slate-400 text-[15px] leading-relaxed space-y-3">
                    <p><?php esc_html_e('All products sold by Pemu Ventures are natural health supplements intended to support general wellness. They are not intended to diagnose, treat, cure, or prevent any disease.', 'pemu'); ?></p>
                    <p><?php esc_html_e('Individual results may vary. Always consult with a qualified healthcare professional before starting any supplement regimen, especially if you are pregnant, nursing, taking medication, or have a pre-existing medical condition.', 'pemu'); ?></p>
                    <p><?php esc_html_e('Product images are for illustration purposes only. Actual product may vary slightly from images shown.', 'pemu'); ?></p>
                </div>
            </section>

            <!-- Section -->
            <section class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 shadow-sm">
                <h2 class="font-display font-bold text-xl text-slate-800 dark:text-slate-200 mb-3 flex items-center gap-2">
                    <span class="w-1.5 h-6 rounded-full bg-brand-green shrink-0"></span>
                    <?php esc_html_e('3. Ordering & Payment', 'pemu'); ?>
                </h2>
                <div class="text-slate-500 dark:text-slate-400 text-[15px] leading-relaxed space-y-3">
                    <p><?php esc_html_e('Orders can be placed via our website or through WhatsApp at +254 707 551 484.', 'pemu'); ?></p>
                    <p><?php esc_html_e('Payment methods accepted include M-Pesa, Bank Transfer, and Cash on Delivery (subject to location). Full payment or deposit may be required before order processing.', 'pemu'); ?></p>
                    <p><?php esc_html_e('All prices are in Kenyan Shillings (KES) and include applicable taxes unless stated otherwise. Delivery charges are calculated at checkout.', 'pemu'); ?></p>
                    <p><?php esc_html_e('We reserve the right to cancel any order due to stock unavailability, pricing errors, or suspected fraudulent activity. In such cases, a full refund will be issued.', 'pemu'); ?></p>
                </div>
            </section>

            <!-- Section -->
            <section class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 shadow-sm">
                <h2 class="font-display font-bold text-xl text-slate-800 dark:text-slate-200 mb-3 flex items-center gap-2">
                    <span class="w-1.5 h-6 rounded-full bg-brand-green shrink-0"></span>
                    <?php esc_html_e('4. Shipping & Delivery', 'pemu'); ?>
                </h2>
                <div class="text-slate-500 dark:text-slate-400 text-[15px] leading-relaxed space-y-3">
                    <p><?php esc_html_e('We deliver to all 47 counties in Kenya. Same-day delivery is available within Nairobi and Mombasa for orders placed before 2 PM.', 'pemu'); ?></p>
                    <p><?php esc_html_e('Nationwide delivery typically takes 24–48 hours depending on your location. Delivery times are estimates and not guaranteed.', 'pemu'); ?></p>
                    <p><?php esc_html_e('Delivery charges are calculated based on location and order size. Free delivery may be available on orders above a certain threshold as communicated on our website.', 'pemu'); ?></p>
                    <p><?php esc_html_e('Risk of loss passes to you upon delivery. Please inspect your package upon receipt.', 'pemu'); ?></p>
                </div>
            </section>

            <!-- Section -->
            <section class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 shadow-sm">
                <h2 class="font-display font-bold text-xl text-slate-800 dark:text-slate-200 mb-3 flex items-center gap-2">
                    <span class="w-1.5 h-6 rounded-full bg-brand-green shrink-0"></span>
                    <?php esc_html_e('5. Returns & Refunds', 'pemu'); ?>
                </h2>
                <div class="text-slate-500 dark:text-slate-400 text-[15px] leading-relaxed space-y-3">
                    <p><?php esc_html_e('We accept returns of unopened, unused products within 7 days of delivery. To initiate a return, please contact us via WhatsApp with your order number.', 'pemu'); ?></p>
                    <p><?php esc_html_e('Refunds will be processed within 5–7 business days after we receive and inspect the returned item. Shipping costs are non-refundable.', 'pemu'); ?></p>
                    <p><?php esc_html_e('Due to hygiene and safety regulations, we cannot accept returns on opened or used products unless they are defective or damaged upon arrival.', 'pemu'); ?></p>
                </div>
            </section>

            <!-- Section -->
            <section class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 shadow-sm">
                <h2 class="font-display font-bold text-xl text-slate-800 dark:text-slate-200 mb-3 flex items-center gap-2">
                    <span class="w-1.5 h-6 rounded-full bg-brand-green shrink-0"></span>
                    <?php esc_html_e('6. Privacy & Data Protection', 'pemu'); ?>
                </h2>
                <div class="text-slate-500 dark:text-slate-400 text-[15px] leading-relaxed space-y-3">
                    <p><?php esc_html_e('Your privacy is important to us. Personal information collected during ordering (name, phone, delivery address, email) is used solely for order processing and communication.', 'pemu'); ?></p>
                    <p><?php esc_html_e('We do not sell, share, or distribute your personal information to third parties except as required for delivery (sharing address with our logistics partners) or as required by law.', 'pemu'); ?></p>
                    <p><?php esc_html_e('By using our website, you consent to the collection and use of your information as described in our Privacy Policy.', 'pemu'); ?></p>
                </div>
            </section>

            <!-- Section -->
            <section class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 shadow-sm">
                <h2 class="font-display font-bold text-xl text-slate-800 dark:text-slate-200 mb-3 flex items-center gap-2">
                    <span class="w-1.5 h-6 rounded-full bg-brand-green shrink-0"></span>
                    <?php esc_html_e('7. Limitation of Liability', 'pemu'); ?>
                </h2>
                <div class="text-slate-500 dark:text-slate-400 text-[15px] leading-relaxed space-y-3">
                    <p><?php esc_html_e('Pemu Ventures shall not be liable for any indirect, incidental, special, consequential, or punitive damages arising out of or related to your use of our products or website.', 'pemu'); ?></p>
                    <p><?php esc_html_e('Our total liability for any claim arising from the sale of products shall not exceed the purchase price of the product in question.', 'pemu'); ?></p>
                </div>
            </section>

            <!-- Section -->
            <section class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 shadow-sm">
                <h2 class="font-display font-bold text-xl text-slate-800 dark:text-slate-200 mb-3 flex items-center gap-2">
                    <span class="w-1.5 h-6 rounded-full bg-brand-green shrink-0"></span>
                    <?php esc_html_e('8. Contact Us', 'pemu'); ?>
                </h2>
                <div class="text-slate-500 dark:text-slate-400 text-[15px] leading-relaxed space-y-3">
                    <p><?php esc_html_e('If you have any questions about these Terms & Conditions, please contact us:', 'pemu'); ?></p>
                    <ul class="space-y-2 list-none p-0">
                        <li class="flex items-center gap-2">
                            <span class="text-brand-green font-semibold"><?php esc_html_e('WhatsApp:', 'pemu'); ?></span>
                            <a href="<?php echo esc_url(pemu_whatsapp_url('Hi! I have a question about your terms.')); ?>" target="_blank" rel="noopener noreferrer" class="text-brand-green hover:underline">+254 707 551 484</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-brand-green font-semibold"><?php esc_html_e('Email:', 'pemu'); ?></span>
                            <a href="mailto:<?php echo esc_attr(get_option('pemu_email', 'Pemuherbalsupplements@gmail.com')); ?>" class="text-brand-green hover:underline"><?php echo esc_html(get_option('pemu_email', 'Pemuherbalsupplements@gmail.com')); ?></a>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-brand-green font-semibold"><?php esc_html_e('Location:', 'pemu'); ?></span>
                            <span class="text-slate-500 dark:text-slate-400"><?php echo esc_html(get_option('pemu_address', 'Nairobi, Kenya')); ?></span>
                        </li>
                    </ul>
                </div>
            </section>

        </div>

        <!-- Back to home -->
        <div class="text-center mt-12">
            <a href="<?php echo esc_url(home_url('/')); ?>"
               class="inline-flex items-center gap-2 bg-brand-green hover:bg-brand-green-dark text-white font-bold px-8 py-4 rounded-xl transition-colors shadow-lg shadow-brand-green/30 no-underline">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" stroke-linecap="round" stroke-linejoin="round"/><polyline points="9 22 9 12 15 12 15 22" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <?php esc_html_e('Back to Home', 'pemu'); ?>
            </a>
        </div>

    </div>
</main>

<?php get_footer(); ?>

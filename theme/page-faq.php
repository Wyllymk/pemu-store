<?php
/**
 * Template Name: FAQ Page
 * Pemu Ventures FAQ.
 */
defined('ABSPATH') || exit;
get_header();

$faqs = [
  [
    'q' => 'Do you deliver countrywide?',
    'a' => "Yes! We deliver to all 47 counties in Kenya. We partner with G4S and Wells Fargo courier services for reliable, trackable delivery. Nairobi orders placed before 2 PM are delivered the same day. For the rest of Kenya, expect delivery within 24–48 hours. Remote or hard-to-reach areas may take up to 72 hours. Once your order is dispatched, you'll receive an SMS notification with tracking details so you can follow your package every step of the way."
  ],
  [
    'q' => 'How do I pay for my order?',
    'a' => "We offer several convenient payment options to suit your needs. You can pay via M-Pesa (we support both STK push and Paybill: Business Number provided at checkout). We also accept Bank Transfers to our National Bank Account: 7712845174. For customers in select Nairobi areas, we offer Cash on Delivery — pay when your package arrives. You can also place your order via WhatsApp and we'll walk you through the entire payment process step-by-step."
  ],
  [
    'q' => 'Are your products genuine and authentic?',
    'a' => "Absolutely — authenticity is our top priority. Every product sold by Pemu Ventures is 100% genuine, lab-tested, and sourced directly from certified manufacturers and suppliers. We carry only natural, organic, non-GMO, gluten-free, and vegan products where applicable. Each batch undergoes verification for purity, potency, and safety. We never sell counterfeit or expired products. If you ever have doubts about a product, contact us on WhatsApp and we'll provide full verification details including batch numbers and supplier certificates."
  ],
  [
    'q' => 'How do I place an order via WhatsApp?',
    'a' => "Ordering via WhatsApp is quick and easy. Simply tap the green WhatsApp button on any product page, or send us a direct message on +254 707 551 484. Let us know which product(s) you'd like, your delivery location, and any questions you have. We'll confirm product availability, calculate your total (including delivery), and send you secure payment instructions. Once payment is confirmed, your order is dispatched immediately. Our WhatsApp line is available 24/7."
  ],
  [
    'q' => 'Can I return a product?',
    'a' => "Yes, we have a fair returns policy. You can return any unopened, sealed product within 7 days of delivery for a full refund or exchange. To initiate a return, contact us on WhatsApp with your order number and reason for the return. For opened products, returns are only accepted if there is a verified quality defect — such as damage during shipping or a manufacturing issue. Once we receive and inspect the returned item, we'll process your refund within 3–5 business days."
  ],
  [
    'q' => 'How long does delivery take?',
    'a' => "Delivery times depend on your location. Nairobi: Same-day delivery for orders placed before 2 PM on weekdays. Mombasa, Kisumu, Nakuru & major towns: 24–48 hours. Rural and remote areas: Up to 72 hours. All deliveries are tracked and you'll receive an SMS notification as soon as your order is dispatched. For urgent orders, contact us on WhatsApp and we'll do our best to expedite your delivery."
  ],
  [
    'q' => 'What is your WhatsApp number?',
    'a' => "Our official WhatsApp number is +254 707 551 484. We're available around the clock — 24 hours a day, 7 days a week. Whether you want to place an order, ask about a product, track a delivery, or get personalized health supplement recommendations, we're here to help. You can also reach us by email at Pemuherbalsupplements@gmail.com for non-urgent enquiries."
  ],
  [
    'q' => 'Are your products safe to use?',
    'a' => "Yes, all Pemu Ventures products are formulated with safety as a priority. Our range is all-natural, non-GMO, organic, gluten-free, and vegan where applicable. Every product is sourced from reputable manufacturers who adhere to strict quality control standards. That said, we always recommend consulting your doctor or healthcare provider before starting any new supplement — especially if you are pregnant, breastfeeding, taking prescription medication, or managing a chronic health condition."
  ],
  [
    'q' => 'Do you have a physical store?',
    'a' => "Yes! While most of our customers shop online for convenience, we also have a physical presence in Nairobi where you can browse and purchase products in person. Contact us on WhatsApp at +254 707 551 484 for our current store address and opening hours. Walk-in customers enjoy the same competitive pricing and product range available on our website."
  ],
  [
    'q' => 'How do I track my order?',
    'a' => "Tracking your order is simple. Once your order is dispatched, you'll receive an SMS with your tracking details and courier information. You can also message us anytime on WhatsApp with your order number, and we'll provide you with a real-time status update including estimated delivery time. For online orders placed through our website, you can also check your order status by logging into your account and visiting the \"My Orders\" section."
  ],
];
?>
<main id="main-content" class="min-h-screen bg-gray-100 dark:bg-slate-800 relative overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40rem] h-[40rem] bg-brand-green/10 rounded-full blur-[100px]">
        </div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40rem] h-[40rem] bg-brand-navy/10 rounded-full blur-[100px]">
        </div>
    </div>

    <div class="relative z-10">
        <div class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 relative overflow-hidden">
            <div class="max-w-4xl mx-auto px-4 py-16 text-center">
                <p class="text-xs font-bold tracking-widest uppercase text-brand-green mb-3">Help Center</p>
                <h1 class="font-display font-extrabold text-4xl lg:text-5xl text-slate-800 dark:text-slate-200 tracking-tight">
                    Frequently Asked Questions
                </h1>
                <p class="mt-4 text-lg text-slate-500 dark:text-slate-400 max-w-xl mx-auto leading-relaxed">
                    Everything you need to know about Pemu Ventures — from ordering and payment to delivery and returns.
                </p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                    <a href="<?php echo esc_url(pemu_whatsapp_url("Hi Pemu Ventures! 👋 I have a question.")); ?>"
                        target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold px-7 py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-green-500/30 hover:-translate-y-0.5 text-base">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        Can't find your answer? Chat with us
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 py-16">
            <div class="space-y-4" x-data="{open: 0}">
                <?php foreach ($faqs as $i => $faq): ?>
                <div
                    class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden hover:border-brand-green/40 transition-colors shadow-sm">
                    <button type="button" @click="open = open === <?php echo $i; ?> ? null : <?php echo $i; ?>"
                        :aria-expanded="open === <?php echo $i; ?>"
                        class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left hover:bg-gray-100 dark:hover:bg-[#1c2b38] transition-colors"
                        aria-controls="faq-<?php echo $i; ?>">
                        <span
                            class="font-semibold text-slate-800 dark:text-slate-200 text-base"><?php echo esc_html($faq['q']); ?></span>
                        <span
                            class="shrink-0 w-8 h-8 rounded-full bg-brand-green/10 flex items-center justify-center text-brand-green transition-transform duration-300"
                            :class="open === <?php echo $i; ?> ? 'rotate-180 bg-brand-green text-white shadow-md' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </button>
                    <div id="faq-<?php echo $i; ?>" x-show="open === <?php echo $i; ?>" x-collapse
                        class="px-6 pb-6 text-slate-500 dark:text-slate-400 text-[15px] leading-relaxed">
                        <div class="pt-3 border-t border-slate-200 dark:border-slate-700">
                            <?php echo esc_html($faq['a']); ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div
                class="mt-16 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-10 text-center shadow-lg relative overflow-hidden">
                <div
                    class="absolute -top-20 -right-20 w-40 h-40 bg-brand-green/10 rounded-full blur-2xl pointer-events-none">
                </div>
                <h2 class="font-display font-bold text-3xl text-slate-800 dark:text-slate-200 mb-3 relative z-10 tracking-tight">
                    Still have questions?</h2>
                <p class="text-slate-500 dark:text-slate-400 mb-8 relative z-10 text-lg">Our team is available 24/7 on
                    WhatsApp to help you.</p>
                <div class="flex flex-wrap gap-4 justify-center relative z-10">
                    <a href="<?php echo esc_url(pemu_whatsapp_url("Hi Pemu Ventures! I have a question.")); ?>"
                        target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold px-8 py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-green-500/30 hover:-translate-y-0.5 text-base">
                        WhatsApp: +254 707 551 484
                    </a>
                    <a href="mailto:Pemuherbalsupplements@gmail.com"
                        class="inline-flex items-center gap-2 bg-gray-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 font-bold px-8 py-3.5 rounded-xl transition-all duration-300 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md hover:-translate-y-0.5 hover:border-brand-green hover:text-brand-green text-base">
                        📧 Email Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>

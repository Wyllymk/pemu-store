<?php
/**
 * Template Name: Privacy Policy Page
 */
defined('ABSPATH') || exit;
get_header();
?>
<main id="main-content" class="min-h-screen bg-gray-100 dark:bg-slate-800 relative overflow-hidden">
  
  <!-- Premium background decorations -->
  <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
      <div class="absolute top-[-10%] left-[-10%] w-[40rem] h-[40rem] bg-brand-green/10 rounded-full blur-[100px]"></div>
      <div class="absolute bottom-[-10%] right-[-10%] w-[40rem] h-[40rem] bg-brand-navy/10 rounded-full blur-[100px]"></div>
  </div>

  <div class="relative z-10">
      <!-- Header -->
      <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl border-b border-slate-200 dark:border-slate-700 relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 py-16 text-center">
          <p class="text-xs font-bold tracking-widest uppercase text-brand-green mb-3">Legal</p>
          <h1 class="font-display font-extrabold text-4xl lg:text-5xl text-slate-800 dark:text-slate-200 tracking-tight">
            <?php the_title(); ?>
          </h1>
          <p class="mt-4 text-lg text-slate-500 dark:text-slate-400 max-w-xl mx-auto leading-relaxed">
            How we protect and handle your information at Pemu Ventures.
          </p>
        </div>
      </div>

      <!-- Content -->
      <div class="max-w-4xl mx-auto px-4 py-16">
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl border border-slate-200 dark:border-slate-700 rounded-3xl p-8 lg:p-12 shadow-xl shadow-black/5">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="max-w-none text-slate-500 dark:text-slate-400 leading-relaxed [&_h2]:font-display [&_h2]:font-bold [&_h2]:text-2xl [&_h2]:text-[#1a1a2e] [&_h2]:dark:text-[#e8edf2] [&_h2]:mt-8 [&_h2]:mb-4 [&_h3]:font-display [&_h3]:font-bold [&_h3]:text-xl [&_h3]:text-[#1a1a2e] [&_h3]:dark:text-[#e8edf2] [&_h3]:mt-6 [&_h3]:mb-3 [&_p]:mb-5 [&_ul]:list-disc [&_ul]:pl-5 [&_ul]:mb-5 [&_li]:mb-1 [&_a]:text-brand-green [&_a]:underline">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; else: ?>
                <div class="max-w-none text-slate-500 dark:text-slate-400 leading-relaxed [&_h2]:font-display [&_h2]:font-bold [&_h2]:text-2xl [&_h2]:text-[#1a1a2e] [&_h2]:dark:text-[#e8edf2] [&_h2]:mt-8 [&_h2]:mb-4 [&_h3]:font-display [&_h3]:font-bold [&_h3]:text-xl [&_h3]:text-[#1a1a2e] [&_h3]:dark:text-[#e8edf2] [&_h3]:mt-6 [&_h3]:mb-3 [&_p]:mb-5 [&_ul]:list-disc [&_ul]:pl-5 [&_ul]:mb-5 [&_li]:mb-1 [&_a]:text-brand-green [&_a]:underline">
                    <h2 class="mt-0">Privacy Policy</h2>
                    <p>At Pemu Ventures, we are committed to protecting your privacy. We use the information we collect on the site to make shopping at Pemu Ventures as simple as possible and to enhance your overall shopping experience.</p>
                    
                    <h3>Information We Collect</h3>
                    <p>We may collect personal information such as your name, email address, physical address, and phone number when you place an order, create an account, or communicate with us.</p>

                    <h3>How We Use Your Information</h3>
                    <ul>
                        <li>To process and fulfill your orders, including sending emails to confirm your order status and shipment.</li>
                        <li>To communicate with you and to send you information by email, postal mail, telephone, text message, or other means about our products, services, contests, and promotions.</li>
                        <li>To help us learn more about your shopping preferences and to enhance your shopping experience.</li>
                    </ul>

                    <h3>Security</h3>
                    <p>We take reasonable precautions to protect your personal information from unauthorized access, loss, or misuse.</p>
                </div>
            <?php endif; ?>
        </div>
      </div>
  </div>
</main>
<?php get_footer(); ?>

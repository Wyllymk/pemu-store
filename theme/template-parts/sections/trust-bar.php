<?php
/**
 * Trust bar — updated for Pemu Ventures (no free delivery)
 */
defined('ABSPATH') || exit;
$items = [
  ['icon'=>'🚚','title'=>'Countrywide Delivery', 'sub'=>'We deliver across Kenya'],
  ['icon'=>'✅','title'=>'100% Authentic',        'sub'=>'Lab-tested, certified products'],
  ['icon'=>'📦','title'=>'Discreet Packaging',    'sub'=>'No branding on outside'],
  ['icon'=>'💬','title'=>'24/7 WhatsApp Support', 'sub'=>'Chat with us anytime'],
];
?>
<section class="border-y border-slate-200 dark:border-[#2a3f52] bg-gray-100 dark:bg-[#1c2b38]">
  <div class="max-w-7xl mx-auto px-4 py-6">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
      <?php foreach ($items as $item): ?>
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-brand-green/10 flex items-center justify-center shrink-0 text-xl"><?php echo esc_html( $item['icon'] ); ?></div>
        <div>
          <p class="font-bold text-sm text-[#1a1a2e] dark:text-[#e8edf2] leading-tight"><?php echo esc_html($item['title']); ?></p>
          <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5"><?php echo esc_html($item['sub']); ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

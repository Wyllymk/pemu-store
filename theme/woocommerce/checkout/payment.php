<?php
/**
 * WooCommerce checkout/payment.php — Pemu override
 * @version 9.8.0
 */
defined('ABSPATH') || exit;
if (!WC()->cart->needs_payment()): ?>
  <div class="woocommerce-checkout-payment">
    <div id="payment">
      <?php do_action('woocommerce_review_order_before_submit'); ?>
      <?php echo apply_filters('woocommerce_order_button_html', '<button type="submit" class="w-full bg-brand-green hover:bg-brand-green-dark text-white font-bold py-4 rounded-xl shadow-md shadow-brand-green/30 transition-colors text-base" id="place_order" value="'.esc_attr(apply_filters('woocommerce_order_button_text',__('Place order','woocommerce'))).'" data-value="'.esc_attr(apply_filters('woocommerce_order_button_text',__('Place order','woocommerce'))).'">'.esc_html(apply_filters('woocommerce_order_button_text',__('Place order','woocommerce'))).'</button>'); // phpcs:ignore ?>
      <?php do_action('woocommerce_review_order_after_submit'); ?>
      <?php wp_nonce_field('woocommerce-process_checkout','woocommerce-process-checkout-nonce'); ?>
    </div>
  </div>
<?php return; endif; ?>

<div class="woocommerce-checkout-payment" id="payment">

  <?php if (WC()->cart->needs_payment()): ?>
  <ul class="wc_payment_methods payment_methods methods space-y-3 list-none p-0 m-0">
    <?php if (!empty($available_gateways)): ?>
    <?php foreach ($available_gateways as $gateway): ?>

    <li class="wc_payment_method payment_method_<?php echo esc_attr($gateway->id); ?>">
      <!-- Radio row -->
      <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-150 <?php echo $gateway->chosen ? 'border-brand-green bg-brand-green/5' : 'border-slate-200 dark:border-slate-700 hover:border-brand-green/50'; ?>"
             for="payment_method_<?php echo esc_attr($gateway->id); ?>">
        <input id="payment_method_<?php echo esc_attr($gateway->id); ?>"
               type="radio"
               class="shrink-0 w-4 h-4 text-brand-green border-slate-200 dark:border-slate-700 focus:ring-brand-green focus:ring-offset-0 accent-brand-green"
               name="payment_method"
               value="<?php echo esc_attr($gateway->id); ?>"
               <?php checked($gateway->chosen, true); ?>
               data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>">
        <span class="flex-1 font-semibold text-sm text-slate-800 dark:text-slate-200">
          <?php echo wp_kses_post($gateway->get_title()); ?>
        </span>
        <?php if ($gateway->get_icon()): ?>
        <span class="shrink-0"><?php echo $gateway->get_icon(); // phpcs:ignore ?></span>
        <?php endif; ?>
      </label>

      <!-- Payment box -->
      <div class="payment_box payment_method_<?php echo esc_attr($gateway->id); ?> <?php echo $gateway->chosen ? '' : 'hidden'; ?> mt-2 p-4 bg-gray-100 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
        <?php $gateway->payment_fields(); ?>
      </div>
    </li>

    <?php endforeach; ?>
    <?php else: ?>
    <li class="p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 text-sm text-amber-800 dark:text-amber-200">
      <?php echo wp_kses_post(apply_filters('woocommerce_no_available_payment_methods_message',
        is_user_logged_in()
          ? __('Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.','woocommerce')
          : __('Please fill in your details above to see available payment methods.','woocommerce')
      )); ?>
    </li>
    <?php endif; ?>
  </ul>
  <?php endif; ?>

  <div class="form-row place-order mt-5">
    <?php do_action('woocommerce_review_order_before_submit'); ?>

    <?php
    $order_btn_text = apply_filters('woocommerce_order_button_text', __('Place order','woocommerce'));
    echo apply_filters('woocommerce_order_button_html', // phpcs:ignore
      '<button type="submit" class="w-full bg-brand-green hover:bg-brand-green-dark text-white font-bold py-4 rounded-xl shadow-md shadow-brand-green/30 transition-colors text-base flex items-center justify-center gap-2" id="place_order" value="'.esc_attr($order_btn_text).'" data-value="'.esc_attr($order_btn_text).'">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12l5 5L20 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
        '.esc_html($order_btn_text).'
      </button>'
    );
    ?>

    <?php do_action('woocommerce_review_order_after_submit'); ?>
    <?php wp_nonce_field('woocommerce-process_checkout','woocommerce-process-checkout-nonce'); ?>

    <?php if (function_exists('pemu_cart_whatsapp_message')): ?>
    <a href="<?php echo esc_url(pemu_whatsapp_url(pemu_cart_whatsapp_message())); ?>"
       target="_blank" rel="noopener noreferrer"
       class="mt-3 flex items-center justify-center gap-2 w-full py-3 rounded-xl border-2 border-green-500 text-green-500 font-semibold text-sm hover:bg-green-500 hover:text-white transition-all duration-200">
      <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
      Or order via WhatsApp
    </a>
    <?php endif; ?>
  </div>
</div>

<script>
// Show/hide payment box on selection
document.addEventListener('change', function(e) {
  if (!e.target.matches('.wc_payment_methods input[type="radio"]')) return;
  document.querySelectorAll('.payment_box').forEach(function(box) {
    box.classList.add('hidden');
  });
  const box = document.querySelector('.payment_method_' + e.target.value + ' .payment_box');
  if (box) box.classList.remove('hidden');
  document.querySelectorAll('.wc_payment_method label').forEach(function(label) {
    label.classList.remove('border-brand-green','bg-brand-green/5');
    label.classList.add('border-slate-200','dark:border-slate-700');
  });
  const parentLi = e.target.closest('.wc_payment_method');
  if (parentLi) {
    const lbl = parentLi.querySelector('label');
    if (lbl) { lbl.classList.remove('border-slate-200','dark:border-slate-700'); lbl.classList.add('border-brand-green','bg-brand-green/5'); }
  }
});
</script>

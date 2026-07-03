<?php
/**
 * WooCommerce cart/cart.php — Pemu override
 * ALL WC hooks preserved.
 * @version 10.1.0
 */
defined('ABSPATH') || exit;
get_header();
?>
<main id="main-content" class="min-h-screen bg-gray-100 dark:bg-slate-800">
<div class="max-w-6xl mx-auto px-4 py-8">

  <h1 class="font-display font-extrabold text-3xl text-slate-800 dark:text-slate-200 mb-8">
    <?php esc_html_e('Your Cart','woocommerce'); ?>
    <?php if (!WC()->cart->is_empty()): ?>
    <span class="text-lg font-normal text-slate-500 dark:text-slate-400 ml-2">(<?php echo WC()->cart->get_cart_contents_count(); ?> items)</span>
    <?php endif; ?>
  </h1>

  <?php do_action('woocommerce_before_cart'); ?>

  <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
  <?php do_action('woocommerce_before_cart_table'); ?>

  <?php if (!WC()->cart->is_empty()): ?>

  <div class="grid lg:grid-cols-[1fr_360px] gap-6 items-start">

    <!-- CART ITEMS -->
    <div class="space-y-4">
      <?php do_action('woocommerce_before_cart_contents'); ?>

      <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
        $_product  = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
        if (!$_product || !$_product->exists() || 0 >= $cart_item['quantity']) continue;

        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
        $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_thumbnail'), $cart_item, $cart_item_key);
        $product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
        $product_subtotal  = apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
        $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
        $row_class         = apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key);
      ?>

      <div class="<?php echo esc_attr($row_class); ?> bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 sm:p-5 flex gap-4 transition-all duration-200 hover:border-brand-green/30">

        <!-- Thumbnail -->
        <div class="w-20 h-20 sm:w-24 sm:h-24 shrink-0 rounded-xl overflow-hidden bg-gradient-to-br from-gray-100 dark:from-slate-800 to-white dark:to-slate-900 flex items-center justify-center">
          <?php if ($product_permalink): ?>
          <a href="<?php echo esc_url($product_permalink); ?>" class="block w-full h-full">
            <?php echo $thumbnail; // phpcs:ignore ?>
          </a>
          <?php else: echo $thumbnail; // phpcs:ignore ?>
          <?php endif; ?>
        </div>

        <!-- Details -->
        <div class="flex-1 min-w-0">
          <div class="flex items-start justify-between gap-3">
            <div class="min-w-0 flex-1">
              <?php if ($product_permalink): ?>
              <a href="<?php echo esc_url($product_permalink); ?>"
                 class="font-semibold text-sm text-slate-800 dark:text-slate-200 hover:text-brand-green transition-colors leading-snug block line-clamp-2">
                <?php echo wp_kses_post($product_name); ?>
              </a>
              <?php else: ?>
              <span class="font-semibold text-sm text-slate-800 dark:text-slate-200 leading-snug block"><?php echo wp_kses_post($product_name); ?></span>
              <?php endif; ?>

              <?php echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore ?>

              <?php if ($_product->get_sku()): ?>
              <span class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 block">SKU: <?php echo esc_html($_product->get_sku()); ?></span>
              <?php endif; ?>
            </div>

            <?php
            $remove_url = apply_filters('woocommerce_cart_item_remove_link',
              esc_url(wc_get_cart_remove_url($cart_item_key)), $cart_item_key);
            ?>
            <a href="<?php echo $remove_url; // phpcs:ignore ?>"
               class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-red-500 hover:bg-red-500/10 transition-colors border border-slate-200 dark:border-slate-700 hover:border-red-200"
               aria-label="Remove <?php echo esc_attr($product_name); ?> from cart"
               data-product_id="<?php echo esc_attr($product_id); ?>"
               data-cart_item_key="<?php echo esc_attr($cart_item_key); ?>"
               data-product_sku="<?php echo esc_attr($_product->get_sku()); ?>">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12" stroke-linecap="round"/></svg>
            </a>
          </div>

          <!-- Bottom row: qty + price -->
          <div class="flex items-end justify-between mt-3 gap-3 flex-wrap">
            <div class="quantity inline-flex items-center border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden bg-gray-100 dark:bg-slate-800">
              <button type="button" class="w-9 h-10 flex items-center justify-center shrink-0 bg-none border-none text-base font-bold text-slate-500 dark:text-slate-400 cursor-pointer transition-colors hover:text-brand-green hover:bg-white dark:hover:bg-slate-800 leading-none pemu-qty-btn minus" data-action="minus" aria-label="Decrease quantity">−</button>
              <input type="number"
                     class="input-text qty text w-11 text-center border-none border-x border-slate-200 dark:border-slate-700 bg-none p-2 text-sm font-bold text-slate-800 dark:text-slate-200 [-moz-appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none focus:bg-white dark:focus:bg-slate-800 outline-none"
                     name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]"
                     value="<?php echo esc_attr($cart_item['quantity']); ?>"
                     min="0"
                     step="<?php echo esc_attr($_product->get_min_purchase_quantity()); ?>"
                     max="<?php echo esc_attr(0 < $_product->get_max_purchase_quantity() ? $_product->get_max_purchase_quantity() : ''); ?>"
                     inputmode="numeric"
                     autocomplete="off"
                     aria-label="Quantity of <?php echo esc_attr($product_name); ?>">
              <button type="button" class="w-9 h-10 flex items-center justify-center shrink-0 bg-none border-none text-base font-bold text-slate-500 dark:text-slate-400 cursor-pointer transition-colors hover:text-brand-green hover:bg-white dark:hover:bg-slate-800 leading-none pemu-qty-btn plus" data-action="plus" aria-label="Increase quantity">+</button>
            </div>

            <div class="text-right">
              <p class="text-[10px] text-slate-500 dark:text-slate-400"><?php echo wp_kses_post($product_price); ?> each</p>
              <p class="font-display font-bold text-brand-green text-base"><?php echo $product_subtotal; // phpcs:ignore ?></p>
            </div>
          </div>
        </div>
      </div>

      <?php endforeach; ?>

      <?php do_action('woocommerce_cart_contents'); ?>

      <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-5"
           x-data="{couponOpen: false}">
        <div class="flex flex-wrap gap-3 items-start">
          <div class="flex-1 min-w-0">
            <button type="button" @click="couponOpen=!couponOpen"
                    class="flex items-center gap-2 text-sm font-semibold text-brand-green hover:text-brand-green-dark transition-colors">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" stroke-linecap="round" stroke-linejoin="round"/></svg>
              <span x-text="couponOpen ? 'Hide coupon code' : 'Have a coupon code?'"></span>
            </button>
            <div x-show="couponOpen" x-cloak x-transition
                 class="mt-3 flex gap-2">
              <div class="coupon flex gap-2 flex-1">
                <input type="text"
                       name="coupon_code"
                       id="coupon_code"
                       class="flex-1 px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-green placeholder-slate-500 dark:placeholder-slate-400"
                       placeholder="Enter coupon code"
                       value="">
                <button type="submit" name="apply_coupon" value="Apply coupon"
                        class="px-5 py-2.5 bg-brand-navy hover:bg-brand-navy/90 text-white font-bold rounded-xl text-sm transition-colors whitespace-nowrap">
                  Apply
                </button>
              </div>
            </div>
          </div>

          <button type="submit" name="update_cart" value="Update cart"
                  class="flex items-center gap-2 px-5 py-2.5 rounded-xl border-2 border-slate-200 dark:border-slate-700 hover:border-brand-green text-slate-800 dark:text-slate-200 font-semibold text-sm transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
                  disabled>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M23 4v6h-6M1 20v-6h6M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Update Cart
          </button>
        </div>
      </div>

      <?php do_action('woocommerce_cart_coupon'); ?>
      <?php do_action('woocommerce_cart_actions'); ?>
      <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
    </div>

    <!-- CART TOTALS -->
    <div class="lg:sticky lg:top-24">
      <?php do_action('woocommerce_cart_collaterals'); ?>
    </div>

  </div>

  <?php else: ?>
  <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-12 text-center">
    <div class="w-20 h-20 rounded-full bg-gray-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-5">
      <svg class="w-9 h-9 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 3h2l2.5 12.5a2 2 0 002 1.5h9a2 2 0 002-1.5L22 7H6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="20" r="1.5" fill="currentColor" stroke="none"/><circle cx="18" cy="20" r="1.5" fill="currentColor" stroke="none"/></svg>
    </div>
    <p class="font-display font-bold text-xl text-slate-800 dark:text-slate-200 mb-2"><?php esc_html_e('Your cart is empty','woocommerce'); ?></p>
    <p class="text-slate-500 dark:text-slate-400 text-sm mb-7">Looks like you haven't added any products yet.</p>
    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
       class="inline-flex items-center gap-2 bg-brand-green hover:bg-brand-green-dark text-white font-bold px-7 py-3.5 rounded-xl transition-colors">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9h18l-2 11H5zM8 9V6a4 4 0 118 0v3" stroke-linecap="round" stroke-linejoin="round"/></svg>
      <?php esc_html_e('Browse Products','pemu'); ?>
    </a>
  </div>
  <?php endif; ?>

  <?php do_action('woocommerce_after_cart_table'); ?>
  </form>

  <?php do_action('woocommerce_after_cart'); ?>
</div>
</main>
<?php get_footer(); ?>

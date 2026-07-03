<?php
/**
 * WooCommerce content-product.php — Pemu override
 * @version 9.4.0
 */
defined('ABSPATH') || exit;
global $product;
if (!$product instanceof WC_Product) return;

setup_postdata(get_post());

$permalink    = $product->get_permalink();
$name         = $product->get_name();
$in_stock     = $product->is_in_stock();
$on_sale      = $product->is_on_sale();
$is_featured  = $product->is_featured();
$avg_rating   = (float)$product->get_average_rating();
$review_count = (int)$product->get_review_count();
$reg_price    = (float)$product->get_regular_price();
$sale_price   = (float)$product->get_sale_price();
$img_id       = $product->get_image_id();
$is_new       = $product->get_date_created() && (time() - $product->get_date_created()->getTimestamp()) < 30*DAY_IN_SECONDS;

// Badge
$badge = $badge_cls = '';
if (!$in_stock) { $badge='Sold Out'; $badge_cls='bg-slate-500 dark:bg-slate-400'; }
elseif ($is_featured) { $badge='BESTSELLER'; $badge_cls='bg-brand-green'; }
elseif ($on_sale && $reg_price>0 && $sale_price>0) { $badge='-'.round((($reg_price-$sale_price)/$reg_price)*100).'%'; $badge_cls='bg-red-500'; }
elseif ($is_new) { $badge='NEW'; $badge_cls='bg-brand-navy'; }

$wa_url  = pemu_whatsapp_url("Hi Pemu Ventures! 👋 I'd like to order: *{$name}*\\n{$permalink}");
$img_html = $img_id
  ? wp_get_attachment_image($img_id,'pemu-product-card',false,['class'=>'w-full h-full object-contain transition-transform duration-500 group-hover:scale-105','loading'=>'lazy','alt'=>esc_attr($name)])
  : '<span class="text-6xl select-none" aria-hidden="true">🌿</span>';
?>

<li
    <?php wc_product_class('group relative bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden hover:shadow-xl hover:shadow-black/8 hover:-translate-y-1 transition-all duration-300 flex flex-col list-none p-0',$product); ?>>

    <?php do_action('woocommerce_before_shop_loop_item'); ?>

    <!-- IMAGE -->
    <a href="<?php echo esc_url($permalink); ?>"
        class="block relative aspect-square overflow-hidden flex items-center justify-center bg-gradient-to-br from-gray-100 dark:from-slate-800 to-white dark:to-slate-900"
        tabindex="-1" aria-hidden="true">
        <div class="w-full h-full flex items-center justify-center p-4">
            <?php echo $img_html; // phpcs:ignore ?>
        </div>
        <?php if (!$in_stock): ?>
        <div class="absolute inset-0 bg-white/60 dark:bg-black/50 flex items-center justify-center">
            <span
                class="text-xs font-bold text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-800 px-3 py-1 rounded-full border border-slate-200 dark:border-slate-700">Out
                of Stock</span>
        </div>
        <?php endif; ?>
    </a>

    <!-- Badge -->
    <?php if ($badge): ?>
    <span
        class="absolute top-2.5 left-2.5 z-10 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold text-white tracking-wide <?php echo esc_attr($badge_cls); ?>">
        <?php echo esc_html($badge); ?>
    </span>
    <?php endif; ?>

    <!-- WhatsApp quick-order on hover -->
    <?php if ($in_stock): ?>
    <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener noreferrer"
        class="absolute top-2.5 right-2.5 z-10 w-8 h-8 rounded-full bg-green-500 hover:bg-green-600 dark:hover:bg-green-400 text-white! flex items-center justify-center shadow-md hover:shadow-lg hover:scale-110 opacity-0 group-hover:opacity-100 translate-y-1 group-hover:translate-y-0 transition-all duration-200"
        aria-label="Order <?php echo esc_attr($name); ?> via WhatsApp">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
        </svg>
    </a>
    <?php endif; ?>

    <!-- CARD BODY -->
    <div class="flex flex-col flex-1 p-4 gap-2">

        <a href="<?php echo esc_url($permalink); ?>"
            class="font-semibold text-sm leading-snug line-clamp-2 text-slate-800 dark:text-slate-200 hover:text-brand-green transition-colors">
            <?php echo esc_html($name); ?>
        </a>

        <?php do_action('woocommerce_after_shop_loop_item_title'); ?>

        <!-- PRICE -->
        <div class="price-wrap mt-auto">
            <div class="font-display font-bold text-brand-green text-base">
                <?php echo wp_kses_post($product->get_price_html()); ?>
            </div>
        </div>

        <!-- ATC row -->
        <div class="flex items-center justify-between gap-2 pt-1">
            <div></div><!-- spacer -->
            <?php if ($in_stock): ?>
            <?php
      if ($product->is_type('simple')):
      ?>
            <a href="<?php echo esc_url(add_query_arg(['add-to-cart'=>$product->get_id(),'quantity'=>1],wc_get_cart_url())); ?>"
                data-product_id="<?php echo esc_attr($product->get_id()); ?>"
                data-product_sku="<?php echo esc_attr($product->get_sku()); ?>"
                data-quantity="1"
                aria-label="Add <?php echo esc_attr($name); ?> to cart" rel="nofollow"
                class="add_to_cart_button ajax_add_to_cart product_type_simple shrink-0 w-9 h-9 rounded-full bg-brand-green hover:bg-brand-green-dark text-white flex items-center justify-center transition-all duration-200 shadow-md shadow-brand-green/30 hover:shadow-lg hover:shadow-brand-green/40 hover:scale-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-green focus-visible:ring-offset-2">
                <svg class="w-4 h-4" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" stroke-linecap="round"></path>
                </svg>
            </a>
            <?php else: ?>
            <a href="<?php echo esc_url($permalink); ?>" aria-label="View <?php echo esc_attr($name); ?>"
                class="shrink-0 w-9 h-9 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-brand-green hover:text-white flex items-center justify-center transition-all duration-200 shadow-sm hover:shadow-md hover:shadow-brand-green/30 hover:scale-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-green focus-visible:ring-offset-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M9 18l6-6-6-6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
            <?php endif; ?>
            <?php endif; ?>
        </div>

    </div>

    <?php do_action('woocommerce_after_shop_loop_item'); ?>
</li>

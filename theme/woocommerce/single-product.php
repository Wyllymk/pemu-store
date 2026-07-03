<?php
/**
 * WooCommerce single-product.php — Pemu override
 * Fixed: single breadcrumb only (from manual call in max-w container)
 * @version 1.6.4
 */
defined('ABSPATH') || exit;
get_header();
global $product;
if (!$product instanceof WC_Product) $product = wc_get_product(get_the_ID());
?>
<main id="main-content" class="min-h-screen">
<?php while (have_posts()): the_post(); ?>
<?php do_action('woocommerce_before_single_product'); ?>

<article id="product-<?php the_ID(); ?>" <?php wc_product_class('pemu-single-product', $product); ?>>

  <!-- Breadcrumb — single, styled -->
  <div class="bg-gray-50/50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 py-3 sm:py-4">
      <?php woocommerce_breadcrumb(); ?>
    </div>
  </div>

  <!-- WooCommerce notices — shown BELOW breadcrumb -->
  <?php do_action('woocommerce_output_all_notices'); ?>

  <!-- Product hero -->
  <div class="max-w-7xl mx-auto px-4 py-8 lg:py-12">
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-black/20 border border-slate-100 dark:border-slate-700 overflow-hidden" id="product-options">
      <div class="grid lg:grid-cols-[1.1fr_1fr] divide-y lg:divide-y-0 lg:divide-x divide-slate-100 dark:divide-slate-700">
        
        <!-- Gallery column -->
        <div class="product-gallery p-6 lg:p-10 bg-gray-50/30 dark:bg-slate-900/20">
          <?php do_action('woocommerce_before_single_product_summary'); ?>
        </div>

        <!-- Summary column -->
        <div class="product-summary p-6 lg:p-10 space-y-6 lg:space-y-8 flex flex-col justify-center" id="product-summary">
          <?php do_action('woocommerce_single_product_summary'); ?>
          <div class="pt-6 mt-6 border-t border-slate-100 dark:border-slate-700">
            <?php get_template_part('template-parts/components/trust-badges', null, ['compact'=>false]); ?>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Tabs + Related -->
  <div class="max-w-7xl mx-auto px-4 pb-20">
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-lg shadow-slate-200/40 dark:shadow-black/20 border border-slate-100 dark:border-slate-700 p-6 lg:p-10">
      <?php do_action('woocommerce_after_single_product_summary'); ?>
    </div>
  </div>

  <?php do_action('woocommerce_after_single_product'); ?>
</article>
<?php endwhile; ?>

<?php
if ($product instanceof WC_Product) {
  get_template_part('template-parts/components/sticky-atc', null, ['product'=>$product]);
}
?>
</main>
<?php get_footer(); ?>

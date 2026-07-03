<?php
/**
 * WooCommerce single-product/related.php — Pemu override
 * @version 10.3.0
 */
defined('ABSPATH') || exit;

if (empty($related_products)) return;
?>
<section class="related products mt-12 pt-10 border-t border-slate-100 dark:border-slate-700">

    <div class="flex items-center gap-3 mb-6">
        <div class="w-1 h-6 rounded-full bg-brand-green shrink-0"></div>
        <h2 class="font-display font-extrabold text-xl text-slate-900 dark:text-white tracking-tight">
            <?php esc_html_e('You might also like', 'pemu'); ?>
        </h2>
    </div>

    <ul class="products grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 list-none p-0 m-0">
        <?php foreach ($related_products as $related_product):
            $post_object = get_post($related_product->get_id());
            setup_postdata($GLOBALS['post'] = $post_object);
            wc_get_template_part('content', 'product');
        endforeach; ?>
    </ul>

    <?php wp_reset_postdata(); ?>

</section>

<?php
/**
 * Pemu Health — inc/woocommerce.php  (v2 – comprehensive fix)
 */
defined( 'ABSPATH' ) || exit;

/* 1. WRAPPERS */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', function(){ echo '<main id="main-content" class="pemu-wc-main min-h-screen">'; }, 10 );
add_action( 'woocommerce_after_main_content',  function(){ echo '</main>'; }, 10 );

/* 1b. DEQUEUE WC TAB SCRIPT — we use Alpine.js tabs instead of jQuery UI tabs */
add_action( 'wp_enqueue_scripts', function() {
    if ( is_product() ) {
        // wc-single-product handles jQuery tab switching & sticky add-to-cart — we handle both ourselves
        wp_dequeue_script( 'wc-single-product' );
    }
}, 99 );

/* 2. BREADCRUMB – remove from default hook; our templates output it manually */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/* 2b. NOTICES – remove default placement (above breadcrumb on single product);
 * our single-product.php manually calls woocommerce_output_all_notices after breadcrumb */
remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );

/* 3. LOOP SETTINGS */
add_filter( 'loop_shop_columns',  fn() => 4 );
add_filter( 'loop_shop_per_page', fn() => 12 );

/* REMOVE price from default loop hook – content-product.php handles it */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

/* 4. SALE BADGE */
add_filter( 'woocommerce_sale_flash', function( $html, $post, $product ){
    $reg = (float)$product->get_regular_price();
    $sal = (float)$product->get_sale_price();
    $pct = ($reg>0&&$sal>0) ? ' -'.round((($reg-$sal)/$reg)*100).'%' : '';
    return '<span class="inline-flex items-center gap-0.5 bg-red-500 text-white text-[10px] font-black tracking-wide px-2.5 py-1 rounded-full shadow-sm shadow-red-500/30 uppercase">SALE'.esc_html($pct).'</span>';
}, 10, 3 );

/* 5. CART FRAGMENTS */
add_filter( 'woocommerce_add_to_cart_fragments', 'pemu_cart_fragments' );
function pemu_cart_fragments( array $fragments ): array {
    $count = WC()->cart->get_cart_contents_count();
    // NOTE: Do NOT add a .pemu-cart-count fragment here.
    // The cart badge is fully managed by Alpine.js ($store.cart.count).
    // Returning it as a WC fragment causes WooCommerce's jQuery to swap the
    // DOM node, destroying Alpine's x-data binding and overriding CSS positioning.
    // Instead, we pass the count via a hidden data element that pemuApplyFragments reads.
    $fragments['span[data-pemu-cart-count]'] = '<span data-pemu-cart-count="' . esc_attr( $count ) . '" style="display:none;" aria-hidden="true"></span>';
    ob_start();
    echo '<div class="pemu-mini-cart-inner">';
    woocommerce_mini_cart();
    echo '</div>';
    $fragments['.pemu-mini-cart-inner'] = ob_get_clean();
    return $fragments;
}


/* 6. BREADCRUMB STYLING */
add_filter( 'woocommerce_breadcrumb_defaults', function( array $d ): array {
    $d['delimiter']   = '<span class="mx-2 text-slate-500 dark:text-slate-400 select-none" aria-hidden="true">/</span>';
    $d['wrap_before'] = '<nav aria-label="Breadcrumb" class="pemu-breadcrumb py-3"><ol class="flex flex-wrap items-center gap-1 text-sm text-slate-500 dark:text-slate-400">';
    $d['wrap_after']  = '</ol></nav>';
    $d['before']      = '<li class="breadcrumb-item">';
    $d['after']       = '</li>';
    return $d;
});

/* 7. CHECKOUT FIELDS — Tailwind classes only */
add_filter( 'woocommerce_form_field_args', function( array $args, string $key ): array {
    $args['class']       = ['form-row','mb-4'];
    $args['label_class'] = ['block','text-sm','font-semibold','mb-1.5','text-slate-800','dark:text-slate-200'];
    $args['input_class'] = ['w-full','px-4','py-3','rounded-xl','border','border-slate-200','dark:border-slate-700','bg-gray-50','dark:bg-slate-800','text-sm','text-slate-800','dark:text-slate-200','focus:outline-none','focus:border-brand-green','focus:ring-3','focus:ring-brand-green/15','transition-all','duration-200'];
    return $args;
}, 10, 2 );

add_filter( 'woocommerce_checkout_fields', function( array $fields ): array {
    if ( isset($fields['billing']['billing_phone']) ) {
        $fields['billing']['billing_phone']['placeholder']       = '0707 551 484';
        $fields['billing']['billing_phone']['custom_attributes'] = ['inputmode'=>'tel','autocomplete'=>'tel'];
    }
    if ( isset($fields['billing']['billing_email']) ) {
        $fields['billing']['billing_email']['custom_attributes'] = ['inputmode'=>'email','autocomplete'=>'email'];
    }
    return $fields;
});

/* 8. CHECKOUT: Style order review table + state/country selects */
add_action( 'woocommerce_review_order_before_cart_contents', function() {
	?>
<style>
/* Order review table — styled via Tailwind-compatible CSS */
.woocommerce-checkout-review-order-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}

.woocommerce-checkout-review-order-table thead th {
    padding: 0.75rem 0.5rem;
    text-align: left;
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
    border-bottom: 1px solid #e2e8f0;
}

.dark .woocommerce-checkout-review-order-table thead th {
    color: #94a3b8;
    border-color: #334155;
}

.woocommerce-checkout-review-order-table td {
    padding: 0.75rem 0.5rem;
    border-bottom: 1px solid #f1f5f9;
    color: #1e293b;
    vertical-align: middle;
}

.dark .woocommerce-checkout-review-order-table td {
    color: #e2e8f0;
    border-color: #1e293b;
}

.woocommerce-checkout-review-order-table .product-name {
    font-weight: 600;
}

.woocommerce-checkout-review-order-table .product-total {
    text-align: right;
    font-weight: 700;
}

.woocommerce-checkout-review-order-table .product-quantity {
    font-weight: 500;
    color: #64748b;
}

.dark .woocommerce-checkout-review-order-table .product-quantity {
    color: #94a3b8;
}

/* Cart subtotal, shipping, total rows */
.woocommerce-checkout-review-order-table tr.cart-subtotal td,
.woocommerce-checkout-review-order-table tr.order-total td {
    text-align: right;
    font-weight: 700;
}

.woocommerce-checkout-review-order-table tr.cart-subtotal th,
.woocommerce-checkout-review-order-table tr.order-total th {
    font-weight: 600;
    color: #475569;
}

.dark .woocommerce-checkout-review-order-table tr.cart-subtotal th,
.dark .woocommerce-checkout-review-order-table tr.order-total th {
    color: #94a3b8;
}

.woocommerce-checkout-review-order-table tr.order-total td .amount {
    color: #6DB33F;
    font-size: 1.125rem;
    font-weight: 800;
}

.woocommerce-checkout-review-order-table tr.shipping td {
    text-align: right;
}

.woocommerce-checkout-review-order-table tr.shipping td ul#shipping_method li {
    justify-content: flex-end;
}

/* State / Country select fields */
.select2-container .select2-selection--single {
    height: auto;
    padding: 0.625rem 1rem;
    border-radius: 0.75rem;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    font-size: 0.875rem;
    color: #1e293b;
}

.dark .select2-container .select2-selection--single {
    background: #1e293b;
    border-color: #334155;
    color: #e2e8f0;
}

.select2-container .select2-selection--single .select2-selection__rendered {
    padding: 0;
    line-height: 1.5;
    color: inherit;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 50%;
    transform: translateY(-50%);
    right: 0.75rem;
}

.select2-dropdown {
    border-radius: 0.75rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.dark .select2-dropdown {
    background: #1e293b;
    border-color: #334155;
}

.select2-results__option {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background: #6DB33F !important;
}

/* Fix WooCommerce select2 dark mode on options */
.dark .select2-results__option {
    color: #e2e8f0;
}

.dark .select2-results__option[aria-selected="true"] {
    background: #334155;
}
</style>
<?php
});

/* 9. TRUST BADGES IN CHECKOUT */
add_action( 'woocommerce_review_order_after_payment', function(){
    get_template_part('template-parts/components/trust-badges');
});

/* 9. WHATSAPP BUTTON ON PRODUCT PAGE */
/* Open flex row before qty input */
add_action( 'woocommerce_before_add_to_cart_quantity', function() {
    echo '<div class="pemu-atc-row">';
}, 10 );
/* Close flex row right after ATC button (before WA button at priority 10) */
add_action( 'woocommerce_after_add_to_cart_button', function() {
    echo '</div>';
}, 1 );

add_action( 'woocommerce_after_add_to_cart_button', 'pemu_product_whatsapp_button', 10 );
function pemu_product_whatsapp_button(): void {
    global $product;
    if ( !$product instanceof WC_Product ) return;
    $msg = "Hi Pemu Ventures! 👋\n\nI'd like to order:\n\n*{$product->get_name()}*\n".strip_tags($product->get_price_html())."\n".get_permalink()."\n\nPlease confirm. Thank you!";
    ?>
<a href="<?php echo esc_url(pemu_whatsapp_url($msg)); ?>" target="_blank" rel="noopener noreferrer"
    class="pemu-wa-btn-product flex items-center justify-center gap-2 w-full py-3 px-6 rounded-xl border-2 border-green-500 dark:border-green-400 text-green-500 dark:text-green-400 font-semibold hover:bg-green-500 dark:hover:bg-green-400 hover:text-white dark:hover:text-slate-900 transition-all duration-200">
    <?php echo pemu_icon('whatsapp',['class'=>'w-5 h-5 shrink-0']); ?>
    <?php esc_html_e('Order via WhatsApp','pemu'); ?>
</a>
<?php
}

/* 10. WHATSAPP ON CART */
remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );

add_action( 'woocommerce_proceed_to_checkout', 'pemu_cart_whatsapp_cta', 5 );
function pemu_cart_whatsapp_cta(): void {
    if (!function_exists('pemu_cart_whatsapp_message')) return;
    $url = pemu_whatsapp_url(pemu_cart_whatsapp_message());
    ?>
<a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer"
    class="flex items-center justify-center gap-2 w-full mb-3 py-3 px-6 rounded-xl border-2 border-green-500 dark:border-green-400 text-green-500 dark:text-green-400 font-semibold hover:bg-green-500 dark:hover:bg-green-400 hover:text-white dark:hover:text-slate-900 transition-all duration-200">
    <?php echo pemu_icon('whatsapp',['class'=>'w-5 h-5 shrink-0']); ?>
    <?php esc_html_e('Order via WhatsApp','pemu'); ?>
</a>
<?php
}

/* 11. THANK YOU PAGE CTA */
add_action( 'woocommerce_thankyou', 'pemu_thankyou_whatsapp_cta', 15 );
function pemu_thankyou_whatsapp_cta( int $order_id ): void {
    $order = wc_get_order($order_id);
    if (!$order) return;
    $msg = "Hi Pemu Ventures! 👋 I just placed Order #{$order->get_order_number()}. Please confirm and update me on delivery.";
    ?>
<div class="mt-8 p-6 rounded-2xl border border-green-500/30 bg-green-500/5 text-center">
    <p class="font-medium mb-3 text-slate-800 dark:text-slate-200">
        <?php esc_html_e('Get order updates on WhatsApp','pemu'); ?></p>
    <a href="<?php echo esc_url(pemu_whatsapp_url($msg)); ?>" target="_blank" rel="noopener noreferrer"
        class="inline-flex items-center gap-2 py-3 px-8 rounded-xl bg-green-500 text-white! font-bold hover:bg-green-600 transition-colors">
        <?php echo pemu_icon('whatsapp',['class'=>'w-5 h-5']); ?>
        <?php esc_html_e('Track Order via WhatsApp','pemu'); ?>
    </a>
</div>
<?php
}

/* 12. CUSTOM FILTER PARAMS (price handled by WC natively; add stock/sale) */
add_action( 'woocommerce_product_query', 'pemu_apply_custom_filters' );
function pemu_apply_custom_filters( WP_Query $q ): void {
    if ( !empty($_GET['instock']) ) {
        $meta   = (array)$q->get('meta_query');
        $meta[] = ['key'=>'_stock_status','value'=>'instock','compare'=>'='];
        $q->set('meta_query',$meta);
    }
    if ( !empty($_GET['onsale']) ) {
        $sale_ids = wc_get_product_ids_on_sale();
        $existing = (array)$q->get('post__in');
        $ids      = empty($existing) ? $sale_ids : array_intersect($existing,$sale_ids);
        $q->set('post__in', empty($ids) ? [0] : $ids);
    }
}

/* 13. DISABLE DEFAULT SIDEBAR */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/* 14. NO PRODUCTS FOUND */
add_filter( 'woocommerce_no_products_found_text', fn() =>
    wp_kses(sprintf(__('No products found. <a href="%s" class="text-brand-green underline">Browse all →</a>','pemu'), esc_url(wc_get_page_permalink('shop'))),
    ['a'=>['href'=>[],'class'=>[]]])
);

/* 15. RELATED PRODUCTS */
add_filter( 'woocommerce_output_related_products_args', function(array $a): array {
    $a['posts_per_page'] = 4; $a['columns'] = 4; return $a;
});

/* 16. REMOVE WOOCOMMERCE DEFAULT ADD-TO-CART BUTTON from loop (we have our own + button in content-product.php) */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

/* 17. ADD-TO-CART REDIRECT: keep users on shop page when adding via URL param */
add_filter( 'woocommerce_add_to_cart_redirect', function( $url ) {
    /* If a product is being added via ?add-to-cart=ID on a non-cart/checkout page
       (e.g. shop, home), stay put so the user sees the success notice right where they are.
       This is primarily for marketing/email links like /shop/?add-to-cart=123. */
    if ( ! is_cart() && ! is_checkout() && ! empty( $_REQUEST['add-to-cart'] ) ) {
        return remove_query_arg( [ 'add-to-cart', 'quantity', 'variation_id' ] );
    }
    return $url;
}, 10, 1 );

/* 18. STOCK URGENCY IN LOOP */
add_action( 'woocommerce_after_shop_loop_item_title', 'pemu_loop_stock_indicator', 15 );
function pemu_loop_stock_indicator(): void {
    global $product;
    if (!$product instanceof WC_Product) return;
    $ind = pemu_stock_indicator($product);
    if (!empty($ind) && in_array($ind['class'],['text-red-500','text-amber-500'],true)) {
        echo '<span class="block text-xs mt-0.5 '.esc_attr($ind['class']).'">'.esc_html($ind['label']).'</span>';
    }
}

/* 19. AJAX: Update cart item quantity */
add_action( 'wp_ajax_pemu_update_cart_qty', 'pemu_ajax_update_cart_qty' );
add_action( 'wp_ajax_nopriv_pemu_update_cart_qty', 'pemu_ajax_update_cart_qty' );
function pemu_ajax_update_cart_qty(): void {
    check_ajax_referer( 'pemu-nonce', 'nonce' );
    $key = sanitize_text_field( $_POST['cart_item_key'] ?? '' );
    $qty = absint( $_POST['quantity'] ?? 1 );
    if ( $key ) {
        WC()->cart->set_quantity( $key, $qty );
    }
    WC_AJAX::get_refreshed_fragments();
}

/* 20. AJAX: Remove cart item */
add_action( 'wp_ajax_pemu_remove_cart_item', 'pemu_ajax_remove_cart_item' );
add_action( 'wp_ajax_nopriv_pemu_remove_cart_item', 'pemu_ajax_remove_cart_item' );
function pemu_ajax_remove_cart_item(): void {
    check_ajax_referer( 'pemu-nonce', 'nonce' );
    $key = sanitize_text_field( $_POST['cart_item_key'] ?? '' );
    if ( $key ) {
        WC()->cart->remove_cart_item( $key );
    }
    WC_AJAX::get_refreshed_fragments();
}
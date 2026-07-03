<?php
/**
 * WooCommerce single-product/tabs/tabs.php — Pemu override
 * Alpine.js pill tabs. Pre-Alpine visibility handled via inline style fallback
 * so description is always visible before JS loads.
 * @version 3.8.1
 */
defined('ABSPATH') || exit;

$product_tabs = apply_filters('woocommerce_product_tabs', []);
if (empty($product_tabs)) return;

$first_tab = array_key_first($product_tabs);
$tab_keys  = array_keys($product_tabs);
?>
<div class="pemu-product-tabs woocommerce-tabs wc-tabs-wrapper"
     x-data="{ activeTab: '<?php echo esc_js($first_tab); ?>' }">

    <?php /* ── Tab navigation ── */ ?>
    <div class="flex gap-1 p-1 bg-slate-100 dark:bg-slate-900 rounded-2xl mb-8 w-fit overflow-x-auto"
         role="tablist">
        <?php foreach ($product_tabs as $key => $tab): ?>
        <button type="button"
                id="tab-title-<?php echo esc_attr($key); ?>"
                role="tab"
                :aria-selected="activeTab === '<?php echo esc_js($key); ?>'"
                aria-controls="tab-panel-<?php echo esc_attr($key); ?>"
                @click="activeTab = '<?php echo esc_js($key); ?>'"
                :class="activeTab === '<?php echo esc_js($key); ?>'
                    ? 'bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm ring-1 ring-slate-200/80 dark:ring-slate-700'
                    : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-white/50 dark:hover:bg-slate-800/40'"
                class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 whitespace-nowrap focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-green <?php echo $key === $first_tab ? 'bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm ring-1 ring-slate-200/80 dark:ring-slate-700' : 'text-slate-500 dark:text-slate-400'; ?>">
            <?php echo esc_html(apply_filters('woocommerce_product_' . $key . '_tab_title', $tab['title'], $key)); ?>
        </button>
        <?php endforeach; ?>
    </div>

    <?php /* ── Tab panels ──
     * style fallback: first panel visible, rest hidden — before Alpine.js loads.
     * We use `pemu-wc-tab` instead of `wc-tab` so WooCommerce's own tab.js
     * doesn't pick these up and forcibly hide them.
     */ ?>
    <?php foreach ($product_tabs as $key => $tab): ?>
    <div id="tab-panel-<?php echo esc_attr($key); ?>"
         class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content pemu-wc-tab"
         role="tabpanel"
         aria-labelledby="tab-title-<?php echo esc_attr($key); ?>"
         style="<?php echo $key === $first_tab ? 'display:block' : 'display:none'; ?>"
         x-show="activeTab === '<?php echo esc_js($key); ?>'"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0">
        <?php
            if (isset($tab['callback'])) {
                call_user_func($tab['callback'], $key, $tab);
            }
        ?>
    </div>
    <?php endforeach; ?>

</div>

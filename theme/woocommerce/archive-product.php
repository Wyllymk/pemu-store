<?php
/**
 * WooCommerce archive-product.php — Pemu override (fixed)
 * Removes woocommerce_get_loop_class() fatal error.
 * Adds working price / stock / sale filters.
 * @version 8.6.0
 */
defined('ABSPATH') || exit;
get_header();

$shop_url   = wc_get_page_permalink('shop');
$curr_url   = home_url(add_query_arg([]));
$min_price  = isset($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
$max_price  = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 15000;
$instock    = !empty($_GET['instock']);
$onsale     = !empty($_GET['onsale']);
$orderby    = sanitize_text_field($_GET['orderby'] ?? 'menu_order');

// Fetch min/max product prices for slider bounds
global $wpdb;
$price_range = $wpdb->get_row("SELECT MIN(CAST(meta_value AS DECIMAL(10,2))) as min_p, MAX(CAST(meta_value AS DECIMAL(10,2))) as max_p FROM {$wpdb->postmeta} WHERE meta_key='_price' AND meta_value!=''");
$global_min  = max(0,   (int)($price_range->min_p ?? 0));
$global_max  = max(1000,(int)($price_range->max_p ?? 15000));
if ($max_price === 15000) $max_price = $global_max;
?>

<main id="main-content" class="min-h-screen">
    <?php do_action('woocommerce_before_main_content'); ?>

    <!-- Page header -->
    <div class="bg-gray-100 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <?php woocommerce_breadcrumb(); ?>
            <div class="mt-3 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h1 class="font-display font-extrabold text-3xl lg:text-4xl text-slate-800 dark:text-slate-200">
                        <?php woocommerce_page_title(); ?>
                    </h1>
                    <div class="text-sm text-slate-500 dark:text-slate-400 mt-1"><?php woocommerce_result_count(); ?></div>
                </div>
                <div class="flex items-center gap-3 flex-wrap">
                    <!-- Grid / List toggle -->
                    <div id="view-toggle" x-data="{v: localStorage.getItem('pemu-view')||'grid'}"
                        x-init="$nextTick(()=>{ document.getElementById('shop-grid')?.classList.toggle('pemu-list-view',v==='list'); })"
                        class="hidden md:flex items-center gap-0.5 p-1 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        <button
                            @click="v='grid'; localStorage.setItem('pemu-view','grid'); document.getElementById('shop-grid')?.classList.remove('pemu-list-view');"
                            :class="v==='grid'?'bg-brand-green text-white':'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:text-slate-200'"
                            class="p-2 rounded transition-colors" aria-label="Grid view">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                            </svg>
                        </button>
                        <button
                            @click="v='list'; localStorage.setItem('pemu-view','list'); document.getElementById('shop-grid')?.classList.add('pemu-list-view');"
                            :class="v==='list'?'bg-brand-green text-white':'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:text-slate-200'"
                            class="p-2 rounded transition-colors" aria-label="List view">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" stroke-linecap="round" />
                            </svg>
                        </button>
                    </div>
                    <!-- Sort -->
                    <form method="get" class="m-0">
                        <?php foreach ($_GET as $k=>$val) if ($k!=='orderby') echo '<input type="hidden" name="'.esc_attr($k).'" value="'.esc_attr($val).'">'; ?>
                        <select name="orderby" onchange="this.form.submit()"
                            class="px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-green cursor-pointer">
                            <option value="menu_order" <?php selected($orderby,'menu_order'); ?>>Default</option>
                            <option value="popularity" <?php selected($orderby,'popularity'); ?>>Most Popular</option>
                            <option value="rating" <?php selected($orderby,'rating'); ?>>Top Rated</option>
                            <option value="date" <?php selected($orderby,'date'); ?>>Newest</option>
                            <option value="price" <?php selected($orderby,'price'); ?>>Price: Low → High</option>
                            <option value="price-desc" <?php selected($orderby,'price-desc'); ?>>Price: High → Low
                            </option>
                        </select>
                    </form>
                    <!-- Mobile filter button -->
                    <button @click="$root.filtersOpen=true"
                        class="lg:hidden flex items-center gap-2 bg-brand-green text-white font-semibold text-sm px-4 py-2.5 rounded-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" stroke-linejoin="round" />
                        </svg>
                        Filters
                        <?php if ($instock||$onsale||$min_price>$global_min||$max_price<$global_max): ?>
                        <span
                            class="bg-white text-brand-green rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">!</span>
                        <?php endif; ?>
                    </button>
                </div>
            </div>

            <!-- Active filter chips -->
            <?php $chips = []; 
    if ($instock) $chips[] = ['In Stock', remove_query_arg('instock')];
    if ($onsale)  $chips[] = ['On Sale',  remove_query_arg('onsale')];
    if ($min_price>$global_min||$max_price<$global_max) $chips[] = ['KSh '.number_format($min_price).' – '.number_format($max_price), remove_query_arg(['min_price','max_price'])];
    if (!empty($chips)): ?>
            <div class="mt-4 flex flex-wrap gap-2 items-center">
                <?php foreach ($chips as [$label,$href]): ?>
                <a href="<?php echo esc_url($href); ?>"
                    class="inline-flex items-center gap-1.5 bg-brand-green/10 text-brand-green text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-brand-green/20 transition-colors">
                    <?php echo esc_html($label); ?> ✕
                </a>
                <?php endforeach; ?>
                <a href="<?php echo esc_url($shop_url); ?>"
                    class="text-xs text-slate-500 dark:text-slate-400 underline hover:text-brand-green">Clear all</a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8 lg:py-10">
        <div class="lg:grid lg:grid-cols-[260px_1fr] lg:gap-8">

            <!-- DESKTOP SIDEBAR -->
            <aside class="hidden lg:block space-y-5" aria-label="Product filters">

                <!-- Category filter -->
                <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-5">
                    <h3 class="font-display font-bold text-sm uppercase tracking-widest mb-4 text-slate-800 dark:text-slate-200">
                        Category</h3>
                    <ul class="space-y-1.5 text-sm">
                        <li>
                            <a href="<?php echo esc_url($shop_url); ?>"
                                class="flex items-center justify-between py-1.5 px-2 rounded-lg transition-colors <?php echo !is_product_category() ? 'text-brand-green bg-brand-green/8 font-semibold' : 'text-slate-800 dark:text-slate-200 hover:text-brand-green hover:bg-gray-100 dark:hover:bg-slate-800'; ?>">
                                <span>All Products</span>
                                <span
                                    class="text-[11px] text-slate-500 dark:text-slate-400"><?php echo wp_count_posts('product')->publish; ?></span>
                            </a>
                        </li>
                        <?php
          $cats = get_terms(['taxonomy'=>'product_cat','hide_empty'=>true,'parent'=>0,'exclude'=>[get_option('default_product_cat')]]);
          if (!is_wp_error($cats)) foreach ($cats as $cat):
            $active = is_product_category($cat->term_id);
            $url    = get_term_link($cat);
          ?>
                        <li>
                            <a href="<?php echo esc_url(is_wp_error($url)?$shop_url:$url); ?>"
                                class="flex items-center justify-between py-1.5 px-2 rounded-lg transition-colors <?php echo $active ? 'text-brand-green bg-brand-green/8 font-semibold' : 'text-slate-800 dark:text-slate-200 hover:text-brand-green hover:bg-gray-100 dark:hover:bg-slate-800'; ?>">
                                <span><?php echo esc_html($cat->name); ?></span>
                                <span
                                    class="text-[11px] text-slate-500 dark:text-slate-400">(<?php echo esc_html($cat->count); ?>)</span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Price filter — DYNAMIC with dual inputs + slider -->
                <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-5" x-data="{
             minV: <?php echo (int)$min_price; ?>,
             maxV: <?php echo (int)$max_price; ?>,
             globalMin: <?php echo (int)$global_min; ?>,
             globalMax: <?php echo (int)$global_max; ?>,
             apply(){
               const u=new URL(window.location.href);
               u.searchParams.set('min_price',this.minV);
               u.searchParams.set('max_price',this.maxV);
               u.searchParams.delete('paged');
               window.location.href=u.toString();
             }
           }">
                    <h3 class="font-display font-bold text-sm uppercase tracking-widest mb-4 text-slate-800 dark:text-slate-200">
                        Price Range</h3>
                    <div class="space-y-4">
                        <!-- Dual text inputs -->
                        <div class="flex items-center gap-2">
                            <div class="flex-1">
                                <label
                                    class="text-[10px] text-slate-500 dark:text-slate-400 font-semibold uppercase tracking-wide block mb-1">Min
                                    (KSh)</label>
                                <input type="number" x-model.number="minV" :min="globalMin" :max="maxV-100" step="100"
                                    class="w-full px-3 py-2 text-sm rounded-lg bg-gray-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-green">
                            </div>
                            <span class="text-slate-500 dark:text-slate-400 mt-5">–</span>
                            <div class="flex-1">
                                <label
                                    class="text-[10px] text-slate-500 dark:text-slate-400 font-semibold uppercase tracking-wide block mb-1">Max
                                    (KSh)</label>
                                <input type="number" x-model.number="maxV" :min="minV+100" :max="globalMax" step="100"
                                    class="w-full px-3 py-2 text-sm rounded-lg bg-gray-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-green">
                            </div>
                        </div>
                        <!-- Min slider -->
                        <div>
                            <label class="text-[10px] text-slate-500 dark:text-slate-400 mb-1 block">Min: <span
                                    class="font-semibold text-slate-800 dark:text-slate-200"
                                    x-text="'KSh '+minV.toLocaleString()"></span></label>
                            <input type="range" x-model.number="minV" :min="globalMin" :max="maxV-100" step="100"
                                class="w-full accent-brand-green cursor-pointer">
                        </div>
                        <!-- Max slider -->
                        <div>
                            <label class="text-[10px] text-slate-500 dark:text-slate-400 mb-1 block">Max: <span
                                    class="font-semibold text-slate-800 dark:text-slate-200"
                                    x-text="'KSh '+maxV.toLocaleString()"></span></label>
                            <input type="range" x-model.number="maxV" :min="minV+100" :max="globalMax" step="100"
                                class="w-full accent-brand-green cursor-pointer">
                        </div>
                        <button @click="apply()"
                            class="w-full py-2.5 rounded-xl bg-brand-green hover:bg-brand-green-dark text-white font-bold text-sm transition-colors">
                            Apply Price
                        </button>
                    </div>
                </div>

                <!-- Availability -->
                <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-5">
                    <h3 class="font-display font-bold text-sm uppercase tracking-widest mb-4 text-slate-800 dark:text-slate-200">
                        Availability</h3>
                    <div class="space-y-2.5 text-sm">
                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <input type="checkbox" <?php checked($instock); ?>
                                onchange="pemuToggleFilter('instock', this.checked)"
                                class="w-4 h-4 rounded border-slate-200 dark:border-slate-700 text-brand-green focus:ring-brand-green focus:ring-offset-0 accent-brand-green">
                            <span class="text-slate-800 dark:text-slate-200 group-hover:text-brand-green transition-colors">In
                                stock only</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <input type="checkbox" <?php checked($onsale); ?>
                                onchange="pemuToggleFilter('onsale', this.checked)"
                                class="w-4 h-4 rounded border-slate-200 dark:border-slate-700 text-brand-green focus:ring-brand-green focus:ring-offset-0 accent-brand-green">
                            <span class="text-slate-800 dark:text-slate-200 group-hover:text-brand-green transition-colors">On
                                sale</span>
                        </label>
                    </div>
                </div>

            </aside><!-- /sidebar -->

            <!-- PRODUCT GRID -->
            <div>
                <?php if (woocommerce_product_loop()): ?>
                <?php do_action('woocommerce_before_shop_loop'); ?>

                <ul id="shop-grid" class="products grid grid-cols-2 md:grid-cols-3 gap-4 lg:gap-5 list-none p-0 m-0"
                    x-data
                    x-init="const v=localStorage.getItem('pemu-view'); if(v==='list') $el.classList.add('pemu-list-view');">
                    <?php while (have_posts()): the_post(); wc_get_template_part('content','product'); endwhile; ?>
                </ul>

                <?php do_action('woocommerce_after_shop_loop'); ?>
                <?php else: ?>
                <?php do_action('woocommerce_no_products_found'); ?>
                <?php endif; ?>
            </div>

        </div><!-- /grid -->
    </div><!-- /container -->

    <!-- MOBILE FILTERS DRAWER -->
    <div x-show="$root.filtersOpen ?? false" x-cloak class="fixed inset-0 z-[60] lg:hidden" role="dialog"
        aria-modal="true" aria-label="Filters">
        <div @click="$root.filtersOpen=false" class="absolute inset-0 bg-black/60"
            x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" aria-hidden="true"></div>
        <aside x-show="$root.filtersOpen ?? false" x-transition:enter="transition transform ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute right-0 top-0 bottom-0 w-80 max-w-[88vw] flex flex-col bg-white dark:bg-slate-800 shadow-2xl overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200 dark:border-slate-700">
                <h2 class="font-display font-bold text-lg text-slate-800 dark:text-slate-200">Filters</h2>
                <button @click="$root.filtersOpen=false"
                    class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 text-slate-500 dark:text-slate-400">✕</button>
            </div>
            <div class="flex-1 overflow-y-auto p-5 space-y-6"
                x-data="{minV:<?php echo (int)$min_price; ?>, maxV:<?php echo (int)$max_price; ?>, globalMin:<?php echo (int)$global_min; ?>, globalMax:<?php echo (int)$global_max; ?>}">
                <!-- Mobile categories -->
                <div>
                    <h3 class="font-bold text-sm uppercase tracking-widest mb-3 text-slate-800 dark:text-slate-200">Category</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="<?php echo esc_url($shop_url); ?>"
                            class="px-3 py-1.5 rounded-full text-xs font-semibold border-2 <?php echo !is_product_category()?'border-brand-green bg-brand-green/10 text-brand-green':'border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200'; ?>">All</a>
                        <?php if (!is_wp_error($cats)) foreach ($cats as $cat):
            $u = get_term_link($cat); if(is_wp_error($u)) continue; ?>
                        <a href="<?php echo esc_url($u); ?>"
                            class="px-3 py-1.5 rounded-full text-xs font-semibold border-2 <?php echo is_product_category($cat->term_id)?'border-brand-green bg-brand-green/10 text-brand-green':'border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200'; ?>">
                            <?php echo esc_html($cat->name); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- Mobile price -->
                <div>
                    <h3 class="font-bold text-sm uppercase tracking-widest mb-3 text-slate-800 dark:text-slate-200">Price: <span
                            x-text="'KSh '+minV.toLocaleString()+' – KSh '+maxV.toLocaleString()"></span></h3>
                    <div class="space-y-3">
                        <input type="range" x-model.number="maxV" :min="minV+100" :max="globalMax" step="100"
                            class="w-full accent-brand-green">
                        <button
                            onclick="pemuApplyPrice(document.querySelector('[x-data]').querySelector('input[type=range]')?.value)"
                            @click="const u=new URL(window.location.href);u.searchParams.set('min_price',minV);u.searchParams.set('max_price',maxV);window.location.href=u.toString();"
                            class="w-full py-2.5 bg-brand-green text-white font-bold rounded-xl text-sm">Apply</button>
                    </div>
                </div>
                <!-- Mobile availability -->
                <div>
                    <h3 class="font-bold text-sm uppercase tracking-widest mb-3 text-slate-800 dark:text-slate-200">Availability
                    </h3>
                    <div class="space-y-2.5">
                        <label class="flex items-center gap-2.5 cursor-pointer text-sm">
                            <input type="checkbox" <?php checked($instock); ?>
                                onchange="pemuToggleFilter('instock',this.checked)"
                                class="w-4 h-4 rounded accent-brand-green">
                            <span class="text-slate-800 dark:text-slate-200">In stock only</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer text-sm">
                            <input type="checkbox" <?php checked($onsale); ?>
                                onchange="pemuToggleFilter('onsale',this.checked)"
                                class="w-4 h-4 rounded accent-brand-green">
                            <span class="text-slate-800 dark:text-slate-200">On sale</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="p-5 border-t border-slate-200 dark:border-slate-700 grid grid-cols-2 gap-3">
                <a href="<?php echo esc_url($shop_url); ?>"
                    class="py-3 rounded-xl border border-slate-200 dark:border-slate-700 font-semibold text-sm text-center text-slate-800 dark:text-slate-200 hover:border-brand-green">Clear
                    All</a>
                <button @click="$root.filtersOpen=false"
                    class="py-3 rounded-xl bg-brand-green text-white font-bold text-sm">Done</button>
            </div>
        </aside>
    </div>

    <?php do_action('woocommerce_after_main_content'); ?>
</main>

<script>
function pemuToggleFilter(param, enabled) {
    const u = new URL(window.location.href);
    if (enabled) {
        u.searchParams.set(param, '1');
    } else {
        u.searchParams.delete(param);
    }
    u.searchParams.delete('paged');
    window.location.href = u.toString();
}
</script>

<?php get_footer(); ?>
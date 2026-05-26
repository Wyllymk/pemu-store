<?php
/**
 * WooCommerce — archive-product.php
 * Pemu override: full shop/category archive with filter sidebar.
 * All WC hooks preserved. Layout only.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @version 3.3.0
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="min-h-screen">

    <?php do_action( 'woocommerce_before_main_content' ); ?>

    <!-- Breadcrumb + Page header -->
    <div class="bg-[var(--color-bg-muted)] border-b border-[var(--color-border)]">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <?php woocommerce_breadcrumb(); ?>

            <div class="mt-3 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h1 class="font-display font-extrabold text-3xl lg:text-4xl text-[var(--color-text)]">
                        <?php woocommerce_page_title(); ?>
                    </h1>
                    <div class="text-sm text-[var(--color-text-muted)] mt-1">
                        <?php woocommerce_result_count(); ?>
                    </div>
                </div>

                <!-- Sort + View toggle -->
                <div class="flex items-center gap-3">
                    <!-- Grid/List toggle (desktop) -->
                    <div class="hidden md:flex items-center gap-0.5 p-1 rounded-lg bg-[var(--color-surface)] border border-[var(--color-border)]"
                        x-data="{ view: localStorage.getItem('pemu-shop-view') || 'grid' }">
                        <button
                            @click="view='grid'; localStorage.setItem('pemu-shop-view','grid'); document.getElementById('shop-grid').className = document.getElementById('shop-grid').className.replace('pemu-list-view','');"
                            :class="view==='grid' ? 'bg-brand-green text-white' : 'text-[var(--color-text-muted)] hover:text-[var(--color-text)]'"
                            class="p-2 rounded transition-colors"
                            aria-label="<?php esc_attr_e( 'Grid view', 'pemu' ); ?>">
                            <?php echo pemu_icon( 'grid', [ 'class' => 'w-4 h-4' ] ); ?>
                        </button>
                        <button
                            @click="view='list'; localStorage.setItem('pemu-shop-view','list'); document.getElementById('shop-grid').classList.add('pemu-list-view');"
                            :class="view==='list' ? 'bg-brand-green text-white' : 'text-[var(--color-text-muted)] hover:text-[var(--color-text)]'"
                            class="p-2 rounded transition-colors"
                            aria-label="<?php esc_attr_e( 'List view', 'pemu' ); ?>">
                            <?php echo pemu_icon( 'list', [ 'class' => 'w-4 h-4' ] ); ?>
                        </button>
                    </div>

                    <!-- Sort dropdown -->
                    <?php woocommerce_catalog_ordering(); ?>

                    <!-- Mobile filters button -->
                    <button @click="$store.ui.filtersOpen = true"
                        class="lg:hidden inline-flex items-center gap-2 bg-brand-green text-white font-semibold text-sm px-4 py-2.5 rounded-xl">
                        <?php echo pemu_icon( 'filter', [ 'class' => 'w-4 h-4' ] ); ?>
                        <?php esc_html_e( 'Filters', 'pemu' ); ?>
                    </button>
                </div>
            </div>

            <!-- Active filter chips -->
            <?php
			$active_filters = [];
			if ( isset( $_GET['product_cat'] ) && $_GET['product_cat'] ) {
				$term = get_term_by( 'slug', sanitize_text_field( wp_unslash( $_GET['product_cat'] ) ), 'product_cat' );
				if ( $term ) $active_filters[] = $term->name;
			}
			if ( isset( $_GET['min_price'] ) || isset( $_GET['max_price'] ) ) {
				$active_filters[] = __( 'Price range', 'pemu' );
			}
			if ( ! empty( $active_filters ) ) :
			?>
            <div class="mt-4 flex flex-wrap gap-2 items-center">
                <?php foreach ( $active_filters as $filter ) : ?>
                <span
                    class="inline-flex items-center gap-1.5 bg-brand-green/10 text-brand-green text-xs font-semibold px-3 py-1.5 rounded-full">
                    <?php echo esc_html( $filter ); ?>
                    <a href="<?php echo esc_url( remove_query_arg( [ 'product_cat', 'min_price', 'max_price', 'paged' ] ) ); ?>"
                        class="opacity-70 hover:opacity-100"
                        aria-label="<?php esc_attr_e( 'Remove filter', 'pemu' ); ?>">✕</a>
                </span>
                <?php endforeach; ?>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
                    class="text-xs text-[var(--color-text-muted)] underline hover:text-brand-green">
                    <?php esc_html_e( 'Clear all', 'pemu' ); ?>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Main layout: sidebar + grid -->
    <div class="max-w-7xl mx-auto px-4 py-8 lg:py-10">
        <div class="lg:grid lg:grid-cols-[260px_1fr] lg:gap-8">

            <!-- ── DESKTOP SIDEBAR ─────────────────────────────── -->
            <aside class="hidden lg:block space-y-5" aria-label="<?php esc_attr_e( 'Product filters', 'pemu' ); ?>">

                <!-- Category filter -->
                <div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-5">
                    <h3 class="font-display font-bold text-sm uppercase tracking-widest mb-4 text-[var(--color-text)]">
                        <?php esc_html_e( 'Category', 'pemu' ); ?></h3>
                    <?php
					$cats = get_terms( [ 'taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0, 'exclude' => [ get_option( 'default_product_cat' ) ] ] );
					if ( ! is_wp_error( $cats ) ) :
					?>
                    <ul class="space-y-2 text-sm">
                        <?php foreach ( $cats as $cat ) :
							$active = ( get_queried_object_id() === $cat->term_id ) || ( isset( $_GET['product_cat'] ) && sanitize_text_field( wp_unslash( $_GET['product_cat'] ) ) === $cat->slug );
						?>
                        <li>
                            <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
                                class="flex items-center justify-between py-1 transition-colors <?php echo $active ? 'text-brand-green font-semibold' : 'text-[var(--color-text)] hover:text-brand-green'; ?>">
                                <span><?php echo esc_html( $cat->name ); ?></span>
                                <span
                                    class="text-[11px] text-[var(--color-text-muted)] tabular-nums">(<?php echo esc_html( $cat->count ); ?>)</span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>

                <!-- Price range -->
                <div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-5"
                    x-data="priceFilter()">
                    <h3 class="font-display font-bold text-sm uppercase tracking-widest mb-4 text-[var(--color-text)]">
                        <?php esc_html_e( 'Price Range', 'pemu' ); ?></h3>
                    <div class="space-y-3">
                        <input type="range" min="0" max="15000" step="100" x-model="maxPrice" @change="applyPrice()"
                            class="w-full accent-brand-green cursor-pointer"
                            aria-label="<?php esc_attr_e( 'Maximum price', 'pemu' ); ?>">
                        <div class="flex items-center justify-between text-xs text-[var(--color-text-muted)]">
                            <span><?php echo wc_price( 0 ); ?></span>
                            <span class="font-semibold text-[var(--color-text)]"><?php esc_html_e( 'Up to', 'pemu' ); ?>
                                <span x-text="'KES ' + Number(maxPrice).toLocaleString()"></span></span>
                        </div>
                    </div>
                </div>

                <!-- Brand filter -->
                <!-- <div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-5">
                    <h3 class="font-display font-bold text-sm uppercase tracking-widest mb-4 text-[var(--color-text)]">
                        <?php esc_html_e( 'Brand', 'pemu' ); ?></h3>
                    <?php
					$brands = get_terms( [ 'taxonomy' => 'product_brand', 'hide_empty' => true ] );
					if ( ! is_wp_error( $brands ) && $brands ) :
					?>
                    <ul class="space-y-2 text-sm">
                        <?php foreach ( array_slice( $brands, 0, 8 ) as $brand ) : ?>
                        <li>
                            <label
                                class="flex items-center gap-2.5 cursor-pointer hover:text-brand-green transition-colors group">
                                <input type="checkbox"
                                    class="rounded border-[var(--color-border)] text-brand-green focus:ring-brand-green focus:ring-offset-0"
                                    onchange="window.location='<?php echo esc_url( add_query_arg( 'product_brand', $brand->slug, wc_get_page_permalink( 'shop' ) ) ); ?>'">
                                <span
                                    class="text-[var(--color-text)] group-hover:text-brand-green"><?php echo esc_html( $brand->name ); ?></span>
                                <span
                                    class="ml-auto text-[11px] text-[var(--color-text-muted)]">(<?php echo esc_html( $brand->count ); ?>)</span>
                            </label>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else : ?>
                    <p class="text-xs text-[var(--color-text-muted)]">
                        <?php esc_html_e( 'No brand taxonomy found. Install a brand plugin or add product_brand taxonomy.', 'pemu' ); ?>
                    </p>
                    <?php endif; ?>
                </div> -->

                <!-- Availability -->
                <div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-2xl p-5">
                    <h3 class="font-display font-bold text-sm uppercase tracking-widest mb-4 text-[var(--color-text)]">
                        <?php esc_html_e( 'Availability', 'pemu' ); ?></h3>
                    <div class="space-y-2 text-sm">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox"
                                class="rounded border-[var(--color-border)] text-brand-green focus:ring-brand-green focus:ring-offset-0">
                            <span
                                class="text-[var(--color-text)]"><?php esc_html_e( 'In stock only', 'pemu' ); ?></span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox"
                                class="rounded border-[var(--color-border)] text-brand-green focus:ring-brand-green focus:ring-offset-0">
                            <span class="text-[var(--color-text)]"><?php esc_html_e( 'On sale', 'pemu' ); ?></span>
                        </label>
                    </div>
                </div>
            </aside>

            <!-- ── PRODUCT GRID ──────────────────────────────────── -->
            <div class="flex flex-col gap-4">

                <?php if ( woocommerce_product_loop() ) : ?>

                <?php do_action( 'woocommerce_before_shop_loop' ); ?>

                <ul id="shop-grid"
                    class="products grid grid-cols-2 md:grid-cols-3 gap-4 lg:gap-5 pemu-product-grid list-none p-0 m-0">

                    <?php wc_setup_loop(); ?>

                    <?php while ( have_posts() ) : the_post(); ?>

                    <?php wc_get_template_part( 'content', 'product' ); ?>

                    <?php endwhile; ?>

                </ul>

                <?php do_action( 'woocommerce_after_shop_loop' ); ?>

                <?php else : ?>

                <?php do_action( 'woocommerce_no_products_found' ); ?>

                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- ── MOBILE FILTERS DRAWER ─────────────────────────────── -->
    <div x-show="$store.ui.filtersOpen" x-cloak class="fixed inset-0 z-[60] lg:hidden" role="dialog" aria-modal="true"
        aria-label="<?php esc_attr_e( 'Filters', 'pemu' ); ?>">
        <div class="absolute inset-0 bg-black/60" @click="$store.ui.filtersOpen = false"
            x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" aria-hidden="true"></div>
        <aside x-show="$store.ui.filtersOpen" x-transition:enter="transition transform ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute right-0 top-0 bottom-0 w-80 max-w-[88vw] flex flex-col bg-[var(--color-surface)] shadow-2xl overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-[var(--color-border)]">
                <h2 class="font-display font-bold text-lg text-[var(--color-text)]">
                    <?php esc_html_e( 'Filters', 'pemu' ); ?></h2>
                <button @click="$store.ui.filtersOpen = false"
                    aria-label="<?php esc_attr_e( 'Close filters', 'pemu' ); ?>"
                    class="p-2 rounded-lg hover:bg-[var(--color-bg-muted)] text-[var(--color-text-muted)]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-5 space-y-6">
                <!-- Mobile categories -->
                <div>
                    <h3 class="font-bold text-sm uppercase tracking-widest mb-3 text-[var(--color-text)]">
                        <?php esc_html_e( 'Category', 'pemu' ); ?></h3>
                    <?php
					$cats = get_terms( [ 'taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0, 'exclude' => [ get_option( 'default_product_cat' ) ] ] );
					if ( ! is_wp_error( $cats ) ) :
					?>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ( $cats as $cat ) :
							$active = ( get_queried_object_id() === $cat->term_id );
						?>
                        <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
                            class="px-3 py-1.5 rounded-full text-xs font-semibold border-2 transition-colors <?php echo $active ? 'border-brand-green bg-brand-green/10 text-brand-green' : 'border-[var(--color-border)] text-[var(--color-text)] hover:border-brand-green'; ?>">
                            <?php echo esc_html( $cat->name ); ?> (<?php echo esc_html( $cat->count ); ?>)
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- Mobile price range -->
                <div x-data="priceFilter()">
                    <h3 class="font-bold text-sm uppercase tracking-widest mb-3 text-[var(--color-text)]">
                        <?php esc_html_e( 'Price', 'pemu' ); ?>: <span
                            x-text="'KES ' + Number(maxPrice).toLocaleString()"></span>
                    </h3>
                    <input type="range" min="0" max="15000" step="100" x-model="maxPrice" @change="applyPrice()"
                        class="w-full accent-brand-green" aria-label="<?php esc_attr_e( 'Maximum price', 'pemu' ); ?>">
                </div>
            </div>
            <div class="p-5 border-t border-[var(--color-border)] grid grid-cols-2 gap-3">
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
                    class="py-3 rounded-xl border border-[var(--color-border)] font-semibold text-sm text-center text-[var(--color-text)] hover:border-brand-green transition-colors">
                    <?php esc_html_e( 'Clear All', 'pemu' ); ?>
                </a>
                <button @click="$store.ui.filtersOpen = false"
                    class="py-3 rounded-xl bg-brand-green text-white font-bold text-sm">
                    <?php esc_html_e( 'Apply', 'pemu' ); ?>
                </button>
            </div>
        </aside>
    </div>

    <?php do_action( 'woocommerce_after_main_content' ); ?>
</main>

<?php get_footer(); ?>
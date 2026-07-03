<?php
/**
 * WooCommerce — loop/pagination.php
 * Pemu override: styled Tailwind pagination.
 * @version 9.3.0
 *
 * Generates: <nav class="woocommerce-pagination">
 *              <ul class="page-numbers">
 *                <li><a class="page-numbers" ...>1</a></li>
 *              </ul>
 *            </nav>
 */
defined( 'ABSPATH' ) || exit;

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) return;

$big   = 999999999;
$pages = paginate_links( apply_filters( 'woocommerce_pagination_args', [
	'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format'    => '?paged=%#%',
	'current'   => max( 1, get_query_var( 'paged' ) ),
	'total'     => $wp_query->max_num_pages,
	'prev_text' => is_rtl() ? '→' : '←',
	'next_text' => is_rtl() ? '←' : '→',
	'type'      => 'plain',
	'end_size'  => 2,
	'mid_size'  => 2,
] ) );
?>
<nav class="woocommerce-pagination mt-10 mb-6" aria-label="<?php esc_attr_e( 'Product pagination', 'pemu' ); ?>">
	<ul class="page-numbers flex flex-wrap items-center justify-center gap-2 list-none m-0 p-0">
		<?php
		// Parse paginate_links output and wrap in <li> with styling
		if ( $pages ) {
			// Convert HTML string into a DOM-like format we can manipulate
			$pages = str_replace(
				[ '<a class="prev page-numbers"', '<a class="next page-numbers"', '<span aria-current="page"', '<a class="page-numbers"', '<span class="page-numbers dots"', '<span class="page-numbers current"' ],
				[
					'<li><a class="prev page-numbers inline-flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold text-sm hover:border-brand-green hover:text-brand-green hover:bg-brand-green/5 hover:scale-105 active:scale-95 transition-all duration-200 no-underline! shadow-sm"',
					'<li><a class="next page-numbers inline-flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold text-sm hover:border-brand-green hover:text-brand-green hover:bg-brand-green/5 hover:scale-105 active:scale-95 transition-all duration-200 no-underline! shadow-sm"',
					'<li aria-current="page"><span class="page-numbers current inline-flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-brand-green text-white! font-bold text-sm shadow-lg shadow-brand-green/30 ring-2 ring-brand-green/20"',
					'<li><a class="page-numbers inline-flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold text-sm hover:border-brand-green hover:text-brand-green hover:bg-brand-green/5 hover:scale-105 active:scale-95 transition-all duration-200 no-underline! shadow-sm"',
					'<li><span class="page-numbers dots inline-flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 text-slate-400 dark:text-slate-500 text-sm tracking-wider select-none"',
					'<li aria-current="page"><span class="page-numbers current inline-flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-brand-green text-white! font-bold text-sm shadow-lg shadow-brand-green/30 ring-2 ring-brand-green/20"',
				],
				$pages
			);
			// Close any <li> after each tag that doesn't have trailing </li>
			$pages = str_replace( '"></a>', '"></a></li>', $pages );
			$pages = str_replace( '"></span>', '"></span></li>', $pages );
			echo $pages; // phpcs:ignore
		}
		?>
	</ul>
</nav>

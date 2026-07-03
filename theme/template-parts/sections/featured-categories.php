<?php
/**
 * Template part: Featured Categories Grid
 */
defined( 'ABSPATH' ) || exit;

$categories = get_terms( [
	'taxonomy'   => 'product_cat',
	'hide_empty' => true,
	'parent'     => 0,
	'number'     => 6,
	'orderby'    => 'menu_order',
	'order'      => 'ASC',
	'exclude'    => [ get_option( 'default_product_cat' ) ],
] );

if ( empty( $categories ) || is_wp_error( $categories ) ) return;

$gradients = [
	'protein'     => 'from-emerald-500 to-brand-green',
	'pre-workout' => 'from-orange-500 to-red-500',
	'supplements-and-vitamins'    => 'from-amber-400 to-yellow-500',
	'wellness'    => 'from-brand-navy to-cyan-600',
	'body-enhancement-supplements'    => 'from-blue-500 to-indigo-600',
	'fat-burners' => 'from-pink-500 to-rose-600',
	'weight-control-supplements' => 'from-pink-500 to-rose-600',
	'default'     => 'from-brand-green to-brand-navy',
];
$emoji_map = [
	'protein'     => '🥛',
	'pre-workout' => '⚡',
	'supplements-and-vitamins'    => '💊',
	'wellness'    => '🌿',
	'body-enhancement-supplements'    => '💪',
	'fat-burners' => '🔥',
	'weight-control-supplements'=> '🏋️',
	'bcaa'        => '⚡',
	'default'     => '🧪',
];
?>

<section class="max-w-7xl mx-auto px-4 py-14 lg:py-20" aria-labelledby="categories-heading">
    <div class="flex items-end justify-between mb-8">
        <div>
            <p class="text-xs font-bold tracking-widest uppercase text-brand-green mb-2">
                <?php esc_html_e( 'Categories', 'pemu' ); ?></p>
            <h2 id="categories-heading"
                class="font-display font-extrabold text-3xl lg:text-4xl text-[#1a1a2e] dark:text-[#e8edf2] leading-tight">
                <?php esc_html_e( 'Shop by Category', 'pemu' ); ?>
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2">
                <?php esc_html_e( 'Built for results. Trusted by Kenya\'s strongest.', 'pemu' ); ?></p>
        </div>
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
            class="hidden sm:inline-flex items-center gap-1.5 text-brand-green font-semibold text-sm hover:underline">
            <?php esc_html_e( 'View all', 'pemu' ); ?>
            <?php echo pemu_icon( 'arrow-right', [ 'class' => 'w-4 h-4' ] ); ?>
        </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5">
        <?php
		$i = 0;
		foreach ( $categories as $cat ) :
			$slug      = $cat->slug;
			$gradient  = $gradients[ $slug ] ?? $gradients['default'];
			$emoji     = $emoji_map[ $slug ] ?? $emoji_map['default'];
			$count_txt = sprintf( _n( '%d product', '%d products', $cat->count, 'pemu' ), $cat->count );
			$cat_url   = get_term_link( $cat );
			if ( is_wp_error( $cat_url ) ) $cat_url = wc_get_page_permalink( 'shop' );
			$extra_class = ( 0 === $i && count( $categories ) >= 4 ) ? 'lg:col-span-2 lg:row-span-2' : '';
			$i++;
		?>
        <a href="<?php echo esc_url( $cat_url ); ?>"
            class="group relative aspect-[4/5] <?php echo esc_attr( $extra_class ); ?> rounded-2xl overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 focus-visible:ring-2 focus-visible:ring-brand-green focus-visible:outline-none">

            <!-- Gradient background -->
            <div
                class="absolute inset-0 bg-gradient-to-br <?php echo esc_attr( $gradient ); ?> transition-transform duration-500 group-hover:scale-105">
            </div>
            <!-- Darkening overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

            <!-- Category thumbnail image -->
            <?php
			$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
			if ( $thumbnail_id ) :
				echo wp_get_attachment_image( $thumbnail_id, 'pemu-category-thumb', false, [
					'class'   => 'absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-70 transition-opacity duration-300',
					'loading' => 'lazy',
					'alt'     => '',
				] );
			endif;
			?>

            <!-- Emoji decoration -->
            <div class="absolute top-4 right-4 text-4xl lg:text-5xl transition-transform duration-300 group-hover:scale-110 select-none"
                aria-hidden="true">
                <?php echo esc_html( $emoji ); ?>
            </div>

            <!-- Text content -->
            <div class="absolute bottom-0 left-0 right-0 p-4 lg:p-5 text-white">
                <p class="text-[11px] font-semibold uppercase tracking-wider opacity-80 leading-none">
                    <?php echo esc_html( $count_txt ); ?>
                </p>
                <h3 class="font-display font-bold text-xl mt-1 leading-tight text-white">
                    <?php echo esc_html( $cat->name ); ?>
                </h3>
                <span
                    class="inline-flex items-center gap-1 mt-2 text-xs font-semibold opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-200">
                    <?php esc_html_e( 'Shop now', 'pemu' ); ?>
                    <?php echo pemu_icon( 'arrow-right', [ 'class' => 'w-3.5 h-3.5' ] ); ?>
                </span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>

    <div class="mt-6 flex justify-center sm:hidden">
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
            class="inline-flex items-center gap-1.5 text-brand-green font-semibold text-sm hover:underline">
            <?php esc_html_e( 'Browse all categories', 'pemu' ); ?>
            <?php echo pemu_icon( 'arrow-right', [ 'class' => 'w-4 h-4' ] ); ?>
        </a>
    </div>
</section>

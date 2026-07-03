<?php
/**
 * WooCommerce single-product/product-image.php — Pemu override
 * @version 10.5.0
 */
defined('ABSPATH') || exit;
global $product;

$post_thumbnail_id = $product->get_image_id();
$attachment_ids    = $product->get_gallery_image_ids();
$all_ids           = array_filter(array_merge([$post_thumbnail_id], $attachment_ids));
$img_count         = count($all_ids);
$large_size        = apply_filters('woocommerce_single_product_large_image_size', 'woocommerce_single');
$thumb_size        = apply_filters('woocommerce_product_thumbnails_image_size', 'woocommerce_thumbnail');
$columns           = apply_filters('woocommerce_product_thumbnails_columns', 4);

$wrapper_classes = apply_filters('woocommerce_product_gallery_classes', array_filter([
    'woocommerce-product-gallery',
    'woocommerce-product-gallery--' . ($post_thumbnail_id ? 'with-images' : 'without-images'),
    'woocommerce-product-gallery--columns-' . absint($columns),
    'images',
]));

$images = [];
foreach ($all_ids as $att_id) {
    $large = wp_get_attachment_image_src($att_id, 'full');
    $med   = wp_get_attachment_image_src($att_id, $large_size);
    $thumb = wp_get_attachment_image_src($att_id, $thumb_size);
    if (!$large) continue;
    $images[] = [
        'id'         => $att_id,
        'alt'        => trim(wp_strip_all_tags(get_post_meta($att_id, '_wp_attachment_image_alt', true))) ?: $product->get_name(),
        'caption'    => wp_get_attachment_caption($att_id) ?: '',
        'large_url'  => $large[0],
        'large_w'    => $large[1],
        'large_h'    => $large[2],
        'medium_url' => $med   ? $med[0]   : $large[0],
        'thumb_url'  => $thumb ? $thumb[0] : $large[0],
        'srcset'     => wp_get_attachment_image_srcset($att_id, $large_size) ?: '',
        'sizes'      => wp_get_attachment_image_sizes($att_id, $large_size)  ?: '',
    ];
}
$placeholder = wc_placeholder_img_src($large_size);
?>

<?php do_action('woocommerce_before_single_product_images'); ?>

<div class="<?php echo esc_attr(implode(' ', $wrapper_classes)); ?>" data-columns="<?php echo esc_attr($columns); ?>"
    x-data="pemuGallery({totalImages: <?php echo (int)$img_count; ?>})" role="region"
    aria-label="Product images">
    <?php do_action('woocommerce_product_gallery_zoom'); ?>

    <!-- ── MAIN IMAGE ── -->
    <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-gray-100 dark:from-slate-800 to-white dark:to-slate-900 aspect-square max-h-[520px] flex items-center justify-center">

        <?php if ($img_count > 1): ?>
        <!-- Prev arrow -->
        <button type="button"
            class="absolute left-2.5 top-1/2 -translate-y-1/2 z-10 w-9 h-9 rounded-full flex items-center justify-center bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 shadow-md hover:bg-brand-green hover:border-brand-green hover:text-white transition-all duration-150"
            @click.prevent="prev()" aria-label="Previous image">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M15 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
        <!-- Next arrow -->
        <button type="button"
            class="absolute right-2.5 top-1/2 -translate-y-1/2 z-10 w-9 h-9 rounded-full flex items-center justify-center bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 shadow-md hover:bg-brand-green hover:border-brand-green hover:text-white transition-all duration-150"
            @click.prevent="next()" aria-label="Next image">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
        <?php endif; ?>

        <?php if (!empty($images)): ?>
        <?php foreach ($images as $idx => $img): ?>
        <div class="absolute inset-0 flex items-center justify-center" x-show="activeIndex === <?php echo (int)$idx; ?>"
            x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            @touchstart.passive="touchStartX=$event.touches[0].clientX; touchStartY=$event.touches[0].clientY"
            @touchend.passive="handleSwipe($event)" role="group"
            aria-label="Image <?php echo $idx + 1; ?> of <?php echo $img_count; ?>">
            <div class="flex items-center justify-center w-full h-full">
                <img src="<?php echo esc_url($img['medium_url']); ?>"
                    class="max-w-[86%] max-h-[86%] w-auto h-auto object-contain transition-transform duration-400 drop-shadow-lg hover:scale-105"
                    alt="<?php echo esc_attr($img['alt']); ?>"
                    title="<?php echo esc_attr($img['caption'] ?: $img['alt']); ?>"
                    loading="<?php echo $idx === 0 ? 'eager' : 'lazy'; ?>" decoding="async"
                    srcset="<?php echo esc_attr($img['srcset']); ?>" sizes="<?php echo esc_attr($img['sizes']); ?>"
                    data-large_image="<?php echo esc_url($img['large_url']); ?>"
                    data-large_image_width="<?php echo (int)$img['large_w']; ?>"
                    data-large_image_height="<?php echo (int)$img['large_h']; ?>" draggable="false">
            </div>
            <?php if ($img['caption']): ?>
            <p
                class="absolute bottom-0 left-0 right-0 m-0 px-4 py-2 text-xs italic text-white bg-gradient-to-t from-black/50 to-transparent rounded-b-2xl pointer-events-none">
                <?php echo esc_html($img['caption']); ?>
            </p>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <img src="<?php echo esc_url($placeholder); ?>" alt="Product placeholder" loading="lazy"
            class="max-w-[86%] max-h-[86%] object-contain mx-auto">
        <?php endif; ?>

        <!-- Dot indicators (mobile only) -->
        <?php if ($img_count > 1): ?>
        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex items-center gap-1.5 sm:hidden" role="tablist">
            <?php for ($d = 0; $d < $img_count; $d++): ?>
            <button type="button"
                class="w-2 h-2 rounded-full border-none p-0 cursor-pointer transition-all duration-200"
                :class="activeIndex === <?php echo $d; ?> ? 'bg-brand-green scale-125' : 'bg-slate-200 dark:bg-slate-700'"
                @click="goTo(<?php echo $d; ?>)" role="tab" :aria-selected="activeIndex === <?php echo $d; ?>"
                aria-label="Image <?php echo $d + 1; ?>"></button>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- ── THUMBNAIL GRID ── -->
    <?php if (!empty($images) && $img_count > 1): ?>
    <div class="mt-3 grid grid-cols-4 gap-2" role="list">
        <ol class="flex-control-nav flex-control-thumbs sr-only" aria-hidden="true">
            <?php foreach ($images as $idx => $img): ?>
            <li><img src="<?php echo esc_url($img['thumb_url']); ?>" data-id="<?php echo esc_attr($img['id']); ?>"
                    class="<?php echo $idx === 0 ? 'flex-active' : ''; ?>" alt="<?php echo esc_attr($img['alt']); ?>">
            </li>
            <?php endforeach; ?>
        </ol>

        <?php foreach ($images as $idx => $img): ?>
        <button type="button"
            class="aspect-square rounded-xl overflow-hidden border-2 transition-all duration-150 bg-gray-100 dark:bg-slate-800 hover:border-brand-green focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-green"
            :class="activeIndex === <?php echo (int)$idx; ?> ? 'border-brand-green ring-2 ring-brand-green/20' : 'border-slate-200 dark:border-slate-700'"
            @click="goTo(<?php echo (int)$idx; ?>)" role="listitem"
            :aria-pressed="(activeIndex === <?php echo (int)$idx; ?>).toString()"
            aria-label="View image <?php echo $idx + 1; ?>">
            <img src="<?php echo esc_url($img['thumb_url']); ?>"
                class="w-full h-full object-contain transition-transform duration-300 hover:scale-105" loading="lazy"
                alt="<?php echo esc_attr($img['alt']); ?>">
        </button>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- <?php do_action('woocommerce_product_thumbnails'); ?> -->

</div>

<?php do_action('woocommerce_after_single_product_images'); ?>

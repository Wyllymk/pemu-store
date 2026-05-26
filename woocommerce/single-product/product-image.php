<?php
defined( 'ABSPATH' ) || exit;

global $product;

$main_image_id = $product->get_image_id();
$gallery_ids   = $product->get_gallery_image_ids();

$images = [];

if ( $main_image_id ) {
    $images[] = $main_image_id;
}

if ( ! empty( $gallery_ids ) ) {
    $images = array_merge( $images, $gallery_ids );
}
?>

<div x-data="{
        active: 0,
        images: <?php echo esc_attr( wp_json_encode( array_map( function( $id ) {
            return [
                'full'  => wp_get_attachment_image_url( $id, 'full' ),
                'large' => wp_get_attachment_image_url( $id, 'large' ),
                'thumb' => wp_get_attachment_image_url( $id, 'thumbnail' ),
                'alt'   => get_post_meta( $id, '_wp_attachment_image_alt', true ),
            ];
        }, $images ) ) ); ?>
    }" class="flex flex-col gap-4">

    <!-- Main Image -->
    <div class="overflow-hidden rounded-3xl bg-zinc-100 aspect-square">

        <img :src="images[active].large" :alt="images[active].alt" class="h-full w-full object-cover">

    </div>

    <!-- Thumbnails -->
    <div class="grid grid-cols-4 gap-3">

        <template x-for="(image, index) in images" :key="index">

            <button @click="active = index" class="overflow-hidden rounded-2xl border-2 transition-all" :class="active === index
                    ? 'border-black'
                    : 'border-transparent opacity-70 hover:opacity-100'">

                <img :src="image.thumb" :alt="image.alt" class="aspect-square w-full object-cover">

            </button>

        </template>

    </div>

</div>
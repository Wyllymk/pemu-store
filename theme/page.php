<?php
/**
 * Pemu Health Supplements — page.php
 */
defined( 'ABSPATH' ) || exit;
get_header(); ?>
<main id="main-content" class="min-h-screen">
    <?php while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if ( has_post_thumbnail() ) : ?>
        <div class="rounded-2xl overflow-hidden mb-8 aspect-[16/7]">
            <?php the_post_thumbnail( 'full', [ 'class' => 'w-full h-full object-cover', 'loading' => 'eager' ] ); ?>
        </div>
        <?php endif; ?>
        <div
            class="prose prose-lg max-w-none [&_h2]:font-display [&_h2]:font-bold [&_a]:text-brand-green [&_a]:hover:underline leading-relaxed">
            <?php the_content(); ?>
        </div>
        <?php wp_link_pages(); ?>
    </article>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>
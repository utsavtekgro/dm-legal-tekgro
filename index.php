<?php
/**
 * Fallback template of last resort — required minimum theme file. Used
 * whenever no more specific template (front-page/single/archive/page)
 * matches the current request.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="content-width content-gapping">
	<?php if ( have_posts() ) : ?>
		<div class="blog-grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/blog-card' ); ?>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p class="no-results"><?php esc_html_e( 'Nothing found.', 'dmlegal' ); ?></p>
	<?php endif; ?>
</section>

<?php get_footer(); ?>

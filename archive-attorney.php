<?php
/**
 * Attorneys archive/listing (team page).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/hero', null, [
	'title'      => __( 'Meet the Experts Who Fought and Won', 'dmlegal' ),
	'subtitle'   => __( 'Our team of experienced lawyers is dedicated to providing comprehensive assistance and support.', 'dmlegal' ),
	'right_side' => 'none',
	'breadcrumb' => [ [ 'label' => __( 'Attorneys', 'dmlegal' ) ] ],
] );
?>

<section class="content-width content-gapping">
	<?php if ( have_posts() ) : ?>
		<div class="experts-grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/attorney-card' ); ?>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p class="no-results"><?php esc_html_e( 'No attorneys found.', 'dmlegal' ); ?></p>
	<?php endif; ?>
</section>

<?php get_footer(); ?>

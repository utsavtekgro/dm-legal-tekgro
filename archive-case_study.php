<?php
/**
 * Case Studies archive/listing.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/hero', null, [
	'title'      => __( 'Explore, Learn, and Grow – Your Journey Starts Here', 'dmlegal' ),
	'subtitle'   => __( 'With a proven track record of dismissed charges and reduced penalties, we defend your rights.', 'dmlegal' ),
	'features'   => [ __( 'Expert Legal Guidance', 'dmlegal' ), __( 'Tailored Legal Solutions', 'dmlegal' ), __( 'Free Initial Consultation', 'dmlegal' ), __( 'Fast & Efficient Process', 'dmlegal' ) ],
	'primary_btn' => [ 'text' => __( 'Explore more', 'dmlegal' ), 'url' => home_url( '/' ) ],
	'right_side' => 'image',
	'image'      => DMLEGAL_URI . '/assets/images/case-studies-bgimg.png',
	'breadcrumb' => [ [ 'label' => __( 'Case Studies', 'dmlegal' ) ] ],
] );
?>

<section class="content-width content-gapping">
	<div class="section-heading">
		<h2 class="secondary-header"><?php esc_html_e( 'Examples of how we’ve supported clients', 'dmlegal' ); ?></h2>
	</div>

	<?php if ( have_posts() ) : ?>
		<div class="services-grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/case-study-card' ); ?>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p class="no-results"><?php esc_html_e( 'No case studies found.', 'dmlegal' ); ?></p>
	<?php endif; ?>
</section>

<?php get_footer(); ?>

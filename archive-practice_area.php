<?php
/**
 * Practice Areas archive — lists only top-level areas (inner services are
 * shown within their parent's page, not in this top-level listing).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/hero', null, [
	'title'      => __( 'Protect Your Financial Future at an Affordable, Transparent Cost with Our Fixed Fees', 'dmlegal' ),
	'subtitle'   => __( 'With a proven track record of dismissed charges and reduced penalties, we defend your rights.', 'dmlegal' ),
	'features'   => [ __( 'Fixed Fees', 'dmlegal' ), __( 'Hourly rates', 'dmlegal' ), __( 'Manage Legal Costs', 'dmlegal' ), __( 'No Win, No Fees', 'dmlegal' ) ],
	'primary_btn' => [ 'text' => __( 'Book free consultation', 'dmlegal' ), 'url' => dmlegal_get_page_url( 'book-a-lawyer' ) ],
	'secondary_btn' => [ 'text' => __( 'Explore more', 'dmlegal' ), 'url' => home_url( '/' ) ],
	'right_side' => 'image',
	'image'      => DMLEGAL_URI . '/assets/images/practicearea-img.png',
	'breadcrumb' => [ [ 'label' => __( 'Practice Area', 'dmlegal' ) ] ],
] );

$top_level_areas = new WP_Query( [
	'post_type'      => 'practice_area',
	'post_parent'    => 0,
	'posts_per_page' => -1,
	'orderby'        => 'menu_order title',
	'order'          => 'ASC',
] );
?>

<section class="content-width content-gapping">
	<div class="section-heading">
		<h2 class="secondary-header"><?php esc_html_e( 'Our Practice Areas', 'dmlegal' ); ?></h2>
		<p class="body-text"><?php esc_html_e( 'Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.', 'dmlegal' ); ?></p>
	</div>
	<?php if ( $top_level_areas->have_posts() ) : ?>
		<div class="services-grid">
			<?php while ( $top_level_areas->have_posts() ) : $top_level_areas->the_post(); ?>
				<?php get_template_part( 'template-parts/practice-area-card' ); ?>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	<?php endif; ?>
</section>

<?php get_footer(); ?>

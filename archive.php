<?php
/**
 * Blog listing (native WP posts). Filtering is done via native category
 * archive links rather than the legacy client-side JS filter/search —
 * simpler, works without JS, and doesn't require loading every post into
 * the DOM up front. Pagination is native (the_posts_pagination()).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/hero', null, [
	'title'       => __( 'Explore, Learn, and Grow – Your Journey Starts Here', 'dmlegal' ),
	'subtitle'    => __( 'With a proven track record of dismissed charges and reduced penalties, we defend your rights.', 'dmlegal' ),
	'features'    => [ __( 'Expert Legal Guidance', 'dmlegal' ), __( 'Tailored Legal Solutions', 'dmlegal' ), __( 'Free Initial Consultation', 'dmlegal' ), __( 'Fast & Efficient Process', 'dmlegal' ) ],
	'primary_btn' => [ 'text' => __( 'Explore more', 'dmlegal' ), 'url' => home_url( '/' ) ],
	'right_side'  => 'image',
	'image'       => DMLEGAL_URI . '/assets/images/blogheroimg.png',
	'breadcrumb'  => [ [ 'label' => __( 'Blogs', 'dmlegal' ) ] ],
] );

$categories = get_categories( [ 'hide_empty' => true ] );
?>

<section class="content-width content-gapping">
	<?php if ( $categories ) : ?>
		<div class="blog-toolbar">
			<div class="blog-toolbar__categories">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" class="<?php echo ( is_home() && ! is_category() ) ? 'is-active' : ''; ?>"><?php esc_html_e( 'All Information', 'dmlegal' ); ?></a>
				<?php foreach ( $categories as $category ) : ?>
					<a href="<?php echo esc_url( get_category_link( $category ) ); ?>" class="<?php echo is_category( $category->term_id ) ? 'is-active' : ''; ?>"><?php echo esc_html( $category->name ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<div class="blog-grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/blog-card' ); ?>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p class="no-results"><?php esc_html_e( 'No blog posts found.', 'dmlegal' ); ?></p>
	<?php endif; ?>
</section>

<?php get_footer(); ?>

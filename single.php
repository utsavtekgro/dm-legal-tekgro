<?php
/**
 * Blog post single (native WP posts).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/hero', null, [
		'title'      => get_the_title(),
		'minimal'    => true,
		'breadcrumb' => [
			[ 'label' => __( 'Blogs', 'dmlegal' ), 'url' => get_post_type_archive_link( 'post' ) ],
			[ 'label' => get_the_title() ],
		],
	] );
	?>
	<div class="content-width page-section blog-detail-grid">
		<article>
			<header class="blog-article__author">
				<div class="blog-article__author-row">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 60 ); ?>
					<div>
						<h4 class="fw-600"><?php the_author(); ?></h4>
					</div>
				</div>
				<div class="blog-article__meta">
					<span><?php echo esc_html( sprintf( __( 'Posted on %s', 'dmlegal' ), get_the_date() ) ); ?></span>
				</div>
			</header>

			<div class="body-text text-justify"><?php the_content(); ?></div>
		</article>

		<aside>
			<?php get_template_part( 'template-parts/sidebar-talk-to-expert' ); ?>
		</aside>
	</div>
	<?php
endwhile;

get_footer();

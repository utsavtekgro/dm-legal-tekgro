<?php
/**
 * Archive template (category, tag, author, date, CPT).
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="site-main" role="main">
	<div class="site-main__inner">
		<?php if ( have_posts() ) : ?>
			<header class="page-header">
				<?php the_archive_title( '<h1 class="page-header__title">', '</h1>' ); ?>
				<?php the_archive_description( '<div class="page-header__desc">', '</div>' ); ?>
			</header>

			<div class="post-list">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', get_post_type() );
				endwhile;
				?>
			</div>

			<?php
			the_posts_pagination(
				array(
					'prev_text'  => esc_html__( 'Previous', 'dm-legal' ),
					'next_text'  => esc_html__( 'Next', 'dm-legal' ),
					'aria_label' => esc_html__( 'Posts', 'dm-legal' ),
				)
			);
			?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>
	</div>
</main>

<?php
get_sidebar();
get_footer();

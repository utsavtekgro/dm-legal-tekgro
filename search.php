<?php
/**
 * Search results template.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="site-main" role="main">
	<div class="site-main__inner">
		<header class="page-header">
			<h1 class="page-header__title">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search results for: %s', 'dm-legal' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
				?>
			</h1>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="post-list">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'search' );
				endwhile;
				?>
			</div>

			<?php
			the_posts_pagination(
				array(
					'prev_text'  => esc_html__( 'Previous', 'dm-legal' ),
					'next_text'  => esc_html__( 'Next', 'dm-legal' ),
					'aria_label' => esc_html__( 'Search results', 'dm-legal' ),
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

<?php
/**
 * The main template file — the fallback for all queries.
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

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header class="page-header">
					<h1 class="page-header__title"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

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
					'mid_size'           => 1,
					'prev_text'          => esc_html__( 'Previous', 'dm-legal' ),
					'next_text'          => esc_html__( 'Next', 'dm-legal' ),
					'screen_reader_text' => esc_html__( 'Posts navigation', 'dm-legal' ),
					'aria_label'         => esc_html__( 'Posts', 'dm-legal' ),
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

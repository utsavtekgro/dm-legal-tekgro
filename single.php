<?php
/**
 * Single post template.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="site-main" role="main">
	<div class="site-main__inner">
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'single' );

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous', 'dm-legal' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next', 'dm-legal' ) . '</span> <span class="nav-title">%title</span>',
					'aria_label' => esc_html__( 'Posts', 'dm-legal' ),
				)
			);

			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		endwhile;
		?>
	</div>
</main>

<?php
get_sidebar();
get_footer();

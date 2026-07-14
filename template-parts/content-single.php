<?php
/**
 * Single post content part.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry--single' ); ?>>
	<header class="entry__header">
		<?php the_title( '<h1 class="entry__title">', '</h1>' ); ?>
		<div class="entry__meta">
			<?php
			dm_legal_posted_on();
			dm_legal_posted_by();
			?>
		</div>
	</header>

	<?php dm_legal_post_thumbnail( 'dm-legal-wide', true ); ?>

	<div class="entry__content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'dm-legal' ) . '">',
				'after'  => '</nav>',
			)
		);
		?>
	</div>

	<footer class="entry__footer">
		<?php dm_legal_entry_footer(); ?>
	</footer>
</article>

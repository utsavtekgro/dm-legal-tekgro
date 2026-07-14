<?php
/**
 * Default post content part (list/archive view).
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry--list' ); ?>>
	<?php dm_legal_post_thumbnail( 'dm-legal-card', false ); ?>

	<div class="entry__body">
		<header class="entry__header">
			<?php the_title( sprintf( '<h2 class="entry__title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			<div class="entry__meta">
				<?php
				dm_legal_posted_on();
				dm_legal_posted_by();
				?>
			</div>
		</header>

		<div class="entry__excerpt">
			<?php the_excerpt(); ?>
		</div>

		<footer class="entry__footer">
			<?php dm_legal_read_more(); ?>
		</footer>
	</div>
</article>

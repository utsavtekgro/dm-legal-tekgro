<?php
/**
 * Compact card used in grids (front page "journal" strip).
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
	<?php dm_legal_post_thumbnail( 'dm-legal-card', false ); ?>
	<div class="card__body">
		<?php the_title( sprintf( '<h3 class="card__title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
		<p class="card__meta"><?php echo esc_html( get_the_date() ); ?></p>
	</div>
</article>

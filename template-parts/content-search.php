<?php
/**
 * Search result content part.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry--search' ); ?>>
	<header class="entry__header">
		<?php the_title( sprintf( '<h2 class="entry__title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<div class="entry__meta"><?php echo esc_html( get_the_date() ); ?></div>
	</header>
	<div class="entry__excerpt"><?php the_excerpt(); ?></div>
</article>

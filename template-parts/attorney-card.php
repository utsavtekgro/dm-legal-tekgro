<?php
/**
 * Attorney card. Reads from global $post — call inside The Loop with:
 * get_template_part( 'template-parts/attorney-card' );
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$role = get_post_meta( get_the_ID(), '_at_role', true );
$stat = get_post_meta( get_the_ID(), '_at_stat', true );
?>
<div class="card-attorney">
	<div class="card-attorney__media">
		<a href="<?php the_permalink(); ?>">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'attorney-photo', array_merge( [ 'loading' => 'lazy', 'decoding' => 'async' ], dmlegal_thumbnail_alt_args( get_the_title() ) ) ); ?>
			<?php endif; ?>
		</a>
	</div>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<?php if ( $role ) : ?><p class="card-attorney__role"><?php echo esc_html( $role ); ?></p><?php endif; ?>
	<?php if ( $stat ) : ?><p class="card-attorney__stat"><?php echo esc_html( $stat ); ?></p><?php endif; ?>
</div>

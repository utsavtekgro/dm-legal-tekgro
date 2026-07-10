<?php
/**
 * Practice area card (used on the archive/listing view). Call inside The
 * Loop with: get_template_part( 'template-parts/practice-area-card' );
 * Reads from global $post — this is a current-page-loop template part,
 * not a fixed-source one.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$short_description = get_post_meta( get_the_ID(), '_pa_short_description', true );
?>
<div class="card-law">
	<div class="card-law__media">
		<a href="<?php the_permalink(); ?>">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'practice-area-card', array_merge( [ 'loading' => 'lazy', 'decoding' => 'async' ], dmlegal_thumbnail_alt_args( get_the_title() ) ) ); ?>
			<?php endif; ?>
		</a>
	</div>
	<div class="card-law__body">
		<div>
			<h3><?php the_title(); ?></h3>
			<?php if ( $short_description ) : ?>
				<p><?php echo esc_html( wp_trim_words( $short_description, 12 ) ); ?></p>
			<?php endif; ?>
		</div>
		<a class="card-law__link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'dmlegal' ); ?> &rsaquo;</a>
	</div>
</div>

<?php
/**
 * Case study card (archive/listing view). Reads from global $post — call
 * inside The Loop with: get_template_part( 'template-parts/case-study-card' );
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tags = get_the_terms( get_the_ID(), 'case_study_tag' );
$tags = is_array( $tags ) ? $tags : [];
?>
<div class="card-case">
	<div class="card-case__media">
		<a href="<?php the_permalink(); ?>">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'case-study-card', array_merge( [ 'loading' => 'lazy', 'decoding' => 'async' ], dmlegal_thumbnail_alt_args( get_the_title() ) ) ); ?>
			<?php endif; ?>
		</a>
	</div>
	<?php if ( $tags ) : ?>
		<div class="card-case__tags">
			<?php foreach ( $tags as $tag ) : ?><span><?php echo esc_html( $tag->name ); ?></span><?php endforeach; ?>
		</div>
	<?php endif; ?>
	<h3><?php echo esc_html( wp_trim_words( get_the_title(), 6 ) ); ?></h3>
	<?php if ( get_the_excerpt() ) : ?>
		<p class="excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
	<?php endif; ?>
	<div class="card-case__link"><a href="<?php the_permalink(); ?>"><?php esc_html_e( 'More Info', 'dmlegal' ); ?> &rsaquo;</a></div>
</div>

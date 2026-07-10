<?php
/**
 * Blog post card. Reads from global $post — call inside The Loop with:
 * get_template_part( 'template-parts/blog-card' );
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$categories = get_the_category();
?>
<div class="card-blog">
	<div class="card-blog__media">
		<a href="<?php the_permalink(); ?>">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'blog-thumbnail', array_merge( [ 'loading' => 'lazy', 'decoding' => 'async' ], dmlegal_thumbnail_alt_args( get_the_title() ) ) ); ?>
			<?php endif; ?>
		</a>
	</div>
	<div class="card-blog__meta">
		<div class="card-blog__author">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
			<div>
				<p><?php the_author(); ?></p>
				<p><?php echo esc_html( get_the_date() ); ?></p>
			</div>
		</div>
		<?php if ( $categories ) : ?>
			<div class="card-blog__tags">
				<?php foreach ( $categories as $category ) : ?><span><?php echo esc_html( $category->name ); ?></span><?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<p class="excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
	<div class="card-blog__link"><a href="<?php the_permalink(); ?>"><?php esc_html_e( 'More Info', 'dmlegal' ); ?> &rsaquo;</a></div>
</div>

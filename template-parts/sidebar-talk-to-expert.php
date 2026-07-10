<?php
/**
 * "Talk to an Expert" sidebar card, reused on practice-area inner pages,
 * case study/blog detail pages, and Contact. Shows up to 6 attorneys (by
 * featured image) plus quick Book Now / call actions. Not tied to
 * global $post — pulls its own small attorney query.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$attorneys = get_posts( [
	'post_type'      => 'attorney',
	'posts_per_page' => 6,
	'orderby'        => 'menu_order date',
	'order'          => 'ASC',
] );

$phone_tel  = dmlegal_get_setting( 'phone_tel' );
$phone_disp = dmlegal_get_setting( 'phone_display' );
$book_url   = dmlegal_get_page_url( 'book-a-lawyer' );
?>
<div class="sidebar-card">
	<h2 class="secondary-header"><?php esc_html_e( 'Talk to an Expert', 'dmlegal' ); ?></h2>
	<?php if ( $attorneys ) : ?>
		<div class="sidebar-card__experts">
			<?php foreach ( $attorneys as $attorney ) : ?>
				<?php if ( has_post_thumbnail( $attorney ) ) : ?>
					<?php echo get_the_post_thumbnail( $attorney, 'thumbnail', array_merge( [ 'loading' => 'lazy', 'decoding' => 'async' ], dmlegal_thumbnail_alt_args( get_the_title( $attorney ) ) ) ); ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<div class="sidebar-card__buttons">
		<a class="btn btn-primary btn-full" href="<?php echo esc_url( $book_url ); ?>"><?php esc_html_e( 'Book Now', 'dmlegal' ); ?></a>
		<?php if ( $phone_tel ) : ?>
			<a class="btn btn-secondary btn-full" href="tel:<?php echo esc_attr( $phone_tel ); ?>"><?php echo esc_html( $phone_disp ); ?></a>
		<?php endif; ?>
	</div>
</div>

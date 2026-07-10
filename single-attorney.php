<?php
/**
 * Attorney single template. Reads from global $post.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

global $post;

$role        = get_post_meta( $post->ID, '_at_role', true );
$stat        = get_post_meta( $post->ID, '_at_stat', true );
$credentials = get_post_meta( $post->ID, '_at_credentials', true );
$credentials = is_array( $credentials ) ? wp_list_pluck( $credentials, 'credential' ) : [];
$credentials = array_filter( $credentials );

get_template_part( 'template-parts/hero', null, [
	'title'      => get_the_title(),
	'subtitle'   => $role,
	'minimal'    => true,
	'breadcrumb' => [
		[ 'label' => __( 'Attorneys', 'dmlegal' ), 'url' => get_post_type_archive_link( 'attorney' ) ],
		[ 'label' => get_the_title() ],
	],
] );
?>

<div class="content-width stack-grid">
	<div class="blog-detail-grid">
		<article>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="attorney-photo">
					<?php the_post_thumbnail( 'attorney-photo', array_merge( [ 'loading' => 'eager', 'decoding' => 'async' ], dmlegal_thumbnail_alt_args( get_the_title() ) ) ); ?>
				</div>
			<?php endif; ?>

			<?php if ( $role ) : ?><p class="card-attorney__role"><?php echo esc_html( $role ); ?></p><?php endif; ?>
			<?php if ( $stat ) : ?><p class="card-attorney__stat"><?php echo esc_html( $stat ); ?></p><?php endif; ?>

			<?php if ( get_the_content() ) : ?>
				<div class="body-text"><?php the_content(); ?></div>
			<?php endif; ?>

			<?php if ( $credentials ) : ?>
				<h2 class="secondary-header"><?php esc_html_e( 'Credentials', 'dmlegal' ); ?></h2>
				<ul>
					<?php foreach ( $credentials as $credential ) : ?>
						<li><img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/tick.svg' ); ?>" alt="" width="20" height="20"><span><?php echo esc_html( $credential ); ?></span></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</article>

		<aside>
			<div class="sidebar-card">
				<h2 class="secondary-header"><?php esc_html_e( 'Book a Consultation', 'dmlegal' ); ?></h2>
				<div class="sidebar-card__buttons">
					<a class="btn btn-primary btn-full" href="<?php echo esc_url( dmlegal_get_page_url( 'book-a-lawyer' ) ); ?>"><?php esc_html_e( 'Book Now', 'dmlegal' ); ?></a>
					<?php $phone_tel = dmlegal_get_setting( 'phone_tel' ); ?>
					<?php if ( $phone_tel ) : ?>
						<a class="btn btn-secondary btn-full" href="tel:<?php echo esc_attr( $phone_tel ); ?>"><?php echo esc_html( dmlegal_get_setting( 'phone_display' ) ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</aside>
	</div>
</div>

<?php get_footer(); ?>

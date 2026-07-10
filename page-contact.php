<?php
/**
 * Contact page — auto-selected by WordPress for the Page with slug
 * "contact" (page-{slug}.php convention, no manual template assignment
 * needed). Reads from global $post.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

global $post;

get_template_part( 'template-parts/hero', null, [
	'title'       => __( 'Get in Touch Today for Clear, Trusted, and Professional Legal Guidance', 'dmlegal' ),
	'subtitle'    => __( 'With a proven track record of dismissed charges and reduced penalties, we defend your rights.', 'dmlegal' ),
	'features'    => [ __( 'Fixed Fees', 'dmlegal' ), __( 'Hourly rates', 'dmlegal' ), __( 'Manage Legal Costs', 'dmlegal' ), __( 'No Win, No Fees', 'dmlegal' ) ],
	'primary_btn' => [ 'text' => __( 'Book free consultation', 'dmlegal' ), 'url' => dmlegal_get_page_url( 'book-a-lawyer' ) ],
	'secondary_btn' => [ 'text' => __( 'Explore more', 'dmlegal' ), 'url' => home_url( '/' ) ],
	'right_side'  => 'form',
	'breadcrumb'  => [ [ 'label' => __( 'Contact', 'dmlegal' ) ] ],
] );

$office_name    = dmlegal_get_setting( 'address_short' );
$office_address = dmlegal_get_setting( 'address_full' );
$phone_tel      = dmlegal_get_setting( 'phone_tel' );
$phone_disp     = dmlegal_get_setting( 'phone_display' );
$email          = dmlegal_get_setting( 'email' );
$hours          = dmlegal_get_setting( 'office_hours' );
$maps_url       = dmlegal_get_setting( 'maps_url' );
$map_embed      = dmlegal_get_setting( 'map_embed_url' );
$facebook       = dmlegal_get_setting( 'facebook_url' );
$linkedin       = dmlegal_get_setting( 'linkedin_url' );
$instagram      = dmlegal_get_setting( 'instagram_url' );
$whatsapp       = dmlegal_get_setting( 'whatsapp_url' );
?>

<section class="content-width content-gapping contact-grid">
	<div>
		<div class="social-icons-row">
			<?php if ( $facebook ) : ?><a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/facebook.svg' ); ?>" alt="" width="18" height="18"></a><?php endif; ?>
			<?php if ( $linkedin ) : ?><a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/linkedin.svg' ); ?>" alt="" width="18" height="18"></a><?php endif; ?>
			<?php if ( $instagram ) : ?><a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/custominsta.svg' ); ?>" alt="" width="18" height="18"></a><?php endif; ?>
			<?php if ( $whatsapp ) : ?><a href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/whatsapp.svg' ); ?>" alt="" width="18" height="18"></a><?php endif; ?>
			<?php if ( $email ) : ?><a href="mailto:<?php echo esc_attr( $email ); ?>" aria-label="Email"><img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/email.svg' ); ?>" alt="" width="18" height="18"></a><?php endif; ?>
		</div>
		<?php get_template_part( 'template-parts/sidebar-talk-to-expert' ); ?>
	</div>

	<div class="office-info-card">
		<div class="office-info-card__panel">
			<?php if ( $office_name ) : ?><h3><?php echo esc_html( $office_name ); ?></h3><?php endif; ?>
			<address>
				<?php if ( $office_address ) : ?><span><?php echo esc_html( $office_address ); ?></span><?php endif; ?>
				<?php if ( $phone_tel ) : ?><a href="tel:<?php echo esc_attr( $phone_tel ); ?>" class="phone-link"><?php echo esc_html( $phone_disp ); ?></a><?php endif; ?>
				<?php if ( $email ) : ?><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a><?php endif; ?>
				<?php if ( $hours ) : ?><span><?php echo esc_html( $hours ); ?></span><?php endif; ?>
			</address>
			<?php if ( $maps_url ) : ?>
				<a class="btn btn-primary btn-full" href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Get Directions', 'dmlegal' ); ?></a>
			<?php endif; ?>
		</div>
		<?php if ( $map_embed ) : ?>
			<iframe class="office-info-card__map" src="<?php echo esc_url( $map_embed ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen title="<?php echo esc_attr( get_bloginfo( 'name' ) . ' office location' ); ?>"></iframe>
		<?php endif; ?>
	</div>
</section>

<?php if ( get_the_content() ) : ?>
	<section class="content-width page-section body-text"><?php the_content(); ?></section>
<?php endif; ?>

<?php get_footer(); ?>

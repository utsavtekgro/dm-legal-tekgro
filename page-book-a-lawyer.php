<?php
/**
 * Book a Lawyer page — auto-selected for the Page with slug
 * "book-a-lawyer". The 3-step UX (calendar + step panels) is preserved
 * per your decision; the actual form fields/submission are rendered by
 * dmlegal_render_contact_form( 'booking' ) from inc/cf7-integration.php
 * (Phase 4) so this template only owns the step-panel shell.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/hero', null, [
	'minimal' => true,
	'title'   => __( 'Book a Consultation', 'dmlegal' ),
	'breadcrumb' => [ [ 'label' => __( 'Book a Lawyer', 'dmlegal' ) ] ],
] );

$office_name = dmlegal_get_setting( 'address_short' );
$address     = dmlegal_get_setting( 'address_full' );
$phone_tel   = dmlegal_get_setting( 'phone_tel' );
$phone_disp  = dmlegal_get_setting( 'phone_display' );
$email       = dmlegal_get_setting( 'email' );
$hours       = dmlegal_get_setting( 'office_hours' );

$how_it_works = [
	__( 'Book a free 15 minute call to discuss the next process.', 'dmlegal' ),
	__( 'Book and attend an intake session (30 - 60 min).', 'dmlegal' ),
	__( 'We will invite the other party to attend their own intake session.', 'dmlegal' ),
	__( 'Attend a mediation (half day / full day).', 'dmlegal' ),
];
?>

<div class="content-width content-gapping">
	<div class="booking-grid">
		<div class="booking-contact">
			<div class="booking-contact__box">
				<h2><?php esc_html_e( 'Contacts', 'dmlegal' ); ?></h2>
				<div class="booking-contact__row">
					<img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/map.svg' ); ?>" alt="">
					<div>
						<?php if ( $office_name ) : ?><p><?php echo esc_html( $office_name ); ?></p><?php endif; ?>
						<?php if ( $address ) : ?><p><?php echo esc_html( $address ); ?></p><?php endif; ?>
					</div>
				</div>
				<?php if ( $phone_tel ) : ?><p><?php esc_html_e( 'Telephone:', 'dmlegal' ); ?> <a href="tel:<?php echo esc_attr( $phone_tel ); ?>"><?php echo esc_html( $phone_disp ); ?></a></p><?php endif; ?>
				<?php if ( $email ) : ?><p><?php esc_html_e( 'Email:', 'dmlegal' ); ?> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p><?php endif; ?>
				<?php if ( $hours ) : ?><p><?php esc_html_e( 'Office hour:', 'dmlegal' ); ?> <strong><?php echo esc_html( $hours ); ?></strong></p><?php endif; ?>
			</div>
			<div class="booking-steps">
				<h2 class="tag"><?php esc_html_e( 'Information', 'dmlegal' ); ?></h2>
				<h2 class="sub-heading"><?php esc_html_e( 'How it works?', 'dmlegal' ); ?></h2>
				<ol>
					<?php foreach ( $how_it_works as $step ) : ?>
						<li><img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/point-tick.svg' ); ?>" alt=""><p><?php echo esc_html( $step ); ?></p></li>
					<?php endforeach; ?>
				</ol>
			</div>
		</div>

		<div class="booking-form-panel" data-booking-form>
			<?php if ( function_exists( 'dmlegal_render_contact_form' ) ) {
				dmlegal_render_contact_form( 'booking' );
			} ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>

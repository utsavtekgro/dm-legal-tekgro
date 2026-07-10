<?php
/**
 * "Limited slots available" consultation-format CTA, reused verbatim
 * across practice-area, fixed-prices, etc. The consultation-format icons
 * are fixed presentational content (not per-page), so they're not backed
 * by a settings field — same as the original static site.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$options = [
	[ 'icon' => 'faceToface.svg', 'label' => __( 'Face to Face', 'dmlegal' ) ],
	[ 'icon' => 'google-meet.svg', 'label' => __( 'Google Meets', 'dmlegal' ) ],
	[ 'icon' => 'telephone.svg', 'label' => __( 'Telephone Call', 'dmlegal' ) ],
	[ 'icon' => 'zoom-icon.svg', 'label' => __( 'Zoom', 'dmlegal' ) ],
];
?>
<section class="attraction-contact">
	<div class="content-width attraction-contact__row">
		<h2 class="main-header attraction-contact__title"><?php esc_html_e( 'Limited slots available — Book your consultation now', 'dmlegal' ); ?></h2>
		<div class="attraction-contact__intro">
			<p class="measure-sm"><?php esc_html_e( 'You can choose any format of consultation with our lawyer:', 'dmlegal' ); ?></p>
			<div class="attraction-contact__options">
				<?php foreach ( $options as $option ) : ?>
					<div class="attraction-contact__option">
						<img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/' . $option['icon'] ); ?>" alt="">
						<p><?php echo esc_html( $option['label'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
			<a class="btn btn-primary" href="<?php echo esc_url( dmlegal_get_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Book a Consultation', 'dmlegal' ); ?></a>
		</div>
	</div>
</section>

<?php
/**
 * Secondary contact/map CTA shown above the footer on every page except
 * Contact. Reads entirely from the Global Settings option (inc/settings-global.php) —
 * no page context needed, so no global $post / $source_slug involved.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$address     = dmlegal_get_setting( 'address_short' );
$email       = dmlegal_get_setting( 'email' );
$phone_tel   = dmlegal_get_setting( 'phone_tel' );
$phone_disp  = dmlegal_get_setting( 'phone_display' );
$hours       = dmlegal_get_setting( 'office_hours' );
$maps_url    = dmlegal_get_setting( 'maps_url' );
$map_embed   = dmlegal_get_setting( 'map_embed_url' );
?>
<section class="page-section content-width contact-cta" aria-labelledby="contact-cta-heading">
	<div class="contact-cta__card">
		<h2 id="contact-cta-heading" class="sub-heading"><?php bloginfo( 'name' ); ?></h2>
		<address>
			<?php if ( $address ) : ?><p><strong><?php esc_html_e( 'Address:', 'dmlegal' ); ?></strong> <?php echo esc_html( $address ); ?></p><?php endif; ?>
			<?php if ( $email ) : ?><p><strong><?php esc_html_e( 'Email:', 'dmlegal' ); ?></strong> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p><?php endif; ?>
			<?php if ( $phone_tel ) : ?><p><strong><?php esc_html_e( 'Phone:', 'dmlegal' ); ?></strong> <a href="tel:<?php echo esc_attr( $phone_tel ); ?>"><?php echo esc_html( $phone_disp ?: $phone_tel ); ?></a></p><?php endif; ?>
			<?php if ( $hours ) : ?><p><strong><?php esc_html_e( 'Business Hours:', 'dmlegal' ); ?></strong> <?php echo esc_html( $hours ); ?></p><?php endif; ?>
		</address>
		<div class="form-grid-2">
			<?php if ( $maps_url ) : ?>
				<a class="btn btn-secondary" href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Get Directions', 'dmlegal' ); ?></a>
			<?php endif; ?>
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Check all contacts', 'dmlegal' ); ?></a>
		</div>
	</div>
	<?php if ( $map_embed ) : ?>
		<div class="contact-cta__map">
			<iframe class="map-frame" title="<?php echo esc_attr( get_bloginfo( 'name' ) . ' location on Google Maps' ); ?>"
				src="<?php echo esc_url( $map_embed ); ?>"
				loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
		</div>
	<?php endif; ?>
</section>

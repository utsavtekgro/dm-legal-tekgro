<?php
/**
 * Site footer + mobile bottom nav + closing scripts. Global contact/social
 * info comes from the Global Settings option; footer links come from the
 * 'footer' nav menu location.
 *
 * The legacy "under development" modal from the static site was dropped —
 * it was placeholder pre-launch messaging, not a real feature to carry
 * into production.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$whatsapp   = dmlegal_get_setting( 'whatsapp_url' );
$email      = dmlegal_get_setting( 'email' );
$maps_url   = dmlegal_get_setting( 'maps_url' );
$facebook   = dmlegal_get_setting( 'facebook_url' );
$instagram  = dmlegal_get_setting( 'instagram_url' );
$linkedin   = dmlegal_get_setting( 'linkedin_url' );
$tiktok     = dmlegal_get_setting( 'tiktok_url' );
$book_url   = dmlegal_get_page_url( 'book-a-lawyer' );

if ( ! is_page( 'contact' ) ) {
	get_template_part( 'template-parts/contact-footer' );
}
?>

<footer class="site-footer px-5">
	<div class="content-width footer-main">
		<div class="footer-top mt-5">
			<div class="footer-top__brand">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<img src="<?php echo esc_url( DMLEGAL_URI . '/assets/images/logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) . ' logo' ); ?>" width="130" height="40">
				<?php endif; ?>
				<p class="body-text"><?php bloginfo( 'description' ); ?></p>
				<p class="body-text fw-bold"><?php esc_html_e( 'DM LEGAL AUSTRALIA | ABN 32 626 700 981', 'dmlegal' ); ?></p>
			</div>
			<div class="footer-top__badges">
				<img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/img8.png' ); ?>" alt="" width="80" height="80">
				<img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/img9.svg' ); ?>" alt="" width="130" height="80">
			</div>
		</div>

		<div class="footer-divider footer-social-row">
			<?php if ( $facebook || $instagram || $linkedin || $tiktok ) : ?>
				<div class="footer-social">
					<?php if ( $facebook ) : ?><a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/customfb.svg' ); ?>" alt="" width="25" height="25"></a><?php endif; ?>
					<?php if ( $instagram ) : ?><a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/custominsta.svg' ); ?>" alt="" width="25" height="25"></a><?php endif; ?>
					<?php if ( $linkedin ) : ?><a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/customlinkedin.svg' ); ?>" alt="" width="25" height="25"></a><?php endif; ?>
					<?php if ( $tiktok ) : ?><a href="<?php echo esc_url( $tiktok ); ?>" target="_blank" rel="noopener noreferrer" aria-label="TikTok"><img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/customtiktok.svg' ); ?>" alt="" width="25" height="25"></a><?php endif; ?>
				</div>
			<?php endif; ?>
			<div class="footer-legal-links">
				<span><?php esc_html_e( 'All Rights Reserved', 'dmlegal' ); ?></span>
				<?php
				wp_nav_menu( [
					'theme_location' => 'footer',
					'container'      => false,
					'items_wrap'     => '<span>|</span>%3$s',
					'fallback_cb'    => false,
				] );
				?>
			</div>
		</div>
	</div>

	<div class="content-width footer-acknowledgement">
		<img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/footerImg.svg' ); ?>" alt="<?php esc_attr_e( 'Aboriginal flag', 'dmlegal' ); ?>">
		<p><?php esc_html_e( 'DM Legal acknowledges the Traditional Custodians and their Elders, past and present, and their enduring culture.', 'dmlegal' ); ?></p>
	</div>

	<div class="footer-bottom">
		<div class="content-width">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All Rights Reserved.', 'dmlegal' ); ?></p>
			<div class="footer-bottom__agency">
				<?php esc_html_e( 'Digital Marketing Agency:', 'dmlegal' ); ?>
				<img src="<?php echo esc_url( DMLEGAL_URI . '/assets/images/tekgro-logo.png' ); ?>" alt="Tekgro logo">
			</div>
		</div>
	</div>
</footer>

<nav class="mobile-bottom-nav" aria-label="<?php esc_attr_e( 'Quick contact', 'dmlegal' ); ?>">
	<div class="mobile-bottom-nav__inner">
		<?php if ( $whatsapp ) : ?>
			<a href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" rel="noopener noreferrer">
				<img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/whatsapp.svg' ); ?>" alt=""><span>WhatsApp</span>
			</a>
		<?php endif; ?>
		<?php if ( $email ) : ?>
			<a href="mailto:<?php echo esc_attr( $email ); ?>">
				<img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/email.svg' ); ?>" alt=""><span><?php esc_html_e( 'Email', 'dmlegal' ); ?></span>
			</a>
		<?php endif; ?>
		<?php if ( $maps_url ) : ?>
			<a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer">
				<img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/direction.svg' ); ?>" alt=""><span><?php esc_html_e( 'Directions', 'dmlegal' ); ?></span>
			</a>
		<?php endif; ?>
	</div>
</nav>

</main>
<?php wp_footer(); ?>
</body>
</html>

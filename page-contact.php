<?php
/**
 * Contact — ported from the legacy static contact.php.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

$heroTitle      = 'Get in Touch Today for Clear, Trusted, and Professional Legal Guidance';
$heroSubtitle   = 'With a proven track record of dismissed charges and reduced penalties, we defend your rights.';
$heroFeatures   = array( 'Fixed Fees', 'Hourly rates', 'Manage Legal Costs', 'No Win, No Fees' );
$heroPrimaryBtn = array( 'text' => 'Book free consultation', 'href' => 'book-your-lawyer.php' );
$heroSecondaryBtn = array( 'text' => 'Explore more', 'href' => 'index.php' );
$heroRightSide  = 'form';
$heroBreadcrumb = array( array( 'label' => 'Contact' ) );

include DM_LEGAL_DIR . '/inc/parts/hero.php';
?>

<!-- ============ SIDEBAR + OFFICE MAP ============ -->
<?php
/*
 * Editable via the "Expert Sidebar & Office Card" metabox (Pages → Contact).
 * The office card's address/phone/email/hours/map come from Global Settings.
 */
$dm_cs = dm_legal_csidebar_args(
	array(
		'heading'         => 'Talk to an Expert',
		'experts'         => array_map(
			static function ( $expert ) {
				return url( 'assets/images/' . $expert . '.png' );
			},
			array( 'expert1', 'expert2', 'expert3', 'expert4', 'expert5', 'expert6' )
		),
		'btn_text'        => 'Book Now',
		'btn_href'        => 'book-your-lawyer.php',
		'directions_text' => 'Get Directions',
	)
);
?>
<section class="content-width content-gapping contact-grid">
  <div>
    <div class="social-icons-row">
      <a href="<?= e( SITE_FACEBOOK_URL ) ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><img src="<?= url( 'assets/icons/facebook.svg' ) ?>" alt="" width="18" height="18"></a>
      <a href="https://www.linkedin.com/company/dmlegalservicesau" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><img src="<?= url( 'assets/icons/linkedin.svg' ) ?>" alt="" width="18" height="18"></a>
      <a href="<?= e( SITE_INSTAGRAM_URL ) ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><img src="<?= url( 'assets/icons/custominsta.svg' ) ?>" alt="" width="18" height="18"></a>
      <a href="<?= e( SITE_WHATSAPP ) ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp" class="icon-whatsapp"><img src="<?= url( 'assets/icons/whatsapp.svg' ) ?>" alt="" width="18" height="18"></a>
      <a href="mailto:<?= e( SITE_EMAIL ) ?>" aria-label="Email" class="icon-email"><img src="<?= url( 'assets/icons/email.svg' ) ?>" alt="" width="18" height="18"></a>
    </div>
    <div class="sidebar-card">
      <h2 class="secondary-header"><?= e( $dm_cs['heading'] ) ?></h2>
      <div class="sidebar-card__experts">
        <?php foreach ( $dm_cs['experts'] as $expert ) : ?>
          <img src="<?= e( url( $expert ) ) ?>" alt="" loading="lazy" decoding="async">
        <?php endforeach; ?>
      </div>
      <div class="sidebar-card__buttons">
        <?php if ( ! empty( $dm_cs['btn_text'] ) ) : ?>
          <a class="btn btn-primary btn-full" href="<?= url( $dm_cs['btn_href'] ) ?>"><?= e( $dm_cs['btn_text'] ) ?></a>
        <?php endif; ?>
        <a class="btn btn-secondary btn-full" href="tel:<?= e( SITE_PHONE_TEL ) ?>"><?= e( SITE_PHONE_DISPLAY ) ?></a>
      </div>
    </div>
  </div>

  <div class="office-info-card">
    <div class="office-info-card__panel">
      <h3><?= e( $officeInfo['name'] ) ?></h3>
      <address>
        <span><?= e( $officeInfo['address'] ) ?></span>
        <?php foreach ( $officeInfo['phoneNumbers'] as $phone ) : ?>
          <a href="tel:<?= e( preg_replace( '/\s+/', '', $phone ) ) ?>" class="phone-link"><?= e( $phone ) ?></a>
        <?php endforeach; ?>
        <a href="mailto:<?= e( $officeInfo['email'] ) ?>"><?= e( $officeInfo['email'] ) ?></a>
        <span><?= e( $officeInfo['hours'] ) ?></span>
      </address>
      <a class="btn btn-primary btn-full" href="<?= e( SITE_MAPS_URL ) ?>" target="_blank" rel="noopener noreferrer"><?= e( $dm_cs['directions_text'] ) ?></a>
    </div>
    <iframe class="office-info-card__map" src="<?= e( $officeInfo['mapEmbedUrl'] ) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen title="DM Legal Services office location"></iframe>
  </div>
</section>

<!-- ============ VALUE HEADING ============ -->
<?php
/*
 * Editable via the "Value Heading Section" metabox (Pages → Contact).
 */
$dm_vh = dm_legal_vheading_args(
	array(
		'heading' => 'Which One Delivers the Best Value for You?',
		'lead'    => 'Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.',
	)
);
?>
<section class="content-width page-section">
  <div class="section-heading">
    <h2 class="secondary-header"><?= e( $dm_vh['heading'] ) ?></h2>
    <p class="body-text"><?= e( $dm_vh['lead'] ) ?></p>
  </div>
</section>

<?php get_footer(); ?>

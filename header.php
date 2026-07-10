<?php
/**
 * Common <head> + opening <body> + site header: top bar, logo, nav, mobile
 * menu, search overlay. Global contact info comes from the Global Settings
 * option; the practice-areas bottom bar is a live loop over top-level
 * practice_area posts rather than a manually-maintained menu, so it can
 * never drift out of sync with the CPT content.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$book_url    = dmlegal_get_page_url( 'book-a-lawyer' );
$whatsapp    = dmlegal_get_setting( 'whatsapp_url' );
$email       = dmlegal_get_setting( 'email' );
$phone_tel   = dmlegal_get_setting( 'phone_tel' );
$phone_disp  = dmlegal_get_setting( 'phone_display' );
$address     = dmlegal_get_setting( 'address_short' );
$maps_url    = dmlegal_get_setting( 'maps_url' );

$top_level_practice_areas = get_posts( [
	'post_type'      => 'practice_area',
	'post_parent'    => 0,
	'posts_per_page' => -1,
	'orderby'        => 'menu_order title',
	'order'          => 'ASC',
] );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a href="#main-content" class="skip-link"><?php esc_html_e( 'Skip to main content', 'dmlegal' ); ?></a>
<header class="site-header">
	<div class="site-header__inner">

		<!-- Top bar (desktop only) -->
		<div class="header-topbar">
			<div class="content-width">
				<div class="header-topbar__links">
					<?php if ( $whatsapp ) : ?>
						<a href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" rel="noopener noreferrer">
							<img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/whatsapp.svg' ); ?>" alt="" width="20" height="20"><?php echo esc_html( $phone_disp ); ?>
						</a>
					<?php endif; ?>
					<?php if ( $email ) : ?>
						<a href="mailto:<?php echo esc_attr( $email ); ?>">
							<img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/email.svg' ); ?>" alt="" width="20" height="20"><?php echo esc_html( $email ); ?>
						</a>
					<?php endif; ?>
					<?php if ( $address && $maps_url ) : ?>
						<a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer">
							<img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/map.svg' ); ?>" alt="" width="15" height="15"><?php echo esc_html( $address ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<!-- Main bar -->
		<div class="header-mainbar">
			<div class="content-width">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' home' ); ?>">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<img src="<?php echo esc_url( DMLEGAL_URI . '/assets/images/logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) . ' logo' ); ?>" width="110" height="110">
					<?php endif; ?>
				</a>

				<nav class="header-nav" aria-label="Primary">
					<?php
					wp_nav_menu( [
						'theme_location' => 'primary',
						'container'      => false,
						'items_wrap'     => '%3$s',
						'fallback_cb'    => false,
					] );
					?>
				</nav>

				<div class="header-actions">
					<?php if ( $phone_tel ) : ?>
						<a class="btn btn-secondary" href="tel:<?php echo esc_attr( $phone_tel ); ?>"><?php echo esc_html( $phone_disp ); ?></a>
					<?php endif; ?>
					<a class="btn btn-primary" href="<?php echo esc_url( $book_url ); ?>"><?php esc_html_e( 'Book a Consultation', 'dmlegal' ); ?></a>
				</div>

				<div class="header-mobile-toggle">
					<button type="button" data-menu-close hidden aria-label="<?php esc_attr_e( 'Close menu', 'dmlegal' ); ?>" class="btn-toogle">&#10005;</button>
					<button type="button" data-menu-open aria-label="<?php esc_attr_e( 'Open menu', 'dmlegal' ); ?>" class="btn-toogle">&#9776;</button>
				</div>
			</div>
		</div>

		<!-- Bottom bar: live practice-areas loop (desktop only) -->
		<?php if ( $top_level_practice_areas ) : ?>
			<div class="header-bottombar">
				<div class="content-width">
					<?php foreach ( $top_level_practice_areas as $area ) : ?>
						<a href="<?php echo esc_url( get_permalink( $area ) ); ?>"><?php echo esc_html( get_the_title( $area ) ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- Mobile slide-down menu -->
		<div class="header-mobile-panel">
			<div class="header-mobile-panel__list" data-mobile-panel>
				<nav aria-label="<?php esc_attr_e( 'Mobile primary', 'dmlegal' ); ?>">
					<?php
					wp_nav_menu( [
						'theme_location' => 'primary',
						'container'      => false,
						'items_wrap'     => '%3$s',
						'fallback_cb'    => false,
					] );
					?>
				</nav>
				<?php if ( $top_level_practice_areas ) : ?>
					<div class="header-mobile-panel__laws">
						<?php foreach ( $top_level_practice_areas as $area ) : ?>
							<a href="<?php echo esc_url( get_permalink( $area ) ); ?>"><?php echo esc_html( get_the_title( $area ) ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<div class="header-mobile-panel__buttons content-width">
					<?php if ( $phone_tel ) : ?>
						<a class="btn btn-secondary btn-full" href="tel:<?php echo esc_attr( $phone_tel ); ?>"><?php echo esc_html( $phone_disp ); ?></a>
					<?php endif; ?>
					<a class="btn btn-primary btn-full" href="<?php echo esc_url( $book_url ); ?>"><?php esc_html_e( 'Book a Consultation', 'dmlegal' ); ?></a>
				</div>
			</div>
		</div>

		<!-- Search overlay -->
		<div class="search-overlay" data-search-overlay>
			<div class="content-width search-overlay__head">
				<button type="button" data-search-close aria-label="<?php esc_attr_e( 'Close search', 'dmlegal' ); ?>">&#10005;</button>
			</div>
			<div class="content-width search-overlay__body">
				<div class="search-overlay__results" data-search-results></div>
			</div>
		</div>

	</div>
</header>
<main id="main-content">

<?php
/**
 * Theme bootstrap. Loads includes and registers core theme features.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DMLEGAL_VERSION', '1.0.0' );
define( 'DMLEGAL_DIR', get_template_directory() );
define( 'DMLEGAL_URI', get_template_directory_uri() );

require_once DMLEGAL_DIR . '/inc/enqueue.php';
require_once DMLEGAL_DIR . '/inc/svg-sanitizer.php';
require_once DMLEGAL_DIR . '/inc/meta-box-repeater.php';
require_once DMLEGAL_DIR . '/inc/cpt-practice-area.php';
require_once DMLEGAL_DIR . '/inc/cpt-case-study.php';
require_once DMLEGAL_DIR . '/inc/cpt-attorney.php';
require_once DMLEGAL_DIR . '/inc/settings-global.php';
require_once DMLEGAL_DIR . '/inc/meta-boxes-pages.php';
require_once DMLEGAL_DIR . '/inc/cf7-integration.php';

/**
 * Theme supports, nav menus, image sizes.
 */
function dmlegal_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
	add_theme_support( 'custom-logo', [
		'height'      => 110,
		'width'       => 110,
		'flex-height' => true,
		'flex-width'  => true,
	] );
	add_theme_support( 'automatic-feed-links' );

	register_nav_menus( [
		'primary' => __( 'Primary Navigation', 'dmlegal' ),
		'footer'  => __( 'Footer Links', 'dmlegal' ),
	] );

	add_image_size( 'practice-area-card', 400, 300, true );
	add_image_size( 'case-study-card', 480, 320, true );
	add_image_size( 'attorney-photo', 480, 480, true );
	add_image_size( 'blog-thumbnail', 400, 260, true );
	add_image_size( 'blog-featured', 900, 500, true );
}
add_action( 'after_setup_theme', 'dmlegal_setup' );

/**
 * Resolve a fixed-slug Page's permalink for use in shared template parts
 * (header/footer links to Book a Lawyer, Contact, etc. — not the current
 * page). Falls back to /$slug/ if the page hasn't been created yet, so
 * links never fatal during initial site setup.
 */
function dmlegal_get_page_url( string $slug ): string {
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
}

/**
 * Image alt text inherits the associated heading. If the heading is empty,
 * bail silently — return no 'alt' override at all rather than alt="", so
 * the_post_thumbnail() falls back to its own default instead of emitting a
 * broken/empty alt attribute.
 */
function dmlegal_thumbnail_alt_args( string $heading ): array {
	return $heading !== '' ? [ 'alt' => $heading ] : [];
}

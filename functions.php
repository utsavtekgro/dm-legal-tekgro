<?php
/**
 * DM Legal functions and definitions.
 *
 * The bootstrap only defines constants and loads focused modules from /inc.
 * No feature logic lives here directly — this keeps the entry point auditable
 * and each concern independently testable.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme version. Bump on release to bust asset caches.
 *
 * During active development, filemtime()-based versioning in inc/enqueue.php
 * takes precedence when WP_DEBUG is on, so the CDN/browser cache is invalidated
 * automatically per file change.
 */
if ( ! defined( 'DM_LEGAL_VERSION' ) ) {
	define( 'DM_LEGAL_VERSION', '1.0.0' );
}

if ( ! defined( 'DM_LEGAL_DIR' ) ) {
	define( 'DM_LEGAL_DIR', get_template_directory() );
}

if ( ! defined( 'DM_LEGAL_URI' ) ) {
	define( 'DM_LEGAL_URI', get_template_directory_uri() );
}

/**
 * Load a theme module from /inc with an existence guard.
 *
 * @param string $module Filename without extension, relative to /inc.
 * @return void
 */
function dm_legal_require_module( $module ) {
	$path = DM_LEGAL_DIR . '/inc/' . $module . '.php';

	if ( is_readable( $path ) ) {
		require_once $path;
	}
}

/**
 * Ordered module manifest. Order matters: setup registers supports that
 * later modules (enqueue, customizer) rely on.
 */
$dm_legal_modules = array(
	'setup',              // Theme supports, menus, image sizes, i18n.
	'security',           // Hardening: headers, disclosure removal, XML-RPC.
	'enqueue',            // Scripts, styles, critical CSS, performance trims.
	'template-tags',      // Reusable, escaped output helpers.
	'template-functions', // Body classes, schema, a11y filters.
	'customizer',         // Theme Customizer settings with sanitization.
	'global-settings',    // "DM Legal → Global Settings" admin page (phone, email, socials…).
	'legacy-helpers',     // Firm constants + WP-aware url()/e() + render helpers.
	'post-types',         // Custom post types (Practice Area) + seeding.
	'metaboxes',          // Per-page Hero Section metabox + dm_legal_hero_args().
	'pages',              // Auto-provision the Pages backing the legacy templates.
);

foreach ( $dm_legal_modules as $dm_legal_module ) {
	dm_legal_require_module( $dm_legal_module );
}

unset( $dm_legal_module );

/**
 * Load the static content arrays at GLOBAL scope so the ported page templates
 * (which run at global scope via the template loader) can read $navLinks,
 * $blogs, $legalServicesData, etc. directly, exactly as the legacy site did.
 * Must load after legacy-helpers.php, which defines the SITE_* constants the
 * data file references.
 */
$dm_legal_data_file = DM_LEGAL_DIR . '/inc/data.php';
if ( is_readable( $dm_legal_data_file ) ) {
	require_once $dm_legal_data_file;
}
unset( $dm_legal_data_file );



add_filter('use_block_editor_for_post', '__return_false', 10);
// use for classic editor




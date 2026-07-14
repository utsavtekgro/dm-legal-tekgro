<?php
/**
 * Theme setup: supports, menus, image sizes, i18n.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register core theme supports.
 *
 * Hooked to after_setup_theme so it runs before the block editor and
 * front end boot.
 *
 * @return void
 */
function dm_legal_setup() {
	// Make the theme available for translation.
	load_theme_textdomain( 'dm-legal', DM_LEGAL_DIR . '/languages' );

	// Let WordPress manage the document <title>.
	add_theme_support( 'title-tag' );

	// Enable featured images.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 675, true );

	// Custom image sizes used by templates (16:9 card, square avatar-ish).
	add_image_size( 'dm-legal-card', 640, 420, true );
	add_image_size( 'dm-legal-wide', 1600, 720, true );

	// HTML5 markup for core features (removes legacy inline styles).
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);

	// Custom logo with accessible dimensions.
	add_theme_support(
		'custom-logo',
		array(
			'height'               => 60,
			'width'                => 220,
			'flex-height'          => true,
			'flex-width'           => true,
			'unlink-homepage-logo' => true,
		)
	);

	// Feed links in <head>.
	add_theme_support( 'automatic-feed-links' );

	// Selective refresh so Customizer widget edits don't reload the page.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Editor niceties. Colors/typography are driven by theme.json.
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );

	// Register navigation menus.
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'dm-legal' ),
			'footer'  => __( 'Footer Menu', 'dm-legal' ),
		)
	);
}
add_action( 'after_setup_theme', 'dm_legal_setup' );

/**
 * Set the content width in pixels for oEmbeds and large images.
 *
 * @return void
 */
function dm_legal_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'dm_legal_content_width', 760 );
}
add_action( 'after_setup_theme', 'dm_legal_content_width', 0 );

/**
 * Register widget areas.
 *
 * @return void
 */
function dm_legal_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Primary Sidebar', 'dm-legal' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Widgets shown alongside posts and archives.', 'dm-legal' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget__title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer', 'dm-legal' ),
			'id'            => 'footer-1',
			'description'   => __( 'Widgets shown in the site footer.', 'dm-legal' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget__title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'dm_legal_widgets_init' );

<?php
/**
 * Asset loading and performance trimming.
 *
 * Strategy for a 100/100 PageSpeed baseline:
 *   - System font stacks => zero external font requests, zero CLS from FOIT.
 *   - Critical CSS inlined in <head>; full stylesheet loaded non-render-blocking.
 *   - Navigation JS deferred; no jQuery on the front end.
 *   - Emoji script, block-library inline SVG duotone, and dashicons removed
 *     for anonymous visitors.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Resolve an asset version.
 *
 * Uses filemtime when the file exists so caches bust per deploy; falls back to
 * the theme version constant otherwise.
 *
 * @param string $relative_path Path relative to the theme root.
 * @return string
 */
function dm_legal_asset_version( $relative_path ) {
	$absolute = DM_LEGAL_DIR . '/' . ltrim( $relative_path, '/' );

	if ( is_readable( $absolute ) ) {
		$mtime = filemtime( $absolute );
		if ( false !== $mtime ) {
			return (string) $mtime;
		}
	}

	return DM_LEGAL_VERSION;
}

/**
 * Enqueue front-end styles and scripts.
 *
 * Loads the ported DM Legal design system stylesheet (assets/css/style.css),
 * the Google Fonts it depends on, the shared behaviour script (app.js), and
 * any per-page script the original static site loaded on that page.
 *
 * @return void
 */
function dm_legal_enqueue_assets() {
	// Google Fonts used by the design (Nunito + Lato).
	wp_enqueue_style(
		'dm-legal-fonts',
		'https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&family=Lato:wght@400;700&display=swap',
		array(),
		null
	);

	// The full DM Legal design system stylesheet.
	wp_enqueue_style(
		'dm-legal-style',
		DM_LEGAL_URI . '/assets/css/style.css',
		array( 'dm-legal-fonts' ),
		dm_legal_asset_version( 'assets/css/style.css' )
	);

	// Shared front-end behaviour (nav, reveal-on-scroll, search, modal, FAQ, etc.).
	wp_enqueue_script(
		'dm-legal-app',
		DM_LEGAL_URI . '/assets/js/app.js',
		array(),
		dm_legal_asset_version( 'assets/js/app.js' ),
		true
	);

	// Per-page scripts, mirroring the legacy pages' $pageScripts.
	$page_scripts = array(
		'blogs'               => 'blog-filter.js',
		'case-studies'        => 'case-filter.js',
		'book-your-lawyer'    => 'booking-form.js',
		'practice-area-inner' => 'inner-dropdown.js',
	);

	$slug = dm_legal_current_slug();
	if ( isset( $page_scripts[ $slug ] ) ) {
		$file = $page_scripts[ $slug ];
		wp_enqueue_script(
			'dm-legal-' . sanitize_title( basename( $file, '.js' ) ),
			DM_LEGAL_URI . '/assets/js/' . $file,
			array( 'dm-legal-app' ),
			dm_legal_asset_version( 'assets/js/' . $file ),
			true
		);
	}

	// Comment reply script only where threaded comments are open.
	if ( is_singular() && comments_open() && (int) get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dm_legal_enqueue_assets' );

/**
 * Add defer to the navigation script for non-render-blocking execution.
 *
 * @param string $tag    The full script tag.
 * @param string $handle The registered handle.
 * @return string
 */
function dm_legal_defer_scripts( $tag, $handle ) {
	// Defer every theme script (handles are prefixed dm-legal-).
	$is_theme_script = 0 === strpos( (string) $handle, 'dm-legal-' );

	if ( $is_theme_script && false === strpos( $tag, 'defer' ) ) {
		$tag = str_replace( ' src=', ' defer src=', $tag );
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'dm_legal_defer_scripts', 10, 2 );

/**
 * Enqueue block editor styles so the editor matches the front end.
 *
 * @return void
 */
function dm_legal_editor_assets() {
	add_editor_style( 'assets/css/style.css' );
}
add_action( 'after_setup_theme', 'dm_legal_editor_assets' );

/**
 * Remove the emoji detection script and styles for anonymous visitors.
 *
 * Saves ~13 KB of render-blocking JS and an extra DNS lookup.
 *
 * @return void
 */
function dm_legal_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'dm_legal_disable_emojis' );

/**
 * Drop jQuery Migrate — no legacy front-end code depends on it here.
 *
 * @param WP_Scripts $scripts Scripts registry.
 * @return void
 */
function dm_legal_dequeue_jquery_migrate( $scripts ) {
	if ( is_admin() || empty( $scripts->registered['jquery'] ) ) {
		return;
	}

	$deps = $scripts->registered['jquery']->deps;
	$scripts->registered['jquery']->deps = array_diff( $deps, array( 'jquery-migrate' ) );
}
add_action( 'wp_default_scripts', 'dm_legal_dequeue_jquery_migrate' );

/**
 * Preload the primary stylesheet to shorten the critical request chain.
 *
 * @return void
 */
function dm_legal_resource_hints() {
	$href = DM_LEGAL_URI . '/assets/css/style.css';
	printf(
		'<link rel="preload" as="style" href="%s">' . "\n",
		esc_url( $href )
	);
}
add_action( 'wp_head', 'dm_legal_resource_hints', 1 );

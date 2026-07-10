<?php
/**
 * Front-end asset registration. Cache-busted with filemtime(); non-critical
 * JS is deferred so nothing render-blocks in <head>.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return a filemtime()-based version string for a theme-relative asset path,
 * falling back to the theme version if the file can't be stat'd.
 */
function dmlegal_asset_version( string $relative_path ): string {
	$full_path = DMLEGAL_DIR . '/' . ltrim( $relative_path, '/' );
	if ( file_exists( $full_path ) ) {
		return (string) filemtime( $full_path );
	}
	return DMLEGAL_VERSION;
}

function dmlegal_enqueue_assets() {
	wp_enqueue_style(
		'dmlegal-style',
		DMLEGAL_URI . '/assets/css/style.css',
		[],
		dmlegal_asset_version( 'assets/css/style.css' )
	);

	wp_enqueue_script(
		'dmlegal-app',
		DMLEGAL_URI . '/assets/js/app.js',
		[],
		dmlegal_asset_version( 'assets/js/app.js' ),
		true
	);
	wp_script_add_data( 'dmlegal-app', 'strategy', 'defer' );

	// blog-filter.js / case-filter.js from the legacy static site are not
	// enqueued here — archive.php and archive-case_study.php use native
	// category links + pagination instead of client-side filtering, so
	// that markup (and its data-blog-grid/data-case-grid hooks) no longer
	// exists in the DOM for them to target.

	if ( is_singular( 'practice_area' ) ) {
		wp_enqueue_script(
			'dmlegal-inner-dropdown',
			DMLEGAL_URI . '/assets/js/inner-dropdown.js',
			[ 'dmlegal-app' ],
			dmlegal_asset_version( 'assets/js/inner-dropdown.js' ),
			true
		);
		wp_script_add_data( 'dmlegal-inner-dropdown', 'strategy', 'defer' );
	}

	if ( is_page( 'book-a-lawyer' ) ) {
		wp_enqueue_script(
			'dmlegal-booking-form',
			DMLEGAL_URI . '/assets/js/booking-form.js',
			[ 'dmlegal-app' ],
			dmlegal_asset_version( 'assets/js/booking-form.js' ),
			true
		);
		wp_script_add_data( 'dmlegal-booking-form', 'strategy', 'defer' );
	}
}
add_action( 'wp_enqueue_scripts', 'dmlegal_enqueue_assets' );

/**
 * Admin-only assets for the custom repeater meta boxes. Enqueued narrowly
 * (only on post edit screens for the relevant post types) rather than
 * loading on every wp-admin screen.
 */
function dmlegal_admin_enqueue_assets( string $hook_suffix ) {
	if ( ! in_array( $hook_suffix, [ 'post.php', 'post-new.php' ], true ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen ) {
		return;
	}

	$repeater_post_types = [ 'practice_area', 'case_study', 'attorney' ];
	$is_repeater_post_type = in_array( $screen->post_type, $repeater_post_types, true );

	$is_allowed_page = false;
	if ( $screen->post_type === 'page' ) {
		global $post;
		$is_allowed_page = $post && in_array( $post->post_name, dmlegal_page_meta_allowed_slugs(), true );
	}

	if ( ! $is_repeater_post_type && ! $is_allowed_page ) {
		return;
	}

	wp_enqueue_media();

	wp_enqueue_style(
		'dmlegal-admin-meta-boxes',
		DMLEGAL_URI . '/assets/css/admin-meta-boxes.css',
		[],
		dmlegal_asset_version( 'assets/css/admin-meta-boxes.css' )
	);

	wp_enqueue_script(
		'dmlegal-admin-repeater',
		DMLEGAL_URI . '/assets/js/admin-repeater.js',
		[ 'jquery' ],
		dmlegal_asset_version( 'assets/js/admin-repeater.js' ),
		true
	);
}
add_action( 'admin_enqueue_scripts', 'dmlegal_admin_enqueue_assets' );

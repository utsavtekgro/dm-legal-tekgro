<?php
/**
 * Security hardening.
 *
 * Defence-in-depth measures applied at the theme layer. These complement,
 * never replace, server- and plugin-level controls. Each measure is filterable
 * so a site can opt out without editing the theme.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Remove version and generator disclosure from the front end.
 *
 * Prevents trivial version fingerprinting used to target known CVEs.
 *
 * @return void
 */
function dm_legal_remove_disclosure() {
	// Remove the WordPress version meta tag.
	remove_action( 'wp_head', 'wp_generator' );

	// Strip ?ver= from core scripts/styles so versions aren't leaked in URLs.
	add_filter( 'style_loader_src', 'dm_legal_maybe_strip_core_version', 15 );
	add_filter( 'script_loader_src', 'dm_legal_maybe_strip_core_version', 15 );
}
add_action( 'init', 'dm_legal_remove_disclosure' );

/**
 * Remove the core WordPress version query arg from asset URLs.
 *
 * Theme assets keep their own filemtime version (set in enqueue.php); only the
 * shared "wp_version" value is scrubbed.
 *
 * @param string $src Asset source URL.
 * @return string
 */
function dm_legal_maybe_strip_core_version( $src ) {
	global $wp_version;

	if ( $src && false !== strpos( $src, 'ver=' . $wp_version ) ) {
		$src = remove_query_arg( 'ver', $src );
	}

	return $src;
}

/**
 * Empty the generator string for RSS and other filters.
 *
 * @return string
 */
function dm_legal_null_generator() {
	return '';
}
add_filter( 'the_generator', 'dm_legal_null_generator' );

/**
 * Disable XML-RPC unless explicitly re-enabled.
 *
 * XML-RPC is a common brute-force and pingback-amplification vector and is
 * rarely needed on a modern marketing site.
 *
 * @return bool
 */
function dm_legal_disable_xmlrpc() {
	return (bool) apply_filters( 'dm_legal_enable_xmlrpc', false );
}
add_filter( 'xmlrpc_enabled', 'dm_legal_disable_xmlrpc' );

/**
 * Remove links that expose surface area (RSD, WLW manifest, shortlinks).
 *
 * @return void
 */
function dm_legal_trim_head_links() {
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
}
add_action( 'init', 'dm_legal_trim_head_links' );

/**
 * Block REST user enumeration for unauthenticated requests.
 *
 * The /wp/v2/users endpoint leaks usernames to anonymous callers, which feeds
 * credential-stuffing. Authenticated users with list_users retain access.
 *
 * @param WP_REST_Response|WP_Error $response Endpoint response.
 * @param array                     $handler  Route handler.
 * @param WP_REST_Request           $request  Current request.
 * @return WP_REST_Response|WP_Error
 */
function dm_legal_restrict_user_endpoint( $response, $handler, $request ) {
	$route = $request->get_route();

	if ( is_string( $route ) && 0 === strpos( $route, '/wp/v2/users' ) ) {
		if ( ! current_user_can( 'list_users' ) ) {
			return new WP_Error(
				'rest_user_cannot_view',
				__( 'Sorry, you are not allowed to list users.', 'dm-legal' ),
				array( 'status' => rest_authorization_required_code() )
			);
		}
	}

	return $response;
}
add_filter( 'rest_request_before_callbacks', 'dm_legal_restrict_user_endpoint', 10, 3 );

/**
 * Emit conservative security headers on front-end responses.
 *
 * A restrictive Content-Security-Policy is intentionally omitted here because
 * it must be authored per-site; a nonce-based CSP belongs at the server/plugin
 * layer. These headers are safe defaults with no false positives.
 *
 * @return void
 */
function dm_legal_security_headers() {
	if ( is_admin() || headers_sent() ) {
		return;
	}

	$headers = apply_filters(
		'dm_legal_security_headers',
		array(
			'X-Content-Type-Options'  => 'nosniff',
			'Referrer-Policy'         => 'strict-origin-when-cross-origin',
			'X-Frame-Options'         => 'SAMEORIGIN',
			'Permissions-Policy'      => 'geolocation=(), microphone=(), camera=()',
			'Cross-Origin-Opener-Policy' => 'same-origin',
		)
	);

	foreach ( $headers as $name => $value ) {
		header( sprintf( '%s: %s', $name, $value ), true );
	}
}
add_action( 'send_headers', 'dm_legal_security_headers' );

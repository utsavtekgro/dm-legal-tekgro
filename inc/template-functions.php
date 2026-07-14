<?php
/**
 * Template functions — body classes, SEO schema, accessibility filters.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add helpful, semantic body classes.
 *
 * @param string[] $classes Existing body classes.
 * @return string[]
 */
function dm_legal_body_classes( $classes ) {
	// Flag the no-sidebar layout so CSS can go full width.
	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page() || is_front_page() ) {
		$classes[] = 'has-no-sidebar';
	}

	// Flag hero presence on the front page.
	if ( is_front_page() ) {
		$classes[] = 'is-front';
	}

	return $classes;
}
add_filter( 'body_class', 'dm_legal_body_classes' );

/**
 * Output Organization + WebSite JSON-LD in the head.
 *
 * Provides a valid, escaped structured-data baseline. LegalService-specific
 * fields can be layered on via the dm_legal_schema filter.
 *
 * @return void
 */
function dm_legal_json_ld() {
	if ( ! is_front_page() ) {
		return;
	}

	$schema = array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type' => 'Organization',
				'@id'   => home_url( '/#organization' ),
				'name'  => get_bloginfo( 'name' ),
				'url'   => home_url( '/' ),
			),
			array(
				'@type'           => 'WebSite',
				'@id'             => home_url( '/#website' ),
				'url'             => home_url( '/' ),
				'name'            => get_bloginfo( 'name' ),
				'description'     => get_bloginfo( 'description' ),
				'publisher'       => array( '@id' => home_url( '/#organization' ) ),
				'potentialAction' => array(
					'@type'       => 'SearchAction',
					'target'      => array(
						'@type'       => 'EntryPoint',
						'urlTemplate' => home_url( '/?s={search_term_string}' ),
					),
					'query-input' => 'required name=search_term_string',
				),
			),
		),
	);

	/**
	 * Filter the JSON-LD graph before output.
	 *
	 * @param array $schema The schema graph.
	 */
	$schema = apply_filters( 'dm_legal_schema', $schema );

	printf(
		'<script type="application/ld+json">%s</script>' . "\n",
		wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
	);
}
add_action( 'wp_head', 'dm_legal_json_ld', 20 );

/**
 * Ensure every <img> in content has a decoding hint and lazy loading.
 *
 * WordPress core adds these to most images; this backstops embedded/legacy
 * markup that predates core behaviour.
 *
 * @param string $content Post content.
 * @return string
 */
function dm_legal_harden_content_images( $content ) {
	if ( is_admin() || is_feed() || empty( $content ) ) {
		return $content;
	}

	// Add decoding="async" to images lacking it.
	$content = preg_replace(
		'/<img((?![^>]*\bdecoding=)[^>]*)>/i',
		'<img$1 decoding="async">',
		$content
	);

	return $content;
}
add_filter( 'the_content', 'dm_legal_harden_content_images', 20 );

/**
 * Add a "Skip to content" target id filter guard.
 *
 * Guarantees the skip link (printed in header.php) always has a matching
 * anchor by filtering the main container id if a child theme changes it.
 *
 * @return string
 */
function dm_legal_main_id() {
	return (string) apply_filters( 'dm_legal_main_id', 'main-content' );
}

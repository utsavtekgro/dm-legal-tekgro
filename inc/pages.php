<?php
/**
 * One-time provisioning of the WordPress Pages that back the ported legacy
 * templates. Each page uses a slug that matches a page-{slug}.php template in
 * the theme root, so WordPress's template hierarchy routes it automatically.
 *
 * Runs idempotently on admin_init (guarded by an option) and also on theme
 * activation, so it works whether the theme is freshly activated or already
 * live.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The legacy page manifest: slug => human title.
 *
 * @return array<string,string>
 */
function dm_legal_page_manifest() {
	return array(
		'home'                 => 'Home',
		'fixed-prices'         => 'Fixed Prices',
		'case-studies'         => 'Case Studies',
		'case-study-detail'    => 'Case Study',
		'practice-area'        => 'Practice Area',
		'practice-area-inner'  => 'Practice Area Service',
		'blogs'                => 'News & Blog',
		'blog-detail'          => 'Blog',
		'faqs'                 => 'FAQs',
		'contact'              => 'Contact',
		'book-your-lawyer'     => 'Book Your Lawyer',
		'privacy-policy'       => 'Privacy Policy',
		'terms-and-conditions' => 'Terms & Conditions',
		'disclaimer'           => 'Disclaimer',
	);
}

/**
 * Create any missing pages and pin the static front page to "home".
 *
 * @return void
 */
function dm_legal_provision_pages() {
	$ids = array();

	foreach ( dm_legal_page_manifest() as $slug => $title ) {
		$existing = get_page_by_path( $slug );

		if ( $existing instanceof WP_Post ) {
			// A matching page exists (e.g. WordPress's default draft Privacy
			// page). Ensure it is published so its template renders.
			if ( 'publish' !== $existing->post_status ) {
				wp_update_post(
					array(
						'ID'          => $existing->ID,
						'post_status' => 'publish',
					)
				);
			}
			$ids[ $slug ] = (int) $existing->ID;
			continue;
		}

		$page_id = wp_insert_post(
			array(
				'post_title'   => $title,
				'post_name'    => $slug,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
				'comment_status' => 'closed',
				'ping_status'  => 'closed',
			)
		);

		if ( $page_id && ! is_wp_error( $page_id ) ) {
			$ids[ $slug ] = (int) $page_id;
		}
	}

	// Pin the static front page to the Home page.
	if ( ! empty( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
	}

	update_option( 'dm_legal_pages_created', DM_LEGAL_VERSION );
}

/**
 * Provision on admin load if it hasn't run for this theme version.
 *
 * @return void
 */
function dm_legal_maybe_provision_pages() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( get_option( 'dm_legal_pages_created' ) === DM_LEGAL_VERSION ) {
		return;
	}

	dm_legal_provision_pages();
}
add_action( 'admin_init', 'dm_legal_maybe_provision_pages' );
add_action( 'after_switch_theme', 'dm_legal_provision_pages' );

/**
 * The current page's legacy slug, used to gate per-page behaviour
 * (e.g. hiding the contact CTA on the contact page).
 *
 * @return string
 */
function dm_legal_current_slug() {
	$post = get_queried_object();
	if ( $post instanceof WP_Post ) {
		return (string) $post->post_name;
	}
	return '';
}

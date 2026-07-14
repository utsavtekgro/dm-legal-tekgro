<?php
/**
 * Theme Customizer settings.
 *
 * Every setting declares a sanitize_callback, and every transport is either
 * postMessage (with selective refresh) or refresh. No raw setting value is
 * ever trusted at render time.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Customizer sections, settings, and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 * @return void
 */
function dm_legal_customize_register( $wp_customize ) {
	// Live-preview the blogname/description.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial(
		'blogname',
		array(
			'selector'        => '.site-branding__title',
			'render_callback' => 'dm_legal_partial_blogname',
		)
	);

	// Contact section.
	$wp_customize->add_section(
		'dm_legal_contact',
		array(
			'title'       => __( 'Firm Contact', 'dm-legal' ),
			'priority'    => 40,
			'description' => __( 'Phone and consultation details shown in the header and footer.', 'dm-legal' ),
		)
	);

	$wp_customize->add_setting(
		'dm_legal_phone',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'dm_legal_sanitize_phone',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'dm_legal_phone',
		array(
			'label'       => __( 'Phone number', 'dm-legal' ),
			'section'     => 'dm_legal_contact',
			'type'        => 'text',
			'input_attrs' => array(
				'placeholder' => '+61 2 0000 0000',
				'autocomplete' => 'tel',
			),
		)
	);

	$wp_customize->add_setting(
		'dm_legal_cta_url',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'dm_legal_cta_url',
		array(
			'label'   => __( 'Consultation button URL', 'dm-legal' ),
			'section' => 'dm_legal_contact',
			'type'    => 'url',
		)
	);
}
add_action( 'customize_register', 'dm_legal_customize_register' );

/**
 * Sanitize a phone number: keep digits, spaces, plus, hyphen, parentheses.
 *
 * @param string $value Raw input.
 * @return string
 */
function dm_legal_sanitize_phone( $value ) {
	$value = (string) $value;
	return trim( preg_replace( '/[^0-9+\-\s()]/', '', $value ) );
}

/**
 * Selective-refresh render callback for the site title.
 *
 * @return void
 */
function dm_legal_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Load the Customizer live-preview script.
 *
 * @return void
 */
function dm_legal_customize_preview_js() {
	wp_enqueue_script(
		'dm-legal-customizer',
		DM_LEGAL_URI . '/assets/js/customizer.js',
		array( 'customize-preview' ),
		dm_legal_asset_version( 'assets/js/customizer.js' ),
		true
	);
}
add_action( 'customize_preview_init', 'dm_legal_customize_preview_js' );

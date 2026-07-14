<?php
/**
 * DM Legal Global Settings.
 *
 * A single admin screen for the firm details that repeat across the site
 * (phone, email, socials, hours, address, map). Everything is stored in one
 * option array so a single get_option() call serves the whole request, and
 * every field is sanitized on save and escaped at output.
 *
 * Read values with dm_legal_get_setting( 'phone' ) or the SITE_* constants
 * defined in inc/legacy-helpers.php, which fall back to these values.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Option name holding the settings array.
 */
if ( ! defined( 'DM_LEGAL_SETTINGS_OPTION' ) ) {
	define( 'DM_LEGAL_SETTINGS_OPTION', 'dm_legal_global_settings' );
}

/**
 * Field definitions — the single source of truth for the form, the sanitizer
 * and the defaults. Adding a field here is all that is needed to expose it.
 *
 * @return array<string,array>
 */
function dm_legal_settings_fields() {
	return array(
		'phone'         => array(
			'label'       => __( 'Phone number', 'dm-legal' ),
			'type'        => 'text',
			'default'     => '0426 269 954',
			'sanitize'    => 'dm_legal_sanitize_phone',
			'description' => __( 'Displayed as-is in the header, footer and contact page.', 'dm-legal' ),
			'placeholder' => '0426 269 954',
		),
		'phone_tel'     => array(
			'label'       => __( 'Phone (tel: link)', 'dm-legal' ),
			'type'        => 'text',
			'default'     => '+610426269954',
			'sanitize'    => 'dm_legal_sanitize_phone',
			'description' => __( 'International format used in tel: links. Leave blank to derive from the phone number above.', 'dm-legal' ),
			'placeholder' => '+610426269954',
		),
		'email'         => array(
			'label'       => __( 'Email address', 'dm-legal' ),
			'type'        => 'email',
			'default'     => 'info@dmlegalservices.com.au',
			'sanitize'    => 'sanitize_email',
			'placeholder' => 'info@example.com.au',
		),
		'instagram_url' => array(
			'label'       => __( 'Instagram URL', 'dm-legal' ),
			'type'        => 'url',
			'default'     => '',
			'sanitize'    => 'esc_url_raw',
			'placeholder' => 'https://www.instagram.com/yourfirm',
		),
		'facebook_url'  => array(
			'label'       => __( 'Facebook URL', 'dm-legal' ),
			'type'        => 'url',
			'default'     => '',
			'sanitize'    => 'esc_url_raw',
			'placeholder' => 'https://www.facebook.com/yourfirm',
		),
		'office_hours'  => array(
			'label'       => __( 'Office hours', 'dm-legal' ),
			'type'        => 'textarea',
			'default'     => 'Mon–Fri: 8:30 AM – 5:30 PM (Sat–Sun: Closed)',
			'sanitize'    => 'dm_legal_sanitize_multiline',
			'description' => __( 'One line per row. Line breaks are preserved on the front end.', 'dm-legal' ),
		),
		'address'       => array(
			'label'    => __( 'Address', 'dm-legal' ),
			'type'     => 'textarea',
			'default'  => 'Meriton Suites World Tower, Sydney',
			'sanitize' => 'dm_legal_sanitize_multiline',
		),
		'maps_url'      => array(
			'label'       => __( 'Google Maps link', 'dm-legal' ),
			'type'        => 'url',
			'default'     => 'https://maps.app.goo.gl/jhzb5NCbfToYvgmy5',
			'sanitize'    => 'esc_url_raw',
			'description' => __( 'The share link people open in Google Maps for directions.', 'dm-legal' ),
			'placeholder' => 'https://maps.app.goo.gl/…',
		),
		'maps_embed_url' => array(
			'label'       => __( 'Google Maps embed URL', 'dm-legal' ),
			'type'        => 'url',
			'default'     => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3312.4862707465377!2d151.20414677653508!3d-33.87712821949169!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12afb2e5d60f5d%3A0xdf1da4954cb773cf!2sDM%20Legal%20Sydney!5e0!3m2!1sen!2snp!4v1758097950018!5m2!1sen!2snp',
			'sanitize'    => 'esc_url_raw',
			'description' => __( 'The src of the &lt;iframe&gt; from Google Maps → Share → Embed a map. Used for the contact page map.', 'dm-legal' ),
		),
	);
}

/**
 * Default value for every field.
 *
 * @return array<string,string>
 */
function dm_legal_settings_defaults() {
	return wp_list_pluck( dm_legal_settings_fields(), 'default' );
}

/**
 * All settings, saved values merged over the defaults.
 *
 * @return array<string,string>
 */
function dm_legal_get_settings() {
	$saved = get_option( DM_LEGAL_SETTINGS_OPTION, array() );

	if ( ! is_array( $saved ) ) {
		$saved = array();
	}

	return wp_parse_args( $saved, dm_legal_settings_defaults() );
}

/**
 * A single setting, falling back to the field default when empty.
 *
 * @param string $key     Field key, e.g. 'phone'.
 * @param string $default Value returned when the setting is empty and has no default.
 * @return string
 */
function dm_legal_get_setting( $key, $default = '' ) {
	$settings = dm_legal_get_settings();

	if ( isset( $settings[ $key ] ) && '' !== trim( (string) $settings[ $key ] ) ) {
		return (string) $settings[ $key ];
	}

	return $default;
}

/**
 * Sanitize a multi-line plain-text value (hours, address).
 *
 * @param string $value Raw input.
 * @return string
 */
function dm_legal_sanitize_multiline( $value ) {
	return trim( sanitize_textarea_field( (string) $value ) );
}

/**
 * Register the option and its fields with the Settings API.
 *
 * @return void
 */
function dm_legal_register_settings() {
	register_setting(
		'dm_legal_global_settings_group',
		DM_LEGAL_SETTINGS_OPTION,
		array(
			'type'              => 'array',
			'sanitize_callback' => 'dm_legal_sanitize_settings',
			'default'           => dm_legal_settings_defaults(),
		)
	);

	add_settings_section(
		'dm_legal_global_settings_section',
		__( 'Firm details', 'dm-legal' ),
		'dm_legal_settings_section_intro',
		'dm-legal-global-settings'
	);

	foreach ( dm_legal_settings_fields() as $key => $field ) {
		add_settings_field(
			'dm_legal_field_' . $key,
			esc_html( $field['label'] ),
			'dm_legal_render_settings_field',
			'dm-legal-global-settings',
			'dm_legal_global_settings_section',
			array(
				'key'       => $key,
				'field'     => $field,
				'label_for' => 'dm_legal_field_' . $key,
			)
		);
	}
}
add_action( 'admin_init', 'dm_legal_register_settings' );

/**
 * Sanitize the whole submitted settings array, field by field.
 *
 * Unknown keys are dropped so nothing unexpected is ever persisted.
 *
 * @param mixed $input Raw $_POST value.
 * @return array<string,string>
 */
function dm_legal_sanitize_settings( $input ) {
	$fields = dm_legal_settings_fields();
	$clean  = array();

	if ( ! is_array( $input ) ) {
		$input = array();
	}

	foreach ( $fields as $key => $field ) {
		$raw      = isset( $input[ $key ] ) ? $input[ $key ] : '';
		$callback = $field['sanitize'];

		$clean[ $key ] = is_callable( $callback ) ? call_user_func( $callback, $raw ) : sanitize_text_field( (string) $raw );
	}

	// An unparseable email would be silently blanked by sanitize_email; tell the editor instead.
	if ( '' !== trim( (string) ( $input['email'] ?? '' ) ) && '' === $clean['email'] ) {
		add_settings_error(
			DM_LEGAL_SETTINGS_OPTION,
			'dm_legal_invalid_email',
			__( 'That email address is not valid, so it was not saved.', 'dm-legal' )
		);
		$clean['email'] = dm_legal_get_setting( 'email' );
	}

	return $clean;
}

/**
 * Section intro copy.
 *
 * @return void
 */
function dm_legal_settings_section_intro() {
	echo '<p>' . esc_html__( 'These values are reused across the header, footer, contact page and practice-area templates. Change them once here.', 'dm-legal' ) . '</p>';
}

/**
 * Render one settings field.
 *
 * @param array $args Field args from add_settings_field().
 * @return void
 */
function dm_legal_render_settings_field( $args ) {
	$key         = $args['key'];
	$field       = $args['field'];
	$settings    = dm_legal_get_settings();
	$value       = isset( $settings[ $key ] ) ? (string) $settings[ $key ] : '';
	$id          = 'dm_legal_field_' . $key;
	$name        = DM_LEGAL_SETTINGS_OPTION . '[' . $key . ']';
	$placeholder = isset( $field['placeholder'] ) ? $field['placeholder'] : '';

	if ( 'textarea' === $field['type'] ) {
		printf(
			'<textarea id="%1$s" name="%2$s" rows="3" class="large-text" placeholder="%3$s">%4$s</textarea>',
			esc_attr( $id ),
			esc_attr( $name ),
			esc_attr( $placeholder ),
			esc_textarea( $value )
		);
	} else {
		printf(
			'<input type="%1$s" id="%2$s" name="%3$s" value="%4$s" class="regular-text" placeholder="%5$s" />',
			esc_attr( $field['type'] ),
			esc_attr( $id ),
			esc_attr( $name ),
			esc_attr( $value ),
			esc_attr( $placeholder )
		);
	}

	if ( ! empty( $field['description'] ) ) {
		echo '<p class="description">' . wp_kses( $field['description'], array( 'code' => array(), 'a' => array( 'href' => array() ) ) ) . '</p>';
	}
}

/**
 * Add the "DM Legal" top-level admin menu with the settings screen.
 *
 * @return void
 */
function dm_legal_add_settings_page() {
	add_menu_page(
		__( 'DM Legal Global Settings', 'dm-legal' ),
		__( 'DM Legal', 'dm-legal' ),
		'manage_options',
		'dm-legal-global-settings',
		'dm_legal_render_settings_page',
		'dashicons-bank',
		59
	);

	add_submenu_page(
		'dm-legal-global-settings',
		__( 'DM Legal Global Settings', 'dm-legal' ),
		__( 'Global Settings', 'dm-legal' ),
		'manage_options',
		'dm-legal-global-settings',
		'dm_legal_render_settings_page'
	);
}
add_action( 'admin_menu', 'dm_legal_add_settings_page' );

/**
 * Render the settings screen.
 *
 * @return void
 */
function dm_legal_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<?php settings_errors( DM_LEGAL_SETTINGS_OPTION ); ?>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'dm_legal_global_settings_group' );
			do_settings_sections( 'dm-legal-global-settings' );
			submit_button( __( 'Save Settings', 'dm-legal' ) );
			?>
		</form>
	</div>
	<?php
}

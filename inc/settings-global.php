<?php
/**
 * Global/Header Settings admin page. Settings API only, no ACF. Every
 * template that needs phone/email/address/social/hours reads from this one
 * option (dmlegal_global_settings) — header and footer both, per the
 * "shared fields defined once" convention. No separate Footer Settings page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DMLEGAL_SETTINGS_OPTION', 'dmlegal_global_settings' );

function dmlegal_global_settings_fields(): array {
	return [
		'phone_display'   => [ 'label' => __( 'Phone (display)', 'dmlegal' ), 'sanitize' => 'sanitize_text_field' ],
		'phone_tel'       => [ 'label' => __( 'Phone (tel: link, e.g. +610426269954)', 'dmlegal' ), 'sanitize' => 'sanitize_text_field' ],
		'whatsapp_url'    => [ 'label' => __( 'WhatsApp URL', 'dmlegal' ), 'sanitize' => 'esc_url_raw' ],
		'email'           => [ 'label' => __( 'Email Address', 'dmlegal' ), 'sanitize' => 'sanitize_email' ],
		'address_short'   => [ 'label' => __( 'Address (short, e.g. header display)', 'dmlegal' ), 'sanitize' => 'sanitize_text_field' ],
		'address_full'    => [ 'label' => __( 'Address (full)', 'dmlegal' ), 'sanitize' => 'sanitize_textarea_field' ],
		'maps_url'        => [ 'label' => __( 'Google Maps Link', 'dmlegal' ), 'sanitize' => 'esc_url_raw' ],
		'map_embed_url'   => [ 'label' => __( 'Google Maps Embed URL', 'dmlegal' ), 'sanitize' => 'esc_url_raw' ],
		'office_hours'    => [ 'label' => __( 'Office Hours', 'dmlegal' ), 'sanitize' => 'sanitize_text_field' ],
		'facebook_url'    => [ 'label' => __( 'Facebook URL', 'dmlegal' ), 'sanitize' => 'esc_url_raw' ],
		'instagram_url'   => [ 'label' => __( 'Instagram URL', 'dmlegal' ), 'sanitize' => 'esc_url_raw' ],
		'linkedin_url'    => [ 'label' => __( 'LinkedIn URL', 'dmlegal' ), 'sanitize' => 'esc_url_raw' ],
		'tiktok_url'      => [ 'label' => __( 'TikTok URL', 'dmlegal' ), 'sanitize' => 'esc_url_raw' ],
	];
}

/**
 * Get a single global setting, escaped for the given context at the call
 * site by the caller (this just returns the raw stored value).
 */
function dmlegal_get_setting( string $key, string $default = '' ): string {
	$settings = get_option( DMLEGAL_SETTINGS_OPTION, [] );
	return $settings[ $key ] ?? $default;
}

function dmlegal_register_global_settings() {
	register_setting( 'dmlegal_global_settings_group', DMLEGAL_SETTINGS_OPTION, [
		'type'              => 'array',
		'sanitize_callback' => 'dmlegal_sanitize_global_settings',
		'default'           => [],
	] );

	add_settings_section(
		'dmlegal_global_settings_section',
		__( 'Contact & Social Details', 'dmlegal' ),
		'__return_false',
		'dmlegal-global-settings'
	);

	foreach ( dmlegal_global_settings_fields() as $key => $field ) {
		add_settings_field(
			$key,
			$field['label'],
			'dmlegal_render_global_setting_field',
			'dmlegal-global-settings',
			'dmlegal_global_settings_section',
			[ 'key' => $key ]
		);
	}
}
add_action( 'admin_init', 'dmlegal_register_global_settings' );

function dmlegal_sanitize_global_settings( $value ): array {
	$clean = [];
	if ( ! is_array( $value ) ) {
		return $clean;
	}

	foreach ( dmlegal_global_settings_fields() as $key => $field ) {
		$raw = $value[ $key ] ?? '';
		$clean[ $key ] = call_user_func( $field['sanitize'], wp_unslash( $raw ) );
	}

	return $clean;
}

function dmlegal_render_global_setting_field( array $args ): void {
	$key   = $args['key'];
	$value = dmlegal_get_setting( $key );
	$is_textarea = $key === 'address_full';
	?>
	<?php if ( $is_textarea ) : ?>
		<textarea name="<?php echo esc_attr( DMLEGAL_SETTINGS_OPTION ); ?>[<?php echo esc_attr( $key ); ?>]" rows="3" class="large-text"><?php echo esc_textarea( $value ); ?></textarea>
	<?php else : ?>
		<input type="text" name="<?php echo esc_attr( DMLEGAL_SETTINGS_OPTION ); ?>[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $value ); ?>" class="regular-text">
	<?php endif; ?>
	<?php
}

function dmlegal_add_global_settings_page() {
	add_options_page(
		__( 'DM Legal Global Settings', 'dmlegal' ),
		__( 'DM Legal Settings', 'dmlegal' ),
		'manage_options',
		'dmlegal-global-settings',
		'dmlegal_render_global_settings_page'
	);
}
add_action( 'admin_menu', 'dmlegal_add_global_settings_page' );

function dmlegal_render_global_settings_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'DM Legal Global Settings', 'dmlegal' ); ?></h1>
		<p><?php esc_html_e( 'These fields feed both the site header and footer — there is only one place to update contact details.', 'dmlegal' ); ?></p>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'dmlegal_global_settings_group' );
			do_settings_sections( 'dmlegal-global-settings' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

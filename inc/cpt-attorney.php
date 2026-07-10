<?php
/**
 * Attorney CPT: registration, meta fields, and its meta box.
 *
 * Photo = featured image, bio = post_content (both native, no custom fields
 * needed for those). Fields:
 *   _at_role        (string — job title / specialization)
 *   _at_stat        (string — optional highlight stat, e.g. "300+ successful defences")
 *   _at_credentials (repeater: single "credential" text field per row)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function dmlegal_register_attorney_cpt() {
	register_post_type( 'attorney', [
		'labels' => [
			'name'          => __( 'Attorneys', 'dmlegal' ),
			'singular_name' => __( 'Attorney', 'dmlegal' ),
			'add_new_item'  => __( 'Add New Attorney', 'dmlegal' ),
			'edit_item'     => __( 'Edit Attorney', 'dmlegal' ),
		],
		'public'       => true,
		'show_in_rest' => true,
		'has_archive'  => true,
		'rewrite'      => [ 'slug' => 'attorneys' ],
		'menu_icon'    => 'dashicons-businessperson',
		'supports'     => [ 'title', 'editor', 'thumbnail' ],
	] );
}
add_action( 'init', 'dmlegal_register_attorney_cpt' );

function dmlegal_attorney_credentials_fields(): array {
	return [
		[ 'key' => 'credential', 'label' => __( 'Credential', 'dmlegal' ), 'type' => 'text' ],
	];
}

function dmlegal_register_attorney_meta() {
	$auth_callback = function ( $allowed, $meta_key, $post_id ) {
		return current_user_can( 'edit_post', $post_id );
	};

	register_post_meta( 'attorney', '_at_role', [
		'type'              => 'string',
		'single'            => true,
		'sanitize_callback' => 'sanitize_text_field',
		'auth_callback'     => $auth_callback,
	] );

	register_post_meta( 'attorney', '_at_stat', [
		'type'              => 'string',
		'single'            => true,
		'sanitize_callback' => 'sanitize_text_field',
		'auth_callback'     => $auth_callback,
	] );

	register_post_meta( 'attorney', '_at_credentials', [
		'type'              => 'array',
		'single'            => true,
		'show_in_rest'      => false,
		'sanitize_callback' => function ( $value ) {
			return dmlegal_sanitize_repeater_field( $value, dmlegal_attorney_credentials_fields() );
		},
		'auth_callback' => $auth_callback,
	] );
}
add_action( 'init', 'dmlegal_register_attorney_meta' );

function dmlegal_add_attorney_meta_box() {
	add_meta_box(
		'dmlegal_at_details',
		__( 'Attorney Details', 'dmlegal' ),
		'dmlegal_render_attorney_meta_box',
		'attorney',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'dmlegal_add_attorney_meta_box' );

function dmlegal_render_attorney_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'dmlegal_save_attorney', 'dmlegal_attorney_nonce' );

	$role        = get_post_meta( $post->ID, '_at_role', true );
	$stat        = get_post_meta( $post->ID, '_at_stat', true );
	$credentials = get_post_meta( $post->ID, '_at_credentials', true );
	$credentials = is_array( $credentials ) ? $credentials : [];
	?>
	<p>
		<label for="dmlegal_at_role"><strong><?php esc_html_e( 'Role / Specialization', 'dmlegal' ); ?></strong></label><br>
		<input type="text" id="dmlegal_at_role" name="dmlegal_at_role" value="<?php echo esc_attr( $role ); ?>" style="width:100%;">
	</p>
	<p>
		<label for="dmlegal_at_stat"><strong><?php esc_html_e( 'Highlight Stat (optional, e.g. "300+ successful defences")', 'dmlegal' ); ?></strong></label><br>
		<input type="text" id="dmlegal_at_stat" name="dmlegal_at_stat" value="<?php echo esc_attr( $stat ); ?>" style="width:100%;">
	</p>

	<p><strong><?php esc_html_e( 'Credentials', 'dmlegal' ); ?></strong></p>
	<?php dmlegal_render_repeater_field( 'dmlegal_at_credentials', dmlegal_attorney_credentials_fields(), $credentials ); ?>
	<?php
}

function dmlegal_save_attorney_meta( int $post_id ): void {
	if ( ! isset( $_POST['dmlegal_attorney_nonce'] ) || ! wp_verify_nonce( $_POST['dmlegal_attorney_nonce'], 'dmlegal_save_attorney' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	if ( get_post_type( $post_id ) !== 'attorney' ) {
		return;
	}

	foreach ( [ 'dmlegal_at_role' => '_at_role', 'dmlegal_at_stat' => '_at_stat' ] as $field => $meta_key ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}

	$credentials = $_POST['dmlegal_at_credentials'] ?? [];
	update_post_meta( $post_id, '_at_credentials', dmlegal_sanitize_repeater_field( $credentials, dmlegal_attorney_credentials_fields() ) );
}
add_action( 'save_post_attorney', 'dmlegal_save_attorney_meta' );

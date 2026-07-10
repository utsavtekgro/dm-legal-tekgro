<?php
/**
 * Practice Area CPT: registration, meta fields, and its meta box.
 *
 * Hierarchical: top-level posts are the main practice areas (Family Law,
 * Criminal Law, ...); child posts (post_parent set) are the "inner
 * services" (Drug Offences, Traffic Offences, ...) shown on a parent
 * area's page. Permalinks nest accordingly: /practice-areas/criminal-law/
 * and /practice-areas/criminal-law/drug-offences/.
 *
 * Fields (used at whichever level makes sense — templates skip empty ones):
 *   _pa_icon_id            (int, media attachment ID — SVG or image)
 *   _pa_short_description  (string, used on card/listing views; post_content is the full body)
 *   _pa_actions             (repeater: title, description, icon_id — top-level area's Q&A/services list)
 *   _pa_subtopics           (repeater: title, description, points — inner-service accordion content;
 *                            "points" is one bullet per line, same convention as fee tiers)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function dmlegal_register_practice_area_cpt() {
	register_post_type( 'practice_area', [
		'labels' => [
			'name'          => __( 'Practice Areas', 'dmlegal' ),
			'singular_name' => __( 'Practice Area', 'dmlegal' ),
			'add_new_item'  => __( 'Add New Practice Area', 'dmlegal' ),
			'edit_item'     => __( 'Edit Practice Area', 'dmlegal' ),
			'parent_item_colon' => __( 'Parent Practice Area:', 'dmlegal' ),
		],
		'public'       => true,
		'show_in_rest' => true,
		'hierarchical' => true,
		'has_archive'  => true,
		'rewrite'      => [ 'slug' => 'practice-areas', 'hierarchical' => true ],
		'menu_icon'    => 'dashicons-hammer',
		'supports'     => [ 'title', 'editor', 'thumbnail', 'page-attributes' ],
	] );
}
add_action( 'init', 'dmlegal_register_practice_area_cpt' );

function dmlegal_practice_area_actions_fields(): array {
	return [
		[ 'key' => 'title', 'label' => __( 'Title', 'dmlegal' ), 'type' => 'text' ],
		[ 'key' => 'description', 'label' => __( 'Description', 'dmlegal' ), 'type' => 'textarea' ],
		[ 'key' => 'icon_id', 'label' => __( 'Icon', 'dmlegal' ), 'type' => 'media' ],
	];
}

function dmlegal_practice_area_subtopics_fields(): array {
	return [
		[ 'key' => 'title', 'label' => __( 'Title', 'dmlegal' ), 'type' => 'text' ],
		[ 'key' => 'description', 'label' => __( 'Description', 'dmlegal' ), 'type' => 'textarea' ],
		[ 'key' => 'points', 'label' => __( 'Bullet Points (one per line)', 'dmlegal' ), 'type' => 'textarea' ],
	];
}

function dmlegal_register_practice_area_meta() {
	register_post_meta( 'practice_area', '_pa_icon_id', [
		'type'          => 'integer',
		'single'        => true,
		'sanitize_callback' => 'absint',
		'auth_callback' => function ( $allowed, $meta_key, $post_id ) {
			return current_user_can( 'edit_post', $post_id );
		},
	] );

	register_post_meta( 'practice_area', '_pa_short_description', [
		'type'          => 'string',
		'single'        => true,
		'sanitize_callback' => 'sanitize_text_field',
		'auth_callback' => function ( $allowed, $meta_key, $post_id ) {
			return current_user_can( 'edit_post', $post_id );
		},
	] );

	register_post_meta( 'practice_area', '_pa_actions', [
		'type'          => 'array',
		'single'        => true,
		'show_in_rest'  => false,
		'sanitize_callback' => function ( $value ) {
			return dmlegal_sanitize_repeater_field( $value, dmlegal_practice_area_actions_fields() );
		},
		'auth_callback' => function ( $allowed, $meta_key, $post_id ) {
			return current_user_can( 'edit_post', $post_id );
		},
	] );

	register_post_meta( 'practice_area', '_pa_subtopics', [
		'type'          => 'array',
		'single'        => true,
		'show_in_rest'  => false,
		'sanitize_callback' => function ( $value ) {
			return dmlegal_sanitize_repeater_field( $value, dmlegal_practice_area_subtopics_fields() );
		},
		'auth_callback' => function ( $allowed, $meta_key, $post_id ) {
			return current_user_can( 'edit_post', $post_id );
		},
	] );
}
add_action( 'init', 'dmlegal_register_practice_area_meta' );

function dmlegal_add_practice_area_meta_box() {
	add_meta_box(
		'dmlegal_pa_details',
		__( 'Practice Area Details', 'dmlegal' ),
		'dmlegal_render_practice_area_meta_box',
		'practice_area',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'dmlegal_add_practice_area_meta_box' );

function dmlegal_render_practice_area_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'dmlegal_save_practice_area', 'dmlegal_practice_area_nonce' );

	$icon_id     = (int) get_post_meta( $post->ID, '_pa_icon_id', true );
	$short_desc  = get_post_meta( $post->ID, '_pa_short_description', true );
	$actions     = get_post_meta( $post->ID, '_pa_actions', true );
	$actions     = is_array( $actions ) ? $actions : [];
	$subtopics   = get_post_meta( $post->ID, '_pa_subtopics', true );
	$subtopics   = is_array( $subtopics ) ? $subtopics : [];
	?>
	<p>
		<label for="dmlegal_pa_short_description"><strong><?php esc_html_e( 'Short Description (used on cards/listings)', 'dmlegal' ); ?></strong></label><br>
		<textarea id="dmlegal_pa_short_description" name="dmlegal_pa_short_description" rows="2" style="width:100%;"><?php echo esc_textarea( $short_desc ); ?></textarea>
	</p>

	<p>
		<strong><?php esc_html_e( 'Icon', 'dmlegal' ); ?></strong><br>
		<span class="dmlegal-repeater__media">
			<input type="hidden" class="dmlegal-repeater__media-id" id="dmlegal_pa_icon_id" name="dmlegal_pa_icon_id" value="<?php echo esc_attr( $icon_id ); ?>">
			<span class="dmlegal-repeater__media-preview">
				<?php if ( $icon_id ) : ?>
					<?php echo wp_get_attachment_image( $icon_id, [ 60, 60 ] ); ?>
				<?php endif; ?>
			</span>
			<button type="button" class="button dmlegal-repeater__media-select"><?php esc_html_e( 'Select Icon', 'dmlegal' ); ?></button>
			<button type="button" class="button dmlegal-repeater__media-clear"><?php esc_html_e( 'Clear', 'dmlegal' ); ?></button>
		</span>
	</p>

	<p><strong><?php esc_html_e( 'Sub-Services / Actions (used on a top-level practice area page)', 'dmlegal' ); ?></strong></p>
	<?php dmlegal_render_repeater_field( 'dmlegal_pa_actions', dmlegal_practice_area_actions_fields(), $actions ); ?>

	<p><strong><?php esc_html_e( 'Accordion Sub-Topics (used on an inner-service page, e.g. Drug Offences)', 'dmlegal' ); ?></strong></p>
	<?php dmlegal_render_repeater_field( 'dmlegal_pa_subtopics', dmlegal_practice_area_subtopics_fields(), $subtopics ); ?>
	<?php
}

function dmlegal_save_practice_area_meta( int $post_id ): void {
	if ( ! isset( $_POST['dmlegal_practice_area_nonce'] ) || ! wp_verify_nonce( $_POST['dmlegal_practice_area_nonce'], 'dmlegal_save_practice_area' ) ) {
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

	if ( get_post_type( $post_id ) !== 'practice_area' ) {
		return;
	}

	if ( isset( $_POST['dmlegal_pa_short_description'] ) ) {
		update_post_meta( $post_id, '_pa_short_description', sanitize_text_field( wp_unslash( $_POST['dmlegal_pa_short_description'] ) ) );
	}

	if ( isset( $_POST['dmlegal_pa_icon_id'] ) ) {
		update_post_meta( $post_id, '_pa_icon_id', absint( $_POST['dmlegal_pa_icon_id'] ) );
	}

	$actions = $_POST['dmlegal_pa_actions'] ?? [];
	update_post_meta( $post_id, '_pa_actions', dmlegal_sanitize_repeater_field( $actions, dmlegal_practice_area_actions_fields() ) );

	$subtopics = $_POST['dmlegal_pa_subtopics'] ?? [];
	update_post_meta( $post_id, '_pa_subtopics', dmlegal_sanitize_repeater_field( $subtopics, dmlegal_practice_area_subtopics_fields() ) );
}
add_action( 'save_post_practice_area', 'dmlegal_save_practice_area_meta' );

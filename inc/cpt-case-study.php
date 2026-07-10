<?php
/**
 * Case Study CPT: registration, taxonomy, meta fields, and its meta box.
 *
 * post_excerpt = card teaser, post_content = intro description.
 * Fields:
 *   _cs_practice_area_id (int, related practice_area post ID)
 *   _cs_client / _cs_industry / _cs_featuring (string — the fixed "highlights" trio)
 *   _cs_stats    (repeater: value, description — the result percentages)
 *   _cs_sections (repeater: heading, body — the long-form narrative)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function dmlegal_register_case_study_cpt() {
	register_post_type( 'case_study', [
		'labels' => [
			'name'          => __( 'Case Studies', 'dmlegal' ),
			'singular_name' => __( 'Case Study', 'dmlegal' ),
			'add_new_item'  => __( 'Add New Case Study', 'dmlegal' ),
			'edit_item'     => __( 'Edit Case Study', 'dmlegal' ),
		],
		'public'       => true,
		'show_in_rest' => true,
		'has_archive'  => true,
		'rewrite'      => [ 'slug' => 'case-studies' ],
		'menu_icon'    => 'dashicons-portfolio',
		'supports'     => [ 'title', 'editor', 'excerpt', 'thumbnail' ],
	] );

	register_taxonomy( 'case_study_tag', 'case_study', [
		'labels'       => [ 'name' => __( 'Case Study Tags', 'dmlegal' ) ],
		'public'       => true,
		'show_in_rest' => true,
		'hierarchical' => false,
		'rewrite'      => [ 'slug' => 'case-study-tag' ],
	] );
}
add_action( 'init', 'dmlegal_register_case_study_cpt' );

function dmlegal_case_study_stats_fields(): array {
	return [
		[ 'key' => 'value', 'label' => __( 'Value (e.g. 33%)', 'dmlegal' ), 'type' => 'text' ],
		[ 'key' => 'description', 'label' => __( 'Description', 'dmlegal' ), 'type' => 'textarea' ],
	];
}

function dmlegal_case_study_sections_fields(): array {
	return [
		[ 'key' => 'heading', 'label' => __( 'Heading', 'dmlegal' ), 'type' => 'text' ],
		[ 'key' => 'body', 'label' => __( 'Body', 'dmlegal' ), 'type' => 'textarea' ],
	];
}

function dmlegal_register_case_study_meta() {
	$auth_callback = function ( $allowed, $meta_key, $post_id ) {
		return current_user_can( 'edit_post', $post_id );
	};

	register_post_meta( 'case_study', '_cs_practice_area_id', [
		'type'              => 'integer',
		'single'            => true,
		'sanitize_callback' => 'absint',
		'auth_callback'     => $auth_callback,
	] );

	foreach ( [ '_cs_client', '_cs_industry', '_cs_featuring' ] as $meta_key ) {
		register_post_meta( 'case_study', $meta_key, [
			'type'              => 'string',
			'single'            => true,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => $auth_callback,
		] );
	}

	register_post_meta( 'case_study', '_cs_stats', [
		'type'              => 'array',
		'single'            => true,
		'show_in_rest'      => false,
		'sanitize_callback' => function ( $value ) {
			return dmlegal_sanitize_repeater_field( $value, dmlegal_case_study_stats_fields() );
		},
		'auth_callback' => $auth_callback,
	] );

	register_post_meta( 'case_study', '_cs_sections', [
		'type'              => 'array',
		'single'            => true,
		'show_in_rest'      => false,
		'sanitize_callback' => function ( $value ) {
			return dmlegal_sanitize_repeater_field( $value, dmlegal_case_study_sections_fields() );
		},
		'auth_callback' => $auth_callback,
	] );
}
add_action( 'init', 'dmlegal_register_case_study_meta' );

function dmlegal_add_case_study_meta_box() {
	add_meta_box(
		'dmlegal_cs_details',
		__( 'Case Study Details', 'dmlegal' ),
		'dmlegal_render_case_study_meta_box',
		'case_study',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'dmlegal_add_case_study_meta_box' );

function dmlegal_render_case_study_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'dmlegal_save_case_study', 'dmlegal_case_study_nonce' );

	$practice_area_id = (int) get_post_meta( $post->ID, '_cs_practice_area_id', true );
	$client           = get_post_meta( $post->ID, '_cs_client', true );
	$industry         = get_post_meta( $post->ID, '_cs_industry', true );
	$featuring        = get_post_meta( $post->ID, '_cs_featuring', true );
	$stats            = get_post_meta( $post->ID, '_cs_stats', true );
	$sections         = get_post_meta( $post->ID, '_cs_sections', true );
	$stats            = is_array( $stats ) ? $stats : [];
	$sections         = is_array( $sections ) ? $sections : [];

	$practice_areas = get_posts( [
		'post_type'      => 'practice_area',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
	] );
	?>
	<p>
		<label for="dmlegal_cs_practice_area_id"><strong><?php esc_html_e( 'Related Practice Area', 'dmlegal' ); ?></strong></label><br>
		<select id="dmlegal_cs_practice_area_id" name="dmlegal_cs_practice_area_id">
			<option value=""><?php esc_html_e( '— None —', 'dmlegal' ); ?></option>
			<?php foreach ( $practice_areas as $area ) : ?>
				<option value="<?php echo esc_attr( $area->ID ); ?>" <?php selected( $practice_area_id, $area->ID ); ?>>
					<?php echo esc_html( get_the_title( $area ) ); ?>
				</option>
			<?php endforeach; ?>
		</select>
	</p>

	<p>
		<label for="dmlegal_cs_client"><strong><?php esc_html_e( 'Client', 'dmlegal' ); ?></strong></label><br>
		<input type="text" id="dmlegal_cs_client" name="dmlegal_cs_client" value="<?php echo esc_attr( $client ); ?>" style="width:100%;">
	</p>
	<p>
		<label for="dmlegal_cs_industry"><strong><?php esc_html_e( 'Industry', 'dmlegal' ); ?></strong></label><br>
		<input type="text" id="dmlegal_cs_industry" name="dmlegal_cs_industry" value="<?php echo esc_attr( $industry ); ?>" style="width:100%;">
	</p>
	<p>
		<label for="dmlegal_cs_featuring"><strong><?php esc_html_e( 'Featuring', 'dmlegal' ); ?></strong></label><br>
		<input type="text" id="dmlegal_cs_featuring" name="dmlegal_cs_featuring" value="<?php echo esc_attr( $featuring ); ?>" style="width:100%;">
	</p>

	<p><strong><?php esc_html_e( 'Result Stats', 'dmlegal' ); ?></strong></p>
	<?php dmlegal_render_repeater_field( 'dmlegal_cs_stats', dmlegal_case_study_stats_fields(), $stats ); ?>

	<p><strong><?php esc_html_e( 'Narrative Sections', 'dmlegal' ); ?></strong></p>
	<?php dmlegal_render_repeater_field( 'dmlegal_cs_sections', dmlegal_case_study_sections_fields(), $sections ); ?>
	<?php
}

function dmlegal_save_case_study_meta( int $post_id ): void {
	if ( ! isset( $_POST['dmlegal_case_study_nonce'] ) || ! wp_verify_nonce( $_POST['dmlegal_case_study_nonce'], 'dmlegal_save_case_study' ) ) {
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

	if ( get_post_type( $post_id ) !== 'case_study' ) {
		return;
	}

	if ( isset( $_POST['dmlegal_cs_practice_area_id'] ) ) {
		$related_id = absint( $_POST['dmlegal_cs_practice_area_id'] );
		if ( $related_id && get_post_type( $related_id ) !== 'practice_area' ) {
			$related_id = 0;
		}
		update_post_meta( $post_id, '_cs_practice_area_id', $related_id );
	}

	foreach ( [ 'dmlegal_cs_client' => '_cs_client', 'dmlegal_cs_industry' => '_cs_industry', 'dmlegal_cs_featuring' => '_cs_featuring' ] as $field => $meta_key ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}

	$stats = $_POST['dmlegal_cs_stats'] ?? [];
	update_post_meta( $post_id, '_cs_stats', dmlegal_sanitize_repeater_field( $stats, dmlegal_case_study_stats_fields() ) );

	$sections = $_POST['dmlegal_cs_sections'] ?? [];
	update_post_meta( $post_id, '_cs_sections', dmlegal_sanitize_repeater_field( $sections, dmlegal_case_study_sections_fields() ) );
}
add_action( 'save_post_case_study', 'dmlegal_save_case_study_meta' );

<?php
/**
 * Custom post types for DM Legal.
 *
 * Practice Area: replaces the static $legalServicesData array so practice
 * areas are managed from wp-admin. Routing stays on the legacy
 * practice-area.php?slug= scheme (see url() in inc/legacy-helpers.php and
 * find_practice_area_by_slug()), so the CPT is queried by its post slug
 * rather than relying on pretty permalinks.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the Practice Area custom post type.
 *
 * The rewrite slug is intentionally "practice-areas" (plural) to avoid
 * colliding with the existing "practice-area" Page that page-practice-area.php
 * renders.
 *
 * @return void
 */
function dm_legal_register_practice_area_cpt() {
	$labels = array(
		'name'               => __( 'Practice Areas', 'dm-legal' ),
		'singular_name'      => __( 'Practice Area', 'dm-legal' ),
		'menu_name'          => __( 'Practice Areas', 'dm-legal' ),
		'add_new'            => __( 'Add New', 'dm-legal' ),
		'add_new_item'       => __( 'Add New Practice Area', 'dm-legal' ),
		'edit_item'          => __( 'Edit Practice Area', 'dm-legal' ),
		'new_item'           => __( 'New Practice Area', 'dm-legal' ),
		'view_item'          => __( 'View Practice Area', 'dm-legal' ),
		'search_items'       => __( 'Search Practice Areas', 'dm-legal' ),
		'not_found'          => __( 'No practice areas found', 'dm-legal' ),
		'not_found_in_trash' => __( 'No practice areas found in Trash', 'dm-legal' ),
		'all_items'          => __( 'All Practice Areas', 'dm-legal' ),
	);

	register_post_type(
		'practice_area',
		array(
			'labels'             => $labels,
			'public'             => true,
			'has_archive'        => false,
			'show_in_rest'       => false, // Classic editor (matches theme-wide setting).
			'menu_icon'          => 'dashicons-portfolio',
			'menu_position'      => 22,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
			'rewrite'            => array( 'slug' => 'practice-areas' ),
			'publicly_queryable' => true,
			'hierarchical'       => false,
		)
	);
}
add_action( 'init', 'dm_legal_register_practice_area_cpt' );

/**
 * Resolve the best image URL for a practice area.
 *
 * Order: featured image → the "_dm_pa_image" fallback meta (may be a legacy
 * /assets path) → a generic default.
 *
 * @param int $post_id Practice area post ID.
 * @return string Absolute image URL.
 */
function dm_legal_pa_image_url( $post_id ) {
	$thumb = get_the_post_thumbnail_url( $post_id, 'large' );
	if ( $thumb ) {
		return $thumb;
	}

	$meta = trim( (string) get_post_meta( $post_id, '_dm_pa_image', true ) );
	if ( '' !== $meta ) {
		return url( $meta );
	}

	return url( '/assets/images/practicearea-img.png' );
}

/**
 * Normalise a practice_area post into the array shape the legacy templates
 * expect (title / description / image / innerServiceCount / slug / ID).
 *
 * @param WP_Post $post Practice area post.
 * @return array
 */
function dm_legal_practice_area_fields( $post ) {
	$excerpt = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_strip_all_tags( (string) $post->post_content );
	$count   = (int) get_post_meta( $post->ID, '_dm_pa_inner_count', true );

	return array(
		'ID'                => (int) $post->ID,
		'title'             => get_the_title( $post ),
		'description'       => trim( (string) $excerpt ),
		'image'             => dm_legal_pa_image_url( $post->ID ),
		'innerServiceCount' => $count > 0 ? $count : 2,
		'slug'              => $post->post_name,
	);
}

/* =====================================================================
 * PRACTICE AREA DETAILS METABOX
 * ================================================================== */

/**
 * Register the Practice Area details metabox.
 *
 * @return void
 */
function dm_legal_add_practice_area_metabox() {
	add_meta_box(
		'dm_legal_practice_area_details',
		__( 'Practice Area Details', 'dm-legal' ),
		'dm_legal_render_practice_area_metabox',
		'practice_area',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes_practice_area', 'dm_legal_add_practice_area_metabox' );

/**
 * Render the Practice Area details metabox.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_practice_area_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_practice_area', 'dm_legal_practice_area_nonce' );

	$count = get_post_meta( $post->ID, '_dm_pa_inner_count', true );
	$image = get_post_meta( $post->ID, '_dm_pa_image', true );
	?>
	<p>
		<label for="dm_pa_inner_count" style="display:block;font-weight:600;margin-bottom:4px;"><?php esc_html_e( 'Inner Service Count', 'dm-legal' ); ?></label>
		<input type="number" id="dm_pa_inner_count" name="_dm_pa_inner_count" value="<?php echo esc_attr( $count ); ?>" min="0" max="12" style="width:100%;" placeholder="2">
		<span class="description"><?php esc_html_e( 'How many inner services show under “Explore … Services”.', 'dm-legal' ); ?></span>
	</p>

	<p style="margin-top:12px;">
		<label for="dm_pa_image" style="display:block;font-weight:600;margin-bottom:4px;"><?php esc_html_e( 'Card Image Fallback', 'dm-legal' ); ?></label>
		<img src="<?php echo esc_url( $image ? url( $image ) : '' ); ?>" id="dm_pa_image_preview" style="max-width:100%;height:auto;display:<?php echo $image ? 'block' : 'none'; ?>;margin-bottom:6px;border:1px solid #dcdcde;border-radius:4px;" alt="">
		<input type="text" id="dm_pa_image" name="_dm_pa_image" value="<?php echo esc_attr( $image ); ?>" style="width:100%;" placeholder="/assets/images/…">
		<span class="description"><?php esc_html_e( 'Only used if no Featured Image is set. Set a Featured Image for best results.', 'dm-legal' ); ?></span>
	</p>
	<?php
}

/**
 * Save the Practice Area details metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_practice_area_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_practice_area_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_practice_area_nonce'] ) ), 'dm_legal_save_practice_area' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$count = isset( $_POST['_dm_pa_inner_count'] ) ? absint( wp_unslash( $_POST['_dm_pa_inner_count'] ) ) : 0;
	if ( $count > 0 ) {
		update_post_meta( $post_id, '_dm_pa_inner_count', $count );
	} else {
		delete_post_meta( $post_id, '_dm_pa_inner_count' );
	}

	$image = isset( $_POST['_dm_pa_image'] ) ? sanitize_text_field( wp_unslash( $_POST['_dm_pa_image'] ) ) : '';
	if ( '' === $image ) {
		delete_post_meta( $post_id, '_dm_pa_image' );
	} else {
		update_post_meta( $post_id, '_dm_pa_image', $image );
	}
}
add_action( 'save_post_practice_area', 'dm_legal_save_practice_area_metabox' );

/* =====================================================================
 * ONE-TIME SEEDING
 *
 * Seed the CPT from the existing static $legalServicesData so the Practice
 * Area pages are not empty on first run. Idempotent, guarded by an option.
 * ================================================================== */

/**
 * Create practice_area posts from $legalServicesData once.
 *
 * @return void
 */
function dm_legal_provision_practice_areas() {
	if ( get_option( 'dm_legal_practice_areas_created' ) ) {
		return;
	}

	global $legalServicesData;

	if ( ! empty( $legalServicesData ) && is_array( $legalServicesData ) ) {
		foreach ( $legalServicesData as $area ) {
			$title = isset( $area['title'] ) ? $area['title'] : '';
			if ( '' === $title ) {
				continue;
			}

			// Skip if a post with this slug already exists.
			if ( get_page_by_path( slugify( $title ), OBJECT, 'practice_area' ) ) {
				continue;
			}

			$post_id = wp_insert_post(
				array(
					'post_type'    => 'practice_area',
					'post_status'  => 'publish',
					'post_title'   => $title,
					'post_name'    => slugify( $title ),
					'post_excerpt' => isset( $area['description'] ) ? $area['description'] : '',
					'post_content' => isset( $area['description'] ) ? $area['description'] : '',
				)
			);

			if ( $post_id && ! is_wp_error( $post_id ) ) {
				if ( isset( $area['innerServiceCount'] ) ) {
					update_post_meta( $post_id, '_dm_pa_inner_count', (int) $area['innerServiceCount'] );
				}
				if ( isset( $area['image'] ) ) {
					update_post_meta( $post_id, '_dm_pa_image', $area['image'] );
				}
			}
		}
	}

	update_option( 'dm_legal_practice_areas_created', DM_LEGAL_VERSION );
}
add_action( 'admin_init', 'dm_legal_provision_practice_areas' );

/**
 * Flush rewrite rules once the CPT exists, so its rewrite slug works.
 *
 * @return void
 */
function dm_legal_practice_area_flush_rewrites() {
	dm_legal_register_practice_area_cpt();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'dm_legal_practice_area_flush_rewrites' );

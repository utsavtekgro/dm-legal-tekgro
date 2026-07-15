<?php
/**
 * Practice Area detail-view metaboxes.
 *
 * Makes the single practice area detail view (page-practice-area.php with a
 * ?slug) editable per area from wp-admin, instead of reading the static
 * $actionsDataBySlug / $steps / $consultationCostFAQ arrays. Each *_args()
 * helper merges saved meta over the template defaults, so an area renders
 * exactly as before until an editor overrides something.
 *
 * Reuses dm_legal_repeater_script() and dm_legal_media_picker_script() from
 * inc/metaboxes.php for the add/remove + media-picker behaviour.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the detail-view metaboxes on the practice_area CPT.
 *
 * @return void
 */
function dm_legal_add_practice_area_detail_metaboxes() {
	add_meta_box( 'dm_pa_hero', __( 'Detail Hero', 'dm-legal' ), 'dm_legal_render_pa_hero_metabox', 'practice_area', 'normal', 'high' );
	add_meta_box( 'dm_pa_actions', __( 'Actions Section', 'dm-legal' ), 'dm_legal_render_pa_actions_metabox', 'practice_area', 'normal', 'high' );
	add_meta_box( 'dm_pa_steps', __( 'Process Steps', 'dm-legal' ), 'dm_legal_render_pa_steps_metabox', 'practice_area', 'normal', 'default' );
	add_meta_box( 'dm_pa_faq', __( 'FAQ Section', 'dm-legal' ), 'dm_legal_render_pa_faq_metabox', 'practice_area', 'normal', 'default' );
}
add_action( 'add_meta_boxes_practice_area', 'dm_legal_add_practice_area_detail_metaboxes' );

/* =====================================================================
 * DETAIL HERO
 * ================================================================== */

/**
 * Render the Detail Hero metabox.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_pa_hero_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_pa_hero', 'dm_legal_pa_hero_nonce' );

	$title    = get_post_meta( $post->ID, '_dm_pa_hero_title', true );
	$subtitle = get_post_meta( $post->ID, '_dm_pa_hero_subtitle', true );
	$image    = get_post_meta( $post->ID, '_dm_pa_hero_image', true );
	?>
	<style>
		.dm-pah-field { margin-bottom:14px; }
		.dm-pah-field > label { display:block; font-weight:600; margin-bottom:4px; }
		.dm-pah-field input[type=text], .dm-pah-field input[type=url], .dm-pah-field textarea { width:100%; max-width:760px; }
		.dm-pah-preview { max-width:220px; height:auto; display:block; margin-bottom:8px; border:1px solid #dcdcde; border-radius:4px; }
	</style>

	<p class="description"><?php esc_html_e( 'Leave a field blank to keep the template default.', 'dm-legal' ); ?></p>

	<div class="dm-pah-field">
		<label for="dm_pa_hero_title"><?php esc_html_e( 'Hero Title', 'dm-legal' ); ?></label>
		<input type="text" id="dm_pa_hero_title" name="_dm_pa_hero_title" value="<?php echo esc_attr( $title ); ?>">
	</div>

	<div class="dm-pah-field">
		<label for="dm_pa_hero_subtitle"><?php esc_html_e( 'Hero Subtitle', 'dm-legal' ); ?></label>
		<textarea id="dm_pa_hero_subtitle" name="_dm_pa_hero_subtitle" rows="2"><?php echo esc_textarea( $subtitle ); ?></textarea>
	</div>

	<div class="dm-pah-field">
		<label for="dm_pa_hero_image"><?php esc_html_e( 'Hero Image', 'dm-legal' ); ?></label>
		<img src="<?php echo esc_url( $image ? url( $image ) : '' ); ?>" class="dm-pah-preview dm-media-preview" id="dm_pa_hero_preview" <?php echo $image ? '' : 'style="display:none;"'; ?> alt="">
		<input type="text" id="dm_pa_hero_image" class="dm-media-input" name="_dm_pa_hero_image" value="<?php echo esc_attr( $image ); ?>" placeholder="<?php esc_attr_e( 'Image URL', 'dm-legal' ); ?>">
		<p style="margin-top:6px;">
			<button type="button" class="button dm-media-select" data-target="#dm_pa_hero_image" data-preview="#dm_pa_hero_preview"><?php esc_html_e( 'Select Image', 'dm-legal' ); ?></button>
			<button type="button" class="button dm-media-clear" data-target="#dm_pa_hero_image" data-preview="#dm_pa_hero_preview"><?php esc_html_e( 'Clear', 'dm-legal' ); ?></button>
		</p>
	</div>
	<?php
	dm_legal_media_picker_script();
}

/**
 * Save the Detail Hero metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_pa_hero_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_pa_hero_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_pa_hero_nonce'] ) ), 'dm_legal_save_pa_hero' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$simple = array(
		'_dm_pa_hero_title'    => 'sanitize_text_field',
		'_dm_pa_hero_subtitle' => 'sanitize_textarea_field',
		'_dm_pa_hero_image'    => 'sanitize_text_field',
	);
	foreach ( $simple as $key => $sanitiser ) {
		$raw   = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
		$value = call_user_func( $sanitiser, $raw );
		if ( '' === $value ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}
}
add_action( 'save_post_practice_area', 'dm_legal_save_pa_hero_metabox' );

/**
 * Merge saved hero meta over the template defaults.
 *
 * @param array $defaults Keys: title, subtitle, image.
 * @param int   $post_id  Practice area post ID.
 * @return array
 */
function dm_legal_pa_hero_args( array $defaults, $post_id ) {
	$args = $defaults;

	$title = trim( (string) get_post_meta( $post_id, '_dm_pa_hero_title', true ) );
	if ( '' !== $title ) {
		$args['title'] = $title;
	}
	$subtitle = trim( (string) get_post_meta( $post_id, '_dm_pa_hero_subtitle', true ) );
	if ( '' !== $subtitle ) {
		$args['subtitle'] = $subtitle;
	}
	$image = trim( (string) get_post_meta( $post_id, '_dm_pa_hero_image', true ) );
	if ( '' !== $image ) {
		$args['image'] = $image;
	}

	return $args;
}

/* =====================================================================
 * ACTIONS SECTION (per area)
 * ================================================================== */

/**
 * Render the Actions metabox.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_pa_actions_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_pa_actions', 'dm_legal_pa_actions_nonce' );

	$title   = get_post_meta( $post->ID, '_dm_pa_actions_title', true );
	$desc    = get_post_meta( $post->ID, '_dm_pa_actions_desc', true );
	$subdesc = get_post_meta( $post->ID, '_dm_pa_actions_subdesc', true );
	$items   = get_post_meta( $post->ID, '_dm_pa_actions_items', true );
	$items   = is_array( $items ) ? $items : array();
	$images  = get_post_meta( $post->ID, '_dm_pa_actions_images', true );
	$images  = is_array( $images ) ? $images : array();
	?>
	<style>
		.dm-paa-field { margin-bottom:14px; }
		.dm-paa-field > label { display:block; font-weight:600; margin-bottom:4px; }
		.dm-paa-field input[type=text], .dm-paa-field textarea { width:100%; max-width:760px; }
		.dm-paa-img { display:inline-flex; flex-direction:column; align-items:center; gap:6px; border:1px solid #dcdcde; border-radius:4px; padding:8px; margin:0 8px 8px 0; background:#fff; position:relative; width:120px; vertical-align:top; }
		.dm-paa-img img { width:100%; height:64px; object-fit:cover; border-radius:4px; }
		.dm-paa-img input { width:100%; font-size:11px; }
	</style>

	<p class="description"><?php esc_html_e( 'The Actions block is hidden on the front-end if the title and all questions are blank. Leave heading fields blank to keep the template default.', 'dm-legal' ); ?></p>

	<div class="dm-paa-field">
		<label for="dm_pa_actions_title"><?php esc_html_e( 'Title', 'dm-legal' ); ?></label>
		<input type="text" id="dm_pa_actions_title" name="_dm_pa_actions_title" value="<?php echo esc_attr( $title ); ?>">
	</div>

	<div class="dm-paa-field">
		<label for="dm_pa_actions_desc"><?php esc_html_e( 'Description', 'dm-legal' ); ?></label>
		<textarea id="dm_pa_actions_desc" name="_dm_pa_actions_desc" rows="2"><?php echo esc_textarea( $desc ); ?></textarea>
	</div>

	<div class="dm-paa-field">
		<label for="dm_pa_actions_subdesc"><?php esc_html_e( 'Sub-Description (below the list)', 'dm-legal' ); ?></label>
		<textarea id="dm_pa_actions_subdesc" name="_dm_pa_actions_subdesc" rows="2"><?php echo esc_textarea( $subdesc ); ?></textarea>
	</div>

	<h4><?php esc_html_e( 'Action Items', 'dm-legal' ); ?></h4>
	<div id="dm-paa-items" class="dm-rep-list">
		<?php foreach ( $items as $i => $item ) : ?>
			<?php
			dm_legal_render_pa_action_item_row(
				(int) $i,
				isset( $item['question'] ) ? $item['question'] : '',
				isset( $item['answer'] ) ? $item['answer'] : ''
			);
			?>
		<?php endforeach; ?>
	</div>
	<p><button type="button" class="button button-secondary dm-rep-add" data-list="#dm-paa-items" data-tmpl="#tmpl-dm-paa-item" data-item=".dm-rep-row"><?php esc_html_e( '+ Add Action', 'dm-legal' ); ?></button></p>

	<h4><?php esc_html_e( 'Images', 'dm-legal' ); ?></h4>
	<div id="dm-paa-images">
		<?php foreach ( $images as $i => $img ) : ?>
			<?php dm_legal_render_pa_action_image_row( (int) $i, $img ); ?>
		<?php endforeach; ?>
	</div>
	<p><button type="button" class="button button-secondary dm-rep-add" data-list="#dm-paa-images" data-tmpl="#tmpl-dm-paa-image" data-item=".dm-paa-img"><?php esc_html_e( '+ Add Image', 'dm-legal' ); ?></button></p>

	<script type="text/html" id="tmpl-dm-paa-item">
		<?php dm_legal_render_pa_action_item_row( '__i__', '', '' ); ?>
	</script>
	<script type="text/html" id="tmpl-dm-paa-image">
		<?php dm_legal_render_pa_action_image_row( '__i__', '' ); ?>
	</script>
	<?php
	dm_legal_repeater_script();
	dm_legal_media_picker_script();
}

/**
 * Render one action Q&A row.
 *
 * @param int|string $index    Row index.
 * @param string     $question Question.
 * @param string     $answer   Answer.
 * @return void
 */
function dm_legal_render_pa_action_item_row( $index, $question, $answer ) {
	$name = '_dm_pa_actions_items[' . $index . ']';
	?>
	<div class="dm-rep-row" data-index="<?php echo esc_attr( $index ); ?>">
		<button type="button" class="button-link dm-rep-remove" aria-label="<?php esc_attr_e( 'Remove action', 'dm-legal' ); ?>">&times;</button>
		<div class="dm-rep-grid">
			<label><?php esc_html_e( 'Question', 'dm-legal' ); ?></label>
			<div><input type="text" name="<?php echo esc_attr( $name ); ?>[question]" value="<?php echo esc_attr( $question ); ?>"></div>

			<label><?php esc_html_e( 'Answer', 'dm-legal' ); ?></label>
			<div><textarea name="<?php echo esc_attr( $name ); ?>[answer]" rows="2"><?php echo esc_textarea( $answer ); ?></textarea></div>
		</div>
	</div>
	<?php
}

/**
 * Render one action image row.
 *
 * @param int|string $index Row index.
 * @param string     $img   Image URL.
 * @return void
 */
function dm_legal_render_pa_action_image_row( $index, $img ) {
	?>
	<div class="dm-paa-img" data-index="<?php echo esc_attr( $index ); ?>">
		<button type="button" class="button-link dm-rep-remove" aria-label="<?php esc_attr_e( 'Remove image', 'dm-legal' ); ?>">&times;</button>
		<img src="<?php echo esc_url( $img ? url( $img ) : '' ); ?>" class="dm-media-preview" <?php echo $img ? '' : 'style="display:none;"'; ?> alt="">
		<input type="text" class="dm-media-input" name="_dm_pa_actions_images[<?php echo esc_attr( $index ); ?>]" value="<?php echo esc_attr( $img ); ?>" placeholder="<?php esc_attr_e( 'Image URL', 'dm-legal' ); ?>">
		<button type="button" class="button button-small dm-media-select"><?php esc_html_e( 'Select', 'dm-legal' ); ?></button>
	</div>
	<?php
}

/**
 * Save the Actions metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_pa_actions_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_pa_actions_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_pa_actions_nonce'] ) ), 'dm_legal_save_pa_actions' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$simple = array(
		'_dm_pa_actions_title'   => 'sanitize_text_field',
		'_dm_pa_actions_desc'    => 'sanitize_textarea_field',
		'_dm_pa_actions_subdesc' => 'sanitize_textarea_field',
	);
	foreach ( $simple as $key => $sanitiser ) {
		$raw   = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
		$value = call_user_func( $sanitiser, $raw );
		if ( '' === $value ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}

	// Action items repeater: keep rows with a question.
	$raw   = isset( $_POST['_dm_pa_actions_items'] ) ? wp_unslash( $_POST['_dm_pa_actions_items'] ) : array();
	$items = array();
	if ( is_array( $raw ) ) {
		foreach ( $raw as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$question = isset( $row['question'] ) ? sanitize_text_field( $row['question'] ) : '';
			$answer   = isset( $row['answer'] ) ? sanitize_textarea_field( $row['answer'] ) : '';
			if ( '' === $question ) {
				continue;
			}
			$items[] = array(
				'question' => $question,
				'answer'   => $answer,
			);
		}
	}
	if ( empty( $items ) ) {
		delete_post_meta( $post_id, '_dm_pa_actions_items' );
	} else {
		update_post_meta( $post_id, '_dm_pa_actions_items', $items );
	}

	// Images: flat list of URLs; drop empties.
	$raw    = isset( $_POST['_dm_pa_actions_images'] ) ? wp_unslash( $_POST['_dm_pa_actions_images'] ) : array();
	$images = array();
	if ( is_array( $raw ) ) {
		foreach ( $raw as $img ) {
			$img = sanitize_text_field( trim( (string) $img ) );
			if ( '' !== $img ) {
				$images[] = $img;
			}
		}
	}
	if ( empty( $images ) ) {
		delete_post_meta( $post_id, '_dm_pa_actions_images' );
	} else {
		update_post_meta( $post_id, '_dm_pa_actions_images', $images );
	}
}
add_action( 'save_post_practice_area', 'dm_legal_save_pa_actions_metabox' );

/**
 * Build the Actions data for a practice area, or null if none.
 *
 * @param int        $post_id Practice area post ID.
 * @param array|null $default Static fallback (e.g. $actionsDataBySlug[$slug]).
 * @return array|null
 */
function dm_legal_pa_actions( $post_id, $default = null ) {
	$title   = trim( (string) get_post_meta( $post_id, '_dm_pa_actions_title', true ) );
	$items   = get_post_meta( $post_id, '_dm_pa_actions_items', true );
	$items   = is_array( $items ) ? $items : array();
	$images  = get_post_meta( $post_id, '_dm_pa_actions_images', true );
	$images  = is_array( $images ) ? $images : array();
	$desc    = trim( (string) get_post_meta( $post_id, '_dm_pa_actions_desc', true ) );
	$subdesc = trim( (string) get_post_meta( $post_id, '_dm_pa_actions_subdesc', true ) );

	// Nothing saved for this area — use the static fallback (may be null).
	if ( '' === $title && empty( $items ) && empty( $images ) ) {
		return $default;
	}

	return array(
		'title'           => '' !== $title ? $title : ( isset( $default['title'] ) ? $default['title'] : '' ),
		'description'     => '' !== $desc ? $desc : ( isset( $default['description'] ) ? $default['description'] : '' ),
		'sub-description' => '' !== $subdesc ? $subdesc : ( isset( $default['sub-description'] ) ? $default['sub-description'] : '' ),
		'actions'         => ! empty( $items ) ? $items : ( isset( $default['actions'] ) ? $default['actions'] : array() ),
		'images'          => ! empty( $images ) ? $images : ( isset( $default['images'] ) ? $default['images'] : array() ),
	);
}

/* =====================================================================
 * PROCESS STEPS (per area, falls back to shared defaults)
 * ================================================================== */

/**
 * Render the Process Steps metabox.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_pa_steps_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_pa_steps', 'dm_legal_pa_steps_nonce' );

	$steps = get_post_meta( $post->ID, '_dm_pa_steps', true );
	$steps = is_array( $steps ) ? $steps : array();
	?>
	<p class="description"><?php esc_html_e( 'Leave empty to use the default process steps. Add at least one to override them for this area.', 'dm-legal' ); ?></p>

	<div id="dm-pas-steps" class="dm-rep-list">
		<?php foreach ( $steps as $i => $step ) : ?>
			<?php
			dm_legal_render_pa_step_row(
				(int) $i,
				isset( $step['image'] ) ? $step['image'] : '',
				isset( $step['title'] ) ? $step['title'] : '',
				isset( $step['description'] ) ? $step['description'] : ''
			);
			?>
		<?php endforeach; ?>
	</div>
	<p><button type="button" class="button button-secondary dm-rep-add" data-list="#dm-pas-steps" data-tmpl="#tmpl-dm-pas-step" data-item=".dm-rep-row"><?php esc_html_e( '+ Add Step', 'dm-legal' ); ?></button></p>

	<script type="text/html" id="tmpl-dm-pas-step">
		<?php dm_legal_render_pa_step_row( '__i__', '', '', '' ); ?>
	</script>
	<?php
	dm_legal_repeater_script();
	dm_legal_media_picker_script();
}

/**
 * Render one process-step row.
 *
 * @param int|string $index       Row index.
 * @param string     $image       Icon URL.
 * @param string     $title       Title.
 * @param string     $description Description.
 * @return void
 */
function dm_legal_render_pa_step_row( $index, $image, $title, $description ) {
	$name = '_dm_pa_steps[' . $index . ']';
	?>
	<div class="dm-rep-row" data-index="<?php echo esc_attr( $index ); ?>">
		<button type="button" class="button-link dm-rep-remove" aria-label="<?php esc_attr_e( 'Remove step', 'dm-legal' ); ?>">&times;</button>
		<div class="dm-rep-grid">
			<label><?php esc_html_e( 'Icon', 'dm-legal' ); ?></label>
			<div>
				<img src="<?php echo esc_url( $image ? url( $image ) : '' ); ?>" class="dm-rep-icon dm-media-preview" <?php echo $image ? '' : 'style="display:none;"'; ?> alt="">
				<input type="text" class="dm-media-input" name="<?php echo esc_attr( $name ); ?>[image]" value="<?php echo esc_attr( $image ); ?>" placeholder="<?php esc_attr_e( 'Icon URL', 'dm-legal' ); ?>">
				<p style="margin:6px 0 0;">
					<button type="button" class="button dm-media-select"><?php esc_html_e( 'Select Icon', 'dm-legal' ); ?></button>
					<button type="button" class="button dm-media-clear"><?php esc_html_e( 'Clear', 'dm-legal' ); ?></button>
				</p>
			</div>

			<label><?php esc_html_e( 'Title', 'dm-legal' ); ?></label>
			<div><input type="text" name="<?php echo esc_attr( $name ); ?>[title]" value="<?php echo esc_attr( $title ); ?>"></div>

			<label><?php esc_html_e( 'Description', 'dm-legal' ); ?></label>
			<div><textarea name="<?php echo esc_attr( $name ); ?>[description]" rows="2"><?php echo esc_textarea( $description ); ?></textarea></div>
		</div>
	</div>
	<?php
}

/**
 * Save the Process Steps metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_pa_steps_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_pa_steps_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_pa_steps_nonce'] ) ), 'dm_legal_save_pa_steps' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$raw   = isset( $_POST['_dm_pa_steps'] ) ? wp_unslash( $_POST['_dm_pa_steps'] ) : array();
	$steps = array();
	if ( is_array( $raw ) ) {
		foreach ( $raw as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$title       = isset( $row['title'] ) ? sanitize_text_field( $row['title'] ) : '';
			$description = isset( $row['description'] ) ? sanitize_textarea_field( $row['description'] ) : '';
			$image       = isset( $row['image'] ) ? sanitize_text_field( trim( $row['image'] ) ) : '';
			if ( '' === $title && '' === $description ) {
				continue;
			}
			$steps[] = array(
				'image'       => $image,
				'title'       => $title,
				'description' => $description,
			);
		}
	}
	if ( empty( $steps ) ) {
		delete_post_meta( $post_id, '_dm_pa_steps' );
	} else {
		update_post_meta( $post_id, '_dm_pa_steps', $steps );
	}
}
add_action( 'save_post_practice_area', 'dm_legal_save_pa_steps_metabox' );

/**
 * Return per-area process steps, or the shared default.
 *
 * @param int   $post_id  Practice area post ID.
 * @param array $default  Shared default steps.
 * @return array
 */
function dm_legal_pa_steps( $post_id, array $default ) {
	$steps = get_post_meta( $post_id, '_dm_pa_steps', true );
	return ( is_array( $steps ) && ! empty( $steps ) ) ? $steps : $default;
}

/* =====================================================================
 * FAQ SECTION (per area, falls back to shared defaults)
 * ================================================================== */

/**
 * Render the FAQ metabox.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_pa_faq_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_pa_faq', 'dm_legal_pa_faq_nonce' );

	$heading = get_post_meta( $post->ID, '_dm_pa_faq_heading', true );
	$lead    = get_post_meta( $post->ID, '_dm_pa_faq_lead', true );
	$items   = get_post_meta( $post->ID, '_dm_pa_faq_items', true );
	$items   = is_array( $items ) ? $items : array();
	?>
	<style>
		.dm-paf-field { margin-bottom:14px; }
		.dm-paf-field > label { display:block; font-weight:600; margin-bottom:4px; }
		.dm-paf-field input[type=text], .dm-paf-field textarea { width:100%; max-width:760px; }
	</style>

	<p class="description"><?php esc_html_e( 'Leave heading/lead blank to keep the template default. Questions replace the defaults only if you add at least one.', 'dm-legal' ); ?></p>

	<div class="dm-paf-field">
		<label for="dm_pa_faq_heading"><?php esc_html_e( 'Heading', 'dm-legal' ); ?></label>
		<input type="text" id="dm_pa_faq_heading" name="_dm_pa_faq_heading" value="<?php echo esc_attr( $heading ); ?>" placeholder="Frequently Asked Questions">
	</div>

	<div class="dm-paf-field">
		<label for="dm_pa_faq_lead"><?php esc_html_e( 'Lead Paragraph', 'dm-legal' ); ?></label>
		<textarea id="dm_pa_faq_lead" name="_dm_pa_faq_lead" rows="2"><?php echo esc_textarea( $lead ); ?></textarea>
	</div>

	<h4><?php esc_html_e( 'Questions', 'dm-legal' ); ?></h4>
	<div id="dm-paf-items" class="dm-rep-list">
		<?php foreach ( $items as $i => $item ) : ?>
			<?php
			dm_legal_render_pa_faq_item_row(
				(int) $i,
				isset( $item['question'] ) ? $item['question'] : '',
				isset( $item['answer'] ) ? $item['answer'] : ''
			);
			?>
		<?php endforeach; ?>
	</div>
	<p><button type="button" class="button button-secondary dm-rep-add" data-list="#dm-paf-items" data-tmpl="#tmpl-dm-paf-item" data-item=".dm-rep-row"><?php esc_html_e( '+ Add Question', 'dm-legal' ); ?></button></p>

	<script type="text/html" id="tmpl-dm-paf-item">
		<?php dm_legal_render_pa_faq_item_row( '__i__', '', '' ); ?>
	</script>
	<?php
	dm_legal_repeater_script();
}

/**
 * Render one FAQ row.
 *
 * @param int|string $index    Row index.
 * @param string     $question Question.
 * @param string     $answer   Answer.
 * @return void
 */
function dm_legal_render_pa_faq_item_row( $index, $question, $answer ) {
	$name = '_dm_pa_faq_items[' . $index . ']';
	?>
	<div class="dm-rep-row" data-index="<?php echo esc_attr( $index ); ?>">
		<button type="button" class="button-link dm-rep-remove" aria-label="<?php esc_attr_e( 'Remove question', 'dm-legal' ); ?>">&times;</button>
		<div class="dm-rep-grid">
			<label><?php esc_html_e( 'Question', 'dm-legal' ); ?></label>
			<div><input type="text" name="<?php echo esc_attr( $name ); ?>[question]" value="<?php echo esc_attr( $question ); ?>"></div>

			<label><?php esc_html_e( 'Answer', 'dm-legal' ); ?></label>
			<div><textarea name="<?php echo esc_attr( $name ); ?>[answer]" rows="3"><?php echo esc_textarea( $answer ); ?></textarea></div>
		</div>
	</div>
	<?php
}

/**
 * Save the FAQ metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_pa_faq_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_pa_faq_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_pa_faq_nonce'] ) ), 'dm_legal_save_pa_faq' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$heading = isset( $_POST['_dm_pa_faq_heading'] ) ? sanitize_text_field( wp_unslash( $_POST['_dm_pa_faq_heading'] ) ) : '';
	$lead    = isset( $_POST['_dm_pa_faq_lead'] ) ? sanitize_textarea_field( wp_unslash( $_POST['_dm_pa_faq_lead'] ) ) : '';

	if ( '' === $heading ) {
		delete_post_meta( $post_id, '_dm_pa_faq_heading' );
	} else {
		update_post_meta( $post_id, '_dm_pa_faq_heading', $heading );
	}
	if ( '' === $lead ) {
		delete_post_meta( $post_id, '_dm_pa_faq_lead' );
	} else {
		update_post_meta( $post_id, '_dm_pa_faq_lead', $lead );
	}

	$raw   = isset( $_POST['_dm_pa_faq_items'] ) ? wp_unslash( $_POST['_dm_pa_faq_items'] ) : array();
	$items = array();
	if ( is_array( $raw ) ) {
		foreach ( $raw as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$question = isset( $row['question'] ) ? sanitize_text_field( $row['question'] ) : '';
			$answer   = isset( $row['answer'] ) ? sanitize_textarea_field( $row['answer'] ) : '';
			if ( '' === $question ) {
				continue;
			}
			$items[] = array(
				'question' => $question,
				'answer'   => $answer,
			);
		}
	}
	if ( empty( $items ) ) {
		delete_post_meta( $post_id, '_dm_pa_faq_items' );
	} else {
		update_post_meta( $post_id, '_dm_pa_faq_items', $items );
	}
}
add_action( 'save_post_practice_area', 'dm_legal_save_pa_faq_metabox' );

/**
 * Merge saved FAQ meta over the template defaults.
 *
 * @param array $defaults Keys: heading, lead, items.
 * @param int   $post_id  Practice area post ID.
 * @return array
 */
function dm_legal_pa_faq_args( array $defaults, $post_id ) {
	$args = $defaults;

	$heading = trim( (string) get_post_meta( $post_id, '_dm_pa_faq_heading', true ) );
	if ( '' !== $heading ) {
		$args['heading'] = $heading;
	}
	$lead = trim( (string) get_post_meta( $post_id, '_dm_pa_faq_lead', true ) );
	if ( '' !== $lead ) {
		$args['lead'] = $lead;
	}
	$items = get_post_meta( $post_id, '_dm_pa_faq_items', true );
	if ( is_array( $items ) && ! empty( $items ) ) {
		$args['items'] = $items;
	}

	return $args;
}

/* =====================================================================
 * ONE-TIME SEEDING of the per-slug Actions content.
 * ================================================================== */

/**
 * Seed each practice_area post's Actions meta from the static
 * $actionsDataBySlug array, once.
 *
 * @return void
 */
function dm_legal_provision_practice_area_details() {
	if ( get_option( 'dm_legal_pa_details_created' ) ) {
		return;
	}

	global $actionsDataBySlug;

	if ( ! post_type_exists( 'practice_area' ) ) {
		return;
	}

	$posts = get_posts(
		array(
			'post_type'      => 'practice_area',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'fields'         => 'all',
		)
	);

	foreach ( $posts as $post ) {
		$slug = $post->post_name;
		$data = isset( $actionsDataBySlug[ $slug ] ) ? $actionsDataBySlug[ $slug ] : null;
		if ( ! is_array( $data ) ) {
			continue;
		}

		if ( ! empty( $data['title'] ) && '' === (string) get_post_meta( $post->ID, '_dm_pa_actions_title', true ) ) {
			update_post_meta( $post->ID, '_dm_pa_actions_title', sanitize_text_field( $data['title'] ) );
		}
		if ( ! empty( $data['description'] ) ) {
			update_post_meta( $post->ID, '_dm_pa_actions_desc', sanitize_textarea_field( $data['description'] ) );
		}
		if ( ! empty( $data['sub-description'] ) ) {
			update_post_meta( $post->ID, '_dm_pa_actions_subdesc', sanitize_textarea_field( $data['sub-description'] ) );
		}
		if ( ! empty( $data['actions'] ) && is_array( $data['actions'] ) ) {
			$items = array();
			foreach ( $data['actions'] as $a ) {
				$items[] = array(
					'question' => sanitize_text_field( isset( $a['question'] ) ? $a['question'] : '' ),
					'answer'   => sanitize_textarea_field( isset( $a['answer'] ) ? $a['answer'] : '' ),
				);
			}
			update_post_meta( $post->ID, '_dm_pa_actions_items', $items );
		}
		if ( ! empty( $data['images'] ) && is_array( $data['images'] ) ) {
			$imgs = array_map( 'sanitize_text_field', $data['images'] );
			update_post_meta( $post->ID, '_dm_pa_actions_images', array_values( $imgs ) );
		}
	}

	update_option( 'dm_legal_pa_details_created', DM_LEGAL_VERSION );
}
add_action( 'admin_init', 'dm_legal_provision_practice_area_details', 20 );

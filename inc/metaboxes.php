<?php
/**
 * Hero Section metabox.
 *
 * Makes the hero block (inc/parts/hero.php) editable per Page from wp-admin
 * instead of being hardcoded in the page template. Any template can opt in by
 * calling dm_legal_hero_args( $defaults ) to merge the saved meta over its own
 * hardcoded defaults, so nothing breaks before an editor saves anything.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Meta keys used by the hero metabox.
 *
 * @return array<string,string> key => sanitiser
 */
function dm_legal_hero_meta_keys() {
	return array(
		'_dm_hero_title'          => 'sanitize_text_field',
		'_dm_hero_subtitle'       => 'sanitize_textarea_field',
		'_dm_hero_features'       => 'sanitize_textarea_field',
		'_dm_hero_primary_text'   => 'sanitize_text_field',
		'_dm_hero_primary_href'   => 'sanitize_text_field',
		'_dm_hero_secondary_text' => 'sanitize_text_field',
		'_dm_hero_secondary_href' => 'sanitize_text_field',
		'_dm_hero_right_side'     => 'sanitize_text_field',
		'_dm_hero_image'          => 'esc_url_raw',
		'_dm_hero_minimal'        => 'sanitize_text_field',
	);
}

/**
 * Register the metaboxes.
 *
 * The Hero box applies to every Page; the Why Fixed Fees box is specific to
 * the Fixed Prices page, so it is only registered there.
 *
 * @param string  $post_type Current post type.
 * @param WP_Post $post      Current post.
 * @return void
 */
function dm_legal_add_hero_metabox( $post_type, $post ) {
	add_meta_box(
		'dm_legal_hero',
		__( 'Hero Section', 'dm-legal' ),
		'dm_legal_render_hero_metabox',
		'page',
		'normal',
		'high'
	);

	if ( $post instanceof WP_Post && 'fixed-prices' === $post->post_name ) {
		add_meta_box(
			'dm_legal_why_fixed_fees',
			__( 'Why Fixed Fees Section', 'dm-legal' ),
			'dm_legal_render_wff_metabox',
			'page',
			'normal',
			'high'
		);

		add_meta_box(
			'dm_legal_attraction_contact',
			__( 'Attraction Contact Section', 'dm-legal' ),
			'dm_legal_render_ac_metabox',
			'page',
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'dm_legal_add_hero_metabox', 10, 2 );

/**
 * Load the media library so the image picker works.
 *
 * @param string $hook Current admin page.
 * @return void
 */
function dm_legal_hero_admin_assets( $hook ) {
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		wp_enqueue_media();
	}
}
add_action( 'admin_enqueue_scripts', 'dm_legal_hero_admin_assets' );

/**
 * Render the metabox UI.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_hero_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_hero', 'dm_legal_hero_nonce' );

	$get = static function ( $key ) use ( $post ) {
		return get_post_meta( $post->ID, $key, true );
	};

	$right_side = $get( '_dm_hero_right_side' );
	$right_side = $right_side ? $right_side : 'image';
	$image      = $get( '_dm_hero_image' );
	?>
	<style>
		.dm-hero-grid { display:grid; grid-template-columns:160px 1fr; gap:12px 16px; align-items:start; }
		.dm-hero-grid label { font-weight:600; padding-top:6px; }
		.dm-hero-grid input[type=text], .dm-hero-grid input[type=url], .dm-hero-grid textarea, .dm-hero-grid select { width:100%; max-width:640px; }
		.dm-hero-grid .description { margin-top:4px; }
		.dm-hero-preview { max-width:220px; height:auto; display:block; margin-bottom:8px; border:1px solid #dcdcde; border-radius:4px; }
		.dm-hero-sep { grid-column:1 / -1; border-top:1px solid #dcdcde; margin:6px 0; }
	</style>

	<p class="description">
		<?php esc_html_e( 'Leave any field blank to keep the template default for this page.', 'dm-legal' ); ?>
	</p>

	<div class="dm-hero-grid">

		<label for="dm_hero_title"><?php esc_html_e( 'Title', 'dm-legal' ); ?></label>
		<div>
			<input type="text" id="dm_hero_title" name="_dm_hero_title" value="<?php echo esc_attr( $get( '_dm_hero_title' ) ); ?>">
		</div>

		<label for="dm_hero_subtitle"><?php esc_html_e( 'Subtitle', 'dm-legal' ); ?></label>
		<div>
			<textarea id="dm_hero_subtitle" name="_dm_hero_subtitle" rows="2"><?php echo esc_textarea( $get( '_dm_hero_subtitle' ) ); ?></textarea>
		</div>

		<label for="dm_hero_features"><?php esc_html_e( 'Feature List', 'dm-legal' ); ?></label>
		<div>
			<textarea id="dm_hero_features" name="_dm_hero_features" rows="4" placeholder="<?php esc_attr_e( "Fixed Fees for common legal services\nHourly Rates where appropriate", 'dm-legal' ); ?>"><?php echo esc_textarea( $get( '_dm_hero_features' ) ); ?></textarea>
			<p class="description"><?php esc_html_e( 'One feature per line. Each renders with a tick icon.', 'dm-legal' ); ?></p>
		</div>

		<div class="dm-hero-sep"></div>

		<label for="dm_hero_primary_text"><?php esc_html_e( 'Primary Button', 'dm-legal' ); ?></label>
		<div>
			<input type="text" id="dm_hero_primary_text" name="_dm_hero_primary_text" value="<?php echo esc_attr( $get( '_dm_hero_primary_text' ) ); ?>" placeholder="<?php esc_attr_e( 'Button label', 'dm-legal' ); ?>">
			<input type="text" name="_dm_hero_primary_href" value="<?php echo esc_attr( $get( '_dm_hero_primary_href' ) ); ?>" placeholder="<?php esc_attr_e( 'Link, e.g. book-your-lawyer.php or https://…', 'dm-legal' ); ?>" style="margin-top:6px;">
			<p class="description"><?php esc_html_e( 'Clear the label to hide this button.', 'dm-legal' ); ?></p>
		</div>

		<label for="dm_hero_secondary_text"><?php esc_html_e( 'Secondary Button', 'dm-legal' ); ?></label>
		<div>
			<input type="text" id="dm_hero_secondary_text" name="_dm_hero_secondary_text" value="<?php echo esc_attr( $get( '_dm_hero_secondary_text' ) ); ?>" placeholder="<?php esc_attr_e( 'Button label', 'dm-legal' ); ?>">
			<input type="text" name="_dm_hero_secondary_href" value="<?php echo esc_attr( $get( '_dm_hero_secondary_href' ) ); ?>" placeholder="<?php esc_attr_e( 'Link, e.g. index.php', 'dm-legal' ); ?>" style="margin-top:6px;">
			<p class="description"><?php esc_html_e( 'Clear the label to hide this button.', 'dm-legal' ); ?></p>
		</div>

		<div class="dm-hero-sep"></div>

		<label for="dm_hero_right_side"><?php esc_html_e( 'Right Side', 'dm-legal' ); ?></label>
		<div>
			<select id="dm_hero_right_side" name="_dm_hero_right_side">
				<option value="image" <?php selected( $right_side, 'image' ); ?>><?php esc_html_e( 'Image', 'dm-legal' ); ?></option>
				<option value="form" <?php selected( $right_side, 'form' ); ?>><?php esc_html_e( 'Enquiry Form', 'dm-legal' ); ?></option>
				<option value="none" <?php selected( $right_side, 'none' ); ?>><?php esc_html_e( 'Nothing', 'dm-legal' ); ?></option>
			</select>
		</div>

		<label for="dm_hero_image"><?php esc_html_e( 'Hero Image', 'dm-legal' ); ?></label>
		<div>
			<img src="<?php echo esc_url( $image ); ?>" class="dm-hero-preview" id="dm_hero_preview" <?php echo $image ? '' : 'style="display:none;"'; ?> alt="">
			<input type="url" id="dm_hero_image" name="_dm_hero_image" value="<?php echo esc_attr( $image ); ?>" placeholder="<?php esc_attr_e( 'Image URL', 'dm-legal' ); ?>">
			<p style="margin-top:6px;">
				<button type="button" class="button" id="dm_hero_image_select"><?php esc_html_e( 'Select Image', 'dm-legal' ); ?></button>
				<button type="button" class="button" id="dm_hero_image_clear"><?php esc_html_e( 'Clear', 'dm-legal' ); ?></button>
			</p>
			<p class="description"><?php esc_html_e( 'Only used when Right Side is set to Image.', 'dm-legal' ); ?></p>
		</div>

		<label for="dm_hero_minimal"><?php esc_html_e( 'Minimal', 'dm-legal' ); ?></label>
		<div>
			<label style="font-weight:400;">
				<input type="checkbox" id="dm_hero_minimal" name="_dm_hero_minimal" value="1" <?php checked( $get( '_dm_hero_minimal' ), '1' ); ?>>
				<?php esc_html_e( 'Show title + breadcrumb only (hides subtitle, features, buttons and image).', 'dm-legal' ); ?>
			</label>
		</div>

	</div>

	<script>
	(function ($) {
		var frame;
		$('#dm_hero_image_select').on('click', function (e) {
			e.preventDefault();
			if (frame) { frame.open(); return; }
			frame = wp.media({
				title: '<?php echo esc_js( __( 'Select Hero Image', 'dm-legal' ) ); ?>',
				button: { text: '<?php echo esc_js( __( 'Use this image', 'dm-legal' ) ); ?>' },
				library: { type: 'image' },
				multiple: false
			});
			frame.on('select', function () {
				var url = frame.state().get('selection').first().toJSON().url;
				$('#dm_hero_image').val(url);
				$('#dm_hero_preview').attr('src', url).show();
			});
			frame.open();
		});
		$('#dm_hero_image_clear').on('click', function (e) {
			e.preventDefault();
			$('#dm_hero_image').val('');
			$('#dm_hero_preview').hide();
		});
	})(jQuery);
	</script>
	<?php
}

/**
 * Save the metabox values.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_hero_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_hero_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_hero_nonce'] ) ), 'dm_legal_save_hero' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	foreach ( dm_legal_hero_meta_keys() as $key => $sanitiser ) {
		if ( '_dm_hero_minimal' === $key ) {
			// Checkbox: absent means unchecked.
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, '1' );
			} else {
				delete_post_meta( $post_id, $key );
			}
			continue;
		}

		$raw   = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
		$value = call_user_func( $sanitiser, $raw );

		if ( '' === $value ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}
}
add_action( 'save_post_page', 'dm_legal_save_hero_metabox' );

/**
 * Merge saved hero meta over a template's hardcoded defaults.
 *
 * Any field left blank in the metabox falls back to the template default, so
 * pages render exactly as before until an editor overrides something.
 *
 * @param array $defaults Template defaults, using the hero.php variable names
 *                        (heroTitle, heroSubtitle, heroFeatures, heroPrimaryBtn,
 *                        heroSecondaryBtn, heroRightSide, heroImage, heroMinimal).
 * @param int   $post_id  Optional post ID; defaults to the queried page.
 * @return array Merged hero args.
 */
function dm_legal_hero_args( array $defaults = array(), $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();

	if ( ! $post_id ) {
		return $defaults;
	}

	$meta = static function ( $key ) use ( $post_id ) {
		return trim( (string) get_post_meta( $post_id, $key, true ) );
	};

	$args = $defaults;

	$title = $meta( '_dm_hero_title' );
	if ( '' !== $title ) {
		$args['heroTitle'] = $title;
	}

	$subtitle = $meta( '_dm_hero_subtitle' );
	if ( '' !== $subtitle ) {
		$args['heroSubtitle'] = $subtitle;
	}

	$features = $meta( '_dm_hero_features' );
	if ( '' !== $features ) {
		$lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $features ) ) );
		if ( $lines ) {
			$args['heroFeatures'] = array_values( $lines );
		}
	}

	$primary_text = $meta( '_dm_hero_primary_text' );
	if ( '' !== $primary_text ) {
		$args['heroPrimaryBtn'] = array(
			'text' => $primary_text,
			'href' => $meta( '_dm_hero_primary_href' ),
		);
	}

	$secondary_text = $meta( '_dm_hero_secondary_text' );
	if ( '' !== $secondary_text ) {
		$args['heroSecondaryBtn'] = array(
			'text' => $secondary_text,
			'href' => $meta( '_dm_hero_secondary_href' ),
		);
	}

	$right_side = $meta( '_dm_hero_right_side' );
	if ( in_array( $right_side, array( 'image', 'form', 'none' ), true ) ) {
		$args['heroRightSide'] = $right_side;
	}

	$image = $meta( '_dm_hero_image' );
	if ( '' !== $image ) {
		$args['heroImage'] = $image;
	}

	$args['heroMinimal'] = ( '1' === $meta( '_dm_hero_minimal' ) );

	return $args;
}

/* =====================================================================
 * WHY FIXED FEES SECTION (Fixed Prices page)
 * ================================================================== */

/**
 * Render the Why Fixed Fees metabox: heading, lead, and repeatable steps.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_wff_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_wff', 'dm_legal_wff_nonce' );

	$heading = get_post_meta( $post->ID, '_dm_wff_heading', true );
	$lead    = get_post_meta( $post->ID, '_dm_wff_lead', true );
	$steps   = get_post_meta( $post->ID, '_dm_wff_steps', true );
	$steps   = is_array( $steps ) ? $steps : array();
	?>
	<style>
		.dm-wff-field { margin-bottom:14px; }
		.dm-wff-field > label { display:block; font-weight:600; margin-bottom:4px; }
		.dm-wff-field input[type=text], .dm-wff-field textarea { width:100%; max-width:760px; }
		.dm-wff-step { border:1px solid #dcdcde; border-radius:4px; padding:12px; margin-bottom:10px; background:#fff; position:relative; }
		.dm-wff-step .dm-wff-row { display:grid; grid-template-columns:90px 1fr; gap:10px 14px; align-items:start; }
		.dm-wff-step label { font-weight:600; padding-top:6px; }
		.dm-wff-step input[type=text], .dm-wff-step input[type=url], .dm-wff-step textarea { width:100%; }
		.dm-wff-icon { width:40px; height:40px; object-fit:contain; border:1px solid #dcdcde; border-radius:4px; padding:4px; background:#fff; margin-bottom:6px; }
		.dm-wff-remove { position:absolute; top:8px; right:8px; }
	</style>

	<p class="description">
		<?php esc_html_e( 'Leave the heading or lead blank to keep the template default. Steps replace the defaults only if you add at least one.', 'dm-legal' ); ?>
	</p>

	<div class="dm-wff-field">
		<label for="dm_wff_heading"><?php esc_html_e( 'Heading', 'dm-legal' ); ?></label>
		<input type="text" id="dm_wff_heading" name="_dm_wff_heading" value="<?php echo esc_attr( $heading ); ?>" placeholder="Why Choose Fixed Fees">
	</div>

	<div class="dm-wff-field">
		<label for="dm_wff_lead"><?php esc_html_e( 'Lead Paragraph', 'dm-legal' ); ?></label>
		<textarea id="dm_wff_lead" name="_dm_wff_lead" rows="3"><?php echo esc_textarea( $lead ); ?></textarea>
	</div>

	<h4><?php esc_html_e( 'Steps', 'dm-legal' ); ?></h4>
	<div id="dm-wff-steps">
		<?php foreach ( $steps as $i => $step ) : ?>
			<?php
			dm_legal_render_wff_step_row(
				(int) $i,
				isset( $step['image'] ) ? $step['image'] : '',
				isset( $step['title'] ) ? $step['title'] : '',
				isset( $step['description'] ) ? $step['description'] : ''
			);
			?>
		<?php endforeach; ?>
	</div>

	<p>
		<button type="button" class="button button-secondary" id="dm-wff-add"><?php esc_html_e( '+ Add Step', 'dm-legal' ); ?></button>
	</p>

	<script type="text/html" id="tmpl-dm-wff-step">
		<?php dm_legal_render_wff_step_row( '__i__', '', '', '' ); ?>
	</script>

	<script>
	(function ($) {
		var $wrap = $('#dm-wff-steps');

		function nextIndex() {
			var max = -1;
			$wrap.find('.dm-wff-step').each(function () {
				var i = parseInt($(this).data('index'), 10);
				if (!isNaN(i) && i > max) { max = i; }
			});
			return max + 1;
		}

		$('#dm-wff-add').on('click', function (e) {
			e.preventDefault();
			var html = $('#tmpl-dm-wff-step').html().replace(/__i__/g, nextIndex());
			$wrap.append(html);
		});

		$wrap.on('click', '.dm-wff-remove', function (e) {
			e.preventDefault();
			$(this).closest('.dm-wff-step').remove();
		});

		// Per-row media picker for the step icon.
		$wrap.on('click', '.dm-wff-select', function (e) {
			e.preventDefault();
			var $step = $(this).closest('.dm-wff-step');
			var frame = wp.media({
				title: '<?php echo esc_js( __( 'Select Step Icon', 'dm-legal' ) ); ?>',
				button: { text: '<?php echo esc_js( __( 'Use this icon', 'dm-legal' ) ); ?>' },
				library: { type: 'image' },
				multiple: false
			});
			frame.on('select', function () {
				var url = frame.state().get('selection').first().toJSON().url;
				$step.find('.dm-wff-image').val(url);
				$step.find('.dm-wff-icon').attr('src', url).show();
			});
			frame.open();
		});

		$wrap.on('click', '.dm-wff-clear', function (e) {
			e.preventDefault();
			var $step = $(this).closest('.dm-wff-step');
			$step.find('.dm-wff-image').val('');
			$step.find('.dm-wff-icon').hide();
		});
	})(jQuery);
	</script>
	<?php
}

/**
 * Render a single repeatable step row.
 *
 * @param int|string $index       Row index (or the __i__ placeholder).
 * @param string     $image       Icon URL.
 * @param string     $title       Step title.
 * @param string     $description Step description.
 * @return void
 */
function dm_legal_render_wff_step_row( $index, $image, $title, $description ) {
	$name = '_dm_wff_steps[' . $index . ']';
	?>
	<div class="dm-wff-step" data-index="<?php echo esc_attr( $index ); ?>">
		<button type="button" class="button-link dm-wff-remove" aria-label="<?php esc_attr_e( 'Remove step', 'dm-legal' ); ?>">&times;</button>
		<div class="dm-wff-row">

			<label><?php esc_html_e( 'Icon', 'dm-legal' ); ?></label>
			<div>
				<img src="<?php echo esc_url( $image ); ?>" class="dm-wff-icon" <?php echo $image ? '' : 'style="display:none;"'; ?> alt="">
				<input type="url" class="dm-wff-image" name="<?php echo esc_attr( $name ); ?>[image]" value="<?php echo esc_attr( $image ); ?>" placeholder="<?php esc_attr_e( 'Icon URL', 'dm-legal' ); ?>">
				<p style="margin:6px 0 0;">
					<button type="button" class="button dm-wff-select"><?php esc_html_e( 'Select Icon', 'dm-legal' ); ?></button>
					<button type="button" class="button dm-wff-clear"><?php esc_html_e( 'Clear', 'dm-legal' ); ?></button>
				</p>
			</div>

			<label><?php esc_html_e( 'Title', 'dm-legal' ); ?></label>
			<div>
				<input type="text" name="<?php echo esc_attr( $name ); ?>[title]" value="<?php echo esc_attr( $title ); ?>">
			</div>

			<label><?php esc_html_e( 'Description', 'dm-legal' ); ?></label>
			<div>
				<textarea name="<?php echo esc_attr( $name ); ?>[description]" rows="2"><?php echo esc_textarea( $description ); ?></textarea>
			</div>

		</div>
	</div>
	<?php
}

/**
 * Save the Why Fixed Fees metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_wff_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_wff_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_wff_nonce'] ) ), 'dm_legal_save_wff' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	// Heading + lead.
	$heading = isset( $_POST['_dm_wff_heading'] ) ? sanitize_text_field( wp_unslash( $_POST['_dm_wff_heading'] ) ) : '';
	$lead    = isset( $_POST['_dm_wff_lead'] ) ? sanitize_textarea_field( wp_unslash( $_POST['_dm_wff_lead'] ) ) : '';

	if ( '' === $heading ) {
		delete_post_meta( $post_id, '_dm_wff_heading' );
	} else {
		update_post_meta( $post_id, '_dm_wff_heading', $heading );
	}

	if ( '' === $lead ) {
		delete_post_meta( $post_id, '_dm_wff_lead' );
	} else {
		update_post_meta( $post_id, '_dm_wff_lead', $lead );
	}

	// Steps repeater: keep only rows that have at least a title or description.
	$raw   = isset( $_POST['_dm_wff_steps'] ) ? wp_unslash( $_POST['_dm_wff_steps'] ) : array();
	$steps = array();

	if ( is_array( $raw ) ) {
		foreach ( $raw as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}

			$title       = isset( $row['title'] ) ? sanitize_text_field( $row['title'] ) : '';
			$description = isset( $row['description'] ) ? sanitize_textarea_field( $row['description'] ) : '';
			$image       = isset( $row['image'] ) ? esc_url_raw( trim( $row['image'] ) ) : '';

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
		delete_post_meta( $post_id, '_dm_wff_steps' );
	} else {
		update_post_meta( $post_id, '_dm_wff_steps', $steps );
	}
}
add_action( 'save_post_page', 'dm_legal_save_wff_metabox' );

/**
 * Merge saved Why Fixed Fees meta over the template defaults.
 *
 * @param array $defaults Keys: heading, lead, steps (each step: image/title/description).
 * @param int   $post_id  Optional post ID; defaults to the queried page.
 * @return array
 */
function dm_legal_wff_args( array $defaults = array(), $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();

	if ( ! $post_id ) {
		return $defaults;
	}

	$args = $defaults;

	$heading = trim( (string) get_post_meta( $post_id, '_dm_wff_heading', true ) );
	if ( '' !== $heading ) {
		$args['heading'] = $heading;
	}

	$lead = trim( (string) get_post_meta( $post_id, '_dm_wff_lead', true ) );
	if ( '' !== $lead ) {
		$args['lead'] = $lead;
	}

	$steps = get_post_meta( $post_id, '_dm_wff_steps', true );
	if ( is_array( $steps ) && ! empty( $steps ) ) {
		$args['steps'] = $steps;
	}

	return $args;
}

/* =====================================================================
 * ATTRACTION CONTACT SECTION (Fixed Prices page)
 * ================================================================== */

/**
 * Render the Attraction Contact metabox: title, intro, consultation format
 * options (repeatable) and the CTA button.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_ac_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_ac', 'dm_legal_ac_nonce' );

	$title     = get_post_meta( $post->ID, '_dm_ac_title', true );
	$intro     = get_post_meta( $post->ID, '_dm_ac_intro', true );
	$btn_text  = get_post_meta( $post->ID, '_dm_ac_btn_text', true );
	$btn_href  = get_post_meta( $post->ID, '_dm_ac_btn_href', true );
	$ac_option = get_post_meta( $post->ID, '_dm_ac_options', true );
	$ac_option = is_array( $ac_option ) ? $ac_option : array();
	?>
	<style>
		.dm-ac-field { margin-bottom:14px; }
		.dm-ac-field > label { display:block; font-weight:600; margin-bottom:4px; }
		.dm-ac-field input[type=text], .dm-ac-field textarea { width:100%; max-width:760px; }
		.dm-ac-opt { border:1px solid #dcdcde; border-radius:4px; padding:12px; margin-bottom:10px; background:#fff; position:relative; }
		.dm-ac-opt .dm-ac-row { display:grid; grid-template-columns:90px 1fr; gap:10px 14px; align-items:start; }
		.dm-ac-opt label { font-weight:600; padding-top:6px; }
		.dm-ac-opt input[type=text], .dm-ac-opt input[type=url] { width:100%; }
		.dm-ac-icon { width:40px; height:40px; object-fit:contain; border:1px solid #dcdcde; border-radius:4px; padding:4px; background:#fff; margin-bottom:6px; }
		.dm-ac-remove { position:absolute; top:8px; right:8px; }
		.dm-ac-btn-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; max-width:760px; }
	</style>

	<p class="description">
		<?php esc_html_e( 'Leave a field blank to keep the template default. Options replace the defaults only if you add at least one.', 'dm-legal' ); ?>
	</p>

	<div class="dm-ac-field">
		<label for="dm_ac_title"><?php esc_html_e( 'Title', 'dm-legal' ); ?></label>
		<input type="text" id="dm_ac_title" name="_dm_ac_title" value="<?php echo esc_attr( $title ); ?>" placeholder="Limited slots available — Book your consultation now">
	</div>

	<div class="dm-ac-field">
		<label for="dm_ac_intro"><?php esc_html_e( 'Intro Text', 'dm-legal' ); ?></label>
		<textarea id="dm_ac_intro" name="_dm_ac_intro" rows="2" placeholder="You can choose any format of consultation with our lawyer:"><?php echo esc_textarea( $intro ); ?></textarea>
	</div>

	<h4><?php esc_html_e( 'Consultation Options', 'dm-legal' ); ?></h4>
	<div id="dm-ac-options">
		<?php foreach ( $ac_option as $i => $opt ) : ?>
			<?php
			dm_legal_render_ac_option_row(
				(int) $i,
				isset( $opt['icon'] ) ? $opt['icon'] : '',
				isset( $opt['label'] ) ? $opt['label'] : ''
			);
			?>
		<?php endforeach; ?>
	</div>

	<p>
		<button type="button" class="button button-secondary" id="dm-ac-add"><?php esc_html_e( '+ Add Option', 'dm-legal' ); ?></button>
	</p>

	<h4><?php esc_html_e( 'Button', 'dm-legal' ); ?></h4>
	<div class="dm-ac-btn-grid">
		<input type="text" name="_dm_ac_btn_text" value="<?php echo esc_attr( $btn_text ); ?>" placeholder="<?php esc_attr_e( 'Button label, e.g. Book a Consultation', 'dm-legal' ); ?>">
		<input type="text" name="_dm_ac_btn_href" value="<?php echo esc_attr( $btn_href ); ?>" placeholder="<?php esc_attr_e( 'Link, e.g. book-your-lawyer.php', 'dm-legal' ); ?>">
	</div>
	<p class="description"><?php esc_html_e( 'Clear the label to hide the button.', 'dm-legal' ); ?></p>

	<script type="text/html" id="tmpl-dm-ac-option">
		<?php dm_legal_render_ac_option_row( '__i__', '', '' ); ?>
	</script>

	<script>
	(function ($) {
		var $wrap = $('#dm-ac-options');

		function nextIndex() {
			var max = -1;
			$wrap.find('.dm-ac-opt').each(function () {
				var i = parseInt($(this).data('index'), 10);
				if (!isNaN(i) && i > max) { max = i; }
			});
			return max + 1;
		}

		$('#dm-ac-add').on('click', function (e) {
			e.preventDefault();
			$wrap.append($('#tmpl-dm-ac-option').html().replace(/__i__/g, nextIndex()));
		});

		$wrap.on('click', '.dm-ac-remove', function (e) {
			e.preventDefault();
			$(this).closest('.dm-ac-opt').remove();
		});

		$wrap.on('click', '.dm-ac-select', function (e) {
			e.preventDefault();
			var $opt = $(this).closest('.dm-ac-opt');
			var frame = wp.media({
				title: '<?php echo esc_js( __( 'Select Option Icon', 'dm-legal' ) ); ?>',
				button: { text: '<?php echo esc_js( __( 'Use this icon', 'dm-legal' ) ); ?>' },
				library: { type: 'image' },
				multiple: false
			});
			frame.on('select', function () {
				var url = frame.state().get('selection').first().toJSON().url;
				$opt.find('.dm-ac-image').val(url);
				$opt.find('.dm-ac-icon').attr('src', url).show();
			});
			frame.open();
		});

		$wrap.on('click', '.dm-ac-clear', function (e) {
			e.preventDefault();
			var $opt = $(this).closest('.dm-ac-opt');
			$opt.find('.dm-ac-image').val('');
			$opt.find('.dm-ac-icon').hide();
		});
	})(jQuery);
	</script>
	<?php
}

/**
 * Render a single repeatable consultation-option row.
 *
 * @param int|string $index Row index (or the __i__ placeholder).
 * @param string     $icon  Icon URL.
 * @param string     $label Option label.
 * @return void
 */
function dm_legal_render_ac_option_row( $index, $icon, $label ) {
	$name = '_dm_ac_options[' . $index . ']';
	?>
	<div class="dm-ac-opt" data-index="<?php echo esc_attr( $index ); ?>">
		<button type="button" class="button-link dm-ac-remove" aria-label="<?php esc_attr_e( 'Remove option', 'dm-legal' ); ?>">&times;</button>
		<div class="dm-ac-row">

			<label><?php esc_html_e( 'Icon', 'dm-legal' ); ?></label>
			<div>
				<img src="<?php echo esc_url( $icon ); ?>" class="dm-ac-icon" <?php echo $icon ? '' : 'style="display:none;"'; ?> alt="">
				<input type="url" class="dm-ac-image" name="<?php echo esc_attr( $name ); ?>[icon]" value="<?php echo esc_attr( $icon ); ?>" placeholder="<?php esc_attr_e( 'Icon URL', 'dm-legal' ); ?>">
				<p style="margin:6px 0 0;">
					<button type="button" class="button dm-ac-select"><?php esc_html_e( 'Select Icon', 'dm-legal' ); ?></button>
					<button type="button" class="button dm-ac-clear"><?php esc_html_e( 'Clear', 'dm-legal' ); ?></button>
				</p>
			</div>

			<label><?php esc_html_e( 'Label', 'dm-legal' ); ?></label>
			<div>
				<input type="text" name="<?php echo esc_attr( $name ); ?>[label]" value="<?php echo esc_attr( $label ); ?>" placeholder="<?php esc_attr_e( 'e.g. Face-to-Face', 'dm-legal' ); ?>">
			</div>

		</div>
	</div>
	<?php
}

/**
 * Save the Attraction Contact metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_ac_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_ac_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_ac_nonce'] ) ), 'dm_legal_save_ac' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$simple = array(
		'_dm_ac_title'    => 'sanitize_text_field',
		'_dm_ac_intro'    => 'sanitize_textarea_field',
		'_dm_ac_btn_text' => 'sanitize_text_field',
		'_dm_ac_btn_href' => 'sanitize_text_field',
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

	// Options repeater: keep only rows that have a label.
	$raw     = isset( $_POST['_dm_ac_options'] ) ? wp_unslash( $_POST['_dm_ac_options'] ) : array();
	$options = array();

	if ( is_array( $raw ) ) {
		foreach ( $raw as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}

			$label = isset( $row['label'] ) ? sanitize_text_field( $row['label'] ) : '';
			$icon  = isset( $row['icon'] ) ? esc_url_raw( trim( $row['icon'] ) ) : '';

			if ( '' === $label ) {
				continue;
			}

			$options[] = array(
				'icon'  => $icon,
				'label' => $label,
			);
		}
	}

	if ( empty( $options ) ) {
		delete_post_meta( $post_id, '_dm_ac_options' );
	} else {
		update_post_meta( $post_id, '_dm_ac_options', $options );
	}
}
add_action( 'save_post_page', 'dm_legal_save_ac_metabox' );

/**
 * Merge saved Attraction Contact meta over the template defaults.
 *
 * @param array $defaults Keys: title, intro, options (icon/label), btn_text, btn_href.
 * @param int   $post_id  Optional post ID; defaults to the queried page.
 * @return array
 */
function dm_legal_ac_args( array $defaults = array(), $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();

	if ( ! $post_id ) {
		return $defaults;
	}

	$args = $defaults;

	$map = array(
		'title'    => '_dm_ac_title',
		'intro'    => '_dm_ac_intro',
		'btn_text' => '_dm_ac_btn_text',
		'btn_href' => '_dm_ac_btn_href',
	);

	foreach ( $map as $arg_key => $meta_key ) {
		$value = trim( (string) get_post_meta( $post_id, $meta_key, true ) );
		if ( '' !== $value ) {
			$args[ $arg_key ] = $value;
		}
	}

	$options = get_post_meta( $post_id, '_dm_ac_options', true );
	if ( is_array( $options ) && ! empty( $options ) ) {
		$args['options'] = $options;
	}

	return $args;
}

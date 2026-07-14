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
 * Register the metabox on Pages.
 *
 * @return void
 */
function dm_legal_add_hero_metabox() {
	add_meta_box(
		'dm_legal_hero',
		__( 'Hero Section', 'dm-legal' ),
		'dm_legal_render_hero_metabox',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'dm_legal_add_hero_metabox' );

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

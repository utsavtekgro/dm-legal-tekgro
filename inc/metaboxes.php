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

	if ( $post instanceof WP_Post && 'home' === $post->post_name ) {
		add_meta_box(
			'dm_legal_about',
			__( 'About Section', 'dm-legal' ),
			'dm_legal_render_about_metabox',
			'page',
			'normal',
			'high'
		);

		add_meta_box(
			'dm_legal_expression',
			__( 'Expert Guidance (Expression) Section', 'dm-legal' ),
			'dm_legal_render_expr_metabox',
			'page',
			'normal',
			'high'
		);

		add_meta_box(
			'dm_legal_why_choose_us',
			__( 'Why Choose Us Section', 'dm-legal' ),
			'dm_legal_render_wcu_metabox',
			'page',
			'normal',
			'high'
		);

		add_meta_box(
			'dm_legal_affiliations',
			__( 'Affiliations & Membership Section', 'dm-legal' ),
			'dm_legal_render_aff_metabox',
			'page',
			'normal',
			'high'
		);

		add_meta_box(
			'dm_legal_get_support',
			__( 'Professional Legal Support Section', 'dm-legal' ),
			'dm_legal_render_gs_metabox',
			'page',
			'normal',
			'high'
		);

		add_meta_box(
			'dm_legal_how_we_work',
			__( 'How We Work Section', 'dm-legal' ),
			'dm_legal_render_hww_metabox',
			'page',
			'normal',
			'high'
		);

		add_meta_box(
			'dm_legal_news',
			__( 'News Carousel Section', 'dm-legal' ),
			'dm_legal_render_news_metabox',
			'page',
			'normal',
			'high'
		);

		add_meta_box(
			'dm_legal_latest_blogs',
			__( 'Latest Blogs Section', 'dm-legal' ),
			'dm_legal_render_lb_metabox',
			'page',
			'normal',
			'high'
		);

		// Reuses the same FAQ metabox as the Fixed Prices page. Meta is
		// per-post, so the Home page stores its own questions.
		add_meta_box(
			'dm_legal_faq',
			__( 'FAQ Section', 'dm-legal' ),
			'dm_legal_render_faq_metabox',
			'page',
			'normal',
			'high'
		);
	}

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

		add_meta_box(
			'dm_legal_faq',
			__( 'FAQ Section', 'dm-legal' ),
			'dm_legal_render_faq_metabox',
			'page',
			'normal',
			'high'
		);
	}

	if ( $post instanceof WP_Post && 'faqs' === $post->post_name ) {
		add_meta_box(
			'dm_legal_faq_categories',
			__( 'FAQ Categories Section', 'dm-legal' ),
			'dm_legal_render_faqcats_metabox',
			'page',
			'normal',
			'high'
		);
	}

	if ( $post instanceof WP_Post && 'contact' === $post->post_name ) {
		add_meta_box(
			'dm_legal_contact_sidebar',
			__( 'Expert Sidebar & Office Card', 'dm-legal' ),
			'dm_legal_render_csidebar_metabox',
			'page',
			'normal',
			'high'
		);

		add_meta_box(
			'dm_legal_value_heading',
			__( 'Value Heading Section', 'dm-legal' ),
			'dm_legal_render_vheading_metabox',
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

/* =====================================================================
 * FAQ SECTION (Fixed Prices page)
 * ================================================================== */

/**
 * Render the FAQ metabox: heading, lead, repeatable Q&A, and the CTA block.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_faq_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_faq', 'dm_legal_faq_nonce' );

	$heading  = get_post_meta( $post->ID, '_dm_faq_heading', true );
	$lead     = get_post_meta( $post->ID, '_dm_faq_lead', true );
	$items    = get_post_meta( $post->ID, '_dm_faq_items', true );
	$items    = is_array( $items ) ? $items : array();
	$cta_head = get_post_meta( $post->ID, '_dm_faq_cta_heading', true );
	$cta_text = get_post_meta( $post->ID, '_dm_faq_cta_text', true );
	$cta_btn  = get_post_meta( $post->ID, '_dm_faq_cta_btn_text', true );
	$cta_href = get_post_meta( $post->ID, '_dm_faq_cta_btn_href', true );
	?>
	<style>
		.dm-faq-field { margin-bottom:14px; }
		.dm-faq-field > label { display:block; font-weight:600; margin-bottom:4px; }
		.dm-faq-field input[type=text], .dm-faq-field textarea { width:100%; max-width:760px; }
		.dm-faq-item { border:1px solid #dcdcde; border-radius:4px; padding:12px 34px 12px 12px; margin-bottom:10px; background:#fff; position:relative; }
		.dm-faq-item .dm-faq-row { display:grid; grid-template-columns:90px 1fr; gap:10px 14px; align-items:start; }
		.dm-faq-item label { font-weight:600; padding-top:6px; }
		.dm-faq-item input[type=text], .dm-faq-item textarea { width:100%; }
		.dm-faq-remove { position:absolute; top:8px; right:8px; }
		.dm-faq-cta-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; max-width:760px; }
	</style>

	<p class="description">
		<?php esc_html_e( 'Leave a field blank to keep the template default. Questions replace the defaults only if you add at least one.', 'dm-legal' ); ?>
	</p>

	<div class="dm-faq-field">
		<label for="dm_faq_heading"><?php esc_html_e( 'Heading', 'dm-legal' ); ?></label>
		<input type="text" id="dm_faq_heading" name="_dm_faq_heading" value="<?php echo esc_attr( $heading ); ?>" placeholder="How Do Lawyers Charge in Australia?">
	</div>

	<div class="dm-faq-field">
		<label for="dm_faq_lead"><?php esc_html_e( 'Lead Paragraph', 'dm-legal' ); ?></label>
		<textarea id="dm_faq_lead" name="_dm_faq_lead" rows="2"><?php echo esc_textarea( $lead ); ?></textarea>
	</div>

	<h4><?php esc_html_e( 'Questions', 'dm-legal' ); ?></h4>
	<div id="dm-faq-items">
		<?php foreach ( $items as $i => $item ) : ?>
			<?php
			dm_legal_render_faq_item_row(
				(int) $i,
				isset( $item['question'] ) ? $item['question'] : '',
				isset( $item['answer'] ) ? $item['answer'] : ''
			);
			?>
		<?php endforeach; ?>
	</div>

	<p>
		<button type="button" class="button button-secondary" id="dm-faq-add"><?php esc_html_e( '+ Add Question', 'dm-legal' ); ?></button>
	</p>

	<h4><?php esc_html_e( 'Call-to-Action Box', 'dm-legal' ); ?></h4>
	<div class="dm-faq-field">
		<label for="dm_faq_cta_heading"><?php esc_html_e( 'CTA Heading', 'dm-legal' ); ?></label>
		<input type="text" id="dm_faq_cta_heading" name="_dm_faq_cta_heading" value="<?php echo esc_attr( $cta_head ); ?>" placeholder="Direct Connect With Us">
	</div>
	<div class="dm-faq-field">
		<label for="dm_faq_cta_text"><?php esc_html_e( 'CTA Text', 'dm-legal' ); ?></label>
		<textarea id="dm_faq_cta_text" name="_dm_faq_cta_text" rows="2"><?php echo esc_textarea( $cta_text ); ?></textarea>
	</div>
	<div class="dm-faq-cta-grid">
		<input type="text" name="_dm_faq_cta_btn_text" value="<?php echo esc_attr( $cta_btn ); ?>" placeholder="<?php esc_attr_e( 'Button label, e.g. Contact Us', 'dm-legal' ); ?>">
		<input type="text" name="_dm_faq_cta_btn_href" value="<?php echo esc_attr( $cta_href ); ?>" placeholder="<?php esc_attr_e( 'Link, e.g. contact.php', 'dm-legal' ); ?>">
	</div>
	<p class="description"><?php esc_html_e( 'Clear the label to hide the CTA button.', 'dm-legal' ); ?></p>

	<script type="text/html" id="tmpl-dm-faq-item">
		<?php dm_legal_render_faq_item_row( '__i__', '', '' ); ?>
	</script>

	<script>
	(function ($) {
		var $wrap = $('#dm-faq-items');

		function nextIndex() {
			var max = -1;
			$wrap.find('.dm-faq-item').each(function () {
				var i = parseInt($(this).data('index'), 10);
				if (!isNaN(i) && i > max) { max = i; }
			});
			return max + 1;
		}

		$('#dm-faq-add').on('click', function (e) {
			e.preventDefault();
			$wrap.append($('#tmpl-dm-faq-item').html().replace(/__i__/g, nextIndex()));
		});

		$wrap.on('click', '.dm-faq-remove', function (e) {
			e.preventDefault();
			$(this).closest('.dm-faq-item').remove();
		});
	})(jQuery);
	</script>
	<?php
}

/**
 * Render a single repeatable FAQ row.
 *
 * @param int|string $index    Row index (or the __i__ placeholder).
 * @param string     $question Question text.
 * @param string     $answer   Answer text.
 * @return void
 */
function dm_legal_render_faq_item_row( $index, $question, $answer ) {
	$name = '_dm_faq_items[' . $index . ']';
	?>
	<div class="dm-faq-item" data-index="<?php echo esc_attr( $index ); ?>">
		<button type="button" class="button-link dm-faq-remove" aria-label="<?php esc_attr_e( 'Remove question', 'dm-legal' ); ?>">&times;</button>
		<div class="dm-faq-row">

			<label><?php esc_html_e( 'Question', 'dm-legal' ); ?></label>
			<div>
				<input type="text" name="<?php echo esc_attr( $name ); ?>[question]" value="<?php echo esc_attr( $question ); ?>">
			</div>

			<label><?php esc_html_e( 'Answer', 'dm-legal' ); ?></label>
			<div>
				<textarea name="<?php echo esc_attr( $name ); ?>[answer]" rows="3"><?php echo esc_textarea( $answer ); ?></textarea>
			</div>

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
function dm_legal_save_faq_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_faq_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_faq_nonce'] ) ), 'dm_legal_save_faq' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$simple = array(
		'_dm_faq_heading'      => 'sanitize_text_field',
		'_dm_faq_lead'         => 'sanitize_textarea_field',
		'_dm_faq_cta_heading'  => 'sanitize_text_field',
		'_dm_faq_cta_text'     => 'sanitize_textarea_field',
		'_dm_faq_cta_btn_text' => 'sanitize_text_field',
		'_dm_faq_cta_btn_href' => 'sanitize_text_field',
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

	// Questions repeater: keep only rows that have a question.
	$raw   = isset( $_POST['_dm_faq_items'] ) ? wp_unslash( $_POST['_dm_faq_items'] ) : array();
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
		delete_post_meta( $post_id, '_dm_faq_items' );
	} else {
		update_post_meta( $post_id, '_dm_faq_items', $items );
	}
}
add_action( 'save_post_page', 'dm_legal_save_faq_metabox' );

/**
 * Merge saved FAQ meta over the template defaults.
 *
 * @param array $defaults Keys: heading, lead, items (question/answer),
 *                        cta_heading, cta_text, cta_btn_text, cta_btn_href.
 * @param int   $post_id  Optional post ID; defaults to the queried page.
 * @return array
 */
function dm_legal_faq_args( array $defaults = array(), $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();

	if ( ! $post_id ) {
		return $defaults;
	}

	$args = $defaults;

	$map = array(
		'heading'      => '_dm_faq_heading',
		'lead'         => '_dm_faq_lead',
		'cta_heading'  => '_dm_faq_cta_heading',
		'cta_text'     => '_dm_faq_cta_text',
		'cta_btn_text' => '_dm_faq_cta_btn_text',
		'cta_btn_href' => '_dm_faq_cta_btn_href',
	);

	foreach ( $map as $arg_key => $meta_key ) {
		$value = trim( (string) get_post_meta( $post_id, $meta_key, true ) );
		if ( '' !== $value ) {
			$args[ $arg_key ] = $value;
		}
	}

	$items = get_post_meta( $post_id, '_dm_faq_items', true );
	if ( is_array( $items ) && ! empty( $items ) ) {
		$args['items'] = $items;
	}

	return $args;
}

/* =====================================================================
 * FAQ CATEGORIES SECTION (FAQs page) — nested repeater:
 * categories -> each with its own list of questions.
 * ================================================================== */

/**
 * Render the FAQ Categories metabox.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_faqcats_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_faqcats', 'dm_legal_faqcats_nonce' );

	$heading = get_post_meta( $post->ID, '_dm_faqcat_heading', true );
	$lead    = get_post_meta( $post->ID, '_dm_faqcat_lead', true );
	$cats    = get_post_meta( $post->ID, '_dm_faqcat_items', true );
	$cats    = is_array( $cats ) ? $cats : array();
	?>
	<style>
		.dm-fc-field { margin-bottom:14px; }
		.dm-fc-field > label { display:block; font-weight:600; margin-bottom:4px; }
		.dm-fc-field input[type=text], .dm-fc-field textarea { width:100%; max-width:760px; }
		.dm-fc-cat { border:1px solid #c3c4c7; border-left:4px solid #2271b1; border-radius:4px; padding:12px 34px 12px 12px; margin-bottom:14px; background:#f6f7f7; position:relative; }
		.dm-fc-cat > .dm-fc-cat-title { display:flex; align-items:center; gap:8px; margin-bottom:10px; }
		.dm-fc-cat > .dm-fc-cat-title label { font-weight:600; white-space:nowrap; }
		.dm-fc-cat > .dm-fc-cat-title input { flex:1; max-width:480px; }
		.dm-fc-q { border:1px solid #dcdcde; border-radius:4px; padding:10px 32px 10px 10px; margin-bottom:8px; background:#fff; position:relative; }
		.dm-fc-q .dm-fc-q-row { display:grid; grid-template-columns:80px 1fr; gap:8px 12px; align-items:start; }
		.dm-fc-q label { font-weight:600; padding-top:6px; }
		.dm-fc-q input[type=text], .dm-fc-q textarea { width:100%; }
		.dm-fc-remove { position:absolute; top:6px; right:8px; }
	</style>

	<p class="description">
		<?php esc_html_e( 'Each category becomes a tab. Leave heading/lead blank to keep the template default. Categories replace the defaults only if you add at least one.', 'dm-legal' ); ?>
	</p>

	<div class="dm-fc-field">
		<label for="dm_fc_heading"><?php esc_html_e( 'Heading', 'dm-legal' ); ?></label>
		<input type="text" id="dm_fc_heading" name="_dm_faqcat_heading" value="<?php echo esc_attr( $heading ); ?>" placeholder="Frequently Asked Questions">
	</div>

	<div class="dm-fc-field">
		<label for="dm_fc_lead"><?php esc_html_e( 'Lead Paragraph', 'dm-legal' ); ?></label>
		<textarea id="dm_fc_lead" name="_dm_faqcat_lead" rows="2"><?php echo esc_textarea( $lead ); ?></textarea>
	</div>

	<h4><?php esc_html_e( 'Categories (Tabs)', 'dm-legal' ); ?></h4>
	<div id="dm-fc-cats">
		<?php foreach ( $cats as $ci => $cat ) : ?>
			<?php
			dm_legal_render_faqcat_row(
				(int) $ci,
				isset( $cat['title'] ) ? $cat['title'] : '',
				isset( $cat['faqs'] ) && is_array( $cat['faqs'] ) ? $cat['faqs'] : array()
			);
			?>
		<?php endforeach; ?>
	</div>

	<p>
		<button type="button" class="button button-primary" id="dm-fc-add-cat"><?php esc_html_e( '+ Add Category', 'dm-legal' ); ?></button>
	</p>

	<script type="text/html" id="tmpl-dm-fc-cat">
		<?php dm_legal_render_faqcat_row( '__ci__', '', array() ); ?>
	</script>
	<script type="text/html" id="tmpl-dm-fc-q">
		<?php dm_legal_render_faqcat_question_row( '__ci__', '__qi__', '', '' ); ?>
	</script>

	<script>
	(function ($) {
		var $cats = $('#dm-fc-cats');

		function nextIndex($scope, selector) {
			var max = -1;
			$scope.find(selector).each(function () {
				var i = parseInt($(this).data('index'), 10);
				if (!isNaN(i) && i > max) { max = i; }
			});
			return max + 1;
		}

		// Add a whole category (tab).
		$('#dm-fc-add-cat').on('click', function (e) {
			e.preventDefault();
			var ci = nextIndex($cats, '> .dm-fc-cat');
			$cats.append($('#tmpl-dm-fc-cat').html().replace(/__ci__/g, ci));
		});

		// Add a question inside a specific category.
		$cats.on('click', '.dm-fc-add-q', function (e) {
			e.preventDefault();
			var $cat = $(this).closest('.dm-fc-cat');
			var ci = $cat.data('index');
			var $list = $cat.find('.dm-fc-qs').first();
			var qi = nextIndex($list, '> .dm-fc-q');
			$list.append(
				$('#tmpl-dm-fc-q').html().replace(/__ci__/g, ci).replace(/__qi__/g, qi)
			);
		});

		// Remove a question, or a whole category.
		$cats.on('click', '.dm-fc-remove-q', function (e) {
			e.preventDefault();
			$(this).closest('.dm-fc-q').remove();
		});
		$cats.on('click', '.dm-fc-remove-cat', function (e) {
			e.preventDefault();
			$(this).closest('.dm-fc-cat').remove();
		});
	})(jQuery);
	</script>
	<?php
}

/**
 * Render one category block, including its nested question rows.
 *
 * @param int|string $ci    Category index (or __ci__ placeholder).
 * @param string     $title Category title.
 * @param array      $faqs  Questions in this category.
 * @return void
 */
function dm_legal_render_faqcat_row( $ci, $title, array $faqs ) {
	$name = '_dm_faqcat_items[' . $ci . ']';
	?>
	<div class="dm-fc-cat" data-index="<?php echo esc_attr( $ci ); ?>">
		<button type="button" class="button-link dm-fc-remove dm-fc-remove-cat" aria-label="<?php esc_attr_e( 'Remove category', 'dm-legal' ); ?>">&times;</button>

		<div class="dm-fc-cat-title">
			<label><?php esc_html_e( 'Category', 'dm-legal' ); ?></label>
			<input type="text" name="<?php echo esc_attr( $name ); ?>[title]" value="<?php echo esc_attr( $title ); ?>" placeholder="<?php esc_attr_e( 'e.g. General Information', 'dm-legal' ); ?>">
		</div>

		<div class="dm-fc-qs">
			<?php foreach ( $faqs as $qi => $faq ) : ?>
				<?php
				dm_legal_render_faqcat_question_row(
					$ci,
					(int) $qi,
					isset( $faq['question'] ) ? $faq['question'] : '',
					isset( $faq['answer'] ) ? $faq['answer'] : ''
				);
				?>
			<?php endforeach; ?>
		</div>

		<button type="button" class="button button-secondary dm-fc-add-q"><?php esc_html_e( '+ Add Question', 'dm-legal' ); ?></button>
	</div>
	<?php
}

/**
 * Render one question row nested inside a category.
 *
 * @param int|string $ci       Category index.
 * @param int|string $qi       Question index.
 * @param string     $question Question text.
 * @param string     $answer   Answer text.
 * @return void
 */
function dm_legal_render_faqcat_question_row( $ci, $qi, $question, $answer ) {
	$name = '_dm_faqcat_items[' . $ci . '][faqs][' . $qi . ']';
	?>
	<div class="dm-fc-q" data-index="<?php echo esc_attr( $qi ); ?>">
		<button type="button" class="button-link dm-fc-remove dm-fc-remove-q" aria-label="<?php esc_attr_e( 'Remove question', 'dm-legal' ); ?>">&times;</button>
		<div class="dm-fc-q-row">

			<label><?php esc_html_e( 'Question', 'dm-legal' ); ?></label>
			<div><input type="text" name="<?php echo esc_attr( $name ); ?>[question]" value="<?php echo esc_attr( $question ); ?>"></div>

			<label><?php esc_html_e( 'Answer', 'dm-legal' ); ?></label>
			<div><textarea name="<?php echo esc_attr( $name ); ?>[answer]" rows="2"><?php echo esc_textarea( $answer ); ?></textarea></div>

		</div>
	</div>
	<?php
}

/**
 * Save the FAQ Categories metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_faqcats_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_faqcats_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_faqcats_nonce'] ) ), 'dm_legal_save_faqcats' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$simple = array(
		'_dm_faqcat_heading' => 'sanitize_text_field',
		'_dm_faqcat_lead'    => 'sanitize_textarea_field',
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

	// Nested repeater: categories, each with its own questions.
	$raw  = isset( $_POST['_dm_faqcat_items'] ) ? wp_unslash( $_POST['_dm_faqcat_items'] ) : array();
	$cats = array();

	if ( is_array( $raw ) ) {
		foreach ( $raw as $cat ) {
			if ( ! is_array( $cat ) ) {
				continue;
			}

			$title = isset( $cat['title'] ) ? sanitize_text_field( $cat['title'] ) : '';

			// A category with no title is meaningless as a tab — drop it.
			if ( '' === $title ) {
				continue;
			}

			$faqs = array();
			if ( isset( $cat['faqs'] ) && is_array( $cat['faqs'] ) ) {
				foreach ( $cat['faqs'] as $faq ) {
					if ( ! is_array( $faq ) ) {
						continue;
					}

					$question = isset( $faq['question'] ) ? sanitize_text_field( $faq['question'] ) : '';
					$answer   = isset( $faq['answer'] ) ? sanitize_textarea_field( $faq['answer'] ) : '';

					if ( '' === $question ) {
						continue;
					}

					$faqs[] = array(
						'question' => $question,
						'answer'   => $answer,
					);
				}
			}

			$cats[] = array(
				'title' => $title,
				'faqs'  => $faqs,
			);
		}
	}

	if ( empty( $cats ) ) {
		delete_post_meta( $post_id, '_dm_faqcat_items' );
	} else {
		update_post_meta( $post_id, '_dm_faqcat_items', $cats );
	}
}
add_action( 'save_post_page', 'dm_legal_save_faqcats_metabox' );

/**
 * Merge saved FAQ Categories meta over the template defaults.
 *
 * @param array $defaults Keys: heading, lead, categories (title + faqs).
 * @param int   $post_id  Optional post ID; defaults to the queried page.
 * @return array
 */
function dm_legal_faqcats_args( array $defaults = array(), $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();

	if ( ! $post_id ) {
		return $defaults;
	}

	$args = $defaults;

	$heading = trim( (string) get_post_meta( $post_id, '_dm_faqcat_heading', true ) );
	if ( '' !== $heading ) {
		$args['heading'] = $heading;
	}

	$lead = trim( (string) get_post_meta( $post_id, '_dm_faqcat_lead', true ) );
	if ( '' !== $lead ) {
		$args['lead'] = $lead;
	}

	$cats = get_post_meta( $post_id, '_dm_faqcat_items', true );
	if ( is_array( $cats ) && ! empty( $cats ) ) {
		$args['categories'] = $cats;
	}

	return $args;
}

/* =====================================================================
 * EXPERT SIDEBAR & OFFICE CARD (Contact page)
 *
 * The office card's name/address/phone/email/hours/map all come from
 * DM Legal → Global Settings, so only the page-specific bits are here.
 * ================================================================== */

/**
 * Render the Expert Sidebar & Office Card metabox.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_csidebar_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_csidebar', 'dm_legal_csidebar_nonce' );

	$heading    = get_post_meta( $post->ID, '_dm_cs_heading', true );
	$btn_text   = get_post_meta( $post->ID, '_dm_cs_btn_text', true );
	$btn_href   = get_post_meta( $post->ID, '_dm_cs_btn_href', true );
	$directions = get_post_meta( $post->ID, '_dm_cs_directions_text', true );
	$experts    = get_post_meta( $post->ID, '_dm_cs_experts', true );
	$experts    = is_array( $experts ) ? $experts : array();
	?>
	<style>
		.dm-cs-field { margin-bottom:14px; }
		.dm-cs-field > label { display:block; font-weight:600; margin-bottom:4px; }
		.dm-cs-field input[type=text] { width:100%; max-width:760px; }
		.dm-cs-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; max-width:760px; }
		.dm-cs-expert { display:inline-flex; flex-direction:column; align-items:center; gap:6px; border:1px solid #dcdcde; border-radius:4px; padding:8px; margin:0 8px 8px 0; background:#fff; position:relative; width:120px; vertical-align:top; }
		.dm-cs-expert img { width:56px; height:56px; object-fit:cover; border-radius:50%; }
		.dm-cs-expert input { width:100%; font-size:11px; }
		.dm-cs-expert .dm-cs-remove { position:absolute; top:2px; right:6px; }
	</style>

	<p class="description">
		<?php esc_html_e( 'The office card\'s address, phone, email, hours and map come from DM Legal → Global Settings. Only the page-specific parts are editable here. Leave a field blank to keep the template default.', 'dm-legal' ); ?>
	</p>

	<div class="dm-cs-field">
		<label for="dm_cs_heading"><?php esc_html_e( 'Sidebar Heading', 'dm-legal' ); ?></label>
		<input type="text" id="dm_cs_heading" name="_dm_cs_heading" value="<?php echo esc_attr( $heading ); ?>" placeholder="Talk to an Expert">
	</div>

	<h4><?php esc_html_e( 'Expert Photos', 'dm-legal' ); ?></h4>
	<div id="dm-cs-experts">
		<?php foreach ( $experts as $i => $img ) : ?>
			<?php dm_legal_render_cs_expert_row( (int) $i, $img ); ?>
		<?php endforeach; ?>
	</div>
	<p>
		<button type="button" class="button button-secondary" id="dm-cs-add"><?php esc_html_e( '+ Add Expert Photo', 'dm-legal' ); ?></button>
	</p>

	<h4><?php esc_html_e( 'Sidebar Button', 'dm-legal' ); ?></h4>
	<div class="dm-cs-grid">
		<input type="text" name="_dm_cs_btn_text" value="<?php echo esc_attr( $btn_text ); ?>" placeholder="<?php esc_attr_e( 'Button label, e.g. Book Now', 'dm-legal' ); ?>">
		<input type="text" name="_dm_cs_btn_href" value="<?php echo esc_attr( $btn_href ); ?>" placeholder="<?php esc_attr_e( 'Link, e.g. book-your-lawyer.php', 'dm-legal' ); ?>">
	</div>
	<p class="description"><?php esc_html_e( 'The phone button beneath it uses the number from Global Settings.', 'dm-legal' ); ?></p>

	<div class="dm-cs-field" style="margin-top:14px;">
		<label for="dm_cs_directions"><?php esc_html_e( 'Office Card — Directions Button Label', 'dm-legal' ); ?></label>
		<input type="text" id="dm_cs_directions" name="_dm_cs_directions_text" value="<?php echo esc_attr( $directions ); ?>" placeholder="Get Directions">
	</div>

	<script type="text/html" id="tmpl-dm-cs-expert">
		<?php dm_legal_render_cs_expert_row( '__i__', '' ); ?>
	</script>

	<script>
	(function ($) {
		var $wrap = $('#dm-cs-experts');

		function nextIndex() {
			var max = -1;
			$wrap.find('.dm-cs-expert').each(function () {
				var i = parseInt($(this).data('index'), 10);
				if (!isNaN(i) && i > max) { max = i; }
			});
			return max + 1;
		}

		$('#dm-cs-add').on('click', function (e) {
			e.preventDefault();
			$wrap.append($('#tmpl-dm-cs-expert').html().replace(/__i__/g, nextIndex()));
		});

		$wrap.on('click', '.dm-cs-remove', function (e) {
			e.preventDefault();
			$(this).closest('.dm-cs-expert').remove();
		});

		$wrap.on('click', '.dm-cs-select', function (e) {
			e.preventDefault();
			var $row = $(this).closest('.dm-cs-expert');
			var frame = wp.media({
				title: '<?php echo esc_js( __( 'Select Expert Photo', 'dm-legal' ) ); ?>',
				button: { text: '<?php echo esc_js( __( 'Use this photo', 'dm-legal' ) ); ?>' },
				library: { type: 'image' },
				multiple: false
			});
			frame.on('select', function () {
				var url = frame.state().get('selection').first().toJSON().url;
				$row.find('.dm-cs-image').val(url);
				$row.find('img').attr('src', url).show();
			});
			frame.open();
		});
	})(jQuery);
	</script>
	<?php
}

/**
 * Render one expert-photo row.
 *
 * @param int|string $index Row index (or __i__ placeholder).
 * @param string     $img   Image URL.
 * @return void
 */
function dm_legal_render_cs_expert_row( $index, $img ) {
	?>
	<div class="dm-cs-expert" data-index="<?php echo esc_attr( $index ); ?>">
		<button type="button" class="button-link dm-cs-remove" aria-label="<?php esc_attr_e( 'Remove photo', 'dm-legal' ); ?>">&times;</button>
		<img src="<?php echo esc_url( $img ); ?>" <?php echo $img ? '' : 'style="display:none;"'; ?> alt="">
		<input type="url" class="dm-cs-image" name="_dm_cs_experts[<?php echo esc_attr( $index ); ?>]" value="<?php echo esc_attr( $img ); ?>" placeholder="<?php esc_attr_e( 'Image URL', 'dm-legal' ); ?>">
		<button type="button" class="button button-small dm-cs-select"><?php esc_html_e( 'Select', 'dm-legal' ); ?></button>
	</div>
	<?php
}

/**
 * Save the Expert Sidebar & Office Card metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_csidebar_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_csidebar_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_csidebar_nonce'] ) ), 'dm_legal_save_csidebar' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$simple = array(
		'_dm_cs_heading'         => 'sanitize_text_field',
		'_dm_cs_btn_text'        => 'sanitize_text_field',
		'_dm_cs_btn_href'        => 'sanitize_text_field',
		'_dm_cs_directions_text' => 'sanitize_text_field',
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

	// Expert photos: a flat list of URLs; drop empties.
	$raw     = isset( $_POST['_dm_cs_experts'] ) ? wp_unslash( $_POST['_dm_cs_experts'] ) : array();
	$experts = array();

	if ( is_array( $raw ) ) {
		foreach ( $raw as $img ) {
			$img = esc_url_raw( trim( (string) $img ) );
			if ( '' !== $img ) {
				$experts[] = $img;
			}
		}
	}

	if ( empty( $experts ) ) {
		delete_post_meta( $post_id, '_dm_cs_experts' );
	} else {
		update_post_meta( $post_id, '_dm_cs_experts', $experts );
	}
}
add_action( 'save_post_page', 'dm_legal_save_csidebar_metabox' );

/**
 * Merge saved Expert Sidebar meta over the template defaults.
 *
 * @param array $defaults Keys: heading, experts, btn_text, btn_href, directions_text.
 * @param int   $post_id  Optional post ID; defaults to the queried page.
 * @return array
 */
function dm_legal_csidebar_args( array $defaults = array(), $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();

	if ( ! $post_id ) {
		return $defaults;
	}

	$args = $defaults;

	$map = array(
		'heading'         => '_dm_cs_heading',
		'btn_text'        => '_dm_cs_btn_text',
		'btn_href'        => '_dm_cs_btn_href',
		'directions_text' => '_dm_cs_directions_text',
	);

	foreach ( $map as $arg_key => $meta_key ) {
		$value = trim( (string) get_post_meta( $post_id, $meta_key, true ) );
		if ( '' !== $value ) {
			$args[ $arg_key ] = $value;
		}
	}

	$experts = get_post_meta( $post_id, '_dm_cs_experts', true );
	if ( is_array( $experts ) && ! empty( $experts ) ) {
		$args['experts'] = $experts;
	}

	return $args;
}

/* =====================================================================
 * VALUE HEADING SECTION (Contact page)
 * ================================================================== */

/**
 * Render the Value Heading metabox.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_vheading_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_vheading', 'dm_legal_vheading_nonce' );

	$heading = get_post_meta( $post->ID, '_dm_vh_heading', true );
	$lead    = get_post_meta( $post->ID, '_dm_vh_lead', true );
	?>
	<p class="description">
		<?php esc_html_e( 'Leave a field blank to keep the template default.', 'dm-legal' ); ?>
	</p>

	<p>
		<label for="dm_vh_heading" style="display:block;font-weight:600;margin-bottom:4px;"><?php esc_html_e( 'Heading', 'dm-legal' ); ?></label>
		<input type="text" id="dm_vh_heading" name="_dm_vh_heading" value="<?php echo esc_attr( $heading ); ?>" style="width:100%;max-width:760px;" placeholder="Which One Delivers the Best Value for You?">
	</p>

	<p>
		<label for="dm_vh_lead" style="display:block;font-weight:600;margin-bottom:4px;"><?php esc_html_e( 'Lead Paragraph', 'dm-legal' ); ?></label>
		<textarea id="dm_vh_lead" name="_dm_vh_lead" rows="3" style="width:100%;max-width:760px;"><?php echo esc_textarea( $lead ); ?></textarea>
	</p>
	<?php
}

/**
 * Save the Value Heading metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_vheading_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_vheading_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_vheading_nonce'] ) ), 'dm_legal_save_vheading' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$simple = array(
		'_dm_vh_heading' => 'sanitize_text_field',
		'_dm_vh_lead'    => 'sanitize_textarea_field',
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
add_action( 'save_post_page', 'dm_legal_save_vheading_metabox' );

/**
 * Merge saved Value Heading meta over the template defaults.
 *
 * @param array $defaults Keys: heading, lead.
 * @param int   $post_id  Optional post ID; defaults to the queried page.
 * @return array
 */
function dm_legal_vheading_args( array $defaults = array(), $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();

	if ( ! $post_id ) {
		return $defaults;
	}

	$args = $defaults;

	$heading = trim( (string) get_post_meta( $post_id, '_dm_vh_heading', true ) );
	if ( '' !== $heading ) {
		$args['heading'] = $heading;
	}

	$lead = trim( (string) get_post_meta( $post_id, '_dm_vh_lead', true ) );
	if ( '' !== $lead ) {
		$args['lead'] = $lead;
	}

	return $args;
}

/* =====================================================================
 * ABOUT SECTION (Home / front page)
 * ================================================================== */

/**
 * Render the About metabox: heading, body text, and image.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_about_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_about', 'dm_legal_about_nonce' );

	$heading = get_post_meta( $post->ID, '_dm_about_heading', true );
	$body    = get_post_meta( $post->ID, '_dm_about_body', true );
	$image   = get_post_meta( $post->ID, '_dm_about_image', true );
	$alt     = get_post_meta( $post->ID, '_dm_about_image_alt', true );
	?>
	<style>
		.dm-about-field { margin-bottom:14px; }
		.dm-about-field > label { display:block; font-weight:600; margin-bottom:4px; }
		.dm-about-field input[type=text], .dm-about-field input[type=url], .dm-about-field textarea { width:100%; max-width:760px; }
		.dm-about-preview { max-width:220px; height:auto; display:block; margin-bottom:8px; border:1px solid #dcdcde; border-radius:4px; }
	</style>

	<p class="description">
		<?php esc_html_e( 'Leave a field blank to keep the template default.', 'dm-legal' ); ?>
	</p>

	<div class="dm-about-field">
		<label for="dm_about_heading"><?php esc_html_e( 'Heading', 'dm-legal' ); ?></label>
		<input type="text" id="dm_about_heading" name="_dm_about_heading" value="<?php echo esc_attr( $heading ); ?>" placeholder="About DM Legal Services">
	</div>

	<div class="dm-about-field">
		<label for="dm_about_body"><?php esc_html_e( 'Body Text', 'dm-legal' ); ?></label>
		<textarea id="dm_about_body" name="_dm_about_body" rows="6"><?php echo esc_textarea( $body ); ?></textarea>
	</div>

	<div class="dm-about-field">
		<label for="dm_about_image"><?php esc_html_e( 'Image', 'dm-legal' ); ?></label>
		<img src="<?php echo esc_url( $image ); ?>" class="dm-about-preview" id="dm_about_preview" <?php echo $image ? '' : 'style="display:none;"'; ?> alt="">
		<input type="url" id="dm_about_image" name="_dm_about_image" value="<?php echo esc_attr( $image ); ?>" placeholder="<?php esc_attr_e( 'Image URL', 'dm-legal' ); ?>">
		<p style="margin-top:6px;">
			<button type="button" class="button" id="dm_about_image_select"><?php esc_html_e( 'Select Image', 'dm-legal' ); ?></button>
			<button type="button" class="button" id="dm_about_image_clear"><?php esc_html_e( 'Clear', 'dm-legal' ); ?></button>
		</p>
	</div>

	<div class="dm-about-field">
		<label for="dm_about_image_alt"><?php esc_html_e( 'Image Alt Text', 'dm-legal' ); ?></label>
		<input type="text" id="dm_about_image_alt" name="_dm_about_image_alt" value="<?php echo esc_attr( $alt ); ?>" placeholder="About DM Legal Services">
	</div>

	<script>
	(function ($) {
		var frame;
		$('#dm_about_image_select').on('click', function (e) {
			e.preventDefault();
			if (frame) { frame.open(); return; }
			frame = wp.media({
				title: '<?php echo esc_js( __( 'Select About Image', 'dm-legal' ) ); ?>',
				button: { text: '<?php echo esc_js( __( 'Use this image', 'dm-legal' ) ); ?>' },
				library: { type: 'image' },
				multiple: false
			});
			frame.on('select', function () {
				var url = frame.state().get('selection').first().toJSON().url;
				$('#dm_about_image').val(url);
				$('#dm_about_preview').attr('src', url).show();
			});
			frame.open();
		});
		$('#dm_about_image_clear').on('click', function (e) {
			e.preventDefault();
			$('#dm_about_image').val('');
			$('#dm_about_preview').hide();
		});
	})(jQuery);
	</script>
	<?php
}

/**
 * Save the About metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_about_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_about_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_about_nonce'] ) ), 'dm_legal_save_about' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$simple = array(
		'_dm_about_heading'   => 'sanitize_text_field',
		'_dm_about_body'      => 'sanitize_textarea_field',
		'_dm_about_image'     => 'esc_url_raw',
		'_dm_about_image_alt' => 'sanitize_text_field',
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
add_action( 'save_post_page', 'dm_legal_save_about_metabox' );

/**
 * Merge saved About meta over the template defaults.
 *
 * @param array $defaults Keys: heading, body, image, image_alt.
 * @param int   $post_id  Optional post ID; defaults to the queried page.
 * @return array
 */
function dm_legal_about_args( array $defaults = array(), $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();

	if ( ! $post_id ) {
		return $defaults;
	}

	$args = $defaults;

	$map = array(
		'heading'   => '_dm_about_heading',
		'body'      => '_dm_about_body',
		'image'     => '_dm_about_image',
		'image_alt' => '_dm_about_image_alt',
	);

	foreach ( $map as $arg_key => $meta_key ) {
		$value = trim( (string) get_post_meta( $post_id, $meta_key, true ) );
		if ( '' !== $value ) {
			$args[ $arg_key ] = $value;
		}
	}

	return $args;
}

/**
 * Split a textarea value into an array of paragraphs on blank lines.
 *
 * @param string $text Raw textarea content.
 * @return array<int,string> Trimmed, non-empty paragraphs.
 */
function dm_legal_split_paragraphs( $text ) {
	$parts = preg_split( '/(?:\r\n|\r|\n){2,}/', (string) $text );
	$parts = array_filter( array_map( 'trim', (array) $parts ) );

	return array_values( $parts );
}

/* =====================================================================
 * EXPERT GUIDANCE / EXPRESSION SECTION (Home / front page)
 * ================================================================== */

/**
 * Render the Expert Guidance metabox: heading, body paragraphs, and image.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_expr_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_expr', 'dm_legal_expr_nonce' );

	$heading = get_post_meta( $post->ID, '_dm_expr_heading', true );
	$body    = get_post_meta( $post->ID, '_dm_expr_body', true );
	$image   = get_post_meta( $post->ID, '_dm_expr_image', true );
	$alt     = get_post_meta( $post->ID, '_dm_expr_image_alt', true );
	?>
	<style>
		.dm-expr-field { margin-bottom:14px; }
		.dm-expr-field > label { display:block; font-weight:600; margin-bottom:4px; }
		.dm-expr-field input[type=text], .dm-expr-field input[type=url], .dm-expr-field textarea { width:100%; max-width:760px; }
		.dm-expr-preview { max-width:220px; height:auto; display:block; margin-bottom:8px; border:1px solid #dcdcde; border-radius:4px; }
	</style>

	<p class="description">
		<?php esc_html_e( 'Leave a field blank to keep the template default.', 'dm-legal' ); ?>
	</p>

	<div class="dm-expr-field">
		<label for="dm_expr_heading"><?php esc_html_e( 'Heading', 'dm-legal' ); ?></label>
		<input type="text" id="dm_expr_heading" name="_dm_expr_heading" value="<?php echo esc_attr( $heading ); ?>" placeholder="Expert Guidance from Accredited Legal Professionals">
	</div>

	<div class="dm-expr-field">
		<label for="dm_expr_body"><?php esc_html_e( 'Body Paragraphs', 'dm-legal' ); ?></label>
		<textarea id="dm_expr_body" name="_dm_expr_body" rows="10"><?php echo esc_textarea( $body ); ?></textarea>
		<p class="description"><?php esc_html_e( 'Separate paragraphs with a blank line. Each block becomes its own paragraph.', 'dm-legal' ); ?></p>
	</div>

	<div class="dm-expr-field">
		<label for="dm_expr_image"><?php esc_html_e( 'Image', 'dm-legal' ); ?></label>
		<img src="<?php echo esc_url( $image ); ?>" class="dm-expr-preview" id="dm_expr_preview" <?php echo $image ? '' : 'style="display:none;"'; ?> alt="">
		<input type="url" id="dm_expr_image" name="_dm_expr_image" value="<?php echo esc_attr( $image ); ?>" placeholder="<?php esc_attr_e( 'Image URL', 'dm-legal' ); ?>">
		<p style="margin-top:6px;">
			<button type="button" class="button dm-media-select" data-target="#dm_expr_image" data-preview="#dm_expr_preview"><?php esc_html_e( 'Select Image', 'dm-legal' ); ?></button>
			<button type="button" class="button dm-media-clear" data-target="#dm_expr_image" data-preview="#dm_expr_preview"><?php esc_html_e( 'Clear', 'dm-legal' ); ?></button>
		</p>
	</div>

	<div class="dm-expr-field">
		<label for="dm_expr_image_alt"><?php esc_html_e( 'Image Alt Text', 'dm-legal' ); ?></label>
		<input type="text" id="dm_expr_image_alt" name="_dm_expr_image_alt" value="<?php echo esc_attr( $alt ); ?>" placeholder="Expert guidance from accredited legal professionals">
	</div>
	<?php
	dm_legal_media_picker_script();
}

/**
 * Save the Expert Guidance metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_expr_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_expr_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_expr_nonce'] ) ), 'dm_legal_save_expr' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$simple = array(
		'_dm_expr_heading'   => 'sanitize_text_field',
		'_dm_expr_body'      => 'sanitize_textarea_field',
		'_dm_expr_image'     => 'esc_url_raw',
		'_dm_expr_image_alt' => 'sanitize_text_field',
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
add_action( 'save_post_page', 'dm_legal_save_expr_metabox' );

/**
 * Merge saved Expert Guidance meta over the template defaults.
 *
 * @param array $defaults Keys: heading, body (array of paragraphs), image, image_alt.
 * @param int   $post_id  Optional post ID; defaults to the queried page.
 * @return array
 */
function dm_legal_expr_args( array $defaults = array(), $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();

	if ( ! $post_id ) {
		return $defaults;
	}

	$args = $defaults;

	$heading = trim( (string) get_post_meta( $post_id, '_dm_expr_heading', true ) );
	if ( '' !== $heading ) {
		$args['heading'] = $heading;
	}

	$body = dm_legal_split_paragraphs( get_post_meta( $post_id, '_dm_expr_body', true ) );
	if ( ! empty( $body ) ) {
		$args['body'] = $body;
	}

	$image = trim( (string) get_post_meta( $post_id, '_dm_expr_image', true ) );
	if ( '' !== $image ) {
		$args['image'] = $image;
	}

	$alt = trim( (string) get_post_meta( $post_id, '_dm_expr_image_alt', true ) );
	if ( '' !== $alt ) {
		$args['image_alt'] = $alt;
	}

	return $args;
}

/* =====================================================================
 * WHY CHOOSE US SECTION (Home / front page)
 * ================================================================== */

/**
 * Render the Why Choose Us metabox: heading, lead, stats repeater and
 * services repeater.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_wcu_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_wcu', 'dm_legal_wcu_nonce' );

	$heading  = get_post_meta( $post->ID, '_dm_wcu_heading', true );
	$lead     = get_post_meta( $post->ID, '_dm_wcu_lead', true );
	$stats    = get_post_meta( $post->ID, '_dm_wcu_stats', true );
	$stats    = is_array( $stats ) ? $stats : array();
	$services = get_post_meta( $post->ID, '_dm_wcu_services', true );
	$services = is_array( $services ) ? $services : array();
	?>
	<style>
		.dm-wcu-field { margin-bottom:14px; }
		.dm-wcu-field > label { display:block; font-weight:600; margin-bottom:4px; }
		.dm-wcu-field input[type=text], .dm-wcu-field textarea { width:100%; max-width:760px; }
		.dm-rep-row { border:1px solid #dcdcde; border-radius:4px; padding:12px 34px 12px 12px; margin-bottom:10px; background:#fff; position:relative; }
		.dm-rep-grid { display:grid; grid-template-columns:90px 1fr; gap:10px 14px; align-items:start; }
		.dm-rep-row label { font-weight:600; padding-top:6px; }
		.dm-rep-row input[type=text], .dm-rep-row input[type=url], .dm-rep-row textarea { width:100%; }
		.dm-rep-icon { width:40px; height:40px; object-fit:contain; border:1px solid #dcdcde; border-radius:4px; padding:4px; background:#fff; margin-bottom:6px; }
		.dm-rep-remove { position:absolute; top:8px; right:8px; }
	</style>

	<p class="description">
		<?php esc_html_e( 'Leave heading/lead blank to keep the template default. Stats and services replace the defaults only if you add at least one.', 'dm-legal' ); ?>
	</p>

	<div class="dm-wcu-field">
		<label for="dm_wcu_heading"><?php esc_html_e( 'Heading', 'dm-legal' ); ?></label>
		<input type="text" id="dm_wcu_heading" name="_dm_wcu_heading" value="<?php echo esc_attr( $heading ); ?>" placeholder="Why To Choose Us">
	</div>

	<div class="dm-wcu-field">
		<label for="dm_wcu_lead"><?php esc_html_e( 'Lead Paragraph', 'dm-legal' ); ?></label>
		<textarea id="dm_wcu_lead" name="_dm_wcu_lead" rows="2"><?php echo esc_textarea( $lead ); ?></textarea>
	</div>

	<h4><?php esc_html_e( 'Stats', 'dm-legal' ); ?></h4>
	<div id="dm-wcu-stats" class="dm-rep-list">
		<?php foreach ( $stats as $i => $stat ) : ?>
			<?php
			dm_legal_render_wcu_stat_row(
				(int) $i,
				isset( $stat['value'] ) ? $stat['value'] : '',
				isset( $stat['label'] ) ? $stat['label'] : ''
			);
			?>
		<?php endforeach; ?>
	</div>
	<p>
		<button type="button" class="button button-secondary dm-rep-add" data-list="#dm-wcu-stats" data-tmpl="#tmpl-dm-wcu-stat" data-item=".dm-rep-row"><?php esc_html_e( '+ Add Stat', 'dm-legal' ); ?></button>
	</p>

	<h4><?php esc_html_e( 'Service Cards', 'dm-legal' ); ?></h4>
	<div id="dm-wcu-services" class="dm-rep-list">
		<?php foreach ( $services as $i => $service ) : ?>
			<?php
			dm_legal_render_wcu_service_row(
				(int) $i,
				isset( $service['image'] ) ? $service['image'] : '',
				isset( $service['title'] ) ? $service['title'] : '',
				isset( $service['description'] ) ? $service['description'] : ''
			);
			?>
		<?php endforeach; ?>
	</div>
	<p>
		<button type="button" class="button button-secondary dm-rep-add" data-list="#dm-wcu-services" data-tmpl="#tmpl-dm-wcu-service" data-item=".dm-rep-row"><?php esc_html_e( '+ Add Service', 'dm-legal' ); ?></button>
	</p>

	<script type="text/html" id="tmpl-dm-wcu-stat">
		<?php dm_legal_render_wcu_stat_row( '__i__', '', '' ); ?>
	</script>
	<script type="text/html" id="tmpl-dm-wcu-service">
		<?php dm_legal_render_wcu_service_row( '__i__', '', '', '' ); ?>
	</script>
	<?php
	dm_legal_repeater_script();
	dm_legal_media_picker_script();
}

/**
 * Render one stat row.
 *
 * @param int|string $index Row index (or __i__ placeholder).
 * @param string     $value Stat value, e.g. 12+.
 * @param string     $label Stat label.
 * @return void
 */
function dm_legal_render_wcu_stat_row( $index, $value, $label ) {
	$name = '_dm_wcu_stats[' . $index . ']';
	?>
	<div class="dm-rep-row" data-index="<?php echo esc_attr( $index ); ?>">
		<button type="button" class="button-link dm-rep-remove" aria-label="<?php esc_attr_e( 'Remove stat', 'dm-legal' ); ?>">&times;</button>
		<div class="dm-rep-grid">
			<label><?php esc_html_e( 'Value', 'dm-legal' ); ?></label>
			<div><input type="text" name="<?php echo esc_attr( $name ); ?>[value]" value="<?php echo esc_attr( $value ); ?>" placeholder="12+"></div>

			<label><?php esc_html_e( 'Label', 'dm-legal' ); ?></label>
			<div><input type="text" name="<?php echo esc_attr( $name ); ?>[label]" value="<?php echo esc_attr( $label ); ?>" placeholder="Years of Knowledge"></div>
		</div>
	</div>
	<?php
}

/**
 * Render one service-card row.
 *
 * @param int|string $index       Row index (or __i__ placeholder).
 * @param string     $image       Icon URL.
 * @param string     $title       Card title.
 * @param string     $description Card description.
 * @return void
 */
function dm_legal_render_wcu_service_row( $index, $image, $title, $description ) {
	$name = '_dm_wcu_services[' . $index . ']';
	?>
	<div class="dm-rep-row" data-index="<?php echo esc_attr( $index ); ?>">
		<button type="button" class="button-link dm-rep-remove" aria-label="<?php esc_attr_e( 'Remove service', 'dm-legal' ); ?>">&times;</button>
		<div class="dm-rep-grid">
			<label><?php esc_html_e( 'Icon', 'dm-legal' ); ?></label>
			<div>
				<img src="<?php echo esc_url( $image ); ?>" class="dm-rep-icon dm-media-preview" <?php echo $image ? '' : 'style="display:none;"'; ?> alt="">
				<input type="url" class="dm-media-input" name="<?php echo esc_attr( $name ); ?>[image]" value="<?php echo esc_attr( $image ); ?>" placeholder="<?php esc_attr_e( 'Icon URL', 'dm-legal' ); ?>">
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
 * Save the Why Choose Us metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_wcu_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_wcu_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_wcu_nonce'] ) ), 'dm_legal_save_wcu' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$heading = isset( $_POST['_dm_wcu_heading'] ) ? sanitize_text_field( wp_unslash( $_POST['_dm_wcu_heading'] ) ) : '';
	$lead    = isset( $_POST['_dm_wcu_lead'] ) ? sanitize_textarea_field( wp_unslash( $_POST['_dm_wcu_lead'] ) ) : '';

	if ( '' === $heading ) {
		delete_post_meta( $post_id, '_dm_wcu_heading' );
	} else {
		update_post_meta( $post_id, '_dm_wcu_heading', $heading );
	}

	if ( '' === $lead ) {
		delete_post_meta( $post_id, '_dm_wcu_lead' );
	} else {
		update_post_meta( $post_id, '_dm_wcu_lead', $lead );
	}

	// Stats repeater: keep rows with a value or label.
	$raw   = isset( $_POST['_dm_wcu_stats'] ) ? wp_unslash( $_POST['_dm_wcu_stats'] ) : array();
	$stats = array();

	if ( is_array( $raw ) ) {
		foreach ( $raw as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$value = isset( $row['value'] ) ? sanitize_text_field( $row['value'] ) : '';
			$label = isset( $row['label'] ) ? sanitize_text_field( $row['label'] ) : '';
			if ( '' === $value && '' === $label ) {
				continue;
			}
			$stats[] = array(
				'value' => $value,
				'label' => $label,
			);
		}
	}

	if ( empty( $stats ) ) {
		delete_post_meta( $post_id, '_dm_wcu_stats' );
	} else {
		update_post_meta( $post_id, '_dm_wcu_stats', $stats );
	}

	// Services repeater: keep rows with a title or description.
	$raw      = isset( $_POST['_dm_wcu_services'] ) ? wp_unslash( $_POST['_dm_wcu_services'] ) : array();
	$services = array();

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
			$services[] = array(
				'image'       => $image,
				'title'       => $title,
				'description' => $description,
			);
		}
	}

	if ( empty( $services ) ) {
		delete_post_meta( $post_id, '_dm_wcu_services' );
	} else {
		update_post_meta( $post_id, '_dm_wcu_services', $services );
	}
}
add_action( 'save_post_page', 'dm_legal_save_wcu_metabox' );

/**
 * Merge saved Why Choose Us meta over the template defaults.
 *
 * @param array $defaults Keys: heading, lead, stats, services.
 * @param int   $post_id  Optional post ID; defaults to the queried page.
 * @return array
 */
function dm_legal_wcu_args( array $defaults = array(), $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();

	if ( ! $post_id ) {
		return $defaults;
	}

	$args = $defaults;

	$heading = trim( (string) get_post_meta( $post_id, '_dm_wcu_heading', true ) );
	if ( '' !== $heading ) {
		$args['heading'] = $heading;
	}

	$lead = trim( (string) get_post_meta( $post_id, '_dm_wcu_lead', true ) );
	if ( '' !== $lead ) {
		$args['lead'] = $lead;
	}

	$stats = get_post_meta( $post_id, '_dm_wcu_stats', true );
	if ( is_array( $stats ) && ! empty( $stats ) ) {
		$args['stats'] = $stats;
	}

	$services = get_post_meta( $post_id, '_dm_wcu_services', true );
	if ( is_array( $services ) && ! empty( $services ) ) {
		$args['services'] = $services;
	}

	return $args;
}

/* =====================================================================
 * AFFILIATIONS & MEMBERSHIP SECTION (Home / front page)
 * ================================================================== */

/**
 * Render the Affiliations metabox: heading, lead, and a logo repeater.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_aff_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_aff', 'dm_legal_aff_nonce' );

	$heading = get_post_meta( $post->ID, '_dm_aff_heading', true );
	$lead    = get_post_meta( $post->ID, '_dm_aff_lead', true );
	$logos   = get_post_meta( $post->ID, '_dm_aff_logos', true );
	$logos   = is_array( $logos ) ? $logos : array();
	?>
	<style>
		.dm-aff-field { margin-bottom:14px; }
		.dm-aff-field > label { display:block; font-weight:600; margin-bottom:4px; }
		.dm-aff-field input[type=text], .dm-aff-field textarea { width:100%; max-width:760px; }
	</style>

	<p class="description">
		<?php esc_html_e( 'Leave heading/lead blank to keep the template default. Logos replace the defaults only if you add at least one.', 'dm-legal' ); ?>
	</p>

	<div class="dm-aff-field">
		<label for="dm_aff_heading"><?php esc_html_e( 'Heading', 'dm-legal' ); ?></label>
		<input type="text" id="dm_aff_heading" name="_dm_aff_heading" value="<?php echo esc_attr( $heading ); ?>" placeholder="Our Affiliations & Membership">
	</div>

	<div class="dm-aff-field">
		<label for="dm_aff_lead"><?php esc_html_e( 'Lead Paragraph', 'dm-legal' ); ?></label>
		<textarea id="dm_aff_lead" name="_dm_aff_lead" rows="2"><?php echo esc_textarea( $lead ); ?></textarea>
	</div>

	<h4><?php esc_html_e( 'Logos', 'dm-legal' ); ?></h4>
	<div id="dm-aff-logos" class="dm-rep-list">
		<?php foreach ( $logos as $i => $logo ) : ?>
			<?php
			dm_legal_render_aff_logo_row(
				(int) $i,
				isset( $logo['image'] ) ? $logo['image'] : '',
				isset( $logo['alt'] ) ? $logo['alt'] : ''
			);
			?>
		<?php endforeach; ?>
	</div>
	<p>
		<button type="button" class="button button-secondary dm-rep-add" data-list="#dm-aff-logos" data-tmpl="#tmpl-dm-aff-logo" data-item=".dm-rep-row"><?php esc_html_e( '+ Add Logo', 'dm-legal' ); ?></button>
	</p>

	<script type="text/html" id="tmpl-dm-aff-logo">
		<?php dm_legal_render_aff_logo_row( '__i__', '', '' ); ?>
	</script>
	<?php
	dm_legal_repeater_script();
	dm_legal_media_picker_script();
}

/**
 * Render one affiliation-logo row.
 *
 * @param int|string $index Row index (or __i__ placeholder).
 * @param string     $image Logo URL.
 * @param string     $alt   Alt text.
 * @return void
 */
function dm_legal_render_aff_logo_row( $index, $image, $alt ) {
	$name = '_dm_aff_logos[' . $index . ']';
	?>
	<div class="dm-rep-row" data-index="<?php echo esc_attr( $index ); ?>">
		<button type="button" class="button-link dm-rep-remove" aria-label="<?php esc_attr_e( 'Remove logo', 'dm-legal' ); ?>">&times;</button>
		<div class="dm-rep-grid">
			<label><?php esc_html_e( 'Logo', 'dm-legal' ); ?></label>
			<div>
				<img src="<?php echo esc_url( $image ); ?>" class="dm-rep-icon dm-media-preview" <?php echo $image ? '' : 'style="display:none;"'; ?> alt="">
				<input type="url" class="dm-media-input" name="<?php echo esc_attr( $name ); ?>[image]" value="<?php echo esc_attr( $image ); ?>" placeholder="<?php esc_attr_e( 'Logo URL', 'dm-legal' ); ?>">
				<p style="margin:6px 0 0;">
					<button type="button" class="button dm-media-select"><?php esc_html_e( 'Select Logo', 'dm-legal' ); ?></button>
					<button type="button" class="button dm-media-clear"><?php esc_html_e( 'Clear', 'dm-legal' ); ?></button>
				</p>
			</div>

			<label><?php esc_html_e( 'Alt Text', 'dm-legal' ); ?></label>
			<div><input type="text" name="<?php echo esc_attr( $name ); ?>[alt]" value="<?php echo esc_attr( $alt ); ?>" placeholder="Doyles 2016 Award"></div>
		</div>
	</div>
	<?php
}

/**
 * Save the Affiliations metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_aff_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_aff_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_aff_nonce'] ) ), 'dm_legal_save_aff' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$heading = isset( $_POST['_dm_aff_heading'] ) ? sanitize_text_field( wp_unslash( $_POST['_dm_aff_heading'] ) ) : '';
	$lead    = isset( $_POST['_dm_aff_lead'] ) ? sanitize_textarea_field( wp_unslash( $_POST['_dm_aff_lead'] ) ) : '';

	if ( '' === $heading ) {
		delete_post_meta( $post_id, '_dm_aff_heading' );
	} else {
		update_post_meta( $post_id, '_dm_aff_heading', $heading );
	}

	if ( '' === $lead ) {
		delete_post_meta( $post_id, '_dm_aff_lead' );
	} else {
		update_post_meta( $post_id, '_dm_aff_lead', $lead );
	}

	// Logos repeater: keep rows with an image.
	$raw   = isset( $_POST['_dm_aff_logos'] ) ? wp_unslash( $_POST['_dm_aff_logos'] ) : array();
	$logos = array();

	if ( is_array( $raw ) ) {
		foreach ( $raw as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$image = isset( $row['image'] ) ? esc_url_raw( trim( $row['image'] ) ) : '';
			$alt   = isset( $row['alt'] ) ? sanitize_text_field( $row['alt'] ) : '';
			if ( '' === $image ) {
				continue;
			}
			$logos[] = array(
				'image' => $image,
				'alt'   => $alt,
			);
		}
	}

	if ( empty( $logos ) ) {
		delete_post_meta( $post_id, '_dm_aff_logos' );
	} else {
		update_post_meta( $post_id, '_dm_aff_logos', $logos );
	}
}
add_action( 'save_post_page', 'dm_legal_save_aff_metabox' );

/**
 * Merge saved Affiliations meta over the template defaults.
 *
 * @param array $defaults Keys: heading, lead, logos (image/alt).
 * @param int   $post_id  Optional post ID; defaults to the queried page.
 * @return array
 */
function dm_legal_aff_args( array $defaults = array(), $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();

	if ( ! $post_id ) {
		return $defaults;
	}

	$args = $defaults;

	$heading = trim( (string) get_post_meta( $post_id, '_dm_aff_heading', true ) );
	if ( '' !== $heading ) {
		$args['heading'] = $heading;
	}

	$lead = trim( (string) get_post_meta( $post_id, '_dm_aff_lead', true ) );
	if ( '' !== $lead ) {
		$args['lead'] = $lead;
	}

	$logos = get_post_meta( $post_id, '_dm_aff_logos', true );
	if ( is_array( $logos ) && ! empty( $logos ) ) {
		$args['logos'] = $logos;
	}

	return $args;
}

/* =====================================================================
 * PROFESSIONAL LEGAL SUPPORT (GET SUPPORT) SECTION (Home / front page)
 * ================================================================== */

/**
 * Render the Get Support metabox: heading, top paragraphs, feature list,
 * closing paragraph, and image.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_gs_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_gs', 'dm_legal_gs_nonce' );

	$heading  = get_post_meta( $post->ID, '_dm_gs_heading', true );
	$top      = get_post_meta( $post->ID, '_dm_gs_body_top', true );
	$features = get_post_meta( $post->ID, '_dm_gs_features', true );
	$bottom   = get_post_meta( $post->ID, '_dm_gs_body_bottom', true );
	$image    = get_post_meta( $post->ID, '_dm_gs_image', true );
	$alt      = get_post_meta( $post->ID, '_dm_gs_image_alt', true );
	?>
	<style>
		.dm-gs-field { margin-bottom:14px; }
		.dm-gs-field > label { display:block; font-weight:600; margin-bottom:4px; }
		.dm-gs-field input[type=text], .dm-gs-field input[type=url], .dm-gs-field textarea { width:100%; max-width:760px; }
		.dm-gs-preview { max-width:220px; height:auto; display:block; margin-bottom:8px; border:1px solid #dcdcde; border-radius:4px; }
	</style>

	<p class="description">
		<?php esc_html_e( 'Leave a field blank to keep the template default.', 'dm-legal' ); ?>
	</p>

	<div class="dm-gs-field">
		<label for="dm_gs_heading"><?php esc_html_e( 'Heading', 'dm-legal' ); ?></label>
		<input type="text" id="dm_gs_heading" name="_dm_gs_heading" value="<?php echo esc_attr( $heading ); ?>" placeholder="Professional Legal Support">
	</div>

	<div class="dm-gs-field">
		<label for="dm_gs_body_top"><?php esc_html_e( 'Body Paragraphs (above the list)', 'dm-legal' ); ?></label>
		<textarea id="dm_gs_body_top" name="_dm_gs_body_top" rows="7"><?php echo esc_textarea( $top ); ?></textarea>
		<p class="description"><?php esc_html_e( 'Separate paragraphs with a blank line.', 'dm-legal' ); ?></p>
	</div>

	<div class="dm-gs-field">
		<label for="dm_gs_features"><?php esc_html_e( 'Feature List', 'dm-legal' ); ?></label>
		<textarea id="dm_gs_features" name="_dm_gs_features" rows="6" placeholder="Business Law&#10;Commercial Law&#10;Criminal Law"><?php echo esc_textarea( $features ); ?></textarea>
		<p class="description"><?php esc_html_e( 'One item per line. Each renders with a check icon.', 'dm-legal' ); ?></p>
	</div>

	<div class="dm-gs-field">
		<label for="dm_gs_body_bottom"><?php esc_html_e( 'Closing Paragraph (below the list)', 'dm-legal' ); ?></label>
		<textarea id="dm_gs_body_bottom" name="_dm_gs_body_bottom" rows="3"><?php echo esc_textarea( $bottom ); ?></textarea>
	</div>

	<div class="dm-gs-field">
		<label for="dm_gs_image"><?php esc_html_e( 'Image', 'dm-legal' ); ?></label>
		<img src="<?php echo esc_url( $image ); ?>" class="dm-gs-preview" id="dm_gs_preview" <?php echo $image ? '' : 'style="display:none;"'; ?> alt="">
		<input type="url" id="dm_gs_image" name="_dm_gs_image" value="<?php echo esc_attr( $image ); ?>" placeholder="<?php esc_attr_e( 'Image URL', 'dm-legal' ); ?>">
		<p style="margin-top:6px;">
			<button type="button" class="button dm-media-select" data-target="#dm_gs_image" data-preview="#dm_gs_preview"><?php esc_html_e( 'Select Image', 'dm-legal' ); ?></button>
			<button type="button" class="button dm-media-clear" data-target="#dm_gs_image" data-preview="#dm_gs_preview"><?php esc_html_e( 'Clear', 'dm-legal' ); ?></button>
		</p>
	</div>

	<div class="dm-gs-field">
		<label for="dm_gs_image_alt"><?php esc_html_e( 'Image Alt Text', 'dm-legal' ); ?></label>
		<input type="text" id="dm_gs_image_alt" name="_dm_gs_image_alt" value="<?php echo esc_attr( $alt ); ?>" placeholder="Professional legal support">
	</div>
	<?php
	dm_legal_media_picker_script();
}

/**
 * Save the Get Support metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_gs_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_gs_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_gs_nonce'] ) ), 'dm_legal_save_gs' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$simple = array(
		'_dm_gs_heading'     => 'sanitize_text_field',
		'_dm_gs_body_top'    => 'sanitize_textarea_field',
		'_dm_gs_features'    => 'sanitize_textarea_field',
		'_dm_gs_body_bottom' => 'sanitize_textarea_field',
		'_dm_gs_image'       => 'esc_url_raw',
		'_dm_gs_image_alt'   => 'sanitize_text_field',
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
add_action( 'save_post_page', 'dm_legal_save_gs_metabox' );

/**
 * Merge saved Get Support meta over the template defaults.
 *
 * @param array $defaults Keys: heading, body_top (array), features (array),
 *                        body_bottom, image, image_alt.
 * @param int   $post_id  Optional post ID; defaults to the queried page.
 * @return array
 */
function dm_legal_gs_args( array $defaults = array(), $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();

	if ( ! $post_id ) {
		return $defaults;
	}

	$args = $defaults;

	$heading = trim( (string) get_post_meta( $post_id, '_dm_gs_heading', true ) );
	if ( '' !== $heading ) {
		$args['heading'] = $heading;
	}

	$top = dm_legal_split_paragraphs( get_post_meta( $post_id, '_dm_gs_body_top', true ) );
	if ( ! empty( $top ) ) {
		$args['body_top'] = $top;
	}

	$features = get_post_meta( $post_id, '_dm_gs_features', true );
	$features = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $features ) ) );
	if ( ! empty( $features ) ) {
		$args['features'] = array_values( $features );
	}

	$bottom = trim( (string) get_post_meta( $post_id, '_dm_gs_body_bottom', true ) );
	if ( '' !== $bottom ) {
		$args['body_bottom'] = $bottom;
	}

	$image = trim( (string) get_post_meta( $post_id, '_dm_gs_image', true ) );
	if ( '' !== $image ) {
		$args['image'] = $image;
	}

	$alt = trim( (string) get_post_meta( $post_id, '_dm_gs_image_alt', true ) );
	if ( '' !== $alt ) {
		$args['image_alt'] = $alt;
	}

	return $args;
}

/* =====================================================================
 * HOW WE WORK SECTION (Home / front page)
 * ================================================================== */

/**
 * Render the How We Work metabox: heading, lead, and a steps repeater.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_hww_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_hww', 'dm_legal_hww_nonce' );

	$heading = get_post_meta( $post->ID, '_dm_hww_heading', true );
	$lead    = get_post_meta( $post->ID, '_dm_hww_lead', true );
	$steps   = get_post_meta( $post->ID, '_dm_hww_steps', true );
	$steps   = is_array( $steps ) ? $steps : array();
	?>
	<style>
		.dm-hww-field { margin-bottom:14px; }
		.dm-hww-field > label { display:block; font-weight:600; margin-bottom:4px; }
		.dm-hww-field input[type=text], .dm-hww-field textarea { width:100%; max-width:760px; }
	</style>

	<p class="description">
		<?php esc_html_e( 'Leave heading/lead blank to keep the template default. Steps replace the defaults only if you add at least one.', 'dm-legal' ); ?>
	</p>

	<div class="dm-hww-field">
		<label for="dm_hww_heading"><?php esc_html_e( 'Heading', 'dm-legal' ); ?></label>
		<input type="text" id="dm_hww_heading" name="_dm_hww_heading" value="<?php echo esc_attr( $heading ); ?>" placeholder="How We Work">
	</div>

	<div class="dm-hww-field">
		<label for="dm_hww_lead"><?php esc_html_e( 'Lead Paragraph', 'dm-legal' ); ?></label>
		<textarea id="dm_hww_lead" name="_dm_hww_lead" rows="2"><?php echo esc_textarea( $lead ); ?></textarea>
	</div>

	<h4><?php esc_html_e( 'Steps', 'dm-legal' ); ?></h4>
	<div id="dm-hww-steps" class="dm-rep-list">
		<?php foreach ( $steps as $i => $step ) : ?>
			<?php
			dm_legal_render_hww_step_row(
				(int) $i,
				isset( $step['image'] ) ? $step['image'] : '',
				isset( $step['title'] ) ? $step['title'] : '',
				isset( $step['description'] ) ? $step['description'] : ''
			);
			?>
		<?php endforeach; ?>
	</div>
	<p>
		<button type="button" class="button button-secondary dm-rep-add" data-list="#dm-hww-steps" data-tmpl="#tmpl-dm-hww-step" data-item=".dm-rep-row"><?php esc_html_e( '+ Add Step', 'dm-legal' ); ?></button>
	</p>

	<script type="text/html" id="tmpl-dm-hww-step">
		<?php dm_legal_render_hww_step_row( '__i__', '', '', '' ); ?>
	</script>
	<?php
	dm_legal_repeater_script();
	dm_legal_media_picker_script();
}

/**
 * Render one How We Work step row.
 *
 * @param int|string $index       Row index (or __i__ placeholder).
 * @param string     $image       Icon URL.
 * @param string     $title       Step title.
 * @param string     $description Step description.
 * @return void
 */
function dm_legal_render_hww_step_row( $index, $image, $title, $description ) {
	$name = '_dm_hww_steps[' . $index . ']';
	?>
	<div class="dm-rep-row" data-index="<?php echo esc_attr( $index ); ?>">
		<button type="button" class="button-link dm-rep-remove" aria-label="<?php esc_attr_e( 'Remove step', 'dm-legal' ); ?>">&times;</button>
		<div class="dm-rep-grid">
			<label><?php esc_html_e( 'Icon', 'dm-legal' ); ?></label>
			<div>
				<img src="<?php echo esc_url( $image ); ?>" class="dm-rep-icon dm-media-preview" <?php echo $image ? '' : 'style="display:none;"'; ?> alt="">
				<input type="url" class="dm-media-input" name="<?php echo esc_attr( $name ); ?>[image]" value="<?php echo esc_attr( $image ); ?>" placeholder="<?php esc_attr_e( 'Icon URL', 'dm-legal' ); ?>">
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
 * Save the How We Work metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_hww_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_hww_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_hww_nonce'] ) ), 'dm_legal_save_hww' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$heading = isset( $_POST['_dm_hww_heading'] ) ? sanitize_text_field( wp_unslash( $_POST['_dm_hww_heading'] ) ) : '';
	$lead    = isset( $_POST['_dm_hww_lead'] ) ? sanitize_textarea_field( wp_unslash( $_POST['_dm_hww_lead'] ) ) : '';

	if ( '' === $heading ) {
		delete_post_meta( $post_id, '_dm_hww_heading' );
	} else {
		update_post_meta( $post_id, '_dm_hww_heading', $heading );
	}

	if ( '' === $lead ) {
		delete_post_meta( $post_id, '_dm_hww_lead' );
	} else {
		update_post_meta( $post_id, '_dm_hww_lead', $lead );
	}

	// Steps repeater: keep rows with a title or description.
	$raw   = isset( $_POST['_dm_hww_steps'] ) ? wp_unslash( $_POST['_dm_hww_steps'] ) : array();
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
		delete_post_meta( $post_id, '_dm_hww_steps' );
	} else {
		update_post_meta( $post_id, '_dm_hww_steps', $steps );
	}
}
add_action( 'save_post_page', 'dm_legal_save_hww_metabox' );

/**
 * Merge saved How We Work meta over the template defaults.
 *
 * @param array $defaults Keys: heading, lead, steps (image/title/description).
 * @param int   $post_id  Optional post ID; defaults to the queried page.
 * @return array
 */
function dm_legal_hww_args( array $defaults = array(), $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();

	if ( ! $post_id ) {
		return $defaults;
	}

	$args = $defaults;

	$heading = trim( (string) get_post_meta( $post_id, '_dm_hww_heading', true ) );
	if ( '' !== $heading ) {
		$args['heading'] = $heading;
	}

	$lead = trim( (string) get_post_meta( $post_id, '_dm_hww_lead', true ) );
	if ( '' !== $lead ) {
		$args['lead'] = $lead;
	}

	$steps = get_post_meta( $post_id, '_dm_hww_steps', true );
	if ( is_array( $steps ) && ! empty( $steps ) ) {
		$args['steps'] = $steps;
	}

	return $args;
}

/* =====================================================================
 * NEWS CAROUSEL SECTION (Home / front page)
 * ================================================================== */

/**
 * Render the News Carousel metabox: heading, lead, a slide repeater and the
 * "View All" button.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_news_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_news', 'dm_legal_news_nonce' );

	$heading   = get_post_meta( $post->ID, '_dm_news_heading', true );
	$lead      = get_post_meta( $post->ID, '_dm_news_lead', true );
	$items     = get_post_meta( $post->ID, '_dm_news_items', true );
	$items     = is_array( $items ) ? $items : array();
	$view_text = get_post_meta( $post->ID, '_dm_news_view_text', true );
	$view_href = get_post_meta( $post->ID, '_dm_news_view_href', true );
	?>
	<style>
		.dm-news-field { margin-bottom:14px; }
		.dm-news-field > label { display:block; font-weight:600; margin-bottom:4px; }
		.dm-news-field input[type=text], .dm-news-field textarea { width:100%; max-width:760px; }
		.dm-news-btn-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; max-width:760px; }
	</style>

	<p class="description">
		<?php esc_html_e( 'Leave heading/lead blank to keep the template default. Slides replace the defaults only if you add at least one.', 'dm-legal' ); ?>
	</p>

	<div class="dm-news-field">
		<label for="dm_news_heading"><?php esc_html_e( 'Heading', 'dm-legal' ); ?></label>
		<input type="text" id="dm_news_heading" name="_dm_news_heading" value="<?php echo esc_attr( $heading ); ?>" placeholder="How We Handle Your Problem">
	</div>

	<div class="dm-news-field">
		<label for="dm_news_lead"><?php esc_html_e( 'Lead Paragraph', 'dm-legal' ); ?></label>
		<textarea id="dm_news_lead" name="_dm_news_lead" rows="2"><?php echo esc_textarea( $lead ); ?></textarea>
	</div>

	<h4><?php esc_html_e( 'Slides', 'dm-legal' ); ?></h4>
	<div id="dm-news-items" class="dm-rep-list">
		<?php foreach ( $items as $i => $item ) : ?>
			<?php dm_legal_render_news_item_row( (int) $i, $item ); ?>
		<?php endforeach; ?>
	</div>
	<p>
		<button type="button" class="button button-secondary dm-rep-add" data-list="#dm-news-items" data-tmpl="#tmpl-dm-news-item" data-item=".dm-rep-row"><?php esc_html_e( '+ Add Slide', 'dm-legal' ); ?></button>
	</p>

	<h4><?php esc_html_e( 'View All Button', 'dm-legal' ); ?></h4>
	<div class="dm-news-btn-grid">
		<input type="text" name="_dm_news_view_text" value="<?php echo esc_attr( $view_text ); ?>" placeholder="<?php esc_attr_e( 'Button label, e.g. View All', 'dm-legal' ); ?>">
		<input type="text" name="_dm_news_view_href" value="<?php echo esc_attr( $view_href ); ?>" placeholder="<?php esc_attr_e( 'Link, e.g. blogs.php', 'dm-legal' ); ?>">
	</div>
	<p class="description"><?php esc_html_e( 'Clear the label to hide the button.', 'dm-legal' ); ?></p>

	<script type="text/html" id="tmpl-dm-news-item">
		<?php dm_legal_render_news_item_row( '__i__', array() ); ?>
	</script>
	<?php
	dm_legal_repeater_script();
	dm_legal_media_picker_script();
}

/**
 * Render one news-slide row.
 *
 * @param int|string $index Row index (or __i__ placeholder).
 * @param array      $item  Slide data (image/category/date/title/preview/link).
 * @return void
 */
function dm_legal_render_news_item_row( $index, $item ) {
	$name     = '_dm_news_items[' . $index . ']';
	$image    = isset( $item['image'] ) ? $item['image'] : '';
	$category = isset( $item['category'] ) ? $item['category'] : '';
	$date     = isset( $item['date'] ) ? $item['date'] : '';
	$title    = isset( $item['title'] ) ? $item['title'] : '';
	$preview  = isset( $item['preview'] ) ? $item['preview'] : '';
	$link     = isset( $item['link'] ) ? $item['link'] : '';
	?>
	<div class="dm-rep-row" data-index="<?php echo esc_attr( $index ); ?>">
		<button type="button" class="button-link dm-rep-remove" aria-label="<?php esc_attr_e( 'Remove slide', 'dm-legal' ); ?>">&times;</button>
		<div class="dm-rep-grid">
			<label><?php esc_html_e( 'Image', 'dm-legal' ); ?></label>
			<div>
				<img src="<?php echo esc_url( $image ); ?>" class="dm-rep-icon dm-media-preview" <?php echo $image ? '' : 'style="display:none;"'; ?> alt="">
				<input type="url" class="dm-media-input" name="<?php echo esc_attr( $name ); ?>[image]" value="<?php echo esc_attr( $image ); ?>" placeholder="<?php esc_attr_e( 'Background image URL', 'dm-legal' ); ?>">
				<p style="margin:6px 0 0;">
					<button type="button" class="button dm-media-select"><?php esc_html_e( 'Select Image', 'dm-legal' ); ?></button>
					<button type="button" class="button dm-media-clear"><?php esc_html_e( 'Clear', 'dm-legal' ); ?></button>
				</p>
			</div>

			<label><?php esc_html_e( 'Category', 'dm-legal' ); ?></label>
			<div><input type="text" name="<?php echo esc_attr( $name ); ?>[category]" value="<?php echo esc_attr( $category ); ?>" placeholder="Victories"></div>

			<label><?php esc_html_e( 'Date', 'dm-legal' ); ?></label>
			<div><input type="text" name="<?php echo esc_attr( $name ); ?>[date]" value="<?php echo esc_attr( $date ); ?>" placeholder="April 26, 2024"></div>

			<label><?php esc_html_e( 'Title', 'dm-legal' ); ?></label>
			<div><input type="text" name="<?php echo esc_attr( $name ); ?>[title]" value="<?php echo esc_attr( $title ); ?>"></div>

			<label><?php esc_html_e( 'Preview', 'dm-legal' ); ?></label>
			<div><textarea name="<?php echo esc_attr( $name ); ?>[preview]" rows="3"><?php echo esc_textarea( $preview ); ?></textarea></div>

			<label><?php esc_html_e( 'Link', 'dm-legal' ); ?></label>
			<div><input type="text" name="<?php echo esc_attr( $name ); ?>[link]" value="<?php echo esc_attr( $link ); ?>" placeholder="blogs.php or https://…"></div>
		</div>
	</div>
	<?php
}

/**
 * Save the News Carousel metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_news_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_news_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_news_nonce'] ) ), 'dm_legal_save_news' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$simple = array(
		'_dm_news_heading'   => 'sanitize_text_field',
		'_dm_news_lead'      => 'sanitize_textarea_field',
		'_dm_news_view_text' => 'sanitize_text_field',
		'_dm_news_view_href' => 'sanitize_text_field',
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

	// Slides repeater: keep rows with a title or preview.
	$raw   = isset( $_POST['_dm_news_items'] ) ? wp_unslash( $_POST['_dm_news_items'] ) : array();
	$items = array();

	if ( is_array( $raw ) ) {
		foreach ( $raw as $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$title   = isset( $row['title'] ) ? sanitize_text_field( $row['title'] ) : '';
			$preview = isset( $row['preview'] ) ? sanitize_textarea_field( $row['preview'] ) : '';
			if ( '' === $title && '' === $preview ) {
				continue;
			}
			$items[] = array(
				'image'    => isset( $row['image'] ) ? esc_url_raw( trim( $row['image'] ) ) : '',
				'category' => isset( $row['category'] ) ? sanitize_text_field( $row['category'] ) : '',
				'date'     => isset( $row['date'] ) ? sanitize_text_field( $row['date'] ) : '',
				'title'    => $title,
				'preview'  => $preview,
				'link'     => isset( $row['link'] ) ? sanitize_text_field( $row['link'] ) : '',
			);
		}
	}

	if ( empty( $items ) ) {
		delete_post_meta( $post_id, '_dm_news_items' );
	} else {
		update_post_meta( $post_id, '_dm_news_items', $items );
	}
}
add_action( 'save_post_page', 'dm_legal_save_news_metabox' );

/**
 * Merge saved News Carousel meta over the template defaults.
 *
 * @param array $defaults Keys: heading, lead, items, view_text, view_href.
 * @param int   $post_id  Optional post ID; defaults to the queried page.
 * @return array
 */
function dm_legal_news_args( array $defaults = array(), $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();

	if ( ! $post_id ) {
		return $defaults;
	}

	$args = $defaults;

	$map = array(
		'heading'   => '_dm_news_heading',
		'lead'      => '_dm_news_lead',
		'view_text' => '_dm_news_view_text',
		'view_href' => '_dm_news_view_href',
	);

	foreach ( $map as $arg_key => $meta_key ) {
		$value = trim( (string) get_post_meta( $post_id, $meta_key, true ) );
		if ( '' !== $value ) {
			$args[ $arg_key ] = $value;
		}
	}

	$items = get_post_meta( $post_id, '_dm_news_items', true );
	if ( is_array( $items ) && ! empty( $items ) ) {
		$args['items'] = $items;
	}

	return $args;
}

/* =====================================================================
 * LATEST BLOGS SECTION (Home / front page)
 *
 * The blog cards come from the shared blog dataset; only the section's
 * heading, lead, post count and "View All" button are editable here.
 * ================================================================== */

/**
 * Render the Latest Blogs metabox.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function dm_legal_render_lb_metabox( $post ) {
	wp_nonce_field( 'dm_legal_save_lb', 'dm_legal_lb_nonce' );

	$heading   = get_post_meta( $post->ID, '_dm_lb_heading', true );
	$lead      = get_post_meta( $post->ID, '_dm_lb_lead', true );
	$count     = get_post_meta( $post->ID, '_dm_lb_count', true );
	$view_text = get_post_meta( $post->ID, '_dm_lb_view_text', true );
	$view_href = get_post_meta( $post->ID, '_dm_lb_view_href', true );
	?>
	<style>
		.dm-lb-field { margin-bottom:14px; }
		.dm-lb-field > label { display:block; font-weight:600; margin-bottom:4px; }
		.dm-lb-field input[type=text], .dm-lb-field textarea { width:100%; max-width:760px; }
		.dm-lb-field input[type=number] { width:100px; }
		.dm-lb-btn-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; max-width:760px; }
	</style>

	<p class="description">
		<?php esc_html_e( 'The blog cards are pulled from the site\'s blog content. Only the heading, lead, count and button are editable here. Leave a field blank to keep the template default.', 'dm-legal' ); ?>
	</p>

	<div class="dm-lb-field">
		<label for="dm_lb_heading"><?php esc_html_e( 'Heading', 'dm-legal' ); ?></label>
		<input type="text" id="dm_lb_heading" name="_dm_lb_heading" value="<?php echo esc_attr( $heading ); ?>" placeholder="Our Latest Blogs">
	</div>

	<div class="dm-lb-field">
		<label for="dm_lb_lead"><?php esc_html_e( 'Lead Paragraph', 'dm-legal' ); ?></label>
		<textarea id="dm_lb_lead" name="_dm_lb_lead" rows="2"><?php echo esc_textarea( $lead ); ?></textarea>
	</div>

	<div class="dm-lb-field">
		<label for="dm_lb_count"><?php esc_html_e( 'Number of Posts', 'dm-legal' ); ?></label>
		<input type="number" id="dm_lb_count" name="_dm_lb_count" value="<?php echo esc_attr( $count ); ?>" min="1" max="12" placeholder="3">
	</div>

	<h4><?php esc_html_e( 'View All Button', 'dm-legal' ); ?></h4>
	<div class="dm-lb-btn-grid">
		<input type="text" name="_dm_lb_view_text" value="<?php echo esc_attr( $view_text ); ?>" placeholder="<?php esc_attr_e( 'Button label, e.g. View All', 'dm-legal' ); ?>">
		<input type="text" name="_dm_lb_view_href" value="<?php echo esc_attr( $view_href ); ?>" placeholder="<?php esc_attr_e( 'Link, e.g. blogs.php', 'dm-legal' ); ?>">
	</div>
	<p class="description"><?php esc_html_e( 'Clear the label to hide the button.', 'dm-legal' ); ?></p>
	<?php
}

/**
 * Save the Latest Blogs metabox.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function dm_legal_save_lb_metabox( $post_id ) {
	if ( ! isset( $_POST['dm_legal_lb_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['dm_legal_lb_nonce'] ) ), 'dm_legal_save_lb' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$simple = array(
		'_dm_lb_heading'   => 'sanitize_text_field',
		'_dm_lb_lead'      => 'sanitize_textarea_field',
		'_dm_lb_view_text' => 'sanitize_text_field',
		'_dm_lb_view_href' => 'sanitize_text_field',
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

	// Count: a positive integer, or clear to fall back to the default.
	$count = isset( $_POST['_dm_lb_count'] ) ? absint( wp_unslash( $_POST['_dm_lb_count'] ) ) : 0;
	if ( $count > 0 ) {
		update_post_meta( $post_id, '_dm_lb_count', $count );
	} else {
		delete_post_meta( $post_id, '_dm_lb_count' );
	}
}
add_action( 'save_post_page', 'dm_legal_save_lb_metabox' );

/**
 * Merge saved Latest Blogs meta over the template defaults.
 *
 * @param array $defaults Keys: heading, lead, count, view_text, view_href.
 * @param int   $post_id  Optional post ID; defaults to the queried page.
 * @return array
 */
function dm_legal_lb_args( array $defaults = array(), $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();

	if ( ! $post_id ) {
		return $defaults;
	}

	$args = $defaults;

	$map = array(
		'heading'   => '_dm_lb_heading',
		'lead'      => '_dm_lb_lead',
		'view_text' => '_dm_lb_view_text',
		'view_href' => '_dm_lb_view_href',
	);

	foreach ( $map as $arg_key => $meta_key ) {
		$value = trim( (string) get_post_meta( $post_id, $meta_key, true ) );
		if ( '' !== $value ) {
			$args[ $arg_key ] = $value;
		}
	}

	$count = (int) get_post_meta( $post_id, '_dm_lb_count', true );
	if ( $count > 0 ) {
		$args['count'] = $count;
	}

	return $args;
}

/* =====================================================================
 * SHARED ADMIN SCRIPTS (repeater add/remove + media picker)
 *
 * Printed inside each metabox that needs them. Guarded so the handlers
 * bind only once even when several metaboxes call them on one screen.
 * ================================================================== */

/**
 * Print the generic repeater add/remove handler once per request.
 *
 * Works with any list container using: an "+ Add" button with class
 * dm-rep-add and data-list/data-tmpl/data-item attributes, rows carrying
 * data-index, and a remove button with class dm-rep-remove.
 *
 * @return void
 */
function dm_legal_repeater_script() {
	static $printed = false;
	if ( $printed ) {
		return;
	}
	$printed = true;
	?>
	<script>
	(function ($) {
		function nextIndex($list, itemSel) {
			var max = -1;
			$list.find(itemSel).each(function () {
				var i = parseInt($(this).data('index'), 10);
				if (!isNaN(i) && i > max) { max = i; }
			});
			return max + 1;
		}

		$(document).on('click', '.dm-rep-add', function (e) {
			e.preventDefault();
			var $btn  = $(this);
			var $list = $($btn.data('list'));
			var tmpl  = $($btn.data('tmpl')).html();
			var item  = $btn.data('item');
			if (!$list.length || !tmpl) { return; }
			$list.append(tmpl.replace(/__i__/g, nextIndex($list, item)));
		});

		$(document).on('click', '.dm-rep-remove', function (e) {
			e.preventDefault();
			$(this).closest('[data-index]').remove();
		});
	})(jQuery);
	</script>
	<?php
}

/**
 * Print the generic media-picker handler once per request.
 *
 * Two usage styles are supported:
 *  - Single field: a .dm-media-select / .dm-media-clear button with
 *    data-target (input selector) and data-preview (img selector).
 *  - Repeater row: a .dm-media-select / .dm-media-clear button with no data
 *    attributes; it targets the .dm-media-input and .dm-media-preview within
 *    its own row (nearest ancestor carrying data-index).
 *
 * @return void
 */
function dm_legal_media_picker_script() {
	static $printed = false;
	if ( $printed ) {
		return;
	}
	$printed = true;
	?>
	<script>
	(function ($) {
		function ctx($btn) {
			var target  = $btn.data('target');
			var preview = $btn.data('preview');
			if (target) {
				return { $input: $(target), $img: preview ? $(preview) : $() };
			}
			var $row = $btn.closest('[data-index]');
			return { $input: $row.find('.dm-media-input').first(), $img: $row.find('.dm-media-preview').first() };
		}

		$(document).on('click', '.dm-media-select', function (e) {
			e.preventDefault();
			var c = ctx($(this));
			var frame = wp.media({
				title: '<?php echo esc_js( __( 'Select Image', 'dm-legal' ) ); ?>',
				button: { text: '<?php echo esc_js( __( 'Use this image', 'dm-legal' ) ); ?>' },
				library: { type: 'image' },
				multiple: false
			});
			frame.on('select', function () {
				var url = frame.state().get('selection').first().toJSON().url;
				c.$input.val(url);
				c.$img.attr('src', url).show();
			});
			frame.open();
		});

		$(document).on('click', '.dm-media-clear', function (e) {
			e.preventDefault();
			var c = ctx($(this));
			c.$input.val('');
			c.$img.hide();
		});
	})(jQuery);
	</script>
	<?php
}

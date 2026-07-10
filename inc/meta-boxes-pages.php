<?php
/**
 * Page-specific meta boxes for Home, Fixed Prices, and FAQs. Follows the
 * meta box standard exactly: a plain array-returning allowed-slugs function
 * (no apply_filters), add_meta_box() itself gated by global $post + slug
 * check, and the save handler in strict order: nonce -> capability ->
 * autosave guard -> revision guard -> allowed-slug check -> sanitize -> save.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The only Pages that get these meta boxes. Plain array, no filters —
 * per convention, disallowed pages simply never see the box registered;
 * there is no admin notice for them.
 */
function dmlegal_page_meta_allowed_slugs(): array {
	return [ 'home', 'fixed-prices', 'faqs' ];
}

function dmlegal_icon_title_description_fields(): array {
	return [
		[ 'key' => 'icon_id', 'label' => __( 'Icon', 'dmlegal' ), 'type' => 'media' ],
		[ 'key' => 'title', 'label' => __( 'Title', 'dmlegal' ), 'type' => 'text' ],
		[ 'key' => 'description', 'label' => __( 'Description', 'dmlegal' ), 'type' => 'textarea' ],
	];
}

function dmlegal_home_hero_feature_fields(): array {
	return [
		[ 'key' => 'feature', 'label' => __( 'Feature', 'dmlegal' ), 'type' => 'text' ],
	];
}

function dmlegal_home_stat_fields(): array {
	return [
		[ 'key' => 'value', 'label' => __( 'Value', 'dmlegal' ), 'type' => 'text' ],
		[ 'key' => 'label', 'label' => __( 'Label', 'dmlegal' ), 'type' => 'text' ],
	];
}

function dmlegal_affiliation_fields(): array {
	return [
		[ 'key' => 'logo_id', 'label' => __( 'Logo', 'dmlegal' ), 'type' => 'media' ],
	];
}

function dmlegal_fee_service_fields(): array {
	return [
		// Free-text tab label (e.g. "Criminal Law") rather than a relation to
		// the practice_area CPT — matches the original data shape, and groups
		// rows into the front-end tabs by matching label.
		[ 'key' => 'practice_area_label', 'label' => __( 'Practice Area Tab', 'dmlegal' ), 'type' => 'text' ],
		[ 'key' => 'icon_id', 'label' => __( 'Icon', 'dmlegal' ), 'type' => 'media' ],
		[ 'key' => 'title', 'label' => __( 'Service Title', 'dmlegal' ), 'type' => 'text' ],
		// One tier per line, formatted as "Label | Price" (e.g. "Standard Consultation | $250").
		[ 'key' => 'tiers', 'label' => __( 'Fee Tiers (one per line: Label | Price)', 'dmlegal' ), 'type' => 'textarea' ],
	];
}

function dmlegal_faq_item_fields(): array {
	return [
		[ 'key' => 'category', 'label' => __( 'Category', 'dmlegal' ), 'type' => 'text' ],
		[ 'key' => 'question', 'label' => __( 'Question', 'dmlegal' ), 'type' => 'text' ],
		[ 'key' => 'answer', 'label' => __( 'Answer', 'dmlegal' ), 'type' => 'textarea' ],
	];
}

function dmlegal_add_page_meta_boxes() {
	global $post;

	if ( ! $post || ! in_array( $post->post_name, dmlegal_page_meta_allowed_slugs(), true ) ) {
		return;
	}

	if ( $post->post_name === 'home' ) {
		add_meta_box( 'dmlegal_home_hero', __( 'Home: Hero', 'dmlegal' ), 'dmlegal_render_home_hero_meta_box', 'page', 'normal', 'high' );
		add_meta_box( 'dmlegal_home_stats', __( 'Home: Stats', 'dmlegal' ), 'dmlegal_render_home_stats_meta_box', 'page', 'normal', 'default' );
		add_meta_box( 'dmlegal_home_services', __( 'Home: How We Help Services', 'dmlegal' ), 'dmlegal_render_home_services_meta_box', 'page', 'normal', 'default' );
		add_meta_box( 'dmlegal_home_affiliations', __( 'Home: Affiliation Logos', 'dmlegal' ), 'dmlegal_render_home_affiliations_meta_box', 'page', 'normal', 'default' );
		add_meta_box( 'dmlegal_home_video', __( 'Home: Video Section', 'dmlegal' ), 'dmlegal_render_home_video_meta_box', 'page', 'normal', 'default' );
	}

	if ( $post->post_name === 'fixed-prices' ) {
		add_meta_box( 'dmlegal_fp_intro_steps', __( 'Fixed Prices: Why Fixed Fees (steps)', 'dmlegal' ), 'dmlegal_render_fp_intro_steps_meta_box', 'page', 'normal', 'high' );
		add_meta_box( 'dmlegal_fp_services', __( 'Fixed Prices: Fee Services & Tiers', 'dmlegal' ), 'dmlegal_render_fp_services_meta_box', 'page', 'normal', 'default' );
	}

	if ( $post->post_name === 'faqs' ) {
		add_meta_box( 'dmlegal_faq_items', __( 'FAQ Items', 'dmlegal' ), 'dmlegal_render_faq_items_meta_box', 'page', 'normal', 'high' );
	}
}
add_action( 'add_meta_boxes', 'dmlegal_add_page_meta_boxes' );

// ---------------------------------------------------------------------
// Home meta boxes
// ---------------------------------------------------------------------

function dmlegal_render_home_hero_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'dmlegal_save_page_meta', 'dmlegal_page_meta_nonce' );

	$heading = get_post_meta( $post->ID, '_home_hero_heading', true );
	$subtext = get_post_meta( $post->ID, '_home_hero_subtext', true );
	$features = get_post_meta( $post->ID, '_home_hero_features', true );
	$features = is_array( $features ) ? $features : [];
	?>
	<p>
		<label for="dmlegal_home_hero_heading"><strong><?php esc_html_e( 'Heading', 'dmlegal' ); ?></strong></label><br>
		<input type="text" id="dmlegal_home_hero_heading" name="dmlegal_home_hero_heading" value="<?php echo esc_attr( $heading ); ?>" style="width:100%;">
	</p>
	<p>
		<label for="dmlegal_home_hero_subtext"><strong><?php esc_html_e( 'Subtext', 'dmlegal' ); ?></strong></label><br>
		<textarea id="dmlegal_home_hero_subtext" name="dmlegal_home_hero_subtext" rows="3" style="width:100%;"><?php echo esc_textarea( $subtext ); ?></textarea>
	</p>
	<p><strong><?php esc_html_e( 'Feature Bullets', 'dmlegal' ); ?></strong></p>
	<?php dmlegal_render_repeater_field( 'dmlegal_home_hero_features', dmlegal_home_hero_feature_fields(), $features ); ?>
	<?php
}

function dmlegal_render_home_stats_meta_box( WP_Post $post ): void {
	$stats = get_post_meta( $post->ID, '_home_stats', true );
	dmlegal_render_repeater_field( 'dmlegal_home_stats', dmlegal_home_stat_fields(), is_array( $stats ) ? $stats : [] );
}

function dmlegal_render_home_services_meta_box( WP_Post $post ): void {
	$services = get_post_meta( $post->ID, '_home_services', true );
	dmlegal_render_repeater_field( 'dmlegal_home_services', dmlegal_icon_title_description_fields(), is_array( $services ) ? $services : [] );
}

function dmlegal_render_home_affiliations_meta_box( WP_Post $post ): void {
	$affiliations = get_post_meta( $post->ID, '_home_affiliations', true );
	dmlegal_render_repeater_field( 'dmlegal_home_affiliations', dmlegal_affiliation_fields(), is_array( $affiliations ) ? $affiliations : [] );
}

function dmlegal_render_home_video_meta_box( WP_Post $post ): void {
	$title       = get_post_meta( $post->ID, '_home_video_title', true );
	$description = get_post_meta( $post->ID, '_home_video_description', true );
	$video_url   = get_post_meta( $post->ID, '_home_video_url', true );
	$button_text = get_post_meta( $post->ID, '_home_video_button_text', true );
	$button_link = get_post_meta( $post->ID, '_home_video_button_link', true );
	?>
	<p>
		<label for="dmlegal_home_video_title"><strong><?php esc_html_e( 'Title', 'dmlegal' ); ?></strong></label><br>
		<input type="text" id="dmlegal_home_video_title" name="dmlegal_home_video_title" value="<?php echo esc_attr( $title ); ?>" style="width:100%;">
	</p>
	<p>
		<label for="dmlegal_home_video_description"><strong><?php esc_html_e( 'Description', 'dmlegal' ); ?></strong></label><br>
		<textarea id="dmlegal_home_video_description" name="dmlegal_home_video_description" rows="3" style="width:100%;"><?php echo esc_textarea( $description ); ?></textarea>
	</p>
	<p>
		<label for="dmlegal_home_video_url"><strong><?php esc_html_e( 'Video URL (mp4)', 'dmlegal' ); ?></strong></label><br>
		<input type="url" id="dmlegal_home_video_url" name="dmlegal_home_video_url" value="<?php echo esc_attr( $video_url ); ?>" style="width:100%;">
	</p>
	<p>
		<label for="dmlegal_home_video_button_text"><strong><?php esc_html_e( 'Button Text', 'dmlegal' ); ?></strong></label><br>
		<input type="text" id="dmlegal_home_video_button_text" name="dmlegal_home_video_button_text" value="<?php echo esc_attr( $button_text ); ?>" style="width:100%;">
	</p>
	<p>
		<label for="dmlegal_home_video_button_link"><strong><?php esc_html_e( 'Button Link', 'dmlegal' ); ?></strong></label><br>
		<input type="url" id="dmlegal_home_video_button_link" name="dmlegal_home_video_button_link" value="<?php echo esc_attr( $button_link ); ?>" style="width:100%;">
	</p>
	<?php
}

// ---------------------------------------------------------------------
// Fixed Prices meta boxes
// ---------------------------------------------------------------------

function dmlegal_render_fp_intro_steps_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'dmlegal_save_page_meta', 'dmlegal_page_meta_nonce' );

	$steps = get_post_meta( $post->ID, '_fp_intro_steps', true );
	dmlegal_render_repeater_field( 'dmlegal_fp_intro_steps', dmlegal_icon_title_description_fields(), is_array( $steps ) ? $steps : [] );
}

function dmlegal_render_fp_services_meta_box( WP_Post $post ): void {
	$services = get_post_meta( $post->ID, '_fp_services', true );
	dmlegal_render_repeater_field( 'dmlegal_fp_services', dmlegal_fee_service_fields(), is_array( $services ) ? $services : [] );
}

// ---------------------------------------------------------------------
// FAQs meta box
// ---------------------------------------------------------------------

function dmlegal_render_faq_items_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'dmlegal_save_page_meta', 'dmlegal_page_meta_nonce' );

	$items = get_post_meta( $post->ID, '_faq_items', true );
	dmlegal_render_repeater_field( 'dmlegal_faq_items', dmlegal_faq_item_fields(), is_array( $items ) ? $items : [] );
}

// ---------------------------------------------------------------------
// Save handler — nonce -> capability -> autosave -> revision -> allowed-slug -> sanitize -> save
// ---------------------------------------------------------------------

function dmlegal_save_page_meta( int $post_id ): void {
	if ( ! isset( $_POST['dmlegal_page_meta_nonce'] ) || ! wp_verify_nonce( $_POST['dmlegal_page_meta_nonce'], 'dmlegal_save_page_meta' ) ) {
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

	$post = get_post( $post_id );
	if ( ! $post || $post->post_type !== 'page' || ! in_array( $post->post_name, dmlegal_page_meta_allowed_slugs(), true ) ) {
		return;
	}

	if ( $post->post_name === 'home' ) {
		if ( isset( $_POST['dmlegal_home_hero_heading'] ) ) {
			update_post_meta( $post_id, '_home_hero_heading', sanitize_text_field( wp_unslash( $_POST['dmlegal_home_hero_heading'] ) ) );
		}
		if ( isset( $_POST['dmlegal_home_hero_subtext'] ) ) {
			update_post_meta( $post_id, '_home_hero_subtext', sanitize_textarea_field( wp_unslash( $_POST['dmlegal_home_hero_subtext'] ) ) );
		}
		update_post_meta( $post_id, '_home_hero_features', dmlegal_sanitize_repeater_field( $_POST['dmlegal_home_hero_features'] ?? [], dmlegal_home_hero_feature_fields() ) );
		update_post_meta( $post_id, '_home_stats', dmlegal_sanitize_repeater_field( $_POST['dmlegal_home_stats'] ?? [], dmlegal_home_stat_fields() ) );
		update_post_meta( $post_id, '_home_services', dmlegal_sanitize_repeater_field( $_POST['dmlegal_home_services'] ?? [], dmlegal_icon_title_description_fields() ) );
		update_post_meta( $post_id, '_home_affiliations', dmlegal_sanitize_repeater_field( $_POST['dmlegal_home_affiliations'] ?? [], dmlegal_affiliation_fields() ) );

		if ( isset( $_POST['dmlegal_home_video_title'] ) ) {
			update_post_meta( $post_id, '_home_video_title', sanitize_text_field( wp_unslash( $_POST['dmlegal_home_video_title'] ) ) );
		}
		if ( isset( $_POST['dmlegal_home_video_description'] ) ) {
			update_post_meta( $post_id, '_home_video_description', sanitize_textarea_field( wp_unslash( $_POST['dmlegal_home_video_description'] ) ) );
		}
		if ( isset( $_POST['dmlegal_home_video_url'] ) ) {
			update_post_meta( $post_id, '_home_video_url', sanitize_url( wp_unslash( $_POST['dmlegal_home_video_url'] ) ) );
		}
		if ( isset( $_POST['dmlegal_home_video_button_text'] ) ) {
			update_post_meta( $post_id, '_home_video_button_text', sanitize_text_field( wp_unslash( $_POST['dmlegal_home_video_button_text'] ) ) );
		}
		if ( isset( $_POST['dmlegal_home_video_button_link'] ) ) {
			update_post_meta( $post_id, '_home_video_button_link', sanitize_url( wp_unslash( $_POST['dmlegal_home_video_button_link'] ) ) );
		}
	}

	if ( $post->post_name === 'fixed-prices' ) {
		update_post_meta( $post_id, '_fp_intro_steps', dmlegal_sanitize_repeater_field( $_POST['dmlegal_fp_intro_steps'] ?? [], dmlegal_icon_title_description_fields() ) );
		update_post_meta( $post_id, '_fp_services', dmlegal_sanitize_repeater_field( $_POST['dmlegal_fp_services'] ?? [], dmlegal_fee_service_fields() ) );
	}

	if ( $post->post_name === 'faqs' ) {
		update_post_meta( $post_id, '_faq_items', dmlegal_sanitize_repeater_field( $_POST['dmlegal_faq_items'] ?? [], dmlegal_faq_item_fields() ) );
	}
}
add_action( 'save_post_page', 'dmlegal_save_page_meta' );

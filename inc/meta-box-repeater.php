<?php
/**
 * Shared rendering + sanitize helpers for hand-rolled repeater fields.
 * This is the native-only stand-in for ACF's repeater field: each row is a
 * fixed set of sub-fields (text/textarea/media), rows are added/removed by
 * assets/js/admin-repeater.js, and the whole list is stored as one
 * serialized array in a single post meta key.
 *
 * $fields shape passed to dmlegal_render_repeater_rows():
 *   [ [ 'key' => 'title', 'label' => 'Title', 'type' => 'text' ],
 *     [ 'key' => 'description', 'label' => 'Description', 'type' => 'textarea' ],
 *     [ 'key' => 'icon_id', 'label' => 'Icon', 'type' => 'media' ] ]
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render the add/remove-able row markup for one repeater field. Used both
 * for existing saved rows and as the <template> the JS clones for new rows.
 */
function dmlegal_render_repeater_row( string $name_base, array $fields, array $row, $row_index ): void {
	?>
	<div class="dmlegal-repeater__row" data-repeater-row>
		<?php foreach ( $fields as $field ) :
			$key       = $field['key'];
			$type      = $field['type'];
			$label     = $field['label'];
			$value     = $row[ $key ] ?? '';
			$field_name = sprintf( '%s[%s][%s]', $name_base, $row_index, $key );
			?>
			<div class="dmlegal-repeater__field">
				<label><?php echo esc_html( $label ); ?></label>
				<?php if ( $type === 'textarea' ) : ?>
					<textarea name="<?php echo esc_attr( $field_name ); ?>" rows="3"><?php echo esc_textarea( $value ); ?></textarea>
				<?php elseif ( $type === 'media' ) : ?>
					<div class="dmlegal-repeater__media">
						<input type="hidden" class="dmlegal-repeater__media-id" name="<?php echo esc_attr( $field_name ); ?>" value="<?php echo esc_attr( $value ); ?>">
						<div class="dmlegal-repeater__media-preview">
							<?php if ( $value ) : ?>
								<?php echo wp_get_attachment_image( (int) $value, [ 60, 60 ] ); ?>
							<?php endif; ?>
						</div>
						<button type="button" class="button dmlegal-repeater__media-select"><?php esc_html_e( 'Select Icon', 'dmlegal' ); ?></button>
						<button type="button" class="button dmlegal-repeater__media-clear"><?php esc_html_e( 'Clear', 'dmlegal' ); ?></button>
					</div>
				<?php else : ?>
					<input type="text" name="<?php echo esc_attr( $field_name ); ?>" value="<?php echo esc_attr( $value ); ?>">
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
		<button type="button" class="button-link dmlegal-repeater__remove"><?php esc_html_e( 'Remove', 'dmlegal' ); ?></button>
	</div>
	<?php
}

/**
 * Render a full repeater field: existing rows + add-row button + the
 * <template> markup the JS clones. $name_base is the meta box input
 * name prefix; saved rows come from get_post_meta( $post_id, $meta_key, true ).
 */
function dmlegal_render_repeater_field( string $name_base, array $fields, array $rows ): void {
	?>
	<div class="dmlegal-repeater" data-repeater data-repeater-name="<?php echo esc_attr( $name_base ); ?>">
		<div class="dmlegal-repeater__rows" data-repeater-rows>
			<?php foreach ( $rows as $index => $row ) :
				dmlegal_render_repeater_row( $name_base, $fields, is_array( $row ) ? $row : [], $index );
			endforeach; ?>
		</div>
		<template data-repeater-template>
			<?php dmlegal_render_repeater_row( $name_base, $fields, [], '__INDEX__' ); ?>
		</template>
		<button type="button" class="button dmlegal-repeater__add"><?php esc_html_e( 'Add Row', 'dmlegal' ); ?></button>
	</div>
	<?php
}

/**
 * Sanitize a submitted repeater field's $_POST value against its field
 * definitions. Unknown keys are dropped; every value is sanitized per its
 * declared type. Never trust the client-side JS to have kept rows well
 * formed.
 */
function dmlegal_sanitize_repeater_field( $posted, array $fields ): array {
	if ( ! is_array( $posted ) ) {
		return [];
	}

	$clean_rows  = [];
	$field_types = wp_list_pluck( $fields, 'type', 'key' );

	foreach ( $posted as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$clean_row  = [];
		$has_value  = false;

		foreach ( $field_types as $key => $type ) {
			$raw = $row[ $key ] ?? '';

			if ( $type === 'textarea' ) {
				$value = sanitize_textarea_field( wp_unslash( $raw ) );
			} elseif ( $type === 'media' ) {
				$value = absint( $raw );
			} else {
				$value = sanitize_text_field( wp_unslash( $raw ) );
			}

			if ( $value !== '' && $value !== 0 ) {
				$has_value = true;
			}

			$clean_row[ $key ] = $value;
		}

		if ( $has_value ) {
			$clean_rows[] = $clean_row;
		}
	}

	return $clean_rows;
}

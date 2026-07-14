<?php
/**
 * Accessible search form.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

$dm_legal_search_id = 'search-' . wp_unique_id();
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $dm_legal_search_id ); ?>" class="screen-reader-text">
		<?php esc_html_e( 'Search for:', 'dm-legal' ); ?>
	</label>
	<input
		type="search"
		id="<?php echo esc_attr( $dm_legal_search_id ); ?>"
		class="search-form__field"
		placeholder="<?php esc_attr_e( 'Search…', 'dm-legal' ); ?>"
		value="<?php echo esc_attr( get_search_query() ); ?>"
		name="s"
		autocomplete="off"
	/>
	<button type="submit" class="search-form__submit">
		<?php esc_html_e( 'Search', 'dm-legal' ); ?>
	</button>
</form>

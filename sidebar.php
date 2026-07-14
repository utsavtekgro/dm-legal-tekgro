<?php
/**
 * Primary sidebar.
 *
 * Only renders on layouts that opt in (no body class has-no-sidebar).
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( is_page() || is_front_page() || ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'dm-legal' ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>

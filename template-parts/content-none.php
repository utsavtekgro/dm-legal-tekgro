<?php
/**
 * "Nothing found" content part.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="no-results">
	<header class="page-header">
		<h1 class="page-header__title"><?php esc_html_e( 'Nothing found', 'dm-legal' ); ?></h1>
	</header>

	<div class="no-results__content">
		<?php if ( is_search() ) : ?>
			<p><?php esc_html_e( 'No results matched your search. Try different or fewer keywords.', 'dm-legal' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'It looks like nothing has been published here yet.', 'dm-legal' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>

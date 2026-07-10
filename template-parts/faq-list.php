<?php
/**
 * Reusable FAQ list, sourced from the single FAQs page's _faq_items meta
 * ($source_slug pattern — one fixed data source, reused across many
 * pages). Call with:
 *   get_template_part( 'template-parts/faq-list', null, [
 *     'heading'  => string,
 *     'category' => string, // optional — filters to one category; omit for all
 *     'limit'    => int,    // optional cap on number of items shown
 *   ] );
 * Does not use global $post — this is a fixed-source part, not a
 * current-page one.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$source_slug = 'faqs';
$faqs_page   = get_page_by_path( $source_slug );
if ( ! $faqs_page ) {
	return;
}

$items = get_post_meta( $faqs_page->ID, '_faq_items', true );
$items = is_array( $items ) ? $items : [];

$category = $args['category'] ?? '';
if ( $category !== '' ) {
	$items = array_values( array_filter( $items, static function ( $item ) use ( $category ) {
		return isset( $item['category'] ) && strcasecmp( $item['category'], $category ) === 0;
	} ) );
}

$limit = $args['limit'] ?? 0;
if ( $limit > 0 ) {
	$items = array_slice( $items, 0, $limit );
}

if ( ! $items ) {
	return;
}

$heading = $args['heading'] ?? __( 'Frequently Asked Questions', 'dmlegal' );
?>
<section class="content-width content-gapping">
	<h2 class="secondary-header text-center"><?php echo esc_html( $heading ); ?></h2>
	<div class="faq-list" data-faq-list>
		<?php foreach ( $items as $item ) : ?>
			<div class="faq-item">
				<div class="faq-item__head">
					<h3><?php echo esc_html( $item['question'] ); ?></h3>
					<span class="faq-item__icon" aria-hidden="true">
						<svg viewBox="0 0 448 512"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
					</span>
				</div>
				<div class="faq-item__panel"><p class="body-text"><?php echo esc_html( $item['answer'] ); ?></p></div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

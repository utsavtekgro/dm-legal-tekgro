<?php
/**
 * Breadcrumb trail. Call with:
 *   get_template_part( 'template-parts/breadcrumb', null, [ 'items' => [ [ 'label' => '...', 'url' => '...' ], ... ] ] );
 * The last item (or any item without a 'url') renders as plain text (current page).
 * Pass an empty items array to omit the breadcrumb entirely (matches the
 * legacy Breadcrumb.tsx returning null on the home page).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items = $args['items'] ?? [];
if ( empty( $items ) ) {
	return;
}
?>
<nav class="breadcrumb" aria-label="Breadcrumb">
	<ol>
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Home">&#8962;</a></li>
		<?php foreach ( $items as $i => $item ) :
			$is_last = $i === count( $items ) - 1;
			?>
			<li>
				<span aria-hidden="true">&rsaquo;</span>
				<?php if ( $is_last || empty( $item['url'] ) ) : ?>
					<span class="current"><?php echo esc_html( $item['label'] ); ?></span>
				<?php else : ?>
					<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ol>
</nav>

<?php
/**
 * Reusable hero section. Call with:
 *   get_template_part( 'template-parts/hero', null, [
 *     'title'         => string,
 *     'subtitle'      => string,               // omitted when 'minimal' is true
 *     'features'      => string[],              // omitted when 'minimal' is true
 *     'primary_btn'   => [ 'text' => '', 'url' => '' ],
 *     'secondary_btn' => [ 'text' => '', 'url' => '' ],
 *     'right_side'    => 'form' | 'image' | 'none',
 *     'image'         => attachment URL, when right_side === 'image',
 *     'breadcrumb'    => [ [ 'label' => '', 'url' => '' ], ... ],
 *     'minimal'       => bool, // title + breadcrumb only, no subtitle/features/buttons/aside
 *   ] );
 * Contact form rendering (right_side === 'form') is provided by
 * dmlegal_render_contact_form() from inc/cf7-integration.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title         = $args['title'] ?? '';
$subtitle      = $args['subtitle'] ?? '';
$features      = $args['features'] ?? [];
$primary_btn   = $args['primary_btn'] ?? null;
$secondary_btn = $args['secondary_btn'] ?? null;
$right_side    = $args['right_side'] ?? 'none';
$image         = $args['image'] ?? '';
$breadcrumb    = $args['breadcrumb'] ?? [];
$minimal       = $args['minimal'] ?? false;
?>
<div class="hero">
	<div class="content-width hero__inner<?php echo $right_side === 'image' ? ' hero__inner--image' : ''; ?>">
		<div class="hero__content">
			<?php get_template_part( 'template-parts/breadcrumb', null, [ 'items' => $breadcrumb ] ); ?>
			<h1 class="main-header"><?php echo esc_html( $title ); ?></h1>

			<?php if ( ! $minimal ) : ?>
				<?php if ( $subtitle ) : ?>
					<p class="body-text lg:text-lg"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>

				<?php if ( $features ) : ?>
					<ul class="hero__features">
						<?php foreach ( $features as $feature ) : ?>
							<li><img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/tick.svg' ); ?>" alt="" width="20" height="20"><?php echo esc_html( $feature ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<div class="hero__buttons">
					<?php if ( $secondary_btn ) : ?>
						<a class="btn btn-secondary" href="<?php echo esc_url( $secondary_btn['url'] ); ?>"><?php echo esc_html( $secondary_btn['text'] ); ?></a>
					<?php endif; ?>
					<?php if ( $primary_btn ) : ?>
						<a class="btn btn-primary" href="<?php echo esc_url( $primary_btn['url'] ); ?>"><?php echo esc_html( $primary_btn['text'] ); ?></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( ! $minimal && $right_side === 'form' ) : ?>
			<div class="hero__aside">
				<?php if ( function_exists( 'dmlegal_render_contact_form' ) ) {
					dmlegal_render_contact_form( 'hero' );
				} ?>
			</div>
		<?php elseif ( ! $minimal && $right_side === 'image' && $image ) : ?>
			<div class="hero__aside">
				<img src="<?php echo esc_url( $image ); ?>" alt="">
			</div>
		<?php endif; ?>
	</div>
</div>

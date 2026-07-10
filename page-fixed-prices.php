<?php
/**
 * Fixed Prices page — auto-selected for the Page with slug "fixed-prices".
 * Reads from global $post for its own meta boxes (Phase 2: _fp_intro_steps,
 * _fp_services).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

global $post;

get_template_part( 'template-parts/hero', null, [
	'title'       => __( 'Protect Your Financial Future at an Affordable, Transparent Cost with Our Fixed Fee', 'dmlegal' ),
	'subtitle'    => __( 'With a proven track record of dismissed charges and reduced penalties, we defend your rights.', 'dmlegal' ),
	'features'    => [ __( 'Fixed Fees for common legal services', 'dmlegal' ), __( 'Hourly Rates where appropriate', 'dmlegal' ), __( 'Manage Legal Costs Effectively', 'dmlegal' ), __( 'Transparent and upfront pricing', 'dmlegal' ) ],
	'primary_btn' => [ 'text' => __( 'Book free consultation', 'dmlegal' ), 'url' => dmlegal_get_page_url( 'book-a-lawyer' ) ],
	'secondary_btn' => [ 'text' => __( 'Explore more', 'dmlegal' ), 'url' => home_url( '/' ) ],
	'right_side'  => 'image',
	'image'       => DMLEGAL_URI . '/assets/images/fixed-fees-img.png',
	'breadcrumb'  => [ [ 'label' => __( 'Fixed Prices', 'dmlegal' ) ] ],
] );

$intro_steps = get_post_meta( $post->ID, '_fp_intro_steps', true );
$intro_steps = is_array( $intro_steps ) ? $intro_steps : [];

$services = get_post_meta( $post->ID, '_fp_services', true );
$services = is_array( $services ) ? $services : [];

// Group flat service rows into tabs by their practice_area_label.
$tabs = [];
foreach ( $services as $service ) {
	$tab_label = $service['practice_area_label'] !== '' ? $service['practice_area_label'] : __( 'General', 'dmlegal' );
	$tabs[ $tab_label ][] = $service;
}
?>

<?php if ( $intro_steps ) : ?>
	<section class="content-width content-gapping text-center">
		<h2 class="secondary-header"><?php esc_html_e( 'Why Choose Fixed Fees', 'dmlegal' ); ?></h2>
		<div class="steps-grid">
			<div class="steps-grid__list">
				<?php foreach ( $intro_steps as $step ) : ?>
					<div class="step-item">
						<div class="step-card">
							<?php if ( ! empty( $step['icon_id'] ) ) : ?>
								<div class="step-card__icon"><?php echo wp_get_attachment_image( (int) $step['icon_id'], [ 40, 40 ] ); ?></div>
							<?php endif; ?>
							<h3><?php echo esc_html( $step['title'] ); ?></h3>
							<p><?php echo esc_html( $step['description'] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/cta-book-consultation' ); ?>

<?php if ( $tabs ) : ?>
	<section class="content-width content-gapping">
		<div class="section-heading">
			<h2 class="secondary-header"><?php esc_html_e( 'Legal Fees by Practice Area', 'dmlegal' ); ?></h2>
		</div>

		<div class="tabs" data-tabs="fee-areas">
			<?php foreach ( array_keys( $tabs ) as $i => $label ) : ?>
				<button type="button" data-tab-btn="area-<?php echo esc_attr( sanitize_title( $label ) ); ?>" class="<?php echo $i === 0 ? 'is-active' : ''; ?>"><?php echo esc_html( $label ); ?></button>
			<?php endforeach; ?>
		</div>

		<?php $i = 0; foreach ( $tabs as $label => $tab_services ) : ?>
			<div data-tab-panel="area-<?php echo esc_attr( sanitize_title( $label ) ); ?>" data-tabs-target="fee-areas" class="<?php echo $i === 0 ? '' : 'hidden'; ?>">
				<div class="services-grid">
					<?php foreach ( $tab_services as $service ) :
						$tiers = array_filter( array_map( 'trim', explode( "\n", $service['tiers'] ?? '' ) ) );
						?>
						<div class="card-fee">
							<?php if ( ! empty( $service['icon_id'] ) ) : ?>
								<?php echo wp_get_attachment_image( (int) $service['icon_id'], 'medium' ); ?>
							<?php endif; ?>
							<h3><?php echo esc_html( $service['title'] ); ?></h3>
							<?php if ( $tiers ) : ?>
								<ul>
									<?php foreach ( $tiers as $tier ) :
										$parts = array_map( 'trim', explode( '|', $tier, 2 ) );
										$tier_label = $parts[0] ?? '';
										$tier_price = $parts[1] ?? '';
										?>
										<li>
											<img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/point-tick.svg' ); ?>" alt="">
											<span><?php echo esc_html( $tier_label ); ?><?php echo $tier_price ? ': ' . esc_html( $tier_price ) : ''; ?></span>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<?php $i++; endforeach; ?>

		<div class="hero__buttons btn-row--center-lg">
			<?php $phone_tel = dmlegal_get_setting( 'phone_tel' ); ?>
			<?php if ( $phone_tel ) : ?><a class="btn btn-secondary" href="tel:<?php echo esc_attr( $phone_tel ); ?>"><?php echo esc_html( dmlegal_get_setting( 'phone_display' ) ); ?></a><?php endif; ?>
			<a class="btn btn-primary" href="<?php echo esc_url( dmlegal_get_page_url( 'book-a-lawyer' ) ); ?>"><?php esc_html_e( 'Book a Consultation', 'dmlegal' ); ?></a>
		</div>
	</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/faq-list', null, [ 'heading' => __( 'How Do Lawyers Charge in Australia?', 'dmlegal' ), 'limit' => 6 ] ); ?>

<?php
$recent_posts = get_posts( [ 'post_type' => 'post', 'posts_per_page' => 3 ] );
if ( $recent_posts ) :
	?>
	<section class="content-width content-gapping">
		<h2 class="secondary-header text-center"><?php esc_html_e( 'Our Latest Blogs', 'dmlegal' ); ?></h2>
		<div class="blog-grid">
			<?php foreach ( $recent_posts as $post ) : setup_postdata( $post ); ?>
				<?php get_template_part( 'template-parts/blog-card' ); ?>
			<?php endforeach; wp_reset_postdata(); ?>
		</div>
	</section>
<?php endif; ?>

<?php get_footer(); ?>

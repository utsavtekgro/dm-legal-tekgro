<?php
/**
 * Practice Area single template. Reads from global $post — a current-page
 * template. Branches on hierarchy level: top-level areas (post_parent = 0)
 * get the full area layout; child posts (inner services, e.g. Drug
 * Offences under Criminal Law) get the inner-service layout.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

global $post;
$is_inner_service = (bool) $post->post_parent;
$parent           = $is_inner_service ? get_post( $post->post_parent ) : null;

if ( $is_inner_service && $parent ) :
	get_template_part( 'template-parts/hero', null, [
		'title'   => get_the_title() . ' — ' . get_the_title( $parent ),
		'minimal' => true,
		'breadcrumb' => [
			[ 'label' => __( 'Practice Areas', 'dmlegal' ), 'url' => get_post_type_archive_link( 'practice_area' ) ],
			[ 'label' => get_the_title( $parent ), 'url' => get_permalink( $parent ) ],
			[ 'label' => get_the_title() ],
		],
	] );

	$subtopics = get_post_meta( $post->ID, '_pa_subtopics', true );
	$subtopics = is_array( $subtopics ) ? $subtopics : [];
	?>
	<div class="content-width stack-grid">
		<div class="blog-detail-grid">
			<article>
				<?php if ( get_the_content() ) : ?>
					<div class="body-text"><?php the_content(); ?></div>
				<?php endif; ?>

				<?php if ( $subtopics ) : ?>
					<div class="dropdown-accordion" data-inner-dropdown>
						<?php foreach ( $subtopics as $i => $topic ) :
							$points = array_filter( array_map( 'trim', explode( "\n", $topic['points'] ?? '' ) ) );
							?>
							<div class="dropdown-accordion__item<?php echo $i === 0 ? ' is-open' : ''; ?>">
								<button type="button" class="dropdown-accordion__head" data-dropdown-head>
									<?php echo esc_html( $topic['title'] ); ?>
									<span aria-hidden="true">&#9662;</span>
								</button>
								<div class="dropdown-accordion__body">
									<div class="dropdown-accordion__body-inner">
										<?php if ( ! empty( $topic['description'] ) ) : ?><p><?php echo esc_html( $topic['description'] ); ?></p><?php endif; ?>
										<?php if ( $points ) : ?>
											<ul>
												<?php foreach ( $points as $point ) : ?>
													<li><img src="<?php echo esc_url( DMLEGAL_URI . '/assets/icons/tick.svg' ); ?>" alt="" width="20" height="20"><span><?php echo esc_html( $point ); ?></span></li>
												<?php endforeach; ?>
											</ul>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php get_template_part( 'template-parts/faq-list', null, [ 'heading' => __( 'Related FAQs', 'dmlegal' ), 'limit' => 6 ] ); ?>
			</article>

			<aside>
				<?php get_template_part( 'template-parts/sidebar-talk-to-expert' ); ?>
			</aside>
		</div>
	</div>
	<?php

else :
	$short_description = get_post_meta( $post->ID, '_pa_short_description', true );
	$actions           = get_post_meta( $post->ID, '_pa_actions', true );
	$actions           = is_array( $actions ) ? $actions : [];

	get_template_part( 'template-parts/hero', null, [
		'title'      => get_the_title(),
		'subtitle'   => $short_description,
		'right_side' => has_post_thumbnail() ? 'image' : 'none',
		'image'      => has_post_thumbnail() ? get_the_post_thumbnail_url( $post, 'large' ) : '',
		'breadcrumb' => [
			[ 'label' => __( 'Practice Areas', 'dmlegal' ), 'url' => get_post_type_archive_link( 'practice_area' ) ],
			[ 'label' => get_the_title() ],
		],
	] );
	?>

	<?php if ( get_the_content() ) : ?>
		<section class="content-width content-gapping body-text"><?php the_content(); ?></section>
	<?php endif; ?>

	<?php if ( $actions ) : ?>
		<section class="content-width content-gapping">
			<div class="faq-list faq-list--dark" data-faq-list>
				<?php foreach ( $actions as $action ) : ?>
					<div class="faq-item">
						<div class="faq-item__head">
							<h3><?php echo esc_html( $action['title'] ); ?></h3>
							<span class="faq-item__icon" aria-hidden="true">
								<svg viewBox="0 0 448 512"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
							</span>
						</div>
						<div class="faq-item__panel"><p class="body-text text-white"><?php echo esc_html( $action['description'] ); ?></p></div>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php
	// Reused from Home's "How We Help" content — one authored source, per convention.
	$source_slug = 'home';
	$home_page   = get_page_by_path( $source_slug );
	$home_services = $home_page ? get_post_meta( $home_page->ID, '_home_services', true ) : [];
	$home_services = is_array( $home_services ) ? $home_services : [];
	if ( $home_services ) :
		?>
		<section class="help-clients content-gapping">
			<div class="content-width help-clients__inner">
				<div>
					<h2><?php esc_html_e( 'How We Help Our Clients', 'dmlegal' ); ?></h2>
					<a class="btn btn-primary" href="<?php echo esc_url( dmlegal_get_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Start Free Legal Check', 'dmlegal' ); ?></a>
				</div>
				<div class="help-clients__cards">
					<?php foreach ( $home_services as $service ) : ?>
						<div class="card-help">
							<?php if ( ! empty( $service['icon_id'] ) ) : ?>
								<div class="card-help__icon"><?php echo wp_get_attachment_image( (int) $service['icon_id'], [ 32, 32 ] ); ?></div>
							<?php endif; ?>
							<div><h3><?php echo esc_html( $service['title'] ); ?></h3><p><?php echo esc_html( $service['description'] ); ?></p></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php
	$children = get_posts( [
		'post_type'      => 'practice_area',
		'post_parent'    => $post->ID,
		'posts_per_page' => -1,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
	] );
	if ( $children ) :
		?>
		<section class="content-width content-gapping">
			<div class="section-heading">
				<h2 class="secondary-header"><?php echo esc_html( sprintf( __( 'Explore %s Services', 'dmlegal' ), get_the_title() ) ); ?></h2>
			</div>
			<div class="services-grid">
				<?php foreach ( $children as $child ) : ?>
					<div class="card-law">
						<div class="card-law__media">
							<a href="<?php echo esc_url( get_permalink( $child ) ); ?>">
								<?php if ( has_post_thumbnail( $child ) ) : ?>
									<?php echo get_the_post_thumbnail( $child, 'practice-area-card', array_merge( [ 'loading' => 'lazy', 'decoding' => 'async' ], dmlegal_thumbnail_alt_args( get_the_title( $child ) ) ) ); ?>
								<?php endif; ?>
							</a>
						</div>
						<div class="card-law__body">
							<div>
								<h3><?php echo esc_html( get_the_title( $child ) ); ?></h3>
								<?php $child_desc = get_post_meta( $child->ID, '_pa_short_description', true ); ?>
								<?php if ( $child_desc ) : ?><p><?php echo esc_html( wp_trim_words( $child_desc, 16 ) ); ?></p><?php endif; ?>
							</div>
							<a class="card-law__link" href="<?php echo esc_url( get_permalink( $child ) ); ?>"><?php esc_html_e( 'Read more', 'dmlegal' ); ?> &rsaquo;</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/cta-book-consultation' ); ?>
	<?php get_template_part( 'template-parts/faq-list', null, [ 'limit' => 6 ] ); ?>

<?php endif; ?>

<?php get_footer(); ?>

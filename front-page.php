<?php
/**
 * Home page. Reads from global $post (the Page assigned as the site's
 * front page in Settings > Reading) — a current-page template, not a
 * fixed-source one.
 *
 * front-page.php always wins for the site root in WordPress's template
 * hierarchy, even when Settings > Reading is still set to "your latest
 * posts" (no static front page assigned yet) — is_home() is true in that
 * case, so fall back to the generic index.php loop rather than assuming
 * global $post is the intended Home page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_home() ) {
	require __DIR__ . '/index.php';
	return;
}

global $post;

get_header();

$hero_heading  = get_post_meta( $post->ID, '_home_hero_heading', true );
$hero_subtext  = get_post_meta( $post->ID, '_home_hero_subtext', true );
$hero_features = get_post_meta( $post->ID, '_home_hero_features', true );
$hero_features = is_array( $hero_features ) ? wp_list_pluck( $hero_features, 'feature' ) : [];

get_template_part( 'template-parts/hero', null, [
	'title'      => $hero_heading ?: get_bloginfo( 'name' ),
	'subtitle'   => $hero_subtext,
	'features'   => array_filter( $hero_features ),
	'right_side' => 'form',
	'breadcrumb' => [],
] );

$stats        = get_post_meta( $post->ID, '_home_stats', true );
$services     = get_post_meta( $post->ID, '_home_services', true );
$affiliations = get_post_meta( $post->ID, '_home_affiliations', true );
$video_title  = get_post_meta( $post->ID, '_home_video_title', true );
$video_desc   = get_post_meta( $post->ID, '_home_video_description', true );
$video_url    = get_post_meta( $post->ID, '_home_video_url', true );
$video_btn_text = get_post_meta( $post->ID, '_home_video_button_text', true );
$video_btn_link = get_post_meta( $post->ID, '_home_video_button_link', true );

$stats        = is_array( $stats ) ? $stats : [];
$services     = is_array( $services ) ? $services : [];
$affiliations = is_array( $affiliations ) ? $affiliations : [];

$practice_areas = get_posts( [
	'post_type'      => 'practice_area',
	'post_parent'    => 0,
	'posts_per_page' => 6,
	'orderby'        => 'menu_order title',
	'order'          => 'ASC',
] );

$attorneys = get_posts( [
	'post_type'      => 'attorney',
	'posts_per_page' => 4,
	'orderby'        => 'menu_order date',
	'order'          => 'ASC',
] );

$recent_posts = get_posts( [
	'post_type'      => 'post',
	'posts_per_page' => 3,
] );
?>

<?php if ( $stats ) : ?>
	<section class="content-width content-gapping stats-grid">
		<?php foreach ( $stats as $stat ) : ?>
			<div class="stat">
				<p class="stat__value"><?php echo esc_html( $stat['value'] ); ?></p>
				<p class="stat__label"><?php echo esc_html( $stat['label'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</section>
<?php endif; ?>

<?php if ( $practice_areas ) : ?>
	<section class="content-width content-gapping">
		<div class="section-heading">
			<h2 class="secondary-header"><?php esc_html_e( 'Our Practice Areas', 'dmlegal' ); ?></h2>
		</div>
		<div class="services-grid">
			<?php foreach ( $practice_areas as $post ) : setup_postdata( $post ); ?>
				<?php get_template_part( 'template-parts/practice-area-card' ); ?>
			<?php endforeach; wp_reset_postdata(); ?>
		</div>
	</section>
<?php endif; ?>

<?php if ( $services ) : ?>
	<section class="content-width content-gapping">
		<div class="section-heading">
			<h2 class="secondary-header"><?php esc_html_e( 'How We Help Our Clients', 'dmlegal' ); ?></h2>
		</div>
		<div class="help-clients__cards">
			<?php foreach ( $services as $service ) : ?>
				<div class="card-help">
					<?php if ( ! empty( $service['icon_id'] ) ) : ?>
						<div class="card-help__icon"><?php echo wp_get_attachment_image( (int) $service['icon_id'], [ 32, 32 ] ); ?></div>
					<?php endif; ?>
					<div>
						<h3><?php echo esc_html( $service['title'] ); ?></h3>
						<p><?php echo esc_html( $service['description'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
<?php endif; ?>

<?php if ( $video_title || $video_url ) : ?>
	<section class="content-width content-gapping video-section">
		<div class="video-section__media">
			<video controls>
				<?php if ( $video_url ) : ?><source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4"><?php endif; ?>
				<?php esc_html_e( 'Your browser does not support the video tag.', 'dmlegal' ); ?>
			</video>
		</div>
		<div class="video-section__content">
			<?php if ( $video_title ) : ?><h2><?php echo esc_html( $video_title ); ?></h2><?php endif; ?>
			<?php if ( $video_desc ) : ?><p><?php echo esc_html( $video_desc ); ?></p><?php endif; ?>
			<?php if ( $video_btn_text && $video_btn_link ) : ?>
				<a class="btn btn-primary" href="<?php echo esc_url( $video_btn_link ); ?>"><?php echo esc_html( $video_btn_text ); ?></a>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>

<?php if ( $attorneys ) : ?>
	<section class="content-width content-gapping">
		<div class="section-heading">
			<h2 class="secondary-header"><?php esc_html_e( 'Meet the Experts Who Fought and Won', 'dmlegal' ); ?></h2>
		</div>
		<div class="experts-grid">
			<?php foreach ( $attorneys as $post ) : setup_postdata( $post ); ?>
				<?php get_template_part( 'template-parts/attorney-card' ); ?>
			<?php endforeach; wp_reset_postdata(); ?>
		</div>
	</section>
<?php endif; ?>

<?php if ( $affiliations ) : ?>
	<section class="content-width content-gapping affiliations-row">
		<?php foreach ( $affiliations as $affiliation ) : ?>
			<?php if ( ! empty( $affiliation['logo_id'] ) ) : ?>
				<?php echo wp_get_attachment_image( (int) $affiliation['logo_id'], 'medium' ); ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</section>
<?php endif; ?>

<?php if ( $recent_posts ) : ?>
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

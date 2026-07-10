<?php
/**
 * Case Study single template. Reads from global $post.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

global $post;

get_template_part( 'template-parts/hero', null, [
	'title'      => get_the_title(),
	'minimal'    => true,
	'breadcrumb' => [
		[ 'label' => __( 'Case Studies', 'dmlegal' ), 'url' => get_post_type_archive_link( 'case_study' ) ],
		[ 'label' => get_the_title() ],
	],
] );

$client    = get_post_meta( $post->ID, '_cs_client', true );
$industry  = get_post_meta( $post->ID, '_cs_industry', true );
$featuring = get_post_meta( $post->ID, '_cs_featuring', true );
$stats     = get_post_meta( $post->ID, '_cs_stats', true );
$sections  = get_post_meta( $post->ID, '_cs_sections', true );
$stats     = is_array( $stats ) ? $stats : [];
$sections  = is_array( $sections ) ? $sections : [];

$highlights = array_filter( [
	[ 'label' => __( 'Client', 'dmlegal' ), 'value' => $client ],
	[ 'label' => __( 'Industry', 'dmlegal' ), 'value' => $industry ],
	[ 'label' => __( 'Featuring', 'dmlegal' ), 'value' => $featuring ],
], static fn( $h ) => $h['value'] !== '' );
?>

<div class="content-width stack-grid">
	<div class="blog-detail-grid">
		<article>
			<?php if ( get_the_content() ) : ?>
				<div class="body-text"><?php the_content(); ?></div>
			<?php endif; ?>

			<?php if ( $highlights ) : ?>
				<div class="highlight-grid">
					<?php foreach ( $highlights as $h ) : ?>
						<div class="highlight-card">
							<h3><?php echo esc_html( $h['label'] ); ?></h3>
							<p><?php echo esc_html( $h['value'] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php foreach ( $sections as $i => $section ) : ?>
				<section class="blog-article__section">
					<?php if ( ! empty( $section['heading'] ) ) : ?><h2 class="secondary-header"><?php echo esc_html( $section['heading'] ); ?></h2><?php endif; ?>
					<?php if ( ! empty( $section['body'] ) ) : ?><p class="body-text"><?php echo esc_html( $section['body'] ); ?></p><?php endif; ?>
					<?php if ( $i === 0 && $stats ) : ?>
						<div class="case-stats-grid">
							<?php foreach ( $stats as $stat ) : ?>
								<div class="stat">
									<p><?php echo esc_html( $stat['value'] ); ?></p>
									<p><?php echo esc_html( $stat['description'] ); ?></p>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</section>
			<?php endforeach; ?>

			<?php get_template_part( 'template-parts/faq-list', null, [ 'heading' => __( 'Related FAQs', 'dmlegal' ), 'limit' => 6 ] ); ?>
		</article>

		<aside>
			<?php get_template_part( 'template-parts/sidebar-talk-to-expert' ); ?>
		</aside>
	</div>
</div>

<?php get_footer(); ?>

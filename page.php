<?php
/**
 * Generic Page fallback — used for Privacy Policy, Terms & Conditions,
 * Disclaimer, and any other plain Page without a dedicated page-{slug}.php.
 * These simply become normal WP Pages edited in the block editor; no
 * custom "legal page" data structure or markdown-lite parser is needed
 * once the content lives in wp-admin.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/hero', null, [
		'title'      => get_the_title(),
		'minimal'    => true,
		'breadcrumb' => [ [ 'label' => get_the_title() ] ],
	] );
	?>
	<div class="content-width content-gapping legal-section offset-top-lg">
		<?php the_content(); ?>
	</div>
	<?php
endwhile;

get_footer();

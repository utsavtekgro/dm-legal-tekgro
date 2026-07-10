<?php
/**
 * 404 page. WordPress already sends the correct 404 HTTP status for
 * unmatched routes based on the query — no manual http_response_code()
 * call needed here.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="not-found content-width content-gapping text-center">
	<h1 class="main-header">404</h1>
	<p class="body-text"><?php esc_html_e( 'Page not found', 'dmlegal' ); ?></p>
	<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Go Home', 'dmlegal' ); ?></a>
</div>

<?php get_footer(); ?>

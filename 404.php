<?php
/**
 * 404 template — ported from the legacy static 404.php.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="not-found">
  <h1>404</h1>
  <p>Page not found</p>
  <a href="<?= url( 'index.php' ) ?>">Go Home</a>
</div>

<?php get_footer(); ?>

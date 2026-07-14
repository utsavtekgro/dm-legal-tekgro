<?php
/** 404 page — converted from src/app/not-found.tsx */
require_once 'includes/functions.php';
http_response_code(404);

$pageTitle = 'Page Not Found | DM Legal';
$pageDescription = 'The page you are looking for could not be found.';
include 'header.php';
?>

<div class="not-found">
  <h1>404</h1>
  <p>Page not found</p>
  <a href="<?= url('index.php') ?>">Go Home</a>
</div>

<?php include 'footer.php'; ?>

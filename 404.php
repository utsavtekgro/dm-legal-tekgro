<?php
/** 404 page — converted from src/app/not-found.tsx */
require_once __DIR__ . '/includes/config.php';
http_response_code(404);

$pageTitle = 'Page Not Found | DM Legal';
$pageDescription = 'The page you are looking for could not be found.';
include __DIR__ . '/includes/head.php';
?>

<div class="not-found">
  <h1>404</h1>
  <p>Page not found</p>
  <a href="<?= url('index.php') ?>">Go Home</a>
</div>

<?php include __DIR__ . '/includes/foot.php'; ?>


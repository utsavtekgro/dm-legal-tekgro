<?php
/**
 * Common <head> + opening <body> + site header.
 * Expects $pageTitle and $pageDescription to be set by the calling page.
 */
$pageTitle = $pageTitle ?? SITE_NAME;
$pageDescription = $pageDescription ?? SITE_TAGLINE;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle) ?></title>
  <meta name="description" content="<?= e($pageDescription) ?>">
  <link rel="icon" href="<?= url('assets/favicon.ico') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head>
<body>
<a href="#main-content" class="skip-link">Skip to main content</a>
<?php include __DIR__ . '/header.php'; ?>
<main id="main-content">

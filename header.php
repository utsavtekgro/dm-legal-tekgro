<?php
/**
 * Common <head> + opening <body> + site header: top bar, logo, nav, mobile menu, search overlay.
 * Expects $pageTitle and $pageDescription to be set by the calling page.
 * Converted from src/components/layout/Header.tsx
 */
require_once __DIR__ . '/includes/functions.php';
$pageTitle = $pageTitle ?? SITE_NAME;
$pageDescription = $pageDescription ?? SITE_TAGLINE;
$currentPage = basename($_SERVER['SCRIPT_NAME']);
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head>
<body>
<a href="#main-content" class="skip-link">Skip to main content</a>
<header class="site-header">
  <div class="site-header__inner">

    <!-- Top bar (desktop only) -->
    <div class="header-topbar">
      <div class="content-width">
        <div class="header-topbar__links">
          <a href="<?= e(SITE_WHATSAPP) ?>" target="_blank" rel="noopener noreferrer">
            <img src="<?= url('assets/icons/whatsapp.svg') ?>" alt="" width="20" height="20"><?= e(SITE_PHONE_DISPLAY) ?>
          </a>
          <a href="mailto:<?= e(SITE_EMAIL) ?>">
            <img src="<?= url('assets/icons/email.svg') ?>" alt="" width="20" height="20"><?= e(SITE_EMAIL) ?>
          </a>
          <a href="<?= e(SITE_MAPS_URL) ?>" target="_blank" rel="noopener noreferrer">
            <img src="<?= url('assets/icons/map.svg') ?>" alt="" width="15" height="15"><?= e(SITE_ADDRESS_SHORT) ?>
          </a>
        </div>
      
      </div>
    </div>

    <!-- Main bar -->
    <div class="header-mainbar">
      <div class="content-width">
        <a href="<?= url('index.php') ?>" class="logo" aria-label="DM Legal home">
          <img src="<?= url('assets/images/logo.svg') ?>" alt="DM Legal logo" width="110" height="110">
        </a>

        <nav class="header-nav" aria-label="Primary">
          <?php foreach ($navLinks as $link): ?>
            <a href="<?= url($link['href']) ?>"><?= e($link['label']) ?></a>
          <?php endforeach; ?>
        </nav>

        <div class="header-actions">
          <a class="btn btn-secondary" href="tel:<?= e(SITE_PHONE_TEL) ?>"><?= e(SITE_PHONE_DISPLAY) ?></a>
          <a class="btn btn-primary" href="<?= url('book-your-lawyer.php') ?>">Book a Consultation</a>
        </div>

        <div class="header-mobile-toggle">
          <button type="button" data-menu-close hidden aria-label="Close menu" class="btn-toogle">&#10005;</button>
          <button type="button" data-menu-open aria-label="Open menu" class="btn-toogle">&#9776;</button>
        </div>
      </div>
    </div>

    <!-- Bottom bar (desktop only) -->
    <div class="header-bottombar">
      <div class="content-width">
        <?php foreach ($lawLinks as $link): ?>
          <a href="<?= url($link['href']) ?>"><?= e($link['label']) ?></a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Mobile slide-down menu -->
    <div class="header-mobile-panel">
      <div class="header-mobile-panel__list" data-mobile-panel>
        <nav aria-label="Mobile primary">
          <?php foreach ($navLinks as $link): ?>
            <a href="<?= url($link['href']) ?>"><?= e($link['label']) ?></a>
          <?php endforeach; ?>
        </nav>
        <div class="header-mobile-panel__laws">
          <?php foreach ($lawLinks as $link): ?>
            <a href="<?= url($link['href']) ?>"><?= e($link['label']) ?></a>
          <?php endforeach; ?>
        </div>
        <div class="header-mobile-panel__buttons content-width">
        <a class="btn btn-secondary btn-full" href="tel:<?= e(SITE_PHONE_TEL) ?>"><?= e(SITE_PHONE_DISPLAY) ?></a>
        <a class="btn btn-primary btn-full" href="<?= url('book-your-lawyer.php') ?>">Book a Consultation</a>
      </div>
      </div>
    </div>
      

    <!-- Search overlay -->
    <div class="search-overlay" data-search-overlay>
      <div class="content-width search-overlay__head">
      
        <button type="button" data-search-close aria-label="Close search">&#10005;</button>
      </div>
      <div class="content-width search-overlay__body">
        <div class="search-overlay__results" data-search-results></div>
      </div>
    </div>

  </div>
</header>
<main id="main-content">

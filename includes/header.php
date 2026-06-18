<?php
/**
 * Site header: top bar, logo, nav, mobile menu, search overlay.
 * Converted from src/components/layout/Header.tsx
 */
$currentPage = basename($_SERVER['SCRIPT_NAME']);
?>
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

<?php
/**
 * Site footer + mobile bottom nav + "under development" modal + closing scripts.
 * Converted from Footer.tsx, MobileBottomNav.tsx, UnderDevelopmentModal.tsx, LayoutClient.tsx
 */
    include '/footer.php';
?>

 <div class="full-map-card">
    <iframe class="full-map-card__iframe" src="<?= e($officeInfo['mapEmbedUrl']) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen title="DM Legal Services location map"></iframe>
    <a class="full-map-card__open" href="<?= e(SITE_MAPS_URL) ?>" target="_blank" rel="noopener noreferrer">
      Open in Maps <span aria-hidden="true">&#8599;</span>
    </a>
    <div class="full-map-card__panel">
      <h3><?= e($officeInfo['name']) ?></h3>
      <div class="full-map-card__grid">
        <div class="full-map-card__item">
          <img src="<?= url('assets/icons/pin-dark.svg') ?>" alt="" width="16" height="20">
          <span><?= e($officeInfo['address']) ?></span>
        </div>
        <div class="full-map-card__item">
          <img src="<?= url('assets/icons/email-dark.svg') ?>" alt="" width="17" height="13">
          <a href="mailto:<?= e($officeInfo['email']) ?>"><?= e($officeInfo['email']) ?></a>
        </div>
        <?php foreach ($officeInfo['phoneNumbers'] as $phone): ?>
          <div class="full-map-card__item">
            <img src="<?= url('assets/icons/phone.svg') ?>" alt="" width="18" height="18">
            <a href="tel:<?= e(preg_replace('/\s+/', '', $phone)) ?>" class="phone-link"><?= e($phone) ?></a>
          </div>
        <?php endforeach; ?>
        <?php
          preg_match('/^(.*?)\s*\((.*)\)$/', $officeInfo['hours'], $hoursParts);
          $hoursMain = $hoursParts[1] ?? $officeInfo['hours'];
          $hoursNote = $hoursParts[2] ?? '';
        ?>
        <div class="full-map-card__item">
          <img src="<?= url('assets/icons/clock.svg') ?>" alt="" width="18" height="18">
          <span><?= e($hoursMain) ?> <?php if ($hoursNote): ?><span class="text-danger">(<?= e($hoursNote) ?>)</span><?php endif; ?></span>
        </div>
      </div>
      <div class="full-map-card__buttons">
        <a class="btn btn-secondary" href="<?= e(SITE_MAPS_URL) ?>" target="_blank" rel="noopener noreferrer">Get Directions</a>
        <a class="btn btn-primary" href="<?= url('book-your-lawyer.php') ?>">Book a Consultation <img src="<?= url('assets/icons/chevron-right.svg') ?>" alt="" width="14" height="14"></a>
      </div>
    </div>
  </div>
<footer class="site-footer px-5">
  <div class="content-width footer-main">
    <div class="footer-top mt-5">
      <div class="footer-top__brand">
        <img src="<?= url('assets/images/logo.svg') ?>" alt="DM Legal logo" width="130" height="40">
        <p class="body-text">Empowering your journey through DM Legal.</p>
<p class="body-text fw-bold">
    DM LEGAL AUSTRALIA | ABN 32 626 700 981
</p>      </div>
      <div class="footer-top__badges">
        <img src="<?= url('assets/icons/img8.png') ?>" alt="" width="80" height="80">
        <img src="<?= url('assets/icons/img9.svg') ?>" alt="" width="130" height="80">
      </div>
    </div>

    <div class="footer-divider footer-social-row">
      <div class="footer-social">
        <a href="https://www.facebook.com/DMlegalservicesAU" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><img src="<?= url('assets/icons/customfb.svg') ?>" alt="" width="25" height="25"></a>
        <a href="https://www.instagram.com/DMlegalservicesAU" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><img src="<?= url('assets/icons/custominsta.svg') ?>" alt="" width="25" height="25"></a>
        <a href="https://www.linkedin.com/company/dmlegalservicesau" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><img src="<?= url('assets/icons/customlinkedin.svg') ?>" alt="" width="25" height="25"></a>
        <a href="https://www.tiktok.com/@dmlegalservicesau" target="_blank" rel="noopener noreferrer" aria-label="TikTok"><img src="<?= url('assets/icons/customtiktok.svg') ?>" alt="" width="25" height="25"></a>
      </div>
      <div class="footer-legal-links">
        <span>All Rights Reserved</span>
        <span>|</span>
        <?php foreach ($usefulLinks as $i => $link): ?>
          <a href="<?= url($link['href']) ?>"><?= e($link['label']) ?></a>
          <?php if ($i < count($usefulLinks) - 1): ?><span>|</span><?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <div class="content-width footer-acknowledgement">
    <img src="<?= url('assets/icons/footerImg.svg') ?>" alt="Aboriginal flag">
    <p>DM Legal acknowledges the Traditional Custodians and their Elders, past and present, and their enduring culture.</p>
  </div>

  <div class="footer-bottom">
    <div class="content-width">
      <p>&copy; Copyright <?= date('Y') ?> DM Legal Australia | All Rights Reserved</p>
      <div class="footer-bottom__agency">
        Digital Marketing Agency:
        <img src="<?= url('assets/images/tekgro-logo.png') ?>" alt="Tekgro logo">
      </div>
    </div>
  </div>
</footer>

<nav class="mobile-bottom-nav" aria-label="Quick contact">
  <div class="mobile-bottom-nav__inner">
    <a href="<?= e(SITE_WHATSAPP) ?>" target="_blank" rel="noopener noreferrer">
      <img src="<?= url('assets/icons/whatsapp.svg') ?>" alt=""><span>WhatsApp</span>
    </a>
    <a href="mailto:<?= e(SITE_EMAIL) ?>">
      <img src="<?= url('assets/icons/email.svg') ?>" alt=""><span>Email</span>
    </a>
    <a href="<?= e(SITE_MAPS_URL) ?>" target="_blank" rel="noopener noreferrer">
      <img src="<?= url('assets/icons/direction.svg') ?>" alt=""><span>Directions</span>
    </a>
  </div>
</nav>

<div class="modal-overlay" data-dev-modal hidden role="dialog" aria-modal="true" aria-labelledby="dev-modal-heading">
  <div class="modal-box">
    <button type="button" class="modal-box__close" data-modal-close aria-label="Close">&#10005;</button>
    <h2 id="dev-modal-heading" class="secondary-header">Website Under Development</h2>
    <p class="body-text">Our website is currently undergoing improvements to serve you better. We appreciate your patience and look forward to welcoming you soon.</p>
    <div class="thanks">
      <span>Thank You</span>
      <span>Development Team</span>
    </div>
  </div>
</div>

<script id="blogs-data" type="application/json"><?= json_encode(array_map(function ($b) {
    return [
        'slug' => slugify($b['title']),
        'title' => $b['title'],
        'category' => $b['category'],
        'tags' => $b['tags'],
        'excerpt' => $b['excerpt'],
        'image' => $b['image'],
        'author' => $b['author'],
    ];
}, $blogs), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP) ?></script>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
<script src="<?= url('assets/js/app.js') ?>" defer></script>
<?php foreach ($pageScripts ?? [] as $script): ?>
  <script src="<?= url($script) ?>" defer></script>
<?php endforeach; ?>
</main>
</body>
</html>

<?php
/** Contact page — converted from src/app/contact/page.tsx */
require_once __DIR__ . '/includes/config.php';

$pageTitle = 'Contact Us | DM Legal';
$pageDescription = 'Get in touch with DM Legal Services for clear, trusted, and professional legal guidance.';
include __DIR__ . '/includes/head.php';

$heroTitle = 'Get in Touch Today for Clear, Trusted, and Professional Legal Guidance';
$heroSubtitle = 'With a proven track record of dismissed charges and reduced penalties, we defend your rights.';
$heroFeatures = ['Fixed Fees', 'Hourly rates', 'Manage Legal Costs', 'No Win, No Fees'];
$heroPrimaryBtn = ['text' => 'Book free consultation', 'href' => 'book-your-lawyer.php'];
$heroSecondaryBtn = ['text' => 'Explore more', 'href' => 'index.php'];
$heroRightSide = 'form';
$heroBreadcrumb = [['label' => 'Contact']];
include __DIR__ . '/includes/hero.php';

$socialLinks = [
    ['label' => 'Facebook', 'href' => 'https://www.facebook.com/DMlegalservicesAU'],
    ['label' => 'LinkedIn', 'href' => 'https://www.linkedin.com/company/dmlegalservicesau'],
    ['label' => 'Instagram', 'href' => 'https://www.instagram.com/DMlegalservicesAU'],
    ['label' => 'TikTok', 'href' => 'https://www.tiktok.com/@dmlegalservicesau'],
    ['label' => 'WhatsApp', 'href' => SITE_WHATSAPP],
    ['label' => 'Email', 'href' => 'mailto:' . SITE_EMAIL],
];

$reviews = [
    ['name' => 'Khilendra Raj Timalsina', 'avatar' => '/assets/images/user.png', 'rating' => 5, 'time' => '2 weeks ago', 'text' => 'The team at DM Legal Services were professional, responsive, and made a stressful process feel manageable from start to finish.'],
    ['name' => 'John Doe', 'avatar' => '/assets/images/user.png', 'rating' => 5, 'time' => '1 month ago', 'text' => 'Clear communication and genuine care for my case. I would recommend DM Legal Services to anyone needing legal advice.'],
    ['name' => 'John Doe', 'avatar' => '/assets/images/user.png', 'rating' => 5, 'time' => '1 month ago', 'text' => 'Excellent outcome and great value for the fixed fee we agreed on upfront. No surprises along the way.'],
];
?>

<!-- ============ SIDEBAR + OFFICE MAP ============ -->
<section class="content-width content-gapping contact-grid">
  <div class="sidebar-card">
    <h2 class="secondary-header">Talk to an Expert</h2>
    <div class="sidebar-card__experts">
      <?php foreach (['expert1', 'expert2', 'expert3', 'expert4', 'expert5', 'expert6'] as $expert): ?>
        <img src="<?= url('assets/images/' . $expert . '.png') ?>" alt="">
      <?php endforeach; ?>
    </div>
    <div class="sidebar-card__buttons">
      <a class="btn btn-primary btn-full" href="<?= url('book-your-lawyer.php') ?>">Book Now</a>
      <a class="btn btn-secondary btn-full" href="tel:<?= e(SITE_PHONE_TEL) ?>"><?= e(SITE_PHONE_DISPLAY) ?></a>
    </div>
    <div class="sidebar-card__rating">
      <img src="<?= url('assets/icons/google.svg') ?>" alt="Google">
      <p style="font-weight:600;font-size:1.125rem;">5.0</p>
      <p style="font-size:0.75rem;color:#6b7280;">(Based on 125 Reviews)</p>
      <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
    </div>
    <div class="carousel">
      <div class="carousel__track">
        <?php foreach ($reviews as $review): ?>
          <div class="review-card" style="width:100%;">
            <div class="review-card__head">
              <img src="<?= url($review['avatar']) ?>" alt="">
              <div>
                <p style="font-weight:600;"><?= e($review['name']) ?></p>
                <p style="font-size:0.85rem;color:#6b7280;"><?= str_repeat('★', $review['rating']) ?> <span><?= e($review['time']) ?></span></p>
              </div>
            </div>
            <p class="review-text"><?= e($review['text']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="carousel__dots"></div>
    </div>
  </div>

  <div class="office-info-card">
    <div class="office-info-card__panel">
      <h3><?= e($officeInfo['name']) ?></h3>
      <address>
        <span><?= e($officeInfo['address']) ?></span>
        <?php foreach ($officeInfo['phoneNumbers'] as $phone): ?>
          <a href="tel:<?= e(preg_replace('/\s+/', '', $phone)) ?>" style="color:#dc2626;font-weight:500;"><?= e($phone) ?></a>
        <?php endforeach; ?>
        <a href="mailto:<?= e($officeInfo['email']) ?>"><?= e($officeInfo['email']) ?></a>
        <span><?= e($officeInfo['hours']) ?></span>
      </address>
      <a class="btn btn-primary btn-full" href="<?= e(SITE_MAPS_URL) ?>" target="_blank" rel="noopener noreferrer">Get Directions</a>
    </div>
    <iframe class="office-info-card__map" src="<?= e($officeInfo['mapEmbedUrl']) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen title="DM Legal Services office location"></iframe>
  </div>
</section>

<!-- ============ SOCIAL ============ -->
<section class="content-width page-section">
  <div class="section-heading">
    <h2 class="secondary-header">Which One Delivers the Best Value for You?</h2>
    <p class="body-text">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.</p>
  </div>
  <div class="social-icons-row">
    <?php foreach ($socialLinks as $social): ?>
      <a href="<?= e($social['href']) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= e($social['label']) ?>"><?= e(mb_substr($social['label'], 0, 1)) ?></a>
    <?php endforeach; ?>
  </div>
</section>

<?php include __DIR__ . '/includes/foot.php'; ?>

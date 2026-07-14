<?php
/** Contact page — converted from src/app/contact/page.tsx */
require_once 'includes/functions.php';

$pageTitle = 'Contact Us | DM Legal';
$pageDescription = 'Get in touch with DM Legal Services for clear, trusted, and professional legal guidance.';
include 'header.php';

$heroTitle = 'Get in Touch Today for Clear, Trusted, and Professional Legal Guidance';
$heroSubtitle = 'With a proven track record of dismissed charges and reduced penalties, we defend your rights.';
$heroFeatures = ['Fixed Fees', 'Hourly rates', 'Manage Legal Costs', 'No Win, No Fees'];
$heroPrimaryBtn = ['text' => 'Book free consultation', 'href' => 'book-your-lawyer.php'];
$heroSecondaryBtn = ['text' => 'Explore more', 'href' => 'index.php'];
$heroRightSide = 'form';
$heroBreadcrumb = [['label' => 'Contact']];
include 'includes/hero.php';


$reviews = [
    ['name' => 'Khilendra Raj Timalsina', 'avatar' => '/assets/images/user.png', 'rating' => 5, 'time' => '2 weeks ago', 'text' => 'The team at DM Legal Services were professional, responsive, and made a stressful process feel manageable from start to finish.'],
    ['name' => 'John Doe', 'avatar' => '/assets/images/user.png', 'rating' => 5, 'time' => '1 month ago', 'text' => 'Clear communication and genuine care for my case. I would recommend DM Legal Services to anyone needing legal advice.'],
    ['name' => 'John Doe', 'avatar' => '/assets/images/user.png', 'rating' => 5, 'time' => '1 month ago', 'text' => 'Excellent outcome and great value for the fixed fee we agreed on upfront. No surprises along the way.'],
];
?>

<!-- ============ SIDEBAR + OFFICE MAP ============ -->
<section class="content-width content-gapping contact-grid">
  <div>
    <div class="social-icons-row">
      <a href="https://www.facebook.com/DMlegalservicesAU" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><img src="<?= url('assets/icons/facebook.svg') ?>" alt="" width="18" height="18"></a>
      <a href="https://www.linkedin.com/company/dmlegalservicesau" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><img src="<?= url('assets/icons/linkedin.svg') ?>" alt="" width="18" height="18"></a>
      <a href="https://www.instagram.com/DMlegalservicesAU" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><img src="<?= url('assets/icons/custominsta.svg') ?>" alt="" width="18" height="18"></a>
      <a href="<?= e(SITE_WHATSAPP) ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp" class="icon-whatsapp"><img src="<?= url('assets/icons/whatsapp.svg') ?>" alt="" width="18" height="18"></a>
      <a href="mailto:<?= e(SITE_EMAIL) ?>" aria-label="Email" class="icon-email"><img src="<?= url('assets/icons/email.svg') ?>" alt="" width="18" height="18"></a>
    </div>
    <div class="sidebar-card">
    <h2 class="secondary-header">Talk to an Expert</h2>
    <div class="sidebar-card__experts">
      <?php foreach (['expert1', 'expert2', 'expert3', 'expert4', 'expert5', 'expert6'] as $expert): ?>
        <img src="<?= url('assets/images/' . $expert . '.png') ?>" alt="" loading="lazy" decoding="async">
      <?php endforeach; ?>
    </div>
    <div class="sidebar-card__buttons">
      <a class="btn btn-primary btn-full" href="<?= url('book-your-lawyer.php') ?>">Book Now</a>
      <a class="btn btn-secondary btn-full" href="tel:<?= e(SITE_PHONE_TEL) ?>"><?= e(SITE_PHONE_DISPLAY) ?></a>
    </div>
  
    </div>
  </div>

  <div class="office-info-card">
    <div class="office-info-card__panel">
      <h3><?= e($officeInfo['name']) ?></h3>
      <address>
        <span><?= e($officeInfo['address']) ?></span>
        <?php foreach ($officeInfo['phoneNumbers'] as $phone): ?>
          <a href="tel:<?= e(preg_replace('/\s+/', '', $phone)) ?>" class="phone-link"><?= e($phone) ?></a>
        <?php endforeach; ?>
        <a href="mailto:<?= e($officeInfo['email']) ?>"><?= e($officeInfo['email']) ?></a>
        <span><?= e($officeInfo['hours']) ?></span>
      </address>
      <a class="btn btn-primary btn-full" href="<?= e(SITE_MAPS_URL) ?>" target="_blank" rel="noopener noreferrer">Get Directions</a>
    </div>
    <iframe class="office-info-card__map" src="<?= e($officeInfo['mapEmbedUrl']) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen title="DM Legal Services office location"></iframe>
  </div>
</section>

<!-- ============ VALUE HEADING ============ -->
<section class="content-width page-section">
  <div class="section-heading">
    <h2 class="secondary-header">Which One Delivers the Best Value for You?</h2>
    <p class="body-text">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.</p>
  </div>

  <!-- ============ FULL-WIDTH MAP ============ -->
</section>

<?php include 'footer.php'; ?>

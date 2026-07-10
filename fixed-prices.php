<?php
/** Fixed Prices page — converted from src/app/fixed-prices/page.tsx + LegalFeesSection.tsx */
require_once 'includes/functions.php';

$pageTitle = 'Fixed Prices | DM Legal';
$pageDescription = 'Transparent, fixed-fee legal pricing by practice area at DM Legal Services.';
include 'header.php';

$heroTitle = 'Protect Your Financial Future at an Affordable, Transparent Cost with Our Fixed Fee';
$heroSubtitle = 'With a proven track record of dismissed charges and reduced penalties, we defend your rights.';
$heroFeatures = ['Fixed Fees for common legal services', 'Hourly Rates where appropriate', 'Manage Legal Costs Effectively', 'Transparent and upfront pricing'];
$heroPrimaryBtn = ['text' => 'Book free consultation', 'href' => 'book-your-lawyer.php'];
$heroSecondaryBtn = ['text' => 'Explore more', 'href' => 'index.php'];
$heroRightSide = 'image';
$heroImage = '/assets/images/fixed-fees-img.png';
$heroBreadcrumb = [['label' => 'Fixed Prices']];

include 'includes/hero.php';
?>

<!-- ============ WHY FIXED FEES ============ -->
<section class="content-width content-gapping text-center">
  <div data-aos="fade-up">
    <h2 class="secondary-header">Why Choose Fixed Fees</h2>
    <p class="body-text section-lead">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.</p>
  </div>
  <div class="steps-grid">
    <div class="steps-grid__list">
      <?php foreach ($fixedFeesStep as $i => $step): ?>
        <div class="step-item" data-aos="zoom-out-right" data-aos-delay="<?= $i * 150 ?>">
          <div class="step-card">
            <div class="step-card__icon"><img src="<?= url($step['image']) ?>" alt="" width="40" height="40"></div>
            <h3><?= e($step['title']) ?></h3>
            <p><?= e($step['description']) ?></p>
          </div>
          <?php if ($i < count($fixedFeesStep) - 1): ?>
            <div class="step-arrow-down"><img src="<?= url('assets/icons/arrow-down.svg') ?>" alt="" width="30" height="30"></div>
            <div class="step-arrow-right"><img src="<?= url('assets/icons/arrow.svg') ?>" alt="" width="80" height="60"></div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ ATTRACTION CONTACT ============ -->
<section class="attraction-contact" data-aos="fade-up">
  <div class="content-width attraction-contact__row">
    <h2 class="main-header attraction-contact__title">Limited slots available &mdash; Book your consultation now</h2>
    <div class="attraction-contact__intro">
      <p class="measure-sm">You can choose any format of consultation with our lawyer:</p>
      <div class="attraction-contact__options">
        <?php foreach ($options as $option): ?>
          <div class="attraction-contact__option">
            <img src="<?= url($option['icon']) ?>" alt="">
            <p><?= e($option['label']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
      <a class="btn btn-primary" href="<?= url('book-your-lawyer.php') ?>">Book a Consultation</a>
    </div>
  </div>
</section>

<!-- ============ LEGAL FEES BY PRACTICE AREA ============ -->
<section class="content-width content-gapping">
  <div class="section-heading">
    <h2 class="secondary-header"><?= e($legalFeesData['title']) ?></h2>
    <p class="body-text"><?= e($legalFeesData['subtitle']) ?></p>
  </div>

  <div class="tabs" data-tabs="fee-areas">
    <?php foreach ($legalFeesData['practiceAreas'] as $i => $area): ?>
      <button type="button" data-tab-btn="area-<?= e($area['id']) ?>" class="<?= $i === 0 ? 'is-active' : '' ?>"><?= e($area['name']) ?></button>
    <?php endforeach; ?>
  </div>

  <?php foreach ($legalFeesData['practiceAreas'] as $i => $area): ?>
    <div data-tab-panel="area-<?= e($area['id']) ?>" data-tabs-target="fee-areas" class="<?= $i === 0 ? '' : 'hidden' ?>">
      <?php if ($area['services']): ?>
        <div class="services-grid">
          <?php foreach ($area['services'] as $j => $svc): ?>
            <div class="card-fee" data-aos="fade-up" data-aos-delay="<?= $j * 100 ?>">
              <img src="<?= url($svc['image']) ?>" alt="<?= e($svc['title']) ?>" loading="lazy" decoding="async">
              <h3><?= e($svc['title']) ?></h3>
              <ul>
                <?php foreach ($svc['fees'] as $fee): ?>
                  <li><img src="<?= url('assets/icons/point-tick.svg') ?>" alt=""><span><?= e($fee['location']) ?>: <?= e($fee['cost']) ?></span></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="no-results">No services available for this practice area.</p>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>

  <div class="hero__buttons btn-row--center-lg">
    <a class="btn btn-secondary" href="tel:<?= e(SITE_PHONE_TEL) ?>"><?= e(SITE_PHONE_DISPLAY) ?></a>
    <a class="btn btn-primary" href="<?= url('book-your-lawyer.php') ?>">Book a Consultation</a>
  </div>
</section>

<!-- ============ FAQ ============ -->
<section class="content-width content-gapping">
  <h2 class="secondary-header text-center">How Do Lawyers Charge in Australia?</h2>
  <p class="body-text text-center section-lead--tight">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal.</p>
  <div class="faq-list" data-faq-list>
    <?php foreach ($consultationCostFAQ as $faq): ?>
      <div class="faq-item">
        <div class="faq-item__head">
          <h3><?= e($faq['question']) ?></h3>
          <span class="faq-item__icon" aria-hidden="true"><svg viewBox="0 0 448 512"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg></span>
        </div>
        <div class="faq-item__panel"><p class="body-text"><?= e($faq['answer']) ?></p></div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="faq-cta">
    <div class="faq-cta__avatars">
      <img src="<?= url('assets/images/avatar1.png') ?>" alt="">
      <img src="<?= url('assets/images/avatar2.png') ?>" alt="">
      <img src="<?= url('assets/images/avatar3.png') ?>" alt="">
    </div>
    <h3>Direct Connect With Us</h3>
    <p>Can&rsquo;t find the answer you&rsquo;re looking for? Please chat to our friendly team.</p>
    <a class="btn btn-primary" href="<?= url('contact.php') ?>">Contact Us</a>
  </div>
</section>

<!-- ============ LATEST BLOGS ============ -->
<section class="content-width content-gapping">
  <h2 class="secondary-header text-center">Our Latest Blogs</h2>
  <p class="body-text text-center section-lead--tight">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal.</p>
  <div class="blog-grid">
    <?php foreach (array_slice($blogs, 0, 3) as $blog): $slug = slugify($blog['title']); ?>
      <div class="card-blog">
        <div class="card-blog__media">
          <a href="<?= url('blog-detail.php?slug=' . $slug) ?>"><img src="<?= url($blog['image']) ?>" alt="<?= e($blog['title']) ?>" loading="lazy" decoding="async"></a>
        </div>
        <div class="card-blog__meta">
          <div class="card-blog__author">
            <img src="<?= url($blog['author']['avatar']) ?>" alt="">
            <div>
              <p><?= e($blog['author']['name']) ?></p>
              <p><?= e($blog['author']['date']) ?></p>
            </div>
          </div>
          <div class="card-blog__tags">
            <?php foreach ($blog['tags'] as $tag): ?><span><?= e($tag) ?></span><?php endforeach; ?>
          </div>
        </div>
        <h3><?= e($blog['title']) ?></h3>
        <p class="excerpt"><?= e(truncate_words($blog['excerpt'], 20)) ?></p>
        <div class="card-blog__link"><a href="<?= url('blog-detail.php?slug=' . $slug) ?>">More Info &rsaquo;</a></div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php include 'footer.php' ?>

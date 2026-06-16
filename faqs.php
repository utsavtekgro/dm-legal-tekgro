<?php
/** FAQs page — converted from src/app/faqs/page.tsx */
require_once __DIR__ . '/includes/config.php';

$pageTitle = 'Frequently Asked Questions | DM Legal';
$pageDescription = 'Answers to common questions about consultations, legal services, fees, and case handling at DM Legal Services.';
include __DIR__ . '/includes/head.php';

$heroTitle = 'Trusted Legal Solutions – Protecting Your Rights, Securing Your Future';
$heroSubtitle = 'Expert legal guidance in family law, business disputes, immigration, and more – tailored to your needs.';
$heroFeatures = ['Expert Legal Guidance', 'Tailored Legal Solutions', 'Free Initial Consultation', 'Fast & Efficient Process'];
$heroPrimaryBtn = ['text' => 'How to contact us?', 'href' => 'contact.php'];
$heroSecondaryBtn = ['text' => 'Leave Enquiry', 'href' => 'index.php'];
$heroRightSide = 'image';
$heroImage = '/assets/images/faqHeroImg.png';
$heroBreadcrumb = [['label' => 'FAQs']];
include __DIR__ . '/includes/hero.php';
?>

<!-- ============ FAQ CATEGORIES ============ -->
<section class="content-width content-gapping">
  <div class="section-heading">
    <h2 class="secondary-header">Frequently Asked Questions</h2>
    <p class="body-text">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.</p>
  </div>

  <div class="tabs" data-tabs="faq-categories">
    <?php foreach ($faqCategories as $i => $cat): ?>
      <button type="button" data-tab-btn="cat-<?= $i ?>" class="<?= $i === 0 ? 'is-active' : '' ?>"><?= e($cat['title']) ?></button>
    <?php endforeach; ?>
  </div>

  <?php foreach ($faqCategories as $i => $cat): ?>
    <div data-tab-panel="cat-<?= $i ?>" data-tabs-target="faq-categories" class="<?= $i === 0 ? '' : 'hidden' ?>">
      <div class="faq-list" data-faq-list>
        <?php foreach ($cat['faqs'] as $faq): ?>
          <div class="faq-item">
            <div class="faq-item__head">
              <h3><?= e($faq['question']) ?></h3>
              <span class="faq-item__icon" aria-hidden="true">+</span>
            </div>
            <div class="faq-item__panel"><p class="body-text"><?= e($faq['answer']) ?></p></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>

  <div class="form-card" style="max-width:32rem;margin:2rem auto 0;">
    <h3 class="sub-heading text-center" style="margin-bottom:1rem;">Still Have Any Question?</h3>
    <form data-ajax-form action="<?= url('api/contact.php') ?>" novalidate>
      <?= csrf_field() ?>
      <input type="text" class="honeypot" name="website" tabindex="-1" autocomplete="off">
      <input class="form-control" type="text" name="name" placeholder="Full Name" aria-label="Full Name" required>
      <div class="form-row">
        <input class="form-control" type="email" name="email" placeholder="Enter Your Email" aria-label="Email address" required>
        <input class="form-control" type="tel" name="phone" placeholder="Mobile Number" aria-label="Mobile number" required pattern="^[0-9+()\-\s]{6,20}$">
      </div>
      <input class="form-control" type="text" name="subject" placeholder="Enter Your Subject" aria-label="Subject" required>
      <textarea class="form-control" name="message" placeholder="Any Extra Message (optional)" aria-label="Additional message (optional)" rows="3"></textarea>
      <p class="form-success" data-form-message hidden></p>
      <button type="submit" class="btn btn-primary btn-full">Send Your Message</button>
    </form>
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

<!-- ============ HOW WE WORK ============ -->
<section class="content-width content-gapping text-center">
  <div data-aos="fade-up">
    <h2 class="secondary-header">Process and Proceedings in Sydney&rsquo;s Criminal Law Courts</h2>
    <p class="body-text" style="max-width:48rem;margin:0 auto 3rem;">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.</p>
  </div>
  <div class="steps-grid">
    <div class="steps-grid__list">
      <?php foreach ($steps as $i => $step): ?>
        <div class="step-item" data-aos="zoom-out-right" data-aos-delay="<?= $i * 150 ?>">
          <div class="step-card">
            <div class="step-card__icon"><img src="<?= url($step['image']) ?>" alt="" width="40" height="40"></div>
            <h3><?= e($step['title']) ?></h3>
            <p><?= e($step['description']) ?></p>
          </div>
          <?php if ($i < count($steps) - 1): ?>
            <div class="step-arrow-down"><img src="<?= url('assets/icons/arrow-down.svg') ?>" alt="" width="30" height="30"></div>
            <div class="step-arrow-right"><img src="<?= url('assets/icons/arrow.svg') ?>" alt="" width="60" height="60"></div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/foot.php'; ?>

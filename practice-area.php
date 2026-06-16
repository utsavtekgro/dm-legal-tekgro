<?php
/**
 * Practice Area pages — converted from:
 *   src/app/practice-area/page.tsx          (no ?slug)
 *   src/app/practice-area/[slug]/page.tsx   (?slug=...)
 */
require_once __DIR__ . '/includes/config.php';

$slug = isset($_GET['slug']) ? clean_input($_GET['slug']) : '';
$service = $slug !== '' ? find_practice_area_by_slug($slug) : null;

// ===================================================================
// DETAIL VIEW — a specific practice area was requested
// ===================================================================
if ($slug !== '' && $service) {
    $pageTitle = e($service['title']) . ' | DM Legal Practice Areas';
    $pageDescription = mb_substr($service['description'], 0, 160);
    include __DIR__ . '/includes/head.php';

    $heroTitle = 'Explore, Learn, and Grow – Your Journey Starts Here';
    $heroSubtitle = 'With a proven track record of dismissed charges and reduced penalties, we defend your rights.';
    $heroFeatures = ['Fixed Fees', 'Hourly rates', 'Manage Legal Costs', 'No Win, No Fees'];
    $heroSecondaryBtn = ['text' => 'Explore more', 'href' => 'index.php'];
    $heroRightSide = 'image';
    $heroImage = '/assets/images/case-studies-bgimg.png';
    $heroBreadcrumb = [['label' => 'Practice Area', 'href' => 'practice-area.php'], ['label' => $service['title']]];
    include __DIR__ . '/includes/hero.php';
    ?>

    <!-- ============ INNER SERVICES ============ -->
    <section class="content-width content-gapping">
      <div class="section-heading">
        <h2 class="secondary-header">Explore <?= e($service['title']) ?> Services</h2>
      </div>
      <div class="services-grid">
        <?php $innerServicesForArea = array_slice($practiceAreaInnerServices, 0, $service['innerServiceCount']); ?>
        <?php foreach ($innerServicesForArea as $idx => $inner): $innerSlug = slugify($inner['title']); ?>
          <div class="card-law">
            <div class="card-law__media">
              <a href="<?= url('practice-area-inner.php?slug=' . $slug . '&inner=' . $innerSlug) ?>">
                <img src="<?= url($inner['image']) ?>" alt="<?= e($inner['title']) ?>">
              </a>
            </div>
            <div class="card-law__body">
              <div>
                <h3><?= e($inner['title']) ?></h3>
                <p><?= e(truncate_words($inner['description'], 16)) ?></p>
              </div>
              <a class="card-law__link" href="<?= url('practice-area-inner.php?slug=' . $slug . '&inner=' . $innerSlug) ?>">Read more &rsaquo;</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- ============ HOW WE WORK ============ -->
    <section class="content-width content-gapping text-center">
      <div data-aos="fade-up">
        <h2 class="secondary-header">Process for <?= e($service['title']) ?></h2>
        <p class="body-text" style="max-width:48rem;margin:0 auto 3rem;">Our team of experienced lawyers is dedicated to providing comprehensive assistance and support.</p>
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

    <!-- ============ HELP CLIENTS ============ -->
    <section class="help-clients content-gapping" style="background-image:url('<?= url($helpClientsData['backgroundImage']) ?>')">
      <div class="content-width help-clients__inner">
        <div data-aos="fade-up">
          <h2><?= e($helpClientsData['title']) ?></h2>
          <p><?= e($helpClientsData['description']) ?></p>
          <a class="btn btn-primary" href="<?= url('contact.php') ?>">Start Free Legal Check</a>
        </div>
        <div class="help-clients__cards">
          <?php foreach ($helpClientsData['services'] as $i => $hc): ?>
            <div class="card-help" data-aos="fade-up" data-aos-delay="<?= $i * 200 ?>">
              <div class="card-help__icon"><img src="<?= url($hc['icon']) ?>" alt="" width="32" height="32"></div>
              <div><h3><?= e($hc['title']) ?></h3><p><?= e($hc['description']) ?></p></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- ============ ACTIONS ============ -->
    <section class="content-width content-gapping">
      <div class="actions-grid">
        <div data-aos="fade-up">
          <h2><?= e($actionsData['title']) ?></h2>
          <p class="body-text" style="margin-bottom:1.5rem;"><?= e($actionsData['description']) ?></p>
          <div class="faq-list faq-list--dark" data-faq-list>
            <?php foreach ($actionsData['actions'] as $action): ?>
              <div class="faq-item">
                <div class="faq-item__head">
                  <h3><?= e($action['question']) ?></h3>
                  <span class="faq-item__icon" aria-hidden="true">+</span>
                </div>
                <div class="faq-item__panel"><p class="body-text" style="color:#fff;"><?= e($action['answer']) ?></p></div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="actions-images">
          <?php foreach ($actionsData['images'] as $i => $img): ?>
            <img src="<?= url($img) ?>" alt="Action <?= $i + 1 ?>" data-aos="fade-up" data-aos-delay="<?= $i * 150 ?>">
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- ============ ATTRACTION CONTACT ============ -->
    <section class="attraction-contact" data-aos="fade-up">
      <div class="content-width attraction-contact__row">
        <h2 class="main-header attraction-contact__title">Limited slots available &mdash; Book your consultation now</h2>
        <div class="attraction-contact__intro">
          <p style="max-width:18rem;">You can choose any format of consultation with our lawyer:</p>
          <div class="attraction-contact__options">
            <?php foreach ($options as $option): ?>
              <div class="attraction-contact__option">
                <img src="<?= url($option['icon']) ?>" alt="">
                <p><?= e($option['label']) ?></p>
              </div>
            <?php endforeach; ?>
          </div>
          <a class="btn btn-primary" href="<?= url('contact.php') ?>">Book a Consultation</a>
        </div>
      </div>
    </section>

    <!-- ============ VIDEO ============ -->
    <section class="content-width content-gapping video-section">
      <div class="video-section__media" data-aos="fade-right">
        <video controls poster="<?= url('assets/images/services.png') ?>">
          <?php if (!empty($videoSectionData['videoUrl'])): ?><source src="<?= url($videoSectionData['videoUrl']) ?>" type="video/mp4"><?php endif; ?>
          Your browser does not support the video tag.
        </video>
      </div>
      <div class="video-section__content" data-aos="fade-left">
        <h2><?= e($videoSectionData['title']) ?></h2>
        <p><?= e($videoSectionData['description']) ?></p>
        <a class="btn btn-primary" href="<?= url($videoSectionData['buttonLink']) ?>"><?= e($videoSectionData['buttonText']) ?></a>
      </div>
    </section>

    <!-- ============ NEWS ============ -->
    <section class="content-width content-gapping">
      <div class="section-heading" data-aos="fade-up">
        <h2 class="secondary-header">How We Handle Your Problem</h2>
        <p class="body-text">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support.</p>
      </div>
      <div class="carousel carousel--full" data-autoplay="5000">
        <div class="carousel__track">
          <?php foreach ($newsData as $item): ?>
            <div class="card-news" style="background-image:url('<?= url($item['image']) ?>')">
              <div class="card-news__body">
                <div class="card-news__meta">
                  <span class="card-news__tag"><?= e($item['category']) ?></span>
                  <time class="card-news__date"><?= e($item['date']) ?></time>
                </div>
                <h3><?= e($item['title']) ?></h3>
                <p><?= e(truncate_words($item['preview'], 55)) ?></p>
                <a class="btn btn-primary" href="<?= url($item['link']) ?>">Read More about this article</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="carousel__dots"></div>
      </div>
    </section>

    <!-- ============ EXPERTS ============ -->
    <section class="content-width content-gapping">
      <div data-aos="fade-up">
        <h2 class="secondary-header text-center"><?= e($expertsSection['heading']) ?></h2>
        <p class="body-text text-center" style="max-width:48rem;margin:0 auto;"><?= e($expertsSection['subheading']) ?></p>
      </div>
      <div class="experts-grid">
        <?php foreach ($expertsSection['experts'] as $i => $expert): ?>
          <div class="card-expert" data-aos="fade-up" data-aos-delay="<?= 150 + $i * 100 ?>">
            <div class="card-expert__media">
              <img src="<?= url($expert['image']) ?>" alt="<?= e($expert['name']) ?>">
              <div class="overlay">
                <h3><?= e($expert['name']) ?></h3>
                <div><img src="<?= url('assets/icons/golden-tick.svg') ?>" alt="" width="18" height="18"><?= e($expert['role']) ?></div>
              </div>
            </div>
            <div class="card-expert__body">
              <p class="card-expert__stat"><img src="<?= url('assets/icons/success.svg') ?>" alt="" width="20" height="20"><?= e($expert['stat']) ?></p>
              <p class="desc"><?= e($expert['description']) ?></p>
              <a class="btn btn-secondary" href="<?= e($expert['ctaLink']) ?>"><?= e($expert['ctaText']) ?></a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="text-center mt-4">
        <a class="btn btn-primary" href="<?= url('book-your-lawyer.php') ?>">Get Your Defense Strategy</a>
      </div>
    </section>

    <!-- ============ FAQ ============ -->
    <section class="content-width content-gapping">
      <h2 class="secondary-header text-center">Frequently Asked Questions</h2>
      <p class="body-text text-center" style="max-width:48rem;margin:0 auto 2.5rem;">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support.</p>
      <div class="faq-list" data-faq-list>
        <?php foreach ($consultationCostFAQ as $faq): ?>
          <div class="faq-item">
            <div class="faq-item__head">
              <h3><?= e($faq['question']) ?></h3>
              <span class="faq-item__icon" aria-hidden="true">+</span>
            </div>
            <div class="faq-item__panel"><p class="body-text"><?= e($faq['answer']) ?></p></div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <?php
    include __DIR__ . '/includes/foot.php';
    exit;
}

if ($slug !== '' && !$service) {
    http_response_code(404);
}

// ===================================================================
// LANDING VIEW — /practice-area.php with no slug (or an unknown slug)
// ===================================================================
$pageTitle = 'Practice Areas | DM Legal';
$pageDescription = 'Browse all legal practice areas covered by DM Legal Services, from business law to immigration law.';
include __DIR__ . '/includes/head.php';

$heroTitle = 'Protect Your Financial Future at an Affordable, Transparent Cost with Our Fixed Fees';
$heroSubtitle = 'With a proven track record of dismissed charges and reduced penalties, we defend your rights.';
$heroFeatures = ['Fixed Fees', 'Hourly rates', 'Manage Legal Costs', 'No Win, No Fees'];
$heroPrimaryBtn = ['text' => 'Book free consultation', 'href' => 'book-your-lawyer.php'];
$heroSecondaryBtn = ['text' => 'Explore more', 'href' => 'index.php'];
$heroRightSide = 'image';
$heroImage = '/assets/images/practicearea-img.png';
$heroBreadcrumb = [['label' => 'Practice Area']];
include __DIR__ . '/includes/hero.php';
?>

<section class="content-width content-gapping">
  <div class="section-heading">
    <h2 class="secondary-header">Our Practice Areas</h2>
    <p class="body-text">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.</p>
  </div>
  <div class="services-grid">
    <?php foreach ($legalServicesData as $idx => $service): $svcSlug = slugify($service['title']); ?>
      <div class="card-law" data-aos="fade-up" data-aos-delay="<?= $idx * 100 ?>">
        <div class="card-law__media">
          <a href="<?= url('practice-area.php?slug=' . $svcSlug) ?>">
            <img src="<?= url($service['image']) ?>" alt="<?= e($service['title']) ?>">
          </a>
        </div>
        <div class="card-law__body">
          <div>
            <h3><?= e($service['title']) ?></h3>
            <p><?= e(truncate_words($service['description'], 12)) ?></p>
          </div>
          <a class="card-law__link" href="<?= url('practice-area.php?slug=' . $svcSlug) ?>">Read more &rsaquo;</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php include __DIR__ . '/includes/foot.php'; ?>

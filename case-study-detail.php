<?php
/** Case study detail — converted from src/app/case-studies/[slug]/page.tsx */
require_once __DIR__ . '/includes/config.php';

$slug = isset($_GET['slug']) ? clean_input($_GET['slug']) : '';
$cs = $slug !== '' ? find_case_study_by_slug($slug) : null;

if (!$cs) {
    http_response_code(404);
    $pageTitle = 'Case Study Not Found | DM Legal';
    include __DIR__ . '/includes/head.php';
    echo '<div class="content-width page-section text-center"><h1 class="main-header">Case study not found</h1><a class="btn btn-primary mt-4" href="' . url('case-studies.php') . '">Back to Case Studies</a></div>';
    include __DIR__ . '/includes/foot.php';
    exit;
}

$pageTitle = e($cs['title']) . ' | DM Legal Case Studies';
$pageDescription = mb_substr($cs['excerpt'], 0, 160);
include __DIR__ . '/includes/head.php';

$heroTitle = $cs['title'];
$heroMinimal = true;
$heroBreadcrumb = [['label' => 'Case Studies', 'href' => 'case-studies.php'], ['label' => $cs['title']]];
include __DIR__ . '/includes/hero.php';
?>

<div class="content-width" style="display:grid;grid-template-columns:1fr;gap:2.5rem;">
  <div class="blog-detail-grid">
    <article>
      <p class="body-text"><?= e($cs['description']) ?></p>

      <div class="highlight-grid">
        <?php foreach ($cs['highlights'] as $h): ?>
          <div class="highlight-card">
            <div class="highlight-card__icon"><img src="<?= url($h['image']) ?>" alt="" width="28" height="28"></div>
            <h3><?= e($h['label']) ?></h3>
            <p><?= e($h['value']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>

      <?php foreach ($cs['sections'] as $i => $section): ?>
        <section class="blog-article__section">
          <h2 class="secondary-header"><?= e($section['heading']) ?></h2>
          <p class="body-text"><?= e($section['body']) ?></p>
          <?php if ($i === 0 && !empty($cs['stats'])): ?>
            <div class="case-stats-grid">
              <?php foreach ($cs['stats'] as $stat): ?>
                <div class="stat">
                  <p><?= e($stat['value']) ?></p>
                  <p><?= e($stat['description']) ?></p>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </section>
      <?php endforeach; ?>

      <div data-faq-list>
        <h2 class="secondary-header">Related FAQs</h2>
        <div class="faq-list">
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
      </div>
    </article>

    <aside>
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
      </div>
    </aside>
  </div>
</div>

<?php include __DIR__ . '/includes/foot.php'; ?>

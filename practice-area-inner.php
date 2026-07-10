<?php
/** Practice area inner service — converted from src/app/practice-area/[slug]/[innerSlug]/page.tsx */
require_once 'includes/functions.php';

$slug = isset($_GET['slug']) ? clean_input($_GET['slug']) : '';
$innerSlug = isset($_GET['inner']) ? clean_input($_GET['inner']) : '';
$service = $slug !== '' ? find_practice_area_by_slug($slug) : null;

$innerService = null;
if ($service) {
    $innerServicesForArea = array_slice($practiceAreaInnerServices, 0, $service['innerServiceCount']);
    foreach ($innerServicesForArea as $inner) {
        if (slugify($inner['title']) === $innerSlug) {
            $innerService = $inner;
            break;
        }
    }
}

if (!$service || !$innerService) {
    http_response_code(404);
    $pageTitle = 'Service Not Found | DM Legal';
    include 'header.php';
    echo '<div class="content-width page-section text-center"><h1 class="main-header">Service not found</h1><a class="btn btn-primary mt-4" href="' . url('practice-area.php') . '">Back to Practice Areas</a></div>';
    include 'footer.php';
    exit;
}

$pageTitle = e($innerService['title']) . ' | ' . e($service['title']) . ' | DM Legal';
$pageDescription = mb_substr($innerService['description'], 0, 160);
include 'header.php';

$heroTitle = $innerService['title'] . ' — ' . $service['title'];
$heroMinimal = true;
$heroBreadcrumb = [
    ['label' => 'Practice Area', 'href' => 'practice-area.php'],
    ['label' => $service['title'], 'href' => 'practice-area.php?slug=' . $slug],
    ['label' => $innerService['title']],
];
include 'includes/hero.php';
?>

<div class="content-width stack-grid">
  <div class="blog-detail-grid">
    <article>
      <div class="dropdown-tabs" data-inner-dropdown>
        <?php foreach ($innerDropdownData as $i => $section): ?>
          <button type="button" data-dropdown-tab="<?= e($section['id']) ?>" class="<?= $i === 0 ? 'is-active' : '' ?>"><?= e($section['title']) ?></button>
        <?php endforeach; ?>
      </div>

      <div class="dropdown-accordion" data-inner-dropdown>
        <?php foreach ($innerDropdownData as $i => $section): ?>
          <div class="dropdown-accordion__item<?= $i === 0 ? ' is-open' : '' ?>" data-dropdown-item="<?= e($section['id']) ?>">
            <button type="button" class="dropdown-accordion__head" data-dropdown-head>
              <?= e($section['title']) ?>
              <span aria-hidden="true">&#9662;</span>
            </button>
            <div class="dropdown-accordion__body">
              <div class="dropdown-accordion__body-inner">
                <p><?= e($section['description']) ?></p>
                <ul>
                  <?php foreach ($section['points'] as $point): ?>
                    <li><img src="<?= url('assets/icons/tick.svg') ?>" alt="" width="20" height="20"><span><?= e($point) ?></span></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div data-faq-list class="content-gapping pt-0">
        <h2 class="secondary-header">Drug FAQs</h2>
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
            <img src="<?= url('assets/images/' . $expert . '.png') ?>" alt="" loading="lazy" decoding="async">
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

<?php
$pageScripts = ['assets/js/inner-dropdown.js'];
include 'footer.php';

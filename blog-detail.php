<?php
/** Blog detail page — converted from src/app/blogs/[slug]/page.tsx + BlogContent.tsx */
require_once 'includes/functions.php';

$slug = isset($_GET['slug']) ? clean_input($_GET['slug']) : '';
$blog = $slug !== '' ? find_blog_by_slug($slug) : null;

if (!$blog) {
    http_response_code(404);
    $pageTitle = 'Blog Not Found | DM Legal';
    include 'header.php';
    echo '<div class="content-width page-section text-center"><h1 class="main-header">Blog post not found</h1><p class="body-text">The article you are looking for may have been moved or removed.</p><a class="btn btn-primary mt-4" href="' . url('blogs.php') . '">Back to Blog</a></div>';
    include 'footer.php';
    exit;
}

$pageTitle = e($blog['title']) . ' | DM Legal';
$pageDescription = mb_substr($blog['excerpt'], 0, 160);
include 'header.php';

$heroTitle = 'Protect Your Financial Future with Transparent Legal Fees';
$heroSubtitle = 'Our experienced lawyers provide clear and predictable pricing, helping you manage your legal matters with confidence.';
$heroFeatures = ['Fixed Fees for common legal services', 'Hourly Rates where appropriate
', 'Manage Legal Costs Effectively', 'Transparent and upfront pricing'];
$heroPrimaryBtn = ['text' => 'Book free consultation', 'href' => 'book-your-lawyer.php'];
$heroSecondaryBtn = ['text' => 'Explore more', 'href' => 'index.php'];
$heroRightSide = 'image';
$heroImage = '/assets/images/blog-inner.png';
$heroBreadcrumb = [['label' => 'Blogs', 'href' => 'blogs.php'], ['label' => $blog['title']]];
include 'includes/hero.php';
?>

<div class="content-width page-section blog-detail-grid">
  <article>
    <header class="blog-article__author">
      <div class="blog-article__author-row">
        <img src="<?= url($blog['author']['avatar']) ?>" alt="<?= e($blog['author']['name']) ?>">
        <div>
          <h4 class="fw-600"><?= e($blog['author']['name']) ?></h4>
          <p class="muted-role"><?= e($blog['author']['role']) ?></p>
        </div>
      </div>
      <div class="blog-article__meta">
        <span>Posted on <?= e($blog['author']['date']) ?></span>
        <span aria-hidden="true">|</span>
        <span><?= e($blog['author']['readTime']) ?></span>
      </div>
    </header>

    <?php foreach ($blog['sections'] as $section): ?>
      <section class="blog-article__section" id="<?= e($section['id']) ?>">
        <h2 class="secondary-header"><?= e($section['heading']) ?></h2>
        <p class="body-text text-justify"><?= nl2br(e(trim($section['content']))) ?></p>
      </section>
    <?php endforeach; ?>
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
      <div class="sidebar-card__rating">
        <img src="<?= url('assets/icons/google.svg') ?>" alt="Google">
        <p class="rating-score">5.0</p>
        <p class="muted-xs">(Based on 125 Reviews)</p>
        <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
      </div>
    </div>
  </aside>
</div>

<?php include 'footer.php'?>

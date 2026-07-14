<?php
/**
 * News & Blog listing — ported from the legacy static blogs.php.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

$heroTitle      = 'Explore, Learn, and Grow – Your Journey Starts Here';
$heroSubtitle   = 'With a proven track record of dismissed charges and reduced penalties, we defend your rights.';
$heroFeatures   = array( 'Expert Legal Guidance', 'Tailored Legal Solutions', 'Free Initial Consultation', 'Fast & Efficient Process' );
$heroPrimaryBtn = array( 'text' => 'Explore more', 'href' => 'index.php' );
$heroRightSide  = 'image';
$heroImage      = '/assets/images/blogheroimg.png';
$heroBreadcrumb = array( array( 'label' => 'Blogs' ) );

include DM_LEGAL_DIR . '/inc/parts/hero.php';

$blogCategories = array( 'All Information', 'Business Law', 'Immigration & Visas', 'Family & Personal Law', 'Security & Compliance' );
?>

<section class="content-width content-gapping">
  <div class="blog-toolbar">
    <div class="blog-toolbar__categories">
      <?php foreach ( $blogCategories as $i => $cat ) : ?>
        <button type="button" data-blog-category="<?= e( $cat ) ?>" class="<?= $i === 0 ? 'is-active' : '' ?>"><?= e( $cat ) ?></button>
      <?php endforeach; ?>
    </div>
    <div class="blog-toolbar__search">
      <input type="text" data-blog-search placeholder="Search" aria-label="Search blog posts">
      <span aria-hidden="true">&#128269;</span>
    </div>
  </div>

  <div class="blog-grid" data-blog-grid>
    <?php
    foreach ( $blogs as $blog ) :
      $slug     = slugify( $blog['title'] );
      $keywords = mb_strtolower( $blog['title'] . ' ' . $blog['category'] . ' ' . implode( ' ', $blog['tags'] ) );
      ?>
      <div class="card-blog" data-blog-card data-category="<?= e( $blog['category'] ) ?>" data-keywords="<?= e( $keywords ) ?>">
        <div class="card-blog__media">
          <a href="<?= url( 'blog-detail.php?slug=' . $slug ) ?>"><img src="<?= url( $blog['image'] ) ?>" alt="<?= e( $blog['title'] ) ?>" loading="lazy" decoding="async"></a>
        </div>
        <div class="card-blog__meta">
          <div class="card-blog__author">
            <img src="<?= url( $blog['author']['avatar'] ) ?>" alt="" loading="lazy" decoding="async">
            <div>
              <p><?= e( $blog['author']['name'] ) ?></p>
              <p><?= e( $blog['author']['date'] ) ?></p>
            </div>
          </div>
          <div class="card-blog__tags">
            <?php foreach ( $blog['tags'] as $tag ) : ?><span><?= e( $tag ) ?></span><?php endforeach; ?>
          </div>
        </div>
        <h3><?= e( $blog['title'] ) ?></h3>
        <p class="excerpt"><?= e( truncate_words( $blog['excerpt'], 20 ) ) ?></p>
        <div class="card-blog__link"><a href="<?= url( 'blog-detail.php?slug=' . $slug ) ?>">More Info &rsaquo;</a></div>
      </div>
    <?php endforeach; ?>
  </div>

  <p class="no-results hidden" data-blog-empty>No blogs found matching your search.</p>

  <div class="blog-toolbar__buttons">
    <button type="button" class="btn-pill btn-pill--primary hidden" data-blog-more>Show More</button>
    <button type="button" class="btn-pill btn-pill--muted hidden" data-blog-less>Show Less</button>
  </div>
</section>

<?php get_footer(); ?>

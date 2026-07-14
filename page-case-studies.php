<?php
/**
 * Case Studies listing — ported from the legacy static case-studies.php.
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
$heroImage      = '/assets/images/case-studies-bgimg.png';
$heroBreadcrumb = array( array( 'label' => 'Case Studies' ) );

include DM_LEGAL_DIR . '/inc/parts/hero.php';
?>

<section class="content-width content-gapping">
  <div class="section-heading">
    <h2 class="secondary-header">Examples of how we&rsquo;ve supported clients</h2>
    <p class="body-text">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.</p>
  </div>

  <div class="case-toolbar">
    <div class="case-toolbar__filters">
      <span>Filter By:</span>
      <select data-case-issue aria-label="Filter by issue">
        <option value="All">Issue</option>
        <option value="Security">Security</option>
        <option value="Immigration">Immigration</option>
        <option value="Compliance">Compliance</option>
      </select>
      <select data-case-practice aria-label="Filter by practice area">
        <option value="All">Practice Area</option>
        <option value="Family Law">Family Law</option>
        <option value="Business Law">Business Law</option>
        <option value="Corporate">Corporate</option>
      </select>
    </div>
    <div class="case-toolbar__search">
      <input type="text" data-case-search placeholder="Search" aria-label="Search case studies">
      <span aria-hidden="true">&#128269;</span>
    </div>
  </div>

  <div class="services-grid" data-case-grid>
    <?php
    foreach ( $caseStudies as $cs ) :
      $slug     = slugify( $cs['title'] );
      $keywords = mb_strtolower( $cs['title'] . ' ' . implode( ' ', $cs['tags'] ) );
      ?>
      <div class="card-case" data-case-card data-issue="<?= e( $cs['issue'] ) ?>" data-practice="<?= e( $cs['practiceArea'] ) ?>" data-keywords="<?= e( $keywords ) ?>">
        <div class="card-case__media"><img src="<?= url( $cs['image'] ) ?>" alt="<?= e( $cs['title'] ) ?>" loading="lazy" decoding="async"></div>
        <div class="card-case__tags">
          <?php foreach ( $cs['tags'] as $tag ) : ?><span><?= e( $tag ) ?></span><?php endforeach; ?>
        </div>
        <h3><?= e( truncate_words( $cs['title'], 6 ) ) ?></h3>
        <p class="excerpt"><?= e( truncate_words( $cs['excerpt'], 20 ) ) ?></p>
        <div class="card-case__link"><a href="<?= url( 'case-study-detail.php?slug=' . $slug ) ?>">More Info &rsaquo;</a></div>
      </div>
    <?php endforeach; ?>
  </div>

  <p class="no-results hidden" data-case-empty>No case studies found.</p>

  <div class="blog-toolbar__buttons">
    <button type="button" class="btn-pill btn-pill--primary hidden" data-case-more>View More</button>
  </div>
</section>

<?php get_footer(); ?>

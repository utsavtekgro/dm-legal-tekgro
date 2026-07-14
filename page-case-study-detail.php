<?php
/**
 * Case Study detail — ported from the legacy static case-study-detail.php.
 * Reads ?slug= to pick the case study from $caseStudies.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

$slug = isset( $_GET['slug'] ) ? clean_input( wp_unslash( $_GET['slug'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$cs   = '' !== $slug ? find_case_study_by_slug( $slug ) : null;

if ( ! $cs ) :
	status_header( 404 );
	?>
	<div class="content-width page-section text-center">
		<h1 class="main-header">Case study not found</h1>
		<a class="btn btn-primary mt-4" href="<?= url( 'case-studies.php' ) ?>">Back to Case Studies</a>
	</div>
	<?php
	get_footer();
	return;
endif;

$heroTitle      = $cs['title'];
$heroMinimal    = true;
$heroBreadcrumb = array(
	array( 'label' => 'Case Studies', 'href' => 'case-studies.php' ),
	array( 'label' => $cs['title'] ),
);

include DM_LEGAL_DIR . '/inc/parts/hero.php';
?>

<div class="content-width stack-grid">
  <div class="blog-detail-grid">
    <article>
      <p class="body-text"><?= e( $cs['description'] ) ?></p>

      <div class="highlight-grid">
        <?php foreach ( $cs['highlights'] as $h ) : ?>
          <div class="highlight-card">
            <div class="highlight-card__icon"><img src="<?= url( $h['image'] ) ?>" alt="" width="28" height="28"></div>
            <h3><?= e( $h['label'] ) ?></h3>
            <p><?= e( $h['value'] ) ?></p>
          </div>
        <?php endforeach; ?>
      </div>

      <?php foreach ( $cs['sections'] as $i => $section ) : ?>
        <section class="blog-article__section">
          <h2 class="secondary-header"><?= e( $section['heading'] ) ?></h2>
          <p class="body-text"><?= e( $section['body'] ) ?></p>
          <?php if ( 0 === $i && ! empty( $cs['stats'] ) ) : ?>
            <div class="case-stats-grid">
              <?php foreach ( $cs['stats'] as $stat ) : ?>
                <div class="stat">
                  <p><?= e( $stat['value'] ) ?></p>
                  <p><?= e( $stat['description'] ) ?></p>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </section>
      <?php endforeach; ?>

      <div data-faq-list>
        <h2 class="secondary-header">Related FAQs</h2>
        <div class="faq-list">
          <?php foreach ( $consultationCostFAQ as $faq ) : ?>
            <div class="faq-item">
              <div class="faq-item__head">
                <h3><?= e( $faq['question'] ) ?></h3>
                <span class="faq-item__icon" aria-hidden="true"><svg viewBox="0 0 448 512"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg></span>
              </div>
              <div class="faq-item__panel"><p class="body-text"><?= e( $faq['answer'] ) ?></p></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </article>

    <aside>
      <div class="sidebar-card">
        <h2 class="secondary-header">Talk to an Expert</h2>
        <div class="sidebar-card__experts">
          <?php foreach ( array( 'expert1', 'expert2', 'expert3', 'expert4', 'expert5', 'expert6' ) as $expert ) : ?>
            <img src="<?= url( 'assets/images/' . $expert . '.png' ) ?>" alt="" loading="lazy" decoding="async">
          <?php endforeach; ?>
        </div>
        <div class="sidebar-card__buttons">
          <a class="btn btn-primary btn-full" href="<?= url( 'book-your-lawyer.php' ) ?>">Book Now</a>
          <a class="btn btn-secondary btn-full" href="tel:<?= e( SITE_PHONE_TEL ) ?>"><?= e( SITE_PHONE_DISPLAY ) ?></a>
        </div>
      </div>
    </aside>
  </div>
</div>

<?php get_footer(); ?>

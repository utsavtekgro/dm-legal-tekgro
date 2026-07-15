<?php
/**
 * Practice Area — ported from the legacy static practice-area.php.
 * With no ?slug it renders the landing grid; with ?slug it renders the
 * detail view for that practice area.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

$slug    = isset( $_GET['slug'] ) ? clean_input( wp_unslash( $_GET['slug'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$service = '' !== $slug ? find_practice_area_by_slug( $slug ) : null;

// ===================================================================
// DETAIL VIEW — a specific practice area was requested
// ===================================================================
if ( '' !== $slug && $service ) :
	$heroTitle      = 'Explore, Learn, and Grow – Your Journey Starts Here';
	$heroSubtitle   = 'With a proven track record of dismissed charges and reduced penalties, we defend your rights.';
	$heroFeatures   = array( 'Fixed Fees', 'Hourly rates', 'Manage Legal Costs', 'No Win, No Fees' );
	$heroSecondaryBtn = array( 'text' => 'Explore more', 'href' => 'index.php' );
	$heroRightSide  = 'image';
	$heroImage      = '/assets/images/case-studies-bgimg.png';
	$heroBreadcrumb = array(
		array( 'label' => 'Practice Area', 'href' => 'practice-area.php' ),
		array( 'label' => $service['title'] ),
	);
	include DM_LEGAL_DIR . '/inc/parts/hero.php';

	$actionsData = $actionsDataBySlug[ $slug ] ?? null;
	?>

	<?php if ( $actionsData ) : ?>
	<!-- ============ ACTIONS ============ -->
	<section class="content-width content-gapping">
	  <div class="actions-grid">
	    <div data-aos="fade-up">
	      <h2><?= e( $actionsData['title'] ) ?></h2>
	      <p class="body-text mb-6"><?= e( $actionsData['description'] ) ?></p>
	      <div class="faq-list faq-list--dark" data-faq-list>
	        <?php foreach ( $actionsData['actions'] as $action ) : ?>
	          <div class="faq-item">
	            <div class="faq-item__head">
	              <h3><?= e( $action['question'] ) ?></h3>
	              <span class="faq-item__icon" aria-hidden="true"><svg viewBox="0 0 448 512"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg></span>
	            </div>
	            <div class="faq-item__panel"><p class="body-text text-white"><?= e( $action['answer'] ) ?></p></div>
	          </div>
	        <?php endforeach; ?>
	      </div>
	      <?php if ( ! empty( $actionsData['sub-description'] ) ) : ?>
	        <p class="body-text mt-4"><?= e( $actionsData['sub-description'] ) ?></p>
	      <?php endif; ?>
	    </div>
	    <div class="actions-images">
	      <?php foreach ( $actionsData['images'] as $i => $img ) : ?>
	        <img src="<?= url( $img ) ?>" alt="Action <?= $i + 1 ?>" loading="lazy" decoding="async" data-aos="fade-up" data-aos-delay="<?= $i * 150 ?>">
	      <?php endforeach; ?>
	    </div>
	  </div>
	</section>
	<?php endif; ?>

	<!-- ============ HELP CLIENTS ============ -->
	<section class="help-clients content-gapping" style="background-image:url('<?= url( $helpClientsData['backgroundImage'] ) ?>')">
	  <div class="content-width help-clients__inner">
	    <div data-aos="fade-up">
	      <h2><?= e( $helpClientsData['title'] ) ?></h2>
	      <p><?= e( $helpClientsData['description'] ) ?></p>
	      <a class="btn btn-primary" href="<?= url( 'contact.php' ) ?>">Start Free Legal Check</a>
	    </div>
	    <div class="help-clients__cards">
	      <?php foreach ( $helpClientsData['services'] as $i => $hc ) : ?>
	        <div class="card-help" data-aos="fade-up" data-aos-delay="<?= $i * 200 ?>">
	          <div class="card-help__icon"><img src="<?= url( $hc['icon'] ) ?>" alt="" width="32" height="32"></div>
	          <div><h3><?= e( $hc['title'] ) ?></h3><p><?= e( $hc['description'] ) ?></p></div>
	        </div>
	      <?php endforeach; ?>
	    </div>
	  </div>
	</section>

	<!-- ============ VIDEO ============ -->
	<section class="content-width content-gapping video-section">
	  <div class="video-section__media" data-aos="fade-right">
	    <video controls poster="<?= url( 'assets/images/services.png' ) ?>">
	      <?php if ( ! empty( $videoSectionData['videoUrl'] ) ) : ?><source src="<?= url( $videoSectionData['videoUrl'] ) ?>" type="video/mp4"><?php endif; ?>
	      Your browser does not support the video tag.
	    </video>
	  </div>
	  <div class="video-section__content" data-aos="fade-left">
	    <h2><?= e( $videoSectionData['title'] ) ?></h2>
	    <p><?= e( $videoSectionData['description'] ) ?></p>
	    <a class="btn btn-primary" href="<?= url( $videoSectionData['buttonLink'] ) ?>"><?= e( $videoSectionData['buttonText'] ) ?></a>
	  </div>
	</section>

	<!-- ============ Process ============ -->
	<section class="content-width content-gapping text-center">
	  <div data-aos="fade-up">
	    <h2 class="secondary-header">Process for <?= e( $service['title'] ) ?></h2>
	    <p class="body-text section-lead">Our team of experienced lawyers is dedicated to providing comprehensive assistance and support.</p>
	  </div>
	  <div class="steps-grid">
	    <div class="steps-grid__four">
	      <?php foreach ( $steps as $i => $step ) : ?>
	        <div class="step-item" data-aos="zoom-out-right" data-aos-delay="<?= $i * 150 ?>">
	          <div class="step-card">
	            <div class="step-card__icon"><img src="<?= url( $step['image'] ) ?>" alt="" width="40" height="40"></div>
	            <h3><?= e( $step['title'] ) ?></h3>
	            <p><?= e( $step['description'] ) ?></p>
	          </div>
	          <?php if ( $i < count( $steps ) - 1 ) : ?>
	            <div class="step-arrow-down"><img src="<?= url( 'assets/icons/arrow-down.svg' ) ?>" alt="" width="30" height="30"></div>
	            <div class="step-arrow-right"><img src="<?= url( 'assets/icons/arrow.svg' ) ?>" alt="" width="80" height="60"></div>
	          <?php endif; ?>
	        </div>
	      <?php endforeach; ?>
	    </div>
	  </div>
	</section>

	<!-- ============ Explore Services ============ -->
	<section class="content-width content-gapping">
	  <div class="section-heading">
	    <h2 class="secondary-header">Explore <?= e( $service['title'] ) ?> Services</h2>
	  </div>
	  <div class="services-grid">
	    <?php $innerServicesForArea = array_slice( $practiceAreaInnerServices, 0, $service['innerServiceCount'] ); ?>
	    <?php
	    foreach ( $innerServicesForArea as $idx => $inner ) :
	      $innerSlug = slugify( $inner['title'] );
	      ?>
	      <div class="card-law">
	        <div class="card-law__media">
	          <a href="<?= url( 'practice-area-inner.php?slug=' . $slug . '&inner=' . $innerSlug ) ?>">
	            <img src="<?= url( $inner['image'] ) ?>" alt="<?= e( $inner['title'] ) ?>" loading="lazy" decoding="async">
	          </a>
	        </div>
	        <div class="card-law__body">
	          <div>
	            <h3><?= e( $inner['title'] ) ?></h3>
	            <p><?= e( truncate_words( $inner['description'], 16 ) ) ?></p>
	          </div>
	          <a class="card-law__link" href="<?= url( 'practice-area-inner.php?slug=' . $slug . '&inner=' . $innerSlug ) ?>">Read more &rsaquo;</a>
	        </div>
	      </div>
	    <?php endforeach; ?>
	  </div>
	</section>

	<!-- ============ Limited CONTACT ============ -->
	<section class="attraction-contact" data-aos="fade-up">
	  <div class="content-width attraction-contact__row">
	    <h2 class="main-header attraction-contact__title">Limited slots available &mdash; Book your consultation now</h2>
	    <div class="attraction-contact__intro">
	      <p class="measure-sm">You can choose any format of consultation with our lawyer:</p>
	      <div class="attraction-contact__options">
	        <?php foreach ( $options as $option ) : ?>
	          <div class="attraction-contact__option">
	            <img src="<?= url( $option['icon'] ) ?>" alt="">
	            <p><?= e( $option['label'] ) ?></p>
	          </div>
	        <?php endforeach; ?>
	      </div>
	      <a class="btn btn-primary" href="<?= url( 'contact.php' ) ?>">Book a Consultation</a>
	    </div>
	  </div>
	</section>

	<!-- ============ FAQ ============ -->
	<section class="content-width content-gapping">
	  <h2 class="secondary-header text-center">Frequently Asked Questions</h2>
	  <p class="body-text text-center section-lead--tight">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support.</p>
	  <div class="faq-list" data-faq-list>
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
	</section>

	<?php
	get_footer();
	return;
endif;

if ( '' !== $slug && ! $service ) {
	status_header( 404 );
}

// ===================================================================
// LANDING VIEW — /practice-area/ with no slug (or an unknown slug)
// ===================================================================
$heroTitle      = 'Protect Your Financial Future at an Affordable, Transparent Cost with Our Fixed Fees';
$heroSubtitle   = 'With a proven track record of dismissed charges and reduced penalties, we defend your rights.';
$heroFeatures   = array( 'Fixed Fees', 'Hourly rates', 'Manage Legal Costs', 'No Win, No Fees' );
$heroPrimaryBtn = array( 'text' => 'Book free consultation', 'href' => 'book-your-lawyer.php' );
$heroSecondaryBtn = array( 'text' => 'Explore more', 'href' => 'index.php' );
$heroRightSide  = 'image';
$heroImage      = '/assets/images/practicearea-img.png';
$heroBreadcrumb = array( array( 'label' => 'Practice Area' ) );

include DM_LEGAL_DIR . '/inc/parts/hero.php';
?>

<section class="content-width content-gapping">
  <div class="section-heading">
    <h2 class="secondary-header">Our Practice Areas</h2>
    <p class="body-text">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.</p>
  </div>
  <div class="services-grid">
    <?php
    /*
     * Practice areas are managed in wp-admin (Practice Areas → All). Ordered by
     * the page-attributes "Order" field, then title.
     */
    $dm_pa_query = new WP_Query(
      array(
        'post_type'      => 'practice_area',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
        'no_found_rows'  => true,
      )
    );

    if ( $dm_pa_query->have_posts() ) :
      $idx = 0;
      while ( $dm_pa_query->have_posts() ) :
        $dm_pa_query->the_post();
        $svcSlug = get_post_field( 'post_name', get_the_ID() );
        $svcDesc = has_excerpt() ? get_the_excerpt() : wp_strip_all_tags( get_the_content() );
        ?>
        <div class="card-law" data-aos="fade-up" data-aos-delay="<?= $idx * 100 ?>">
          <div class="card-law__media">
            <a href="<?= url( 'practice-area.php?slug=' . $svcSlug ) ?>">
              <img src="<?= e( dm_legal_pa_image_url( get_the_ID() ) ) ?>" alt="<?= e( get_the_title() ) ?>" loading="lazy" decoding="async">
            </a>
          </div>
          <div class="card-law__body">
            <div>
              <h3><?= e( get_the_title() ) ?></h3>
              <p><?= e( truncate_words( $svcDesc, 12 ) ) ?></p>
            </div>
            <a class="card-law__link" href="<?= url( 'practice-area.php?slug=' . $svcSlug ) ?>">Read more &rsaquo;</a>
          </div>
        </div>
        <?php
        $idx++;
      endwhile;
      wp_reset_postdata();
    else :
      ?>
      <p class="no-results">No practice areas published yet.</p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>

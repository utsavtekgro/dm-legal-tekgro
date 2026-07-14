<?php
/**
 * FAQs — ported from the legacy static faqs.php.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

$heroTitle      = 'Trusted Legal Solutions – Protecting Your Rights, Securing Your Future';
$heroSubtitle   = 'Expert legal guidance in family law, business disputes, immigration, and more – tailored to your needs.';
$heroFeatures   = array( 'Expert Legal Guidance', 'Tailored Legal Solutions', 'Free Initial Consultation', 'Fast & Efficient Process' );
$heroPrimaryBtn = array( 'text' => 'How to contact us?', 'href' => 'contact.php' );
$heroSecondaryBtn = array( 'text' => 'Leave Enquiry', 'href' => 'index.php' );
$heroRightSide  = 'image';
$heroImage      = '/assets/images/faqHeroImg.png';
$heroBreadcrumb = array( array( 'label' => 'FAQs' ) );

include DM_LEGAL_DIR . '/inc/parts/hero.php';
?>

<!-- ============ FAQ CATEGORIES ============ -->
<?php
/*
 * Editable via the "FAQ Categories Section" metabox (Pages → FAQs).
 * Each category renders as a tab. Blank fields fall back to these defaults.
 */
$dm_fc = dm_legal_faqcats_args(
	array(
		'heading'    => 'Frequently Asked Questions',
		'lead'       => 'Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.',
		'categories' => $faqCategories,
	)
);
$dm_fc_cats = $dm_fc['categories'];
?>
<section class="content-width content-gapping">
  <div class="section-heading">
    <h2 class="secondary-header"><?= e( $dm_fc['heading'] ) ?></h2>
    <p class="body-text"><?= e( $dm_fc['lead'] ) ?></p>
  </div>

  <div class="tabs" data-tabs="faq-categories">
    <?php foreach ( $dm_fc_cats as $i => $cat ) : ?>
      <button type="button" data-tab-btn="cat-<?= $i ?>" class="<?= $i === 0 ? 'is-active' : '' ?>"><?= e( $cat['title'] ) ?></button>
    <?php endforeach; ?>
  </div>

  <?php foreach ( $dm_fc_cats as $i => $cat ) : ?>
    <div data-tab-panel="cat-<?= $i ?>" data-tabs-target="faq-categories" class="<?= $i === 0 ? '' : 'hidden' ?>">
      <div class="faq-list" data-faq-list>
        <?php foreach ( ( $cat['faqs'] ?? array() ) as $faq ) : ?>
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
  <?php endforeach; ?>

  <div class="form-card form-card--narrow">
    <h3 class="sub-heading text-center mb-4">Still Have Any Question?</h3>
    <form data-ajax-form novalidate>
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
      <img src="<?= url( 'assets/images/avatar1.png' ) ?>" alt="">
      <img src="<?= url( 'assets/images/avatar2.png' ) ?>" alt="">
      <img src="<?= url( 'assets/images/avatar3.png' ) ?>" alt="">
    </div>
    <h3>Direct Connect With Us</h3>
    <p>Can&rsquo;t find the answer you&rsquo;re looking for? Please chat to our friendly team.</p>
    <a class="btn btn-primary" href="<?= url( 'contact.php' ) ?>">Contact Us</a>
  </div>
</section>

<?php get_footer(); ?>

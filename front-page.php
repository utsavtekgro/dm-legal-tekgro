<?php
/**
 * Front page — ported from the legacy static index.php (home).
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<!-- ============ HERO ============ -->
<div class="hero">
  <div class="content-width hero__inner">
    <div class="hero__content">
      <?php render_breadcrumb( array() ); /* breadcrumb hidden on home */ ?>
      <h1 class="main-header">Clear Legal Advice for Life&rsquo;s Toughest Moments</h1>
      <p class="body-text">Providing trusted representation in family law, criminal law, migration law, civil
        litigation, and business law &ndash; protecting your rights and guiding your future.</p>
      <ul class="hero__features">
        <?php
        foreach ( array(
          'Comprehensive Legal Expertise',
          'Trusted Representation Across Australia',
          'Free Initial Consultation',
          'Efficient, Client-Focused Process',
        ) as $feature ) :
          ?>
          <li><img src="<?= url( 'assets/icons/tick.svg' ) ?>" alt="" width="20" height="20"><?= e( $feature ) ?></li>
        <?php endforeach; ?>
      </ul>
      <div class="hero__buttons">
        <a class="btn btn-secondary" href="<?= url( 'index.php' ) ?>">Leave Enquiry</a>
        <a class="btn btn-primary" href="<?= url( 'contact.php' ) ?>">How to contact us?</a>
      </div>
    </div>
    <div class="hero__aside">
      <form class="hero-form" data-ajax-form novalidate>
        <h2 class="sub-heading">Get In Touch Instantly</h2>
        <input type="text" class="honeypot" name="website" tabindex="-1" autocomplete="off">
        <input class="form-control" type="text" name="name" placeholder="Full Name" required>
        <div class="form-row">
          <input class="form-control" type="email" name="email" placeholder="Enter Your Email" required>
          <input class="form-control" type="tel" name="phone" placeholder="Mobile Number" required
            pattern="^[0-9+()\-\s]{6,20}$">
        </div>
        <select class="form-control" name="matterType" required>
          <option value="">Select Matter Type</option>
          <option value="immigration">Family Law &amp; Property Settlement</option>
          <option value="visa">Commercial &amp; Business Law</option>
          <option value="retail">Retail Lease Matter</option>
          <option value="professional">Professional Registration (AHPRA)</option>
          <option value="debt">Debt Recovery</option>
          <option value="immigration-visa">Immigration &amp; Visa Matter</option>
          <option value="criminal">Criminal Law Matter</option>
          <option value="other">Other Legal Matter</option>
        </select>
        <textarea class="form-control" name="message" placeholder="Any Extra Message (optional)" rows="3"></textarea>
        <p class="form-success" data-form-message hidden></p>
        <button type="submit" class="btn btn-primary btn-full">Book Free Consultation</button>
      </form>
    </div>
  </div>
</div>

<!-- ============ ABOUT ============ -->
<?php
$about = dm_legal_about_args(
  array(
    'heading'   => 'About DM Legal Services',
    'body'      => 'Our professional team at DM Legal Services is committed to delivering exceptional legal support across all areas of law, ensuring each client receives the guidance, representation, and attention they deserve. We stay constantly updated on the latest legal developments and regulatory changes to prevent unnecessary delays and provide solutions that are both practical and effective. We work exclusively with fully accredited and highly experienced legal professionals who are recognised for their integrity, skill, and dedication to client success. Navigating the Australian legal system can be challenging, and our role is to simplify this process for you with personalised strategies, clear advice, and hands-on support to achieve the best possible outcome.',
    'image'     => url( 'assets/images/AboutDMLegalService.jpeg' ),
    'image_alt' => 'About DM Legal Services',
  )
);
?>
<section class="content-width content-gapping split-section" data-aos="fade-up">
  <div class="split-section__text">
    <h2 class="secondary-header"><?= e( $about['heading'] ) ?></h2>
    <p class="body-text text-justify"><?= e( $about['body'] ) ?></p>
  </div>
  <div class="split-section__media">
    <img src="<?= e( $about['image'] ) ?>" class="img-fill" alt="<?= e( $about['image_alt'] ) ?>">
  </div>
</section>

<!-- ============ LEGAL SERVICES ============ -->
<section class="content-width content-gapping">
  <div class="section-heading" data-aos="fade-up">
    <h2 class="secondary-header">Legal Services We Provide</h2>
    <p class="body-text">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and
      support in matters related to divorce, child custody, spousal support, and more.</p>
  </div>
  <div class="services-grid">
    <?php
    foreach ( $legalServicesData as $idx => $service ) :
      $slug = slugify( $service['title'] );
      ?>
      <div class="card-law" data-aos="fade-up" data-aos-delay="<?= $idx * 100 ?>">
        <div class="card-law__media">
          <a href="<?= url( 'practice-area.php?slug=' . $slug ) ?>">
            <img src="<?= url( $service['image'] ) ?>" alt="<?= e( $service['title'] ) ?>" loading="lazy" decoding="async">
          </a>
        </div>
        <div class="card-law__body">
          <div>
            <h3><?= e( $service['title'] ) ?></h3>
            <p><?= e( truncate_words( $service['description'], 12 ) ) ?></p>
          </div>
          <a class="card-law__link" href="<?= url( 'practice-area.php?slug=' . $slug ) ?>">Read more &rsaquo;</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="hero__buttons btn-row--center-md" data-aos="fade-up">
    <a class="btn btn-secondary" href="tel:<?= e( SITE_PHONE_TEL ) ?>"><?= e( SITE_PHONE_DISPLAY ) ?></a>
    <a class="btn btn-primary" href="<?= url( 'book-your-lawyer.php' ) ?>">Book a Consultation</a>
  </div>
</section>

<!-- ============ ATTRACTION CONTACT ============ -->
<?php
/*
 * This block shares its content with the Fixed Prices page. It is edited via
 * the "Attraction Contact Section" metabox on Pages → Fixed Prices, and pulled
 * in here from that page's meta so both pages stay in sync. Blank fields fall
 * back to the defaults below.
 */
$dm_fp    = get_page_by_path( 'fixed-prices' );
$dm_fp_id = $dm_fp instanceof WP_Post ? (int) $dm_fp->ID : 0;
$dm_ac    = dm_legal_ac_args(
  array(
    'title'    => 'Limited slots available — Book your consultation now',
    'intro'    => 'You can choose any format of consultation with our lawyer:',
    'options'  => $options,
    'btn_text' => 'Book a Consultation',
    'btn_href' => 'book-your-lawyer.php',
  ),
  $dm_fp_id
);
?>
<section class="attraction-contact" data-aos="fade-up">
  <div class="content-width attraction-contact__row">
    <h2 class="main-header attraction-contact__title"><?= e( $dm_ac['title'] ) ?></h2>
    <div class="attraction-contact__intro">
      <p class="measure-sm"><?= e( $dm_ac['intro'] ) ?></p>
      <?php if ( ! empty( $dm_ac['btn_text'] ) ) : ?>
        <a class="btn btn-primary btn-consult-up" href="<?= url( $dm_ac['btn_href'] ) ?>"><?= e( $dm_ac['btn_text'] ) ?></a>
      <?php endif; ?>

      <div class="attraction-contact__options">
        <?php foreach ( $dm_ac['options'] as $option ) : ?>
          <div class="attraction-contact__option">
            <?php if ( ! empty( $option['icon'] ) ) : ?>
              <img src="<?= url( $option['icon'] ) ?>" alt="">
            <?php endif; ?>
            <p><?= e( $option['label'] ) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
      <?php if ( ! empty( $dm_ac['btn_text'] ) ) : ?>
        <a class="btn btn-primary btn-consult" href="<?= url( $dm_ac['btn_href'] ) ?>"><?= e( $dm_ac['btn_text'] ) ?></a>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ============ EXPRESSION SECTION ============ -->
<?php
$expr = dm_legal_expr_args(
  array(
    'heading'   => 'Expert Guidance from Accredited Legal Professionals',
    'body'      => array(
      'At DM Legal Services, we understand that successfully navigating Australia’s legal and immigration systems requires far more than general knowledge. It demands an in-depth understanding of complex regulations, procedural requirements, and evolving legal frameworks.',
      'We recognise that every client’s situation is unique. That is why we provide tailored advice and bespoke strategies designed to address the specific needs of each client, ensuring they are fully informed, confident, and strategically positioned to achieve their goals.',
      'Our comprehensive services cover a wide range of visa and immigration matters, including family visas, student visas, business visas, temporary work visas, general skilled migration visas, and working holiday visas.',
      'With DM Legal Services, you can be confident that every aspect of your journey is guided by accredited professionals who prioritise your success and streamline complex processes.',
    ),
    'image'     => url( 'assets/images/expert-euidance1.png' ),
    'image_alt' => 'Expert guidance from accredited legal professionals',
  )
);
?>
<section class="content-width content-gapping split-section" data-aos="fade-up">
  <div class="split-section__text">
    <h2 class="secondary-header text-center"><?= e( $expr['heading'] ) ?></h2>
    <div class="text-stack">
      <?php foreach ( $expr['body'] as $paragraph ) : ?>
        <p class="body-text text-justify"><?= e( $paragraph ) ?></p>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="split-section__media">
    <img src="<?= e( $expr['image'] ) ?>" alt="<?= e( $expr['image_alt'] ) ?>" loading="lazy" decoding="async">
  </div>
</section>

<!-- ============ WHY CHOOSE US ============ -->
<?php
$wcu = dm_legal_wcu_args(
  array(
    'heading'  => 'Why To Choose Us',
    'lead'     => 'Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.',
    'stats'    => $statsData,
    'services' => $serviceData,
  )
);
?>
<section class="content-width content-gapping">
  <div class="section-heading" data-aos="fade-up">
    <h2 class="secondary-header"><?= e( $wcu['heading'] ) ?></h2>
    <p class="body-text"><?= e( $wcu['lead'] ) ?></p>
  </div>
  <div class="stats-grid">
    <?php foreach ( $wcu['stats'] as $i => $stat ) : ?>
      <div class="stat-item" data-aos="zoom-in" data-aos-delay="<?= $i * 150 ?>">
        <h3><?= e( $stat['value'] ) ?></h3>
        <p><?= e( $stat['label'] ) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="services-row" data-aos="fade-up" data-aos-delay="200">
    <?php foreach ( $wcu['services'] as $service ) : ?>
      <div class="card-service">
        <?php if ( ! empty( $service['image'] ) ) : ?>
          <div class="card-service__icon"><img src="<?= url( $service['image'] ) ?>" alt=""></div>
        <?php endif; ?>
        <h3><?= e( $service['title'] ) ?></h3>
        <p><?= e( $service['description'] ) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ============ AFFILIATIONS ============ -->
<?php
$aff = dm_legal_aff_args(
  array(
    'heading' => 'Our Affiliations & Membership',
    'lead'    => 'Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.',
    'logos'   => $affiliations,
  )
);
?>
<section class="affiliation-section content-gapping" data-aos="fade-up">
  <h2 class="secondary-header"><?= e( $aff['heading'] ) ?></h2>
  <p class="body-text"><?= e( $aff['lead'] ) ?></p>
  <div class="affiliation-logos">
    <?php foreach ( $aff['logos'] as $i => $item ) : ?>
      <div class="affiliation-logos__item" data-aos="zoom-in" data-aos-delay="<?= ( $i + 1 ) * 100 ?>">
        <img src="<?= url( $item['image'] ) ?>" alt="<?= e( $item['alt'] ) ?>" loading="lazy" decoding="async">
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ============ GET SUPPORT ============ -->
<?php
$gs = dm_legal_gs_args(
  array(
    'heading'     => 'Professional Legal Support',
    'body_top'    => array(
      'Our professional team at DM Legal Services is committed to delivering exceptional legal support across all areas of law, ensuring each client receives the guidance, representation, and attention they deserve.',
      'We work exclusively with fully accredited and highly experienced legal professionals who are recognised for their integrity, skill, and dedication to client success.',
      'Navigating the Australian legal system can be challenging. Our role is to simplify this process for you by offering personalised strategies, clear advice, and hands-on support.',
    ),
    'features'    => array( 'Business Law', 'Commercial Law', 'Criminal Law', 'Family Law', 'Debt Recovery', 'Immigration Law' ),
    'body_bottom' => 'Our commitment to professional excellence and attention to detail ensures that every client receives thorough guidance, effective representation, and the confidence to navigate their legal matters successfully.',
    'image'       => url( 'assets/images/ProfessionalLegalSupport.jpg' ),
    'image_alt'   => 'Professional legal support',
  )
);
?>
<section class="content-width content-gapping text-center" data-aos="fade-up">
  <h2 class="secondary-header"><?= e( $gs['heading'] ) ?></h2>
  <div class="split-section">
    <div class="text-stack text-justify">
      <?php foreach ( $gs['body_top'] as $paragraph ) : ?>
        <p class="body-text"><?= e( $paragraph ) ?></p>
      <?php endforeach; ?>
      <ul class="feature-check-list">
        <?php foreach ( $gs['features'] as $feature ) : ?>
          <li><img src="<?= url( 'assets/icons/check.svg' ) ?>" alt=""><span><?= e( $feature ) ?></span></li>
        <?php endforeach; ?>
      </ul>
      <?php if ( ! empty( $gs['body_bottom'] ) ) : ?>
        <p class="body-text"><?= e( $gs['body_bottom'] ) ?></p>
      <?php endif; ?>
    </div>
    <div class="split-section__media">
      <img src="<?= e( $gs['image'] ) ?>" alt="<?= e( $gs['image_alt'] ) ?>" loading="lazy" decoding="async">
    </div>
  </div>
</section>

<!-- ============ HOW WE WORK ============ -->
<?php
$hww = dm_legal_hww_args(
  array(
    'heading' => 'How We Work',
    'lead'    => 'Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.',
    'steps'   => $steps,
  )
);
$hww_steps = $hww['steps'];
?>
<section class="content-width content-gapping text-center">
  <div data-aos="fade-up">
    <h2 class="secondary-header"><?= e( $hww['heading'] ) ?></h2>
    <p class="body-text section-lead"><?= e( $hww['lead'] ) ?></p>
  </div>
  <div class="steps-grid">
    <div class="steps-grid__list">
      <?php foreach ( $hww_steps as $i => $step ) : ?>
        <div class="step-item" data-aos="zoom-out-right" data-aos-delay="<?= $i * 150 ?>">
          <div class="step-card">
            <?php if ( ! empty( $step['image'] ) ) : ?>
              <div class="step-card__icon"><img src="<?= url( $step['image'] ) ?>" alt="" width="40" height="40"></div>
            <?php endif; ?>
            <h3><?= e( $step['title'] ) ?></h3>
            <p><?= e( $step['description'] ) ?></p>
          </div>
          <?php if ( $i < count( $hww_steps ) - 1 ) : ?>
            <div class="step-arrow-down"><img src="<?= url( 'assets/icons/arrow-down.svg' ) ?>" alt="" width="30" height="30">
            </div>
            <div class="step-arrow-right"><img src="<?= url( 'assets/icons/arrow.svg' ) ?>" alt="" width="80" height="60">
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ NEWS CAROUSEL ============ -->
<?php
$news = dm_legal_news_args(
  array(
    'heading'   => 'How We Handle Your Problem',
    'lead'      => 'Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.',
    'items'     => $newsData,
    'view_text' => 'View All',
    'view_href' => 'blogs.php',
  )
);
?>
<section class="content-width content-gapping">
  <div class="section-heading" data-aos="fade-up">
    <h2 class="secondary-header"><?= e( $news['heading'] ) ?></h2>
    <p class="body-text"><?= e( $news['lead'] ) ?></p>
  </div>
  <div class="carousel carousel--full" data-autoplay="5000" data-aos="zoom-out-up">
    <div class="carousel__track">
      <?php foreach ( $news['items'] as $item ) : ?>
        <div class="card-news" style="background-image:url('<?= url( $item['image'] ) ?>')">
          <div class="card-news__body">
            <div class="card-news__meta">
              <span class="card-news__tag"><?= e( $item['category'] ) ?></span>
              <time class="card-news__date"><?= e( $item['date'] ) ?></time>
            </div>
            <h3><?= e( $item['title'] ) ?></h3>
            <p><?= e( truncate_words( $item['preview'], 55 ) ) ?></p>
            <?php if ( ! empty( $item['link'] ) ) : ?>
              <a class="btn btn-primary" href="<?= url( $item['link'] ) ?>">Read More about this article</a>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="carousel__dots"></div>
  </div>
  <?php if ( ! empty( $news['view_text'] ) ) : ?>
    <div class="text-center mt-4">
      <a class="btn btn-primary" href="<?= url( $news['view_href'] ) ?>"><?= e( $news['view_text'] ) ?></a>
    </div>
  <?php endif; ?>
</section>

<!-- ============ LATEST BLOGS ============ -->
<?php
$lb = dm_legal_lb_args(
  array(
    'heading'   => 'Our Latest Blogs',
    'lead'      => 'Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal.',
    'count'     => 3,
    'view_text' => 'View All',
    'view_href' => 'blogs.php',
  )
);
?>
<section class="content-width content-gapping" data-aos="fade-up">
  <h2 class="secondary-header text-center"><?= e( $lb['heading'] ) ?></h2>
  <p class="body-text text-center section-lead--tight"><?= e( $lb['lead'] ) ?></p>
  <?php
  /*
   * Cards are the latest published WordPress posts (Posts → All Posts), so
   * they stay in sync with the News & Blog page. The count is set in the
   * "Latest Blogs Section" metabox.
   */
  $dm_lb_query = new WP_Query(
    array(
      'post_type'      => 'post',
      'post_status'    => 'publish',
      'posts_per_page' => (int) $lb['count'],
      'no_found_rows'  => true,
      'ignore_sticky_posts' => true,
    )
  );
  $dm_lb_fallback = '/assets/images/Blogs.jpeg';
  ?>
  <div class="blog-grid">
    <?php
    if ( $dm_lb_query->have_posts() ) :
      while ( $dm_lb_query->have_posts() ) :
        $dm_lb_query->the_post();

        $post_tags = get_the_tags();
        $tag_names = $post_tags ? wp_list_pluck( $post_tags, 'name' ) : array();
        $thumb     = get_the_post_thumbnail_url( get_the_ID(), 'large' );
        $image     = $thumb ? $thumb : url( $dm_lb_fallback );
        $avatar    = get_avatar_url( get_the_author_meta( 'ID' ), array( 'size' => 96 ) );
        ?>
        <div class="card-blog">
          <div class="card-blog__media">
            <a href="<?php the_permalink(); ?>"><img src="<?= e( $image ) ?>" alt="<?= e( get_the_title() ) ?>" loading="lazy" decoding="async"></a>
          </div>
          <div class="card-blog__meta">
            <div class="card-blog__author">
              <img src="<?= e( $avatar ) ?>" alt="" loading="lazy" decoding="async">
              <div>
                <p><?= e( get_the_author() ) ?></p>
                <p><?= e( get_the_date( 'F j, Y' ) ) ?></p>
              </div>
            </div>
            <div class="card-blog__tags">
              <?php foreach ( $tag_names as $tag ) : ?><span><?= e( $tag ) ?></span><?php endforeach; ?>
            </div>
          </div>
          <h3><?= e( get_the_title() ) ?></h3>
          <p class="excerpt"><?= e( truncate_words( wp_strip_all_tags( get_the_excerpt() ), 20 ) ) ?></p>
          <div class="card-blog__link"><a href="<?php the_permalink(); ?>">More Info &rsaquo;</a></div>
        </div>
        <?php
      endwhile;
      wp_reset_postdata();
    else :
      ?>
      <p class="no-results">No blog posts published yet.</p>
    <?php endif; ?>
  </div>
  <?php if ( ! empty( $lb['view_text'] ) ) : ?>
    <div class="text-center mt-4">
      <a class="btn btn-primary" href="<?= url( $lb['view_href'] ) ?>"><?= e( $lb['view_text'] ) ?></a>
    </div>
  <?php endif; ?>
</section>

<!-- ============ FAQ ============ -->
<?php
$dm_faq = dm_legal_faq_args(
  array(
    'heading'      => 'Frequently Asked Questions',
    'lead'         => 'Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal.',
    'items'        => $consultationCostFAQ,
    'cta_heading'  => 'Direct Connect With Us',
    'cta_text'     => 'Can’t find the answer you’re looking for? Please chat to our friendly team.',
    'cta_btn_text' => 'Contact Us',
    'cta_btn_href' => 'contact.php',
  )
);
?>
<section class="content-width content-gapping">
  <h2 class="secondary-header text-center"><?= e( $dm_faq['heading'] ) ?></h2>
  <p class="body-text text-center section-lead--tight"><?= e( $dm_faq['lead'] ) ?></p>
  <div class="faq-list" data-faq-list>
    <?php foreach ( $dm_faq['items'] as $faq ) : ?>
      <div class="faq-item">
        <div class="faq-item__head">
          <h3><?= e( $faq['question'] ) ?></h3>
          <span class="faq-item__icon" aria-hidden="true"><svg viewBox="0 0 448 512"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg></span>
        </div>
        <div class="faq-item__panel">
          <p class="body-text"><?= e( $faq['answer'] ) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="faq-cta">
    <div class="faq-cta__avatars">
      <img src="<?= url( 'assets/images/avatar1.png' ) ?>" alt="">
      <img src="<?= url( 'assets/images/avatar2.png' ) ?>" alt="">
      <img src="<?= url( 'assets/images/avatar3.png' ) ?>" alt="">
    </div>
    <h3><?= e( $dm_faq['cta_heading'] ) ?></h3>
    <p><?= e( $dm_faq['cta_text'] ) ?></p>
    <?php if ( ! empty( $dm_faq['cta_btn_text'] ) ) : ?>
      <a class="btn btn-primary" href="<?= url( $dm_faq['cta_btn_href'] ) ?>"><?= e( $dm_faq['cta_btn_text'] ) ?></a>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>

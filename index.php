<?php
/**
 * Home page — converted from src/app/page.tsx
 */

$pageTitle = 'DM Legal | Trusted Legal Solutions in Australia';
include 'header.php';
$dynamicContentText = "At DM Legal Services, we understand that choosing the right legal team is one of the most important decisions you can make. Our firm combines extensive experience, proven expertise, and a client-first approach to ensure your legal matters are handled with precision, care, and integrity.\n\nWe provide comprehensive guidance across business law, commercial disputes, criminal law, family matters, debt recovery, and immigration law. Every case is treated individually, allowing us to develop tailored strategies that protect your interests, resolve issues efficiently, and achieve optimal outcomes.\n\nClients choose us because we deliver results backed by a track record of success, industry recognition, and unwavering dedication to ethical and professional standards. We prioritise clear communication, proactive advice, and full transparency at every stage of the process so you can feel confident and informed.\n\nWith DM Legal Services, you are not just hiring a law firm – you are gaining a trusted partner committed to guiding you through complex legal challenges with expertise and care.";
?>

<!-- ============ HERO ============ -->
<div class="hero">
  <div class="content-width hero__inner">
    <div class="hero__content">
      <?php render_breadcrumb([]); /* breadcrumb hidden on home, matching Breadcrumb.tsx */ ?>
      <h1 class="main-header">Clear Legal Advice for Life’s Toughest Moments</h1>
      <p class="body-text">Providing trusted representation in family law, criminal law, migration law, civil
        litigation, and business law &ndash; protecting your rights and guiding your future.</p>
      <ul class="hero__features">

        <?php foreach ([
          'Comprehensive Legal Expertise',
          'Trusted Representation Across Australia',
          'Free Initial Consultation',
          'Efficient, Client-Focused Process'
        ] as $feature): ?>
          <li><img src="<?= url('assets/icons/tick.svg') ?>" alt="" width="20" height="20"><?= e($feature) ?></li>
        <?php endforeach; ?>
      </ul>
      <div class="hero__buttons">
        <a class="btn btn-secondary" href="<?= url('index.php') ?>">Leave Enquiry</a>
        <a class="btn btn-primary" href="<?= url('contact.php') ?>">How to contact us?</a>
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
          <option value="immigration">Family Law & Property Settlement</option>
          <option value="visa">Commercial & Business Law</option>
          <option value="retail">Retail Lease Matter</option>
          <option value="professional">Professional Registration (AHPRA)</option>
          <option value="debt">Debt Recovery</option>
          <option value="immigration-visa">Immigration & Visa Matter</option>
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
<section class="content-width content-gapping split-section" data-aos="fade-up">
  <div class="split-section__text">
    <h2 class="secondary-header">About DM Legal Services</h2>
    <p class="body-text text-justify">Our professional team at DM Legal Services is committed to delivering exceptional
      legal support across all areas of law, ensuring each client receives the guidance, representation, and attention
      they deserve. We stay constantly updated on the latest legal developments and regulatory changes to prevent
      unnecessary delays and provide solutions that are both practical and effective. We work exclusively with fully
      accredited and highly experienced legal professionals who are recognised for their integrity, skill, and
      dedication to client success. Navigating the Australian legal system can be challenging, and our role is to
      simplify this process for you with personalised strategies, clear advice, and hands-on support to achieve the best
      possible outcome.</p>
  </div>
  <div class="split-section__media">
    <img src="<?= url('assets/images/AboutDMLegalService.jpeg') ?>" class="img-fill" alt="About DM Legal Services">
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
    <?php foreach ($legalServicesData as $idx => $service):
      $slug = slugify($service['title']); ?>
      <div class="card-law" data-aos="fade-up" data-aos-delay="<?= $idx * 100 ?>">
        <div class="card-law__media">
          <a href="<?= url('practice-area.php?slug=' . $slug) ?>">
            <img src="<?= url($service['image']) ?>" alt="<?= e($service['title']) ?>" loading="lazy" decoding="async">
          </a>
        </div>
        <div class="card-law__body">
          <div>
            <h3><?= e($service['title']) ?></h3>
            <p><?= e(truncate_words($service['description'], 12)) ?></p>
          </div>
          <a class="card-law__link" href="<?= url('practice-area.php?slug=' . $slug) ?>">Read more &rsaquo;</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="hero__buttons btn-row--center-md" data-aos="fade-up">
    <a class="btn btn-secondary" href="tel:<?= e(SITE_PHONE_TEL) ?>"><?= e(SITE_PHONE_DISPLAY) ?></a>
    <a class="btn btn-primary" href="<?= url('book-your-lawyer.php') ?>">Book a Consultation</a>
  </div>
</section>

<!-- ============ ATTRACTION CONTACT ============ -->
<section class="attraction-contact" data-aos="fade-up">
  <div class="content-width attraction-contact__row">
    <h2 class="main-header attraction-contact__title">Limited slots available &mdash; Book your consultation now</h2>
    <div class="attraction-contact__intro">
      <p class="measure-sm">You can choose any format of consultation with our lawyer:</p>
      <a class="btn btn-primary btn-consult-up" href="<?= url('book-your-lawyer.php') ?>">Book a Consultationup</a>

      <div class="attraction-contact__options">
        <?php foreach ($options as $option): ?>
          <div class="attraction-contact__option">
            <img src="<?= url($option['icon']) ?>" alt="">
            <p><?= e($option['label']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
      <a class="btn btn-primary btn-consult" href="<?= url('book-your-lawyer.php') ?>">Book a Consultation</a>
    </div>
  </div>
</section>

<!-- ============ EXPRESSION SECTION ============ -->
<section class="content-width content-gapping split-section" data-aos="fade-up">
  <div class="split-section__text">
    <h2 class="secondary-header text-center">Expert Guidance from Accredited Legal Professionals</h2>
    <div class="text-stack">
      <p class="body-text text-justify">At DM Legal Services, we understand that successfully navigating
        Australia&rsquo;s legal and immigration systems requires far more than general knowledge. It demands an in-depth
        understanding of complex regulations, procedural requirements, and evolving legal frameworks.</p>
      <p class="body-text text-justify">We recognise that every client&rsquo;s situation is unique. That is why we
        provide tailored advice and bespoke strategies designed to address the specific needs of each client, ensuring
        they are fully informed, confident, and strategically positioned to achieve their goals.</p>
      <p class="body-text text-justify">Our comprehensive services cover a wide range of visa and immigration matters,
        including family visas, student visas, business visas, temporary work visas, general skilled migration visas,
        and working holiday visas.</p>
      <p class="body-text text-justify">With DM Legal Services, you can be confident that every aspect of your journey
        is guided by accredited professionals who prioritise your success and streamline complex processes.</p>
    </div>
  </div>
  <div class="split-section__media">
    <img src="<?= url('assets/images/expert-euidance1.png') ?>"
      alt="Expert guidance from accredited legal professionals" loading="lazy" decoding="async">
  </div>
</section>

<!-- ============ WHY CHOOSE US ============ -->
<section class="content-width content-gapping">
  <div class="section-heading" data-aos="fade-up">
    <h2 class="secondary-header">Why To Choose Us</h2>
    <p class="body-text">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and
      support in matters related to divorce, child custody, spousal support, and more.</p>
  </div>
  <div class="stats-grid">
    <?php foreach ($statsData as $i => $stat): ?>
      <div class="stat-item" data-aos="zoom-in" data-aos-delay="<?= $i * 150 ?>">
        <h3><?= e($stat['value']) ?></h3>
        <p><?= e($stat['label']) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="services-row" data-aos="fade-up" data-aos-delay="200">
    <?php foreach ($serviceData as $service): ?>
      <div class="card-service">
        <div class="card-service__icon"><img src="<?= url($service['image']) ?>" alt=""></div>
        <h3><?= e($service['title']) ?></h3>
        <p><?= e($service['description']) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ============ AFFILIATIONS ============ -->
<section class="affiliation-section content-gapping" data-aos="fade-up">
  <h2 class="secondary-header">Our Affiliations &amp; Membership</h2>
  <p class="body-text">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and
    support in matters related to divorce, child custody, spousal support, and more.</p>
  <div class="affiliation-logos">
    <?php foreach ($affiliations as $item): ?>
      <div class="affiliation-logos__item" data-aos="zoom-in" data-aos-delay="<?= $item['id'] * 100 ?>">
        <img src="<?= url($item['image']) ?>" alt="<?= e($item['alt']) ?>" loading="lazy" decoding="async">
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ============ GET SUPPORT ============ -->
<section class="content-width content-gapping text-center" data-aos="fade-up">
  <h2 class="secondary-header">Professional Legal Support</h2>
  <div class="split-section">
    <div class="text-stack text-justify">
      <p class="body-text">Our professional team at DM Legal Services is committed to delivering exceptional legal
        support across all areas of law, ensuring each client receives the guidance, representation, and attention they
        deserve.</p>
      <p class="body-text">We work exclusively with fully accredited and highly experienced legal professionals who are
        recognised for their integrity, skill, and dedication to client success.</p>
      <p class="body-text">Navigating the Australian legal system can be challenging. Our role is to simplify this
        process for you by offering personalised strategies, clear advice, and hands-on support.</p>
      <ul class="feature-check-list">
        <?php foreach (['Business Law', 'Commercial Law', 'Criminal Law', 'Family Law', 'Debt Recovery', 'Immigration Law'] as $feature): ?>
          <li><img src="<?= url('assets/icons/check.svg') ?>" alt=""><span><?= e($feature) ?></span></li>
        <?php endforeach; ?>
      </ul>
      <p class="body-text">Our commitment to professional excellence and attention to detail ensures that every client
        receives thorough guidance, effective representation, and the confidence to navigate their legal matters
        successfully.</p>
    </div>
    <div class="split-section__media">
      <img src="<?= url('assets/images/ProfessionalLegalSupport.jpg') ?>" alt="Professional legal support"
        loading="lazy" decoding="async">
    </div>
  </div>
</section>


<!-- ============ HOW WE WORK ============ -->
<section class="content-width content-gapping text-center">
  <div data-aos="fade-up">
    <h2 class="secondary-header">How We Work</h2>
    <p class="body-text section-lead">Our team of experienced family lawyers is dedicated to providing comprehensive
      assistance and support in matters related to divorce, child custody, spousal support, and more.</p>
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
            <div class="step-arrow-down"><img src="<?= url('assets/icons/arrow-down.svg') ?>" alt="" width="30" height="30">
            </div>
            <div class="step-arrow-right"><img src="<?= url('assets/icons/arrow.svg') ?>" alt="" width="80" height="60">
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ NEWS CAROUSEL ============ -->
<section class="content-width content-gapping">
  <div class="section-heading" data-aos="fade-up">
    <h2 class="secondary-header">How We Handle Your Problem</h2>
    <p class="body-text">Our team of experienced family lawyers is dedicated to providing comprehensive assistance and
      support in matters related to divorce, child custody, spousal support, and more.</p>
  </div>
  <div class="carousel carousel--full" data-autoplay="5000" data-aos="zoom-out-up">
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
  <div class="text-center mt-4">
    <a class="btn btn-primary" href="<?= url('blogs.php') ?>">View All</a>
  </div>
</section>

<!-- ============ LATEST BLOGS ============ -->
<section class="content-width content-gapping" data-aos="fade-up">
  <h2 class="secondary-header text-center">Our Latest Blogs</h2>
  <p class="body-text text-center section-lead--tight">Our team of experienced family lawyers is dedicated to providing
    comprehensive assistance and support in matters related to divorce, child custody, spousal.</p>
  <div class="blog-grid">
    <?php foreach (array_slice($blogs, 0, 3) as $blog):
      $slug = slugify($blog['title']); ?>
      <div class="card-blog">
        <div class="card-blog__media">
          <a href="<?= url('blog-detail.php?slug=' . $slug) ?>"><img src="<?= url($blog['image']) ?>"
              alt="<?= e($blog['title']) ?>" loading="lazy" decoding="async"></a>
        </div>
        <div class="card-blog__meta">
          <div class="card-blog__author">
            <img src="<?= url($blog['author']['avatar']) ?>" alt="">
            <div>
              <p><?= e($blog['author']['name']) ?></p>
              <p><?= e($blog['author']['date']) ?></p>
            </div>
          </div>
          <div class="card-blog__tags">
            <?php foreach ($blog['tags'] as $tag): ?><span><?= e($tag) ?></span><?php endforeach; ?>
          </div>
        </div>
        <h3><?= e($blog['title']) ?></h3>
        <p class="excerpt"><?= e(truncate_words($blog['excerpt'], 20)) ?></p>
        <div class="card-blog__link"><a href="<?= url('blog-detail.php?slug=' . $slug) ?>">More Info &rsaquo;</a></div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="text-center mt-4">
    <a class="btn btn-primary" href="<?= url('blogs.php') ?>">View All</a>
  </div>
</section>

<!-- ============ FAQ ============ -->
<section class="content-width content-gapping">
  <h2 class="secondary-header text-center">Frequently Asked Questions</h2>
  <p class="body-text text-center section-lead--tight">Our team of experienced family lawyers is dedicated to providing
    comprehensive assistance and support in matters related to divorce, child custody, spousal.</p>
  <div class="faq-list" data-faq-list>
    <?php foreach ($consultationCostFAQ as $faq): ?>
      <div class="faq-item">
        <div class="faq-item__head">
          <h3><?= e($faq['question']) ?></h3>
          <span class="faq-item__icon" aria-hidden="true"><svg viewBox="0 0 448 512"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg></span>
        </div>
        <div class="faq-item__panel">
          <p class="body-text"><?= e($faq['answer']) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="faq-cta">
    <div class="faq-cta__avatars">
      <img src="<?= url('assets/images/avatar1.png') ?>" alt="">
      <img src="<?= url('assets/images/avatar2.png') ?>" alt="">
      <img src="<?= url('assets/images/avatar3.png') ?>" alt="">
    </div>
    <h3>Direct Connect With Us</h3>
    <p>Can&rsquo;t find the answer you&rsquo;re looking for? Please chat to our friendly team.</p>
    <a class="btn btn-primary" href="<?= url('contact.php') ?>">Contact Us</a>
  </div>
</section>







<?php include 'footer.php' ?>
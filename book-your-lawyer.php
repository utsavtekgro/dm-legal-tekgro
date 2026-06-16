<?php
/**
 * Book a Lawyer page — converted from src/app/book-your-lawyer/page.tsx,
 * StepForm.tsx, StepOne.tsx, StepTwo.tsx, StepThree.tsx, ContactInfo.tsx.
 */
require_once __DIR__ . '/includes/config.php';

$pageTitle = 'Book a Consultation | DM Legal';
$pageDescription = 'Book a consultation with DM Legal Services in three simple steps.';
include __DIR__ . '/includes/head.php';
?>

<div class="content-width content-gapping" style="margin-top:10rem;">
  <div class="booking-grid">
    <div class="booking-contact">
      <div class="booking-contact__box">
        <h2>Contacts</h2>
        <div class="booking-contact__row">
          <img src="<?= url('assets/icons/map.svg') ?>" alt="">
          <div>
            <p><?= e($contactData['title']) ?></p>
            <p><?= e($contactData['address']) ?></p>
          </div>
        </div>
        <p>Telephone: <a href="tel:<?= e($contactData['telephone']) ?>"><?= e($contactData['telephone']) ?></a></p>
        <p>Office hour mobile: <a href="tel:<?= e($contactData['officeMobile']) ?>"><?= e($contactData['officeMobile']) ?></a></p>
        <p>Email: <a href="mailto:<?= e($contactData['email']) ?>"><?= e($contactData['email']) ?></a></p>
        <p>Office hour: <strong><?= e($contactData['officeHour']) ?></strong></p>
      </div>
      <div class="booking-steps">
        <h2 class="tag">Information</h2>
        <h2 class="sub-heading">How it works?</h2>
        <ol>
          <?php foreach ($stepsData as $step): ?>
            <li><img src="<?= url('assets/icons/point-tick.svg') ?>" alt=""><p><?= e($step['title']) ?></p></li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>

    <div class="booking-form-panel">
      <form data-booking-form data-ajax-form action="<?= url('api/booking.php') ?>" novalidate>
        <?= csrf_field() ?>
        <input type="text" class="honeypot" name="website" tabindex="-1" autocomplete="off">
        <input type="hidden" name="date">

        <!-- STEP 1: Date -->
        <div data-step-panel="1" class="step-panel is-active text-center">
          <h2 class="secondary-header">Get In Touch</h2>
          <p class="body-text">Every situation is unique. Speak to a qualified legal expert</p>
          <div class="step-progress">
            <span class="step-progress__dot is-active" data-step-dot="1">1</span>
            <span class="step-progress__bar"></span>
            <span class="step-progress__dot" data-step-dot="2">2</span>
            <span class="step-progress__bar"></span>
            <span class="step-progress__dot" data-step-dot="3">3</span>
          </div>
          <div class="calendar__panel calendar" data-calendar>
            <p class="label">Find a time to meet with DM Legal</p>
            <div class="calendar__head">
              <button type="button" data-calendar-prev aria-label="Previous month">&lsaquo;</button>
              <span data-calendar-month></span>
              <button type="button" data-calendar-next aria-label="Next month">&rsaquo;</button>
            </div>
            <div class="calendar__grid" data-calendar-grid></div>
          </div>
          <button type="button" class="btn btn-primary btn-full" data-step-next>Next</button>
        </div>

        <!-- STEP 2: Contact & case details -->
        <div data-step-panel="2" class="step-panel">
          <h2 class="secondary-header text-center">Contact &amp; Case Details</h2>
          <p class="body-text text-center">Every situation is unique. Speak to a qualified legal expert</p>
          <div class="step-progress">
            <span class="step-progress__dot is-active" data-step-dot="1">1</span>
            <span class="step-progress__bar"></span>
            <span class="step-progress__dot" data-step-dot="2">2</span>
            <span class="step-progress__bar"></span>
            <span class="step-progress__dot" data-step-dot="3">3</span>
          </div>
          <label class="form-label" for="bk-name">Full Name *</label>
          <input class="form-control" id="bk-name" type="text" name="fullName" placeholder="Enter Full Name" required>

          <label class="form-label" for="bk-email">Email *</label>
          <input class="form-control" id="bk-email" type="email" name="email" placeholder="Example@gmail.com" required>

          <label class="form-label" for="bk-phone">Phone Number *</label>
          <input class="form-control" id="bk-phone" type="tel" name="phone" placeholder="Enter Phone Number" required pattern="^[0-9+()\-\s]{6,20}$">

          <label class="form-label" for="bk-matter">Type of Matter *</label>
          <select class="form-control" id="bk-matter" name="matterType" required>
            <option value="">Select Matter</option>
            <option value="immigration">Immigration Law</option>
            <option value="family">Family Law</option>
            <option value="business">Business Law</option>
            <option value="property">Property Law</option>
          </select>

          <button type="button" class="btn btn-primary btn-full mt-4" data-step-next>Next</button>
          <button type="button" class="btn btn-secondary btn-full mt-2" data-step-prev>Previous</button>
        </div>

        <!-- STEP 3: Case summary & contact preference -->
        <div data-step-panel="3" class="step-panel text-center">
          <h2 class="secondary-header">Case Summary &amp; Contact</h2>
          <p class="body-text">Every situation is unique. Speak to a qualified legal expert</p>
          <div class="step-progress">
            <span class="step-progress__dot is-active" data-step-dot="1">1</span>
            <span class="step-progress__bar"></span>
            <span class="step-progress__dot is-active" data-step-dot="2">2</span>
            <span class="step-progress__bar"></span>
            <span class="step-progress__dot" data-step-dot="3">3</span>
          </div>
          <div class="booking-summary">
            <p><strong>Date:</strong> <span data-summary-date>Not selected</span></p>
          </div>

          <label class="form-label" style="text-align:left;" for="bk-desc">Brief Description of Your Situation *</label>
          <textarea class="form-control" id="bk-desc" name="description" placeholder="Write brief description" rows="4" required></textarea>

          <label class="form-label" style="text-align:left;" for="bk-contact-method">Preferred Contact Method *</label>
          <select class="form-control" id="bk-contact-method" name="contactMethod" required>
            <option value="">Select Preferred Contact</option>
            <option value="phone">Phone</option>
            <option value="email">Email</option>
            <option value="whatsapp">WhatsApp</option>
          </select>

          <label class="form-label" style="text-align:left;" for="bk-contact-time">Preferred Time for Contact *</label>
          <input class="form-control" id="bk-contact-time" type="time" name="contactTime" required>

          <p class="form-success" data-form-message hidden></p>
          <button type="submit" class="btn btn-primary btn-full mt-4">Submit</button>
          <button type="button" class="btn btn-secondary btn-full mt-2" data-step-prev>Previous</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
$pageScripts = ['assets/js/booking-form.js'];
include __DIR__ . '/includes/foot.php';

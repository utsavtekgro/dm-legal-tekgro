<?php
/**
 * Secondary contact/map CTA shown above the footer on every page except Contact.
 * Converted from src/components/ui/ContactFooter.tsx
 */
?>
<section class="page-section content-width contact-cta" aria-labelledby="contact-cta-heading">
  <div class="contact-cta__card">
    <h2 id="contact-cta-heading" class="sub-heading">DM Legal Services</h2>
    <address>
      <p><strong>Address:</strong> <?= e(SITE_ADDRESS_SHORT) ?></p>
      <p><strong>Email:</strong> <a href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a></p>
      <p><strong>Phone:</strong> <a href="tel:<?= e(SITE_PHONE_TEL) ?>"><?= e(SITE_PHONE_DISPLAY) ?></a></p>
      <p><strong>Business Hours:</strong> Mon&ndash;Fri: 8:30 AM &ndash; 5:30 PM (Sat&ndash;Sun: Closed)</p>
    </address>
    <div class="form-grid-2">
      <a class="btn btn-secondary" href="<?= e(SITE_MAPS_URL) ?>" target="_blank" rel="noopener noreferrer">Get Directions</a>
      <a class="btn btn-primary" href="<?= url('contact.php') ?>">Check all contacts</a>
    </div>
  </div>
  <div class="contact-cta__map">
    <iframe class="map-frame" title="DM Legal Services location on Google Maps"
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3312.4862707465377!2d151.20414677653508!3d-33.87712821949169!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12afb2e5d60f5d%3A0xdf1da4954cb773cf!2sDM%20Legal%20Sydney!5e0!3m2!1sen!2snp!4v1758097950018!5m2!1sen!2snp"
      loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
  </div>
</section>

<?php
/**
 * Reusable hero section — converted from src/components/sections/home/Hero.tsx
 * Expects the calling page to set:
 *   $heroTitle, $heroSubtitle, $heroFeatures (array of strings),
 *   $heroPrimaryBtn ['text'=>,'href'=>], $heroSecondaryBtn ['text'=>,'href'=>],
 *   $heroRightSide 'form'|'image'|'none', $heroImage (path, when rightSide=image),
 *   $heroBreadcrumb (array of ['label','href']; omit/empty to hide, as on home page)
 */
$heroFeatures = $heroFeatures ?? [];
$heroRightSide = $heroRightSide ?? 'none';
$heroBreadcrumb = $heroBreadcrumb ?? [];
$heroMinimal = $heroMinimal ?? false; // mirrors showHeaderAndBreadcrumb in Hero.tsx: title + breadcrumb only
?>
<div class="hero">
  <div class="content-width hero__inner<?= $heroRightSide === 'image' ? ' hero__inner--image' : '' ?>">
    <div class="hero__content">
      <?php render_breadcrumb($heroBreadcrumb); ?>
      <h1 class="main-header"><?= e($heroTitle) ?></h1>
      <?php if (!$heroMinimal): ?>
      <p class="body-text lg:text-lg"><?= e($heroSubtitle) ?></p>
      <?php if ($heroFeatures): ?>
        <ul class="hero__features">
          <?php foreach ($heroFeatures as $feature): ?>
            <li><img src="<?= url('assets/icons/tick.svg') ?>" alt="" width="20" height="20"><?= e($feature) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <div class="hero__buttons">
        <?php if (!empty($heroSecondaryBtn)): ?>
          <a class="btn btn-secondary" href="<?= url($heroSecondaryBtn['href']) ?>"><?= e($heroSecondaryBtn['text']) ?></a>
        <?php endif; ?>
        <?php if (!empty($heroPrimaryBtn)): ?>
          <a class="btn btn-primary" href="<?= url($heroPrimaryBtn['href']) ?>"><?= e($heroPrimaryBtn['text']) ?></a>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>

    <?php if ($heroMinimal): /* image/form aside suppressed in minimal mode */ ?>
    <?php elseif ($heroRightSide === 'form'): ?>
      <div class="hero__aside">
        <form class="hero-form" data-ajax-form novalidate>
          <h2 class="sub-heading">Get In Touch Instantly</h2>
          <input type="text" class="honeypot" name="website" tabindex="-1" autocomplete="off">
          <input class="form-control" type="text" name="name" placeholder="Full Name" aria-label="Full Name" required>
          <div class="form-row">
            <input class="form-control" type="email" name="email" placeholder="Enter Your Email" aria-label="Email address" required>
            <input class="form-control" type="tel" name="phone" placeholder="Mobile Number" aria-label="Mobile number" required pattern="^[0-9+()\-\s]{6,20}$">
          </div>
          <select class="form-control" name="matterType" aria-label="Matter type" required>
            <option value="">Select Matter Type</option>
            <option value="immigration">Immigration</option>
            <option value="visa">Visa</option>
            <option value="legal">Legal</option>
            <option value="other">Other</option>
          </select>
          <textarea class="form-control" name="message" placeholder="Any Extra Message (optional)" aria-label="Additional message (optional)" rows="3"></textarea>
          <p class="form-success" data-form-message hidden></p>
          <button type="submit" class="btn btn-primary btn-full">Book Free Consultation</button>
        </form>
      </div>
    <?php elseif ($heroRightSide === 'image' && !empty($heroImage)): ?>
      <div class="hero__aside">
        <img src="<?= url($heroImage) ?>" alt="">
      </div>
    <?php endif; ?>
  </div>
</div>

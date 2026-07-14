<?php
/**
 * Shared renderer for Privacy Policy / Terms & Conditions / Disclaimer.
 * Converted from src/components/sections/legal-section/LegalSection.tsx
 * Expects $legalPageTitle and $legalSections to be set by the including page.
 */
?>
<div class="content-width content-gapping legal-section offset-top-lg">
  <h1 class="main-header text-center mb-4"><?= e($legalPageTitle) ?></h1>
  <?php foreach ($legalSections as $section): ?>
    <section>
      <h2><?= e($section['title']) ?></h2>
      <?php render_markdown_lite($section['content']) ?>
    </section>
  <?php endforeach; ?>
</div>

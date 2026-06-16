<?php
/** Terms & Conditions page — converted from src/app/terms&conditions/page.tsx */
require_once __DIR__ . '/includes/config.php';

$pageTitle = 'Terms & Conditions | DM Legal';
$pageDescription = 'The terms and conditions governing use of the DM Legal Services website and services.';
include __DIR__ . '/includes/head.php';

$legalPageTitle = 'Terms & Conditions';
$legalSections = $termsAndConditions;
include __DIR__ . '/includes/legal-page-template.php';

include __DIR__ . '/includes/foot.php';

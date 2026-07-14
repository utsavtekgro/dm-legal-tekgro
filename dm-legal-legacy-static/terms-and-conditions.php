<?php
/** Terms & Conditions page — converted from src/app/terms&conditions/page.tsx */
require_once 'includes/functions.php';

$pageTitle = 'Terms & Conditions | DM Legal';
$pageDescription = 'The terms and conditions governing use of the DM Legal Services website and services.';
include 'header.php';

$legalPageTitle = 'Terms & Conditions';
$legalSections = $termsAndConditions;
include 'includes/legal-page-template.php';

include 'footer.php';

<?php
/** Privacy Policy page — converted from src/app/privacy-policy/page.tsx */
require_once 'includes/functions.php';

$pageTitle = 'Privacy Policy | DM Legal';
$pageDescription = 'How DM Legal Services collects, uses, and protects your personal information.';
include 'header.php';

$legalPageTitle = 'Privacy Policy';
$legalSections = $privacyPolicy;
include 'includes/legal-page-template.php';

include 'footer.php';

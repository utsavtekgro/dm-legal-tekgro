<?php
/** Privacy Policy page — converted from src/app/privacy-policy/page.tsx */
require_once __DIR__ . '/includes/config.php';

$pageTitle = 'Privacy Policy | DM Legal';
$pageDescription = 'How DM Legal Services collects, uses, and protects your personal information.';
include __DIR__ . '/includes/head.php';

$legalPageTitle = 'Privacy Policy';
$legalSections = $privacyPolicy;
include __DIR__ . '/includes/legal-page-template.php';

include __DIR__ . '/includes/foot.php';

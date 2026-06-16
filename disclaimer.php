<?php
/** Disclaimer page — converted from src/app/disclaimer/page.tsx */
require_once __DIR__ . '/includes/config.php';

$pageTitle = 'Disclaimer | DM Legal';
$pageDescription = 'Limitations and responsibilities relating to information and services provided by DM Legal Services.';
include __DIR__ . '/includes/head.php';

$legalPageTitle = 'Disclaimer';
$legalSections = $disclaimer;
include __DIR__ . '/includes/legal-page-template.php';

include __DIR__ . '/includes/foot.php';

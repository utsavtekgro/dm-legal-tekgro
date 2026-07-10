<?php
/** Disclaimer page — converted from src/app/disclaimer/page.tsx */
require_once 'includes/functions.php';

$pageTitle = 'Disclaimer | DM Legal';
$pageDescription = 'Limitations and responsibilities relating to information and services provided by DM Legal Services.';
include 'header.php';

$legalPageTitle = 'Disclaimer';
$legalSections = $disclaimer;
include 'includes/legal-page-template.php';

include 'footer.php';

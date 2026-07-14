<?php
/**
 * Disclaimer — ported from the legacy static disclaimer.php.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

global $disclaimer;
$legalPageTitle = 'Disclaimer';
$legalSections  = $disclaimer;
include DM_LEGAL_DIR . '/inc/parts/legal-page-template.php';

get_footer();

<?php
/**
 * Terms & Conditions — ported from the legacy static terms-and-conditions.php.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

global $termsAndConditions;
$legalPageTitle = 'Terms & Conditions';
$legalSections  = $termsAndConditions;
include DM_LEGAL_DIR . '/inc/parts/legal-page-template.php';

get_footer();

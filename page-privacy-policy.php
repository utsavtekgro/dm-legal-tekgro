<?php
/**
 * Privacy Policy — ported from the legacy static privacy-policy.php.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

global $privacyPolicy;
$legalPageTitle = 'Privacy Policy';
$legalSections  = $privacyPolicy;
include DM_LEGAL_DIR . '/inc/parts/legal-page-template.php';

get_footer();

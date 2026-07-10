<?php
/**
 * Global configuration: session/security setup, site constants, autoload of helpers + data.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        // 'secure' => true, // enable once served over HTTPS in production
    ]);
    session_start();
}

// Regenerate session id periodically to mitigate session fixation.
if (empty($_SESSION['created_at'])) {
    $_SESSION['created_at'] = time();
} elseif (time() - $_SESSION['created_at'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['created_at'] = time();
}

error_reporting(E_ALL);
ini_set('display_errors', '0'); // never leak errors to output in production
ini_set('log_errors', '1');

define('SITE_NAME', 'DM Legal');
define('SITE_TAGLINE', 'Expert legal advice and representation for your needs.');

/**
 * Auto-detect the base path so links/CSS/JS resolve correctly whether this
 * project is served from the web root (http://host/) or from a subfolder
 * (e.g. XAMPP's http://localhost/dm-legal-Project/). Falls back to ''
 * (site root) if DOCUMENT_ROOT isn't available.
 */
$projectRoot = str_replace('\\', '/', dirname(__DIR__));
$documentRoot = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? ''), '/');
$basePath = '';
if ($documentRoot !== '' && strpos($projectRoot, $documentRoot) === 0) {
    $basePath = substr($projectRoot, strlen($documentRoot));
}
define('BASE_URL', $basePath);
define('ASSETS_URL', BASE_URL . '/assets');

define('SITE_PHONE_DISPLAY', '0426 269 954');
define('SITE_PHONE_TEL', '+610426269954');
define('SITE_WHATSAPP', 'https://wa.me/+610426269954');
define('SITE_EMAIL', 'info@dmlegalservices.com.au');
define('SITE_ADDRESS_SHORT', 'Meriton Suites World Tower, Sydney');
define('SITE_MAPS_URL', 'https://maps.app.goo.gl/jhzb5NCbfToYvgmy5');

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/data.php';

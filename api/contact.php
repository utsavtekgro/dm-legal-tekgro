<?php
/**
 * Handles the hero/general contact form (ContactForm.tsx) and the FAQ
 * contact form on faqs.php. Returns JSON for the fetch()-based app.js
 * AJAX submit handler.
 */
require_once '../includes/config.php';

header('Content-Type: application/json; charset=utf-8');

function respond(bool $success, string $message, int $code = 200): void
{
    http_response_code($code);
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Invalid request method.', 405);
}

// Honeypot: bots that fill every field will trip this hidden field.
if (!empty($_POST['website'])) {
    respond(true, 'Thank you, we will be in touch shortly.'); // silently accept, do nothing
}

if (!verify_csrf($_POST['csrf_token'] ?? null)) {
    respond(false, 'Your session has expired. Please refresh the page and try again.', 403);
}

$name = clean_input($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = clean_input($_POST['phone'] ?? '');
$matterType = clean_input($_POST['matterType'] ?? '');
$subject = clean_input($_POST['subject'] ?? '');
$message = clean_input($_POST['message'] ?? '');

$errors = [];
if ($name === '' || mb_strlen($name) > 150) {
    $errors[] = 'Please provide a valid name.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address.';
}
if ($phone === '' || !preg_match('/^[0-9+()\-\s]{6,20}$/', $phone)) {
    $errors[] = 'Please provide a valid phone number.';
}
if (mb_strlen($message) > 5000 || mb_strlen($subject) > 200) {
    $errors[] = 'Your message is too long.';
}

if ($errors) {
    respond(false, implode(' ', $errors), 422);
}

$submission = [
    'date' => date('c'),
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'matter_type' => $matterType,
    'subject' => $subject,
    'message' => $message,
    'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
];

// Persist to a private log file (outside web root would be preferable in a
// real deployment; kept here for portability). No SMTP credentials were
// provided, so this stands in for an email/CRM integration — see README
// notes / migration report for wiring up real mail delivery.
$logFile = __DIR__ . '/../storage/contact-submissions.log';
if (!is_dir(dirname($logFile))) {
    mkdir(dirname($logFile), 0750, true);
}
file_put_contents($logFile, json_encode($submission) . PHP_EOL, FILE_APPEND | LOCK_EX);

// Optional: send a real email if the server has mail() configured.
$to = SITE_EMAIL;
$emailSubject = 'New enquiry from DM Legal website';
$body = "Name: $name\nEmail: $email\nPhone: $phone\nMatter type: $matterType\nSubject: $subject\nMessage:\n$message";
$headers = "From: no-reply@" . ($_SERVER['HTTP_HOST'] ?? 'dmlegalservices.com.au') . "\r\nReply-To: " . filter_var($email, FILTER_SANITIZE_EMAIL);
@mail($to, $emailSubject, $body, $headers);

respond(true, 'Thank you! Your message has been sent. Our team will contact you shortly.');

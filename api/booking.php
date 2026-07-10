<?php
/**
 * Handles the "Book a Lawyer" multi-step consultation form
 * (StepForm.tsx / StepOne.tsx / StepTwo.tsx / StepThree.tsx).
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

if (!empty($_POST['website'])) {
    respond(true, 'Your consultation request has been received.'); // honeypot
}

if (!verify_csrf($_POST['csrf_token'] ?? null)) {
    respond(false, 'Your session has expired. Please refresh the page and try again.', 403);
}

$date = clean_input($_POST['date'] ?? '');
$fullName = clean_input($_POST['fullName'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = clean_input($_POST['phone'] ?? '');
$matterType = clean_input($_POST['matterType'] ?? '');
$description = clean_input($_POST['description'] ?? '');
$contactMethod = clean_input($_POST['contactMethod'] ?? '');
$contactTime = clean_input($_POST['contactTime'] ?? '');

$errors = [];
$dateObj = DateTime::createFromFormat('Y-m-d', $date);
$today = new DateTime('today');
if (!$dateObj || $dateObj < $today) {
    $errors[] = 'Please select a valid, upcoming consultation date.';
}
if ($fullName === '' || mb_strlen($fullName) > 150) {
    $errors[] = 'Please provide a valid name.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address.';
}
if ($phone === '' || !preg_match('/^[0-9+()\-\s]{6,20}$/', $phone)) {
    $errors[] = 'Please provide a valid phone number.';
}
$validMatterTypes = ['immigration', 'family', 'business', 'property'];
if (!in_array($matterType, $validMatterTypes, true)) {
    $errors[] = 'Please select a valid matter type.';
}
if ($description === '' || mb_strlen($description) > 3000) {
    $errors[] = 'Please provide a brief description (max 3000 characters).';
}
$validContactMethods = ['phone', 'email', 'whatsapp'];
if (!in_array($contactMethod, $validContactMethods, true)) {
    $errors[] = 'Please select a valid contact method.';
}
if (!preg_match('/^([01]\d|2[0-3]):([0-5]\d)$/', $contactTime)) {
    $errors[] = 'Please select a valid preferred contact time.';
}

if ($errors) {
    respond(false, implode(' ', $errors), 422);
}

$submission = [
    'date' => date('c'),
    'consultation_date' => $date,
    'full_name' => $fullName,
    'email' => $email,
    'phone' => $phone,
    'matter_type' => $matterType,
    'description' => $description,
    'contact_method' => $contactMethod,
    'contact_time' => $contactTime,
    'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
];

$logFile = __DIR__ . '/../storage/booking-submissions.log';
if (!is_dir(dirname($logFile))) {
    mkdir(dirname($logFile), 0750, true);
}
file_put_contents($logFile, json_encode($submission) . PHP_EOL, FILE_APPEND | LOCK_EX);

$to = SITE_EMAIL;
$subject = 'New consultation booking request';
$body = "Date: $date\nName: $fullName\nEmail: $email\nPhone: $phone\nMatter type: $matterType\nPreferred contact: $contactMethod at $contactTime\n\nDescription:\n$description";
$headers = "From: no-reply@" . ($_SERVER['HTTP_HOST'] ?? 'dmlegalservices.com.au') . "\r\nReply-To: " . filter_var($email, FILTER_SANITIZE_EMAIL);
@mail($to, $subject, $body, $headers);

respond(true, 'Thank you! Your consultation request has been booked. Our team will confirm shortly.');


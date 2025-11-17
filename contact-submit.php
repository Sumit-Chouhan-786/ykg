<?php
session_start();

// Rate limit
$ip = $_SERVER['REMOTE_ADDR'] ?? 'n/a';
if (!isset($_SESSION['last_submit_ts'])) $_SESSION['last_submit_ts'] = 0;
if (time() - $_SESSION['last_submit_ts'] < 20) {
  http_response_code(429);
  exit('Please wait a moment before resubmitting.');
}

// Honeypot
if (!empty($_POST['company'])) {
  exit('OK');
}

function f($k){ return trim($_POST[$k] ?? ''); }

$name = f('name');
$email = f('email');
$phone = f('phone');
$service = f('service');
$date = f('date');
$msg = f('message');

if(!$name || !$email || !$phone || !$service || !$date){
  http_response_code(400);
  exit('Missing required fields.');
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
  http_response_code(400);
  exit('Invalid email.');
}

// Attachment
$att = null;
if (!empty($_FILES['attachment']['name'])) {
  $allowed = ['application/pdf','image/jpeg','image/png'];
  $mime = mime_content_type($_FILES['attachment']['tmp_name']);
  $size = $_FILES['attachment']['size'];

  if (!in_array($mime, $allowed)) exit("Invalid file type");
  if ($size > 7*1024*1024) exit("File too large");

  $att = $_FILES['attachment'];
}

require __DIR__ . '/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);

try {
  $mail->isSMTP();
  $mail->Host = 'mail.cpaykg.ca';
  $mail->SMTPAuth = true;
  $mail->Username = 'info@cpaykg.ca';
  $mail->Password = 'Bharti@2005';  // <— PASSWORD INSERTED
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = 587;

  $mail->setFrom('info@cpaykg.ca', 'CPAYKG Website');
  $mail->addReplyTo($email, $name);
  $mail->addAddress('info@cpaykg.ca');

  $mail->Subject = "New Website Inquiry: $service — $name";

  $mail->Body =
    "Name: $name\n".
    "Email: $email\n".
    "Phone: $phone\n".
    "Service: $service\n".
    "Preferred Date: $date\n\n".
    "Message:\n$msg\n\n".
    "IP: $ip\n";

  if ($att) {
    $mail->addAttachment($att['tmp_name'], $att['name']);
  }

  $mail->send();
  $_SESSION['last_submit_ts'] = time();
  header('Location: /thank-you/');
  exit;

} catch (Exception $e) {
  http_response_code(500);
  exit('Email delivery failed — please email info@cpaykg.ca directly.');
}
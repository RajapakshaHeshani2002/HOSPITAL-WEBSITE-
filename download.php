<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php'); exit;
}

include 'db.php';

if(!isset($_GET['report_id'])) {
    http_response_code(400); exit('Missing report id.');
}

$report_id = intval($_GET['report_id']);

// fetch report record
$stmt = $pdo->prepare("SELECT * FROM medical_reports WHERE report_id = ?");
$stmt->execute([$report_id]);
$report = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$report) {
    http_response_code(404); exit('Report not found.');
}

// permission check: allow if logged-in user is the patient OR the doctor who uploaded OR admin (adjust roles)
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

$allowed = false;
if($user_role === 'patient' && $report['patient_id'] == $user_id) $allowed = true;
if($user_role === 'doctor' && $report['doctor_id'] == $user_id) $allowed = true;
if($user_role === 'admin') $allowed = true;

if(!$allowed) {
    http_response_code(403); exit('Access denied.');
}

// serve file
$upload_dir = __DIR__ . '/uploads/';
$filepath = $upload_dir . $report['stored_filename'];

if(!file_exists($filepath)) {
    http_response_code(404); exit('File missing on server.');
}

// send headers
header('Content-Description: File Transfer');
header('Content-Type: ' . ($report['file_mime'] ?? 'application/octet-stream'));
header('Content-Disposition: attachment; filename="' . basename($report['original_filename']) . '"');
header('Content-Length: ' . $report['file_size']);
header('Cache-Control: private, max-age=60');
readfile($filepath);
exit;

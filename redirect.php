<?php
// redirect.php
session_start();
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php'); exit;
}

$role = $_SESSION['role'];

switch($role) {
    case 'admin':
        header('Location: admin_dashboard.php'); break;
    case 'doctor':
        header('Location: doctor_dashboard.php'); break;
    case 'patient':
    default:
        header('Location: patient_dashboard.php'); break;
}
exit;

<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

if (!$email || !$password || !$role) {
    header('Location: login.html?error=Missing+fields&email=' . urlencode($email));
    exit;
}

/* ----- HARD-CODED ADMIN ----- */
if ($email === 'admin@gmail.com' && $password === 'admin123' && $role === 'admin') {
    session_regenerate_id(true);
    $_SESSION['user_id'] = 0;
    $_SESSION['user_name'] = 'Admin';
    $_SESSION['role'] = 'admin';
    header('Location: admin_dashboard.php');
    exit;
}

/* ----- REGULAR USERS ----- */
try {
    $stmt = $pdo->prepare("SELECT id, password, role, fullname FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    header('Location: login.html?error=Server+Error');
    exit;
}

if (!$user) {
    header('Location: login.html?error=Invalid+email+or+password&email=' . urlencode($email));
    exit;
}

if (!password_verify($password, $user['password'])) {
    header('Location: login.html?error=Invalid+email+or+password&email=' . urlencode($email));
    exit;
}

if ($role !== $user['role']) {
    header('Location: login.html?error=Selected+role+is+incorrect&email=' . urlencode($email));
    exit;
}

/* ----- LOGIN SUCCESS ----- */
session_regenerate_id(true);
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['fullname'];
$_SESSION['role'] = $user['role'];

switch ($role) {
    case 'doctor':
        header('Location: doctor_dashboard.php');
        break;
    case 'patient':
        header('Location: patient_dashboard.php');
        break;
    case 'admin':
        header('Location: admin_dashboard.php');
        break;
}
exit;
?>

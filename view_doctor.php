<?php
session_start();
require 'db.php';

// Admin-only protection
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: list_doctors.php"); // <-- Make sure quotes match
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM doctors WHERE id = ?");
$stmt->execute([$id]);
$d = $stmt->fetch();

if (!$d) {
    header("Location: list_doctors.php"); // <-- fixed quotes
    exit;
}
?>

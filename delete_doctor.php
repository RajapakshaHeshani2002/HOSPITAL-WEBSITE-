<?php
// delete_doctor.php
session_start();
require 'db.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { header('Location: login.php'); exit; }


$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: list_doctors.php'); exit; }


$del = $pdo->prepare("DELETE FROM doctors WHERE id = ?");
$del->execute([$id]);
header('Location: list_doctors.php');
exit;
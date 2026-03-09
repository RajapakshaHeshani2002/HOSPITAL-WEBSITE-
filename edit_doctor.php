<?php
session_start();
require 'db.php';

// Admin-only protection
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Get doctor ID
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: list_doctors.php');
    exit;
}

// Load doctor
$stmt = $pdo->prepare("SELECT * FROM doctors WHERE id = ?");
$stmt->execute([$id]);
$doctor = $stmt->fetch();

if (!$doctor) {
    header('Location: list_doctors.php');
    exit;
}

$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $specialization = trim($_POST['specialization'] ?? '');
    $qualifications = trim($_POST['qualifications'] ?? '');
    $years = intval($_POST['years_experience'] ?? 0);
    $clinic = trim($_POST['clinic_location'] ?? '');
    $fee = floatval($_POST['consultation_fee'] ?? 0);
    $availability = trim($_POST['availability_text'] ?? '');

    $stmt = $pdo->prepare("
        UPDATE doctors SET
        name = ?, 
        specialization = ?, 
        qualifications = ?, 
        years_experience = ?, 
        clinic_location = ?, 
        consultation_fee = ?, 
        availability_text = ?
        WHERE id = ?
    ");

    if ($stmt->execute([$name, $specialization, $qualifications, $years, $clinic, $fee, $availability, $id])) {
        $message = 'Doctor updated successfully.';
        // Reload updated doctor
        $stmt = $pdo->prepare("SELECT * FROM doctors WHERE id = ?");
        $stmt->execute([$id]);
        $doctor = $stmt->fetch();
    } else {
        $message = 'Error updating doctor.';
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Doctor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
    <h1>Edit Doctor</h1>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input class="form-control" name="name" required value="<?= htmlspecialchars($doctor['name'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Specialization</label>
            <input class="form-control" name="specialization" value="<?= htmlspecialchars($doctor['specialization'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Qualifications</label>
            <input class="form-control" name="qualifications" value="<?= htmlspecialchars($doctor['qualifications'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Years Experience</label>
            <input class="form-control" name="years_experience" type="number" min="0" value="<?= intval($doctor['years_experience'] ?? 0) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Clinic Location</label>
            <input class="form-control" name="clinic_location" value="<?= htmlspecialchars($doctor['clinic_location'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Consultation Fee</label>
            <input class="form-control" name="consultation_fee" type="number" step="0.01" value="<?= number_format($doctor['consultation_fee'] ?? 0, 2) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Availability (text)</label>
            <textarea class="form-control" name="availability_text" rows="4"><?= htmlspecialchars($doctor['availability_text'] ?? '') ?></textarea>
        </div>

        <button class="btn btn-primary" type="submit">Save Changes</button>
        <a class="btn btn-secondary" href="list_doctors.php">Back</a>
    </form>
</div>
</body>
</html>

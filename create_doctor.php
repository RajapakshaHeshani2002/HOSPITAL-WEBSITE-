<?php
// create_doctor.php
session_start();
require 'db.php';

// Admin-only protection (remove if you don't use sessions)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize inputs
    $name = trim($_POST['name'] ?? '');
    $specialization = trim($_POST['specialization'] ?? '');
    $qualifications = trim($_POST['qualifications'] ?? '');
    $years = intval($_POST['years_experience'] ?? 0);
    $clinic = trim($_POST['clinic_location'] ?? '');
    $fee = floatval($_POST['consultation_fee'] ?? 0);
    $availability = trim($_POST['availability_text'] ?? '');

    // Prepared statement to insert
    $stmt = $pdo->prepare("
        INSERT INTO doctors
        (name, specialization, qualifications, years_experience, clinic_location, consultation_fee, availability_text, rating_avg, rating_count)
        VALUES (?, ?, ?, ?, ?, ?, ?, 0.00, 0)
    ");

    if ($stmt->execute([$name, $specialization, $qualifications, $years, $clinic, $fee, $availability])) {
        $message = 'Doctor added successfully.';
    } else {
        $message = 'Error: could not add doctor.';
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Doctor</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
  <div class="container">
    <h1>Add Doctor</h1>

    <?php if ($message): ?>
      <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input class="form-control" name="name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Specialization</label>
        <input class="form-control" name="specialization" value="<?= htmlspecialchars($_POST['specialization'] ?? '') ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Qualifications</label>
        <input class="form-control" name="qualifications" value="<?= htmlspecialchars($_POST['qualifications'] ?? '') ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Years Experience</label>
        <input class="form-control" name="years_experience" type="number" min="0" value="<?= intval($_POST['years_experience'] ?? 0) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Clinic Location</label>
        <input class="form-control" name="clinic_location" value="<?= htmlspecialchars($_POST['clinic_location'] ?? '') ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Consultation Fee</label>
        <input class="form-control" name="consultation_fee" type="number" step="0.01" value="<?= htmlspecialchars($_POST['consultation_fee'] ?? '0.00') ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Availability (text)</label>
        <textarea class="form-control" name="availability_text" rows="4"><?= htmlspecialchars($_POST['availability_text'] ?? '') ?></textarea>
      </div>

      <button class="btn btn-primary" type="submit">Save Doctor</button>
      <a class="btn btn-secondary" href="list_doctors.php">Back</a>
    </form>
  </div>
</body>
</html>

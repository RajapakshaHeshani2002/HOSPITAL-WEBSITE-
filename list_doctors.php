<?php
// list_doctors.php
session_start();
require 'db.php';


// Admin-only protection
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
header('Location: login.php');
exit;
}


$stmt = $pdo->query("SELECT id, name, specialization, clinic_location, consultation_fee, rating_avg, rating_count FROM doctors ORDER BY name");
$doctors = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Doctors Management</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
<div class="d-flex justify-content-between align-items-center mb-3">
<h1>Doctors</h1>
<div>
<a class="btn btn-success" href="create_doctor.php">Add New Doctor</a>
<a class="btn btn-secondary" href="admin_dashboard.php">Back to Admin</a>
</div>
</div>


<div class="table-responsive">
<table class="table table-bordered table-hover">
<thead class="table-light">
<tr>
<th>Name</th>
<th>Specialization</th>
<th>Clinic</th>
<th>Fee</th>
<th>Rating</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php if (count($doctors) === 0): ?>
<tr><td colspan="6" class="text-center">No doctors found.</td></tr>
<?php endif; ?>


<?php foreach ($doctors as $d): ?>
<tr>
<td><?= htmlspecialchars($d['name'] ?? '') ?></td>
<td><?= htmlspecialchars($d['specialization'] ?? '') ?></td>
<td><?= htmlspecialchars($d['clinic_location'] ?? '') ?></td>
<td><?= number_format($d['consultation_fee'] ?? 0, 2) ?></td>
<td><?= number_format($d['rating_avg'] ?? 0, 2) ?> (<?= intval($d['rating_count'] ?? 0) ?>)</td>
<td>
<a class="btn btn-sm btn-primary" href="view_doctor.php?id=<?= $d['id'] ?>">View</a>


<a class="btn btn-sm btn-warning" href="edit_doctor.php?id=<?= $d['id'] ?>">Edit</a>
<a class="btn btn-sm btn-danger" href="delete_doctor.php?id=<?= $d['id'] ?>" onclick="return confirm('Delete this doctor?')">Delete</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</body>
</html>
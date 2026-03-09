<?php
include 'db.php';

// Fetch doctors from database
$stmt = $pdo->query("SELECT * FROM doctors ORDER BY id DESC");
$doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Profiles | MediCare Plus</title>
  <link rel="stylesheet" href="css/doctor-profiles.css">
</head>
<body>

<header class="main-header">
  <div class="logo">MediCare Plus</div>
  <nav>
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="doctor-search.php">Doctor Search</a></li>
      <li><a href="doctor-profiles.php" class="active">Doctor Profiles</a></li>
      <li><a href="contact.html">Contact</a></li>
    </ul>
  </nav>
</header>

<section class="hero">
  <div class="hero-content">
    <h1>Our Expert Doctors</h1>
    <p>View details of our qualified doctors, schedules, fees, and availability.</p>
  </div>
</section>

<section class="profiles">
  <div class="container">

    <?php foreach($doctors as $d): ?>
      <div class="doctor-card">

        <img src="<?= htmlspecialchars($d['image_url']) ?>" 
             alt="<?= htmlspecialchars($d['name']) ?>">

        <div class="doc-info">
          <h3><?= htmlspecialchars($d['name']) ?></h3>
          <p>🩺 <?= htmlspecialchars($d['specialization']) ?></p>

          <div class="details">
            <p><strong>Consultation Charges:</strong> LKR <?= number_format($d['fee']) ?></p>
            <p><strong>Availability:</strong> <?= htmlspecialchars($d['availability']) ?></p>
            <p><strong>Schedule:</strong> <?= htmlspecialchars($d['schedule']) ?></p>
            <p><strong>Bio:</strong> <?= nl2br(htmlspecialchars($d['bio'])) ?></p>
          </div>

          <a href="book-appointment.html?doctor=<?= $d['id'] ?>" class="btn">Book Appointment</a>
        </div>

      </div>
    <?php endforeach; ?>

    <?php if(count($doctors) == 0): ?>
      <p class="no-data">No doctors added yet.</p>
    <?php endif; ?>

  </div>
</section>

<footer class="footer">
  <p>© 2025 MediCare Plus | All Rights Reserved</p>
</footer>

</body>
</html>

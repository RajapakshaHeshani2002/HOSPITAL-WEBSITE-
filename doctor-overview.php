<?php
// doctor-overview.php
require 'db.php'; // Make sure this path is correct
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Profiles – Overview | MediCare Plus</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { padding-top: 70px; }
    .doctor-card { border: 1px solid #bc2a2aff; border-radius: 10px; padding: 15px; margin-bottom: 20px; display: flex; gap: 15px; }
    .doctor-card img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; }
    .doc-info h3 { margin-top: 0; }
    .btn { margin-top: 10px; }
    .main-header { position: fixed; top:0; width: 100%; background: #0077b6; color: #f0e8e8ff; padding: 10px 20px; z-index: 999; display: flex; justify-content: space-between; align-items: center; }
    .main-header .logo { font-weight: bold; font-size: 1.2em; }
    .main-header nav ul { list-style: none; margin:0; padding:0; display: flex; gap: 15px; }
    .main-header nav ul li a { color:#f0e8e8ff; text-decoration: none; }
    .footer { text-align: center; padding: 20px; margin-top: 30px; background: #0077b6; }
  </style>
</head>
<body>

  <!-- Header -->
  <header class="main-header">
    <div class="logo">MediCare Plus</div>
    <nav>
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="doctor-search.html">Doctor Search</a></li>
        <li><a href="doctor-overview.php">Doctor Profiles</a></li>
        <li><a href="contact.html">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="hero text-center py-5 bg-light">
    <div class="container">
      <h1>Doctor Profiles – Overview</h1>
      <p>Meet our expert doctors and get an insight into their specialization, experience, and services.</p>
    </div>
  </section>

  <!-- Doctor Overview Section -->
  <section class="profiles py-4">
    <div class="container">
      <?php
      $stmt = $pdo->query("SELECT * FROM doctors ORDER BY name");
      $doctors = $stmt->fetchAll();

      if (!$doctors) {
        echo "<p class='text-center'>No doctors available at the moment.</p>";
      } else {
        foreach($doctors as $d):
      ?>
        <div class="doctor-card">
         <img src="<?= htmlspecialchars($d['photo_url'] ?? 'https://static.vecteezy.com/system/resources/previews/018/765/757/original/user-profile-icon-in-flat-style-member-avatar-illustration-on-isolated-background-human-permission-sign-business-concept-vector.jpg') ?>" alt="Dr. <?= htmlspecialchars($d['name']) ?>">

          <div class="doc-info">
            <h3>Dr. <?= htmlspecialchars($d['name']) ?></h3>
            <p>🩺 <?= htmlspecialchars($d['specialization']) ?> | <?= htmlspecialchars($d['clinic_location']) ?></p>
            <p>Qualifications: <?= htmlspecialchars($d['qualifications']) ?></p>
            <p>Experience: <?= intval($d['years_experience']) ?> Years</p>
            <p>Consultation Charges: LKR <?= number_format($d['consultation_fee'],2) ?> per visit</p>
            <p>Availability: <?= nl2br(htmlspecialchars($d['availability_text'])) ?></p>
            <a href="book-appointment.html?doctor_id=<?= $d['id'] ?>" class="btn btn-primary">Book Appointment</a>
          </div>
        </div>
      <?php endforeach; } ?>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <p>© 2025 MediCare Plus | All Rights Reserved</p>
  </footer>

</body>
</html>

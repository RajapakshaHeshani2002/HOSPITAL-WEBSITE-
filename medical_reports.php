<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient'){
    header('Location: login.php'); exit;
}
include 'db.php';

$patient_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM medical_reports WHERE patient_id = ? ORDER BY uploaded_at DESC");
$stmt->execute([$patient_id]);
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

$grouped = ['lab'=>[], 'visit_summary'=>[], 'prescription'=>[]];
foreach($reports as $r) {
    $grouped[$r['report_type']][] = $r;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Medical Reports | MediCare Plus</title>

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f5f7fa;
    }
    /* Header */
    .main-header {
      display: flex;
      justify-content: space-between;
      padding: 15px 40px;
      background: #1977cc;
      color: white;
      align-items: center;
    }
    .main-header .logo {
      font-size: 26px;
      font-weight: bold;
    }
    .navbar ul {
      list-style: none;
      display: flex;
      gap: 20px;
    }
    .navbar ul li a {
      color: white;
      text-decoration: none;
      font-size: 16px;
      padding: 8px 14px;
      border-radius: 6px;
    }
    .navbar ul li a.active,
    .navbar ul li a:hover {
      background: white;
      color: #1977cc;
    }

    /* Hero */
    .hero {
      display: flex;
      justify-content: space-between;
      padding: 40px;
      background: white;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
      margin-bottom: 30px;
    }
    .hero h1 {
      font-size: 38px;
      color: #1977cc;
    }
    .hero p {
      font-size: 18px;
      color: #333;
    }
    .hero img {
      width: 420px;
      border-radius: 10px;
      object-fit: cover;
    }

    /* Reports Section */
    .reports-section {
      padding: 40px;
    }
    .reports-section h2 {
      font-size: 28px;
      margin-bottom: 25px;
      color: #1977cc;
    }

    .report-box {
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      margin-bottom: 30px;
    }

    .report-header {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 15px;
    }
    .report-header img {
      width: 90px;
      height: 70px;
      border-radius: 8px;
      object-fit: cover;
    }
    .report-header h3 {
      font-size: 24px;
      margin: 0;
    }

    .report-item {
      padding: 10px 15px;
      background: #eef4ff;
      border-radius: 8px;
      margin-bottom: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .report-item span {
      font-size: 16px;
      font-weight: bold;
    }
    .report-item a {
      text-decoration: none;
      padding: 6px 12px;
      background: #1977cc;
      color: white;
      border-radius: 6px;
    }
    .empty-msg {
      color: #777;
      font-size: 15px;
      margin-left: 10px;
    }

    /* Footer */
    .footer {
      text-align: center;
      padding: 20px;
      background: #1977cc;
      color: white;
      margin-top: 40px;
    }
  </style>

</head>
<body>

<!-- Header -->
<header class="main-header">
  <div class="logo">MediCare Plus</div>
  <nav class="navbar">
    
  </nav>
</header>

<!-- Hero -->
<section class="hero">
  <div>
    <h1>Medical Reports</h1>
    <p>Access all your lab results, visit summaries, and prescriptions in one place.</p>
  </div>
  <img src="https://thumbs.dreamstime.com/b/medical-team-working-digital-tablet-healthcare-doctor-technology-tablet-using-computer-analyzed-results-medical-reports-278600480.jpg">
</section>

<!-- Reports Section -->
<section class="reports-section">

  <h2>All Reports</h2>

  <!-- LAB RESULTS -->
  <div class="report-box">
    <div class="report-header">
      <img src="https://medlineplus.gov/images/LaboratoryTests_share.jpg">
      <h3>Lab Test Results</h3>
    </div>

    <?php if(empty($grouped['lab'])): ?>
      <p class="empty-msg">No lab test results available.</p>
    <?php else: ?>
      <?php foreach($grouped['lab'] as $r): ?>
        <div class="report-item">
          <span><?php echo htmlspecialchars($r['original_filename']); ?> (<?php echo date('Y-m-d', strtotime($r['uploaded_at'])); ?>)</span>
          <a href="download.php?report_id=<?php echo $r['report_id']; ?>">Download</a>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <!-- VISIT SUMMARIES -->
  <div class="report-box">
    <div class="report-header">
      <img src="https://blog.cosmaneura.com/content/images/2025/04/10-after-visit-summary-examples-to-enhance-patient-communication.webp">
      <h3>Visit Summaries</h3>
    </div>

    <?php if(empty($grouped['visit_summary'])): ?>
      <p class="empty-msg">No visit summaries available.</p>
    <?php else: ?>
      <?php foreach($grouped['visit_summary'] as $r): ?>
        <div class="report-item">
          <span><?php echo htmlspecialchars($r['original_filename']); ?> (<?php echo date('Y-m-d', strtotime($r['uploaded_at'])); ?>)</span>
          <a href="download.php?report_id=<?php echo $r['report_id']; ?>">Download</a>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <!-- PRESCRIPTIONS -->
  <div class="report-box">
    <div class="report-header">
      <img src="https://www.northwestpharmacy.com/special-features/images/us-prescriptions-01.jpg">
      <h3>Prescriptions</h3>
    </div>

    <?php if(empty($grouped['prescription'])): ?>
      <p class="empty-msg">No prescriptions available.</p>
    <?php else: ?>
      <?php foreach($grouped['prescription'] as $r): ?>
        <div class="report-item">
          <span><?php echo htmlspecialchars($r['original_filename']); ?> (<?php echo date('Y-m-d', strtotime($r['uploaded_at'])); ?>)</span>
          <a href="download.php?report_id=<?php echo $r['report_id']; ?>">Download</a>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

</section>

<footer class="footer">
  © 2025 MediCare Plus | All Rights Reserved
</footer>

</body>
</html>

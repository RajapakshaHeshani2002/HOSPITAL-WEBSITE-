<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header('Location: login.php'); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Doctor Dashboard - MediCare Plus</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Roboto', sans-serif;
    }
    body {
        background: #f2f7fa;
        color: #333;
    }
    .header {
        background-color:  #0077b6;
        color: #fff;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .header h1 {
        font-size: 24px;
    }
    .profile {
        display: flex;
        align-items: center;
        cursor: pointer;
    }
    .profile img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
        border: 2px solid #fff;
    }
    .dashboard-container {
        display: flex;
        flex-wrap: wrap;
        padding: 20px;
        gap: 20px;
    }
    .card {
        background: #fff;
        flex: 1 1 300px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card h2 {
        margin-bottom: 10px;
        color:  #0077b6;
    }
    .card p {
        margin-bottom: 8px;
    }
    .logout-btn {
        display: inline-block;
        padding: 10px 20px;
        background: #dc3545;
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        margin-top: 10px;
    }
</style>
</head>
<body>

<div class="header">
    <h1>Doctor Dashboard</h1>
    <div class="profile" onclick="window.location.href='doctor_profile.php'">
        <img src="<?php echo $_SESSION['profile_image'] ?? 'default_doctor.png'; ?>" alt="Profile">
        <span>Dr. <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
    </div>
</div>


    
<div class="dashboard-container">

    

    <!-- Prescriptions -->
    <div class="card">
        <h2>Prescriptions</h2>
        <p>Create, edit and manage prescriptions</p>
        <a href="prescriptions.html">Manage Prescriptions</a>
    </div>

    <!-- Messages -->
    <div class="card">
        <h2>Messages</h2>
        <p>Communicate with your patients</p>
        <a href="doctor.messages.php">Open Messages</a>
    </div>

    

    

    <!-- Reports (exists already) -->
    <div class="card">
        <h2>Medical Reports</h2>
        <p>Upload and access test results or prescriptions</p>
        <a href="manage_reports.php">Manage Reports</a>
    </div>

</div>

   

    

    

<div style="padding:20px;">
    <a href="index.html" class="logout-btn">Logout</a>
</div>

</body>
</html>

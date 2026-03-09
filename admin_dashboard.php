<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MediCare Plus Admin Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Roboto', sans-serif; background-color:#f4f6f8; color:#333; display:flex; min-height:100vh; flex-direction:column; }

/* Layout wrapper */
.wrapper { display:flex; flex:1; }

/* Sidebar */
.sidebar {
    width: 250px; background-color:#0077b6; color:white; flex-shrink:0;
    display:flex; flex-direction:column; padding-top:20px; height:100%;
}
.sidebar h2 { text-align:center; margin-bottom:30px; font-size:22px; }
.sidebar a {
    display:block; padding:15px 20px; color:white; 
    text-decoration:none; transition:0.3s;
}
.sidebar a:hover { background-color:#0056b3; }

/* Main content */
.main-content { flex:1; padding:20px; }

/* Top banner */
.top-banner {
    text-align:center; padding:15px; background-color:#00aaff; 
    color:white; border-radius:8px; margin-bottom:20px; font-weight:500; 
}

/* Header */
.header {
    display:flex; justify-content:space-between; align-items:center;
    background-color:#0077b6; padding:15px 25px; color:white;
    border-radius:8px; margin-bottom:20px;
}
.header .profile { display:flex; align-items:center; cursor:pointer; }
.header .profile img {
    width:40px; height:40px; border-radius:50%; margin-right:10px;
}
.header .profile span { font-weight:500; }

/* Widgets */
.widgets { 
    display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); 
    gap:20px;
}
.widget {
    background:white; padding:20px; border-radius:12px;
    box-shadow:0 6px 15px rgba(0,0,0,0.1); text-align:center;
}
.widget h3 { color:#0077b6; margin-bottom:10px; }
.widget p { font-size:18px; font-weight:500; }

/* Table */
table { width:100%; border-collapse:collapse; margin-top:30px; background:white; border-radius:8px; overflow:hidden; }
table th, table td { padding:12px 15px; text-align:left; }
table th { background-color:#0077b6; color:white; }
table tr:nth-child(even) { background-color:#f2f2f2; }

/* Footer */
.footer {
    margin-top:20px; background:#0077b6; color:white;
    text-align:center; padding:15px; font-size:15px;
    width:100%;
}

/* Responsive */
@media(max-width:768px){
    .wrapper { flex-direction:column; }
    .sidebar { width:100%; flex-direction:row; overflow-x:auto; }
    .sidebar a { flex:1; text-align:center; padding:12px; }
}
</style>
</head>
<body>

<div class="wrapper">

<div class="sidebar">
    <h2>MediCare Plus Admin</h2>
    <a href="index.html">Home</a>
    <a href="list_doctors.php">Doctors</a>
    <a href="patients.html">Patients</a>
    <a href="appointments.html">Appointments</a>
    <a href="services.html">Services</a>
    <a href="adminfeedback.html">Feedback & Ratings</a>
    <a href="payments.html">Payments</a>
    <a href="adminhealthblog.html">Health Blog</a>
    <a href="messaging.html">Settings / Profile</a>
    <a href="index.html">Logout</a>
</div>

<div class="main-content">

    

    <div class="header">
        <h1>Dashboard</h1>
        <div class="profile" onclick="window.location.href='profile.php'">
            <img src="/mnt/data/806d0147-1b47-4580-bb5c-0b49236dda3a.png">
            <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
        </div>
    </div>

    <div class="widgets">
        <div class="widget">
            <h3>Appointments</h3>
            <p>650</p>
        </div>
        <div class="widget">
            <h3>Operations</h3>
            <p>54</p>
        </div>
        <div class="widget">
            <h3>New Patients</h3>
            <p>129</p>
        </div>
        <div class="widget">
            <h3>Earnings</h3>
            <p>$20,125</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Doctor Name</th>
                <th>Specialization</th>
                <th>Availability</th>
                <th>Fee</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Dr. John Doe</td>
                <td>Cardiology</td>
                <td>Mon–Fri</td>
                <td>$50</td>
            </tr>
            <tr>
                <td>Dr. Jane Smith</td>
                <td>Pediatrics</td>
                <td>Tue–Thu</td>
                <td>$40</td>
            </tr>
        </tbody>
    </table>

</div>
</div>

<!-- FOOTER -->
<div class="footer">
    © 2025 MediCare Plus | All Rights Reserved
</div>

</body>
</html>

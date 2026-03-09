<?php 
session_start(); 
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header('Location: login.php'); 
    exit;
}
?> 
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Patient Dashboard - MediCare </title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background-color: #f4f6f8; color: #333; }

        /* HEADER WITH NAVIGATION */
        header {
            background: #0077b6;
            color: #fff;
            padding: 15px 0 5px 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .nav-container {
            width: 90%;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 25px;
        }

        nav ul li {
            display: inline-block;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 5px;
            transition: 0.3s;
        }

        nav ul li a:hover {
            background: #005f86;
        }

        /* Welcome */
        .welcome {
            margin: 25px auto;
            text-align: center;
        }
        .welcome p { font-size: 20px; margin-bottom: 10px; }
        .welcome a {
            padding: 10px 20px;
            background-color: #0077b6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        /* Dashboard Grid */
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 25px;
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            transition: 0.3s;
            text-decoration: none;
            color: #333;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.2);
        }

        .card img {
            width: 60px; height: 60px; margin-bottom: 15px;
        }

        .card strong {
            font-size: 18px;
            margin-bottom: 8px;
            color: #0077b6;
        }

       /* Footer */
.footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: #0077b6;
    color: white;
    text-align: center;
    padding: 12px 0;
    font-size: 15px;
    box-shadow: 0 -3px 10px rgba(0,0,0,0.25);
    z-index: 999;
}
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <header>
        <div class="nav-container">
            <div class="logo">MediCare Plus</div>

            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="book_appointment.html">Appointments</a></li>
                    
                    <li><a href="medical_reports.php">Reports</a></li>
                    <li><a href="prescriptions.html">Prescriptions</a></li>
                    <li><a href="online-payments.html">Payments</a></li>
                    <li><a href="patientsetting.php">Settings</a></li>
                    <li><a href="index.html" style="background:#ff4d4d;">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Welcome -->
    <div class="welcome">
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
    </div>

    <!-- Dashboard Cards -->
    <div class="dashboard">
        <a class="card" href="profile.html">
            <img src="https://static.vecteezy.com/system/resources/previews/005/544/718/original/profile-icon-design-free-vector.jpg">
            <strong>Profile</strong><span>Update your details.</span>
        </a>

        <a class="card" href="book-appointment.html">
            <img src="https://www.nicepng.com/png/detail/360-3605155_img-appointment-icon.png">
            <strong>Appointments</strong><span>View upcoming visits.</span>
        </a>

        <a class="card" href="medical_reports.php">
            <img src="https://www.pinclipart.com/picdir/big/444-4448260_standards-auditing-report-icon-png-clipart.png">
            <strong>Medical Reports</strong><span>Your lab results.</span>
        </a>

        <a class="card" href="prescriptions.html">
            <img src="https://cdn-icons-png.flaticon.com/512/9310/9310278.png">
            <strong>Prescriptions</strong><span>Doctor prescriptions.</span>
        </a>

        <a class="card" href="online-payments.html">
            <img src="https://as1.ftcdn.net/v2/jpg/05/19/16/38/1000_F_519163846_ggMv74dIvkoSLXoTagIEfQYMKol2K5P6.jpg">
            <strong>Payments</strong><span>Pay bills safely.</span>
        </a>

        <a class="card" href="feedback.html">
            <img src="https://img.freepik.com/premium-vector/feedback-icon_933463-75021.jpg">
            <strong>Feedback</strong><span>Share your experience.</span>
        </a>
    </div>

   <!-- FOOTER -->
<div class="footer">
    © 2025 MediCare Plus | All Rights Reserved
</div>



</body>
</html>

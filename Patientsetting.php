<?php
session_start();
include 'db_connect.php'; // PDO connection

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header('Location: login.php');
    exit();
}

$message = '';

// Fetch current user data
$stmt = $conn->prepare("SELECT fullname, phone, email FROM users WHERE id = :id");
$stmt->bindParam(':id', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        if(!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE users SET fullname=:fullname, phone=:phone, email=:email, password=:password WHERE id=:id");
            $update->bindParam(':password', $hashedPassword);
        } else {
            $update = $conn->prepare("UPDATE users SET fullname=:fullname, phone=:phone, email=:email WHERE id=:id");
        }

        $update->bindParam(':fullname', $fullname);
        $update->bindParam(':phone', $phone);
        $update->bindParam(':email', $email);
        $update->bindParam(':id', $_SESSION['user_id']);

        if($update->execute()) {
            $message = "Profile updated successfully!";
            // Refresh user info
            $user['fullname'] = $fullname;
            $user['phone'] = $phone;
            $user['email'] = $email;
        } else {
            $message = "Update failed. Try again.";
        }

    } catch(PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Patient Settings</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    background-color: #f4f6f8;
}

.container {
    width: 400px;
    margin: 50px auto;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
}

h1 {
    text-align: center;
    color: #4a148c;
    margin-bottom: 20px;
}

label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
}

input[type="text"], input[type="email"], input[type="password"] {
    width: 95%;
    padding: 8px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

button {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #4a148c;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #6a1b9a;
}

p.message {
    color: green;
    text-align: center;
}

p.error {
    color: red;
    text-align: center;
}

a {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: #4a148c;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>
<div class="container">
    <h1>Settings</h1>
    <?php if(!empty($message)) echo "<p class='message'>$message</p>"; ?>

    <form method="post">
        <label>Full Name</label>
        <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>

        <label>Phone</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label>Password (leave blank to keep current)</label>
        <input type="password" name="password">

        <button type="submit">Update Profile</button>
    </form>

    <a href="patient_dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>

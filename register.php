<?php
session_start();
include 'db_connect.php'; // include the PDO connection

if(isset($_POST['fullname'], $_POST['phone'], $_POST['email'], $_POST['password'], $_POST['role'])) {

    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = trim($_POST['role']);

    try {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            echo "<script>alert('Email already registered. Please login.');window.location='register.html';</script>";
            exit();
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $insert = $conn->prepare("INSERT INTO users (fullname, phone, email, password, role) VALUES (:fullname, :phone, :email, :password, :role)");
        $insert->bindParam(':fullname', $fullname);
        $insert->bindParam(':phone', $phone);
        $insert->bindParam(':email', $email);
        $insert->bindParam(':password', $hashedPassword);
        $insert->bindParam(':role', $role);

     if($insert->execute()) { 
        echo "<script>alert('Registration successful! Please login.');window.location='login.html';</script>"; 
        exit();
     } else {
         echo "<script>alert('Registration failed! Please try again.');window.location='register.html';</script>";
          exit();
         }


    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }

} else {
    header("Location: register.html");
    exit();
}
?>

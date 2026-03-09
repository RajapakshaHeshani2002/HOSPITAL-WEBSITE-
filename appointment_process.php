<?php
// Include the database connection
include 'db_connect.php';  // Make sure this path is correct

// Check if form data is submitted (example using POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Example form fields
    $full_name = $_POST['full_name'] ?? '';
    $email =$_POST['email'] ?? '';
    $phone_number =$_POST['phone_number'] ?? '';
    $doctor  = $_POST['doctor'] ?? '';
    $appointment_date = $_POST['appointment_date'] ?? '';
    $appointment_time = $_POST['appointment_time'] ?? '';

    // Prepare SQL query
    $sql = "INSERT INTO appointments (full_name,email,phone_number, doctor, appointment_date,appointment_time) 
            VALUES (:full_name,:email,:phone_number, :doctor, :appointment_date,:appointment_time)";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':full_name', $full_name);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':phone_number',$phone_number);
    $stmt->bindParam(':doctor', $doctor);
    $stmt->bindParam(':appointment_date', $appointment_date);
    $stmt->bindParam(':appointment_time',$appointment_time);

    // Execute statement
    if ($stmt->execute()) {
        echo "Appointment booked successfully!";
    } else {
        echo "Error booking appointment.";
    }
}
?>

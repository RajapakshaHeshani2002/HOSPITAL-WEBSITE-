<?php
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = $_POST['full_name'] ?? '';
    $email     = $_POST['email'] ?? '';
    $subject   = $_POST['subject'] ?? '';
    $type      = $_POST['type'] ?? 'other';  // default type
    $message   = $_POST['message'] ?? '';

    if (!empty($full_name) && !empty($email) && !empty($subject) && !empty($message)) {

        $sql = "INSERT INTO contact_messages (full_name, email, subject, type, message) 
                VALUES (:full_name, :email, :subject, :type, :message)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            echo "<script>alert('Your message has been sent successfully!');</script>";
        } else {
            echo "<script>alert('Database Error: Failed to send your message.');</script>";
        }

    } else {
        echo "<script>alert('Please fill all required fields.');</script>";
    }
}
?>

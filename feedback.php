<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $feedback = trim($_POST['feedback']);
    $rating = trim($_POST['rating']);

    if (empty($name) || empty($email) || empty($feedback) || empty($rating)) {
        die("All fields are required!");
    }

    try {
        $sql = "INSERT INTO feedback (name, email, feedback, rating)
                VALUES (:name, :email, :feedback, :rating)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':feedback', $feedback);
        $stmt->bindParam(':rating', $rating);
        $stmt->execute();

        echo "Thank you! Your feedback has been submitted successfully.";

    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
}
?>

<?php
include 'db_connect.php'; // PDO connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = $_POST['patientName'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone'];
    $amount = $_POST['amount'];
    $card_number = $_POST['cardNumber'];
    $expiry_date = $_POST['expiry'];
    $cvv = $_POST['cvv'];

    try {
        $sql = "INSERT INTO payments (full_name, email, phone_number, amount, card_number, expiry_date, cvv)
                VALUES (:full_name, :email, :phone_number, :amount, :card_number, :expiry_date, :cvv)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':card_number', $card_number);
        $stmt->bindParam(':expiry_date', $expiry_date);
        $stmt->bindParam(':cvv', $cvv);

        $stmt->execute();

        echo "Successful";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // PDO error
    }
}
?>

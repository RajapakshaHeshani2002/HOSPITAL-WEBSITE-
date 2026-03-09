<?php
include 'db.php';

$name = $_POST['name'];
$spec = $_POST['spec'];
$fee = $_POST['fee'];
$availability = $_POST['availability'];
$image = $_POST['image'];
$schedule = $_POST['schedule'];
$bio = $_POST['bio'];

$stmt = $pdo->prepare("INSERT INTO doctors(name, specialization, fee, availability, image_url, schedule, bio)
VALUES (?,?,?,?,?,?,?)");

$stmt->execute([$name,$spec,$fee,$availability,$image,$schedule,$bio]);

echo "success";

<?php
session_start();

// Doctor login check
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header('Location: login.php');
    exit;
}

$messagesFile = "messages.json";

// Create file if not found
if (!file_exists($messagesFile)) {
    file_put_contents($messagesFile, json_encode([]));
}

// Load messages
$messages = json_decode(file_get_contents($messagesFile), true);

// When doctor sends message
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newMessage = [
        "doctor_id" => $_SESSION['user_id'],
        "patient_name" => $_POST['patient_name'],
        "message" => $_POST['message'],
        "time" => date("Y-m-d H:i")
    ];

    $messages[] = $newMessage;
    file_put_contents($messagesFile, json_encode($messages, JSON_PRETTY_PRINT));
    header("Location: messages.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Doctor Messages – MediCare Plus</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    body{
        font-family: 'Poppins', sans-serif;
        background:#e8f1f7;
        margin:0;
        padding:0;
    }
    .header{
        background:#0077b6;
        padding:20px;
        color:#fff;
        text-align:center;
        font-size:26px;
        font-weight:600;
    }
    .container{
        width:90%;
        margin:auto;
        margin-top:20px;
        display:flex;
        gap:25px;
    }
    .form-box, .messages-box{
        background:#fff;
        padding:20px;
        border-radius:15px;
        box-shadow:0 4px 10px rgba(0,0,0,0.1);
        flex:1;
    }
    .form-box h2, .messages-box h2{
        color:#0077b6;
        margin-bottom:10px;
    }
    input, textarea, select{
        width:100%;
        padding:12px;
        margin:10px 0;
        border-radius:8px;
        border:1px solid #ccc;
    }
    button{
        background:#0077b6;
        color:#fff;
        padding:12px;
        border:none;
        border-radius:8px;
        width:100%;
        cursor:pointer;
        font-size:16px;
    }
    .message{
        background:#f1faff;
        padding:12px;
        border-left:4px solid #0077b6;
        margin-bottom:12px;
        border-radius:8px;
    }
    .time{
        font-size:12px;
        color:gray;
    }
</style>

</head>
<body>

<div class="header">Doctor Messages</div>

<div class="container">

    <!-- Message Send Section -->
    <div class="form-box">
        <h2>Send Message to Patient</h2>

        <form method="POST">

            <label>Patient Name:</label>
            <select name="patient_name" required>
                <option value="">Select Patient</option>
                <option>John Silva</option>
                <option>Amali Perera</option>
                <option>Kamal Fernando</option>
                <option>Nimali Jayasooriya</option>
            </select>

            <label>Message:</label>
            <textarea name="message" rows="4" required placeholder="Type your message..."></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>

    <!-- Message List Section -->
    <div class="messages-box">
        <h2>Messages Sent</h2>

        <?php if (empty($messages)): ?>
            <p>No messages yet.</p>
        <?php endif; ?>

        <?php foreach (array_reverse($messages) as $msg): ?>
            <div class="message">
                <strong>To: <?= htmlspecialchars($msg['patient_name']) ?></strong><br>
                <?= htmlspecialchars($msg['message']) ?><br>
                <span class="time"><?= $msg['time'] ?></span>
            </div>
        <?php endforeach; ?>
    </div>

</div>

</body>
</html>

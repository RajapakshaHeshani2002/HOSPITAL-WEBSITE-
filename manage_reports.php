<?php
session_start();
// ensure doctor is logged in
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor'){
    header('Location: login.php'); exit;
}

include 'db.php'; // $pdo PDO connection

$errors = [];
$success = '';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_report'])) {
    $patient_id = intval($_POST['patient_id']);
    $report_type = $_POST['report_type'];

    if(!$patient_id) $errors[] = "Invalid patient id.";
    $allowed_types = ['lab','visit_summary','prescription'];
    if(!in_array($report_type, $allowed_types)) $errors[] = "Invalid report type.";

    if(!isset($_FILES['report']) || $_FILES['report']['error'] !== UPLOAD_ERR_OK){
        $errors[] = "Please select a file to upload.";
    }

    if(empty($errors)){
        $file = $_FILES['report'];
        $origName = basename($file['name']);
        $fileSize = $file['size'];
        $mime = mime_content_type($file['tmp_name']);

        $allowedExt = ['pdf','jpg','jpeg','png','doc','docx'];
        $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
        if(!in_array($ext, $allowedExt)){
            $errors[] = "File type not allowed. Allowed: " . implode(',', $allowedExt);
        }

        if($fileSize > 10 * 1024 * 1024) $errors[] = "File too large (max 10 MB).";

        if(empty($errors)){
            $upload_dir = __DIR__ . "/uploads/";
            if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            $storedName = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            $destination = $upload_dir . $storedName;

            if(move_uploaded_file($file['tmp_name'], $destination)){
                $stmt = $pdo->prepare("INSERT INTO medical_reports (patient_id, doctor_id, report_type, original_filename, stored_filename, file_mime, file_size) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $patient_id,
                    $_SESSION['user_id'],
                    $report_type,
                    $origName,
                    $storedName,
                    $mime,
                    $fileSize
                ]);
                $success = "Report uploaded successfully.";
            } else {
                $errors[] = "Failed to move uploaded file.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Upload Medical Report</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f4f8;
    padding: 30px;
}
.card {
    background: #ffffff;
    max-width: 500px;
    margin: 0 auto;
    padding: 25px 30px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-4px);
}
h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 25px;
}
label {
    font-weight: bold;
    color: #34495e;
}
input[type="number"],
input[type="file"],
select {
    width: 100%;
    padding: 10px;
    margin: 6px 0 15px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
    transition: border-color 0.2s;
}
input[type="number"]:focus,
input[type="file"]:focus,
select:focus {
    border-color: #0077b6;
    outline: none;
}
button {
    width: 100%;
    padding: 12px;
    background-color: #0077b6;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.2s;
}
button:hover {
    background-color: #0077b6;
}
.message {
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 6px;
    font-weight: bold;
    text-align: center;
}
.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>
</head>
<body>

<div class="card">
    <h2>Upload Medical Report</h2>

    <?php if(!empty($errors)): ?>
        <div class="message error">
            <?php foreach($errors as $e) echo htmlspecialchars($e)."<br>"; ?>
        </div>
    <?php endif; ?>

    <?php if(!empty($success)): ?>
        <div class="message success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <label>Patient ID</label>
        <input type="number" name="patient_id" required>

        <label>Report Type</label>
        <select name="report_type" required>
            <option value="lab">Lab Test Results</option>
            <option value="visit_summary">Visit Summaries</option>
            <option value="prescription">Prescriptions</option>
        </select>

        <label>Select File</label>
        <input type="file" name="report" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>

        <button type="submit" name="upload_report">Upload Report</button>
    </form>
</div>

</body>
</html>

<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit;
}
include '../db.php';

$student_id = $_SESSION['user_id'];

// Fetch student details
$stmt = $pdo->prepare("SELECT s.*, p.phone_number FROM student s LEFT JOIN stu_phone_number p ON s.Student_id = p.Student_id WHERE s.Student_id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch();

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['FirstName'];
    $lname = $_POST['LastName'];
    $phone = $_POST['Phone_Number'];
    $duration = $_POST['Duration_Stay'];

    $pdo->beginTransaction();

    $updateStudent = $pdo->prepare("UPDATE student SET FirstName = ?, LastName = ?, Duration_Stay = ? WHERE Student_id = ?");
    $updateStudent->execute([$fname, $lname, $duration, $student_id]);

    $checkPhone = $pdo->prepare("SELECT * FROM stu_phone_number WHERE Student_id = ?");
    $checkPhone->execute([$student_id]);
    if ($checkPhone->rowCount() > 0) {
        $updatePhone = $pdo->prepare("UPDATE stu_phone_number SET phone_number = ? WHERE Student_id = ?");
        $updatePhone->execute([$phone, $student_id]);
    } else {
        $insertPhone = $pdo->prepare("INSERT INTO stu_phone_number (Student_id, phone_number) VALUES (?, ?)");
        $insertPhone->execute([$student_id, $phone]);
    }

    $pdo->commit();
    header("Location: list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Edit Profile</title>
<style>
    /* Reset and base styles */
    * {
        box-sizing: border-box;
    }
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9fafb;
        margin: 40px auto;
        max-width: 480px;
        padding: 0 20px 40px;
        color: #222;
    }
    h2 {
        text-align: center;
        margin-bottom: 30px;
        font-weight: 700;
        color: #222;
    }
    form {
        background: #fff;
        padding: 30px 25px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
    }
    label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        color: #333;
    }
    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 20px;
        border-radius: 6px;
        border: 1.5px solid #ccc;
        font-size: 15px;
        transition: border-color 0.25s ease;
    }
    input[type="text"]:focus,
    input[type="number"]:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 6px #a5c8ff;
    }
    button {
        width: 100%;
        padding: 12px 0;
        background-color: #28a745;
        border: none;
        border-radius: 6px;
        color: white;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #218838;
    }
    a.back-link {
        display: block;
        margin-top: 30px;
        text-align: center;
        text-decoration: none;
        font-weight: 600;
        color: #fff;
        background-color: #dc3545;
        padding: 12px 25px;
        border-radius: 6px;
        transition: background-color 0.3s ease;
        max-width: 200px;
        margin-left: auto;
        margin-right: auto;
    }
    a.back-link:hover {
        background-color: #b02a37;
    }
</style>
</head>
<body>

<h2>Edit Your Profile</h2>
<form method="POST" novalidate>
    <label for="FirstName">First Name:</label>
    <input type="text" id="FirstName" name="FirstName" value="<?= htmlspecialchars($student['FirstName']) ?>" required>

    <label for="LastName">Last Name:</label>
    <input type="text" id="LastName" name="LastName" value="<?= htmlspecialchars($student['LastName']) ?>" required>

    <label for="Phone_Number">Phone Number:</label>
    <input type="text" id="Phone_Number" name="Phone_Number" value="<?= htmlspecialchars($student['phone_number']) ?>" required>

    <label for="Duration_Stay">Duration of Stay (Years):</label>
    <input type="number" id="Duration_Stay" name="Duration_Stay" value="<?= htmlspecialchars($student['Duration_Stay']) ?>" min="0" required>

    <button type="submit">Save Changes</button>
</form>

<a href="../dashboard_student.php" class="back-link">← Back to Dashboard</a>

</body>
</html>

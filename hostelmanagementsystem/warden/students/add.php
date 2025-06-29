<?php
session_start();
include '../../db.php';

// ✅ Only wardens can access this page
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'warden') {
    header("Location: ../../login.php");
    exit;
}

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['Student_id'];
    $fname = $_POST['FirstName'];
    $lname = $_POST['LastName'];
    $duration = $_POST['Duration_Stay'];
    $phone = $_POST['Phone_Number'];
    $warden_id = $_SESSION['user_id'];

    try {
        $pdo->beginTransaction();

        // ✅ Insert into STUDENT table
        $insertStudent = $pdo->prepare("INSERT INTO student (Student_id, FirstName, LastName, Duration_Stay, Warden_id) VALUES (?, ?, ?, ?, ?)");
        $insertStudent->execute([$student_id, $fname, $lname, $duration, $warden_id]);

        // ✅ Insert into stu_phone_number table
        $insertPhone = $pdo->prepare("INSERT INTO stu_phone_number (Student_id, phone_number) VALUES (?, ?)");
        $insertPhone->execute([$student_id, $phone]);

        $pdo->commit();

        header("Location: list.php?msg=added");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "❌ Failed to add student: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f1f1f1;
            padding: 40px;
        }
        form {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            text-align: center;
            color: #007BFF;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 12px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background: #28a745;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        .back {
            text-align: center;
            margin-top: 20px;
            display: block;
            background: #dc3545;
            color: white;
            padding: 10px;
            border-radius: 6px;
            text-decoration: none;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>

<h2>Add New Student</h2>

<form method="POST">
    <label>Student ID:</label>
    <input type="text" name="Student_id" required>

    <label>First Name:</label>
    <input type="text" name="FirstName" required>

    <label>Last Name:</label>
    <input type="text" name="LastName" required>

    <label>Phone Number:</label>
    <input type="text" name="Phone_Number" required>

    <label>Duration of Stay (Years):</label>
    <input type="number" name="Duration_Stay" required>

    <button type="submit">➕ Add Student</button>
</form>

<a class="back" href="list.php">⬅ Back to Student List</a>

</body>
</html>

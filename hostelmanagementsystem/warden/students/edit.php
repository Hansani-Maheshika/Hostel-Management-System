<?php
session_start();
include '../../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'warden') {
    header("Location: ../../login.php");
    exit;
}

$id = $_GET['id'] ?? '';
$wardenId = $_SESSION['user_id'];

// Fetch student record
$stmt = $pdo->prepare("SELECT * FROM student WHERE Student_id = ? AND Warden_id = ?");
$stmt->execute([$id, $wardenId]);
$student = $stmt->fetch();

// Get phone number
$phone = '';
$phoneStmt = $pdo->prepare("SELECT phone_number FROM stu_phone_number WHERE Student_id = ?");
$phoneStmt->execute([$id]);
if ($row = $phoneStmt->fetch()) {
    $phone = $row['phone_number'];
}

if (!$student) {
    echo "Access Denied or Student Not Found.";
    exit;
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['FirstName'];
    $lname = $_POST['LastName'];
    $duration = $_POST['Duration_Stay'];
    $phoneNew = $_POST['Phone_Number'];

    try {
        $pdo->beginTransaction();

        // Update student
        $updateStudent = $pdo->prepare("UPDATE student SET FirstName = ?, LastName = ?, Duration_Stay = ? WHERE Student_id = ? AND Warden_id = ?");
        $updateStudent->execute([$fname, $lname, $duration, $id, $wardenId]);

        // Update or insert phone number
        $checkPhone = $pdo->prepare("SELECT * FROM stu_phone_number WHERE Student_id = ?");
        $checkPhone->execute([$id]);
        if ($checkPhone->rowCount() > 0) {
            $updatePhone = $pdo->prepare("UPDATE stu_phone_number SET phone_number = ? WHERE Student_id = ?");
            $updatePhone->execute([$phoneNew, $id]);
        } else {
            $insertPhone = $pdo->prepare("INSERT INTO stu_phone_number (Student_id, phone_number) VALUES (?, ?)");
            $insertPhone->execute([$id, $phoneNew]);
        }

        $pdo->commit();
        header("Location: list.php?msg=updated");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "❌ Failed to update: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #eef2f3;
            padding: 40px;
        }
        form {
            background: white;
            padding: 25px;
            border-radius: 10px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            text-align: center;
            color: #0077b6;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 12px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background: #0077b6;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background: #023e8a;
        }
        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            background: #f44336;
            color: white;
            padding: 10px;
            border-radius: 6px;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>

<h2>Edit Student Details</h2>

<form method="POST">
    <label>First Name:</label>
    <input type="text" name="FirstName" value="<?= htmlspecialchars($student['FirstName']) ?>" required>

    <label>Last Name:</label>
    <input type="text" name="LastName" value="<?= htmlspecialchars($student['LastName']) ?>" required>

    <label>Phone Number:</label>
    <input type="text" name="Phone_Number" value="<?= htmlspecialchars($phone) ?>" required>

    <label>Duration of Stay (Years):</label>
    <input type="number" name="Duration_Stay" value="<?= htmlspecialchars($student['Duration_Stay']) ?>" required>

    <button type="submit">Update Student</button>
</form>

<a class="back" href="list.php">⬅ Back to Student List</a>

</body>
</html>

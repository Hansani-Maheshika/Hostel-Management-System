<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $visitor_name = $_POST['visitor_name'];
    $phone_number = $_POST['phone_number'];
    $relationship = $_POST['relationship'];

    $stmt = $pdo->prepare("INSERT INTO visitors (Student_id, Name, Phone_number, Relationship) VALUES (?, ?, ?, ?)");
    $stmt->execute([$student_id, $visitor_name, $phone_number, $relationship]);

    header("Location: view_visitors.php");
    exit;
}

// Fetch students for dropdown
$students = $pdo->query("SELECT Student_id, FirstName FROM student")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Add Visitor</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { padding: 40px; }
</style>
</head>
<body>
<div class="container">
    <h2>Add Visitor</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Student</label>
            <select name="student_id" class="form-select" required>
                <option value="">Select Student</option>
                <?php foreach ($students as $s): ?>
                    <option value="<?= htmlspecialchars($s['Student_id']) ?>">
                        <?= htmlspecialchars($s['Student_id'] . " - " . $s['FirstName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Visitor Name</label>
            <input type="text" name="visitor_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Relationship</label>
            <input type="text" name="relationship" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Visitor</button>
        <a href="view_visitors.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>

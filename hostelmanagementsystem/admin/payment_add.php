<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require_once '../db.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['Payment_id'];
    $student_id = $_POST['Student_id'];
    $admin_id = $_POST['Admin_id'];
    $date = $_POST['Payment_Date'];
    $month = $_POST['Payment_Month'];
    $amount = $_POST['Payment_Amount'];
    $penalty = $_POST['Penalty_Amount'];

    if (!$id || !$student_id || !$admin_id || !$date || !$month || !$amount) {
        $errors[] = "All required fields must be filled.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO payments 
            (Payment_id, Student_id, Admin_id, Payment_Date, Payment_Month, Payment_Amount, Penalty_Amount)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id, $student_id, $admin_id, $date, $month, $amount, $penalty ?: null]);
        header("Location: payment_list.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Payment</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
        }
        form {
            background: white;
            padding: 20px;
            width: 400px;
            margin: 50px auto;
            box-shadow: 0 0 10px #ccc;
            border-radius: 8px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
        }
        input[type="submit"] {
            margin-top: 15px;
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        a.back-btn {
            display: inline-block;
            margin-top: 15px;
            background: #f44336;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<form method="POST">
    <h2>Add New Payment</h2>

    <?php if ($errors): ?>
        <div class="error"><?= implode('<br>', $errors); ?></div>
    <?php endif; ?>

    <label>Payment ID:</label>
    <input type="text" name="Payment_id" required>

    <label>Student ID:</label>
    <input type="text" name="Student_id" required placeholder="e.g., S001">

    <label>Admin ID:</label>
    <input type="text" name="Admin_id" required placeholder="e.g., A001">

    <label>Payment Date (YYYY-MM-DD):</label>
    <input type="date" name="Payment_Date" required>

    <label>Payment Month:</label>
    <input type="text" name="Payment_Month" required placeholder="e.g., June">

    <label>Payment Amount:</label>
    <input type="number" name="Payment_Amount" required>

    <label>Penalty Amount (optional):</label>
    <input type="number" name="Penalty_Amount">

    <input type="submit" value="Add Payment">
    <a href="payment_list.php" class="back-btn">← Back</a>
</form>

</body>
</html>


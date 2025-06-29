<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require_once '../db.php';

if (!isset($_GET['id'])) {
    header("Location: payment_list.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM payments WHERE Payment_id = ?");
$stmt->execute([$id]);
$payment = $stmt->fetch();

if (!$payment) {
    echo "Payment not found!";
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['Student_id'];
    $admin_id = $_POST['Admin_id'];
    $date = $_POST['Payment_Date'];
    $month = $_POST['Payment_Month'];
    $amount = $_POST['Payment_Amount'];
    $penalty = $_POST['Penalty_Amount'];

    if (!$student_id || !$admin_id || !$date || !$month || !$amount) {
        $errors[] = "All required fields must be filled.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE payments SET 
            Student_id = ?, Admin_id = ?, Payment_Date = ?, 
            Payment_Month = ?, Payment_Amount = ?, Penalty_Amount = ?
            WHERE Payment_id = ?");
        $stmt->execute([$student_id, $admin_id, $date, $month, $amount, $penalty ?: null, $id]);
        header("Location: payment_list.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Payment</title>
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
    <h2>Edit Payment <?= htmlspecialchars($payment['Payment_id']) ?></h2>

    <?php if ($errors): ?>
        <div class="error"><?= implode('<br>', $errors); ?></div>
    <?php endif; ?>

    <label>Student ID:</label>
    <input type="text" name="Student_id" value="<?= htmlspecialchars($payment['Student_id']) ?>" required>

    <label>Admin ID:</label>
    <input type="text" name="Admin_id" value="<?= htmlspecialchars($payment['Admin_id']) ?>" required>

    <label>Payment Date:</label>
    <input type="date" name="Payment_Date" value="<?= htmlspecialchars($payment['Payment_Date']) ?>" required>

    <label>Month:</label>
    <input type="text" name="Payment_Month" value="<?= htmlspecialchars($payment['Payment_Month']) ?>" required>

    <label>Amount:</label>
    <input type="number" name="Payment_Amount" value="<?= htmlspecialchars($payment['Payment_Amount']) ?>" required>

    <label>Penalty:</label>
    <input type="number" name="Penalty_Amount" value="<?= htmlspecialchars($payment['Penalty_Amount']) ?>">

    <input type="submit" value="Update Payment">
    <a href="payment_list.php" class="back-btn">← Back</a>
</form>

</body>
</html>


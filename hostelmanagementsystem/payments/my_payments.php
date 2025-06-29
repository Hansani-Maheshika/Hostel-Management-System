<?php
session_start();
if ($_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit;
}
include '../db.php';

$student_id = $_SESSION['user_id'];

// Fetch student payments
$stmt = $pdo->prepare("SELECT * FROM payments WHERE Student_id = ? ORDER BY Payment_Date DESC");
$stmt->execute([$student_id]);
$payments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Payments</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #FFDEE9, #B5FFFC);
            padding: 30px;
            color: #333;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 70%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px #ccc;
            border-radius: 10px;
            overflow: hidden;
        }
        th {
            background-color: #28a745;
            color: white;
            padding: 15px;
        }
        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>

<h2>💳 My Payment History</h2>

<table>
    <tr>
        <th>Month</th>
        <th>Amount (Rs.)</th>
        <th>Penalty (Rs.)</th>
        <th>Date</th>
    </tr>
    <?php foreach ($payments as $payment): ?>
    <tr>
        <td><?= htmlspecialchars($payment['Payment_Month']) ?></td>
        <td><?= number_format($payment['Payment_Amount'], 2) ?></td>
        <td><?= $payment['Penalty_Amount'] ? number_format($payment['Penalty_Amount'], 2) : 'None' ?></td>
        <td><?= htmlspecialchars($payment['Payment_Date']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="../dashboard_student.php">← Back to Dashboard</a>

</body>
</html>

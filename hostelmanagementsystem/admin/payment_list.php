<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
require_once('../db.php');

$sql = "SELECT p.*, a.Name AS Admin_name 
        FROM payments p
        JOIN student s ON p.Student_id = s.Student_id
        JOIN admin a ON p.Admin_id = a.Admin_id
        ORDER BY STR_TO_DATE(Payment_Date, '%d/%m/%Y') DESC";

$stmt = $pdo->query($sql);
$payments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            padding: 30px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .btn-custom {
            text-decoration: none;
            background: #28a745;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 500;
        }
        .btn-custom:hover {
            background: #218838;
        }
        .action-buttons .btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>All Payments</h2>
        <a href="payment_add.php" class="btn btn-success mb-3">+ Add New Payment</a>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Admin</th>
                        <th>Date</th>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Penalty</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($payments as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['Payment_id']) ?></td>
                        <td><?= htmlspecialchars($p['Student_id']) ?></td>
                        <td><?= htmlspecialchars($p['Admin_id']) ?> - <?= htmlspecialchars($p['Admin_name']) ?></td>
                        <td><?= htmlspecialchars($p['Payment_Date']) ?></td>
                        <td><?= htmlspecialchars($p['Payment_Month']) ?></td>
                        <td><?= htmlspecialchars($p['Payment_Amount']) ?></td>
                        <td><?= htmlspecialchars($p['Penalty_Amount'] ?? '0') ?></td>
                        <td class="action-buttons">
                            <a href="payment_edit.php?id=<?= $p['Payment_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="payment_delete.php?id=<?= $p['Payment_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this payment?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="/hostelmanagementsystem/dashboard_admin.php" class="btn btn-secondary mt-3">⬅ Back to Admin Dashboard</a>
    </div>
</body>
</html>

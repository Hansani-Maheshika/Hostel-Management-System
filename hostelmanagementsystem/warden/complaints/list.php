<?php
session_start();
if ($_SESSION['role'] !== 'warden') {
    header("Location: ../login.php");
    exit;
}

include '../../db.php';

// Update status logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $complaint_id = $_POST['complaint_id'];
    $new_status = $_POST['action_status'];
    $stmt = $pdo->prepare("UPDATE complaints SET Action = ? WHERE Complaint_id = ?");
    $stmt->execute([$new_status, $complaint_id]);
}

// Fetch complaints
$stmt = $pdo->prepare("SELECT * FROM complaints ORDER BY Complaint_id DESC");
$stmt->execute();
$complaints = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Warden - Manage Complaints</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        .table th {
            background-color: #e9ecef;
            text-align: center;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table td.description-cell {
            text-align: left;
            white-space: pre-wrap;
        }

        .form-select {
            min-width: 120px;
        }

        .btn-update {
            white-space: nowrap;
        }

        .back-btn {
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .form-select, .btn-update {
                font-size: 14px;
                padding: 5px 10px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">📋 All Complaints (Warden Access)</h2>

    <div class="table-container">
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th style="width: 140px;">Title</th>
                    <th>Description</th> <!-- Full-width column -->
                    <th style="width: 150px;">Report Date</th>
                    <th style="width: 100px;">Student ID</th>
                    <th style="width: 140px;">Status</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($complaints as $row): ?>
                <tr>
                    <form method="POST">
                        <td><?= htmlspecialchars($row['Complaint_id']) ?></td>
                        <td><?= htmlspecialchars($row['Title']) ?></td>
                        <td class="description-cell"><?= htmlspecialchars($row['Description']) ?></td>
                        <td><?= htmlspecialchars($row['Report_Date']) ?></td>
                        <td><?= htmlspecialchars($row['Student_id']) ?></td>
                        <td>
                            <select name="action_status" class="form-select">
                                <option value="Pending" <?= $row['Action'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Solved" <?= $row['Action'] === 'Solved' ? 'selected' : '' ?>>Solved</option>
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="complaint_id" value="<?= htmlspecialchars($row['Complaint_id']) ?>">
                            <button type="submit" name="update_status" class="btn btn-success btn-sm btn-update">Update</button>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center">
        <a href="../../dashboard_warden.php" class="btn btn-primary back-btn">⬅ Back to Warden Dashboard</a>
    </div>
</div>

</body>
</html>

<?php
session_start();
include('../../db.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$stmt = $pdo->query("SELECT Warden_id, Name, Phone_number FROM WARDEN");
$wardens = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Wardens</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .container-box {
            max-width: 900px;
            margin: 60px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 500;
            color: #333;
        }

        .btn-custom {
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-edit {
            background-color: #0d6efd;
            color: #fff;
        }

        .btn-edit:hover {
            background-color: #0b5ed7;
        }

        .btn-add {
            display: block;
            width: fit-content;
            margin: 0 auto 20px;
            background-color: #198754;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
        }

        .btn-add:hover {
            background-color: #157347;
        }

        .btn-back {
            display: block;
            margin: 30px auto 0;
            text-align: center;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #bb2d3b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #343a40;
            color: white;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
        }

        tr:last-child td {
            border-bottom: none;
        }
    </style>
</head>
<body>

<div class="container-box">
    <h2>Manage Wardens</h2>

    <a href="warden_add.php" class="btn-add">Add New Warden</a>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Warden ID</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($wardens as $warden): ?>
            <tr>
                <td><?= htmlspecialchars($warden['Warden_id']) ?></td>
                <td><?= htmlspecialchars($warden['Name']) ?></td>
                <td><?= htmlspecialchars($warden['Phone_number']) ?></td>
                <td>
                    <a href="warden_edit.php?id=<?= urlencode($warden['Warden_id']) ?>" class="btn btn-sm btn-edit btn-custom">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a href="/hostelmanagementsystem/dashboard_admin.php" class="btn-back">Back to Admin Dashboard</a>
</div>

</body>
</html>

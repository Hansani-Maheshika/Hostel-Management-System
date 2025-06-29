<?php
session_start();
if ($_SESSION['role'] !== 'warden') {
    header("Location: ../login.php");
    exit;
}
include '../../db.php';

$rooms = $pdo->query("SELECT * FROM room")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Rooms Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 30px auto;
            padding: 20px 15px;
            background-color: #fafafa; /* very light gray */
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #4a6fa5; /* soft blue */
        }
        a {
            text-decoration: none;
            color: #3467c6; /* medium blue */
            transition: color 0.3s;
        }
        a:hover {
            color: #1e3c72; /* darker blue on hover */
            text-decoration: underline;
        }
        .top-actions {
            margin-bottom: 15px;
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            background-color: #fff;
            box-shadow: 0 0 6px rgba(0,0,0,0.05);
            border-radius: 6px;
            overflow: hidden;
        }
        th, td {
            border-bottom: 1px solid #ddd;
            padding: 10px 15px;
            text-align: left;
        }
        th {
            background-color: #e3ebf8; /* very light blue */
            color: #3b5998;
            font-weight: 600;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .back-btn {
            display: inline-block;
            padding: 8px 15px;
            background-color: #d9e2f3; /* light blue-gray */
            color: #3b5998;
            border-radius: 4px;
            border: 1px solid #aac4f7;
            transition: background-color 0.3s;
        }
        .back-btn:hover {
            background-color: #aac4f7;
            color: #1e3c72;
        }
    </style>
</head>
<body>

<h2>Rooms Management</h2>

<div class="top-actions">
    <a href="add_room.php">+ Add New Room</a>
</div>

<table>
    <thead>
        <tr>
            <th>Room ID</th>
            <th>Room No</th>
            <th>Room Type</th>
            <th>AC Type</th>
            <th>Capacity</th>
            <th>Occupied</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rooms as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['Room_id']) ?></td>
            <td><?= htmlspecialchars($r['Room_no']) ?></td>
            <td><?= htmlspecialchars($r['Room_Type']) ?></td>
            <td><?= htmlspecialchars($r['Ac_Type']) ?></td> 
            <td><?= htmlspecialchars($r['Capacity']) ?></td>
            <td><?= htmlspecialchars($r['Occupied_Count']) ?></td>
            <td>
                <a href="assign_room.php?room_id=<?= urlencode($r['Room_id']) ?>">Assign Student</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (count($rooms) === 0): ?>
        <tr>
            <td colspan="7" style="text-align:center;">No rooms found.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<a href="../../dashboard_warden.php" class="back-btn">⬅ Back to Warden Dashboard</a>

</body>
</html>

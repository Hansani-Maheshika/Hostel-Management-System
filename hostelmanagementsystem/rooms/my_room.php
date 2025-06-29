<?php
session_start();
if ($_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit;
}

include '../db.php';

$student_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT r.*
    FROM student s
    JOIN room r ON s.Room_id = r.Room_id
    WHERE s.Student_id = ?
");
$stmt->execute([$student_id]);
$room = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Room Details</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #e0c3fc, #8ec5fc);
            padding: 30px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px #ccc;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
        }

        th {
            background-color: #7b2cbf;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f3e9ff;
        }

        .back-btn {
            display: block;
            margin: 30px auto;
            background-color: #ff6b6b;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            text-align: center;
            width: fit-content;
        }

        .back-btn:hover {
            background-color: #ff4d4d;
        }

        .no-room {
            text-align: center;
            font-size: 18px;
            color: red;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<h2>🏠 Your Room Details</h2>

<?php if ($room): ?>
    <table>
        <tr>
            <th>Room ID</th>
            <th>Room No</th>
            <th>Room Type</th>
            <th>AC Type</th>
            <th>Capacity</th>
            <th>Occupied Count</th>
         
        </tr>
        <tr>
            <td><?= htmlspecialchars($room['Room_id']) ?></td>
            <td><?= htmlspecialchars($room['Room_no']) ?></td>
            <td><?= htmlspecialchars($room['Room_Type']) ?></td>
            <td><?= htmlspecialchars($room['Ac_Type']) ?></td>
            <td><?= htmlspecialchars($room['Capacity']) ?></td>
            <td><?= htmlspecialchars($room['Occupied_Count']) ?></td>
        
        </tr>
    </table>
<?php else: ?>
    <div class="no-room">⚠️ No room assigned to your account yet.</div>
<?php endif; ?>

<a class="back-btn" href="../dashboard_student.php">← Back to Dashboard</a>

</body>
</html>


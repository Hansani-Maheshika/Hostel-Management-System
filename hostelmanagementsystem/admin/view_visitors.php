<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

include '../db.php';

$stmt = $pdo->query("
    SELECT 
        visitors.Student_id,
        visitors.Name AS Visitor_Name,
        visitors.Phone_number,
        visitors.Relationship,
        visitors.visit_date,
        student.FirstName
    FROM visitors
    JOIN student ON visitors.Student_id = student.Student_id
    ORDER BY visitors.Student_id
");

$visitors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>All Visitors - Admin View</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #fff;
        color: #212529;
        min-height: 100vh;
        padding: 40px 20px;
    }
    h2 {
        text-align: center;
        margin-bottom: 30px;
        font-weight: 600;
        color: #343a40;
    }
    a.back-link {
        display: block;
        max-width: 200px;
        margin: 30px auto 0;
        padding: 10px 20px;
        background: #0d6efd;
        color: white;
        font-weight: 600;
        border-radius: 6px;
        text-decoration: none;
        text-align: center;
        transition: background-color 0.3s ease;
    }
    a.back-link:hover {
        background-color: #0b5ed7;
    }
</style>
</head>
<body>

<h2>Visitor Records</h2>

<div class="table-responsive">
    <table class="table table-striped table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Visitor Name</th>
                <th>Phone Number</th>
                <th>Relationship</th>
                <th>Visit Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($visitors as $v): ?>
            <tr>
                <td><?= htmlspecialchars($v['Student_id']) ?></td>
                <td><?= htmlspecialchars($v['FirstName']) ?></td>
                <td><?= htmlspecialchars($v['Visitor_Name']) ?></td>
                <td><?= htmlspecialchars($v['Phone_number']) ?></td>
                <td><?= htmlspecialchars($v['Relationship']) ?></td>
                <td><?= htmlspecialchars($v['visit_date']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<a href="../dashboard_admin.php" class="back-link">← Back to Admin Dashboard</a>


<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

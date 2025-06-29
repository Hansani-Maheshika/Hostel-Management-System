<?php
session_start();
if ($_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit;
}
include '../db.php';

$student_id = $_SESSION['user_id'];

// Handle complaint submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['Title'];
    $description = $_POST['Description'];
    $report_date = $_POST['Report_Date'];
    $action = "Pending"; // ✅ Set default status

    $stmt = $pdo->prepare("INSERT INTO complaints (Title, Description, Student_id, Report_Date, Action) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $student_id, $report_date, $action]);
}

// Fetch own complaints
$own_stmt = $pdo->prepare("SELECT * FROM complaints WHERE Student_id = ? ORDER BY Complaint_id DESC");
$own_stmt->execute([$student_id]);
$own_complaints = $own_stmt->fetchAll();

// Fetch all complaints with student names
$all_stmt = $pdo->prepare("SELECT c.*, s.FirstName, s.LastName FROM complaints c JOIN student s ON c.Student_id = s.Student_id ORDER BY c.Complaint_id DESC");
$all_stmt->execute();
$all_complaints = $all_stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Complaints</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #fbc2eb, #a6c1ee);
            padding: 30px;
        }
        h2 {
            text-align: center;
        }
        form {
            background-color: #ffffffdd;
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 12px #bbb;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        table {
            width: 90%;
            margin: 20px auto;
            background-color: #fff;
            border-collapse: collapse;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        th {
            background-color: #007bff;
            color: white;
            padding: 12px;
        }
        td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>

<h2>📩 Report a New Complaint</h2>
<form method="POST">
    <label>Complaint Title:</label>
    <input type="text" name="Title" required>

    <label>Description:</label>
    <textarea name="Description" rows="4" required></textarea>

    <label>Report Date:</label>
    <input type="date" name="Report_Date" value="<?= date('Y-m-d') ?>" required>

    <button type="submit">Submit Complaint</button>
</form>

<h2>🗂️ Your Complaints</h2>
<?php if ($own_complaints): ?>
<table>
    <tr>
        <th>Complaint ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Report Date</th>
        <th>Status</th>
    </tr>
    <?php foreach ($own_complaints as $c): ?>
    <tr>
        <td><?= 'C' . str_pad(htmlspecialchars($c['Complaint_id']), 3, '0', STR_PAD_LEFT) ?></td>
        <td><?= htmlspecialchars($c['Title']) ?></td>
        <td><?= htmlspecialchars($c['Description']) ?></td>
        <td><?= htmlspecialchars($c['Report_Date']) ?></td>
        <td><?= htmlspecialchars($c['Action']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p style="text-align:center;">You haven't submitted any complaints yet.</p>
<?php endif; ?>

<h2>📝 All Complaints by Students</h2>
<table>
    <tr>
        <th>Complaint ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Student</th>
        <th>Report Date</th>
        <th>Status</th>
    </tr>
    <?php foreach ($all_complaints as $c): ?>
    <tr>
        <td><?= 'C' . str_pad(htmlspecialchars($c['Complaint_id']), 3, '0', STR_PAD_LEFT) ?></td>
        <td><?= htmlspecialchars($c['Title']) ?></td>
        <td><?= htmlspecialchars($c['Description']) ?></td>
        <td><?= htmlspecialchars($c['FirstName'] . ' ' . $c['LastName']) ?></td>
        <td><?= htmlspecialchars($c['Report_Date']) ?></td>
        <td><?= htmlspecialchars($c['Action']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<a class="back-link" href="../dashboard_student.php">← Back to Dashboard</a>

</body>
</html>

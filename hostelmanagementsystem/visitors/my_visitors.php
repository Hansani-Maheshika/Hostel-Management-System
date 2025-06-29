<?php
session_start();
if ($_SESSION['role'] !== 'student') {
    header("Location: ../login.php");
    exit;
}
include '../db.php';

$student_id = $_SESSION['user_id'];

// Handle Add Visitor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vname = $_POST['Name'];
    $vphone = $_POST['Phone_number'];
    $relation = $_POST['Relationship'];
    $vdate = $_POST['visit_date'];

    $insert = $pdo->prepare("INSERT INTO visitors (Student_id, Name, Phone_number, Relationship, visit_date) VALUES (?, ?, ?, ?, ?)");
    $insert->execute([$student_id, $vname, $vphone, $relation, $vdate]);

    header("Location: my_visitors.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $visitorName = $_GET['delete'];
    $delete = $pdo->prepare("DELETE FROM visitors WHERE Student_id = ? AND Name = ?");
    $delete->execute([$student_id, $visitorName]);
    header("Location: my_visitors.php");
    exit;
}

// Get all visitors
$stmt = $pdo->prepare("SELECT * FROM visitors WHERE Student_id = ?");
$stmt->execute([$student_id]);
$visitors = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Visitors</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #d9afd9, #97d9e1);
            padding: 30px;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        form, table {
            background-color: #ffffffee;
            width: 60%;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 12px #bbb;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        table {
            border-collapse: collapse;
        }
        th {
            background-color: #007bff;
            color: white;
            padding: 10px;
        }
        td {
            text-align: center;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .delete-btn {
            color: white;
            background-color: #dc3545;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
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

<h2>🧑‍🤝‍🧑 Manage Your Visitors</h2>

<form method="POST">
    <label>Visitor Name:</label>
    <input type="text" name="Name" required>

    <label>Phone Number:</label>
    <input type="text" name="Phone_number" required>

    <label>Relationship:</label>
    <select name="Relationship" required>
        <option value="Father">Father</option>
        <option value="Mother">Mother</option>
        <option value="Brother">Brother</option>
        <option value="Sister">Sister</option>
        <option value="Friend">Friend</option>
    </select>

    <label>Visit Date:</label>
    <input type="date" name="visit_date" required>

    <button type="submit">Add Visitor</button>
</form>

<?php if (count($visitors) > 0): ?>
    <h2>Your Visitors</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Relationship</th>
            <th>Visit Date</th>
            <th>Action</th>
        </tr>
        <?php foreach ($visitors as $v): ?>
        <tr>
            <td><?= htmlspecialchars($v['Name']) ?></td>
            <td><?= htmlspecialchars($v['Phone_number']) ?></td>
            <td><?= htmlspecialchars($v['Relationship']) ?></td>
            <td><?= htmlspecialchars($v['visit_date']) ?></td>
            <td>
                <a class="delete-btn" href="?delete=<?= urlencode($v['Name']) ?>" onclick="return confirm('Are you sure to delete this visitor?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p style="text-align:center;">No visitors added yet.</p>
<?php endif; ?>

<a class="back-link" href="../dashboard_student.php">← Back to Dashboard</a>

</body>
</html>

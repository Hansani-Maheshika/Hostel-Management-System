<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require_once('../../db.php');

$errors = [];
$warden_id = $name = $phone = $admin_id = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $warden_id = trim($_POST['Warden_id']);
    $name = trim($_POST['Name']);
    $phone = trim($_POST['Phone_number']);
    $admin_id = trim($_POST['Admin_id']);

    if (!$warden_id || !$name || !$phone || !$admin_id) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO warden (Warden_id, Name, Phone_number, Admin_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$warden_id, $name, $phone, $admin_id]);
        header("Location: warden_list.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Warden</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
        }

        .form-container {
            max-width: 600px;
            margin: 60px auto;
            background-color: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .btn-primary {
            width: 100%;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            font-weight: 500;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>➕ Add New Warden</h2>

    <?php if ($errors): ?>
        <div class="error-message">
            <?= implode('<br>', $errors); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="Warden_id" class="form-label">Warden ID</label>
            <input type="text" name="Warden_id" id="Warden_id" class="form-control" required value="<?= htmlspecialchars($warden_id) ?>">
        </div>

        <div class="mb-3">
            <label for="Name" class="form-label">Name</label>
            <input type="text" name="Name" id="Name" class="form-control" required value="<?= htmlspecialchars($name) ?>">
        </div>

        <div class="mb-3">
            <label for="Phone_number" class="form-label">Phone Number</label>
            <input type="text" name="Phone_number" id="Phone_number" class="form-control" required value="<?= htmlspecialchars($phone) ?>">
        </div>

        <div class="mb-3">
            <label for="Admin_id" class="form-label">Admin ID</label>
            <input type="text" name="Admin_id" id="Admin_id" class="form-control" required value="<?= htmlspecialchars($admin_id) ?>">
        </div>

        <button type="submit" class="btn btn-primary">Add Warden</button>
    </form>

    <a href="warden_list.php" class="back-link">← Back to Warden List</a>
</div>

</body>
</html>

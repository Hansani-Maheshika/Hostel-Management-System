<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];

    $stmt = $pdo->prepare("SELECT * FROM WARDEN WHERE Warden_id = ? AND Name = ?");
    $stmt->execute([$user_id, $name]);

    if ($stmt->fetch()) {
        $_SESSION['role'] = 'warden';
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;
        header("Location: dashboard_warden.php");
        exit;
    } else {
        echo "Invalid Warden credentials.";
    }
} else {
    header("Location: login_warden.php");
    exit;
}

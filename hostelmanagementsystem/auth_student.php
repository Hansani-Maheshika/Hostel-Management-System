<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];

    $stmt = $pdo->prepare("SELECT * FROM STUDENT WHERE Student_id = ? AND FirstName = ?");
    $stmt->execute([$user_id, $name]);

    if ($stmt->fetch()) {
        $_SESSION['role'] = 'student';
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;
        header("Location: dashboard_student.php");
        exit;
    } else {
        echo "Invalid Student credentials.";
    }
} else {
    header("Location: login_student.php");
    exit;
}

<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $action = $_POST['action'];

    if ($action === 'signup') {
        $phone = $_POST['phone_number'];

        // Check if Admin already exists
        $stmt = $pdo->prepare("SELECT * FROM ADMIN WHERE Admin_id = ?");
        $stmt->execute([$user_id]);
        if ($stmt->fetch()) {
            echo "Admin ID already exists. Please login.";
            exit;
        }

        // Insert new Admin
        $insert = $pdo->prepare("INSERT INTO ADMIN (Admin_id, Name, Phone_number) VALUES (?, ?, ?)");
        $insert->execute([$user_id, $name, $phone]);

        $_SESSION['role'] = 'admin';
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;
        header("Location:dashboard_admin.php");
        exit;
    }
    elseif ($action === 'login') {
        // Login without phone number
        $stmt = $pdo->prepare("SELECT * FROM ADMIN WHERE Admin_id = ? AND Name = ?");
        $stmt->execute([$user_id, $name]);
        if ($stmt->fetch()) {
            $_SESSION['role'] = 'admin';
            $_SESSION['user_id'] = $user_id;
            $_SESSION['name'] = $name;
            header("Location: dashboard_admin.php");
            exit;
        } else {
            echo "Invalid Admin credentials.";
            exit;
        }
    }
    else {
        echo "Invalid action.";
        exit;
    }
} else {
    header("Location: login_admin.php");
    exit;
}


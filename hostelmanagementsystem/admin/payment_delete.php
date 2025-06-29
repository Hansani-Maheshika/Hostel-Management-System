<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
require_once '../db.php';

$id = $_GET['id'] ?? '';
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM payments WHERE Payment_id = ?");
    $stmt->execute([$id]);
}

header("Location: payment_list.php");
exit;

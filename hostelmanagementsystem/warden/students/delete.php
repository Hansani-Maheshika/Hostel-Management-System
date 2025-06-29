<?php
session_start();
include '../../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'warden') {
    header("Location: ../../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "Invalid Request";
    exit;
}

$student_id = $_GET['id'];
$warden_id = $_SESSION['user_id'];

// Check student belongs to this warden
$check = $pdo->prepare("SELECT * FROM student WHERE Student_id = ? AND Warden_id = ?");
$check->execute([$student_id, $warden_id]);
if ($check->rowCount() === 0) {
    echo "Access denied or student not found.";
    exit;
}

try {
    $pdo->beginTransaction();

    // Step 0: Get the Room_id of the student
    $roomStmt = $pdo->prepare("SELECT Room_id FROM student WHERE Student_id = ? AND Warden_id = ?");
    $roomStmt->execute([$student_id, $warden_id]);
    $room = $roomStmt->fetch(PDO::FETCH_ASSOC);

    if ($room) {
        $room_id = $room['Room_id'];

        // Decrement occupied count by 1 in rooms table for that room_id
        $updateRoom = $pdo->prepare("UPDATE room SET Occupied_Count = Occupied_Count - 1 WHERE Room_id = ? AND Occupied_Count > 0");
        $updateRoom->execute([$room_id]);
    }

 

    // Step 3: Delete complaints
    $deleteComplaints = $pdo->prepare("DELETE FROM complaints WHERE Student_id = ?");
    $deleteComplaints->execute([$student_id]);

    // Step 4: Delete payments
    $deletePayments = $pdo->prepare("DELETE FROM payments WHERE Student_id = ?");
    $deletePayments->execute([$student_id]);

    // Step 5: Delete phone numbers
    $deletePhone = $pdo->prepare("DELETE FROM stu_phone_number WHERE Student_id = ?");
    $deletePhone->execute([$student_id]);

    // Step 6: Delete visitors
    $deleteVisitors = $pdo->prepare("DELETE FROM visitors WHERE Student_id = ?");
    $deleteVisitors->execute([$student_id]);

    // Removed allocated delete since table doesn't exist

    // Step 7: Finally delete the student
    $deleteStudent = $pdo->prepare("DELETE FROM student WHERE Student_id = ? AND Warden_id = ?");
    $deleteStudent->execute([$student_id, $warden_id]);

    $pdo->commit();

    header("Location: list.php?msg=deleted");
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Failed to delete student: " . $e->getMessage();
    exit;
}

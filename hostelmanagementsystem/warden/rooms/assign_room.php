<?php
session_start();
if ($_SESSION['role'] !== 'warden') {
    header("Location: ../login.php");
    exit;
}

include '../../db.php';

$room_id = $_GET['room_id'] ?? '';
if (!$room_id) {
    echo "Room ID missing.";
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['Student_id'];

    // Check if student exists and has no room assigned
    $check = $pdo->prepare("SELECT Room_id FROM student WHERE Student_id = ?");
    $check->execute([$student_id]);
    $student = $check->fetch();

    if (!$student) {
        $message = "Student ID not found.";
    } elseif ($student['Room_id'] !== null) {
        $message = "Student is already assigned to a room.";
    } else {
        // Check room capacity
        $roomCheck = $pdo->prepare("SELECT Capacity, Occupied_Count FROM room WHERE Room_id = ?");
        $roomCheck->execute([$room_id]);
        $room = $roomCheck->fetch();

        if (!$room) {
            $message = "Room not found.";
        } elseif ($room['Occupied_Count'] >= $room['Capacity']) {
            $message = "Room capacity full. Cannot assign more students.";
        } else {
            // Proceed to assign
            $pdo->beginTransaction();
            try {
                $update_student = $pdo->prepare("UPDATE student SET Room_id = ? WHERE Student_id = ?");
                $update_student->execute([$room_id, $student_id]);

                $update_room = $pdo->prepare("UPDATE room SET Occupied_Count = Occupied_Count + 1 WHERE Room_id = ?");
                $update_room->execute([$room_id]);

                $pdo->commit();
                header("Location: view_rooms.php");
                exit;
            } catch (Exception $e) {
                $pdo->rollBack();
                $message = "Error: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Room <?= htmlspecialchars($room_id) ?> to Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fefefe;
            margin: 40px auto;
            max-width: 600px;
            color: #333;
            padding: 0 20px 40px;
        }
        h2 {
            text-align: center;
            color: #222;
            margin-bottom: 30px;
            font-weight: 600;
        }
        form {
            background: #fff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
            max-width: 400px;
            margin: 0 auto 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 15px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 12px 0;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #45a049;
        }
        p.message {
            max-width: 400px;
            margin: 0 auto 20px;
            color: red;
            font-weight: 600;
            text-align: center;
        }
        a.back-link {
            display: block;
            width: fit-content;
            margin: 0 auto;
            text-align: center;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        a.back-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2>Assign Room <?= htmlspecialchars($room_id) ?> to Student</h2>

<?php if ($message): ?>
    <p class="message"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST" novalidate>
    <label for="Student_id">Student ID:</label>
    <input type="text" name="Student_id" id="Student_id" required placeholder="Enter Student ID">

    <button type="submit">Assign Room</button>
</form>

<a href="view_rooms.php" class="back-link">⬅ Back to Room List</a>

</body>
</html>

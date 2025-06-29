<?php
session_start();
if ($_SESSION['role'] !== 'warden') {
    header("Location: ../login.php");
    exit;
}
include '../../db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['Room_id'];
    $room_no = $_POST['Room_no'];
    $room_type = $_POST['Room_Type'];
    $ac_type = $_POST['AC_Type'];
    $capacity = $_POST['Capacity'];

    $check = $pdo->prepare("SELECT * FROM room WHERE Room_id = ?");
    $check->execute([$room_id]);

    if ($check->rowCount() > 0) {
        $error = "Room ID already exists.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO room (Room_id,Room_no ,Room_Type,AC_Type, Capacity, Occupied_Count) VALUES (?, ?,?,?, ?, 0)");
        $stmt->execute([$room_id, $room_no, $room_type, $ac_type, $capacity]);
        header("Location: view_rooms.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add New Room</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 40px auto;
            padding: 20px 25px;
            background-color: #fafafa;
            color: #333;
            border-radius: 6px;
            box-shadow: 0 0 8px rgba(0,0,0,0.05);
        }
        h2 {
            text-align: center;
            color: #4a6fa5;
            margin-bottom: 25px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 6px;
            font-weight: 600;
            color: #3b5998;
        }
        input[type="text"],
        input[type="number"],
        select {
            padding: 8px 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 15px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #3467c6;
            outline: none;
        }
        button {
            padding: 10px 0;
            background-color: #3467c6;
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        button:hover {
            background-color: #1e3c72;
        }
        .error-message {
            color: #d9534f;
            font-weight: 600;
            margin-bottom: 15px;
            text-align: center;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #3b5998;
            border: 1px solid #aac4f7;
            background-color: #d9e2f3;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .back-link:hover {
            background-color: #aac4f7;
            color: #1e3c72;
        }
    </style>
</head>
<body>

<h2>Add New Room</h2>

<?php if ($error): ?>
    <p class="error-message"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="">
    <label for="Room_id">Room ID:</label>
    <input id="Room_id" name="Room_id" required>

    <label for="Room_no">Room No:</label>
    <input id="Room_no" type="text" name="Room_no" required>

    <label for="Room_Type">Room Type:</label>
    <input id="Room_Type" name="Room_Type" required>

    <label for="AC_Type">AC Type:</label>
    <select id="AC_Type" name="AC_Type" required>
        <option value="AC">AC</option>
        <option value="Non-AC">Non-AC</option>
    </select>

    <label for="Capacity">Capacity:</label>
    <input id="Capacity" name="Capacity" type="number" min="1" required>

    <button type="submit">Add Room</button>
</form>

<a href="view_rooms.php" class="back-link">⬅ Back to Room List</a>

</body>
</html>

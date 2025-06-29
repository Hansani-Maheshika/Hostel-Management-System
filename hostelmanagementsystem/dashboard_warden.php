<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'warden') {
    header("Location: index.php");
    exit;
}

$warden_id = $_SESSION['user_id'];
$warden_name = $_SESSION['username'] ?? 'Warden ' . htmlspecialchars($warden_id);
$login_time = date("Y-m-d H:i:s");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Warden Dashboard - Hostel Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .topbar {
            background-color: #2c3e50;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
        }
        .dashboard-header {
            background: white;
            padding: 1.5rem 2rem;
            margin: 1.5rem auto;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .dashboard-header h2 {
            margin: 0;
            font-size: 24px;
        }
        .card-box {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
            padding: 1.5rem;
        }
        .card-box i {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .card-footer-btn {
            margin-top: 1rem;
        }
        .logout-btn {
            margin: 2rem auto 1rem;
            display: block;
        }
        footer {
            background-color: #2c3e50;
            color: white;
            padding: 10px 0;
            text-align: center;
            margin-top: 3rem;
        }
    </style>
</head>
<body>

<!-- Top Navbar -->
<div class="topbar">
    <div><strong>Hostel Management System</strong></div>
    <div>🏢 Warden: <?= htmlspecialchars($warden_id) ?></div>
</div>

<div class="container">
    <!-- Welcome Banner -->
    <div class="dashboard-header text-center">
        <h2>Warden Dashboard</h2>
        <p>Manage students, rooms, and monitor complaints effectively.</p>
    </div>

    <div class="row g-4">
        <!-- Manage Students -->
        <div class="col-md-4">
            <div class="card-box text-center">
                <i class="fa fa-users text-primary"></i>
                <h5 class="mt-2">Manage Students</h5>
                <p>View and manage students under your supervision.</p>
                <a href="warden/students/list.php" class="btn btn-primary card-footer-btn">Manage Students</a>
            </div>
        </div>

        <!-- Manage Rooms -->
        <div class="col-md-4">
            <div class="card-box text-center">
                <i class="fa fa-door-open text-warning"></i>
                <h5 class="mt-2">Manage Rooms</h5>
                <p>Assign, edit, or view room availability.</p>
                <a href="warden/rooms/view_rooms.php" class="btn btn-warning text-white card-footer-btn">Manage Rooms</a>
            </div>
        </div>

        <!-- View Complaints -->
        <div class="col-md-4">
            <div class="card-box text-center">
                <i class="fa fa-comment-dots text-success"></i>
                <h5 class="mt-2">View Complaints</h5>
                <p>Review and update student complaints.</p>
                <a href="warden/complaints/list.php" class="btn btn-success card-footer-btn">View Complaints</a>
            </div>
        </div>

        <!-- System Info -->
        <div class="col-md-4">
            <div class="card-box">
                <h5 class="mb-3">System Info</h5>
                <p><strong>Login Time:</strong> <?= $login_time ?></p>
                <p><strong>User Role:</strong> Warden</p>
                <p><strong>Status:</strong> Active</p>
            </div>
        </div>
    </div>

    <!-- Logout -->
    <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>
</div>

<!-- Footer -->
<footer>
    <p>&copy; <?= date("Y") ?> Hostel Management System. All rights reserved.</p>
</footer>

</body>
</html>


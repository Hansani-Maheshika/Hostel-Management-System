<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['user_id'];
$student_name = $_SESSION['username'] ?? 'Student ' . htmlspecialchars($student_id);
$login_time = date("Y-m-d H:i:s"); // optionally store this in session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard - Hostel Management System</title>
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
    <div>👤 Student: <?= htmlspecialchars($student_id) ?></div>
</div>

<div class="container">
    <!-- Welcome Banner -->
    <div class="dashboard-header text-center">
        <h2>Student Dashboard</h2>
        <p>Manage your hostel profile, view complaints, payments, and room details.</p>
    </div>

    <div class="row g-4">
        <!-- Student Profile -->
        <div class="col-md-6">
            <div class="card-box text-center">
                <i class="fa fa-user-circle text-primary"></i>
                <h5 class="mt-2">Profile</h5>
                <p>View and update your student details.</p>
                <a href="student/list.php" class="btn btn-primary card-footer-btn">Manage Profile</a>
            </div>
        </div>

        <!-- Complaints -->
        <div class="col-md-6">
            <div class="card-box text-center">
                <i class="fa fa-comments text-success"></i>
                <h5 class="mt-2">Complaints</h5>
                <p>View, add, and track your complaints.</p>
                <a href="complaints/my_complaints.php" class="btn btn-success card-footer-btn">View Complaints</a>
            </div>
        </div>

        <!-- Payments -->
        <div class="col-md-6">
            <div class="card-box text-center">
                <i class="fa fa-credit-card text-warning"></i>
                <h5 class="mt-2">Payments</h5>
                <p>Make hostel payments and check status.</p>
                <a href="payments/my_payments.php" class="btn btn-warning text-white card-footer-btn">View / Make Payments</a>
            </div>
        </div>

        <!-- Visitors -->
        <div class="col-md-6">
            <div class="card-box text-center">
                <i class="fa fa-users text-info"></i>
                <h5 class="mt-2">Visitors</h5>
                <p>Add and manage your visitor entries.</p>
                <a href="visitors/my_visitors.php" class="btn btn-info text-white card-footer-btn">Manage Visitors</a>
            </div>
        </div>

        <!-- Room Details -->
        <div class="col-md-6">
            <div class="card-box text-center">
                <i class="fa fa-door-open text-secondary"></i>
                <h5 class="mt-2">Room</h5>
                <p>Check your current room assignment.</p>
                <a href="rooms/my_room.php" class="btn btn-secondary card-footer-btn">View Room</a>
            </div>
        </div>

        <!-- System Info -->
        <div class="col-md-6">
            <div class="card-box">
                <h5 class="mb-3">System Info</h5>
                <p><strong>Login Time:</strong> <?= $login_time ?></p>
                <p><strong>User Role:</strong> Student</p>
                <p><strong>Status:</strong> Active</p>
            </div>
        </div>
    </div>

    <!-- Logout Button -->
    <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>
</div>

<!-- Footer -->
<footer>
    <p>&copy; <?= date("Y") ?> Hostel Management System. All rights reserved.</p>
</footer>

</body>
</html>

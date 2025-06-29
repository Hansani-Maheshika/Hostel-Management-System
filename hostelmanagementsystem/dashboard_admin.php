<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
$admin_id = $_SESSION['user_id'];
$admin_name = $_SESSION['username'] ?? 'Admin ' . htmlspecialchars($admin_id);
$login_time = date("Y-m-d H:i:s");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Hostel Management System</title>
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
    <div>🧑‍💼 Admin: <?= htmlspecialchars($admin_id) ?></div>
</div>

<div class="container">
    <!-- Welcome Header -->
    <div class="dashboard-header text-center">
        <h2>Admin Dashboard</h2>
        <p>Manage wardens, payments, and system-level operations.</p>
    </div>

    <div class="row g-4">
        <!-- Manage Wardens -->
        <div class="col-md-4">
            <div class="card-box text-center">
                <i class="fa fa-user-tie text-primary"></i>
                <h5 class="mt-2">Manage Wardens</h5>
                <p>View and manage warden accounts.</p>
                <a href="admin/wardens/warden_list.php" class="btn btn-primary card-footer-btn">Manage Wardens</a>
            </div>
        </div>

        <!-- Manage Payments -->
        <div class="col-md-4">
            <div class="card-box text-center">
                <i class="fa fa-credit-card text-warning"></i>
                <h5 class="mt-2">Manage Payments</h5>
                <p>Track and verify student payments.</p>
                <a href="admin/payment_list.php" class="btn btn-warning text-white card-footer-btn">Manage Payments</a>
            </div>
        </div>

        <!-- View Visitors -->
        <div class="col-md-4">
            <div class="card-box text-center">
                <i class="fa fa-users text-success"></i>
                <h5 class="mt-2">View Visitors</h5>
                <p>Review all visitor records in the system.</p>
                <a href="admin/view_visitors.php" class="btn btn-success card-footer-btn">View Visitors</a>
            </div>
        </div>

        <!-- System Info -->
        <div class="col-md-4">
            <div class="card-box">
                <h5 class="mb-3">System Info</h5>
                <p><strong>Login Time:</strong> <?= $login_time ?></p>
                <p><strong>User Role:</strong> Admin</p>
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


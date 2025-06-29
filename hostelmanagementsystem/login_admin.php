<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Hostel Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card p-4 shadow" style="width: 350px;">
    <h3 class="mb-4 text-center">Admin Login</h3>

    <form action="auth_admin.php" method="POST">
        <div class="mb-3">
            <label for="admin_id" class="form-label">Admin ID</label>
            <input type="text" class="form-control" id="admin_id" name="user_id" required>
        </div>
        <div class="mb-3">
            <label for="admin_name" class="form-label">Name</label>
            <input type="text" class="form-control" id="admin_name" name="name" required>
        </div>
        <button type="submit" name="action" value="login" class="btn btn-primary w-100">Login</button>
    </form>

    <a href="signup_admin.php" class="btn btn-success w-100 mt-2">Sign Up</a>
    <a href="index.php" class="btn btn-link mt-3 w-100">Back to Home</a>
</div>

</body>
</html>

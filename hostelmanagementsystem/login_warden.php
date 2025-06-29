<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Warden Login - Hostel Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card p-4 shadow" style="width: 350px;">
    <h3 class="mb-4 text-center">Warden Login</h3>

    <form action="auth_warden.php" method="POST">
        <div class="mb-3">
            <label for="warden_id" class="form-label">Warden ID</label>
            <input type="text" class="form-control" id="warden_id" name="user_id" required>
        </div>
        <div class="mb-3">
            <label for="warden_name" class="form-label">Name</label>
            <input type="text" class="form-control" id="warden_name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <a href="index.php" class="btn btn-link mt-3 w-100">Back to Home</a>
</div>

</body>
</html>

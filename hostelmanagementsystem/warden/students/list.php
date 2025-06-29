<?php 
session_start(); 
include '../../db.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'warden') { 
    header("Location: ../../login.php"); 
    exit; 
} 

$wardenId = $_SESSION['user_id']; 
$stmt = $pdo->prepare(" 
    SELECT s.Student_id, s.FirstName, s.LastName, s.Duration_Stay, p.Phone_Number 
    FROM STUDENT s 
    LEFT JOIN STU_PHONE_NUMBER p ON s.Student_id = p.Student_id 
    WHERE s.Warden_id = ? 
"); 
$stmt->execute([$wardenId]); 
$students = $stmt->fetchAll(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warden - Student List</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h2 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .add-btn {
            background: #28a745;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        }

        .add-btn:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
        }

        .student-count {
            color: #666;
            font-size: 16px;
            font-weight: 500;
        }

        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            font-size: 15px;
        }

        th {
            background: #f8f9fa;
            color: #495057;
            font-weight: 600;
            padding: 18px 15px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 18px 15px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.2s ease;
        }

        .student-name {
            font-weight: 600;
            color: #495057;
        }

        .student-id {
            font-family: 'Courier New', monospace;
            background: #e9ecef;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
        }

        .duration-badge {
            background: #007bff;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .phone-number {
            font-family: 'Courier New', monospace;
            color: #666;
        }

        .na-text {
            color: #999;
            font-style: italic;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-align: center;
            min-width: 70px;
        }

        .btn-edit {
            background: #007bff;
            color: white;
        }

        .btn-edit:hover {
            background: #0056b3;
            transform: translateY(-1px);
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
            transform: translateY(-1px);
        }

        .back-btn {
            background: #dc3545;
            color: white;
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            display: block;
            width: fit-content;
            margin: 0 auto;
            text-align: center;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        .back-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #999;
        }

        .empty-state p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .content {
                padding: 20px;
            }

            .header {
                padding: 20px;
            }

            .header h2 {
                font-size: 24px;
            }

            .action-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .add-btn {
                text-align: center;
            }

            th, td {
                padding: 12px 8px;
                font-size: 14px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                margin-bottom: 4px;
            }
        }

        @media (max-width: 480px) {
            .table-container {
                font-size: 12px;
            }

            th, td {
                padding: 8px 4px;
            }

            .student-id {
                font-size: 11px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Students Management</h2>
            <p>Manage students assigned to your supervision</p>
        </div>
        
        <div class="content">
            <div class="action-bar">
                <div class="student-count">
                    Total Students: <strong><?= count($students) ?></strong>
                </div>
                <a class="add-btn" href="add.php">➕ Add New Student</a>
            </div>

            <?php if (empty($students)): ?>
                <div class="empty-state">
                    <h3>No Students Found</h3>
                    <p>You don't have any students assigned to you yet.</p>
                    <a class="add-btn" href="add.php">Add Your First Student</a>
                </div>
            <?php else: ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Full Name</th>
                                <th>Phone Number</th>
                                <th>Duration Stay</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                            <tr>
                                <td>
                                    <span class="student-id"><?= htmlspecialchars($student['Student_id']) ?></span>
                                </td>
                                <td>
                                    <span class="student-name">
                                        <?= htmlspecialchars($student['FirstName'] . ' ' . $student['LastName']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($student['Phone_Number']): ?>
                                        <span class="phone-number"><?= htmlspecialchars($student['Phone_Number']) ?></span>
                                    <?php else: ?>
                                        <span class="na-text">Not provided</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="duration-badge">
                                        <?= htmlspecialchars($student['Duration_Stay']) ?> 
                                        <?= $student['Duration_Stay'] == 1 ? 'Year' : 'Years' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a class="btn btn-edit" href="edit.php?id=<?= $student['Student_id'] ?>">
                                            Edit
                                        </a>
                                        <a class="btn btn-delete" 
                                           href="delete.php?id=<?= $student['Student_id'] ?>" 
                                           onclick="return confirm('Are you sure you want to delete this student? This action cannot be undone.')">
                                             Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            
            <a href="../../dashboard_warden.php" class="back-btn">⬅ Back to Warden Dashboard</a>
        </div>
    </div>
</body>
</html>
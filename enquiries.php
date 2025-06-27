<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include "db.php";

$result = $conn->query("SELECT * FROM enquiries ORDER BY submitted_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enquiry Submissions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            padding: 40px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        th {
            background: #007BFF;
            color: white;
        }
        tr:hover {
            background: #f1f1f1;
        }
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 16px;
            background: #6c757d;
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }
        .back-btn:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>

    
    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
    <h2>All Enquiries</h2>
    <table>
        <tr>
            <th>Name</th><th>Email</th><th>Phone</th>
            <th>Event</th><th>Date</th><th>Location</th>
            <th>Message</th><th>Time</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= $row['event_type'] ?></td>
            <td><?= $row['event_date'] ?></td>
            <td><?= $row['event_location'] ?></td>
            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
            <td><?= $row['submitted_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

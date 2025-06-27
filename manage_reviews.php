<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit;
}
$reviews = $conn->query("SELECT r.*, p.title FROM package_reviews r LEFT JOIN packages p ON r.package_id = p.id ORDER BY r.created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Reviews</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f6f9;
      padding: 30px;
    }

    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 25px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 12px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 14px 16px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #34495e;
      color: white;
    }

    tr:hover {
      background-color: #f2f2f2;
    }

    a.delete-btn {
      color: #e74c3c;
      font-weight: bold;
      text-decoration: none;
    }

    a.delete-btn:hover {
      text-decoration: underline;
    }

    td:last-child {
      text-align: center;
    }
  </style>
</head>
<body>

  <h2>All Package Reviews</h2>

  <table>
    <tr>
      <th>Reviewer</th>
      <th>Package</th>
      <th>Rating</th>
      <th>Review</th>
      <th>Actions</th>
    </tr>
    <?php while($r = $reviews->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($r['reviewer_name']) ?></td>
        <td><?= htmlspecialchars($r['title']) ?></td>
        <td><?= htmlspecialchars($r['rating']) ?>/5</td>
        <td><?= htmlspecialchars($r['review']) ?></td>
        <td>
          <a class="delete-btn" href="delete_review.php?id=<?= $r['id'] ?>" onclick="return confirm('Delete this review?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>

</body>
</html>

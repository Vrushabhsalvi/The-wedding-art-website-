<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit;
}
$packages = $conn->query("SELECT * FROM packages ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Packages</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f4f9;
      margin: 0;
      padding: 20px;
      color: #333;
    }

    h2 {
      text-align: center;
      color: #2c3e50;
    }

    .btn-add {
      display: inline-block;
      background: #27ae60;
      color: white;
      padding: 10px 16px;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .btn-add:hover {
      background: #1e8449;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 14px 16px;
      border-bottom: 1px solid #eee;
      text-align: left;
    }

    th {
      background-color: #2980b9;
      color: white;
    }

    tr:hover {
      background-color: #f2f2f2;
    }

    a.action {
      color: #e74c3c;
      text-decoration: none;
      font-weight: bold;
    }

    a.action:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <h2>Manage Packages</h2>
  <a class="btn-add" href="add_package.php">+ Add New Package</a>

  <table>
    <tr>
      <th>Title</th>
      <th>Price</th>
      <th>Description</th>
      <th>Actions</th>
    </tr>
    <?php while($p = $packages->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($p['title']) ?></td>
        <td><?= htmlspecialchars($p['price']) ?></td>
        <td><?= htmlspecialchars($p['description']) ?></td>
        <td>
          <a class="action" href="delete_package.php?id=<?= $p['id'] ?>" onclick="return confirm('Delete this package?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>

</body>
</html>

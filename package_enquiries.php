<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit;
}
$enquiries = $conn->query("SELECT e.*, p.title AS package_title FROM package_inquiries e
LEFT JOIN packages p ON e.package_id = p.id
ORDER BY e.submitted_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Package Enquiries</title>
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
      background-color: #f9f9f9;
    }

    .whatsapp {
      color: green;
      font-weight: bold;
    }

    .no-whatsapp {
      color: #aaa;
    }
  </style>
</head>
<body>

  <h2>All Package Enquiries</h2>

  <table>
    <tr>
      <th>Package</th>
      <th>Name</th>
      <th>Phone</th>
      <th>Email</th>
      <th>Function Date</th>
      <th>Message</th>
      <th>WhatsApp?</th>
      <th>Submitted</th>
    </tr>
    <?php while($e = $enquiries->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($e['package_title']) ?></td>
        <td><?= htmlspecialchars($e['name']) ?></td>
        <td><?= htmlspecialchars($e['phone']) ?></td>
        <td><?= htmlspecialchars($e['email']) ?></td>
        <td><?= htmlspecialchars($e['function_date']) ?></td>
        <td><?= nl2br(htmlspecialchars($e['message'])) ?></td>
        <td class="<?= $e['notify_whatsapp'] ? 'whatsapp' : 'no-whatsapp' ?>">
          <?= $e['notify_whatsapp'] ? 'Yes ✅' : 'No' ?>
        </td>
        <td><?= date("d M Y, H:i", strtotime($e['submitted_at'])) ?></td>
      </tr>
    <?php endwhile; ?>
  </table>

</body>
</html>

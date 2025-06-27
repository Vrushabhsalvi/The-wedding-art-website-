<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'admin/db.php';

$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $package_id = intval($_POST['package_id']);
    $name = trim($_POST['reviewer_name']);
    $rating = floatval($_POST['rating']);
    $review = trim($_POST['review']);

    if ($package_id && $name && $rating && $review) {
        $stmt = $conn->prepare("INSERT INTO package_reviews (package_id, reviewer_name, rating, review) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isds", $package_id, $name, $rating, $review);
        $stmt->execute();
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Review Submitted</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f0f2f5;
      text-align: center;
      padding: 50px;
    }
    .card {
      max-width: 500px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0,0,0,0.1);
    }
    h2 {
      color: #2ecc71;
    }
    p {
      margin-top: 10px;
      font-size: 16px;
    }
    a {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: #fff;
      background: #3498db;
      padding: 10px 20px;
      border-radius: 5px;
    }
    a:hover {
      background: #2980b9;
    }
  </style>
</head>
<body>

  <div class="card">
    <?php if ($success): ?>
      <h2>Thank You!</h2>
      <p>Your review has been submitted successfully.</p>
    <?php else: ?>
      <h2 style="color:#e74c3c;">Error</h2>
      <p>Something went wrong. Please try again.</p>
    <?php endif; ?>
    <a href="packages.php">← Back to Packages</a>
  </div>

</body>
</html>


<?php
include "admin/db.php";
$result = $conn->query("SELECT * FROM gallery_images ORDER BY uploaded_at DESC");
?>

<!DOCTYPE html>


<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gallery</title>
  <link rel="stylesheet" href="style1.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar (same as index) -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">The Wedding Art</a>
    <div>
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="/admin/login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
          <li class="nav-item"><a class="nav-link" href="packages.php">Packages</a></li>
        <li class="nav-item"><a class="nav-link" href="payment.html">Payment</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container my-5">
  <h2 class="text-center mb-4">Gallery</h2>
  <div class="row">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="col-md-4 mb-4">
        <img src="<?= $row['image_path'] ?>" class="img-fluid rounded" alt="Gallery Image">
      </div>
    <?php endwhile; ?>
  </div>
</div>
</body>
<!-- Footer -->
<footer class="text-center p-3 bg-dark text-white">
  © 2025 The Wedding Art Photography
</footer>

</body>
</html>
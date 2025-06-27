<?php
include 'admin/db.php';
$packages = $conn->query("SELECT * FROM packages ORDER BY id ASC");
function getPackageImages($conn, $package_id) {
  $imgs = $conn->query("SELECT image_path FROM package_images WHERE package_id = $package_id");
  return $imgs;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Our Packages</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f6f9;
      padding: 30px;
    }
    .package-card {
      display: flex;
      gap: 30px;
      margin-bottom: 60px;
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 0 12px rgba(0,0,0,0.06);
      justify-content: center;
    }
    .carousel {
      width: 22%;
    }
    .package-details {
      width: 55%;
    }
    .package-details h3 {
      color: #3498db;
    }
    .form-field {
      margin-bottom: 14px;
    }
    .form-field input, .form-field textarea {
      width: 100%; padding: 10px;
      border: 1px solid #ccc; border-radius: 5px;
    }
    .btn {
      background: #3498db; color: white;
      border: none; border-radius: 5px;
      padding: 8px 14px; margin-top: 10px;
    }
    .inquiry-form, .review-form {
      display: none;
      background: #f9f9f9;
      padding: 15px; margin-top: 20px;
      border-radius: 8px; border: 1px solid #ddd;
    }
    h2 { text-align: center; margin-bottom: 40px; color: #2c3e50; }
  </style>
</head>

 <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="margin-bottom:40px;">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">The Wedding Art</a>
      <div>
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="/admin/login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="gallery.php">Gallery</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="packages.php">Packages</a></li>
          <li class="nav-item"><a class="nav-link" href="payment.html">Payment</a></li>
        </ul>
      </div>
    </div>
  </nav>
<body>
  <h2>Our Packages</h2>
  <?php while($pkg = $packages->fetch_assoc()): ?>
    <div class="package-card">
      <!-- Carousel Section -->
      <div class="carousel slide" id="carousel<?= $pkg['id'] ?>" data-bs-ride="carousel">
        <div class="carousel-inner">
          <?php
          $images = getPackageImages($conn, $pkg['id']);
          $first = true;
          while($img = $images->fetch_assoc()): ?>
            <div class="carousel-item <?= $first ? 'active' : '' ?>">
              <img src="<?= $img['image_path'] ?>" class="d-block w-100" alt="Package Image" style="height:300px; object-fit:cover;">
            </div>
          <?php $first = false; endwhile; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $pkg['id'] ?>" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $pkg['id'] ?>" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>

      <!-- Package Content -->
      <div class="package-details">
        <h3><?= $pkg['title'] ?></h3>
        <p><strong>Price:</strong> <?= $pkg['price'] ?></p>
        <p><?= $pkg['description'] ?></p>
        <button class="btn" onclick="showForm(<?= $pkg['id'] ?>)">Enquire Now</button>
        <button class="btn" onclick="showReviewForm(<?= $pkg['id'] ?>)">Write a Review</button>

        <div id="form-<?= $pkg['id'] ?>" class="inquiry-form">
          <form action="submit_inquiry.php" method="POST">
            <input type="hidden" name="package_id" value="<?= $pkg['id'] ?>">
            <div class="form-field"><input name="name" placeholder="Full Name" required></div>
            <div class="form-field"><input name="phone" placeholder="Phone Number" required></div>
            <div class="form-field"><input name="email" placeholder="Email" required></div>
            <div class="form-field"><input type="date" name="function_date" required></div>
            <div class="form-field"><textarea name="message" placeholder="Event details..."></textarea></div>
            <div class="form-field">
              <label><input type="checkbox" name="notify_whatsapp" value="1"> Notify me on WhatsApp</label>
            </div>
            <button class="btn" type="submit">Send Enquiry</button>
          </form>
        </div>

        <div id="review-form-<?= $pkg['id'] ?>" class="review-form">
          <form action="submit_review.php" method="POST">
            <input type="hidden" name="package_id" value="<?= $pkg['id'] ?>">
            <div class="form-field"><input name="reviewer_name" placeholder="Your Name" required></div>
            <div class="form-field"><input type="number" name="rating" min="1" max="5" step="0.1" placeholder="Rating (1-5)" required></div>
            <div class="form-field"><textarea name="review" placeholder="Write your review..." required></textarea></div>
            <button class="btn" type="submit">Submit Review</button>
          </form>
        </div>

        <h4 class="mt-4">Reviews:</h4>
        <?php
          $pid = $pkg['id'];
          $reviews = $conn->query("SELECT * FROM package_reviews WHERE package_id=$pid ORDER BY created_at DESC");
          while($r = $reviews->fetch_assoc()):
        ?>
          <p><strong><?= htmlspecialchars($r['reviewer_name']) ?></strong> (<?= $r['rating'] ?>/5): <?= htmlspecialchars($r['review']) ?></p>
        <?php endwhile; ?>
      </div>
    </div>
  <?php endwhile; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function showForm(id) {
      document.querySelectorAll('.inquiry-form').forEach(f => f.style.display = 'none');
      document.getElementById('form-' + id).style.display = 'block';
    }
    function showReviewForm(id) {
      document.querySelectorAll('.review-form').forEach(f => f.style.display = 'none');
      document.getElementById('review-form-' + id).style.display = 'block';
    }
  </script>
</body>
</html>

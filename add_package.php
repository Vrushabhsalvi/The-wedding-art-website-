<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $price = $_POST['price'];
  $desc = $_POST['description'];

  $stmt = $conn->prepare("INSERT INTO packages (title, price, description) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $title, $price, $desc);
  $stmt->execute();
  $package_id = $stmt->insert_id;

  // Handle image upload
  foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
    $fileName = time() . "_" . basename($_FILES["images"]["name"][$key]);
    $targetPath = "../uploads/" . $fileName;
    if (move_uploaded_file($tmp_name, $targetPath)) {
      $imagePath = "uploads/" . $fileName;
      $conn->query("INSERT INTO package_images (package_id, image_path) VALUES ($package_id, '$imagePath')");
    }
  }

  header("Location: manage_packages.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Package</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f0f2f5;
      padding: 30px;
    }
    .form-container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 25px;
    }
    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }
    input[type="text"], textarea, input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 16px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      background: #27ae60;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }
    button:hover {
      background: #1e8449;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>Add New Package</h2>
    <form method="POST" enctype="multipart/form-data">
      <label>Title:</label>
      <input type="text" name="title" required>

      <label>Price:</label>
      <input type="text" name="price" required>

      <label>Description:</label>
      <textarea name="description" rows="5" required></textarea>

      <label>Upload Images (you can select multiple):</label>
      <input type="file" name="images[]" accept="image/*" multiple required>

      <button type="submit">Save Package</button>
    </form>
  </div>

</body>
</html>

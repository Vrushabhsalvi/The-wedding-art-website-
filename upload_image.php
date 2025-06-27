<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['gallery_image'])) {
    $targetDir = "../uploads/";
    $fileName = basename($_FILES["gallery_image"]["name"]);
    $targetFile = $targetDir . time() . "_" . $fileName;

    if (move_uploaded_file($_FILES["gallery_image"]["tmp_name"], $targetFile)) {
        $pathToStore = str_replace("../", "", $targetFile);
        $stmt = $conn->prepare("INSERT INTO gallery_images (image_path) VALUES (?)");
        $stmt->bind_param("s", $pathToStore);
        $stmt->execute();
        $success = "Image uploaded successfully.";
    } else {
        $error = "Error uploading file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Upload Gallery Image</title>
  <style>
    body {
        font-family: Arial, sans-serif;
        background: #f7f7f7;
        padding: 40px;
    }
    .form-container {
        background: white;
        padding: 30px;
        max-width: 500px;
        margin: auto;
        border-radius: 10px;
        box-shadow: 0 0 12px rgba(0,0,0,0.1);
        text-align: center;
    }
    input[type="file"] {
        margin: 15px 0;
    }
    button {
        padding: 10px 20px;
        background: #007BFF;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }
    .msg {
        margin: 15px 0;
        color: green;
    }
    .error {
        color: red;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Upload New Gallery Image</h2>
    <?php if (isset($success)) echo "<p class='msg'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST" enctype="multipart/form-data">
      <input type="file" name="gallery_image" accept="image/*" required><br>
      <button type="submit">Upload</button>
    </form>
    <br>
    <a href="dashboard.php">← Back to Dashboard</a>
  </div>
  
  
  
  <?php
$images = $conn->query("SELECT * FROM gallery_images ORDER BY uploaded_at DESC");
?>

<hr><h3>Uploaded Images</h3>
<div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
<?php while ($img = $images->fetch_assoc()): ?>
    <div style="text-align: center;">
        <img src="../<?= $img['image_path'] ?>" style="width: 150px; height: auto; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <br>
        <a href="delete_image.php?id=<?= $img['id'] ?>" 
           onclick="return confirm('Are you sure you want to delete this image?')" 
           style="display:inline-block; margin-top:8px; padding:6px 10px; background:#dc3545; color:#fff; border-radius:5px; text-decoration:none;">
           Delete
        </a>
    </div>
<?php endwhile; ?>
</div>

  
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

include "db.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Get image path
    $result = $conn->query("SELECT image_path FROM gallery_images WHERE id = $id");
    if ($row = $result->fetch_assoc()) {
        $file = "../" . $row['image_path'];
        if (file_exists($file)) {
            unlink($file); // delete image file
        }
        $conn->query("DELETE FROM gallery_images WHERE id = $id");
    }
}

header("Location: upload_image.php");
exit;

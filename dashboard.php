<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            background: #f0f2f5;
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 80px;
        }
        .dashboard {
            background: white;
            padding: 30px;
            max-width: 500px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        a {
            display: block;
            margin: 10px auto;
            padding: 12px;
            width: 80%;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    

    
<div class="dashboard">
    <h2>Welcome, Admin</h2>
    <a href="enquiries.php">View Enquiries</a>
  <a href="upload_image.php">Upload Gallery Image</a>
    <a href="manage_packages.php">View Packages</a>
          <a href="add_package.php">Add Packages
</a>
<a href="package_enquiries.php">View Package Enquiries</a>


         <a href="manage_reviews.php">Manage Reviews</a>
    <a href="logout.php" style="background:#dc3545;">Logout</a>

</div>
</body>
</html>

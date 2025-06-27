<?php
$host = "localhost";
$dbname = "u265663502_wedding_art";
$username = "u265663502_admin";  // replace with Hostinger DB user
$password = "Wedding@750!";  // replace with Hostinger DB password

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

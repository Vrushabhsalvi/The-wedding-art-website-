<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit;
}
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $conn->query("DELETE FROM packages WHERE id = $id");
}
header("Location: manage_packages.php");
exit;
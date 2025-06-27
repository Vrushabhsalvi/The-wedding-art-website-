<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'admin/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $package_id = $_POST['package_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $function_date = $_POST['function_date'];
    $message = $_POST['message'];
    $notify = isset($_POST['notify_whatsapp']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO package_inquiries (package_id, name, phone, email, function_date, message, notify_whatsapp) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssi", $package_id, $name, $phone, $email, $function_date, $message, $notify);
    $stmt->execute();

    // Optional success message
    echo "success";
} else {
    echo "invalid request";
}

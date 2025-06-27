<?php
include "admin/db.php";

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$event_type = $_POST['event_type'];
$event_date = $_POST['event_date'];
$event_location = $_POST['event_location'];
$message = $_POST['message'];

$sql = "INSERT INTO enquiries (name, email, phone, event_type, event_date, event_location, message)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $name, $email, $phone, $event_type, $event_date, $event_location, $message);
$stmt->execute();
echo "OK";

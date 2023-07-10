<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  // Redirect to the login page if not logged in
  header('Location: login.html');
  exit();
}

// Database connection
include "dbconnect.php";

// Get sender and recipient information
$sender_id = $_SESSION['user_id'];
$receiver_id = $_POST['receiver_id'];
$message_content = $_POST['message'];

// Insert the message into the database
$stmt = $conn->prepare("INSERT INTO Messages (sender_id, receiver_id, message_content) VALUES (:sender_id, :receiver_id, :message_content)");
$stmt->bindParam(':sender_id', $sender_id);
$stmt->bindParam(':receiver_id', $receiver_id);
$stmt->bindParam(':message_content', $message_content);
$stmt->execute();


// Redirect back to the user page
header('Location: user_page.php');
exit();
?>


<?php
// Database connection
include "dbconnect.php";

// Signup processing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Hash password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Insert new user into the database
  $stmt = $conn->prepare("INSERT INTO Users (username, email, password) VALUES (:username, :email, :password)");
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':password', $hashedPassword);
  $stmt->execute();

  // Redirect to login page
  header('Location: index.html');
  exit();
}
?>

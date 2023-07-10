<?php
// Database connection
include "dbconnect.php";

// Login processing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Check if user exists
  $stmt = $conn->prepare("SELECT * FROM Users WHERE email = :email");
  $stmt->bindParam(':email', $email);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    // Successful login
    // Set user session
    session_start();
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['profileImg'] = $user['profileImg'];

    // Redirect to user page
    header('Location: user_page.php');
    exit();
  } else {
    // Invalid credentials
    echo 'Invalid email or password.';
  }
}
?>

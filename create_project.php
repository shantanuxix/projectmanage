
<?php
session_start();

// Database connection
include "dbconnect.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: login.html');
  exit();
}

// Get input
$projectTitle = $_POST['projectTitle'];
$projectDescription = $_POST['projectDescription'];
$created_by = $_SESSION['user_id'];

// Insert the project into the database
$stmt = $conn->prepare("INSERT INTO Projects (title, description, created_by) VALUES (:title, :description, :created_by)");
$stmt->bindParam(':title', $projectTitle);
$stmt->bindParam(':description', $projectDescription);
$stmt->bindParam(':created_by', $created_by);
$stmt->execute();

// Get the project ID of the newly created project
$project_id = $conn->lastInsertId();

// Assign tasks 
if (isset($_POST['taskTitle']) && isset($_POST['taskDescription']) && isset($_POST['taskDeadline']) && isset($_POST['assignedTo'])) {
  $taskTitle = $_POST['taskTitle'];
  $taskDescription = $_POST['taskDescription'];
  $taskDeadline = $_POST['taskDeadline'];
  $assignedTo = $_POST['assignedTo'];

  // Insert each task into the database
  foreach ($taskTitle as $index => $title) {
    $stmt = $conn->prepare("INSERT INTO Tasks (title, description, deadline, assigned_by, assigned_to, project_id) VALUES (:title, :description, :deadline, :assigned_by, :assigned_to, :project_id)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $taskDescription[$index]);
    $stmt->bindParam(':deadline', $taskDeadline[$index]);
    $stmt->bindParam(':assigned_by', $created_by);
    $stmt->bindParam(':assigned_to', $assignedTo[$index]);
    $stmt->bindParam(':project_id', $project_id);
    $stmt->execute();
  }
}
header('Location: user_page.php');
exit();
?>

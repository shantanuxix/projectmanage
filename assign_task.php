<?php
session_start();

// Database connection
include   "dbconnect.php";

$conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: login.html');
  exit();
}

// Get form input
$projectId = $_POST['projectId'];
$title = $_POST['title'];
$description = $_POST['description'];
$deadline = $_POST['deadline'];
$assignedTo = $_POST['assignedTo'];
$assignedBy = $_SESSION['user_id'];

// Insert the task into the database
$stmt = $conn->prepare("INSERT INTO Tasks (project_id, title, description, deadline, assigned_by, assigned_to) VALUES (:project_id, :title, :description, :deadline, :assigned_by, :assigned_to)");
$stmt->bindParam(':project_id', $projectId);
$stmt->bindParam(':title', $title);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':deadline', $deadline);
$stmt->bindParam(':assigned_by', $assignedBy);
$stmt->bindParam(':assigned_to', $assignedTo);
$stmt->execute();

// Calculate project progress
$stmt = $conn->prepare("SELECT COUNT(*) AS total_tasks, SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) AS completed_tasks FROM Tasks WHERE project_id = :project_id");
$stmt->bindParam(':project_id', $projectId);
$stmt->execute();
$progress = $stmt->fetch(PDO::FETCH_ASSOC);

$totalTasks = $progress['total_tasks'];
$completedTasks = $progress['completed_tasks'];

if ($totalTasks > 0 && $totalTasks == $completedTasks) {
  // All tasks completed, update project status to 'Completed'
  $stmt = $conn->prepare("UPDATE Projects SET status = 'Completed' WHERE project_id = :project_id");
  $stmt->bindParam(':project_id', $projectId);
  $stmt->execute();
} else {
  // Update project status to 'In Progress'
  $stmt = $conn->prepare("UPDATE Projects SET status = 'In Progress' WHERE project_id = :project_id");
  $stmt->bindParam(':project_id', $projectId);
  $stmt->execute();
}

// Redirect back to the user page
header('Location: user_page.php');
exit();
?>

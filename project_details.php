<?php
// session_start();

// Database connection
include "dbconnect.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: index.html');
  exit();
}

// Get user information
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM Users WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$project_id = $_GET['project_id'];

// Fetch project details
$stmt = $conn->prepare("SELECT * FROM Projects WHERE project_id = :project_id");
$stmt->bindParam(':project_id', $project_id);
$stmt->execute();
$project = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch tasks for the project
$stmt = $conn->prepare("SELECT * FROM Tasks WHERE project_id = :project_id");
$stmt->bindParam(':project_id', $project_id);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <title>ME PMT</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h3>Project Details</h3>
    <h4>Title: <?php echo $project['title']; ?></h4>
    <p>Description: <?php echo $project['description']; ?></p>

    <h4>Tasks:</h4>
    <table class="table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Deadline</th>
          <th>Status</th>
          <th>Assigned To</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tasks as $task) { ?>
          <tr>
            <td><?php echo $task['title']; ?></td>
            <td><?php echo $task['description']; ?></td>
            <td><?php echo $task['deadline']; ?></td>
            <td><?php echo $task['status']; ?></td>
            <td><?php echo $other_users[$task['assigned_to']]['username']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</body>
</html>

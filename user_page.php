<?php
session_start();

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

// Fetch all users except the current user
$stmt = $conn->prepare("SELECT * FROM Users WHERE user_id != :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$other_users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch projects created by the current user
$stmt = $conn->prepare("SELECT * FROM Projects WHERE created_by = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$created_projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch tasks assigned by the current user
$stmt = $conn->prepare("SELECT * FROM Tasks WHERE assigned_by = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$assigned_tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch tasks assigned to the current user
$stmt = $conn->prepare("SELECT * FROM Tasks WHERE assigned_to = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$received_tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <title>ME PMT</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="script.js"></script>
</head>
<body>
  <div class="container-fluid">
    <div class="row vh-100">

      <?php include "navbar.php"; ?>  
          
      <div class="px-5 m-auto vh-100" id="userPage" style="overflow-y: scroll; width: 1010px;">
        <div class="content-section p-4" id="chatDiv">
          <?php include "chat.php" ?>
        </div>
        <div class="content-section" id="createProjectDiv">
          <h3>Create a Project:</h3>
          <form id="projectForm" action="create_project.php" method="POST">
            <div class="form-group">
              <label for="projectTitle">Title:</label>
              <input type="text" class="form-control" id="projectTitle" name="projectTitle" required>
            </div>
            <div class="form-group">
              <label for="projectDescription">Description:</label>
              <textarea class="form-control" id="projectDescription" name="projectDescription"></textarea>
            </div>
            <h5>Tasks:</h5>
            <div class="task-container">
              <div class="tasks">
                <div class="form-group">
                  <label for="taskTitle[]">Task Title:</label>
                  <input type="text" class="form-control" name="taskTitle[]" required>
                </div>
                <div class="form-group">
                  <label for="taskDescription[]">Task Description:</label>
                  <textarea class="form-control" name="taskDescription[]"></textarea>
                </div>
                <div class="form-group">
                  <label for="taskDeadline[]">Task Deadline:</label>
                  <input type="date" class="form-control" name="taskDeadline[]" required>
                </div>
                <div class="form-group">
                  <label for="assignedTo[]">Assign to:</label>
                    <select class="form-control" name="assignedTo[]" required>
                      <option value="">Select User</option>
                      <?php foreach ($other_users as $other_user) { ?>
                      <option value="<?php echo $other_user['user_id']; ?>"><?php echo $other_user['username']; ?></option>
                      <?php } ?>
                    </select>
                </div>
              </div>
            </div>
            <button type="button" class="btn btn-secondary" id="addTaskBtn">Add Task</button>
            <button type="submit" class="btn btn-primary">Create Project</button>
          </form>
        </div>

        <div id="projectsDiv" class="content-section p-4">
            <?php include "project.php"; ?>
          <h4>Projects Created:</h4>
          <table class="table" >
            <thead>
              <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Progress</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($created_projects as $project) { ?>
                <tr>
                  <td><?php echo $project['title']; ?></td>
                  <td><?php echo $project['description']; ?></td>
                  <td><?php echo $project['progress']; ?>%</td>
                  <td>
                    <a href="user_page.php?project_id=<?php echo $project['project_id']; ?>">View Details</a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <d class="content-section p-4" id="tasksDiv">
            <?php include "task.php" ?>
          <h4>Assigned Tasks:</h4>
          <table class="table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Deadline</th>
                <th>Progress</th>
                <th>Assigned To</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($assigned_tasks as $task) { ?>
                <tr>
                  <td><?php echo $task['title']; ?></td>
                  <td><?php echo $task['description']; ?></td>
                  <td><?php echo $task['deadline']; ?></td>
                  <td><?php echo $task['progress']; ?>%</td>
                  <td>
                  <?php
                  $assigned_to_user = null;
                  foreach ($other_users as $other_user) {
                    if ($other_user['user_id'] == $task['assigned_to']) {
                      $assigned_to_user = $other_user;
                      break;
                    }
                  }
                  if ($assigned_to_user && isset($assigned_to_user['username'])) {
                    echo $assigned_to_user['username'];
                  }
                  ?>
                </td>
                  <td>
                    <a href="user_page.php?task_id=<?php echo $task['task_id']; ?>">View Details</a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <br><br>
          <h4>Received Tasks:</h4>
          <table class="table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Deadline</th>
                <th>Progress</th>
                <th>Assigned By</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($received_tasks as $task) { ?>
                <tr>
                  <td><?php echo $task['title']; ?></td>
                  <td><?php echo $task['description']; ?></td>
                  <td><?php echo $task['deadline']; ?></td>
                  <td><?php echo $task['progress']; ?>%</td>
                  <td><?php echo $other_users[$task['assigned_by']]['username']; ?></td>
                  <td>
                    <a href="user_page.php?task_id=<?php echo $task['task_id']; ?>">View Details</a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

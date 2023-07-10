<?php

// Get task ID from the URL parameter
if(isset($_REQUEST['task_id'])){

    $task_id = $_GET['task_id'];
    
    // Fetch the task details
    $stmt = $conn->prepare("SELECT * FROM Tasks WHERE task_id = :task_id");
    $stmt->bindParam(':task_id', $task_id);
    $stmt->execute();
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Fetch the associated project details
    $stmt = $conn->prepare("SELECT * FROM Projects WHERE project_id = :project_id");
    $stmt->bindParam(':project_id', $task['project_id']);
    $stmt->execute();
    $project = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Update task progress
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $progress = $_POST['progress'];
        
        // Update the task progress in the database
        $stmt = $conn->prepare("UPDATE Tasks SET progress = :progress WHERE task_id = :task_id");
        $stmt->bindParam(':progress', $progress);
        $stmt->bindParam(':task_id', $task_id);
        $stmt->execute();
        
        // Recalculate the project progress
        $stmt = $conn->prepare("SELECT SUM(progress) AS total_progress, COUNT(task_id) AS total_tasks FROM Tasks WHERE project_id = :project_id");
        $stmt->bindParam(':project_id', $task['project_id']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Calculate the new project progress
        $project_progress = ($result['total_progress'] / $result['total_tasks']);
        
        // Update the project progress in the database
        $stmt = $conn->prepare("UPDATE Projects SET progress = :project_progress WHERE project_id = :project_id");
        $stmt->bindParam(':project_progress', $project_progress);
        $stmt->bindParam(':project_id', $task['project_id']);
        $stmt->execute();
    }
}
?>

<?php if (isset($_REQUEST['task_id']) && $task_id !== null) { ?>
  <div class="container p-3 shadow p-3 mb-5 bg-white rounded">
    <h3><u><strong>Task Details: </strong><?php echo $task['title']; ?></u></h3>
    <p>Description: <?php echo $task['description']; ?></p>
    <p>Deadline: <?php echo $task['deadline']; ?></p>
    <p>Progress: <?php echo $task['progress']; ?>%</p>

    <h4>Update Progress:</h4>
    <form id="progressForm" action="user_page.php?task_id=<?php echo $task_id; ?>" method="POST">
      <div class="form-group">
        <label for="progress">Progress:</label>
        <input type="number" class="form-control" id="progress" name="progress" min="0" max="100" step="1" required>
      </div>
      <button type="submit" class="btn btn-primary">Update Progress</button>
    </form>
  </div>
<?php } ?>

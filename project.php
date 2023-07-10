<?php

// Get project ID from the URL parameter
if(isset($_REQUEST['project_id'])){

    $project_id = $_GET['project_id'];
    
    // Fetch the project details
    $stmt = $conn->prepare("SELECT * FROM Projects WHERE project_id = :project_id");
    $stmt->bindParam(':project_id', $project_id);
    $stmt->execute();
    $project = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Fetch tasks for the project
    $stmt = $conn->prepare("SELECT * FROM Tasks WHERE project_id = :project_id");
    $stmt->bindParam(':project_id', $project_id);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<?php if (isset($_REQUEST['project_id']) && $project_id !== null) { ?>
  <div class="container shadow p-3 mb-5 bg-white rounded ">
    <h3><u><strong>Project Details: </strong><?php echo $project['title']; ?></u></h3>
    <p>Description: <?php echo $project['description']; ?></p>
    <p>Progress: <?php echo $project['progress']; ?>%</p>

    <h4>Tasks:</h4>
    <table class="table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Deadline</th>
          <th>Progress</th>
          <th>Assigned To</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tasks as $task) { ?>
          <tr>
            <td><?php echo $task['title']; ?></td>
            <td><?php echo $task['description']; ?></td>
            <td><?php echo $task['deadline']; ?></td>
            <td><?php echo $task['progress']; ?>%</td>
            <!-- <td><?php echo $other_users[$task['assigned_to']]['username']; ?></td> -->
            <td>
            <?php
            $assigned_to = null;
            foreach ($other_users as $user) {
              if ($user['user_id'] == $task['assigned_to']) {
                $assigned_to = $user;
                break;
              }
            }
            if ($assigned_to && isset($assigned_to['username'])) {
              echo $assigned_to['username'];
            }
            ?>
          </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <?php } ?>

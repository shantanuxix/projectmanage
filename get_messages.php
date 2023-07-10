<?php
session_start();

// Database connection
include "dbconnect.php";

// Get user information
$user_id = $_SESSION['user_id'];

// Get receiver ID from the AJAX request
$receiver_id = $_POST['receiver_id'];

// Fetch messages between the current user and the receiver
$stmt = $conn->prepare("SELECT * FROM Messages WHERE (sender_id = :user_id AND receiver_id = :receiver_id) OR (sender_id = :receiver_id AND receiver_id = :user_id) ORDER BY timestamp ASC");
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':receiver_id', $receiver_id);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

function convertToChatTime($timestamp) {
  $dateTime = new DateTime($timestamp);
  $formattedTime = $dateTime->format('h:i A');
  return $formattedTime;
}
// Display messages
foreach ($messages as $message) {
  $message_class = ($message['sender_id'] == $user_id) ? 'sender' : 'receiver';
  echo '<div class="message ' . $message_class . '">';
  echo '<div class="meta message text-only">
          <div>
            <p class="content text">'. $message['message_content'] .'</p> 
          </div>
        </div>
        <p class="time">'.$formattedTime = convertToChatTime($message['timestamp']).'</p> ';
  echo '</div>';
}
?>
    
              
            

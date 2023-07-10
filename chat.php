<?php

if(isset($_REQUEST['receiver_id'])){
  $receiver_id = $_GET['receiver_id'];
  // Fetch the receiver's information
  $stmt = $conn->prepare("SELECT * FROM Users WHERE user_id = :receiver_id");
  $stmt->bindParam(':receiver_id', $receiver_id);
  $stmt->execute();
  $receiver = $stmt->fetch(PDO::FETCH_ASSOC);

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
}
?>
<div id="ChatContainer" class="container">
  <div class="row">
    <section class="discussions">
      <div class="discussion search">
        <div class="searchbar">
          <i class="fa fa-search" aria-hidden="true"></i>
          <input type="text" placeholder="Search..."></input>
        </div>
      </div>
      <?php foreach ($other_users as $other_user) { ?>
            
          
      <div class="discussion message">
        <div class="photo" style="background-image: url('<?php echo $other_user['profileImg']; ?>')">
          <div class="online"></div>
        </div>
        <div class="desc-contact">
          <p class="name"><a href="user_page.php?receiver_id=<?php echo $other_user['user_id'];  ?>" ><?php echo $other_user['username']; ?></a></p>
          <p class="message">Message</p>
        </div>
        <div class="timer">Today</div>
      </div>
      <?php } ?>
      
    </section>

    <?php if (isset($_REQUEST['receiver_id']) && $receiver_id !== null) { ?>
    <section class="chat">
      <div class="header-chat">
        <p class="name"><img src='<?php echo $receiver['profileImg']; ?>' alt='' width='42' height='42' class='rounded-circle me-2'> &nbsp;<?php echo $receiver['username']; ?></p>
      </div>
      <div class="messages-chat">
        <div id="messagesContainer" class="chat-container">
          <?php foreach ($messages as $message) { ?>
            <div class="message <?php echo ($message['sender_id'] == $user_id) ? 'sender' : 'receiver'; ?>">
              <div class="meta message text-only">
                <div>
                <p class="content text"><?php echo $message['message_content']; ?></p> 
                </div>
              </div>
              <p class="time">
                <?php
                $formattedTime = convertToChatTime($message['timestamp']);
                echo $formattedTime; ?></p> 
            </div>
          <?php } ?>
        </div>
        <br>
        <form id="messageForm">
          <div class="footer-chat">
            <input type="hidden" name="receiver_id" value="<?php echo $receiver_id; ?>">
            <input type="text" id="messageInput" autocomplete="off" name="message" required class="write-message" placeholder="Type your message here">
            <button class="p-2 m-2 border-0" type="submit" class="btn btn-primary"><img class="pl-1" src="./images/icons8-send-50.png" width='32px' heigth='32px' alt="" srcset=""></button>
          </div>
        </form>       
      </div>
    </section>
    <?php } ?>
  </div>
</div>


  

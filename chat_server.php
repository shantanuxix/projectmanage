<?php
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require 'vendor/autoload.php';

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        foreach ($this->clients as $client) {
            if ($client !== $from) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080
);

$server->run();



// <?php
// // Database connection
// $host = 'localhost';
// $db = 'your_database_name';
// $user = 'your_username';
// $password = 'your_password';

// $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);

// // Check if the user is logged in
// session_start();
// if (!isset($_SESSION['user_id'])) {
//   // Redirect to the login page if not logged in
//   header('Location: login.html');
//   exit();
// }

// // Get current user information
// $user_id = $_SESSION['user_id'];

// $stmt = $conn->prepare("SELECT * FROM Users WHERE user_id = :user_id");
// $stmt->bindParam(':user_id', $user_id);
// $stmt->execute();
// $user = $stmt->fetch(PDO::FETCH_ASSOC);

// // Handle incoming chat messages
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   $message = $_POST['message'];

//   // Insert message into the database
//   $stmt = $conn->prepare("INSERT INTO ChatMessages (user_id, message) VALUES (:user_id, :message)");
//   $stmt->bindParam(':user_id', $user_id);
//   $stmt->bindParam(':message', $message);
//   $stmt->execute();
// }

// // Long polling technique to continuously check for new chat messages
// function checkForNewMessages($lastMessageId) {
//   global $conn;

//   $stmt = $conn->prepare("SELECT * FROM ChatMessages WHERE message_id > :lastMessageId");
//   $stmt->bindParam(':lastMessageId', $lastMessageId);
//   $stmt->execute();
//   $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

//   if (count($messages) > 0) {
//     return $messages;
//   }

//   // If no new messages, wait for a few seconds before checking again
//   sleep(2);
//   return checkForNewMessages($lastMessageId);
// }

// // Retrieve last chat message ID
// $stmt = $conn->query("SELECT MAX(message_id) AS lastMessageId FROM ChatMessages");
// $result = $stmt->fetch(PDO::FETCH_ASSOC);
// $lastMessageId = $result['lastMessageId'];

// // Continuously check for new messages
// while (true) {
//   $newMessages = checkForNewMessages($lastMessageId);

//   if (count($newMessages) > 0) {
//     $response = [
//       'status' => 'success',
//       'messages' => $newMessages
//     ];

//     // Output JSON response and stop execution
//     header('Content-Type: application/json');
//     echo json_encode($response);
//     exit();
//   }
// }

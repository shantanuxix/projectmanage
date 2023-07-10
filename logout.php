<?php
session_start();

// Destroy the session data
session_destroy();

header('Location: index.html');
exit();
?>

<?php
session_start();
require 'db.php'; // assumes this connects to your database

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Anonymous';
    $message = trim($_POST['feedback']);

    if (!empty($message)) {
        $stmt = $conn->prepare("INSERT INTO feedback (username, message) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $message);

        if ($stmt->execute()) {
            echo "Thank you for your feedback!";
        } else {
            echo "Error saving feedback. Please try again.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Please enter your feedback.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<?php
session_start();
require 'db.php';
require 'db_suggestions.php';

if (!isset($_SESSION['username'])) {
    echo "Access denied.";
    exit;
}

$input = trim($_POST["message"]);
$username = $_SESSION['username'];

// File upload logic
$uploadedFileLink = "";
if (!empty($_FILES["file"]) && $_FILES["file"]["error"] === 0) {
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $originalName = basename($_FILES["file"]["name"]);
    $uniqueName = uniqid() . "_" . $originalName;
    $targetPath = $uploadDir . $uniqueName;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetPath)) {
        $uploadedFileLink = "<br><a href='" . $targetPath . "' target='_blank'>📎 View uploaded file: " . htmlspecialchars($originalName) . "</a>";
    } else {
        $uploadedFileLink = "<br><em>⚠️ File upload failed.</em>";
    }
}

$apiKey = "AIzaSyCNYJRu3xo8X30iHeOm1q7JB9jjdMnStt0";
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=" . $apiKey;

$data = [
    "contents" => [[
        "parts" => [[ "text" => "Answer as a helpful e-Governance assistant: " . $input ]]
    ]]
];

$headers = ["Content-Type: application/json"];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
curl_close($ch);

$reply = "Sorry, couldn't fetch response.";
$responseData = json_decode($response, true);
if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
    $reply = $responseData['candidates'][0]['content']['parts'][0]['text'];
}

$replyWithAttachment = $reply . $uploadedFileLink;

$stmt = $conn->prepare("INSERT INTO chat_logs (username, message, reply) VALUES (?, ?, ?)");
if ($stmt) {
    $stmt->bind_param("sss", $username, $input, $replyWithAttachment);
    $stmt->execute();
    $stmt->close();
} else {
    // Error Handling
    echo "Database error (chat_logs insert): " . $conn->error;
    exit;
}

// Save suggestion
$suggestionStmt = $suggestionConn->prepare("INSERT INTO suggestions (query) VALUES (?)");
if ($suggestionStmt) {
    $suggestionStmt->bind_param("s", $input);
    $suggestionStmt->execute();
    $suggestionStmt->close();
} else {
    // Error Handling
    echo "Database error (suggestions insert): " . $suggestionConn->error;
    exit;
}

echo nl2br(htmlspecialchars($reply)) . $uploadedFileLink;
?>

<?php
// feedback.php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
$username = htmlspecialchars($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - e-Governance Chatbot</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('FEEDBACK Concept with icons by IhorZigor on….jpg'); /* Replace with your image URL */
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
            scroll-behavior: smooth;
            min-height: 100vh; /* Ensure the body fills the viewport */
            display: flex;
            flex-direction: column;
        }

        main {
            max-height: calc(100vh - 80px); /* Make main section scrollable, considering header height */
            overflow-y: auto; /* Enable vertical scrolling */
        }
    </style>
</head>
<body class="bg-gray-50">
    <header class="bg-white py-4 shadow fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-700">Feedback</h1>
            <a href="logout.php" class="text-red-600 hover:underline">Logout</a>
        </div>
    </header>

    <main class="py-16 px-4">
        <div class="max-w-3xl mx-auto text-center bg-white bg-opacity-80 p-6 rounded-lg shadow-lg">
            <h2 class="text-3xl font-bold text-blue-800 mb-6">We Value Your Feedback</h2>
            <form action="feedback_handler.php" method="POST" class="space-y-4">
                <textarea name="feedback" rows="5" required placeholder="Your feedback..." class="w-full p-4 border rounded-lg"></textarea>
                <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800">Submit Feedback</button>
            </form>
        </div>
    </main>
</body>
</html>

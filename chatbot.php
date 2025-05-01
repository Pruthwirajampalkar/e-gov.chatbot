<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

$recentSearches = [];
$conn = new mysqli("localhost", "root", "", "egov_chatbot");
if (!$conn->connect_error) {
    $username = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT message FROM chat_logs WHERE username = ? ORDER BY created_at DESC LIMIT 7");
    $stmt->bind_param("s", $username);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $recentSearches[] = $row['message'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>e-Governance Chatbot</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: linear-gradient(to right, #e0f7fa, #fff3e0);
    }
    .fade-in {
      animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    #chat-box {
      height: 24rem;
      overflow-y: auto;
      border: 1px solid #d1d5db;
      padding: 1rem;
      margin-bottom: 1rem;
      border-radius: 0.375rem;
      background-image: url('Top Tips to Write an Article on Ai ChatBots.jpg'); 
      background-size: cover;
      background-position: center center;
      backdrop-filter: blur(10px);
      background-color: rgba(255, 255, 255, 0.6); 
    }
  </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-start p-4">
  <div class="w-full max-w-7xl flex gap-6 bg-white shadow-xl rounded-lg p-6 border-t-8 border-blue-500 fade-in">

    <!-- Chat Section -->
    <div class="flex-1">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">e-Gov Chatbot 🤖</h2>
        <div class="flex gap-4 items-center">
          <a href="download_chat.php" class="text-sm text-green-700 hover:underline">Download Chat</a>
          <a href="logout.php" class="text-sm text-red-600 hover:underline">Logout</a>
        </div>
      </div>

      <!-- Suggestions -->
      <div id="suggestion-box" class="mb-3 hidden bg-gray-100 border border-gray-300 p-2 rounded"></div>

      <div id="chat-box">
        <!-- Chat will be dynamically added -->
      </div>

      <form id="chat-form" class="flex items-center gap-2">
        <input type="text" id="user-input" class="flex-1 border px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Ask something..." autocomplete="off" required />
        <input type="file" id="file-upload" class="hidden" />
        <label for="file-upload" class="cursor-pointer bg-gray-200 px-3 py-2 rounded hover:bg-gray-300 text-sm">📎</label>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded font-semibold">Send</button>
      </form>
    </div>

    <!-- Right Panel: Recent Searches -->
    <div class="w-1/4 border-l border-gray-300 pl-4">
      <h3 class="text-lg font-semibold text-gray-800 mb-2">Recent Searches</h3>
      <div class="space-y-2">
        <?php foreach ($recentSearches as $search): ?>
          <div class="bg-blue-50 text-blue-900 px-3 py-2 rounded shadow hover:bg-blue-100 cursor-pointer" onclick="document.getElementById('user-input').value = '<?= htmlspecialchars($search, ENT_QUOTES) ?>';">
            <?= htmlspecialchars($search) ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>

  <script>
    const form = document.getElementById("chat-form");
    const input = document.getElementById("user-input");
    const chatBox = document.getElementById("chat-box");
    const suggestionBox = document.getElementById("suggestion-box");

    input.addEventListener("input", async () => {
      const query = input.value;
      if (query.length < 2) {
        suggestionBox.classList.add('hidden');
        return;
      }
      const res = await fetch("suggestions.php?q=" + encodeURIComponent(query));
      const suggestions = await res.json();
      if (suggestions.length > 0) {
        suggestionBox.innerHTML = suggestions.map(s => `<div class="cursor-pointer px-2 py-1 hover:bg-blue-100 rounded" onclick="selectSuggestion('${s}')">${s}</div>`).join('');
        suggestionBox.classList.remove('hidden');
      } else {
        suggestionBox.classList.add('hidden');
      }
    });

    function selectSuggestion(text) {
      input.value = text;
      suggestionBox.classList.add('hidden');
    }

    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      const userText = input.value.trim();
      if (!userText) return;

      const timestamp = new Date().toLocaleString('en-GB', {
        hour: '2-digit', minute: '2-digit',
        day: '2-digit', month: '2-digit', year: 'numeric'
      });

      chatBox.innerHTML += `
        <div class='text-right mb-2 fade-in flex items-end justify-end gap-2'>
          <div>
            <span class='text-xs text-gray-400 block'>You • ${timestamp}</span>
            <span class='inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded shadow'>${userText}</span>
          </div>
          <img src='https://i.pravatar.cc/30?u=session_user' class='w-6 h-6 rounded-full' />
        </div>`;
      input.value = "";
      chatBox.scrollTop = chatBox.scrollHeight;

      const typing = document.createElement("div");
      typing.className = 'text-left mb-2 fade-in flex items-end gap-2';
      typing.innerHTML = `
        <img src='https://cdn-icons-png.flaticon.com/512/4712/4712027.png' class='w-6 h-6 rounded-full' />
        <div>
          <span class='text-xs text-gray-400 block'>Bot</span>
          <span class='inline-block bg-gray-200 text-gray-900 px-3 py-1 rounded shadow'>Typing...</span>
        </div>`;
      chatBox.appendChild(typing);

      const response = await fetch("chatbot_backend.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "message=" + encodeURIComponent(userText)
      });
      const reply = await response.text();

      chatBox.removeChild(typing);
      chatBox.innerHTML += `
        <div class='text-left mb-2 fade-in flex items-end gap-2'>
          <img src='https://cdn-icons-png.flaticon.com/512/4712/4712027.png' class='w-6 h-6 rounded-full' />
          <div>
            <span class='text-xs text-gray-400 block'>Bot • ${timestamp}</span>
            <span class='inline-block bg-gray-200 text-gray-900 px-3 py-1 rounded shadow'>${reply}</span>
          </div>
        </div>`;
      chatBox.scrollTop = chatBox.scrollHeight;
    });
  </script>
</body>
</html>

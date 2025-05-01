<?php
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>🏛️ e-Governance Chatbot</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      scroll-behavior: smooth;
      background: linear-gradient(135deg, #FF7F50, #FF1493, #1E90FF, #32CD32); /* Soft and vibrant gradient colors */
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
    section {
      animation: fadeInUp 0.6s ease-out both;
    }
    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    .chatbot-glow {
      box-shadow: 0 0 15px rgba(59, 130, 246, 0.6), 0 0 25px rgba(59, 130, 246, 0.3);
      animation: pulseGlow 2s infinite;
    }
    @keyframes pulseGlow {
      0%, 100% { box-shadow: 0 0 15px rgba(59, 130, 246, 0.6), 0 0 25px rgba(59, 130, 246, 0.3); }
      50% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.9), 0 0 30px rgba(59, 130, 246, 0.4); }
    }
    .dark body {
      background-color: #1f2937;
      color: #e5e7eb;
    }
    .dark .bg-white { background-color: #1f2937; }
    .dark .bg-blue-700 { background-color: #3b82f6; }
    .dark .text-blue-700 { color: #60a5fa; }
    .dark .bg-gradient-to-r {
      background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(59, 130, 246, 0.3) 100%);
    }

    header {
      background: rgba(255, 255, 255, 0.9);
    }

    .hero {
      background: linear-gradient(135deg, #FF7F50, #FF1493, #1E90FF, #32CD32); /* Multi-color gradient */
      color: white;
    }

    /* Button Styling */
    .btn-primary {
      background-color: #3B82F6;
      color: white;
      padding: 1rem 2rem;
      border-radius: 0.375rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .btn-primary:hover {
      background-color: #2563EB;
    }

    .btn-secondary {
      background-color: #10B981;
      color: white;
      padding: 1rem 2rem;
      border-radius: 0.375rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .btn-secondary:hover {
      background-color: #059669;
    }

    /* Footer Section Styling */
    footer {
      background: rgba(0, 0, 0, 0.05);
      color: #1f2937;
    }
    footer h4 {
      font-weight: bold;
      color: #3B82F6;
    }
    footer a {
      color: #3B82F6;
    }
    footer a:hover {
      color: #1d4ed8;
    }
  </style>
  <script>
    function openChatbot() {
      window.location.href = 'chatbot.php';
    }
    function toggleDarkMode() {
      document.body.classList.toggle("dark");
      localStorage.setItem("darkMode", document.body.classList.contains("dark") ? "enabled" : "disabled");
    }
    window.onload = () => {
      if (localStorage.getItem("darkMode") === "enabled") {
        document.body.classList.add("dark");
      }
    };
  </script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">
  <header id="navbar" class="bg-white fixed top-0 left-0 w-full z-50 shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold text-blue-700">🏛️ e-Governance Web</h1>
      <div class="flex items-center gap-4">
        <span class="text-gray-600 flex items-center gap-2">
          <span class="bg-blue-100 text-blue-700 rounded-full w-8 h-8 flex items-center justify-center text-lg">
            👤
          </span>
          <?php echo $username; ?> 👋
        </span>
        <a href="logout.php" class="text-red-600 hover:underline">Logout</a>
        <button onclick="toggleDarkMode()" class="text-gray-600 hover:underline">🌙</button>
      </div>
    </div>
  </header>

  <section class="bg-gradient-to-r from-pink-100 via-indigo-200 to-teal-100 py-24 mt-16">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <h2 class="text-4xl font-bold text-blue-800 mb-6">🤖 Your Digital Government Assistant</h2>
      <p class="text-lg text-blue-700 mb-10">Access public services, ask questions, and get instant support — all in one place.</p>

      <!-- Button Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <a href="services.php" class="bg-white border border-blue-700 text-blue-700 px-8 py-6 rounded-lg shadow-lg hover:bg-blue-50 transition-all duration-300 flex flex-col items-center">
          <span class="text-2xl mb-4">📋</span>
          <span class="text-lg font-semibold mb-2">Explore Services</span>
          <p class="text-sm text-center">Browse and access a variety of government services easily.</p>
        </a>

        <button onclick="openChatbot()" class="bg-blue-700 text-white px-8 py-6 rounded-lg shadow-lg hover:bg-blue-800 transition-all duration-300 flex flex-col items-center">
          <span class="text-2xl mb-4">💬</span>
          <span class="text-lg font-semibold mb-2">Chatbot</span>
          <p class="text-sm text-center">Ask questions, get responses, and access services instantly!</p>
        </button>

        <a href="appointments.php" class="bg-indigo-600 text-white px-8 py-6 rounded-lg shadow-lg hover:bg-indigo-700 transition-all duration-300 flex flex-col items-center">
          <span class="text-2xl mb-4">📅</span>
          <span class="text-lg font-semibold mb-2">Appointments</span>
          <p class="text-sm text-center">Book appointments for various government services quickly.</p>
        </a>

        <a href="notifications.php" class="bg-purple-600 text-white px-8 py-6 rounded-lg shadow-lg hover:bg-purple-700 transition-all duration-300 flex flex-col items-center">
          <span class="text-2xl mb-4">🔔</span>
          <span class="text-lg font-semibold mb-2">Notifications</span>
          <p class="text-sm text-center">Stay updated with important announcements and alerts.</p>
        </a>

        <a href="grievances.php" class="bg-pink-600 text-white px-8 py-6 rounded-lg shadow-lg hover:bg-pink-700 transition-all duration-300 flex flex-col items-center">
          <span class="text-2xl mb-4">📝</span>
          <span class="text-lg font-semibold mb-2">Grievances</span>
          <p class="text-sm text-center">Submit your grievances and track their status.</p>
        </a>

        <a href="contact.php" class="bg-green-600 text-white px-8 py-6 rounded-lg shadow-lg hover:bg-green-700 transition-all duration-300 flex flex-col items-center">
          <span class="text-2xl mb-4">📞</span>
          <span class="text-lg font-semibold mb-2">Contact Us</span>
          <p class="text-sm text-center">Get in touch with customer support for assistance.</p>
        </a>

        <a href="feedback.php" class="bg-yellow-600 text-white px-8 py-6 rounded-lg shadow-lg hover:bg-yellow-700 transition-all duration-300 flex flex-col items-center">
          <span class="text-2xl mb-4">✉️</span>
          <span class="text-lg font-semibold mb-2">Feedback</span>
          <p class="text-sm text-center">Share your thoughts and help us improve.</p>
        </a>
      </div>
    </div>
  </section>

  <!-- Floating Chatbot Button -->
  <button onclick="openChatbot()" class="chatbot-glow fixed bottom-6 right-6 bg-blue-700 text-white px-5 py-3 rounded-full shadow-lg hover:scale-105">💬 Chatbot</button>
<!-- Footer -->
<footer class="bg-gray-900 text-gray-100 pt-12 pb-6 mt-20">
  <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-10 text-sm">
    
    <!-- Follow Us Section -->
    <div>
      <h4 class="font-semibold text-white text-lg mb-4">🌐 Follow Us</h4>
      <ul class="space-y-2">
        <li><a href="https://facebook.com" target="_blank" class="hover:text-blue-400 transition duration-300">📘 Facebook</a></li>
        <li><a href="https://twitter.com" target="_blank" class="hover:text-blue-400 transition duration-300">🐦 Twitter</a></li>
        <li><a href="https://instagram.com" target="_blank" class="hover:text-blue-400 transition duration-300">📸 Instagram</a></li>
        <li><a href="https://linkedin.com" target="_blank" class="hover:text-blue-400 transition duration-300">📱 LinkedIn</a></li>
      </ul>
    </div>

    <!-- Contact Us Section -->
    <div>
      <h4 class="font-semibold text-white text-lg mb-4">📞 Contact Us</h4>
      <p class="text-gray-300">Have questions or need help? Reach out anytime!</p>
      <p class="mt-2 text-gray-400">📧 <a href="mailto:support@govchat.com" class="hover:text-blue-400">support@govchat.com</a></p>
      <p class="text-gray-400">📞 <a href="tel:+1234567890" class="hover:text-blue-400">+1 234 567 890</a></p>
    </div>

    <!-- Quick Links Section -->
    <div>
      <h4 class="font-semibold text-white text-lg mb-4">⚡ Quick Links</h4>
      <ul class="space-y-2">
        <li><a href="faq.php" class="hover:text-blue-400 transition duration-300">FAQs</a></li>
        <li><a href="help.php" class="hover:text-blue-400 transition duration-300">Help Center</a></li>
        <li><a href="sitemap.php" class="hover:text-blue-400 transition duration-300">Site Map</a></li>
      </ul>
    </div>

    <!-- Important Links Section -->
    <div>
      <h4 class="font-semibold text-white text-lg mb-4">📎 Important Links</h4>
      <ul class="space-y-2">
        <li><a href="https://india.gov.in" target="_blank" class="hover:text-blue-400 transition duration-300">National Portal of India</a></li>
        <li><a href="https://mygov.in" target="_blank" class="hover:text-blue-400 transition duration-300">MyGov</a></li>
        <li><a href="https://uidai.gov.in" target="_blank" class="hover:text-blue-400 transition duration-300">UIDAI (Aadhaar)</a></li>
        <li><a href="https://services.india.gov.in" target="_blank" class="hover:text-blue-400 transition duration-300">Government Services</a></li>
      </ul>
    </div>
  </div>

  <div class="mt-10 border-t border-gray-700 pt-6 text-center text-gray-400">
    <ul class="flex justify-center gap-6 mb-4 text-sm">
      <li><a href="terms.php" class="hover:text-blue-400">Terms & Conditions</a></li>
      <li><a href="privacy.php" class="hover:text-blue-400">Privacy Policy</a></li>
    </ul>
    <p>&copy; 2025 e-Governance Chatbot. All rights reserved.</p>
  </div>
</footer>

</body>
</html>

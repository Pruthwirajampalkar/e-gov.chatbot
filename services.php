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
  <meta charset="UTF-8">
  <title>All Services</title>
  <!-- FontAwesome CDN for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    /* Remove underlines from links */
    a {
      text-decoration: none;
    }

    body {
      font-family: 'Arial', sans-serif;
      background: linear-gradient(to right, #00bcd4, #009ec1, #045b62); /* Gradient background */
      color: white;
      margin: 0;
      padding: 20px;
    }

    header {
      background-color: rgba(255, 255, 255, 0.9); /* Transparent white background */
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      border-radius: 10px;
    }

    .header-left h1 {
      margin: 0;
      color: #c13e3e;
      font-size: 24px;
    }

    .header-right {
      font-size: 16px;
      color: #333;
    }

    .header-right a {
      color: #c13e3e;
      margin-left: 15px;
      font-weight: bold;
    }

    h2 {
      text-align: center;
      color: #fff;
      margin: 30px 0 10px;
      font-size: 28px;
      text-transform: uppercase;
    }

    #searchInput {
      display: block;
      margin: 0 auto 20px auto;
      padding: 12px;
      width: 80%;
      max-width: 500px;
      border: 2px solid #ffffff;
      border-radius: 5px;
      font-size: 16px;
      background-color: rgba(255, 255, 255, 0.7);
      color: #333;
    }

    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      padding: 20px;
      justify-items: center;
    }

    .card {
      background-color: #ffffff;
      border: 2px solid #009ec1;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      text-align: center;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
    }

    .card i {
      font-size: 40px;
      color: #00748f;
      margin-bottom: 10px;
    }

    .card h3 {
      margin-top: 0;
      color: #00748f;
      font-size: 20px;
    }

    .card p {
      color: #555;
      font-size: 16px;
    }

    .top-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #00bcd4;
      color: white;
      padding: 15px;
      border-radius: 50%;
      text-decoration: none;
      font-size: 18px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .top-btn:hover {
      background-color: #00748f;
      transform: scale(1.1);
    }

    footer {
      text-align: center;
      font-size: 14px;
      margin-top: 40px;
      color: #fff;
    }

    footer a {
      color: #c13e3e;
      text-decoration: none;
      font-weight: bold;
    }
  </style>

  <script>
    function filterServices() {
      let input = document.getElementById('searchInput').value.toLowerCase();
      let cards = document.getElementsByClassName('card');

      for (let card of cards) {
        let title = card.getElementsByTagName('h3')[0].innerText.toLowerCase();
        let text = card.getElementsByTagName('p')[0].innerText.toLowerCase();
        card.style.display = (title.includes(input) || text.includes(input)) ? "block" : "none";
      }
    }
  </script>
</head>
<body>

<header>
  <div class="header-left">
    <h1>All Government Services</h1>
  </div>
  <div class="header-right">
    Welcome, <?php echo $username; ?>!
    <a href="logout.php">Logout</a>
  </div>
</header>

<h2>Explore Topics and Schemes</h2>
<input type="text" id="searchInput" onkeyup="filterServices()" placeholder="Search for a service...">

<div class="grid-container">
  <?php
  $services = [
    ["The India and its government", "Learn about Indian laws, history, and more. Buy government property. Contact elected officials and federal agencies.", "india-government", "fas fa-flag"],
    ["Complaints", "File complaints involving government agencies, telemarketers, products and services, travel, housing, and banking.", "complaints", "fas fa-exclamation-circle"],
    ["Disability services", "Find government benefits and programs for people with disabilities and their families.", "disability-services", "fas fa-wheelchair"],
    ["Disasters and emergencies", "Learn about disaster relief and find government benefits for other emergencies.", "disasters-emergencies", "fas fa-hurricane"],
    ["Education", "Learn about Federal Student Aid and studying in the U.S. Find early intervention, special education, and Head Start programs.", "education", "fas fa-graduation-cap"],
    ["Government benefits", "Find government programs that may help pay for food, housing, health care, and more.", "government-benefits", "fas fa-hand-holding-usd"],
    ["Health", "Get information about health insurance, various health conditions, and help with medical bills.", "health", "fas fa-heartbeat"],
    ["Housing help", "Learn about rental and buyer assistance programs. Find emergency housing and avoid eviction.", "housing-help", "fas fa-home"],
    ["Immigration and Indian citizenship", "Learn about Indian residency, Green Cards, citizenship requirements, and related topics.", "immigration-citizenship", "fas fa-globe"],
    ["Jobs, labor laws, and unemployment", "Get resources for finding a job. Learn about unemployment insurance and important labor laws.", "jobs-labor", "fas fa-briefcase"],
    ["Laws and legal issues", "Learn how to replace vital records, get child support enforcement, find legal help, and more.", "legal-issues", "fas fa-gavel"],
    ["Military and veterans", "Learn how to join the military and find benefits and services as a member or veteran.", "military-veterans", "fas fa-user-tie"],
    ["Vehicle Services", "Apply for driving license, registration, challan status.", "vehicle-services", "fas fa-car"],
    ["LPG Subsidy", "Check subsidy status, book cylinders, link Aadhaar.", "lpg-subsidy", "fas fa-cogs"],
    ["Digital India Services", "Access DigiLocker, UMANG app, and more.", "digital-india", "fas fa-laptop"],
    ["PM Kisan Samman Nidhi", "₹6,000/year to small & marginal farmers.", "pm-kisan-samman", "fas fa-seedling"],
    ["Ayushman Bharat Yojana", "Health insurance of ₹5 lakh/year.", "ayushman-bharat", "fas fa-heart"],
    ["PM Ujjwala Yojana", "Free LPG for below poverty line families.", "pm-ujjwala", "fas fa-fire"],
    ["PM SVANidhi Scheme", "Working capital loans to street vendors.", "pm-svanidhi", "fas fa-money-bill-wave"],
    ["Election Services", "Voter ID registration, corrections, status check.", "election-services", "fas fa-vote-yea"],
    ["Education Services", "Scholarships, student loans, academic aid.", "education-services", "fas fa-book"]
  ];

  foreach ($services as $service) {
    echo "<div class='card'>";
    echo "<a href='service_details.php?service={$service[2]}'>";
    echo "<i class='{$service[3]}'></i>";
    echo "<h3>{$service[0]}</h3>";
    echo "<p>{$service[1]}</p>";
    echo "</a>";
    echo "</div>";
  }
  ?>
</div>

<a href="#top" class="top-btn">↑</a>

<footer>
  &copy; 2025 e-Governance Chatbot. All rights reserved. | <a href="privacy-policy.html">Privacy Policy</a>
</footer>

</body>
</html>

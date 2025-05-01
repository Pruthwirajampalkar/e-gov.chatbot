<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
$username = htmlspecialchars($_SESSION['username']);

$serviceDetails = [
    "india-government" => [
        "title" => "The India and its government",
        "description" => "Learn about Indian laws, history, and more. Buy government property. Contact elected officials and federal agencies.",
        "apply_link" => "https://www.india.gov.in/",
        "csc_link" => "https://www.csc.gov.in/"
    ],
    "complaints" => [
        "title" => "Complaints",
        "description" => "File complaints involving government agencies, telemarketers, products and services, travel, housing, and banking.",
        "apply_link" => "https://www.consumercomplaints.in/",
        "csc_link" => "https://www.csc.gov.in/"
    ],
    "disability-services" => [
        "title" => "Disability services",
        "description" => "Find government benefits and programs for people with disabilities and their families.",
        "apply_link" => "https://www.disabilityaffairs.gov.in/",
        "csc_link" => "https://www.csc.gov.in/"
    ],
    "disasters-emergencies" => [
        "title" => "Disasters and emergencies",
        "description" => "Learn about disaster relief and find government benefits for other emergencies.",
        "apply_link" => "https://www.ndma.gov.in/",
        "csc_link" => "https://www.csc.gov.in/"
    ],
    "education" => [
        "title" => "Education",
        "description" => "Learn about Federal Student Aid and studying in the U.S. Find early intervention, special education, and Head Start programs.",
        "apply_link" => "https://www.education.gov.in/",
        "csc_link" => "https://www.csc.gov.in/"
    ],
];
$service = isset($_GET['service']) ? $_GET['service'] : null;

if (!isset($serviceDetails[$service])) {
    $service = "not-found"; 
}

$details = isset($serviceDetails[$service]) ? $serviceDetails[$service] : [
    "title" => "Service Not Found",
    "description" => "Sorry, we couldn't find any details for this service. Please check back later or visit the CSC Portal for more services.",
    "apply_link" => "#",
    "csc_link" => "https://www.csc.gov.in/"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Service Details</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #e3f4f6;
      margin: 0;
      padding: 20px;
    }

    header {
      background-color: #ffffff;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    h1 {
      margin: 0;
      color: #c13e3e;
    }

    h2 {
      color: #045b62;
      margin-top: 30px;
    }

    .content {
      background-color: white;
      padding: 20px;
      border: 2px solid #009ec1;
      border-radius: 5px;
      box-shadow: 0px 0px 5px rgba(0,0,0,0.2);
      margin-top: 20px;
    }

    footer {
      text-align: center;
      font-size: 14px;
      margin-top: 40px;
      color: #555;
    }
  </style>
</head>
<body>

<header>
  <div>
    <h1>Service Details</h1>
  </div>
  <div>
    Welcome, <?php echo $username; ?>!
    <a href="logout.php">Logout</a>
  </div>
</header>

<h2><?php echo $details['title']; ?></h2>

<div class="content">
  <p><?php echo $details['description']; ?></p>
  <?php if ($details['apply_link'] !== "#") { ?>
    <a href="<?php echo $details['apply_link']; ?>" target="_blank">Apply for this scheme</a><br><br>
  <?php } ?>
  <a href="<?php echo $details['csc_link']; ?>" target="_blank">Visit CSC Portal for more services</a>
</div>

<footer>
  &copy; 2025 e-Governance Chatbot. All rights reserved.
</footer>

</body>
</html>

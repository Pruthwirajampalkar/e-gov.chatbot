<?php
session_start();
include 'db.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service = $_POST['service_type'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $stmt = $conn->prepare("INSERT INTO appointments (username, service_type, appointment_date, appointment_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $service, $date, $time);
    $stmt->execute();
    header("Location: appointments.php?success=1");
    exit();
}

$result = $conn->query("SELECT * FROM appointments WHERE username='$username' ORDER BY appointment_date");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Set the background image */
        body {
            background-image: url('Premium Vector _ Hand drawn announcement background.jpg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="p-6 bg-gray-50 bg-opacity-70"> <!-- Added bg-opacity-70 for transparency effect -->
<h1 class="text-2xl font-bold mb-4">Schedule Appointment</h1>
<form method="POST" class="space-y-4 max-w-md bg-white p-6 rounded-lg shadow-md">
    <select name="service_type" required class="w-full border p-2 rounded">
        <option value="">Select Service</option>
        <option value="Passport">Passport</option>
        <option value="Aadhaar">Aadhaar</option>
        <option value="Voter ID">Voter ID</option>
        <option value="Driving License">Driving License</option>
        <option value="Pan Card">Pan Card</option>
        <option value="Birth Certificate">Birth Certificate</option>
        <option value="Marriage Certificate">Marriage Certificate</option>
    </select>
    <input type="date" name="date" required class="w-full border p-2 rounded">
    <input type="time" name="time" required class="w-full border p-2 rounded">
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Book</button>
</form>
<?php if (isset($_GET['success'])) echo "<p class='text-green-600 mt-4'>Appointment scheduled successfully!</p>"; ?>
<h2 class="text-xl mt-10 mb-2">Your Appointments</h2>
<table class="w-full bg-white border mt-2">
    <tr><th class="border px-4 py-2">Service</th><th>Date</th><th>Time</th><th>Status</th></tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr class="text-center border-t"><td><?= $row['service_type'] ?></td><td><?= $row['appointment_date'] ?></td><td><?= $row['appointment_time'] ?></td><td><?= $row['status'] ?></td></tr>
    <?php endwhile; ?>
</table>
</body>
</html>

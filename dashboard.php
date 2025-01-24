<?php
session_start();

// Database credentials
$servername = "";  // Hostname
$username = "";  // Username
$password = "";  // Password
$dbname = "";    // Database Name

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the session has a user_email
if (!isset($_SESSION['user_email'])) {
    // If no user is logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Fetch user data from the database
$user_email = $_SESSION['user_email'];
$query = "SELECT name, donated, funded, impact FROM detail WHERE name = ?";

// Prepare and execute the query
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Error preparing the statement: " . $conn->error);
}

$stmt->bind_param("i", $user_email);
$stmt->execute();

// Bind the result
$stmt->bind_result($name, $donated, $funded, $impact);
if ($stmt->fetch() === false) {
    die("No user found with the given ID.");
}
$stmt->close();

// Query to fetch the active campaigns
$campaign_query = "SELECT id, name, detail, goal FROM campaign WHERE status = 'active'";
$campaign_result = $conn->query($campaign_query);

// Check if the query was successful
if ($campaign_result && $campaign_result->num_rows > 0) {
    $active_campaigns = $campaign_result->fetch_all(MYSQLI_ASSOC); // Fetch all active campaigns
} else {
    $active_campaigns = [];
}

// Close the database connection
$conn->close();
?>

<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>TrackYourDonation</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100">
  <div class="min-h-screen flex">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-md">
      <div class="p-4">
        <h1 class="text-2xl font-bold text-green-600">
          TrackYourDonation
        </h1>
      </div>
      <nav class="mt-6">
        <a class="flex items-center p-2 text-gray-700 bg-green-100 rounded-md" href="#">
          <i class="fas fa-tachometer-alt mr-3"></i>
          Dashboard
        </a>
        <a class="flex items-center p-2 mt-2 text-gray-700 hover:bg-gray-200 rounded-md" href="track.php">
          <i class="fas fa-donate mr-3"></i>
          My Donations
        </a>
        <a class="flex items-center p-2 mt-2 text-gray-700 hover:bg-gray-200 rounded-md" href="campaign.php">
          <i class="fas fa-hand-holding-heart mr-3"></i>
          Charities
        </a>
        <a class="flex items-center p-2 mt-2 text-gray-700 hover:bg-gray-200 rounded-md" href="#">
          <i class="fas fa-question-circle mr-3"></i>
          Help
        </a>
      </nav>
    </div>
    <!-- Main Content -->
    <div class="flex-1 p-6">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
          <button class="text-gray-500 focus:outline-none lg:hidden">
            <i class="fas fa-bars"></i>
          </button>
          <div class="relative ml-4 lg:ml-0">
            <input class="bg-gray-200 rounded-full pl-10 pr-4 py-2 focus:outline-none" placeholder="Search..." type="text"/>
            <i class="fas fa-search absolute left-3 top-2.5 text-gray-500"></i>
          </div>
        </div>
        <div class="flex items-center">
          
          <div class="flex items-center">
            <img alt="User Avatar" class="w-10 h-10 rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/WQ9WBX3WeCV5PaKeZmwl7LOTavQyWrJT2KXjeb2uJbSTbIOoA.jpg" width="40"/>
            <span class="ml-2 text-gray-700"><?= htmlspecialchars($name) ?></span> <!-- Display user's name -->
            <span class="ml-2 text-gray-700">
              <a class="text-blue-600" href="logout.php">Logout</a>
            </span>
          </div>
        </div>
      </div>
      <!-- Welcome Section -->
      <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="flex justify-between items-center">
          <div>
            <h2 class="text-2xl font-bold text-gray-800">
              Welcome Back, <?= htmlspecialchars($name) ?>!
            </h2>
            <p class="text-gray-600">
              Your donations are making a real impact. Let's see where your contributions are going.
            </p>
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
          <div class="bg-gray-100 p-4 rounded-md text-center">
            <h3 class="text-gray-600">Total Donated</h3>
            <p class="text-2xl font-bold text-green-600">₹<?= number_format($donated, 2) ?></p> <!-- Show donated amount -->
          </div>
          <div class="bg-gray-100 p-4 rounded-md text-center">
            <h3 class="text-gray-600">Projects Funded</h3>
            <p class="text-2xl font-bold text-green-600"><?= htmlspecialchars($funded) ?></p> <!-- Show funded projects -->
          </div>
          <div class="bg-gray-100 p-4 rounded-md text-center">
            <h3 class="text-gray-600">Active Campaigns</h3>
            <p class="text-2xl font-bold text-green-600"><?= count($active_campaigns) ?></p> <!-- Show active campaigns count -->
          </div>
          <div class="bg-gray-100 p-4 rounded-md text-center">
            <h3 class="text-gray-600">Impact Score</h3>
            <p class="text-2xl font-bold text-green-600"><?= htmlspecialchars($impact) ?></p> <!-- Show impact score -->
          </div>
        </div>
      </div>
      <!-- Active Campaigns Section -->
      <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Active Campaigns</h2>
        <?php if (count($active_campaigns) > 0): ?>
          <table class="min-w-full table-auto border-collapse">
            <thead>
              <tr>
                <th class="py-2 px-4 border-b text-left">#</th>
                <th class="py-2 px-4 border-b text-left">Campaign Name</th>
                <th class="py-2 px-4 border-b text-left">Details</th>
                <th class="py-2 px-4 border-b text-left">Goal</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($active_campaigns as $campaign): ?>
                <tr>
                  <td class="py-2 px-4 border-b"><?= htmlspecialchars($campaign['id']) ?></td>
                  <td class="py-2 px-4 border-b"><?= htmlspecialchars($campaign['name']) ?></td>
                  <td class="py-2 px-4 border-b"><?= htmlspecialchars($campaign['detail']) ?></td>
                  <td class="py-2 px-4 border-b">₹<?= number_format($campaign['goal'], 2) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p class="text-gray-600">No active campaigns at the moment.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>

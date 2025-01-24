<?php
session_start();

// Database credentials
$servername = "198.38.84.112";  // Hostname
$username = "trackyou1_test";  // Username
$password = "TRACKdonation@322";  // Password
$dbname = "trackyou1_users";    // Database Name

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

// Fetch campaigns data from the database
$query = "SELECT id, name, detail, goal, status FROM campaign WHERE status = 'active'";
$result = $conn->query($query);

// Check if any campaigns exist
if ($result->num_rows > 0) {
    $campaigns = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $campaigns = [];
}

// Close the database connection
$conn->close();
?>

<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>TrackYourDonation - Active Campaigns</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100">
  <div class="min-h-screen flex">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-md">
      <div class="p-4">
        <h1 class="text-2xl font-bold text-green-600">TrackYourDonation</h1>
      </div>
      <nav class="mt-6">
        <a class="flex items-center p-2 text-gray-700 bg-green-100 rounded-md" href="dashboard.php">
          <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
        </a>
        <a class="flex items-center p-2 mt-2 text-gray-700 hover:bg-gray-200 rounded-md" href="track.php">
          <i class="fas fa-donate mr-3"></i> My Donations
        </a>
        <a class="flex items-center p-2 mt-2 text-gray-700 hover:bg-gray-200 rounded-md" href="campaign.php">
          <i class="fas fa-hand-holding-heart mr-3"></i> Charities
        </a>
        <a class="flex items-center p-2 mt-2 text-gray-700 hover:bg-gray-200 rounded-md" href="#">
          <i class="fas fa-question-circle mr-3"></i> Help
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
        </div>
        <div class="flex items-center">
          
          <div class="flex items-center">
            <img alt="User Avatar" class="w-10 h-10 rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/WQ9WBX3WeCV5PaKeZmwl7LOTavQyWrJT2KXjeb2uJbSTbIOoA.jpg" width="40"/>
            <span class="ml-2 text-gray-700"><?= htmlspecialchars($_SESSION['user_email']) ?></span>
            <span class="ml-2 text-gray-700">
              <a class="text-blue-600" href="logout.php">Logout</a>
            </span>
          </div>
        </div>
      </div>
      <!-- Campaigns Section -->
      <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Active Campaigns</h2>
        <?php if (count($campaigns) > 0): ?>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($campaigns as $campaign): ?>
              <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-bold text-gray-800"><?= htmlspecialchars($campaign['name']) ?></h3>
                <p class="text-gray-600"><?= htmlspecialchars($campaign['detail']) ?></p>
                <div class="mt-4">
                  <p class="text-gray-800">Goal: ₹<?= number_format($campaign['goal'], 2) ?></p>
                  <form action="donate.php" method="post" class="mt-4">
                    <input type="hidden" name="campaign_id" value="<?= $campaign['id'] ?>">
                    <button type="submit" class="w-full py-2 px-4 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none">
                      Donate Now
                    </button>
                  </form>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="text-gray-600">No active campaigns found.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>

<?php
session_start();

// Database credentials
$servername = "198.38.84.112";  // Hostname
$username = "trackyou1_test";  // Username
$password = "TRACKdonation@322";  // Password
$dbname = "trackyou1_users";    // Database Name

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    // If no user is logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process donation if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['campaign_id'], $_POST['amount'], $_POST['transaction_id'])) {
    $campaign_id = $_POST['campaign_id'];
    $donation_amount = $_POST['amount'];
    $transaction_id = $_POST['transaction_id'];
    $user_email = $_SESSION['user_email'];

    // Check if donation amount is valid
    if ($donation_amount <= 0) {
        $error_message = "Please enter a valid donation amount.";
    } else {
        // Insert the donation into the donations table
        $stmt = $conn->prepare("INSERT INTO donations (campaign_id, user_email, amount, transaction_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isds", $campaign_id, $user_email, $donation_amount, $transaction_id);

        if ($stmt->execute()) {
            $success_message = "Thank you for your generous donation of ₹" . number_format($donation_amount, 2);
        } else {
            $error_message = "There was an error processing your donation. Please try again.";
        }

        $stmt->close();
    }
}

// Fetch the campaign details
if (isset($_POST['campaign_id'])) {
    $campaign_id = $_POST['campaign_id'];
    $query = "SELECT id, name, detail, goal FROM campaign WHERE id = ? AND status = 'active'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $campaign_id);
    $stmt->execute();
    $stmt->bind_result($id, $name, $detail, $goal);
    if (!$stmt->fetch()) {
        die("Campaign not found or no longer active.");
    }
    $stmt->close();
} else {
    die("Campaign ID not provided.");
}

// Close the database connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Donate to Campaign - TrackYourDonation</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <div class="min-h-screen flex">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-md">
      <div class="p-4">
        <h1 class="text-2xl font-bold text-green-600">TrackYourDonation</h1>
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
        <a class="flex items-center p-2 mt-2 text-gray-700 hover:bg-gray-200 rounded-md" href="#">
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
      <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Donate to <?= htmlspecialchars($name) ?></h2>
        <p class="text-gray-600 mb-4">
          Your contribution to the <strong><?= htmlspecialchars($name) ?></strong> campaign will help achieve the goal of <strong>₹<?= number_format($goal, 2) ?></strong>.
        </p>

        <?php if (isset($success_message)): ?>
          <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4">
            <?= htmlspecialchars($success_message) ?>
          </div>
        <?php elseif (isset($error_message)): ?>
          <div class="bg-red-100 text-red-800 p-4 rounded-md mb-4">
            <?= htmlspecialchars($error_message) ?>
          </div>
        <?php endif; ?>

        <!-- QR Code Image for User to Scan -->
        <div class="mb-4">
          <h3 class="text-xl font-semibold text-gray-700">Scan to Donate</h3>
          <img src="unnamed.png" alt="QR Code" class="mt-2" />
        </div>

        <form method="POST" action="donate.php" class="space-y-4">
          <div class="space-y-2">
            <label for="amount" class="block text-gray-600">Donation Amount</label>
            <input type="number" id="amount" name="amount" class="w-full p-3 rounded-md border border-gray-300" placeholder="Enter amount" required min="1" />
          </div>

          <div class="space-y-2">
            <label for="transaction_id" class="block text-gray-600">Transaction ID</label>
            <input type="text" id="transaction_id" name="transaction_id" class="w-full p-3 rounded-md border border-gray-300" placeholder="Enter transaction ID" required />
          </div>

          <input type="hidden" name="campaign_id" value="<?= $id ?>">

          <button type="submit" class="w-full py-3 px-4 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none">
            Donate Now
          </button>
        </form>

      </div>
    </div>
  </div>
</body>
</html>

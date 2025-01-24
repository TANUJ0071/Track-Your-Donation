<?php
// Start the session
session_start();

// Database credentials
$servername = "";  // Hostname
$username = "";  // Username
$password = "";  // Password
$dbname = "";    // Database Name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['user_email'])) {
    // Redirect to login if not logged in
    header("Location: login.php");
    exit();
}

// Sanitize email for safe table name
$user_email = $_SESSION['user_email'];
$sanitized_email = str_replace(['@', '.'], ['_', '_'], $user_email);
$user_table = "user_" . $sanitized_email . "_campaign_details";

// Fetch campaigns from the user's specific table
$query = "SELECT campaign FROM $user_table";
$result = $conn->query($query);

// Store campaign IDs
$campaigns = [];
while ($row = $result->fetch_assoc()) {
    $campaigns[] = $row['campaign'];
}

// Fetch active campaigns from the campaign table based on the selected IDs
$active_campaigns = [];
foreach ($campaigns as $campaign_id) {
    $status_query = "SELECT id, name FROM campaign WHERE id = '$campaign_id' AND status = 'active'";
    $status_result = $conn->query($status_query);

    if ($status_result->num_rows > 0) {
        while ($status_row = $status_result->fetch_assoc()) {
            $active_campaigns[] = $status_row;
        }
    }
}

// Fetch Donation and Utilization details
$donation_details = [];
$utilization_details = [];
$impact_details = [];
$mobileno_details = [];

if (count($active_campaigns) > 0) {
    foreach ($active_campaigns as $campaign) {
        $campaign_id = $campaign['id'];

        // Fetch Donation
        $donation_query = "SELECT donation FROM $user_table WHERE campaign = '$campaign_id'";
        $donation_result = $conn->query($donation_query);
        if ($donation_result->num_rows > 0) {
            $donation_details = $donation_result->fetch_assoc();
        }

        // Fetch Utilization Breakdown
        $utilization_query = "SELECT education, food FROM $user_table WHERE campaign = '$campaign_id'";
        $utilization_result = $conn->query($utilization_query);
        if ($utilization_result->num_rows > 0) {
            $utilization_details = $utilization_result->fetch_assoc();
        }

        // Fetch Impact Metrics
        $impact_query = "SELECT impact FROM $user_table WHERE campaign = '$campaign_id'";
        $impact_result = $conn->query($impact_query);
        if ($impact_result->num_rows > 0) {
            $impact_details = $impact_result->fetch_assoc();
        }

        // Fetch Charity Mobile No
        $mobileno_query = "SELECT charity FROM $user_table WHERE campaign = '$campaign_id'";
        $mobileno_result = $conn->query($mobileno_query);
        if ($mobileno_result->num_rows > 0) {
            $mobileno_details = $mobileno_result->fetch_assoc();
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Donation Flow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        header {
            background-color: #2c7a7b;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        .container {
            margin: 20px auto;
            max-width: 900px;
            padding: 20px;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .flow-diagram {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
            display: none;
        }

        .flow-step {
            text-align: center;
            padding: 20px;
            width: 100%;
            max-width: 300px;
            background-color: #edf2f7;
            border: 2px solid #2c7a7b;
            border-radius: 10px;
            position: relative;
        }

        .flow-step::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 30px;
            background-color: #2c7a7b;
        }

        .flow-step:last-child::after {
            display: none;
        }

        .step-title {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2c7a7b;
        }

        .step-details {
            font-size: 0.9em;
            color: #4a5568;
        }

        .campaign-selection {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        select {
            padding: 10px;
            font-size: 1em;
            border: 2px solid #2c7a7b;
            border-radius: 5px;
            background-color: #f4f4f9;
        }

        button {
            padding: 10px 20px;
            background-color: #2c7a7b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1d4f4b;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            padding: 20px;
        }

        .sidebar h1 {
            font-size: 24px;
            color: #2c7a7b;
        }

        .sidebar nav a {
            display: block;
            padding: 10px;
            margin-top: 10px;
            background-color: #f7fafc;
            color: #2c7a7b;
            border-radius: 5px;
            text-decoration: none;
        }

        .sidebar nav a:hover {
            background-color: #edf2f7;
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .flow-step {
                max-width: 100%;
            }

            .sidebar {
                width: 200px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h1>TrackYourDonation</h1>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="track.php">My Donations</a>
            <a href="campaign.php">Charities</a>
            <a href="#">Help</a>
        </nav>
    </div>

    <!-- Main content area -->
    <div style="margin-left: 250px; padding: 20px;">
        <header>
            <h1>Track Your Donation Flow</h1>
        </header>

        <div class="container">
            <!-- Campaign Selection Section -->
            <div class="campaign-selection">
                <h2>Select a Campaign</h2>
                <select id="campaignSelect">
                    <!-- PHP will dynamically populate this -->
                    <?php
                    if (count($active_campaigns) > 0) {
                        foreach ($active_campaigns as $campaign) {
                            echo '<option value="' . $campaign['id'] . '">' . $campaign['name'] . '</option>';
                        }
                    } else {
                        echo '<option>No active campaigns available</option>';
                    }
                    ?>
                </select>
                <?php
                if (count($active_campaigns) > 0) {
                    echo '<button onclick="showDonationFlow()">Show Donation Flow</button>';
                } else {
                    echo '<button onclick="window.location.href=\'dashboard.php\'">Donate Now</button>';
                }
                ?>
            </div>

            <!-- Donation Flow Diagram Section -->
            <div class="flow-diagram" id="flowDiagram">
                <div class="flow-step">
                    <div class="step-title">Donation Received</div>
                    <div class="step-details" id="donationDetails">
                        ₹<?php echo isset($donation_details['donation']) ? $donation_details['donation'] : 'N/A'; ?> donated by you
                    </div>
                </div>

                <div class="flow-step">
                    <div class="step-title">Charity Allocation</div>
                    <div class="step-details" id="charityDetails">
                        Allocated to "<?php echo isset($active_campaigns[0]['name']) ? $active_campaigns[0]['name'] : 'No Campaign'; ?>" campaign
                    </div>
                </div>

                <div class="flow-step">
                    <div class="step-title">Utilization Breakdown</div>
                    <div class="step-details" id="utilizationDetails">
                        ₹<?php echo isset($utilization_details['education']) ? $utilization_details['education'] : 'N/A'; ?> for education,
                        ₹<?php echo isset($utilization_details['food']) ? $utilization_details['food'] : 'N/A'; ?> for food
                    </div>
                </div>

                <div class="flow-step">
                    <div class="step-title">Impact Metrics</div>
                    <div class="step-details" id="impactDetails">
                        Supported <?php echo isset($impact_details['impact']) ? $impact_details['impact'] : 'N/A'; ?> children
                    </div>
                </div>

                <div class="flow-step">
                    <div class="step-title">Charity Mobileno</div>
                    <div class="step-details" id="mobilenoDetails">
                        <?php echo isset($mobileno_details['charity']) ? $mobileno_details['charity'] : 'N/A'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDonationFlow() {
            document.getElementById('flowDiagram').style.display = 'flex';
        }
    </script>
</body>
</html>

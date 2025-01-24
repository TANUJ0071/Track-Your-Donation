<?php
// Start session to track the logged-in user
session_start();

// Database connection parameters
$servername = "198.38.84.112";
$username = "trackyou1_test";
$password = "TRACKdonation@322";
$dbname = "trackyou1_users";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    // If no user is logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Check if the logged-in user email is the expected email
$loggedInUserEmail = $_SESSION['user_email'];

// If the logged-in user is not 'tanuj@gmail.com', show message and exit
if ($loggedInUserEmail !== 'tanuj@gmail.com') {
    echo "<h2>You are now an admin, please login with admin credentials.</h2>";
    exit();
}

// SQL query to fetch donations data
$sql = "SELECT id, campaign_id, user_email, amount, transaction_id, created_at FROM donations";
$result = $conn->query($sql);

// Start HTML output
echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Donations</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }";
echo "table { width: 100%; border-collapse: collapse; margin: 20px 0; background-color: white; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }";
echo "table, th, td { border: 1px solid #ddd; }";
echo "th, td { padding: 10px; text-align: left; }";
echo "th { background-color: #f2f2f2; }";
echo "h1 { text-align: center; color: #333; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<h1>Donations List</h1>";

// Check if there are results
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Campaign ID</th><th>User Email</th><th>Amount</th><th>Transaction ID</th><th>Created At</th></tr>";
    
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["campaign_id"] . "</td>";
        echo "<td>" . $row["user_email"] . "</td>";
        echo "<td>" . $row["amount"] . "</td>";
        echo "<td>" . $row["transaction_id"] . "</td>";
        echo "<td>" . $row["created_at"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No donations found.</p>";
}

echo "</body>";
echo "</html>";

// Close connection
$conn->close();
?>

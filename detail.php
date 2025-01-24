<?php
// Start session to track the logged-in user
session_start();

// Database connection settings
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

// Get the logged-in user's email from the session
$loggedInUserEmail = $_SESSION['user_email'];

// If the logged-in user is not 'tanuj@gmail.com', show message and exit
if ($loggedInUserEmail !== 'tanuj@gmail.com') {
    echo "<h2>You are now an admin, please login with admin credentials.</h2>";
    exit();
}

// Update query using prepared statements
if (isset($_POST['update'])) {
    // Collect data from the form
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $donated = $_POST['donated'];
    $funded = $_POST['funded'];
    $impact = $_POST['impact'];

    // Prepare the SQL statement to avoid SQL injection
    $stmt = $conn->prepare("UPDATE detail SET name=?, password=?, donated=?, funded=?, impact=? WHERE email=?");

    // Check if prepare() returned false
    if ($stmt === false) {
        die("SQL prepare error: " . $conn->error);
    }

    // Bind the parameters (email is the last one)
    $stmt->bind_param("ssssss", $name, $password, $donated, $funded, $impact, $email);

    // Execute the query
    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Fetch all records
$sql = "SELECT * FROM detail";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        input[type="text"] {
            width: 100%;
        }
    </style>
</head>
<body>

    <h2>Edit Data</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th>Donated</th>
                    <th>Funded</th>
                    <th>Impact</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <form action="detail.php" method="POST">
                            <td><input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>"></td>
                            <td><input type="text" name="password" value="<?php echo htmlspecialchars($row['password']); ?>"></td>
                            <td><input type="text" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" readonly></td>
                            <td><input type="text" name="donated" value="<?php echo htmlspecialchars($row['donated']); ?>"></td>
                            <td><input type="text" name="funded" value="<?php echo htmlspecialchars($row['funded']); ?>"></td>
                            <td><input type="text" name="impact" value="<?php echo htmlspecialchars($row['impact']); ?>"></td>
                            <input type="hidden" name="email" value="<?php echo $row['email']; ?>"> <!-- Hidden email for the update -->
                            <td><button type="submit" name="update">Update</button></td>
                        </form>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No records found</p>
    <?php endif; ?>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>

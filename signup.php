<?php
// Start the session
session_start();

// Database credentials
$servername = "198.38.84.112";  // Hostname
$username = "trackyou1_test";  // Username
$password = "TRACKdonation@322";  // Password
$dbname = "trackyou1_users";    // Database Name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if session already exists (user is logged in)
if (isset($_SESSION['user_email'])) {
    // If session exists, redirect to dashboard.php
    header("Location: dashboard.php");
    exit();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form input
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Check if email already exists
    $emailCheckQuery = "SELECT * FROM detail WHERE email = '$email'";
    $result = $conn->query($emailCheckQuery);

    if ($result->num_rows > 0) {
        // Email exists, show error message
        echo "<script>alert('Email already exists. Please use a different email.');</script>";
    } else {
        // Validate password match
        if ($password == $confirmPassword) {
            // Insert new user into the database
            $insertQuery = "INSERT INTO detail (name, email, password) VALUES ('$name', '$email', '$password')";

            if ($conn->query($insertQuery) === TRUE) {
                // Set session variables after successful registration
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;

                // Sanitize email to be used as a table name
                // Replace "@" with "_" and "." with "_"
                $sanitized_email = str_replace(['@', '.'], ['_', '_'], $email);

                // Create table for the new user
                $user_table_name = "user_" . $sanitized_email . "_campaign_details";  // Table name is user-specific

                $createTableQuery = "
                    CREATE TABLE $user_table_name (
                        sid INT(11) AUTO_INCREMENT PRIMARY KEY,
                        campaign INT(11) NOT NULL,
                        donation INT(11) NOT NULL,
                        charity INT(11) NOT NULL,
                        education INT(11) NOT NULL,
                        impact INT(11) NOT NULL,
                        food INT(11) NOT NULL
                    )
                ";

                if ($conn->query($createTableQuery) === TRUE) {
                    // Table created successfully
                                        // Registration successful, redirect to dashboard
                header("Location: dashboard.php");
                exit();
                
                } else {
                    echo "Error creating table: " . $conn->error;
                }
            } else {
                // Error in inserting data
                echo "Error: " . $insertQuery . "<br>" . $conn->error;
            }
        } else {
            echo "<script>alert('Passwords do not match.');</script>";
        }
    }
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrackYourDonation</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
        }

        header {
            background: #fff;
            padding: 20px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 40px;
            margin-right: 10px;
        }

        .logo span {
            font-size: 24px;
            font-weight: 700;
            color: #1abc9c;
        }

        nav {
            float: right;
        }

        nav a {
            margin-left: 20px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
        }

        /* Hero Section */
        .hero {
            background: url('donation.jpg') no-repeat center center/cover;
            color: #fff;
            text-align: center;
            padding: 100px 0;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .hero .btn {
            background: #1abc9c;
            color: #fff;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        /* Form Section */
        .form-section {
            background: #f9f9f9;
            padding: 50px 0;
        }

        .form-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        .form-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-container .btn {
            background: #1abc9c;
            color: #fff;
            padding: 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        /* Footer */
        footer {
            background: #333;
            color: #fff;
            padding: 50px 0;
        }

        footer .container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        footer .column {
            width: 30%;
            margin-bottom: 20px;
        }

        footer .column h3 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        footer .column p,
        footer .column a {
            font-size: 14px;
            color: #fff;
            text-decoration: none;
            margin-bottom: 10px;
            display: block;
        }

        footer .social-icons {
            display: flex;
            justify-content: flex-end;
        }

        footer .social-icons i {
            font-size: 24px;
            margin-left: 10px;
        }

        @media (max-width: 768px) {
            nav {
                float: none;
                text-align: center;
                margin-top: 20px;
            }
            footer .column {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <div class="container">
            <div class="logo">
                <img alt="TrackYourDonation Logo" height="40" src="logo.png" width="40"/>
                <span>TrackYourDonation</span>
            </div>
            <nav>
                <a href="#">Home</a>
                <a href="#">How It Works</a>
                <a href="#">Contact Us</a>
                <a class="btn" href="login.php">Log In</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Create Your Account to Track Your Donations</h1>
            <p>Start seeing exactly how your contributions are making a difference. It's simple, transparent, and secure.</p>
            <button class="btn"><a href="#signup1" style="color:white; text-decoration:none;">Sign Up Now</a></button>
        </div>
    </section>

    <!-- Sign-Up Form Section -->
    <section id="signup1" class="form-section">
        <div class="container">
            <div class="form-container">
                <h2>Join TrackYourDonation in Three Simple Steps</h2>
                <form action="" method="POST">
                    <label for="fullname">Full Name</label>
                    <input id="fullname" name="name" placeholder="Enter your full name" type="text" required/>

                    <label for="email">Email Address</label>
                    <input id="email" name="email" placeholder="Enter your email address" type="email" required/>

                    <label for="password">Password</label>
                    <input id="password" name="password" placeholder="Create a password" type="password" required/>

                    <label for="confirm-password">Confirm Password</label>
                    <input id="confirm-password" name="confirm-password" placeholder="Confirm your password" type="password" required/>

                    <button class="btn" type="submit">Create Account</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <div class="container">
            <div class="column">
                <h3>TrackYourDonation</h3>
                <p>Your privacy is our priority. We protect your personal information with industry-leading security measures.</p>
            </div>
            <div class="column">
                <h3>Quick Links</h3>
                <a href="#">About Us</a>
                <a href="#">How It Works</a>
                <a href="#">Contact Us</a>
                <a href="#">Help Center</a>
            </div>
            <div class="column">
                <h3>Legal</h3>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms & Conditions</a>
            </div>
            <div class="social-icons">
                <i class="fab fa-facebook-f"></i>
                <i class="fab fa-twitter"></i>
                <i class="fab fa-instagram"></i>
                <i class="fab fa-linkedin-in"></i>
            </div>
        </div>
        <div class="container">
            <p>© 2025 TrackYourDonation. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>

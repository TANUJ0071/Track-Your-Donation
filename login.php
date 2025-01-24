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

// Check if session already exists (user is logged in)
if (isset($_SESSION['user_email'])) {
    // If session exists, redirect to dashboard.php
    header("Location: dashboard.php");
    exit();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form input
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Query to check user credentials
    $sql = "SELECT * FROM detail WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, create session variables
        $user = $result->fetch_assoc();
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];

        // Redirect to dashboard.php after successful login
        header("Location: dashboard.php");
        exit();
    } else {
        // Invalid credentials, show error message
        echo "<script>alert('Invalid email or password. Please try again.');</script>";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background-color: #fff;
            border-bottom: 1px solid #e0e0e0;
        }
        header .logo {
            font-size: 24px;
            font-weight: 700;
            color: #00a651;
        }
        header nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }
        header .sign-up {
            padding: 10px 20px;
            background-color: #00a651;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
        }
        .hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 60px 40px;
            background: url('donation.jpg') no-repeat center center/cover;
            color: #fff;
        }
        .hero .content {
            max-width: 50%;
        }
        .hero .content h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        .hero .content p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .hero .login-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #333;
        }
        .hero .login-form h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .hero .login-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .hero .login-form .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .hero .login-form .remember-me input {
            margin-right: 10px;
        }
        .hero .login-form .login-btn {
            width: 100%;
            padding: 10px;
            background-color: #00a651;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .hero .login-form .forgot-password {
            text-align: right;
            margin-top: 10px;
        }
        .hero .login-form .forgot-password a {
            color: #00a651;
            text-decoration: none;
        }
        .security-section {
            text-align: center;
            padding: 60px 40px;
            background-color: #f9f9f9;
        }
        .security-section h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .security-section p {
            font-size: 18px;
            margin-bottom: 40px;
        }
        .security-section .features {
            display: flex;
            justify-content: space-around;
        }
        .security-section .feature {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 30%;
        }
        .security-section .feature h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .security-section .feature p {
            font-size: 16px;
        }
        .cta-section {
            text-align: center;
            padding: 60px 40px;
            background-color: #e0f7e9;
        }
        .cta-section h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .cta-section .cta-btn {
            padding: 15px 30px;
            background-color: #00a651;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
        }
        footer {
            background-color: #333;
            color: #fff;
            padding: 40px;
            display: flex;
            justify-content: space-between;
        }
        footer .column {
            width: 30%;
        }
        footer .column h3 {
            font-size: 18px;
            margin-bottom: 20px;
        }
        footer .column p, footer .column a {
            font-size: 16px;
            color: #ccc;
            text-decoration: none;
            margin-bottom: 10px;
            display: block;
        }
        footer .social-icons a {
            margin-right: 10px;
            color: #ccc;
            font-size: 20px;
        }
        @media (max-width: 768px) {
            .hero {
                flex-direction: column;
                text-align: center;
            }
            .hero .content, .hero .login-form {
                max-width: 100%;
            }
            .security-section .features {
                flex-direction: column;
            }
            .security-section .feature {
                width: 100%;
                margin-bottom: 20px;
            }
            footer {
                flex-direction: column;
                text-align: center;
            }
            footer .column {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">TrackYourDonation</div>
        <nav>
            <a href="https://trackyourdonation.online/">Home</a>
            <a href="#">How It Works</a>
            <a href="#">Contact Us</a>
        </nav>
        <a href="signup.php" class="sign-up">Sign Up</a>
    </header>
    <section class="hero">
        <div class="content">
            <h1>Welcome Back to TrackYourDonation</h1>
            <p>Log in to continue tracking your donations and see the impact of your contributions.</p>
        </div>
        <div class="login-form">
            <h2>Securely Log In to Your Account</h2>
            <form action="" method="POST">
                <input type="email" name="email" placeholder="Enter your email address" required>
                <input type="password" name="password" placeholder="Enter your password" required>
                
                <button type="submit" class="login-btn">Log In</button>
            </form>
            <div class="forgot-password">
                <a href="#">Forgot password?</a>
            </div>
        </div>
    </section>
    <section class="security-section">
        <h2>Your Data Is Safe with Us</h2>
        <p>We prioritize your security and transparency. Your donations and personal data are always protected.</p>
        <div class="features">
            <div class="feature">
                <h3>SSL Encryption</h3>
                <p>Industry-leading encryption to keep your data secure</p>
            </div>
            <div class="feature">
                <h3>GDPR Compliant</h3>
                <p>Your personal data is protected under GDPR guidelines</p>
            </div>
            <div class="feature">
                <h3>Full Transparency</h3>
                <p>Track exactly how your donations are being used</p>
            </div>
        </div>
    </section>
    <section class="cta-section">
        <h2>New to TrackYourDonation?</h2>
        <a href="signup.php" class="cta-btn">Create an Account</a>
    </section>
    <footer>
        <div class="column">
            <h3>TrackYourDonation</h3>
            <p>Your privacy is our priority. We protect your personal information with industry-leading security measures.</p>
        </div>
        <div class="column">
            <h3>Quick Links</h3>
            <a href="#">About Us</a>
            <a href="#">How It Works</a>
            <a href="#">Contact Us</a>
        </div>
        <div class="column">
            <h3>Support</h3>
            <a href="#">Help Center</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
        </div>
        <div class="column social-icons">
            <h3>Connect With Us</h3>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </footer>
</body>
</html>

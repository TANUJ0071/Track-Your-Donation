<html>
<head>
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
            background: #fff;
            padding: 20px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #00a651;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }
        nav ul li {
            display: inline;
        }
        nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }
        .auth-buttons a {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 500;
        }
        .auth-buttons .sign-in {
            color: #00a651;
            border: 1px solid #00a651;
        }
        .auth-buttons .get-started {
            background: #00a651;
            color: #fff;
        }
        .hero {
            background: url('donation.jpg') no-repeat center center/cover;
            color: #fff;
            text-align: center;
            padding: 100px 20px;
        }
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .hero p {
            font-size: 18px;
            margin-bottom: 40px;
        }
        .hero .buttons a {
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 5px;
            font-weight: 500;
            margin: 0 10px;
        }
        .hero .buttons .start-tracking {
            background: #00a651;
            color: #fff;
        }
        .hero .buttons .learn-how {
            background: #fff;
            color: #00a651;
        }
        .section {
            padding: 60px 20px;
            text-align: center;
        }
        .section h2 {
            font-size: 32px;
            margin-bottom: 20px;
        }
        .section p {
            font-size: 18px;
            margin-bottom: 40px;
        }
        .icons {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }
        .icon {
            flex: 1;
            min-width: 200px;
            max-width: 250px;
            text-align: center;
        }
        .icon i {
            font-size: 48px;
            color: #00a651;
            margin-bottom: 10px;
        }
        .icon h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .icon p {
            font-size: 16px;
        }
        .donations {
            background: #f0fdf4;
            padding: 60px 20px;
        }
        .donations .cards {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex: 1;
            min-width: 250px;
            max-width: 300px;
        }
        .card h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .card p {
            font-size: 16px;
        }
        .testimonials {
            padding: 60px 20px;
        }
        .testimonials .cards {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }
        .testimonial {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex: 1;
            min-width: 250px;
            max-width: 300px;
        }
        .testimonial p {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .testimonial h4 {
            font-size: 18px;
            font-weight: 700;
        }
        .cta {
            background: #00a651;
            color: #fff;
            text-align: center;
            padding: 60px 20px;
        }
        .cta h2 {
            font-size: 32px;
            margin-bottom: 20px;
        }
        .cta p {
            font-size: 18px;
            margin-bottom: 40px;
        }
        .cta .buttons a {
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 5px;
            font-weight: 500;
            margin: 0 10px;
            background: #fff;
            color: #00a651;
        }
        footer {
            background: #333;
            color: #fff;
            padding: 40px 20px;
            text-align: center;
        }
        footer .footer-content {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }
        footer .footer-content div {
            flex: 1;
            min-width: 200px;
            max-width: 250px;
        }
        footer h4 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        footer p, footer ul {
            font-size: 14px;
        }
        footer ul {
            list-style: none;
            padding: 0;
        }
        footer ul li {
            margin-bottom: 5px;
        }
        footer ul li a {
            text-decoration: none;
            color: #fff;
        }
        footer .social-icons a {
            color: #fff;
            margin: 0 10px;
            font-size: 18px;
        }
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                gap: 10px;
            }
            .icons, .donations .cards, .testimonials .cards, .footer-content {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">TrackYourDonation</div>
                <ul>
                    <li><a href="#">How It Works</a></li>
                    <li><a href="#">Impact</a></li>
                    <li><a href="#">Charities</a></li>
                    <li><a href="#">About</a></li>
                </ul>
                <div class="auth-buttons">
                    <a href="signup.php" class="sign-in">Sign In</a>
                    <a href="dashboard.php" class="get-started">Get Started</a>
                </div>
            </nav>
        </div>
    </header>
    <section class="hero">
        <div class="container">
            <h1>Track Your Impact, Know Where Your Money Goes</h1>
            <p>See exactly how your donations are making a difference—every penny, every project.</p>
            <div class="buttons">
                <a href="#" class="start-tracking">Start Tracking Now</a>
                <a href="#" class="learn-how">Learn How It Works</a>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <h2>Transparency You Can Trust</h2>
            <p>Every donation is tracked and used exactly as promised</p>
            <div class="icons">
                <div class="icon">
                    <i class="fas fa-heartbeat"></i>
                    <h3>Healthcare</h3>
                    <p>80% to Medical Programs</p>
                </div>
                <div class="icon">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>Education</h3>
                    <p>15% to Schools</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tint"></i>
                    <h3>Clean Water</h3>
                    <p>3% to Infrastructure</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ambulance"></i>
                    <h3>Emergency Relief</h3>
                    <p>2% to Crisis Response</p>
                </div>
            </div>
        </div>
    </section>
    <section class="donations">
        <div class="container">
            <h2>See Your Donations at Work—In Real Time</h2>
            <p>Get regular updates and impact reports for every donation you make</p>
            <div class="cards">
                <div class="card">
                    <h3>Current Projects</h3>
                    <p>Medical Supplies for Children <span style="color: green;">85%</span></p>
                    <p>School Building Project <span style="color: green;">60%</span></p>
                </div>
                <div class="card">
                    <h3>Recent Donations</h3>
                    <p>Sarah M. donated $100 to Healthcare</p>
                    <p>John D. donated $250 to Education</p>
                </div>
                <div class="card">
                    <h3>Impact Overview</h3>
                    <p>10,000+ People Helped</p>
                    <p>25 Countries Global Reach</p>
                </div>
            </div>
        </div>
    </section>
    <section class="testimonials">
        <div class="container">
            <h2>What Our Donors Say</h2>
            <p>Thousands of people are already making a difference with us</p>
            <div class="cards">
                <div class="testimonial">
                    <p>"I love being able to track exactly where my donations go. The transparency is incredible, and it makes me confident about giving more."</p>
                    <h4>Emma Thompson</h4>
                    <p>Monthly Donor</p>
                </div>
                <div class="testimonial">
                    <p>"The real-time updates and impact reports make me feel connected to the causes I support. It's amazing to see the difference we're making."</p>
                    <h4>Michael Chen</h4>
                    <p>Regular Donor</p>
                </div>
                <div class="testimonial">
                    <p>"As a business owner, I appreciate the detailed tracking and reporting. It helps us show our stakeholders the impact of our charitable giving."</p>
                    <h4>Lisa Rodriguez</h4>
                    <p>Corporate Donor</p>
                </div>
            </div>
        </div>
    </section>
    <section class="cta">
        <div class="container">
            <h2>Ready to Make a Real Difference?</h2>
            <p>Start tracking your donations today and see the impact of your contributions</p>
            <div class="buttons">
                <a href="#">Get Started</a>
                <a href="#">Explore Charities</a>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <div class="footer-content">
                <div>
                    <h4>TrackYourDonation</h4>
                    <p>We are committed to the ethical use of donations. 100% of your data is protected, and you control how your information is used.</p>
                </div>
                <div>
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">How It Works</a></li>
                        <li><a href="#">Impact Reports</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Connect With Us</h4>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <p>&copy; 2025 TrackYourDonation. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
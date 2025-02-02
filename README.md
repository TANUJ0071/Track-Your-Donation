# Track-Your-Donation

A platform designed to bring transparency and trust to donations. Track your contributions in real-time, see exactly how they're making an impact, and stay connected with the causes you care about.  Our website ensures accountability.


## Features and Functionality

* **Real-time Donation Tracking:**  Monitor your donations and their progress in real-time.
* **Impact Reporting:**  See exactly how your contributions are being utilized and the positive impact they are creating.
* **Campaign Visibility:**  View active campaigns and donate to the causes you care about.
* **User Dashboard:**  Access a personalized dashboard to view your donation history, impact score, and more.
* **Secure Transactions:** (Assumed, not explicitly shown in code)  Safe and secure payment gateway integration.
* **Admin Panel:** (Present in `detail.php` and `donations.php`)  Allows administrators to manage user data, update campaign details and view donation records.


## Technology Stack

* **PHP:** Server-side scripting language.
* **MySQL:** Database for storing user data, campaign information, and donation details.
* **HTML, CSS:** Front-end technologies for creating the user interface.
* **Tailwind CSS:**  CSS framework for rapid UI development.
* **Font Awesome:** Icon library.


## Prerequisites

* **Web Server:** Apache, Nginx, or similar.
* **PHP:** Version 7.4 or higher (or as specified by your Tailwind CSS setup).
* **MySQL:** Database server with appropriate credentials.
* **PHP MySQLi Extension:** Ensure this is enabled in your PHP configuration.


## Installation Instructions

1. **Clone the Repository:**

   ```bash
   git clone https://github.com/TANUJ0071/Track-Your-Donation.git
   ```

2. **Database Setup:** Create a MySQL database and import the necessary tables (structure not provided in the given code snippets; this is a crucial missing part). Update the database credentials (`servername`, `username`, `password`, `dbname`) in the `campaign.php`, `dashboard.php`, `detail.php`, `donate.php`, `donations.php`, `login.php` and `signup.php` files.

3. **Configure Web Server:** Configure your web server to serve the files from the cloned directory.


## Usage Guide

1. **Sign Up/Log In:**  Navigate to `signup.php` to create a new account or `login.php` to log in with existing credentials.
2. **Dashboard:** Upon successful login, you will be redirected to your dashboard (`dashboard.php`).
3. **Track Donations:** View your donation history and impact through `track.php`.
4. **View Campaigns:** Browse active campaigns and donate via `campaign.php`.
5. **Admin Access:**  `detail.php` and `donations.php` provide admin functionality (access restricted, as indicated in the code; requires `test@gmail.com` credentials). This requires proper authentication setup.



## API Documentation

No API is explicitly defined in the provided code.


## Contributing Guidelines

1. **Fork the Repository:** Create a fork of the project on your GitHub account.
2. **Create a Branch:** Create a new branch for your feature or bug fix.
3. **Make Changes:** Implement your changes and ensure they are well-documented.
4. **Test Thoroughly:** Test your changes to ensure they work correctly.
5. **Create a Pull Request:** Submit a pull request to the main branch of the original repository.


## License Information

License information is not specified in the repository.  This needs to be added.


## Contact/Support Information

For support or inquiries, please contact the repository owner (TANUJ0071) through GitHub or other means they choose to make public (e.g., an email address in the repository's about section or other files).  There are no contact details present in the provided code.

# TrackYourDonation

TrackYourDonation is a web application that allows users to track the impact of their donations and see how their contributions are being used.

## Installation

1. Clone the repository:
```
git clone https://github.com/your-username/trackyourdonation.git
```
2. Install the required dependencies:
```
composer install
```
3. Create a new database and update the database credentials in the `config.php` file.
4. Run the SQL script to create the necessary tables.
5. Start the development server:
```
php -S localhost:8000
```

## Usage

1. Register a new account or log in to an existing one.
2. Explore the available campaigns and make donations.
3. Track the progress of your donations and see the impact metrics.
4. Manage your donation history and view detailed reports.

## Contributing

1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Implement your changes and ensure the tests pass.
4. Submit a pull request with a detailed description of your changes.

## License

This project is licensed under the [MIT License](LICENSE).

## Testing

To run the test suite, execute the following command:

```
phpunit tests/
```

The test suite covers the following aspects of the application:

- User authentication and authorization
- Donation processing and tracking
- Campaign management
- Impact reporting

Make sure all tests pass before submitting your changes.

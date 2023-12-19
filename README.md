<a href="https://github.com/divyeshz/StudentDataLoader.git"> <h1 align="center">Student Data Loader</h1></a>

This Laravel-based application manages student data, imports student results, exports data from the database, and schedules result emails to students.


## About

This system provides functionality to import student data and their results, export data from the database, and schedule result emails to be sent to students.

> **Note**
> Work in Progress

## Requirements

Package | Version
--- | ---
[Composer](https://getcomposer.org/)  | V2.6.3+
[Php](https://www.php.net/)  | V8.0.17
[Laravel](https://laravel.com/)  | V10.28.0

## Getting Started

To get the StudentDataLoader project up and running, follow these steps:

## Prerequisites

Before installation, ensure you have the required software and dependencies installed:

- PHP is installed on your machine.
- Composer globally installed.
- MySQL or any compatible database server running.

## Installation

> **Warning**
> Make sure to follow the requirements first.

1. Clone the repository to your local machine:

   ```bash
   git clone https://github.com/divyeshz/StudentDataLoader.git
   ```

2. Change the working directory:

   ```bash
   cd StudentDataLoader
   ```

3. Install PHP dependencies using Composer:

   ```bash
   composer install
   ```

4. Create a copy of the `.env.example` file and rename it to `.env`. Update the file with your database configuration and mail settings.

5. Generate an application key:

   ```bash
   php artisan key:generate
   ```

6. Migrate the Database and Seeding:

   ```bash
   php artisan migrate --seed
   ```

7. Start the development server:

   ```bash
   php artisan serve
   ```

The Student Data Loader application should now be accessible at [http://localhost:8000](http://localhost:8000).

## Database Setup

You will need to configure your database connection in the `.env` file. Here's an example configuration:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=StudentDataLoader
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

Make sure you create the `StudentDataLoader` database in your MySQL server before running migrations.

## Email Configuration

For sending result emails to students, you need to configure your email settings in the `.env` file. Here's an example configuration using Mailtrap as the SMTP provider:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=youremail@gmail.com
MAIL_PASSWORD=yourpassword
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=youremail@gmail.com
MAIL_FROM_NAME=StudentDataLoader
```

## Features

- **Import Student Results:** Upload a file to import student data and their results into the database.
- **Export Data:** Export student data and results from the database.
- **Scheduling:** Add schedules for result emails to students.
Automated Emails: Automatically send result emails based on schedules.

## Usage

### Scheduling Result Emails

- Log in as an admin.
- Access the scheduling feature.
- Add schedules for result emails along with the necessary details.
- Run ```php artisan schedule:work``` to trigger the scheduled emails.

## API Documentation / Postman Collection

Access the Postman collection containing the API endpoints and examples:

[Postman Collection](https://documenter.getpostman.com/view/31777144/2s9Ykocg4J)


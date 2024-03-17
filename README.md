
# Take Home Test: staff_api

## Getting Started
These instructions will guide you through setting up and running the project on your local machine for development and testing purposes.

### Prerequisites
Before you begin, ensure you have the following installed:

- PHP >= 8.1
- Composer
- A supported database: MySQL

### Installation
Follow these steps to set up the project locally:

#### Clone the Repository
```sh
git clone https://github.com/waz083274082/staff_api.git
cd yourprojectname
```

#### Install PHP Dependencies
```sh
composer install
```

#### Set Up Environment Variables
Copy `.env.example` to `.env` and update it to fit your local setup, especially the database settings.

```sh
cp .env.example .env
```

#### Generate an Application Key
```sh
php artisan key:generate
```

#### Run Database Migrations
Ensure your database details in `.env` are correct, then migrate.

```sh
php artisan migrate
```

#### Start the Development Server
```sh
php artisan serve
```
The app will be available at http://localhost:8000.

## Accessing Swagger API Documentation
Generate and access the Swagger documentation as follows:

### Generate Documentation
Make sure `darkaonline/l5-swagger` is installed, then:

```sh
php artisan l5-swagger:generate
```

### View the Documentation
Visit http://localhost:8000/api/documentation in your browser to see the API documentation.

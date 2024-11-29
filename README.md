# Blog Post API

This project implements a Laravel-based blog post API with the following features:
- Author, Post, and Comment models with relationships.
- API endpoint `/api/posts` with pagination, filtering, and eager loading.
- Request validation using Laravel's `FormRequest`.
- Comprehensive tests written using PEST.
- API documentation generated using Swagger.

---

## Prerequisites

Ensure you have the following installed:
- PHP (>= 8.1)
- Composer
- Laravel CLI
- A database (e.g., MySQL, PostgreSQL, SQLite)

---

## Installation Guide

### Step 1: Clone the Repository
```bash
git clone https://github.com/Mohamadreza-mpy/challenge.git
cd challenge
```

### Step 2: Install Dependencies
```bash
composer install
```

### Step 3: Set Up Environment Variables
Copy the `.env.example` file to `.env` and configure the database connection:
```bash
cp .env.example .env
```
Edit the `.env` file and set the database credentials (e.g., DB_DATABASE, DB_USERNAME, DB_PASSWORD).

### Step 4: Generate Application Key
```bash
php artisan key:generate
```

### Step 5: Run Migrations
Run the migrations to create the database tables:
```bash
php artisan migrate
```

### Step 6: Seed the Database
Populate the database with sample data:
```bash
php artisan db:seed
```

---

## Running the Application

### Step 1: Start the Server
Start the Laravel development server:
```bash
php artisan serve
```
The application will be available at `http://127.0.0.1:8000`.

### Step 2: Access the API
You can access the `/api/posts` endpoint. For example:
```bash
http://127.0.0.1:8000/api/posts
```

Optional query parameters:
- `author_id` (integer): Filter posts by the author ID.
- `title` (string): Search posts by a title substring.
- `page` (integer): Specify the page number (default: 1).
- `per_page` (integer): Number of items per page (default: 15).

---

## Testing

Run the tests using the following command:
```bash
php artisan test
```
This includes tests for pagination, filtering, and validation.

---

## API Documentation

The API documentation is available at:
```bash
http://127.0.0.1:8000/api/documentation
```
This documentation is generated using Swagger and provides detailed information about the API endpoints.

---

## Additional Notes

- For production, make sure to set the `APP_ENV` to `production` in the `.env` file and configure database credentials accordingly.
- To regenerate API documentation:
  ```bash
  php artisan l5-swagger:generate
  ```

---

Enjoy using the Blog Post API!

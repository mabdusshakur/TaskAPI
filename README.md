# Task Management API

A simple RESTful API built with Laravel for managing tasks with user authentication. This API provides endpoints for auth and task operations.

## Features

### User Authentication
- User registration, login, logout, and profile

### Task Management
- CRUD operations for tasks

## Installation

1. Clone the repository
```bash
git clone https://github.com/mabdusshakur/TaskAPI.git
```

2. Install dependencies
```bash
composer install
```

3. Copy environment file and configure your database
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Run migrations
```bash
php artisan migrate
```

6. Start the server
```bash
php artisan serve
```

## Technologies Used

- Laravel 12
- Laravel Sanctum for authentication
- PHP 8.2+

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

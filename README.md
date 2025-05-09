<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# TaskTracker

TaskTracker is a Laravel-based application designed to help users organize their work and simplify their lives. It provides an intuitive interface for managing tasks and projects, making productivity effortless.

## Features

- User authentication (Login, Registration)
- Task and project management
- Responsive design
- Export functionality using [Maatwebsite Excel](https://docs.laravel-excel.com/)
- PDF generation using [Barryvdh Laravel DomPDF](https://github.com/barryvdh/laravel-dompdf)
- Built with Laravel 12.x and PHP 8.2
- Styled with Tailwind CSS

## Installation

Follow these steps to set up the project locally:

1. Clone the repository:
   ```sh
   git clone <repository-url>
   cd task-tracker

2. Install dependencies:
    composer install
    npm install

3. Copy the .env.example file to .env and configure your environment variables:
    cp .env.example .env

4. Generate the key:
    php artisan key:generate

5. Run database migrations:
    php artisan serve

6. Start the development server:
    php artisan serve

7. Compile frontend assets:
    npm run dev


## Usage
    Visit http://localhost:8000 in your browser to access the application.
    Use the "Login" or "Sign Up" buttons to create an account or log in.
    Start managing your tasks and projects.
## Testing
    Run the test suite using PHPUnit:
        php artisan test


## Contributing
    Thank you for considering contributing to TaskTracker! Please follow these steps:

        Fork the repository.
        Create a new branch for your feature or bugfix.
        Commit your changes and push them to your fork.
        Submit a pull request.
## License
    This project is open-sourced software licensed under the MIT license.


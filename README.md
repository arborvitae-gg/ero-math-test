# Quiz Web App Project

A web-based quiz platform built with Laravel 12, using Supabase for storage and Pest for testing. This app allows users to take quizzes, and admins to manage users and quizzes. It features image upload for questions/choices, user authentication, and a clean Blade-based UI.

---

## Table of Contents

-   [Project Overview](#project-overview)
-   [Features](#features)
-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Usage](#usage)
-   [Project Structure](#project-structure)
-   [Controllers & Services](#controllers--services)
-   [Routes Summary](#routes-summary)
-   [Testing](#testing)
-   [Contributing](#contributing)
-   [License](#license)

---

## Project Overview

This is a Laravel-based quiz web app that supports user authentication, quiz participation, and admin quiz/user management. Supabase is used for database and image storage. The app is designed for easy deployment and extensibility.

## Features

-   User authentication with email verification
-   Admin dashboard for managing users and quizzes
-   Quiz participation with timer and progress tracking
-   Image upload for questions and choices (via Supabase)
-   Role-based access (admin/user)
-   Just Blade UI and Normal CSS for the frontend

## Installation

### Prerequisites

-   Laragon 0.6.0 (or XAMPP/other server tools)
-   PHP 8.4.5
-   Apache 2.4.63
-   Node.js (for frontend assets)
-   Supabase account (for database and storage)

### PHP Extensions

Enable these in your PHP config:

-   pgsql
-   pdo_pgsql

### Setup Steps

1. Clone the repository.
2. Install PHP dependencies:
    ```sh
    composer install
    ```
3. Install Node dependencies:
    ```sh
    npm install
    ```
4. Build frontend assets:
    ```sh
    npm run dev
    ```
5. Generate Laravel app key:
    ```sh
    php artisan key:generate
    ```
6. Configure your `.env` file with Supabase credentials (see below).

## Configuration

-   Copy `.env.example` to `.env` and update database and Supabase storage credentials.
-   In Laragon, you may disable the built-in database if using Supabase (Settings > Services & Ports).
-   **Note:** You can use a different database provider instead of Supabase. However, image upload and deletion features are tightly coupled to Supabase Storage via the `SupabaseService` (see `app/Services/Admin/SupabaseService.php`). If you switch databases, you must update or replace this service to handle image storage accordingly.

## Usage

-   Start your local server (via Laragon, XAMPP, or `php artisan serve`).
-   Access the app in your browser at `http://localhost`.
-   Register a user or log in as admin(use seeder) to access management features.

## Project Structure

-   `app/Http/Controllers/` — Main controllers for user/admin actions
-   `app/Http/Requests/` — Form request validation logic
-   `app/Services/` — Business logic and integrations (e.g., Supabase)
-   `app/Models/` — Eloquent models for Users, Quizzes, Questions, etc.
-   `resources/views/` — Blade templates for UI
-   `routes/` — Route definitions (`web.php`, `admin.php`, `user.php`, etc.)
-   `database/migrations/` — Database schema definitions
-   `database/seeders/` — Initial/test data population
-   `database/factories/` — Model factories for generating fake/test data

## Controllers & Services

-   **UserController**: Handles user registration, login, profile, and quiz participation.
-   **Admin/QuizController**: Admin CRUD for quizzes and questions.
-   **Admin/UserController**: Admin management of users.
-   **Services/ProfileService**: Handles user profile updates and logic.
-   **Services/Admin/**: Business logic for admin features.
-   **Services/User/**: Business logic for user quiz participation.

## Routes Summary

-   `/` — Welcome page
-   `/dashboard` — User dashboard
-   `/login`, `/register` — Auth routes
-   `/profile` — Edit user profile
-   `/quizzes` — List quizzes (user)
-   `/quizzes/{quiz}/take` — Take a quiz
-   `/admin/users` — Admin user management
-   `/admin/quizzes` — Admin quiz management

(See `routes/web.php`, `routes/admin.php`, and `routes/user.php` for more details.)

## Testing

-   Unit and Feature tests

## Contributing

Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change.

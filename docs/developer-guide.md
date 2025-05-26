# Developer Guide

## Table of Contents

-   [Architecture](#architecture)
-   [Directory Structure](#directory-structure)
-   [Main Logic](#main-logic)
-   [API Endpoints](#api-endpoints)
-   [Controllers, Middleware, Requests, Models, Services](#components)
-   [Error Handling and Logging Practices](#error-handling-and-logging-practices)

## Architecture

This Laravel-based application uses a layered architecture:

-   **Controllers** handle HTTP requests and responses.
-   **Middleware** enforces authentication, verification, and role-based access.
-   **Requests** validate and sanitize input.
-   **Models** represent database tables and relationships.
-   **Services** encapsulate business logic (e.g., quiz flow, scoring).
-   **Views** (Blade templates) render the UI for users and admins.

## Directory Structure

```
app/
  Http/
    Controllers/   # Route handlers (Admin, Auth, User)
    Middleware/    # Custom middleware (e.g., RoleMiddleware)
    Requests/      # Form request validation (Admin, Auth, User)
  Models/          # Eloquent models (Quiz, Question, User, etc.)
  Services/        # Business logic (Admin, User)
  View/Components/ # Blade components
routes/
  web.php          # Main entry, dashboard, profile
  auth.php         # Registration, login, password reset
  admin.php        # Admin dashboard, user/quiz management
  user.php         # User dashboard, quiz participation
```

## Main Logic

-   **User Registration:** Validates input, creates user, assigns role, logs in.
-   **Quiz Management (Admin):** CRUD for quizzes/questions/choices, posting/locking quizzes, category filtering.
-   **Quiz Participation (User):**
    -   Users see quizzes for their grade/category.
    -   Quiz questions and choices are randomized per user.
    -   Answers are saved per question; skipped questions are handled.
    -   Submission triggers scoring and status update.
-   **Result Management:**
    -   Admins review all attempts, toggle result visibility.
    -   Users see results only when allowed by admin.

## API Endpoints

### Auth

-   `GET /register` / `POST /register` — User/Admin registration
-   `GET /login` / `POST /login` — Login
-   `POST /logout` — Logout

### User

-   `GET /user/dashboard` — User dashboard (available quizzes)
-   `POST /user/quizzes/{quiz}/start` — Start quiz
-   `GET /user/quizzes/{quiz}/attempts/{quizUser}` — Take quiz (question-by-question)
-   `POST /user/quizzes/{quiz}/attempts/{quizUser}/questions/{question}/save` — Save answer
-   `POST /user/quizzes/{quiz}/attempts/{quizUser}/submit` — Submit quiz
-   `GET /user/quizzes/{quiz}/attempts/{quizUser}/completed` — Completion page
-   `GET /user/quizzes/{quiz}/attempts/{quizUser}/results` — View results

### Admin

-   `GET /admin/dashboard` — Admin dashboard
-   `GET /admin/users` — Manage users
-   `GET /admin/quizzes` — List quizzes
-   `POST /admin/quizzes` — Create quiz
-   `GET /admin/quizzes/{quiz}` — Show quiz
-   `PATCH /admin/quizzes/{quiz}` — Update quiz
-   `DELETE /admin/quizzes/{quiz}` — Delete quiz
-   `POST /admin/quizzes/{quiz}/post` — Post/lock quiz
-   `GET /admin/quizzes/{quiz}/questions` — Manage questions
-   `POST /admin/quizzes/{quiz}/questions` — Add question
-   `PATCH /admin/quizzes/{quiz}/questions/{question}` — Update question
-   `DELETE /admin/quizzes/{quiz}/questions/{question}` — Delete question
-   `GET /admin/quizzes/{quiz}/results` — Quiz results
-   `GET /admin/quizzes/{quiz}/results/{quizUser}` — User's quiz results
-   `POST /admin/quizzes/{quiz}/results/{quizUser}/toggle-visibility` — Toggle result visibility

## Components

-   **Controllers:** Route handlers for each domain (Admin, Auth, User)
-   **Middleware:** E.g., `role:admin`, `role:user`, `auth`, `verified`
-   **Requests:** E.g., `QuizRequest`, `QuestionRequest`, `SaveAnswerRequest`
-   **Models:** Eloquent models for all main tables
-   **Services:**
    -   `Admin/QuizService`, `Admin/QuestionService`: CRUD and business logic for admins
    -   `User/QuizService`: Quiz flow, answer saving, scoring for users

## Error Handling and Logging Practices

### Controllers

-   All controllers performing database or sensitive operations must use try/catch blocks.
-   On exception, log the error using `\Log::error()` with relevant context (user ID, email, etc.).
-   Return user-friendly error messages using `withErrors()` or similar methods.
-   Example:

```php
try {
    // service/database call
} catch (\Throwable $e) {
    \Log::error('Context message', [...]);
    return back()->withErrors(['key' => 'User-friendly message.']);
}
```

### Services

-   Service methods should catch exceptions, log details, and rethrow for controller handling.
-   Always log the exception message and stack trace.

### Logging

-   All logs are written to `storage/logs/laravel.log` by default.
-   Include user context and error trace for easier debugging.

### Database Transactions

-   Use DB transactions for multi-step operations to ensure data integrity.

### Testing

-   All error paths should be covered by feature and unit tests.
-   Tests should assert that user-friendly errors are shown and logs are written (where possible).

### Authorization & Validation

-   Always validate and authorize requests before performing actions.

---

_Last updated: May 24, 2025_

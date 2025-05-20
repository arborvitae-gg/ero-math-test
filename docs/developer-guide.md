# Developer Guide

## Table of Contents

-   [Architecture](#architecture)
-   [Directory Structure](#directory-structure)
-   [Main Logic](#main-logic)
-   [API Endpoints](#api-endpoints)
-   [Controllers, Middleware, Requests, Models, Services](#components)

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

---

For more details, see the code in each referenced folder. Add or update this guide as the application evolves.

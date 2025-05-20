# Project Overview

## Purpose

This web application is designed for online math quiz competitions. It supports user registration, quiz participation, and an admin panel for managing quizzes, users, and results.

## Main Features

-   User registration and authentication (with roles: admin, user)
-   Quiz creation, editing, posting, and deletion (admin only)
-   Question and choice management, including images
-   Quiz participation for users, with randomized question and choice order
-   Scoring and result visibility (admins can control when users see scores)
-   Category-based quizzes (mapped to user grade levels)
-   Admin dashboard for user and quiz management
-   User dashboard for available quizzes and results

## Process Flow

1. **Registration & Login**
    - Users and admins register via the registration form.
    - Users provide grade level, school, and coach name; admins do not.
    - After registration, users are authenticated and redirected to their dashboard.
2. **Quiz Lifecycle**
    - Admins create quizzes, add questions (with images and choices), and post quizzes when ready.
    - Once posted, quizzes are locked for editing/deletion.
    - Users see available quizzes based on their grade/category.
    - Users start a quiz, answer questions in random order, and submit when done.
    - Each answer is saved per question; skipped questions are recorded.
3. **Scoring & Results**
    - Scores are calculated automatically upon submission.
    - Admins can review all attempts and control when users can view their scores.
    - Users can view results and see which answers were correct/incorrect.

## Database Schema

_Embed your Supabase schema diagram here._

### Main Tables

-   **users**: id, name, email, password, role, grade_level, school, coach_name
-   **quizzes**: id, title, slug, is_posted, timer
-   **categories**: id, name, min_grade, max_grade
-   **questions**: id, quiz_id, category_id, question_text, question_image
-   **question_choices**: id, question_id, choice_text, choice_image, is_correct
-   **quiz_users**: id, quiz_id, user_id, category_id, status, total_score, started_at, completed_at, can_view_score, question_order, choice_orders, uuid
-   **quiz_attempts**: id, quiz_user_id, question_id, question_choice_id, is_correct, answered_at

## Application Structure

-   **Controllers**: Handle HTTP requests and responses (see `app/Http/Controllers/`)
-   **Middleware**: Request filtering and processing (e.g., role-based access)
-   **Requests**: Form validation and request data handling (see `app/Http/Requests/`)
-   **Models**: Database entities (see `app/Models/`)
-   **Services**: Business logic (see `app/Services/`)

## Key Process Diagrams

-   _Add flowcharts or sequence diagrams here if available._

---

See `developer-guide.md` for technical details, `admin-guide.md` for admin instructions, and `user-guide.md` for user instructions.

# Project Overview

## Purpose

This web application is designed for online math quiz competitions. It supports user registration with email verification, quiz participation, and an admin panel for managing quizzes, users, and quiz results.

## Main Features

### For Admins

-   Monitor registered users (user deletion also available)
-   Quiz creation, editing, posting, and deletion
-   Question and choice management
-   Users' quiz attempts viewing

### For Users

-   User authentication with email verification
-   Category-based quizzes (mapped to user grade levels)
-   Quiz participation (with randomized question and choice order)
-   Quiz results details viewing after completing a quiz

## Process Flow

1. **Registration & Login**

    - Users register their details via the registration form.
    - Users verify their accocunt by clicking the link sent to their registered email.
    - After account verification, users are authenticated and redirected to their dashboard.

2. **Quiz Lifecycle**

    - Admins create quizzes, add questions (with images and choices), and post quizzes when ready.
    - Once posted, quizzes are locked for editing.
    - Users see available quizzes based on their grade/category.
    - Users start a quiz, answer questions in random order, and submit when done(or when timer runs out).
    - Each answer is saved per question; skipped questions are recorded.

3. **Scoring & Results**

    - Scores are calculated automatically upon submission.
    - Admins can review all users' quiz attempts and see which answers were correct/incorrect.
    - Users can view results and see which answers were correct/incorrect.

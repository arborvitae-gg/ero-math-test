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

### For Admins

1. **Authentication**

    - Admin accounts are seeded directly to the database.
    - Admins verify their account via email.
    - After verification, admins log in and access the admin dashboard.
    - Edit account details of default admin account such as name, email, and password.

2. **Quiz Lifecycle**

    - Create quizzes, add/edit/delete questions, and post quizzes when ready.
    - Once posted, quizzes are locked for editing.

3. **User Management**

    - Monitor registered users and delete users if needed.

4. **Results Review**

    - View all users' quiz attempts and see which answers were correct/incorrect.

### For Users

1. **Authentication**

    - Users register their details via the registration form.
    - Users verify their account by clicking the link sent to their registered email.
    - After account verification, users are authenticated and redirected to their dashboard.

2. **Quiz Participation**

    - Users see available quizzes based on their grade/category.
    - Users start a quiz, answer questions in random order, and submit when done (or when timer runs out).

3. **Scoring & Results**

    - Scores are calculated automatically upon submission.
    - Users can view results and see which answers were correct/incorrect.

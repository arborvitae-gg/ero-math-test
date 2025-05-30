# Admin Guide

## Overview

This guide explains how admins can manage users, quizzes, questions, and results in the Ero-Math web app.

## Accessing the Admin Panel

-   Log in with an admin account. (Admin accounts are to be seeded directly to the databas, not like conventional user registration using the web app frontend)
-   Use the navigation bar to access **Users** and **Quizzes** sections.

## Managing Users

-   Go to **Users** to view all registered users in a sortable table.
-   Columns include: First Name, Last Name, Email, Grade, Category, School, Coach.
-   Click a column header to sort by that column.
-   To delete a user, click the **Delete** button in the user’s row.  
    **Warning:** Deleting a user also deletes all their quiz records and scores.

## Managing Quizzes

-   Go to **Quizzes** to see all quizzes.
-   Toggle between **Unposted** and **Posted** quizzes using the buttons at the top.
-   **Add Quiz:**
    -   Click "+ Add Quiz" (only for unposted quizzes).
    -   Fill in the quiz title and set the timer (hours, minutes, seconds).
    -   Click **Save** to create the quiz.
-   **Edit Quiz:**
    -   Click **Edit** next to a quiz (only for unposted quizzes).
    -   Update the title or timer, then click **Update**.
-   **Delete Quiz:**
    -   Click **Delete** next to a quiz (only for unposted quizzes).
    -   **Warning:** Deleting a posted quiz also deletes all related user data.
-   **Post Quiz:**
    -   Click **Post Quiz** to lock the quiz for participation.
    -   Once posted, the quiz cannot be edited or deleted, and no more questions can be added.

## Managing Questions

-   Click **Manage Questions** for a quiz to add, edit, or delete questions.
-   If the quiz is posted, you can only review questions; editing is disabled.
-   **Add Question:**
    -   Click "+ Add Question".
    -   Enter the question text, optionally upload an image.
    -   Enter the correct answer and up to three other choices (each can have text and an image).
    -   Assign the question to a category.
    -   Click **Save**.
-   **Edit/Delete Question:**
    -   Click **Edit** to update a question (only for unposted quizzes).
    -   Click **Delete** to remove a question (only for unposted quizzes).
-   **Category Filter:**
    -   Use the radio buttons to filter questions by category.
    -   Questions are grouped and displayed by category.

## Viewing Results

-   Click **View User Results** for a quiz to see all user attempts and scores.
-   The results table shows: User Name, Category, Score, Total Questions, and a link to view detailed results.
-   Click **View Results** in a user’s row to see their answers, which are marked as correct, incorrect, or skipped.
-   You can navigate back to the quiz list from the results page.

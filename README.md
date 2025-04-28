# Instructions

## For Laragon

### Make sure to have the correct versions of the following:

-   PHP 8.4.5
-   Apache 2.4.63
-   Database may be disabled in Laragon preferences since Supabase would be used instead (Settings/Services & Ports)

### Install the following PHP extensions: (Menu/PHP/Extensions)

-   pgsql
-   pdo_pgsql

## For Database

Create a Supabase Account, then send your Supabase email to get an invitation to the Supabase project

## For Laravel App

-   Make sure to have a '.env' file (Copy '.env.example' and rename it to '.env')
-   In '.env', change database details to the ones in Supabase (needs to be invited to Supabase Project First)
-   Generate an APK Key using the command: php artisan key:generate
-   use command: composer install (install dependencies from composer.json)
-   use command: npm install (install node modules)
-   use command: npm run dev (activates Alpinejs toggleable button modals) (refresh webpage afterwards)

## Authentication

Login using the following information:

# User Role

User can access the userQuiz(where users take the quiz) page (not yet functional)

-   Email: admin@example.com
-   Password: password

# Admin Role

Admin can access the user and adminQuiz(list of quizzes) pages

-   Email: user@example.com
-   Password: password

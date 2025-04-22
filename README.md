# Instructions

## For Laragon

### Make sure to have the correct versions of the following:
- PHP 8.4.5
- Apache 2.4.63
- Database may be disabled in Laragon preferences (Settings/Services & Ports)

### Install the following PHP extensions: (Menu/PHP/Extensions)
- pgsql
- pdo_pgsql

## For Database

Create a Supabase Account, then send your Supabase email to get an invitation to the Supabase project

## For Laravel App

- Make sure to have a '.env' file (Copy '.env.example' and rename it to '.env')
- In '.env', change database details to the ones in Supabase (needs to be invited to Supabase Project First)
- Generate an APK Key using the command: php artisan key:generate

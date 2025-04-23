<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Classless CSS script, remove if you want to start styling --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/digitallytailored/classless@latest/classless.min.css">
</head>

<body>
    <div>
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header>
                <div>
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="shortcut icon" href="{{ asset('images/Erovoutika_E_logo.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ config('app.name', 'Laravel') }}
    </title>

    {{-- Styles / Scripts --}}
    @vite([
        'resources/css/app.css',
        'resources/css/navigation.css',
        'resources/css/quiz.css',
        'resources/css/auth.css',
        'resources/css/profile.css'
    ])
    @yield('styles')
    @vite(['resources/js/app.js'])

    {{-- Classless CSS script, remove or comment out if you want to start styling --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/digitallytailored/classless@latest/classless.min.css"> --}}
</head>

<body>
    <div>
        @include('layouts.navigation')

        {{-- Page Heading --}}
        <header class="page-header">
            <div class="header-content">
                @yield('header')
            </div>
        </header>

        {{-- Page Content --}}
        <main class="page-content">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>

</html>

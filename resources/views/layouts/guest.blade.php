<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/Erovoutika_E_logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <title>
        {{ config('app.name', 'Laravel') }}
    </title>

    {{-- Styles / Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Classless CSS script, remove or comment out if you want to start styling --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/digitallytailored/classless@latest/classless.min.css"> --}}
</head>

<body>
    <nav class="main-navbar">
        <div class="navbar-content">
            <a href="{{ url('/') }}" class="navbar-logo">
                <img src="{{ asset('images/Erovoutika Light Logo.png') }}" alt="Ero-Math Logo">
            </a>
            @if (Route::has('login'))
                <div class="navbar-links">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="nav-link">
                            <i class="fa-solid fa-gauge-high"></i>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-link primary">
                                <i class="fa-solid fa-user-plus"></i>
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </nav>

    <div class="page-content">
        {{ $slot }}
    </div>
</body>

</html>

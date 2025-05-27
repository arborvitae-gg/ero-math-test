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
</head>

<body>
    <style>
        .main-navbar {
            background: rgba(0, 0, 139, 0.92);
            padding: 0.75rem 0;
            box-shadow: 0 4px 24px rgba(0, 0, 139, 0.15);
            position: relative;
            z-index: 10;
        }

        .navbar-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .navbar-logo img {
            height: 40px;
            width: auto;
            display: block;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-link {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }

        .nav-link.primary {
            background: white;
            color: #000080;
        }

        .nav-link.primary:hover {
            background: #f8fafc;
            transform: translateY(-1px);
        }

        .page-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        @media (max-width: 768px) {
            .navbar-content {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
                padding: 1rem;
            }

            .navbar-links {
                flex-direction: column;
                width: 100%;
                gap: 0.75rem;
            }

            .nav-link {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

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

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/Erovoutika_E_logo.png') }}" type="image/png">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Styles --}}
    <style>
        /* Immediate styles to prevent FOUC */
        body {
            margin: 0;
            padding: 0;
            background: rgb(230, 230, 255);
        }
    </style>
    @vite(['resources/css/app.css', 'resources/css/auth.css'])
</head>

<body class="auth-body">
    @yield('content')
</body>

</html>

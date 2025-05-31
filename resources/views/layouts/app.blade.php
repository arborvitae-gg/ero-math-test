<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Styles / Scripts --}}
    @vite([
        'resources/css/app.css',
        'resources/css/dashboard.css',
        'resources/js/app.js',
    ])

    <style>
        body {
            padding-top: 80px;
            /* Add padding to prevent navbar overlap */
        }
    </style>
</head>

<body>
    <div>
        <x-navbar />

        {{-- Page Heading --}}
        @isset($header)
            <header>
                <div>
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Page Content --}}
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('scripts')
</body>

</html>

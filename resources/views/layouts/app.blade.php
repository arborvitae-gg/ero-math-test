<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('images/Erovoutika_E_logo.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ config('app.name', 'Laravel') }}
    </title>

    {{-- Styles / Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div>
        @include('layouts.navigation')

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
</body>

</html>

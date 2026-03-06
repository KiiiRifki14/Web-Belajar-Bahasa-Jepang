<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nihongo Odyssey') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700,800,900i|outfit:300,400,500,600,700,800,900" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased {{ Auth::check() && Auth::user()->active_theme ? 'theme-' . Auth::user()->active_theme : '' }}">

    <div class="min-h-screen" style="transition: background 0.6s ease, color 0.4s ease;">

        @include('layouts.navigation')

        <!-- Page Heading (admin / standard pages only) -->
        @isset($header)
        <header class="relative z-10" style="background: rgba(255,255,255,0.55); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.6);">
            <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
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
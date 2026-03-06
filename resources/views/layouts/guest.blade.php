<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nihongo Odyssey') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,600,700,900|outfit:300,400,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans text-gray-800 flex items-center justify-center p-6 min-h-screen">
    <div class="w-full sm:max-w-md flex flex-col items-center z-10">
        <!-- Aesthetic Logo Area -->
        <div class="mb-10 text-center animate-float-slow">
            <a href="/" class="inline-block relative">
                <div class="w-24 h-24 mx-auto bg-white/40 backdrop-blur-md rounded-3xl flex items-center justify-center text-5xl shadow-glass border border-white/60 hover:scale-105 hover:rotate-3 transition-transform duration-300">
                    💮
                </div>
            </a>
            <h2 class="mt-4 font-serif text-3xl font-bold italic tracking-tight text-sakura-950 drop-shadow-sm">Nihongo Odyssey</h2>
        </div>

        <!-- Main Auth Card -->
        <div class="w-full glass-panel px-8 py-10 rounded-[2.5rem] md:rounded-[3rem] overflow-hidden manhua-glow">
            {{ $slot }}
        </div>

        <!-- Footer Small Note -->
        <div class="mt-8 text-[10px] font-black uppercase tracking-[0.3em] text-stone-400 opacity-60">
            &copy; {{ date('Y') }} Nihongo Odyssey &bull; Jembatan Impian
        </div>
    </div>
</body>

</html>
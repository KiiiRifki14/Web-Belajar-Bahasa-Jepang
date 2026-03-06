<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nihongo Odyssey') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:700|outfit:300,400,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: linear-gradient(135deg, #ffd1dc 0%, #fff9fb 50%, #e0b0ff 100%);
            min-height: 100vh;
            font-family: 'Outfit', sans-serif;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
        }

        .poetic-font {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>

<body class="antialiased text-stone-800 flex items-center justify-center p-6">
    <div class="w-full sm:max-w-md flex flex-col items-center">
        <!-- Aesthetic Logo Area -->
        <div class="mb-10 text-center animate-bounce duration-[3000ms]">
            <a href="/">
                <div class="w-24 h-24 bg-white/60 backdrop-blur-md rounded-[2.5rem] flex items-center justify-center text-5xl shadow-lg border border-white/40">
                    💮
                </div>
            </a>
            <h2 class="mt-4 poetic-font text-2xl font-black italic tracking-tight text-stone-700">Nihongo Odyssey</h2>
        </div>

        <!-- Main Auth Card -->
        <div class="w-full glass-panel px-8 py-10 rounded-[3rem] overflow-hidden">
            {{ $slot }}
        </div>

        <!-- Footer Small Note -->
        <div class="mt-8 text-[10px] font-black uppercase tracking-[0.3em] text-stone-400 opacity-60">
            &copy; {{ date('Y') }} Nihongo Odyssey &bull; Jembatan Impian
        </div>
    </div>
</body>

</html>
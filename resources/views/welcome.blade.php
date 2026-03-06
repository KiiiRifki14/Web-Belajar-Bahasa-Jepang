<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nihongo Odyssey - Jembatan Impianmu</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:700,900|outfit:300,400,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --sakura-pink: #ffd1dc;
            --dream-purple: #e0b0ff;
            --text-main: #2d3436;
        }

        .manhua-font {
            font-family: 'Outfit', sans-serif;
        }

        .poetic-font {
            font-family: 'Playfair Display', serif;
        }

        .bg-dream-overlay {
            background: linear-gradient(135deg, rgba(255, 209, 220, 0.4) 0%, rgba(224, 176, 255, 0.3) 100%);
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(2deg);
            }

            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }

        .floating-petals {
            position: absolute;
            pointer-events: none;
            animation: float 6s ease-in-out infinite;
            z-index: 5;
        }

        .cta-glow {
            box-shadow: 0 0 20px rgba(255, 209, 220, 0.6);
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {
            0% {
                box-shadow: 0 0 10px rgba(255, 209, 220, 0.5);
            }

            50% {
                box-shadow: 0 0 30px rgba(255, 182, 193, 0.8);
            }

            100% {
                box-shadow: 0 0 10px rgba(255, 209, 220, 0.5);
            }
        }
    </style>
</head>

<body class="antialiased manhua-font selection:bg-pink-200">
    <!-- Fullscreen Background Placeholder -->
    <div class="fixed inset-0 z-0 bg-center bg-cover bg-no-repeat bg-stone-100"
        style="background-image: url('https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?q=80&w=2070&auto=format&fit=crop');">
        <div class="absolute inset-0 bg-dream-overlay backdrop-blur-[2px]"></div>
    </div>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 glass-nav px-8 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center text-xs font-black uppercase tracking-widest text-[#2d3436]">
            <div class="flex items-center gap-2">
                <span class="text-2xl">💮</span>
                <span>Nihongo Odyssey</span>
            </div>
            <div class="space-x-8">
                @if (Route::has('login'))
                @auth
                <a href="{{ url('/dashboard') }}" class="hover:text-pink-600 transition-colors">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="hover:text-pink-600 transition-colors">Masuk</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="px-6 py-2 bg-[var(--text-main)] text-white rounded-full hover:scale-105 transition-transform">Daftar</a>
                @endif
                @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Main Hero -->
    <main class="relative z-10 min-h-screen flex flex-col items-center justify-center p-6 text-center">
        <!-- Floating Decorative Elements -->
        <div class="floating-petals top-1/4 left-10 text-4xl opacity-30">🌸</div>
        <div class="floating-petals bottom-1/4 right-20 text-4xl opacity-30 animate-delay-1000">✨</div>

        <div class="max-w-4xl space-y-12 animate-fadeIn">
            <h1 class="poetic-font text-7xl md:text-9xl font-black text-[#2d3436] tracking-tighter drop-shadow-sm">
                Nihongo <br>
                <span class="text-white drop-shadow-[0_2px_10px_rgba(0,0,0,0.1)]">Odyssey</span>
            </h1>

            <p class="text-lg md:text-2xl text-stone-700 italic opacity-80 poetic-font max-w-2xl mx-auto leading-relaxed">
                "Jembatan impianmu menuju Tokyo dimulai dari sini. Setiap kanji adalah langkah, setiap kosa kata adalah cerita."
            </p>

            <div class="pt-10">
                <a href="{{ route('register') }}"
                    class="inline-block px-12 py-5 bg-[var(--text-main)] text-white rounded-full font-black text-xs uppercase tracking-[0.4em] cta-glow hover:-translate-y-2 hover:scale-105 transition-all active:scale-95">
                    Mulai Perjalanan
                </a>
            </div>
        </div>

        <!-- Bottom Footer Quote -->
        <div class="absolute bottom-12 w-full text-center px-6">
            <span class="text-[10px] font-black uppercase tracking-[0.5em] text-[#2d3436] opacity-40">
                Sebuah Petualangan Menanti &bull; 日本語オデッセイ
            </span>
        </div>
    </main>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 1.5s ease-out forwards;
        }
    </style>
</body>

</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nihongo Odyssey - Jembatan Impianmu</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,600,700,900|outfit:300,400,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans bg-transparent min-h-screen">
    <!-- Fullscreen Background with Radial Gradient & Image Overlay -->
    <div class="fixed inset-0 z-0">
        <!-- Base gradient via app.css body, this div layers the image slightly on top -->
        <div class="absolute inset-0 bg-center bg-cover bg-no-repeat opacity-40 mix-blend-overlay"
            style="background-image: url('https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?q=80&w=2070&auto=format&fit=crop');">
        </div>
        <!-- Dreamy overlay to ensure text readability and pastel vibe -->
        <div class="absolute inset-0 bg-gradient-to-br from-sakura-100/60 via-white/40 to-matcha-50/50 backdrop-blur-[2px]"></div>
    </div>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-white/10 backdrop-blur-md border-b border-white/20 px-8 py-4 transition-all duration-300">
        <div class="max-w-7xl mx-auto flex justify-between items-center text-xs font-black uppercase tracking-widest text-gray-800">
            <div class="flex items-center gap-3">
                <span class="text-2xl drop-shadow-sm">💮</span>
                <span class="tracking-[0.2em]">Nihongo Odyssey</span>
            </div>
            <div class="space-x-8 flex items-center">
                @if (Route::has('login'))
                @auth
                <a href="{{ url('/dashboard') }}" class="hover:text-sakura-600 transition-colors">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="hover:text-sakura-600 transition-colors">Masuk</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="px-6 py-2 bg-gray-900 text-white rounded-full hover:scale-105 transition-transform shadow-glass hover:shadow-glow hover:bg-sakura-950">Daftar</a>
                @endif
                @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Main Hero -->
    <main class="relative z-10 min-h-screen flex flex-col items-center justify-center p-6 text-center overflow-hidden">
        <!-- Floating Decorative Elements -->
        <div class="absolute animate-float-slow top-1/4 left-[10%] text-4xl opacity-40 blur-[1px]">🌸</div>
        <div class="absolute animate-float-slow top-1/3 right-[15%] text-2xl opacity-50 animation-delay-700">🦋</div>
        <div class="absolute animate-float-slow bottom-1/4 right-[20%] text-4xl opacity-30 animation-delay-1000 blur-[2px]">✨</div>
        <div class="absolute animate-float-slow bottom-1/3 left-[15%] text-2xl opacity-40 animation-delay-500">🍃</div>

        <div class="max-w-4xl space-y-10 animate-fadeIn relative z-20">
            <h1 class="font-serif text-7xl md:text-[8rem] leading-[1.1] font-bold text-gray-900 tracking-tight drop-shadow-md">
                Nihongo <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-sakura-500 to-matcha-500 drop-shadow-sm">Odyssey</span>
            </h1>

            <div class="glass-panel p-8 md:p-10 max-w-2xl mx-auto">
                <p class="text-lg md:text-2xl text-gray-700 italic opacity-90 font-serif leading-relaxed">
                    "Jembatan impianmu menuju Tokyo dimulai dari sini. Setiap kanji adalah langkah, setiap kosa kata adalah cerita."
                </p>
            </div>

            <div class="pt-8 relative z-30">
                <a href="{{ route('register') }}"
                    class="inline-block px-12 py-5 bg-gray-900 text-white rounded-[2rem] font-bold text-xs uppercase tracking-[0.4em] shadow-glow hover:-translate-y-2 hover:scale-105 hover:bg-sakura-900 transition-all duration-300 ease-out active:scale-95 border border-white/20 relative overflow-hidden group">
                    <span class="relative z-10">Mulai Perjalanan</span>
                    <div class="absolute inset-0 h-full w-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-shimmer blur-[4px]"></div>
                </a>
            </div>
        </div>

        <!-- Bottom Footer Quote -->
        <div class="absolute bottom-12 w-full text-center px-6">
            <span class="text-[10px] font-bold uppercase tracking-[0.5em] text-gray-600 opacity-60">
                Sebuah Petualangan Menanti &bull; 日本語オデッセイ
            </span>
        </div>
    </main>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 1.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }

        .animate-shimmer {
            animation: shimmer 1.5s infinite;
        }

        .animation-delay-500 { animation-delay: 500ms; }
        .animation-delay-700 { animation-delay: 700ms; }
        .animation-delay-1000 { animation-delay: 1000ms; }
    </style>
</body>

</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nihongo Odyssey — Jembatan Impianmu ke Tokyo</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700,800,900i|outfit:300,400,500,600,700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── Sakura Petal Generator ── */
        @keyframes petalFall {
            0% {
                transform: translateY(-80px) translateX(0) rotate(0deg) scale(1);
                opacity: 0;
            }

            8% {
                opacity: 0.85;
            }

            90% {
                opacity: 0.4;
            }

            100% {
                transform: translateY(110vh) translateX(calc(var(--sway) * 1px)) rotate(var(--rot)) scale(0.6);
                opacity: 0;
            }
        }

        @keyframes petalSway {

            0%,
            100% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(calc(var(--sway2) * 1px));
            }
        }

        .petal {
            position: fixed;
            pointer-events: none;
            z-index: 2;
            user-select: none;
            animation: petalFall var(--duration) var(--delay) ease-in-out infinite;
        }

        @keyframes heroReveal {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.94);
                filter: blur(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes subtitleReveal {
            from {
                opacity: 0;
                transform: translateY(20px);
                letter-spacing: 0.6em;
            }

            to {
                opacity: 1;
                transform: translateY(0);
                letter-spacing: 0.5em;
            }
        }

        @keyframes cardReveal {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes orbFloat {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(-30px, -20px) scale(1.05);
            }

            66% {
                transform: translate(20px, 15px) scale(0.97);
            }
        }

        @keyframes borderGlow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(242, 123, 181, 0.3), 0 0 40px rgba(242, 123, 181, 0.1);
            }

            50% {
                box-shadow: 0 0 35px rgba(242, 123, 181, 0.5), 0 0 70px rgba(242, 123, 181, 0.2);
            }
        }

        @keyframes shimmerText {
            0% {
                background-position: -200% center;
            }

            100% {
                background-position: 200% center;
            }
        }

        @keyframes logoFloat {

            0%,
            100% {
                transform: translateY(0) rotate(-2deg);
            }

            50% {
                transform: translateY(-12px) rotate(2deg);
            }
        }

        .hero-title {
            animation: heroReveal 1.4s cubic-bezier(0.2, 0.8, 0.2, 1) 0.2s both;
        }

        .hero-sub {
            animation: subtitleReveal 1s ease-out 0.9s both;
        }

        .hero-card {
            animation: cardReveal 1s ease-out 1.1s both;
        }

        .hero-btn {
            animation: cardReveal 1s ease-out 1.4s both;
        }

        .hero-features {
            animation: cardReveal 1s ease-out 1.6s both;
        }

        .bg-orb {
            animation: orbFloat 18s ease-in-out infinite;
        }

        .logo-float {
            animation: logoFloat 6s ease-in-out infinite;
        }

        .border-glow {
            animation: borderGlow 3s ease-in-out infinite;
        }

        .gradient-text {
            background: linear-gradient(120deg, #f27bb5, #e8609a, #79a582, #f27bb5);
            background-size: 300% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmerText 5s linear infinite;
        }
    </style>
</head>

<body class="antialiased font-sans overflow-x-hidden" style="background: radial-gradient(ellipse at 80% -10%, rgba(242,123,181,0.15) 0%, transparent 50%), radial-gradient(ellipse at -10% 100%, rgba(121,165,130,0.12) 0%, transparent 50%), radial-gradient(ellipse 120% 100% at 50% 50%, #fffbfe 0%, #f8f0f8 100%); min-height: 100vh;">

    <!-- ── Ambient Background Orbs ── -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="bg-orb absolute w-[600px] h-[600px] rounded-full opacity-[0.07]" style="background: radial-gradient(circle, #f27bb5, transparent); top: -10%; right: -5%;"></div>
        <div class="bg-orb absolute w-[500px] h-[500px] rounded-full opacity-[0.06]" style="background: radial-gradient(circle, #79a582, transparent); bottom: -5%; left: -8%; animation-delay: -6s;"></div>
        <div class="bg-orb absolute w-[300px] h-[300px] rounded-full opacity-[0.05]" style="background: radial-gradient(circle, #c4a0e8, transparent); top: 40%; left: 30%; animation-delay: -12s;"></div>
    </div>

    <!-- ── Sakura Petals ── -->
    <div id="petals-container" class="fixed inset-0 z-[1] overflow-hidden pointer-events-none" aria-hidden="true"></div>

    <!-- ── Navigation ── -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-500" id="navbar">
        <div class="mx-auto max-w-7xl px-6 py-4">
            <div class="flex justify-between items-center glass-panel px-6 py-3 rounded-[2rem] border-white/60" style="background: rgba(255,255,255,0.55);">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xl" style="background: linear-gradient(135deg, #fce7f1, #f0f7f1);">💮</div>
                    <span class="font-black text-xs uppercase tracking-[0.3em] text-slate-700">Nihongo Odyssey</span>
                </div>
                <div class="flex items-center gap-2 sm:gap-4">
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}" class="text-xs font-bold text-slate-600 hover:text-pink-600 transition-colors uppercase tracking-widest hidden sm:block">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="text-xs font-bold text-slate-600 hover:text-pink-600 transition-colors uppercase tracking-widest hidden sm:block">Masuk</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-5 py-2.5 text-white font-bold text-xs uppercase tracking-widest rounded-full transition-all duration-300 hover:-translate-y-1 hover:shadow-lg active:scale-95" style="background: linear-gradient(135deg, #f27bb5, #c4497e); box-shadow: 0 4px 15px rgba(242,123,181,0.4);">
                        Mulai Gratis
                    </a>
                    @endif
                    @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- ── HERO SECTION ── -->
    <main class="relative z-10 min-h-screen flex flex-col items-center justify-center px-6 pt-28 pb-20">

        <!-- Eyebrow label -->
        <div class="hero-sub mb-8 flex items-center gap-3 glass-panel px-5 py-2.5 rounded-full border-white/70 shadow-glass-sm">
            <span class="w-2 h-2 rounded-full bg-pink-400 animate-pulse"></span>
            <span class="text-caption text-pink-600 tracking-[0.4em]">Platform Belajar Bahasa Jepang No.1</span>
            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse delay-300"></span>
        </div>

        <!-- Main Title -->
        <h1 class="hero-title text-center leading-none mb-6" style="max-width: 900px;">
            <span class="block font-serif font-bold text-slate-800 drop-shadow-sm"
                style="font-size: clamp(3.5rem, 10vw, 8rem); line-height: 0.95; letter-spacing: -0.03em;">
                Nihongo
            </span>
            <span class="block gradient-text font-serif font-bold"
                style="font-size: clamp(3.5rem, 10vw, 8rem); line-height: 0.95; letter-spacing: -0.03em;">
                Odyssey
            </span>
        </h1>

        <!-- Glass Quote Card -->
        <div class="hero-card mt-8 max-w-2xl w-full glass-panel px-8 md:px-12 py-8 rounded-[2.5rem] border border-white/70 shadow-glass relative overflow-hidden" style="animation: cardReveal 1s ease-out 1.1s both, borderGlow 3s ease-in-out infinite 2.1s;">
            <div class="absolute -top-4 -left-4 text-7xl opacity-[0.06] font-serif select-none pointer-events-none">"</div>
            <div class="absolute -bottom-8 -right-4 text-9xl opacity-[0.06] font-serif select-none pointer-events-none">"</div>
            <p class="font-serif text-lg md:text-xl text-slate-700 italic text-center leading-relaxed relative z-10">
                "Jembatan impianmu menuju Tokyo dimulai dari sini.<br class="hidden md:block">
                Setiap kanji adalah langkah, setiap kosa kata adalah cerita."
            </p>
            <div class="flex justify-center mt-4">
                <span class="text-caption text-slate-400 tracking-[0.4em]">— Neko-Sensei</span>
            </div>
        </div>

        <!-- CTA Buttons -->
        <div class="hero-btn mt-10 flex flex-col sm:flex-row items-center gap-4">
            @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="group relative px-10 py-5 text-white font-black text-xs uppercase tracking-[0.4em] rounded-full overflow-hidden transition-all duration-300 hover:-translate-y-2 active:scale-95"
                style="background: linear-gradient(135deg, #f27bb5 0%, #e0549a 50%, #c4497e 100%); box-shadow: 0 8px 30px rgba(242,123,181,0.5), 0 2px 6px rgba(242,123,181,0.3);">
                <span class="relative z-10 flex items-center gap-3">
                    Mulai Petualangan
                    <svg class="w-4 h-4 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
            </a>
            @endif
            @if(Route::has('login'))
            <a href="{{ route('login') }}" class="group px-10 py-5 font-bold text-xs uppercase tracking-[0.35em] rounded-full transition-all duration-300 hover:-translate-y-1 active:scale-95 glass-panel border-white/70 hover:border-pink-200 text-slate-600 hover:text-pink-600 shadow-glass-sm hover:shadow-glow">
                Sudah Punya Akun
            </a>
            @endif
        </div>

        <!-- Social Proof -->
        <div class="hero-sub mt-10 flex items-center gap-2 text-caption text-slate-400">
            <div class="flex -space-x-2">
                @foreach(['🌸','🎐','💮','🌿','✨'] as $emoji)
                <div class="w-8 h-8 rounded-full glass-panel border border-white/80 flex items-center justify-center text-xs shadow-sm">{{ $emoji }}</div>
                @endforeach
            </div>
            <span class="ml-2">Ribuan pelajar sudah memulai odyssey mereka</span>
        </div>

        <!-- Feature Cards Row -->
        <div class="hero-features mt-20 w-full max-w-5xl grid grid-cols-1 sm:grid-cols-3 gap-5">
            @php
            $features = [
            ['icon' => '🗺️', 'title' => 'Quest Map', 'desc' => 'Jelajahi peta belajar interaktif layaknya game RPG Jepang', 'color' => 'from-pink-50 to-rose-50', 'border' => 'border-pink-100'],
            ['icon' => '🐱', 'title' => 'Neko-Sensei', 'desc' => 'Gurumu yang lucu akan membimbing setiap langkah perjalanan', 'color' => 'from-green-50 to-emerald-50', 'border' => 'border-green-100'],
            ['icon' => '⛩️', 'title' => 'O-mikuji & Gacha', 'desc' => 'Koleksi item langka, skin, dan ramalan keberuntunganmu', 'color' => 'from-violet-50 to-purple-50', 'border' => 'border-violet-100'],
            ];
            @endphp
            @foreach($features as $i => $f)
            <div class="group manhua-card p-6 bg-gradient-to-br {{ $f['color'] }} border {{ $f['border'] }}" {!! 'style="animation-delay: ' . ($i * 150) . 'ms;"' !!}>
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-3xl mb-4 glass-panel border-white/80 shadow-glass-sm group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300">{{ $f['icon'] }}</div>
                <h3 class="font-serif text-lg font-bold text-slate-800 mb-2">{{ $f['title'] }}</h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>

        <!-- Bottom decoration -->
        <div class="mt-24 flex flex-col items-center gap-3 opacity-40">
            <div class="w-px h-16 bg-gradient-to-b from-transparent via-pink-400 to-transparent"></div>
            <p class="text-caption text-slate-500 tracking-[0.5em]">日本語オデッセイ · Sebuah Petualangan Menanti</p>
        </div>
    </main>

    <!-- ── Floating Logo Decoration (right side, desktop) ── -->
    <div class="fixed right-8 top-1/2 -translate-y-1/2 z-[3] hidden xl:flex flex-col items-center gap-6 opacity-30 pointer-events-none" aria-hidden="true">
        <div class="logo-float text-5xl">🌸</div>
        <div class="w-px h-20 bg-gradient-to-b from-transparent via-pink-300 to-transparent"></div>
        <div class="logo-float text-3xl" style="animation-delay: -3s;">🍃</div>
        <div class="w-px h-20 bg-gradient-to-b from-transparent via-green-300 to-transparent"></div>
        <div class="logo-float text-4xl" style="animation-delay: -1.5s;">✨</div>
    </div>

    <script>
        // ── Generate Sakura Petals ──
        const container = document.getElementById('petals-container');
        const petalShapes = ['🌸', '🌺', '🌷'];
        const count = window.innerWidth < 768 ? 10 : 18;

        for (let i = 0; i < count; i++) {
            const petal = document.createElement('div');
            const left = Math.random() * 100;
            const duration = 8 + Math.random() * 12;
            const delay = Math.random() * 15;
            const size = 10 + Math.random() * 16;
            const sway = (Math.random() - 0.5) * 160;
            const rot = (Math.random() - 0.5) * 720;

            petal.className = 'petal';
            petal.innerText = petalShapes[Math.floor(Math.random() * petalShapes.length)];
            petal.style.cssText = `
                left: ${left}%;
                font-size: ${size}px;
                --duration: ${duration}s;
                --delay: ${delay}s;
                --sway: ${sway};
                --rot: ${rot}deg;
                opacity: 0;
                animation-delay: ${delay}s;
            `;
            container.appendChild(petal);
        }
    </script>
</body>

</html>
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

    <style>
        @keyframes floatOrb {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(-25px, -18px) scale(1.04);
            }

            66% {
                transform: translate(18px, 12px) scale(0.97);
            }
        }

        @keyframes cardAppear {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes logoAppear {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.8) rotate(-5deg);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1) rotate(-2deg);
            }
        }

        @keyframes petalDrift {
            0% {
                transform: translateY(-40px) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 0.7;
            }

            100% {
                transform: translateY(110vh) rotate(var(--r));
                opacity: 0;
            }
        }

        .petal {
            animation: petalDrift var(--d) var(--delay) ease-in-out infinite;
            position: fixed;
            pointer-events: none;
            z-index: 1;
        }

        .float-orb {
            animation: floatOrb 15s ease-in-out infinite;
        }

        .card-appear {
            animation: cardAppear 0.9s cubic-bezier(0.2, 0.8, 0.2, 1) 0.1s both;
        }

        .logo-appear {
            animation: logoAppear 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }
    </style>
</head>

<body class="antialiased font-sans min-h-screen flex items-center justify-center p-5"
    style="background: radial-gradient(ellipse at 70% -5%, rgba(242,123,181,0.18) 0%, transparent 55%), radial-gradient(ellipse at -5% 105%, rgba(121,165,130,0.14) 0%, transparent 55%), linear-gradient(160deg, #fffbfe 0%, #f5f0fa 40%, #f0f7f2 100%);">

    <!-- Ambient orbs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0" aria-hidden="true">
        <div class="float-orb absolute w-[480px] h-[480px] rounded-full opacity-[0.08]" style="background: radial-gradient(circle, #f27bb5, transparent); top: -15%; right: -8%;"></div>
        <div class="float-orb absolute w-[400px] h-[400px] rounded-full opacity-[0.07]" style="background: radial-gradient(circle, #79a582, transparent); bottom: -10%; left: -10%; animation-delay: -7s;"></div>
        <div class="float-orb absolute w-[250px] h-[250px] rounded-full opacity-[0.05]" style="background: radial-gradient(circle, #c4a0e8, transparent); top: 50%; left: 45%; animation-delay: -14s;"></div>
    </div>

    <!-- Petals -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-[1]" aria-hidden="true" id="petal-container"></div>

    <!-- Page Layout -->
    <div class="relative z-10 w-full sm:max-w-md flex flex-col items-center">

        <!-- Logo Mark -->
        <div class="logo-appear mb-8 text-center">
            <a href="/" class="inline-block group">
                <div class="w-20 h-20 mx-auto rounded-[1.5rem] flex items-center justify-center text-4xl transition-all duration-500 group-hover:scale-110 group-hover:rotate-6 group-hover:shadow-[0_0_30px_rgba(242,123,181,0.4)]"
                    style="background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(255,240,248,0.8)); backdrop-filter: blur(20px); border: 1.5px solid rgba(255,255,255,0.8); box-shadow: 0 8px 30px rgba(242,123,181,0.2), 0 2px 6px rgba(0,0,0,0.06);">
                    💮
                </div>
            </a>
            <h2 class="mt-4 font-serif text-2xl font-bold text-slate-800 tracking-tight drop-shadow-sm">Nihongo Odyssey</h2>
            <p class="text-[10px] font-black uppercase tracking-[0.4em] text-slate-400 mt-1">日本語オデッセイ</p>
        </div>

        <!-- Auth Card -->
        <div class="card-appear w-full rounded-[2.5rem] overflow-hidden relative"
            style="background: rgba(255,255,255,0.7); backdrop-filter: blur(30px) saturate(180%); -webkit-backdrop-filter: blur(30px) saturate(180%); border: 1.5px solid rgba(255,255,255,0.8); box-shadow: 0 20px 60px rgba(0,0,0,0.08), 0 4px 12px rgba(0,0,0,0.04), 0 1px 2px rgba(255,255,255,0.9) inset;">

            <!-- Top accent bar -->
            <div class="h-1 w-full" style="background: linear-gradient(90deg, #f27bb5, #e0549a, #79a582, #568761, #f27bb5); background-size: 300%; animation: shimmerBar 4s linear infinite;"></div>

            <div class="px-8 py-10">
                {{ $slot }}
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-[10px] font-black uppercase tracking-[0.35em] text-slate-400 opacity-60">
                &copy; {{ date('Y') }} Nihongo Odyssey &bull; Jembatan Impian
            </p>
        </div>
    </div>

    <style>
        @keyframes shimmerBar {
            0% {
                background-position: 0% center;
            }

            100% {
                background-position: 300% center;
            }
        }
    </style>

    <script>
        const container = document.getElementById('petal-container');
        ['🌸', '🌺', '🌷', '✿'].forEach((p, i) => {
            for (let j = 0; j < 3; j++) {
                const el = document.createElement('div');
                el.className = 'petal';
                el.innerText = p;
                el.style.cssText = `left:${Math.random()*100}%; font-size:${10+Math.random()*14}px; --d:${10+Math.random()*12}s; --delay:${Math.random()*20}s; --r:${(Math.random()-0.5)*720}deg;`;
                container.appendChild(el);
            }
        });
    </script>
</body>

</html>
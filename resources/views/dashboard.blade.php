<x-app-layout>
    {{--
        Halaman Dashboard Utama - Nihongo Odyssey
        Menampilkan progress peta, mood tracker, tema dinamis, dan akses fitur utama.
    --}}
    <div class="py-6" x-data="{ mood: '{{ $user->mood ?? 'neutral' }}' }">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8 space-y-8">

            <!-- Grid Atas: Panel Atmosfer (Countdown, Tema, Mood, Tip) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

                <!-- Widget Hitung Mundur JLPT (Tokyo Station Style) -->
                <div class="glass-panel flex flex-col items-center justify-center text-center hover:scale-[1.02] transition-all duration-500 group relative overflow-hidden manhua-glow p-6 sm:p-8 rounded-[2rem] border border-slate-200/60 max-w-full">
                    <!-- LED ticker background effect -->
                    <div class="absolute inset-0 bg-slate-900 opacity-90 z-0"></div>
                    <div class="relative z-10 flex flex-col items-center w-full overflow-hidden">
                        <div class="font-mono text-sakura-400 text-[10px] sm:text-xs tracking-[0.2em] sm:tracking-[0.3em] uppercase mb-3 animate-pulse whitespace-nowrap">Next Train: JLPT N5 ({{ $jlptMonth }})</div>
                        <div class="font-mono text-3xl sm:text-4xl xl:text-5xl font-black text-white drop-shadow-md tabular-nums tracking-wider sm:tracking-widest flex flex-wrap justify-center items-baseline gap-1 break-all px-2">
                            {{ str_pad($daysToJLPT, 3, '0', STR_PAD_LEFT) }} <span class="text-[9px] sm:text-[10px] text-slate-400 font-sans font-bold tracking-widest uppercase sm:ml-1 opacity-80 whitespace-nowrap">Days</span>
                        </div>
                    </div>
                </div>

                <!-- Theme Switcher Panel -->
                <div class="manhua-card p-6 border-sakura-200 flex flex-col justify-center">
                    <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 mb-4 block text-center">Aesthetic Theme</h3>
                    <div class="grid grid-cols-3 gap-3">
                        <form action="{{ route('theme.update') }}" method="POST">
                            @csrf
                            <button type="submit" name="theme" value="senja" class="w-full h-14 rounded-xl border-2 {{ ($user->active_theme ?? 'senja') === 'senja' ? 'border-sakura-400 bg-sakura-50' : 'border-slate-200 bg-white/60 hover:bg-slate-50' }} flex items-center justify-center text-2xl transition-transform hover:scale-105 shadow-sm" title="Senja di Shinjuku">🌆</button>
                        </form>
                        <form action="{{ route('theme.update') }}" method="POST">
                            @csrf
                            <button type="submit" name="theme" value="perpustakaan" class="w-full h-14 rounded-xl border-2 {{ ($user->active_theme ?? 'senja') === 'perpustakaan' ? 'border-matcha-500 bg-matcha-50' : 'border-slate-200 bg-white/60 hover:bg-slate-50' }} flex items-center justify-center text-2xl transition-transform hover:scale-105 shadow-sm" title="Perpustakaan Tua">🎐</button>
                        </form>
                        <form action="{{ route('theme.update') }}" method="POST">
                            @csrf
                            <button type="submit" name="theme" value="neon" class="w-full h-14 rounded-xl border-2 {{ ($user->active_theme ?? 'senja') === 'neon' ? 'border-indigo-400 bg-indigo-50' : 'border-slate-200 bg-white/60 hover:bg-slate-50' }} flex items-center justify-center text-2xl transition-transform hover:scale-105 shadow-sm" title="Tokyo Malam">🌌</button>
                        </form>
                    </div>
                </div>

                <!-- Mood Tracker Panel -->
                <div class="manhua-card p-6 border-matcha-200 flex flex-col justify-center">
                    <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 mb-4 block text-center">Current Spirit</h3>
                    <form action="{{ route('mood.update') }}" method="POST" class="flex justify-between items-center w-full px-2">
                        @csrf
                        <button type="submit" name="mood" value="happy" class="text-3xl transition-transform hover:scale-110 {{ $user->mood === 'happy' ? 'filter grayscale-0 drop-shadow-md' : 'filter grayscale opacity-40 hover:opacity-100 hover:grayscale-0' }}">😊</button>
                        <button type="submit" name="mood" value="neutral" class="text-3xl transition-transform hover:scale-110 {{ $user->mood === 'neutral' ? 'filter grayscale-0 drop-shadow-md' : 'filter grayscale opacity-40 hover:opacity-100 hover:grayscale-0' }}">😐</button>
                        <button type="submit" name="mood" value="sad" class="text-3xl transition-transform hover:scale-110 {{ $user->mood === 'sad' ? 'filter grayscale-0 drop-shadow-md' : 'filter grayscale opacity-40 hover:opacity-100 hover:grayscale-0' }}">😢</button>
                        <button type="submit" name="mood" value="angry" class="text-3xl transition-transform hover:scale-110 {{ $user->mood === 'angry' ? 'filter grayscale-0 drop-shadow-md' : 'filter grayscale opacity-40 hover:opacity-100 hover:grayscale-0' }}">💢</button>
                    </form>
                </div>

                <!-- Secret Note (Interactive Pop-up) -->
                <div class="manhua-card p-6 border-slate-200 relative overflow-hidden group cursor-pointer flex flex-col justify-center" @click="open = true" x-data="{ open: false }">
                    <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <span class="text-6xl">🐾</span>
                    </div>
                    <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-sakura-600 mb-2 flex items-center relative z-10">
                        <span class="mr-2 text-sm">🐱</span> Whisper
                    </h3>
                    <p class="text-xs text-slate-500 italic line-clamp-2 relative z-10 font-serif pr-4 leading-relaxed">
                        "{{ $secretNote->content ?? 'Keep moving forward...' }}"
                    </p>

                    <!-- Poetic Modal -->
                    <template x-if="open">
                        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm animate-fadeIn">
                            <div class="manhua-card max-w-lg w-full shadow-2xl relative p-10 bg-white/90 border-sakura-300" @click.away="open = false">
                                <div class="absolute top-6 left-6 text-4xl opacity-10">🕯️</div>
                                <div class="text-center relative z-10">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-sakura-500 mb-6 block">Neko-Sensei's Note</span>
                                    <p class="text-xl font-serif italic text-slate-700 leading-relaxed mb-8 px-4">
                                        "{{ $secretNote->content ?? 'The path to mastery is built with bricks of persistence.' }}"
                                    </p>
                                    <button @click="open = false" class="bg-slate-800 hover:bg-slate-700 text-white font-bold uppercase tracking-widest text-[10px] px-8 py-3 rounded-full transition-all shadow-md active:scale-95">
                                        Dismiss
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Second Grid: Store & Daily Reward -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <!-- Koban Ichiba Entry -->
                <a href="{{ route('store.index') }}" class="group block manhua-card hover:shadow-glow p-1.5 transition-all">
                    <div class="bg-gradient-to-br from-amber-50/80 to-orange-50/50 h-full p-6 lg:p-8 flex flex-col md:flex-row items-center justify-between gap-6 rounded-[2rem] border border-amber-200/50">
                        <div class="flex flex-col md:flex-row items-center text-center md:text-left gap-4 lg:gap-6">
                            <div class="w-16 h-16 shrink-0 bg-white/80 backdrop-blur-md rounded-2xl flex items-center justify-center text-4xl group-hover:rotate-12 group-hover:scale-110 transition-transform shadow-sm border border-white">🏮</div>
                            <div>
                                <h3 class="text-xl lg:text-2xl font-serif font-bold text-amber-900 leading-tight">Koban Ichiba</h3>
                                <p class="text-[10px] text-amber-700 mt-2 uppercase font-bold tracking-widest">Village Marketplace</p>
                            </div>
                        </div>
                        <div class="text-amber-500 group-hover:text-amber-600 group-hover:translate-x-2 transition-all mt-4 md:mt-0 p-3 bg-white/50 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                @if($canClaimDaily)
                <div class="manhua-card p-1.5 animate-pulse group shadow-glow border-sakura-300">
                    <div class="bg-gradient-to-br from-sakura-50/80 to-matcha-50/80 h-full p-6 lg:p-8 flex flex-col md:flex-row items-center justify-between gap-6 rounded-[2rem] border border-white/60">
                        <div class="flex flex-col md:flex-row items-center text-center md:text-left gap-4 lg:gap-6">
                            <div class="w-16 h-16 shrink-0 bg-white/80 backdrop-blur-md rounded-2xl flex items-center justify-center text-4xl group-hover:scale-110 group-hover:-rotate-6 transition-transform shadow-sm border border-white">🎁</div>
                            <div>
                                <h3 class="text-xl lg:text-2xl font-serif font-bold text-slate-800 leading-tight">Daily Gift!</h3>
                                <p class="text-[10px] text-sakura-600 font-bold tracking-widest uppercase mt-2">Claim your Kobans</p>
                            </div>
                        </div>
                        <form action="{{ route('daily.claim') }}" method="POST" class="w-full md:w-auto mt-4 md:mt-0">
                            @csrf
                            <button type="submit" class="w-full md:w-auto bg-sakura-500 hover:bg-sakura-600 text-white px-8 py-4 rounded-full font-bold text-[10px] lg:text-xs uppercase tracking-widest transition-all hover:-translate-y-1 shadow-md active:scale-95 whitespace-nowrap">Claim 50 🪙</button>
                        </form>
                    </div>
                </div>
                @else
                <div class="glass-panel p-6 lg:p-8 flex flex-col md:flex-row items-center gap-6 opacity-80 border-dashed border-2 border-slate-300 rounded-[2.5rem] bg-slate-50/30">
                    <div class="w-16 h-16 shrink-0 bg-slate-200/50 rounded-2xl flex items-center justify-center text-4xl filter grayscale opacity-70">💮</div>
                    <div class="text-center md:text-left">
                        <h3 class="text-xl lg:text-2xl font-serif font-bold text-slate-500 leading-tight">Gift Claimed</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-2">Rest your spirit. Return tomorrow.</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Third Grid: Main Features & Map -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                <!-- Main Adventure Map -->
                <div class="lg:col-span-3 glass-panel relative p-6 sm:p-10 text-center rounded-[3rem] border border-white/60">
                    <!-- Magic Glow backdrop -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-sakura-300 opacity-20 blur-[100px] rounded-full pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-matcha-300 opacity-20 blur-[100px] rounded-full pointer-events-none"></div>

                    <div class="relative z-10 flex flex-col items-center">
                        <h2 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-slate-800 mb-2 mt-4 drop-shadow-sm">The Quest Map</h2>
                        <p class="text-[10px] uppercase tracking-[0.3em] font-bold text-slate-500 mb-12">Select a village to continue</p>

                        <div class="w-full max-w-4xl mx-auto space-y-16 py-4">
                            @foreach($regions as $index => $region)
                            <div class="relative text-left">
                                <div class="flex items-center mb-10 {{ $index % 2 == 0 ? 'flex-row' : 'flex-row-reverse' }}">
                                    <div class="h-[2px] bg-gradient-to-r from-transparent via-sakura-200 to-transparent flex-grow"></div>
                                    <h4 class="mx-4 px-6 py-2.5 bg-white/80 backdrop-blur-md border border-sakura-200 rounded-full text-[10px] font-bold text-sakura-700 shadow-sm uppercase tracking-widest whitespace-nowrap">
                                        Arc {{ $index + 1 }}: {{ $region->name }}
                                    </h4>
                                    <div class="h-[2px] bg-gradient-to-r from-transparent via-sakura-200 to-transparent flex-grow"></div>
                                </div>

                                <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 gap-6 sm:gap-8 justify-items-center">
                                    @foreach($region->levels as $level)
                                    @php
                                    $status = $progress[$level->id] ?? 'locked';
                                    $isLocked = $status === 'locked';
                                    $isPassed = $status === 'passed';
                                    $isBoss = $level->is_boss_level;
                                    @endphp
                                    <div class="flex flex-col items-center group relative z-10 w-full max-w-[90px]">
                                        <a href="{{ $isLocked ? '#' : route('quiz.start', $level) }}"
                                            class="relative w-16 h-16 sm:w-20 sm:h-20 flex items-center justify-center transition-all duration-300 transform
                                                       {{ $isLocked ? 'bg-slate-100/60 opacity-60 cursor-not-allowed rounded-full border border-slate-300 shadow-sm' : 'hover:-translate-y-2 bg-white/90 backdrop-blur-md shadow-glass-sm hover:shadow-glow rounded-[1.5rem]' }}
                                                       {{ $isPassed && !$isBoss ? 'border-2 border-matcha-300 bg-matcha-50/50' : '' }}
                                                       {{ $status === 'unlocked' && !$isBoss ? 'border border-sakura-400 shadow-glow animate-float-slow bg-white' : '' }}
                                                       {{ $isBoss ? 'rounded-[2rem] border-2 border-sakura-500 shadow-glow hover:rotate-3 bg-white' : '' }}">

                                            @if($isBoss) <span class="text-3xl sm:text-4xl filter group-hover:drop-shadow-lg transition-transform pb-1">👹</span>
                                            @elseif($isPassed) <span class="text-2xl sm:text-3xl filter pb-1">🉐</span>
                                            @else <span class="text-xl sm:text-2xl font-black font-sans {{ $status === 'unlocked' ? 'text-sakura-600' : 'text-slate-500' }}">{{ $level->order }}</span>
                                            @endif

                                            <!-- Decorative magical aura for unlocked nodes -->
                                            @if($status === 'unlocked') <div class="absolute -inset-2 rounded-full border border-sakura-400/40 animate-ping opacity-60 pointer-events-none"></div> @endif

                                            @if($isLocked) <div class="absolute -top-1 -right-1 bg-slate-300 text-slate-600 w-6 h-6 rounded-full flex items-center justify-center text-[10px] shadow-sm">🔒</div>
                                            @elseif($isPassed) <div class="absolute -top-1 -right-1 bg-matcha-400 text-white w-6 h-6 rounded-full flex items-center justify-center text-[10px] shadow-sm">⭐</div>
                                            @endif
                                        </a>
                                        <span class="mt-4 text-[9px] sm:text-[10px] font-bold uppercase tracking-widest text-slate-600 text-center w-full truncate leading-tight transition-opacity {{ $isLocked ? 'opacity-50' : 'opacity-90 group-hover:text-sakura-600' }}">{{ $level->name }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar: Collectibles & Stats -->
                <div class="space-y-6 lg:col-span-1">

                    <!-- Buku Kenangan (Memory Album) -->
                    <a href="{{ route('album.index') }}" class="block group">
                        <div class="glass-panel p-6 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-glow border-slate-200/50 rounded-[2.5rem]">
                            <div class="absolute -right-4 -bottom-4 text-9xl opacity-10 group-hover:rotate-6 group-hover:opacity-20 transition-all blur-[2px]">🖼️</div>
                            <h3 class="font-serif text-2xl font-bold text-slate-800 relative z-10 mb-1">Buku Kenangan</h3>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-sakura-600 mb-8 relative z-10">Memory Archive</p>

                            <div class="flex items-center text-[10px] font-bold uppercase tracking-widest text-slate-500 group-hover:text-sakura-600 transition-colors relative z-10">
                                View Gallery <span class="ml-2 group-hover:translate-x-1 transition-transform">→</span>
                            </div>
                        </div>
                    </a>

                    <!-- Buku Hitam (Mistakes) -->
                    <a href="{{ route('black_book.index') }}" class="block group">
                        <div class="bg-slate-900/90 backdrop-blur-md p-6 shadow-glass-sm rounded-[2.5rem] relative overflow-hidden transition-all duration-300 hover:-translate-y-1 border border-slate-700/50 hover:border-slate-500">
                            <div class="absolute -right-4 -bottom-4 text-9xl opacity-5 group-hover:scale-105 group-hover:opacity-10 transition-all blur-[2px]">📜</div>
                            <h3 class="font-serif text-2xl font-bold text-slate-100 relative z-10 mb-1">Buku Hitam</h3>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-6 relative z-10">Mistake Archive</p>

                            <div class="bg-slate-800/80 border border-slate-700/50 rounded-2xl p-4 flex justify-between items-center mb-6 relative z-10">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Target Belajar</span>
                                <span class="text-2xl font-serif font-black text-sakura-300">{{ $user->blackBooks()->where('is_mastered', false)->count() }}</span>
                            </div>

                            <div class="flex items-center text-slate-400 font-bold text-[10px] uppercase tracking-widest group-hover:text-sakura-300 transition-colors relative z-10">
                                Begin Rematch <span class="ml-2 group-hover:translate-x-1 transition-transform">→</span>
                            </div>
                        </div>
                    </a>

                    <!-- Stats Quicklook -->
                    <div class="glass-panel p-6 border-slate-200/50 rounded-[2.5rem]">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-white/40 rounded-2xl border border-white/50">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Streak</span>
                                <span class="text-lg font-black text-orange-400 drop-shadow-sm">🔥 {{ $user->current_streak }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white/40 rounded-2xl border border-white/50">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Punches</span>
                                <span class="text-lg font-black text-sakura-500 drop-shadow-sm">🐾 {{ $user->paw_points ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</x-app-layout>
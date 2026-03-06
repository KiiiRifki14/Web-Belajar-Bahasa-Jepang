<x-app-layout>
    <div class="py-6" x-data="{ mood: '{{ $user->mood ?? 'neutral' }}' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Top Grid: Atmosphere Panels -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <!-- Countdown Widget -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-lg border-b-4 border-pink-300 dark:border-pink-900 flex flex-col items-center justify-center text-center transition-all hover:scale-105 manhua-outline group">
                    <div class="text-pink-500 text-4xl mb-2 transition-transform group-hover:rotate-12">🏯</div>
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Road to Tokyo</h3>
                    <div class="text-4xl font-black text-[var(--theme-text)] my-2">
                        {{ $daysToJLPT }} <span class="text-lg font-normal opacity-30">Days</span>
                    </div>
                </div>

                <!-- Theme Switcher Panel -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-lg border-b-4 border-[var(--theme-secondary)] group manhua-outline">
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Aesthetic Atmosphere</h3>
                    <div class="grid grid-cols-3 gap-2">
                        <form action="{{ route('theme.update') }}" method="POST">
                            @csrf
                            <button type="submit" name="theme" value="senja" class="w-full h-12 rounded-xl bg-orange-100 border-2 {{ ($user->active_theme ?? 'senja') === 'senja' ? 'border-orange-500' : 'border-transparent' }} flex items-center justify-center text-xl transition-transform hover:scale-110" title="Senja di Shinjuku">🌇</button>
                        </form>
                        <form action="{{ route('theme.update') }}" method="POST">
                            @csrf
                            <button type="submit" name="theme" value="perpustakaan" class="w-full h-12 rounded-xl bg-stone-100 border-2 {{ ($user->active_theme ?? 'senja') === 'perpustakaan' ? 'border-amber-700' : 'border-transparent' }} flex items-center justify-center text-xl transition-transform hover:scale-110" title="Perpustakaan Tua">📜</button>
                        </form>
                        <form action="{{ route('theme.update') }}" method="POST">
                            @csrf
                            <button type="submit" name="theme" value="neon" class="w-full h-12 rounded-xl bg-indigo-900 border-2 {{ ($user->active_theme ?? 'senja') === 'neon' ? 'border-cyan-400' : 'border-transparent' }} flex items-center justify-center text-xl transition-transform hover:scale-110" title="Tokyo Malam">🌌</button>
                        </form>
                    </div>
                </div>

                <!-- Mood Tracker Panel -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-lg border-b-4 border-indigo-300 dark:border-indigo-900 group manhua-outline">
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Current Spirit</h3>
                    <form action="{{ route('mood.update') }}" method="POST" class="flex justify-around w-full">
                        @csrf
                        <button type="submit" name="mood" value="happy" class="text-2xl transition hover:scale-125 {{ $user->mood === 'happy' ? 'grayscale-0' : 'grayscale opacity-40' }}">😊</button>
                        <button type="submit" name="mood" value="neutral" class="text-2xl transition hover:scale-125 {{ $user->mood === 'neutral' ? 'grayscale-0' : 'grayscale opacity-40' }}">😐</button>
                        <button type="submit" name="mood" value="sad" class="text-2xl transition hover:scale-125 {{ $user->mood === 'sad' ? 'grayscale-0' : 'grayscale opacity-40' }}">😢</button>
                        <button type="submit" name="mood" value="angry" class="text-2xl transition hover:scale-125 {{ $user->mood === 'angry' ? 'grayscale-0' : 'grayscale opacity-40' }}">💢</button>
                    </form>
                </div>

                <!-- Secret Note (Interactive Pop-up) -->
                <div x-data="{ open: false }" @click="open = true" class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-lg border-b-4 border-amber-200 dark:border-amber-800 relative overflow-hidden group cursor-pointer manhua-outline">
                    <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="text-6xl">🐾</span>
                    </div>
                    <h3 class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-2 flex items-center">
                        <span class="mr-2">🐱</span> Whisper
                    </h3>
                    <p class="text-[10px] text-gray-400 leading-relaxed italic line-clamp-2">
                        "{{ $secretNote->content ?? 'Keep moving forward...' }}"
                    </p>

                    <!-- Poetic Modal -->
                    <template x-if="open">
                        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm animate-fadeIn">
                            <div class="bg-white dark:bg-gray-800 p-12 rounded-[3.5rem] max-w-lg w-full shadow-2xl relative manhua-outline" @click.away="open = false">
                                <div class="absolute top-8 left-8 text-4xl opacity-10">🕯️</div>
                                <div class="text-center">
                                    <span class="text-[10px] font-black uppercase tracking-[0.5em] text-indigo-300 mb-8 block">Neko-Sensei's Note</span>
                                    <p class="text-2xl font-serif italic text-[var(--theme-text)] leading-relaxed mb-10">
                                        "{{ $secretNote->content ?? 'The path to mastery is built with bricks of persistence.' }}"
                                    </p>
                                    <button @click="open = false" class="px-8 py-3 bg-[var(--theme-primary)] text-white rounded-full font-black text-[10px] uppercase tracking-widest shadow-lg hover:scale-105 transition-transform manhua-glow">Dismiss</button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Second Grid: Store & Daily Reward -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Koban Ichiba Entry -->
                <a href="{{ route('store.index') }}" class="group bg-gradient-to-r from-stone-800 to-stone-900 p-1 rounded-[2.5rem] shadow-xl transition-all hover:scale-[1.01]">
                    <div class="bg-white dark:bg-stone-800 h-full rounded-[2.3rem] p-8 flex items-center justify-between border-b-8 border-stone-200 dark:border-stone-700">
                        <div class="flex items-center">
                            <div class="w-20 h-20 bg-stone-100 dark:bg-stone-700 rounded-2xl flex items-center justify-center text-5xl mr-6 group-hover:rotate-12 transition-transform shadow-inner">🏮</div>
                            <div>
                                <h3 class="text-2xl font-black text-stone-800 dark:text-white leading-tight underline decoration-[var(--theme-primary)] decoration-4 underline-offset-8">Koban Ichiba</h3>
                                <p class="text-[10px] text-stone-500 mt-2 uppercase font-black tracking-widest opacity-60">Traditional Village Marketplace</p>
                            </div>
                        </div>
                        <div class="text-stone-300 group-hover:text-[var(--theme-primary)] transition-colors">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                @if($canClaimDaily)
                <div class="bg-gradient-to-r from-[var(--theme-primary)] to-[var(--theme-secondary)] p-1 rounded-[2.5rem] shadow-xl animate-pulse group">
                    <div class="bg-white dark:bg-gray-900 h-full rounded-[2.3rem] p-8 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-20 h-20 bg-amber-50 dark:bg-amber-950 rounded-2xl flex items-center justify-center text-5xl mr-6 group-hover:scale-110 transition-transform">🎁</div>
                            <div>
                                <h3 class="text-2xl font-black text-[var(--theme-text)] leading-tight">Daily Gift!</h3>
                                <p class="text-[10px] text-amber-600 font-black tracking-widest uppercase opacity-80 mt-2">Claim your dailyKobans</p>
                            </div>
                        </div>
                        <form action="{{ route('daily.claim') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-[var(--theme-text)] text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all hover:scale-105 shadow-xl">Claim 50 🪙</button>
                        </form>
                    </div>
                </div>
                @else
                <div class="bg-gray-100 dark:bg-gray-800 p-8 rounded-[2.5rem] border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center opacity-40 manhua-outline">
                    <div class="w-20 h-20 bg-gray-50 dark:bg-gray-700 rounded-2xl flex items-center justify-center text-5xl mr-6 grayscale">💮</div>
                    <div>
                        <h3 class="text-2xl font-black text-gray-400 leading-tight">Gift Claimed</h3>
                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-2">Rest your spirit. Return tomorrow.</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Third Grid: Main Features & Map -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                <!-- Main Adventure Map -->
                <div class="lg:col-span-3 bg-white dark:bg-gray-800 rounded-[3rem] shadow-2xl p-10 manhua-outline relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-[var(--theme-primary)] opacity-5 blur-[120px]"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <h2 class="text-4xl font-black text-[var(--theme-text)] mb-2 tracking-tighter uppercase italic">Road to Tokyo</h2>
                        <p class="text-xs text-gray-400 mb-12 uppercase tracking-[0.3em] font-bold">Select a village to continue your odyssey</p>

                        <div class="w-full space-y-20 py-10">
                            @foreach($regions as $index => $region)
                            <div class="relative">
                                <div class="flex items-center mb-12 {{ $index % 2 == 0 ? 'flex-row' : 'flex-row-reverse' }}">
                                    <div class="h-[2px] bg-gradient-to-r from-transparent via-[var(--theme-border)] to-transparent flex-grow"></div>
                                    <h4 class="mx-6 px-6 py-2 bg-[var(--theme-bg)] border-2 border-[var(--theme-border)] rounded-full text-[10px] font-black text-[var(--theme-text)] shadow-sm uppercase tracking-[0.3em]">
                                        Arc {{ $index + 1 }}: {{ $region->name }}
                                    </h4>
                                    <div class="h-[2px] bg-gradient-to-r from-transparent via-[var(--theme-border)] to-transparent flex-grow"></div>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-5 gap-10">
                                    @foreach($region->levels as $level)
                                    @php
                                    $status = $progress[$level->id] ?? 'locked';
                                    $isLocked = $status === 'locked';
                                    $isPassed = $status === 'passed';
                                    @endphp
                                    <div class="flex flex-col items-center group">
                                        <a href="{{ $isLocked ? '#' : route('quiz.start', $level) }}"
                                            class="relative w-20 h-20 rounded-3xl flex items-center justify-center transition-all duration-500 transform manhua-outline
                                                       {{ $isLocked ? 'bg-gray-100 dark:bg-gray-700 opacity-40 cursor-not-allowed' : 'hover:scale-110 shadow-xl active:scale-90 hover:-translate-y-2 bg-white dark:bg-gray-800' }}
                                                       {{ $isPassed ? 'border-[var(--theme-secondary)] ' : '' }}
                                                       {{ $status === 'unlocked' ? 'border-[var(--theme-primary)] manhua-glow animate-pulse' : '' }}">

                                            @if($level->is_boss_level) <span class="text-4xl filter group-hover:drop-shadow-lg">👹</span>
                                            @elseif($isPassed) <span class="text-4xl text-[var(--theme-secondary)]">🉐</span>
                                            @else <span class="text-2xl font-black {{ $status === 'unlocked' ? 'text-[var(--theme-primary)]' : 'text-gray-300' }}">{{ $level->order }}</span>
                                            @endif

                                            @if($isLocked) <div class="absolute -top-3 -right-3 bg-gray-400 text-white w-8 h-8 rounded-2xl flex items-center justify-center text-xs shadow-lg">🔒</div>
                                            @elseif($isPassed) <div class="absolute -top-3 -right-3 bg-[var(--theme-secondary)] text-white w-8 h-8 rounded-2xl flex items-center justify-center text-xs shadow-lg">⭐</div>
                                            @endif
                                        </a>
                                        <span class="mt-4 text-[10px] font-black uppercase text-center opacity-30 tracking-widest max-w-[80px] truncate">{{ $level->name }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar: Collectibles & Stats -->
                <div class="space-y-8 lg:col-span-1">

                    <!-- Buku Kenangan (Memory Album) -->
                    <a href="{{ route('album.index') }}" class="block group">
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-[3rem] shadow-xl manhua-outline relative overflow-hidden transition-all hover:-translate-y-2">
                            <div class="absolute -right-4 -bottom-4 text-9xl opacity-10 group-hover:rotate-6 transition-transform">🖼️</div>
                            <h3 class="text-2xl font-black text-[var(--theme-text)] mb-1">Buku Kenangan</h3>
                            <p class="text-[10px] text-[var(--theme-secondary)] font-black uppercase tracking-widest mb-6">Memory Archive</p>

                            <div class="flex items-center text-[10px] font-black uppercase opacity-40 group-hover:opacity-100 transition-opacity">
                                View Gallery <span class="ml-2 group-hover:translate-x-2 transition-transform">→</span>
                            </div>
                        </div>
                    </a>

                    <!-- Buku Hitam (Mistakes) -->
                    <a href="{{ route('black_book.index') }}" class="block group">
                        <div class="bg-[#1a120b] p-8 rounded-[3rem] shadow-2xl border-t-8 border-[#3c2a21] relative overflow-hidden transition-all hover:-translate-y-2">
                            <div class="absolute -right-4 -bottom-4 text-9xl opacity-10 group-hover:scale-110 transition-transform">📜</div>
                            <h3 class="text-2xl font-serif italic text-[#e5e5cb] mb-1">Buku Hitam</h3>
                            <p class="text-[10px] text-[#d5cea3] font-black uppercase tracking-widest mb-6">Mistake Archive</p>

                            <div class="bg-[#3c2a21] rounded-2xl p-4 flex justify-between items-center mb-6">
                                <span class="text-[10px] text-[#d5cea3] opacity-60 font-black tracking-widest uppercase">Target</span>
                                <span class="text-2xl font-serif font-black text-white">{{ $user->blackBooks()->where('is_mastered', false)->count() }}</span>
                            </div>

                            <div class="flex items-center text-[#d5cea3] font-black text-[10px] uppercase tracking-widest group-hover:translate-x-2 transition-transform">
                                Begin Rematch <span class="ml-2">→</span>
                            </div>
                        </div>
                    </a>

                    <!-- Stats Quicklook -->
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-[3rem] manhua-outline shadow-xl">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black uppercase text-gray-400 tracking-[0.3em]">Streak</span>
                                <span class="text-xl font-black text-orange-500">🔥 {{ $user->current_streak }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black uppercase text-gray-400 tracking-[0.3em]">Punches</span>
                                <span class="text-xl font-black text-indigo-500">🐾 {{ $user->paw_points ?? 0 }}</span>
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
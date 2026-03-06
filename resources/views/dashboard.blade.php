<x-app-layout>
    {{--
        Halaman Dashboard Utama - Nihongo Odyssey
        Menampilkan progress peta, mood tracker, tema dinamis, dan akses fitur utama.
    --}}
    <div class="py-6" x-data="{ mood: '{{ $user->mood ?? 'neutral' }}' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Grid Atas: Panel Atmosfer (Countdown, Tema, Mood, Tip) -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-section">

                <!-- Widget Hitung Mundur JLPT -->
                <x-card class="flex flex-col items-center justify-center text-center hover:scale-105 transition-all group" style="border-color: var(--theme-primary);">
                    <div class="text-[var(--theme-primary)] text-4xl mb-2 transition-transform group-hover:rotate-12">🏯</div>
                    <h3 class="text-label text-gray-400 mb-3">Road to Tokyo</h3>
                    <div class="text-4xl font-black text-[var(--theme-text)] my-2">
                        {{ $daysToJLPT }} <span class="text-sm font-normal opacity-40">Days</span>
                    </div>
                </x-card>

                <!-- Theme Switcher Panel -->
                <x-card style="border-color: var(--theme-secondary);">
                    <h3 class="text-label text-gray-400 mb-4">Aesthetic Atmosphere</h3>
                    <div class="grid grid-cols-3 gap-2">
                        <form action="{{ route('theme.update') }}" method="POST">
                            @csrf
                            <button type="submit" name="theme" value="senja" class="w-full h-12 rounded-xl border-2 {{ ($user->active_theme ?? 'senja') === 'senja' ? 'border-orange-500 bg-orange-50 dark:bg-orange-900' : 'border-transparent bg-orange-100 dark:bg-orange-950' }} flex items-center justify-center text-xl transition-transform hover:scale-110" title="Senja di Shinjuku">🌇</button>
                        </form>
                        <form action="{{ route('theme.update') }}" method="POST">
                            @csrf
                            <button type="submit" name="theme" value="perpustakaan" class="w-full h-12 rounded-xl border-2 {{ ($user->active_theme ?? 'senja') === 'perpustakaan' ? 'border-amber-700 bg-stone-100 dark:bg-stone-900' : 'border-transparent bg-stone-100 dark:bg-stone-950' }} flex items-center justify-center text-xl transition-transform hover:scale-110" title="Perpustakaan Tua">📜</button>
                        </form>
                        <form action="{{ route('theme.update') }}" method="POST">
                            @csrf
                            <button type="submit" name="theme" value="neon" class="w-full h-12 rounded-xl border-2 {{ ($user->active_theme ?? 'senja') === 'neon' ? 'border-cyan-400 bg-indigo-900 dark:bg-indigo-950' : 'border-transparent bg-indigo-900 dark:bg-indigo-950' }} flex items-center justify-center text-xl transition-transform hover:scale-110" title="Tokyo Malam">🌌</button>
                        </form>
                    </div>
                </x-card>

                <!-- Mood Tracker Panel -->
                <x-card style="border-color: var(--theme-secondary);">
                    <h3 class="text-label text-gray-400 mb-4">Current Spirit</h3>
                    <form action="{{ route('mood.update') }}" method="POST" class="flex justify-around w-full">
                        @csrf
                        <button type="submit" name="mood" value="happy" class="text-2xl transition hover:scale-125 {{ $user->mood === 'happy' ? 'grayscale-0' : 'grayscale opacity-40' }}">😊</button>
                        <button type="submit" name="mood" value="neutral" class="text-2xl transition hover:scale-125 {{ $user->mood === 'neutral' ? 'grayscale-0' : 'grayscale opacity-40' }}">😐</button>
                        <button type="submit" name="mood" value="sad" class="text-2xl transition hover:scale-125 {{ $user->mood === 'sad' ? 'grayscale-0' : 'grayscale opacity-40' }}">😢</button>
                        <button type="submit" name="mood" value="angry" class="text-2xl transition hover:scale-125 {{ $user->mood === 'angry' ? 'grayscale-0' : 'grayscale opacity-40' }}">💢</button>
                    </form>
                </x-card>

                <!-- Secret Note (Interactive Pop-up) -->
                <x-card style="border-color: var(--theme-primary);" class="relative overflow-hidden group cursor-pointer" @click="open = true" x-data="{ open: false }">
                    <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="text-6xl">🐾</span>
                    </div>
                    <h3 class="text-label text-[var(--theme-primary)] mb-2 flex items-center">
                        <span class="mr-2">🐱</span> Whisper
                    </h3>
                    <p class="text-small text-gray-400 italic line-clamp-2">
                        "{{ $secretNote->content ?? 'Keep moving forward...' }}"
                    </p>

                    <!-- Poetic Modal -->
                    <template x-if="open">
                        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm animate-fadeIn">
                            <x-card class="max-w-lg w-full shadow-2xl relative" style="border-radius: 3.5rem;" @click.away="open = false">
                                <div class="absolute top-8 left-8 text-4xl opacity-10">🕯️</div>
                                <div class="text-center">
                                    <span class="text-label text-[var(--theme-primary)] mb-8 block">Neko-Sensei's Note</span>
                                    <p class="text-heading font-serif italic text-[var(--theme-text)] leading-relaxed mb-10">
                                        "{{ $secretNote->content ?? 'The path to mastery is built with bricks of persistence.' }}"
                                    </p>
                                    <x-btn-primary @click="open = false" class="rounded-full">Dismiss</x-btn-primary>
                                </div>
                            </x-card>
                        </div>
                    </template>
                </x-card>
            </div>

            <!-- Second Grid: Store & Daily Reward -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Koban Ichiba Entry -->
                <a href="{{ route('store.index') }}" class="group bg-gradient-to-r from-stone-800 to-stone-900 p-1 shadow-xl transition-all hover:scale-[1.01]" style="border-radius: 2.5rem;">
                    <div class="bg-white dark:bg-stone-800 h-full p-8 flex items-center justify-between border-b-8 border-stone-200 dark:border-stone-700" style="border-radius: 2.3rem;">
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
                <div class="bg-gradient-to-r from-[var(--theme-primary)] to-[var(--theme-secondary)] p-1 shadow-xl animate-pulse group" style="border-radius: 2.5rem;">
                    <div class="bg-white dark:bg-gray-900 h-full p-8 flex items-center justify-between" style="border-radius: 2.3rem;">
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
                <div class="bg-gray-100 dark:bg-gray-800 p-8 border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center opacity-40 manhua-outline" style="border-radius: 2.5rem;">
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
                <x-card class="lg:col-span-3 shadow-2xl relative overflow-hidden" style="border-radius: 3rem;">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-[var(--theme-primary)] opacity-5 blur-[120px]"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <h2 class="text-display text-[var(--theme-text)] uppercase italic">Road to Tokyo</h2>
                        <p class="text-label text-gray-400 mb-12">Select a village to continue your odyssey</p>

                        <div class="w-full space-y-20 py-10">
                            @foreach($regions as $index => $region)
                            <div class="relative">
                                <div class="flex items-center mb-12 {{ $index % 2 == 0 ? 'flex-row' : 'flex-row-reverse' }}">
                                    <div class="h-[2px] bg-gradient-to-r from-transparent via-[var(--theme-border)] to-transparent flex-grow"></div>
                                    <h4 class="mx-6 px-6 py-2 bg-[var(--theme-bg)] border-2 border-[var(--theme-border)] rounded-full text-caption text-[var(--theme-text)] shadow-sm uppercase">
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
                                        <span class="mt-4 text-caption text-[var(--theme-text)] text-center opacity-40 max-w-[80px] truncate">{{ $level->name }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </x-card>

                <!-- Right Sidebar: Collectibles & Stats -->
                <div class="space-y-8 lg:col-span-1">

                    <!-- Buku Kenangan (Memory Album) -->
                    <a href="{{ route('album.index') }}" class="block group">
                        <x-card class="relative overflow-hidden transition-all hover:-translate-y-2" style="border-radius: 3rem;">
                            <div class="absolute -right-4 -bottom-4 text-9xl opacity-10 group-hover:rotate-6 transition-transform">🖼️</div>
                            <h3 class="text-heading text-[var(--theme-text)]">Buku Kenangan</h3>
                            <p class="text-label text-[var(--theme-secondary)] mb-6">Memory Archive</p>

                            <div class="flex items-center text-caption text-[var(--theme-text)] opacity-60 group-hover:opacity-100 transition-opacity">
                                View Gallery <span class="ml-2 group-hover:translate-x-2 transition-transform">→</span>
                            </div>
                        </x-card>
                    </a>

                    <!-- Buku Hitam (Mistakes) -->
                    <a href="{{ route('black_book.index') }}" class="block group">
                        <div class="bg-gradient-to-br from-stone-900 to-amber-950 dark:from-stone-950 dark:to-amber-900 p-6 shadow-2xl rounded-[3rem] relative overflow-hidden transition-all hover:-translate-y-2" style="border: 1px solid rgba(139, 90, 43, 0.3);">
                            <div class="absolute -right-4 -bottom-4 text-9xl opacity-10 group-hover:scale-110 transition-transform">📜</div>
                            <h3 class="text-heading font-serif italic text-amber-50">Buku Hitam</h3>
                            <p class="text-label text-amber-100 mb-6">Mistake Archive</p>

                            <div class="bg-amber-900 dark:bg-amber-950 rounded-2xl p-4 flex justify-between items-center mb-6">
                                <span class="text-label text-amber-100 opacity-70">Target</span>
                                <span class="text-2xl font-serif font-black text-white">{{ $user->blackBooks()->where('is_mastered', false)->count() }}</span>
                            </div>

                            <div class="flex items-center text-amber-100 font-black text-caption uppercase tracking-widest group-hover:translate-x-2 transition-transform">
                                Begin Rematch <span class="ml-2">→</span>
                            </div>
                        </div>
                    </a>

                    <!-- Stats Quicklook -->
                    <x-card style="border-radius: 3rem;" class="shadow-xl">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <span class="text-label text-gray-400">Streak</span>
                                <span class="text-xl font-black text-orange-500">🔥 {{ $user->current_streak }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-label text-gray-400">Punches</span>
                                <span class="text-xl font-black text-[var(--theme-primary)]">🐾 {{ $user->paw_points ?? 0 }}</span>
                            </div>
                        </div>
                    </x-card>

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

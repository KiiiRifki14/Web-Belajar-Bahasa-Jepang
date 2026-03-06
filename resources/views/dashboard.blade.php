<x-app-layout>
    <div class="py-8 relative" x-data="{ showWhisper: false }">

        <!-- Ambient background blobs -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden z-0" aria-hidden="true">
            <div class="absolute w-[700px] h-[700px] rounded-full opacity-[0.06]" style="background: radial-gradient(circle, #f27bb5, transparent); top: -15%; right: -10%; animation: floatOrb 20s ease-in-out infinite;"></div>
            <div class="absolute w-[500px] h-[500px] rounded-full opacity-[0.05]" style="background: radial-gradient(circle, #79a582, transparent); bottom: 0; left: -8%; animation: floatOrb 25s ease-in-out infinite reverse;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 relative z-10">

            <!-- ROW 1: Countdown · Theme · Mood · Whisper -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 animate-fadeInUp">

                <!-- JLPT Countdown -->
                <div class="manhua-card relative overflow-hidden group min-h-[140px] flex flex-col justify-center p-6"
                    style="background: rgba(12, 8, 28, 0.9) !important; border-color: rgba(255,255,255,0.1) !important;">
                    <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 16px 16px;"></div>
                    <div class="absolute top-0 right-0 w-40 h-40 rounded-full opacity-20 blur-3xl pointer-events-none" style="background: radial-gradient(circle, #f27bb5, transparent);"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-2 h-2 rounded-full bg-pink-400 animate-pulse"></span>
                            <span class="text-[9px] font-black uppercase tracking-[0.35em] text-pink-400">Next Station: JLPT N5</span>
                        </div>
                        <div class="font-mono font-black text-white tracking-widest flex items-baseline gap-2" style="font-size: clamp(2.2rem, 5vw, 3.2rem);">
                            {{ str_pad($daysToJLPT, 3, '0', STR_PAD_LEFT) }}
                            <span class="text-[9px] text-slate-500 font-sans font-bold tracking-[0.3em]">DAYS</span>
                        </div>
                        <div class="mt-3 text-[9px] font-bold uppercase tracking-widest text-slate-500">{{ $jlptMonth }} · 試験まで</div>
                    </div>
                </div>

                <!-- Theme Switcher -->
                <div class="manhua-card p-6 flex flex-col justify-center">
                    <span class="text-label text-slate-400 mb-4 block text-center">Aesthetic Theme</span>
                    <div class="grid grid-cols-3 gap-3">
                        @php
                        $themes = [
                        ['value' => 'senja', 'emoji' => '🌆', 'title' => 'Senja di Shinjuku', 'active' => 'ring-2 ring-orange-300 bg-orange-50'],
                        ['value' => 'perpustakaan', 'emoji' => '🎐', 'title' => 'Perpustakaan Tua', 'active' => 'ring-2 ring-yellow-300 bg-yellow-50'],
                        ['value' => 'neon', 'emoji' => '🌌', 'title' => 'Tokyo Malam', 'active' => 'ring-2 ring-violet-400 bg-violet-50'],
                        ];
                        @endphp
                        @foreach($themes as $theme)
                        <form action="{{ route('theme.update') }}" method="POST">
                            @csrf
                            <button type="submit" name="theme" value="{{ $theme['value'] }}" title="{{ $theme['title'] }}"
                                class="w-full h-14 rounded-2xl border flex items-center justify-center text-2xl transition-all duration-300 hover:scale-110 hover:-translate-y-1 shadow-sm {{ ($user->active_theme ?? '') === $theme['value'] ? $theme['active'] : 'border-white/60 bg-white/50 hover:bg-white/80' }}">
                                {{ $theme['emoji'] }}
                            </button>
                        </form>
                        @endforeach
                    </div>
                </div>

                <!-- Mood Tracker -->
                <div class="manhua-card p-6 flex flex-col justify-center">
                    <span class="text-label text-slate-400 mb-4 block text-center">Current Spirit</span>
                    <form action="{{ route('mood.update') }}" method="POST" class="flex justify-around items-center px-2">
                        @csrf
                        @php
                        $moods = [
                        ['val' => 'happy', 'emoji' => '😊'],
                        ['val' => 'neutral', 'emoji' => '😐'],
                        ['val' => 'sad', 'emoji' => '😢'],
                        ['val' => 'angry', 'emoji' => '💢'],
                        ];
                        @endphp
                        @foreach($moods as $m)
                        <button type="submit" name="mood" value="{{ $m['val'] }}"
                            class="text-3xl transition-all duration-300 hover:scale-125 rounded-2xl p-2 {{ $user->mood === $m['val'] ? 'scale-110 drop-shadow-md bg-white/50' : 'opacity-40 hover:opacity-100 grayscale hover:grayscale-0' }}">
                            {{ $m['emoji'] }}
                        </button>
                        @endforeach
                    </form>
                </div>

                <!-- Neko Whisper -->
                <div class="manhua-card p-6 relative overflow-hidden group cursor-pointer flex flex-col justify-center hover:shadow-glow"
                    @click="showWhisper = true">
                    <div class="absolute -right-3 -bottom-3 text-6xl opacity-10 group-hover:opacity-20 group-hover:rotate-12 transition-all duration-500 pointer-events-none">🐾</div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-lg">🐱</span>
                            <span class="text-label text-pink-500 tracking-[0.3em]">Whisper</span>
                        </div>
                        <p class="text-xs text-slate-500 font-serif italic leading-relaxed line-clamp-2">
                            "{{ $secretNote->content ?? 'Terus melangkah... setiap langkah mendekatkanmu ke Tokyo.' }}"
                        </p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-3">Tap untuk membaca</p>
                    </div>

                    <template x-if="showWhisper">
                        <div class="fixed inset-0 z-[100] flex items-center justify-center p-6 animate-fadeIn"
                            style="background: rgba(15,10,30,0.5); backdrop-filter: blur(8px);"
                            @click.self="showWhisper = false">
                            <div class="w-full max-w-md"
                                style="background: rgba(255,255,255,0.92); backdrop-filter: blur(30px); border: 1.5px solid rgba(255,255,255,0.9); border-radius: 2.5rem; box-shadow: 0 30px 80px rgba(0,0,0,0.15), 0 0 50px rgba(242,123,181,0.2);"
                                @click.stop>
                                <div class="p-10 text-center">
                                    <div class="text-6xl mb-6 animate-float-slow">🐱</div>
                                    <p class="text-[9px] font-black uppercase tracking-[0.4em] text-pink-500 mb-5">Neko-Sensei's Whisper</p>
                                    <p class="font-serif text-xl italic text-slate-700 leading-relaxed mb-8">
                                        "{{ $secretNote->content ?? 'Terus melangkah maju. Setiap kesalahan adalah guru terbaikmu.' }}"
                                    </p>
                                    <button @click="showWhisper = false"
                                        class="px-8 py-3.5 text-white font-black text-xs uppercase tracking-widest rounded-full transition-all hover:scale-105 active:scale-95"
                                        style="background: linear-gradient(135deg, #f27bb5, #c4497e); box-shadow: 0 6px 20px rgba(242,123,181,0.4);">
                                        Arigatou 🌸
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- ROW 2: Store Banner + Daily Reward -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 animate-fadeInUp delay-100">

                <a href="{{ route('store.index') }}" class="group block">
                    <div class="manhua-card p-1.5 bg-gradient-to-br from-amber-50/60 to-orange-50/40 border-amber-100/60">
                        <div class="h-full px-7 py-6 flex items-center justify-between gap-5 rounded-[2rem] bg-gradient-to-br from-white/40 to-transparent">
                            <div class="flex items-center gap-5">
                                <div class="w-16 h-16 shrink-0 rounded-2xl flex items-center justify-center text-4xl transition-all duration-500 group-hover:scale-110 group-hover:rotate-12"
                                    style="background: rgba(255,255,255,0.85); box-shadow: 0 4px 16px rgba(245,158,11,0.2); border: 1px solid rgba(255,255,255,0.9);">
                                    🏮
                                </div>
                                <div>
                                    <h3 class="font-serif text-2xl font-bold text-amber-900">Koban Ichiba</h3>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-amber-600 mt-1">Pasar Tradisional Desa</p>
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 group-hover:translate-x-1 shrink-0"
                                style="background: rgba(255,255,255,0.6);">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                @if($canClaimDaily)
                <div class="manhua-card p-1.5 border-pink-200/60" style="background: linear-gradient(135deg, rgba(252,231,241,0.7), rgba(240,247,241,0.6)) !important;">
                    <div class="h-full px-7 py-6 flex items-center justify-between gap-5 rounded-[2rem] bg-gradient-to-br from-white/40 to-transparent">
                        <div class="flex items-center gap-5">
                            <div class="w-16 h-16 shrink-0 rounded-2xl flex items-center justify-center text-4xl animate-float-slow"
                                style="background: rgba(255,255,255,0.85); box-shadow: 0 4px 16px rgba(242,123,181,0.25); border: 1px solid rgba(255,255,255,0.9);">
                                🎁
                            </div>
                            <div>
                                <h3 class="font-serif text-2xl font-bold text-slate-800">Daily Gift!</h3>
                                <p class="text-[10px] font-black uppercase tracking-widest text-pink-500 mt-1">Hadiah Harianmu Siap!</p>
                            </div>
                        </div>
                        <form action="{{ route('daily.claim') }}" method="POST">
                            @csrf
                            <button type="submit" class="shrink-0 px-6 py-3.5 text-white font-black text-xs uppercase tracking-widest rounded-full transition-all hover:-translate-y-1 active:scale-95"
                                style="background: linear-gradient(135deg, #f27bb5, #c4497e); box-shadow: 0 6px 20px rgba(242,123,181,0.4);">
                                Claim 50 🪙
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div class="manhua-card p-6 flex items-center gap-5 opacity-60">
                    <div class="w-16 h-16 shrink-0 rounded-2xl flex items-center justify-center text-4xl grayscale opacity-50"
                        style="background: rgba(255,255,255,0.5);">💮</div>
                    <div>
                        <h3 class="font-serif text-xl font-bold text-slate-500">Hadiah Sudah Diklaim</h3>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-1">Istirahatkan spiritmu. Kembali besok.</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- ROW 3: Quest Map + Sidebar -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-5 animate-fadeInUp delay-200">

                <!-- QUEST MAP -->
                <div class="lg:col-span-3 glass-panel relative p-6 sm:p-10 overflow-hidden" style="border-radius: 2.5rem;">
                    <div class="absolute top-0 right-0 w-72 h-72 rounded-full opacity-[0.12] pointer-events-none" style="background: radial-gradient(circle, #f27bb5, transparent); filter: blur(60px);"></div>
                    <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full opacity-[0.09] pointer-events-none" style="background: radial-gradient(circle, #79a582, transparent); filter: blur(60px);"></div>

                    <div class="relative z-10">
                        <div class="text-center mb-10">
                            <p class="text-label text-slate-400 tracking-[0.4em] mb-3">Select a village to continue</p>
                            <h2 class="font-serif text-4xl sm:text-5xl font-bold text-slate-800 drop-shadow-sm">The Quest Map</h2>
                        </div>

                        <div class="space-y-14">
                            @foreach($regions as $index => $region)
                            <div class="relative">
                                <!-- Arc label -->
                                <div class="flex items-center gap-4 mb-8 {{ $index % 2 === 0 ? '' : 'flex-row-reverse' }}">
                                    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-pink-200 to-transparent"></div>
                                    <div class="shrink-0 px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-widest text-pink-700 border border-pink-200/60"
                                        style="background: rgba(255,255,255,0.8); backdrop-filter: blur(12px); box-shadow: 0 2px 10px rgba(242,123,181,0.1);">
                                        Arc {{ $index + 1 }}: {{ $region->name }}
                                    </div>
                                    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-pink-200 to-transparent"></div>
                                </div>

                                <!-- Level nodes -->
                                <div class="grid grid-cols-4 sm:grid-cols-5 lg:grid-cols-6 gap-4 sm:gap-6 justify-items-center">
                                    @foreach($region->levels as $level)
                                    @php
                                    $status = $progress[$level->id] ?? 'locked';
                                    $isLocked = $status === 'locked';
                                    $isPassed = $status === 'passed';
                                    $isUnlocked = $status === 'unlocked';
                                    $isBoss = $level->is_boss_level;

                                    $nodeSize = $isBoss ? '76px' : '68px';
                                    $nodeBorderRadius = $isBoss ? '1.5rem' : '50%';
                                    $nodeStyle = "width:{$nodeSize}; height:{$nodeSize}; border-radius:{$nodeBorderRadius};";

                                    if ($isLocked) {
                                    $nodeStyle .= ' background:rgba(210,205,220,0.4); border:1px dashed rgba(180,170,195,0.5); box-shadow:none; opacity:0.5;';
                                    } elseif ($isPassed) {
                                    $nodeStyle .= ' background:rgba(255,255,255,0.9); border:2px solid rgba(121,165,130,0.6); box-shadow:0 4px 14px rgba(121,165,130,0.2);';
                                    } elseif ($isUnlocked) {
                                    $nodeStyle .= ' background:rgba(255,255,255,0.95); border:2px solid rgba(242,123,181,0.6); box-shadow:0 4px 20px rgba(242,123,181,0.3),0 0 0 6px rgba(242,123,181,0.1); animation:pulse-glow 3s ease-in-out infinite;';
                                    }

                                    if ($isBoss && !$isLocked) {
                                    $nodeStyle .= ' border:2px solid rgba(242,123,181,0.7); box-shadow:0 6px 24px rgba(242,123,181,0.35),0 0 0 6px rgba(242,123,181,0.12);';
                                    }
                                    @endphp

                                    <div class="flex flex-col items-center group relative">

                                        <a href="{{ $isLocked ? '#' : route('quiz.start', $level) }}"
                                            class="{{ $isLocked ? 'pointer-events-none' : '' }} relative flex items-center justify-center transition-all duration-300"
                                            <?php echo 'style="' . $nodeStyle . '"'; ?>>

                                            @if($isBoss)
                                            <span class="text-3xl {{ !$isLocked ? 'group-hover:scale-110 group-hover:drop-shadow-lg' : '' }} transition-transform duration-300">👹</span>
                                            @elseif($isPassed)
                                            <span class="text-2xl">🉐</span>
                                            @elseif($isUnlocked)
                                            <span class="text-lg font-black text-pink-600 font-sans">{{ $level->order }}</span>
                                            @else
                                            <span class="text-lg font-black text-slate-400 font-sans">{{ $level->order }}</span>
                                            @endif

                                            @if($isUnlocked)
                                            <div class="absolute inset-0 rounded-full border border-pink-400/30 animate-ping-slow pointer-events-none"></div>
                                            @endif

                                            @if($isLocked)
                                            <div class="absolute -top-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center text-[10px] bg-slate-300/80 shadow-sm">🔒</div>
                                            @elseif($isPassed)
                                            <div class="absolute -top-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center text-[10px] shadow-sm" style="background: rgba(121,165,130,0.9);">⭐</div>
                                            @endif

                                        </a>

                                        <span class="mt-3 text-[9px] font-bold uppercase tracking-wider text-center w-full truncate leading-tight transition-colors duration-200 {{ $isLocked ? 'text-slate-300' : 'text-slate-500 group-hover:text-pink-600' }}"
                                            style="max-width: 72px;">
                                            {{ $level->name }}
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDEBAR -->
                <div class="space-y-5">

                    <!-- Buku Kenangan -->
                    <a href="{{ route('album.index') }}" class="block group">
                        <div class="glass-panel p-6 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-glow" style="border-radius: 2rem;">
                            <div class="absolute -right-4 -bottom-4 text-8xl opacity-[0.08] group-hover:opacity-[0.14] group-hover:rotate-6 transition-all duration-500 blur-[1px] pointer-events-none">🖼️</div>
                            <h3 class="font-serif text-xl font-bold text-slate-800 mb-1">Buku Kenangan</h3>
                            <p class="text-label text-pink-500 tracking-[0.25em] mb-6">Memory Archive</p>
                            <div class="flex items-center gap-2 text-label text-slate-400 group-hover:text-pink-500 transition-colors">
                                View Gallery <span class="group-hover:translate-x-1 transition-transform inline-block">→</span>
                            </div>
                        </div>
                    </a>

                    <!-- Buku Hitam -->
                    <a href="{{ route('black_book.index') }}" class="block group">
                        <div class="relative overflow-hidden transition-all duration-300 hover:-translate-y-1 p-6"
                            style="background: rgba(12,8,28,0.88); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.07); border-radius: 2rem; box-shadow: 0 8px 30px rgba(0,0,0,0.2);">
                            <div class="absolute -right-4 -bottom-4 text-8xl opacity-[0.05] group-hover:opacity-[0.1] transition-all duration-500 blur-[1px] pointer-events-none">📜</div>
                            <h3 class="font-serif text-xl font-bold text-slate-100 mb-1">Buku Hitam</h3>
                            <p class="text-label text-slate-500 tracking-[0.25em] mb-5">Mistake Archive</p>
                            <div class="flex items-center justify-between mb-6 px-4 py-3 rounded-xl border border-white/5"
                                style="background: rgba(255,255,255,0.04);">
                                <span class="text-label text-slate-500">Target Belajar</span>
                                <span class="font-serif text-2xl font-black text-pink-400">{{ $user->blackBooks()->where('is_mastered', false)->count() }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-label text-slate-500 group-hover:text-pink-400 transition-colors">
                                Begin Rematch <span class="group-hover:translate-x-1 transition-transform inline-block">→</span>
                            </div>
                        </div>
                    </a>

                    <!-- Stats -->
                    <div class="glass-panel p-5 space-y-3" style="border-radius: 2rem;">
                        <div class="flex items-center justify-between px-4 py-3 rounded-2xl"
                            style="background: rgba(255,255,255,0.5); border: 1px solid rgba(255,255,255,0.7);">
                            <span class="text-label text-slate-400">Streak</span>
                            <span class="font-black text-lg text-orange-400">🔥 {{ $user->current_streak }}</span>
                        </div>
                        <div class="flex items-center justify-between px-4 py-3 rounded-2xl"
                            style="background: rgba(255,255,255,0.5); border: 1px solid rgba(255,255,255,0.7);">
                            <span class="text-label text-slate-400">Punches</span>
                            <span class="font-black text-lg text-pink-500">🐾 {{ $user->paw_points ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between px-4 py-3 rounded-2xl"
                            style="background: rgba(255,255,255,0.5); border: 1px solid rgba(255,255,255,0.7);">
                            <span class="text-label text-slate-400">Koban</span>
                            <span class="font-black text-lg text-amber-500">🪙 {{ number_format($user->koban ?? 0) }}</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

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

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 4px 20px rgba(242, 123, 181, 0.3), 0 0 0 6px rgba(242, 123, 181, 0.1);
            }

            50% {
                box-shadow: 0 4px 30px rgba(242, 123, 181, 0.5), 0 0 0 10px rgba(242, 123, 181, 0.15);
            }
        }
    </style>
</x-app-layout>
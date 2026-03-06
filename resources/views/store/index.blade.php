<x-app-layout>
    <div class="py-12 min-h-screen" x-data="{ 
        tab: 'powerups', 
        omikujiDrawing: false, 
        result: {{ session('omikuji_result') ? json_encode(session('omikuji_result')) : 'null' }}
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Store Header & Balance -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-16 gap-10">
                <div class="flex items-center group">
                    <div class="text-7xl mr-8 filter drop-shadow-2xl transition-transform group-hover:rotate-12 duration-500">🏮</div>
                    <div>
                        <h1 class="text-6xl font-black text-[var(--theme-text)] tracking-tighter uppercase italic leading-none">Koban Ichiba</h1>
                        <p class="text-[var(--theme-secondary)] font-bold uppercase tracking-[0.4em] text-[10px] mt-2">Traditional treasures for the modern student</p>
                    </div>
                </div>

                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-[var(--theme-primary)] to-[var(--theme-secondary)] rounded-3xl blur-xl opacity-20 group-hover:opacity-40 transition-opacity"></div>
                    <div class="bg-white dark:bg-gray-800 px-10 py-6 rounded-3xl flex items-center shadow-2xl relative z-10 manhua-outline">
                        <span class="text-4xl mr-4 animate-bounce">🪙</span>
                        <div>
                            <span class="block text-[10px] font-black uppercase text-gray-400 tracking-widest leading-none mb-1">Your Coins</span>
                            <span class="text-4xl font-black text-[var(--theme-text)] tabular-nums">{{ number_format($user->koban) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">

                <!-- Left Column: O-mikuji & Redemption -->
                <div class="space-y-12">

                    <!-- O-mikuji Shrine -->
                    <div class="bg-white dark:bg-gray-800 rounded-[3rem] p-10 text-center relative overflow-hidden shadow-2xl manhua-outline group">
                        <!-- Background Pattern -->
                        <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 20px 20px;"></div>

                        <div class="relative z-10">
                            <span class="px-4 py-1.5 bg-red-100 dark:bg-red-900/30 text-red-600 rounded-full text-[10px] font-black uppercase tracking-widest mb-6 inline-block">Fortune Shrine</span>
                            <h2 class="text-2xl font-black text-[var(--theme-text)] mb-8">Draw a Fortune</h2>

                            <!-- The Gacha Box Animation -->
                            <div class="relative py-12 flex justify-center h-48 items-center">
                                <div class="text-9xl transition-all duration-75 relative z-20" :class="omikujiDrawing ? 'animate-omikuji-shake' : 'hover:scale-110 cursor-pointer'">
                                    🔲
                                    <div class="absolute inset-0 flex items-center justify-center text-4xl mt-4">🎋</div>
                                </div>
                                <div x-show="omikujiDrawing" class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-32 h-32 bg-[var(--theme-primary)] rounded-full blur-3xl opacity-30 animate-pulse"></div>
                                </div>
                            </div>

                            <form action="{{ route('store.omikuji') }}" method="POST" @submit="omikujiDrawing = true">
                                @csrf
                                <button type="submit" :disabled="omikujiDrawing"
                                    class="w-full py-5 bg-[var(--theme-primary)] hover:bg-[var(--theme-secondary)] text-white font-black rounded-2xl shadow-lg transition-all active:scale-95 disabled:opacity-50 manhua-glow">
                                    <span x-show="!omikujiDrawing">Seek Destiny (100 🪙)</span>
                                    <span x-show="omikujiDrawing" class="flex items-center justify-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Shaking Destiny...
                                    </span>
                                </button>
                            </form>

                            <!-- Result Overlay -->
                            <div x-show="result" x-transition @click.away="result = null"
                                class="mt-10 p-6 bg-[var(--theme-bg)] rounded-3xl border-2 border-dashed border-[var(--theme-primary)] animate-fadeIn relative">
                                <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-white px-4 py-1 rounded-full shadow-md text-xs font-black uppercase tracking-widest text-[var(--theme-primary)]">Your Fate</div>
                                <div class="text-4xl mb-4" x-text="result.type === 'blessing' ? '✨' : '📜'"></div>
                                <h4 class="text-sm font-black text-[var(--theme-text)] italic leading-relaxed" x-text="result.message"></h4>
                                <button @click="result = null" class="mt-6 text-[10px] font-black uppercase tracking-widest opacity-30 hover:opacity-100 transition-opacity">Dismiss</button>
                            </div>
                        </div>
                    </div>

                    <!-- Mystery Gift -->
                    <div class="bg-[var(--theme-text)] p-10 rounded-[3rem] shadow-2xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-[var(--theme-primary)] opacity-10 blur-3xl"></div>
                        <h3 class="text-xl font-black text-white mb-6 flex items-center">
                            <span class="mr-4 text-2xl">🎁</span> Mystery Gift
                        </h3>
                        <form action="{{ route('store.redeem') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="text" name="code" placeholder="ENTER CODE"
                                class="w-full bg-white/5 border-2 border-white/10 rounded-2xl p-5 text-[var(--theme-primary)] font-mono font-black tracking-[0.4em] focus:border-[var(--theme-primary)] focus:ring-0 text-center uppercase transition-all">
                            <button type="submit" class="w-full py-4 bg-white text-[var(--theme-text)] font-black rounded-2xl transition-all hover:scale-[1.02] active:scale-95 shadow-xl">
                                Redeem
                            </button>
                        </form>
                    </div>

                </div>

                <!-- Right Column: Wooden Shelves -->
                <div class="lg:col-span-2">

                    <!-- Tab Switcher -->
                    <div class="flex items-center space-x-2 mb-10 p-2 bg-gray-100 dark:bg-gray-800 rounded-3xl w-fit">
                        <button @click="tab = 'powerups'" :class="tab === 'powerups' ? 'bg-white dark:bg-gray-700 shadow-md text-[var(--theme-text)]' : 'text-gray-400'" class="px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all">
                            ⚡ Power-ups
                        </button>
                        <button @click="tab = 'skins'" :class="tab === 'skins' ? 'bg-white dark:bg-gray-700 shadow-md text-[var(--theme-text)]' : 'text-gray-400'" class="px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all">
                            👘 Cosmetics
                        </button>
                    </div>

                    <!-- Shelf Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        @foreach($items as $item)
                        <div x-show="tab === '{{ $item->type === 'powerup' ? 'powerups' : 'skins' }}'"
                            x-transition
                            class="bg-white dark:bg-gray-800 p-8 rounded-[2.5rem] shadow-xl manhua-outline transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl group flex flex-col">

                            <div class="flex justify-between items-start mb-8">
                                <span class="text-[10px] font-black uppercase underline decoration-[var(--theme-primary)] decoration-4 underline-offset-4 tracking-widest">{{ $item->type }}</span>
                                <div class="w-16 h-16 bg-[var(--theme-bg)] rounded-3xl flex items-center justify-center text-3xl group-hover:rotate-12 transition-transform shadow-inner">
                                    @if($item->name === 'Streak Shield') 🛡️ @elseif($item->name === 'Kopi Begadang') ☕ @elseif($item->name === 'Baju Kantoran') 💼 @elseif($item->name === 'Baju Samurai') ⚔️ @elseif($item->name === 'Kimono Sakura') 🌸 @else 📦 @endif
                                </div>
                            </div>

                            <h4 class="text-2xl font-black text-[var(--theme-text)] mb-3 leading-tight">{{ $item->name }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-8 leading-relaxed flex-grow italic">"{{ $item->description }}"</p>

                            <form action="{{ route('store.purchase', $item) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex justify-between items-center bg-[var(--theme-bg)] border-2 border-[var(--theme-border)] hover:border-[var(--theme-primary)] p-5 rounded-2xl transition-all group-hover:shadow-lg">
                                    <span class="font-black text-xs uppercase tracking-widest opacity-60">Purchase</span>
                                    <span class="flex items-center text-[var(--theme-text)] font-black">
                                        <span class="mr-2 opacity-50 text-xl">🪙</span> {{ number_format($item->price) }}
                                    </span>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        @keyframes omikuji-shake {

            0%,
            100% {
                transform: rotate(0);
            }

            25% {
                transform: rotate(10deg);
            }

            75% {
                transform: rotate(-10deg);
            }
        }

        .animate-omikuji-shake {
            animation: omikuji-shake 0.1s infinite;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out forwards;
        }
    </style>
</x-app-layout>
<x-app-layout>
    <div class="py-12 bg-stone-50 dark:bg-zinc-950 min-h-screen" x-data="{ 
        tab: 'powerups', 
        showOmikuji: false, 
        omikujiDrawing: false, 
        result: {{ session('omikuji_result') ? json_encode(session('omikuji_result')) : 'null' }}
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Store Header & Balance -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
                <div class="flex items-center">
                    <div class="text-6xl mr-6 filter drop-shadow-lg">🏮</div>
                    <div>
                        <h1 class="text-4xl font-black text-stone-800 dark:text-stone-100 tracking-tighter uppercase italic">Koban Ichiba</h1>
                        <p class="text-stone-500 dark:text-stone-400 font-medium">Traditional treasures for the modern student.</p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-amber-400 to-orange-500 p-1 rounded-3xl shadow-xl shadow-orange-200 dark:shadow-none transition-transform hover:scale-105">
                    <div class="bg-white dark:bg-zinc-900 px-8 py-4 rounded-[1.4rem] flex items-center">
                        <span class="text-3xl mr-3">🪙</span>
                        <div>
                            <span class="block text-[10px] font-black uppercase text-amber-600 tracking-widest leading-none mb-1">Your Balance</span>
                            <span class="text-3xl font-black text-stone-800 dark:text-amber-400 tabular-nums">{{ number_format($user->koban) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

                <!-- Left Column: O-mikuji Shrine & Vouchers -->
                <div class="space-y-8">

                    <!-- O-mikuji Shrine -->
                    <div class="bg-red-50 dark:bg-red-950 border-4 border-red-200 dark:border-red-900 rounded-3xl p-8 text-center relative overflow-hidden shadow-lg group">
                        <div class="absolute -top-4 -right-4 text-8xl opacity-10 group-hover:rotate-12 transition-transform">⛩️</div>
                        <h2 class="text-2xl font-black text-red-800 dark:text-red-200 mb-2">O-mikuji Shrine</h2>
                        <p class="text-sm text-red-600 dark:text-red-400 mb-6 font-medium">Draw a fortune for 100 Koban.</p>

                        <div class="relative py-10">
                            <!-- Shaking Box Animation -->
                            <div class="text-7xl transition-all duration-300" :class="omikujiDrawing ? 'animate-shake' : ''">
                                🧧
                            </div>
                        </div>

                        <form action="{{ route('store.omikuji') }}" method="POST" @submit="omikujiDrawing = true">
                            @csrf
                            <button type="submit"
                                :disabled="omikujiDrawing"
                                class="w-full py-4 bg-red-600 hover:bg-red-700 text-white font-black rounded-2xl shadow-lg transition-all active:scale-95 disabled:opacity-50">
                                <span x-show="!omikujiDrawing">Draw Fortune 🎋</span>
                                <span x-show="omikujiDrawing">Praying... 🙏</span>
                            </button>
                        </form>

                        <!-- Result Modal (Inline Overlay) -->
                        <template x-if="result">
                            <div class="mt-6 p-4 bg-white dark:bg-zinc-900 rounded-2xl border-2 border-red-200 animate-fadeIn">
                                <div class="text-3xl mb-2" x-text="result.type === 'blessing' ? '✨' : '📜'"></div>
                                <p class="text-sm font-bold text-stone-800 dark:text-stone-200 italic" x-text="result.message"></p>
                                <button @click="result = null" class="mt-4 text-xs font-black text-red-600 uppercase tracking-widest hover:underline">Close</button>
                            </div>
                        </template>
                    </div>

                    <!-- Voucher Redemption -->
                    <div class="bg-stone-800 p-8 rounded-3xl shadow-2xl border-t-8 border-amber-400">
                        <h3 class="text-xl font-black text-white mb-4 flex items-center">
                            <span class="mr-2">🎁</span> Mystery Gift
                        </h3>
                        <form action="{{ route('store.redeem') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="text" name="code" placeholder="ENTER CODE HERE..."
                                class="w-full bg-stone-700 border-none rounded-xl p-4 text-amber-400 font-mono font-bold tracking-widest focus:ring-2 focus:ring-amber-400 text-center uppercase">
                            <button type="submit" class="w-full py-3 bg-amber-400 hover:bg-amber-500 text-stone-900 font-black rounded-xl transition-all active:scale-95">
                                Redeem Gift
                            </button>
                        </form>
                    </div>

                </div>

                <!-- Right Column: Wooden Shelves (The Shop) -->
                <div class="lg:col-span-2">

                    <!-- Tabs -->
                    <div class="flex space-x-4 mb-8">
                        <button @click="tab = 'powerups'" :class="tab === 'powerups' ? 'bg-stone-800 text-white' : 'bg-transparent text-stone-400 hover:text-stone-800'" class="px-6 py-2 rounded-full font-black text-sm transition-all uppercase tracking-widest">
                            ⚡ Power-ups
                        </button>
                        <button @click="tab = 'skins'" :class="tab === 'skins' ? 'bg-stone-800 text-white' : 'bg-transparent text-stone-400 hover:text-stone-800'" class="px-6 py-2 rounded-full font-black text-sm transition-all uppercase tracking-widest">
                            👘 Cosmetics
                        </button>
                    </div>

                    <!-- Shelf Grid -->
                    <div class="bg-[#dcc7a1] dark:bg-stone-900 p-10 rounded-[3rem] shadow-inner grid grid-cols-1 md:grid-cols-2 gap-10 relative">
                        <!-- Decorative Wood Texture Lines -->
                        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: repeating-linear-gradient(0deg, #000, #000 1px, transparent 1px, transparent 150px);"></div>

                        @foreach($items as $item)
                        <div x-show="tab === '{{ $item->type === 'powerup' ? 'powerups' : 'skins' }}'"
                            class="bg-stone-50 dark:bg-zinc-800 p-6 rounded-3xl shadow-xl transition-all hover:-translate-y-2 hover:shadow-2xl border-b-8 border-stone-200 dark:border-stone-700 relative group">

                            <div class="absolute top-4 right-4 bg-amber-100 dark:bg-amber-900 px-3 py-1 rounded-full text-[10px] font-black text-amber-700 dark:text-amber-200 uppercase tracking-widest">
                                {{ $item->type }}
                            </div>

                            <div class="w-full aspect-square bg-stone-200 dark:bg-zinc-700 rounded-2xl mb-6 flex items-center justify-center text-6xl group-hover:scale-110 transition-transform">
                                @if($item->name === 'Streak Shield') 🛡️ @elseif($item->name === 'Kopi Begadang') ☕ @elseif($item->name === 'Baju Kantoran') 💼 @elseif($item->name === 'Baju Samurai') ⚔️ @elseif($item->name === 'Kimono Sakura') 🌸 @else 📦 @endif
                            </div>

                            <h4 class="text-xl font-black text-stone-800 dark:text-stone-100 mb-2">{{ $item->name }}</h4>
                            <p class="text-xs text-stone-500 dark:text-stone-400 mb-6 leading-relaxed">{{ $item->description }}</p>

                            <form action="{{ route('store.purchase', $item) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex justify-between items-center bg-stone-800 hover:bg-indigo-600 text-white p-4 rounded-2xl transition-all group-hover:shadow-lg shadow-stone-400 dark:shadow-none">
                                    <span class="font-black">Purchase</span>
                                    <span class="flex items-center text-amber-400">
                                        <span class="mr-2">🪙</span> {{ number_format($item->price) }}
                                    </span>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Success/Error Alerts -->
            @if(session('success'))
            <div class="fixed bottom-10 right-10 p-6 bg-indigo-600 text-white rounded-3xl shadow-2xl animate-bounce flex items-center font-black">
                <span class="text-3xl mr-4">🐱✨</span>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="fixed bottom-10 right-10 p-6 bg-red-600 text-white rounded-3xl shadow-2xl flex items-center font-black">
                <span class="text-3xl mr-4">😿</span>
                {{ session('error') }}
            </div>
            @endif

        </div>
    </div>

    <style>
        @keyframes shake {
            0% {
                transform: rotate(0) translate(0);
            }

            20% {
                transform: rotate(5deg) translate(5px);
            }

            40% {
                transform: rotate(-5deg) translate(-5px);
            }

            60% {
                transform: rotate(3deg) translate(3px);
            }

            80% {
                transform: rotate(-3deg) translate(-3px);
            }

            100% {
                transform: rotate(0) translate(0);
            }
        }

        .animate-shake {
            animation: shake 0.3s infinite;
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
<x-app-layout>
    {{--
        Koban Ichiba (Toko Desa) - Nihongo Odyssey
        Tempat membeli Power-ups, Kosmetik, dan menarik O-mikuji.
        Desain: Rak Kayu Jepang Estetik.
    --}}
    <div class="py-12" x-data="{ showOmikuji: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Toko: Menampilkan Saldo Koban -->
            <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h1 class="text-5xl font-black text-[var(--theme-text)] tracking-tighter uppercase italic leading-none">Koban Ichiba</h1>
                    <p class="text-xs text-gray-400 mt-4 uppercase tracking-[0.4em] font-bold">Pasar Tradisional Desa Odyssey</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-[2rem] shadow-xl manhua-outline flex flex-col items-center min-w-[180px]">
                    <span class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1">Dompet Anda</span>
                    <div class="text-3xl font-black text-amber-500 flex items-center">
                        <span class="mr-2">🪙</span> {{ number_format($user->koban) }}
                    </div>
                </div>
            </div>

            <!-- Bagian Atas: O-mikuji & Voucher -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Portal O-mikuji -->
                <div class="md:col-span-2 bg-gradient-to-br from-red-50 to-orange-50 dark:from-red-950 dark:to-orange-950 p-10 rounded-[3rem] manhua-outline relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 text-[12rem] opacity-5 group-hover:rotate-12 transition-transform">⛩️</div>
                    <div class="relative z-10">
                        <h3 class="text-3xl font-black text-red-800 dark:text-red-200 mb-2">O-mikuji Shrine</h3>
                        <p class="text-sm text-red-600 dark:text-red-300 opacity-70 mb-8 max-w-sm">Tarik ramalan hari ini untuk mendapatkan nasihat atau keberuntungan ekstra.</p>
                        <button @click="showOmikuji = true" class="px-8 py-4 bg-red-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:scale-105 transition-transform manhua-glow">
                            Tarik Ramalan (100 🪙)
                        </button>
                    </div>
                </div>

                <!-- Penukaran Kode Voucher -->
                <div class="bg-white dark:bg-gray-800 p-10 rounded-[3rem] manhua-outline">
                    <h3 class="text-xl font-black text-[var(--theme-text)] mb-2 italic">Misi Rahasia?</h3>
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-black mb-6 leading-relaxed">Masukkan kode untuk menukar kado misterius</p>
                    <form action="{{ route('redeem') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="text" name="code" placeholder="KODE-ODYSSEY" class="w-full bg-gray-50 dark:bg-gray-900 border-2 border-[var(--theme-border)] p-4 rounded-xl text-center font-black tracking-widest outline-none focus:border-[var(--theme-primary)] transition-all">
                        <button type="submit" class="w-full py-4 bg-[var(--theme-primary)] text-white rounded-xl font-black text-[10px] uppercase tracking-widest shadow-lg">Klaim Kado</button>
                    </form>
                </div>
            </div>

            <!-- Rak Item: Power-ups & Skin Mascot -->
            <h2 class="text-2xl font-black text-[var(--theme-text)] mb-8 uppercase tracking-widest italic border-l-8 border-[var(--theme-primary)] pl-6">Rak Barang Dagangan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($items as $item)
                <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-xl overflow-hidden manhua-outline group flex flex-col">
                    <div class="h-48 bg-stone-50 dark:bg-gray-900 flex items-center justify-center relative group-hover:bg-stone-100 transition-colors">
                        <span class="text-7xl group-hover:scale-110 transition-transform duration-500">
                            @if($item->type === 'powerup') ⚡ @elseif($item->type === 'skin') 👘 @else 🎁 @endif
                        </span>
                        <div class="absolute top-4 right-4 bg-white/80 dark:bg-gray-800/80 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest text-[var(--theme-primary)] manhua-outline decoration-none">
                            {{ $item->type }}
                        </div>
                    </div>
                    <div class="p-8 flex flex-col flex-grow">
                        <h3 class="text-xl font-black text-[var(--theme-text)] mb-1">{{ $item->name }}</h3>
                        <p class="text-xs text-gray-400 mb-6 flex-grow leading-relaxed italic">"{{ $item->description }}"</p>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="text-2xl font-black text-amber-500">
                                <span class="text-sm mr-1">🪙</span> {{ number_format($item->price) }}
                            </div>
                            <form action="{{ route('purchase', $item) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-[var(--theme-secondary)] text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest shadow-lg hover:bg-[var(--theme-primary)] transition-all active:scale-95">
                                    Beli
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Pop-up O-mikuji (Eksklusif: Animasi Box Guncang) -->
        <template x-if="showOmikuji">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                <div class="bg-white dark:bg-gray-800 p-12 rounded-[3.5rem] max-w-lg w-full shadow-2xl relative manhua-outline text-center" @click.away="showOmikuji = false">

                    @if(session('omikuji_result'))
                    <!-- Hasil Ramalan -->
                    <div class="animate-fadeIn">
                        <span class="text-xs font-black uppercase tracking-[0.5em] text-red-400 mb-8 block">Hasil Ramalan Anda</span>
                        <div class="text-6xl mb-8">📜</div>
                        <h4 class="text-2xl font-serif italic text-[var(--theme-text)] leading-relaxed mb-10">
                            "{{ session('omikuji_result')['message'] }}"
                        </h4>
                        <button @click="showOmikuji = false" class="px-8 py-3 bg-red-600 text-white rounded-full font-black text-[10px] uppercase tracking-widest shadow-lg">Arigatou</button>
                    </div>
                    @else
                    <!-- Box Guncang Sebelum Tarik -->
                    <div x-data="{ shaking: false }">
                        <h3 class="text-2xl font-black mb-10 italic">Guncang Kotak Ramalan</h3>
                        <div class="text-8xl inline-block mb-10" :class="shaking ? 'animate-shake' : ''">🎍</div>
                        <div class="flex flex-col gap-4">
                            <form action="{{ route('omikuji.draw') }}" method="POST" @submit="shaking = true">
                                @csrf
                                <button type="submit" class="w-full py-4 bg-red-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl">
                                    TARIK SEKARANG!
                                </button>
                            </form>
                            <button @click="showOmikuji = false" class="text-xs font-black text-gray-400 uppercase tracking-widest">Batal</button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </template>
    </div>

    <!-- Animasi Box Guncang -->
    <style>
        @keyframes shake {
            0% {
                transform: rotate(0deg);
            }

            20% {
                transform: rotate(15deg);
            }

            40% {
                transform: rotate(-15deg);
            }

            60% {
                transform: rotate(15deg);
            }

            80% {
                transform: rotate(-15deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        .animate-shake {
            animation: shake 0.4s infinite;
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</x-app-layout>
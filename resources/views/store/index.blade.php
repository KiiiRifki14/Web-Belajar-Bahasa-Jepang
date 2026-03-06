<x-app-layout>
    {{--
        Koban Ichiba (Toko Desa) - Nihongo Odyssey
        Tempat membeli Power-ups, Kosmetik, dan menarik O-mikuji.
        Desain: Rak Kayu Jepang Estetik.
    --}}
    <div class="py-12 min-h-screen bg-transparent relative" x-data="{ showOmikuji: {{ session('omikuji_result') ? 'true' : 'false' }} }">
        <!-- Magical ambient backdrop -->
        <div class="absolute top-20 right-10 w-96 h-96 bg-amber-300 opacity-20 blur-[100px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-sakura-300 opacity-20 blur-[100px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">

            <!-- Header Toko: Menampilkan Saldo Koban -->
            <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h1 class="font-serif text-5xl font-bold text-gray-800 italic drop-shadow-sm">Koban Ichiba</h1>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-amber-600 mt-4">Pasar Tradisional Desa Odyssey</p>
                </div>
                <div class="glass-panel p-6 flex flex-col items-center min-w-[200px] shadow-glass-sm" style="border-radius: 2rem;">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-2">Dompet Anda</span>
                    <div class="text-4xl font-black text-amber-500 flex items-center filter drop-shadow-sm">
                        <span class="mr-3 animate-float-slow">🪙</span> {{ number_format($user->koban) }}
                    </div>
                </div>
            </div>

            <!-- Bagian Atas: O-mikuji & Voucher -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Portal O-mikuji -->
                <div class="md:col-span-2 glass-panel p-10 rounded-[3rem] relative overflow-hidden group shadow-glow border-red-200/50 bg-gradient-to-br from-white/60 to-red-50/40">
                    <div class="absolute -right-6 -bottom-6 text-[14rem] opacity-20 filter blur-[4px] group-hover:rotate-12 transition-transform duration-700 pointer-events-none">⛩️</div>
                    <div class="relative z-10 flex flex-col h-full justify-center">
                        <h3 class="font-serif text-3xl font-bold text-red-800 mb-3 drop-shadow-sm">O-mikuji Shrine</h3>
                        <p class="text-sm text-red-700/80 mb-8 max-w-sm font-medium">Tarik ramalan hari ini untuk mendapatkan nasihat atau keberuntungan ekstra.</p>
                        <button @click="showOmikuji = true" class="w-max px-8 py-4 bg-gradient-to-r from-red-400 to-orange-400 hover:from-red-500 hover:to-orange-500 text-white font-bold rounded-full shadow-glow transition-all duration-300 hover:scale-[1.02] active:scale-95 text-sm uppercase tracking-widest">
                            Tarik Ramalan (100 🪙)
                        </button>
                    </div>
                </div>

                <!-- Penukaran Kode Voucher -->
                <div class="glass-panel p-8 rounded-[3rem] shadow-glass-sm flex flex-col justify-center border-white/60">
                    <h3 class="font-serif text-2xl font-bold text-gray-800 italic mb-2">Misi Rahasia?</h3>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-8">Tukar kode rahasia</p>
                    <form action="{{ route('store.redeem') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="text" name="code" placeholder="KODE-ODYSSEY" class="w-full bg-white/50 backdrop-blur-sm border-2 border-white/60 p-4 rounded-2xl text-center font-black tracking-widest outline-none focus:border-sakura-400 focus:bg-white/80 transition-all text-gray-800 placeholder-gray-400 shadow-inner">
                        <button type="submit" class="w-full py-4 bg-white/70 hover:bg-white text-sakura-600 font-bold border border-sakura-200 hover:border-sakura-400 rounded-2xl shadow-sm transition-all duration-300 tracking-widest uppercase text-xs">Klaim Kado</button>
                    </form>
                </div>
            </div>

            <!-- Rak Item: Power-ups & Skin Mascot -->
            <div class="mb-8">
                <h2 class="font-serif text-3xl font-bold text-gray-800">Rak Barang Dagangan</h2>
                <p class="text-[10px] uppercase font-bold tracking-widest text-gray-500 mt-2">Power-ups & Kosmetik</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($items as $item)
                <div class="glass-panel p-6 overflow-hidden hover:scale-[1.02] hover:shadow-glow transition-all duration-300 flex flex-col group border-white/60" style="border-radius: 2rem;">
                    <div class="h-48 bg-white/30 backdrop-blur-sm shadow-inner rounded-3xl flex items-center justify-center relative group-hover:bg-white/50 transition-colors -m-2 mb-6 border border-white/40">
                        <span class="text-7xl group-hover:scale-110 transition-transform duration-500 filter drop-shadow-md animate-float-slow">
                            @if($item->type === 'powerup') ⚡ @elseif($item->type === 'skin') 👘 @else 🎁 @endif
                        </span>
                        <div class="absolute top-4 right-4 bg-white/80 backdrop-blur-md border border-white/60 px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest text-gray-600 shadow-sm">
                            {{ $item->type }}
                        </div>
                    </div>
                    <div class="flex flex-col flex-grow px-2">
                        <h3 class="font-serif text-xl font-bold text-gray-800 mb-2">{{ $item->name }}</h3>
                        <p class="text-xs text-gray-500 mb-6 flex-grow italic leading-relaxed">"{{ $item->description }}"</p>

                        <div class="flex items-center justify-between mt-auto bg-gray-50/50 p-4 rounded-2xl border border-gray-100/50 backdrop-blur-sm">
                            <div class="text-2xl font-black text-amber-500 filter drop-shadow-sm flex items-center">
                                <span class="text-sm mr-2 opacity-80">🪙</span> {{ number_format($item->price) }}
                            </div>
                            <form action="{{ route('store.purchase', $item) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-sakura-400 to-matcha-400 hover:from-sakura-500 hover:to-matcha-500 text-white font-bold rounded-xl shadow-glow transition-all duration-300 hover:-translate-y-1 active:scale-95 text-xs uppercase tracking-widest">Beli</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Pop-up O-mikuji (Eksklusif: Animasi Box Guncang) -->
        <div x-show="showOmikuji" x-cloak class="fixed inset-0 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md" style="z-index: 999;">
            <div class="glass-panel shadow-2xl max-w-lg w-full relative text-center border-white/60 p-10 overflow-hidden" style="border-radius: 3.5rem;" @click.away="if('{{ session('omikuji_result') ? 'true' : 'false' }}' == 'false') showOmikuji = false">
                <!-- Decor inside modal -->
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-red-300 opacity-20 blur-[50px] rounded-full pointer-events-none"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-orange-300 opacity-20 blur-[50px] rounded-full pointer-events-none"></div>

                @if(session('omikuji_result'))
                <!-- Hasil Ramalan -->
                <div class="animate-fadeIn relative z-10 py-4">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-red-500 mb-8 block">Hasil Ramalan Anda</span>
                    <div class="text-7xl mb-10 filter drop-shadow-md">📜</div>
                    <h4 class="font-serif text-2xl font-bold italic text-slate-800 leading-relaxed mb-12">
                        "{{ session('omikuji_result')['message'] ?? 'Peruntungan yang baik menanti Anda.' }}"
                    </h4>
                    <button @click="showOmikuji = false" class="px-10 py-4 bg-gradient-to-r from-red-400 to-orange-400 hover:from-red-500 hover:to-orange-500 text-white font-bold rounded-full shadow-glow transition-all duration-300 hover:-translate-y-1 active:scale-95 text-sm uppercase tracking-widest">Arigatou</button>
                </div>
                @else
                <!-- Box Guncang Sebelum Tarik -->
                <div x-data="{ shaking: false }" class="relative z-10 py-4 flex flex-col items-center gap-10">
                    <div>
                        <h3 class="font-serif text-3xl font-bold text-slate-800 mb-2 italic">Guncang Kotak Ramalan</h3>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Tarik peruntunganmu hari ini</p>
                    </div>

                    <div class="text-[8rem] filter drop-shadow-xl" :class="shaking ? 'animate-shake' : 'animate-float-slow'">🎍</div>

                    <div class="flex flex-col gap-4 w-full max-w-xs mx-auto">
                        <form action="{{ route('store.omikuji') }}" method="POST" @submit="shaking = true; $el.submit()">
                            @csrf
                            <button type="submit" class="w-full py-5 bg-gradient-to-r from-red-400 to-orange-400 hover:from-red-500 hover:to-orange-500 text-white font-bold rounded-full shadow-[0_0_20px_rgba(240,100,100,0.4)] transition-all duration-300 hover:-translate-y-1 active:scale-95 text-lg uppercase tracking-widest flex items-center justify-center">
                                <span class="mr-2">⛩️</span> TARIK SEKARANG!
                            </button>
                        </form>
                        <button @click="showOmikuji = false" class="py-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-colors w-full">Batal</button>
                    </div>
                </div>
                @endif
            </div>
        </div>
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
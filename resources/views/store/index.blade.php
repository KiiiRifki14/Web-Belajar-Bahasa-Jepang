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
                    <h1 class="text-display text-[var(--theme-text)] uppercase italic">Koban Ichiba</h1>
                    <p class="text-label text-gray-400 mt-4">Pasar Tradisional Desa Odyssey</p>
                </div>
                <x-card class="flex flex-col items-center min-w-[180px]">
                    <span class="text-label text-gray-400 mb-1">Dompet Anda</span>
                    <div class="text-3xl font-black text-amber-500 flex items-center">
                        <span class="mr-2">🪙</span> {{ number_format($user->koban) }}
                    </div>
                </x-card>
            </div>

            <!-- Bagian Atas: O-mikuji & Voucher -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-section mb-16">
                <!-- Portal O-mikuji -->
                <div class="md:col-span-2 bg-gradient-to-br from-red-50 to-orange-50 dark:from-red-950 dark:to-orange-950 p-section rounded-[3rem] manhua-outline relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 text-[12rem] opacity-5 group-hover:rotate-12 transition-transform">⛩️</div>
                    <div class="relative z-10">
                        <h3 class="text-heading text-red-800 dark:text-red-200 mb-3">O-mikuji Shrine</h3>
                        <p class="text-body text-red-600 dark:text-red-300 opacity-70 mb-8 max-w-sm">Tarik ramalan hari ini untuk mendapatkan nasihat atau keberuntungan ekstra.</p>
                        <x-btn-primary @click="showOmikuji = true" class="hover:scale-105">
                            Tarik Ramalan (100 🪙)
                        </x-btn-primary>
                    </div>
                </div>

                <!-- Penukaran Kode Voucher -->
                <x-card>
                    <h3 class="text-subheading text-[var(--theme-text)] italic">Misi Rahasia?</h3>
                    <p class="text-caption text-gray-400 mb-6">Masukkan kode untuk menukar kado misterius</p>
                    <form action="{{ route('store.redeem') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="text" name="code" placeholder="KODE-ODYSSEY" class="w-full bg-gray-50 dark:bg-gray-900 border-2 border-[var(--theme-border)] p-4 rounded-xl text-center font-black tracking-widest outline-none focus:border-[var(--theme-primary)] transition-all">
                        <x-btn-primary type="submit" class="w-full">Klaim Kado</x-btn-primary>
                    </form>
                </x-card>
            </div>

            <!-- Rak Item: Power-ups & Skin Mascot -->
            <x-section-heading title="Rak Barang Dagangan" subtitle="Power-ups & Kosmetik"/>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-section">
                @foreach($items as $item)
                <x-card class="overflow-hidden hover:scale-105 transition-transform">
                    <div class="h-48 bg-stone-50 dark:bg-gray-900 flex items-center justify-center relative group-hover:bg-stone-100 transition-colors -m-6 mb-6">
                        <span class="text-7xl group-hover:scale-110 transition-transform duration-500">
                            @if($item->type === 'powerup') ⚡ @elseif($item->type === 'skin') 👘 @else 🎁 @endif
                        </span>
                        <div class="absolute top-4 right-4 bg-white/80 dark:bg-gray-800/80 px-3 py-1 rounded-full text-caption text-[var(--theme-primary)]">
                            {{ $item->type }}
                        </div>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <h3 class="text-subheading text-[var(--theme-text)] mb-1">{{ $item->name }}</h3>
                        <p class="text-small text-gray-400 mb-6 flex-grow italic">"{{ $item->description }}"</p>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="text-2xl font-black text-amber-500">
                                <span class="text-sm mr-1">🪙</span> {{ number_format($item->price) }}
                            </div>
                            <form action="{{ route('store.purchase', $item) }}" method="POST">
                                @csrf
                                <x-btn-secondary type="submit" size="md">Beli</x-btn-secondary>
                            </form>
                        </div>
                    </div>
                </x-card>
                @endforeach
            </div>
        </div>

        <!-- Pop-up O-mikuji (Eksklusif: Animasi Box Guncang) -->
        <template x-if="showOmikuji">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                <x-card class="max-w-lg w-full shadow-2xl relative text-center" style="border-radius: 3.5rem;" @click.away="showOmikuji = false">

                    @if(session('omikuji_result'))
                    <!-- Hasil Ramalan -->
                    <div class="animate-fadeIn">
                        <span class="text-label text-[var(--theme-primary)] mb-8 block">Hasil Ramalan Anda</span>
                        <div class="text-6xl mb-8">📜</div>
                        <h4 class="text-heading font-serif italic text-[var(--theme-text)] leading-relaxed mb-10">
                            "{{ session('omikuji_result')['message'] }}"
                        </h4>
                        <x-btn-primary @click="showOmikuji = false" class="rounded-full">Arigatou</x-btn-primary>
                    </div>
                    @else
                    <!-- Box Guncang Sebelum Tarik -->
                    <div x-data="{ shaking: false }">
                        <h3 class="text-heading mb-10 italic">Guncang Kotak Ramalan</h3>
                        <div class="text-8xl inline-block mb-10" :class="shaking ? 'animate-shake' : ''">🎍</div>
                        <div class="flex flex-col gap-4">
                            <form action="{{ route('store.omikuji') }}" method="POST" @submit="shaking = true">
                                @csrf
                                <x-btn-primary type="submit" class="w-full">TARIK SEKARANG!</x-btn-primary>
                            </form>
                            <button @click="showOmikuji = false" class="text-caption text-gray-400">Batal</button>
                        </div>
                    </div>
                    @endif
                </x-card>
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

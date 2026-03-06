<x-app-layout>
    {{--
        Buku Kenangan (Memory Album) - Nihongo Odyssey
        Menyimpan pencapaian kuis Boss Level dalam format polaroid estetik.
    --}}
    <div class="py-12 bg-transparent min-h-screen relative">
        <!-- Magical ambient backdrop -->
        <div class="absolute top-20 right-10 w-96 h-96 bg-sakura-300 opacity-20 blur-[100px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-20 left-10 w-96 h-96 bg-matcha-300 opacity-20 blur-[100px] rounded-full pointer-events-none"></div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">

            <!-- Header Galeri -->
            <div class="text-center mb-16 relative">
                <span class="text-[10px] font-bold uppercase tracking-[0.6em] text-sakura-600 mb-4 block animate-pulse">Your Legends</span>
                <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none">
                    <span class="text-[170px] font-serif font-black tracking-tighter uppercase italic filter blur-[1px]">Memories</span>
                </div>
                <h1 class="text-5xl font-serif font-bold text-gray-800 tracking-tighter uppercase italic relative z-10 drop-shadow-sm">Buku Kenangan</h1>
                <p class="text-gray-500 font-bold uppercase tracking-[0.3em] text-xs mt-3 relative z-10">Digital Remembrance of the Odyssey</p>
            </div>

            @if($memories->isEmpty())
            <div class="glass-panel rounded-[3rem] p-20 text-center shadow-glass-sm border-white/60 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-b from-white/40 to-transparent pointer-events-none"></div>
                <div class="text-[8rem] mb-8 grayscale opacity-30 filter drop-shadow-md animate-float-slow">💮</div>
                <h3 class="font-serif text-3xl font-bold text-gray-500 relative z-10">The pages are still blank.</h3>
                <p class="mt-4 text-[10px] font-bold uppercase tracking-widest text-gray-400 max-w-md mx-auto relative z-10">Complete Boss Levels to capture special moments and fill your album with memories.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                @foreach($memories as $memory)
                <div class="group relative glass-panel p-4 rounded-[2rem] shadow-glass-sm transition-all duration-500 hover:-rotate-2 hover:scale-[1.02] hover:shadow-glow border border-white/60">
                    <!-- Polaroid Aesthetic -->
                    <div class="overflow-hidden rounded-[1.5rem] aspect-[4/5] bg-white/50 relative shadow-inner">
                        <img src="{{ asset('storage/' . $memory->image_path) }}"
                            alt="Boss Level Memory"
                            class="w-full h-full object-cover grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-1000 mix-blend-multiply">

                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 via-transparent to-transparent flex items-end p-6 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            <span class="text-white font-mono text-[10px] tracking-[0.2em] uppercase font-bold drop-shadow-md">Captured: {{ $memory->earned_at->format('Y.m.d') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 px-4 text-center pb-4">
                        <h4 class="text-[10px] font-bold uppercase tracking-[0.2em] text-sakura-500 mb-2">Arc {{ $loop->iteration }}: {{ $memory->level->region->name }}</h4>
                        <h3 class="text-xl font-serif font-bold italic text-gray-800 mt-1">"The Fall of {{ $memory->level->name }}"</h3>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -top-4 -right-4 w-12 h-12 bg-gradient-to-br from-sakura-300 to-sakura-400 rounded-full flex items-center justify-center text-xl shadow-md transform rotate-12 group-hover:rotate-0 group-hover:scale-110 transition-transform duration-500 text-white border-2 border-white">🌸</div>
                </div>
                @endforeach
            </div>
            @endif

            <div class="mt-20 text-center relative z-10">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-[10px] font-bold uppercase tracking-[0.3em] text-gray-500 hover:text-sakura-600 transition-colors group bg-white/50 backdrop-blur-sm px-6 py-3 rounded-full shadow-sm border border-white/60 hover:shadow-md">
                    <span class="mr-3 transition-transform duration-300 group-hover:-translate-x-2">←</span> Return to the Village
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
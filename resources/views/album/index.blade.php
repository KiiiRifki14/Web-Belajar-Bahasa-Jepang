<x-app-layout>
    <div class="py-12 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center mb-16 relative">
                <div class="absolute inset-0 flex items-center justify-center opacity-5 pointer-events-none">
                    <span class="text-[170px] font-black tracking-tighter uppercase italic">Memories</span>
                </div>
                <h1 class="text-5xl font-black text-[var(--theme-text)] tracking-tighter uppercase italic relative z-10">Buku Kenangan</h1>
                <p class="text-[var(--theme-secondary)] font-bold uppercase tracking-[0.3em] text-xs mt-2 relative z-10">Digital Remembrance of the Odyssey</p>
            </div>

            @if($memories->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-[3rem] p-20 text-center manhua-outline manhua-glow">
                <div class="text-8xl mb-8 grayscale opacity-20">💮</div>
                <h3 class="text-3xl font-black text-gray-400">The pages are still blank.</h3>
                <p class="mt-4 text-gray-500 max-w-md mx-auto">Complete Boss Levels to capture special moments and fill your album with memories.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($memories as $memory)
                <div class="group relative bg-white dark:bg-gray-800 p-4 rounded-3xl shadow-xl transition-all duration-500 hover:-rotate-2 hover:scale-105 manhua-outline">
                    <!-- Polaroid Aesthetic -->
                    <div class="overflow-hidden rounded-2xl aspect-[4/5] bg-gray-100 relative">
                        <img src="{{ asset('storage/' . $memory->image_path) }}"
                            alt="Boss Level Memory"
                            class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000">

                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-6 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="text-white font-mono text-[10px] tracking-widest uppercase">Captured on: {{ $memory->earned_at->format('Y.m.d') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 px-2 text-center pb-4">
                        <h4 class="text-xs font-black uppercase tracking-[0.2em] text-[var(--theme-secondary)] mb-1">Arc {{ $loop->iteration }}: {{ $memory->level->region->name }}</h4>
                        <h3 class="text-xl font-serif font-black italic text-[var(--theme-text)]">"The Fall of {{ $memory->level->name }}"</h3>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -top-4 -right-4 w-12 h-12 bg-[var(--theme-primary)] rounded-full flex items-center justify-center text-xl shadow-lg rotate-12 group-hover:rotate-0 transition-transform">🌸</div>
                </div>
                @endforeach
            </div>
            @endif

            <div class="mt-20 text-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs font-black uppercase tracking-[0.3em] text-gray-400 hover:text-[var(--theme-primary)] transition-colors group">
                    <span class="mr-3 transition-transform group-hover:-translate-x-2">←</span> Return to the Village
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
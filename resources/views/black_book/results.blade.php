<x-app-layout>
    <div class="py-12 bg-transparent min-h-screen text-slate-200 flex items-center justify-center relative">
        <!-- Occult ambient backdrop -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-900 opacity-30 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-10 left-10 w-[400px] h-[400px] bg-slate-800 opacity-40 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-md w-full mx-auto sm:px-6 lg:px-8 text-center relative z-10">

            <div class="glass-panel shadow-glow rounded-[3rem] p-12 border border-slate-700/50 bg-slate-900/60 relative overflow-visible mt-10">
                <div class="absolute -top-12 left-1/2 -translate-x-1/2 text-7xl bg-slate-800 w-28 h-28 rounded-full flex items-center justify-center border-4 border-slate-700 shadow-glow animate-float-slow">
                    📜
                </div>

                <h1 class="text-4xl font-serif font-bold italic text-slate-100 mt-10 drop-shadow-sm">Sesi Berakhir</h1>
                <p class="text-slate-500 uppercase font-bold tracking-[0.3em] text-[10px] mt-3 mb-10">Session Summary</p>

                <div class="grid grid-cols-2 gap-6 mb-12">
                    <div class="bg-slate-800/40 p-6 rounded-3xl border border-slate-700/30">
                        <span class="block text-[8px] uppercase font-bold tracking-widest text-slate-500 mb-2">Corrected</span>
                        <span class="text-4xl font-serif font-black text-emerald-400 drop-shadow-sm">{{ $correct }}</span>
                    </div>
                    <div class="bg-slate-800/40 p-6 rounded-3xl border border-slate-700/30">
                        <span class="block text-[8px] uppercase font-bold tracking-widest text-slate-500 mb-2">Total Review</span>
                        <span class="text-4xl font-serif font-black text-slate-300">{{ $total }}</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <a href="{{ route('black_book.index') }}" class="block w-full py-5 bg-slate-200 hover:bg-white text-slate-900 font-bold uppercase tracking-widest text-[10px] transition-all duration-300 rounded-full shadow-glow hover:scale-[1.02] active:scale-95">
                        Return to Archive
                    </a>
                    <a href="{{ route('dashboard') }}" class="block w-full py-5 border-2 border-slate-700 text-slate-400 hover:text-slate-200 hover:border-slate-500 hover:bg-slate-800/50 font-bold uppercase tracking-widest text-[10px] transition-all duration-300 rounded-full hover:scale-[1.02] active:scale-95">
                        Back to Village
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
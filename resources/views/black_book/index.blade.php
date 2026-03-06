<x-app-layout>
    {{--
        Buku Hitam (Review System) - Nihongo Odyssey
        Menampilkan daftar kesalahan yang pernah dibuat user untuk dipelajari kembali.
    --}}
    <div class="py-12 bg-transparent min-h-screen text-slate-200 relative">
        <!-- Occult/Mysterious ambient backdrop -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-slate-800 opacity-40 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-10 left-10 w-[400px] h-[400px] bg-indigo-900 opacity-30 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">

            <!-- Header: Estetika Perpustakaan Tua -->
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 border-b border-slate-700/50 pb-8">
                <div class="relative">
                    <div class="absolute -left-4 -top-4 text-7xl opacity-5 blur-[2px] pointer-events-none text-slate-100">📖</div>
                    <h1 class="text-6xl font-serif font-bold italic tracking-tighter text-slate-100 drop-shadow-md">Buku Hitam</h1>
                    <p class="text-slate-400 uppercase font-black tracking-[0.4em] text-[10px] mt-3 drop-shadow-sm">Arsip Pengetahuan Yang Terlupakan</p>
                </div>
                <div class="mt-8 md:mt-0 text-right glass-panel px-8 py-4 rounded-[2rem] border-slate-700/50 bg-slate-800/40 shadow-glass-sm tooltip-trigger group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-slate-600/10 to-transparent -translate-x-[150%] animate-shimmer"></div>
                    <span class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Total Entri Belum Dikuasai</span>
                    <span class="text-5xl font-serif font-black text-slate-200 group-hover:text-white transition-colors">{{ count($mistakes) }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">

                <!-- Sidebar Informasi: Aturan Penguasaan (Mastery) -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="glass-panel p-8 rounded-[2rem] shadow-glow border-l-4 border-l-slate-400 border-slate-700/50 bg-slate-900/60 transition-transform duration-500 hover:-translate-y-1">
                        <h3 class="font-serif text-2xl mb-4 italic text-slate-100 drop-shadow-sm">Jalan Menuju<br>Penguasaan</h3>
                        <p class="text-xs leading-relaxed text-slate-400 font-medium">
                            Kesalahan adalah anak tangga menuju sukses. Untuk menghapus nama dari buku ini, Anda harus menjawab benar <span class="font-bold text-slate-200">3 kali berturut-turut</span> dalam sesi Balas Dendam.
                        </p>
                        <form action="{{ route('black_book.start') }}" method="POST" class="mt-8">
                            @csrf
                            <button type="submit" class="w-full py-4 bg-slate-200 hover:bg-white text-slate-900 font-black uppercase text-[10px] tracking-widest transition-all rounded-xl shadow-glow active:scale-95 group relative overflow-hidden">
                                <span class="relative z-10 flex items-center justify-center">
                                    <span class="mr-2 group-hover:rotate-12 transition-transform">⚔️</span> Mulai Balas Dendam
                                </span>
                            </button>
                        </form>
                    </div>

                    <div class="glass-panel p-6 border-slate-700/50 bg-slate-800/30 rounded-2xl">
                        <p class="text-[10px] uppercase font-bold tracking-widest leading-relaxed text-slate-500 italic text-center">
                            "Seseorang yang melakukan kesalahan dan tidak memperbaikinya, sebenarnya sedang melakukan kesalahan lain."
                            <br><br><span class="text-slate-400 not-italic">— Confucius</span>
                        </p>
                    </div>
                </div>

                <!-- Daftar Soal yang Belum Dikuasai (Unmastered) -->
                <div class="lg:col-span-3">
                    @if($mistakes->isEmpty())
                    <div class="glass-panel bg-slate-900/40 p-24 text-center rounded-[3rem] border border-dashed border-slate-600/50 relative overflow-hidden">
                        <div class="text-[8rem] mb-8 opacity-20 filter drop-shadow-md animate-float-slow grayscale">📜</div>
                        <h3 class="text-3xl font-serif font-bold italic text-slate-300 relative z-10">Arsip Anda Kosong</h3>
                        <p class="mt-4 text-[10px] font-bold uppercase tracking-widest text-slate-500 relative z-10">Semua kesalahan telah dikuasai.<br>Anda telah mencapai kejernihan pikiran.</p>
                    </div>
                    @else
                    <div class="space-y-6">
                        @foreach($mistakes as $mistake)
                        <div class="glass-panel p-6 rounded-[2rem] flex flex-col md:flex-row justify-between items-center transition-all duration-300 hover:bg-slate-800/60 hover:-translate-y-1 hover:shadow-glow border border-slate-700/50 group relative overflow-hidden bg-slate-900/50">
                            <!-- Subtle left border accent -->
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-slate-600/50 group-hover:bg-slate-400 transition-colors"></div>

                            <div class="flex-1 pl-4">
                                <div class="flex items-center space-x-4 mb-3">
                                    <span class="px-3 py-1 bg-slate-800 rounded-full text-[10px] font-bold uppercase tracking-widest text-slate-300 border border-slate-700">Arc {{ $mistake->question->level->name }}</span>
                                    <span class="text-[10px] uppercase font-bold tracking-widest text-slate-500">Tercatat {{ $mistake->updated_at->diffForHumans() }}</span>
                                </div>
                                <h4 class="text-lg font-serif text-slate-200 group-hover:text-white transition-colors italic pr-6 leading-relaxed">
                                    "{{ Str::limit($mistake->question->question_text, 120) }}"
                                </h4>
                            </div>
                            <div class="mt-6 md:mt-0 flex items-center space-x-10 pr-4 pl-4 md:border-l md:border-slate-700/50">
                                <div class="text-center">
                                    <span class="block text-[10px] uppercase font-bold tracking-widest text-slate-500 mb-1">Total Salah</span>
                                    <span class="text-2xl font-serif font-black text-rose-400/80">{{ $mistake->wrong_count }}</span>
                                </div>
                                <div class="text-center min-w-[100px]">
                                    <span class="block text-[10px] uppercase font-bold tracking-widest text-slate-500 mb-2">Progress Lulus</span>
                                    <div class="flex space-x-2 justify-center">
                                        @for($i=1; $i<=3; $i++)
                                            <div class="w-3 h-3 rounded-full transition-all duration-500 {{ $mistake->correct_streak >= $i ? 'bg-slate-300 shadow-glow scale-110' : 'bg-slate-800 border border-slate-700' }}">
                                    </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    </div>
    </div>
</x-app-layout>
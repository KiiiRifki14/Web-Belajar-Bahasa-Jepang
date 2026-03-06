<x-app-layout>
    {{--
        Buku Hitam (Review System) - Nihongo Odyssey
        Menampilkan daftar kesalahan yang pernah dibuat user untuk dipelajari kembali.
    --}}
    <div class="py-12 bg-[#1a120b] min-h-screen text-[#d5cea3]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header: Estetika Perpustakaan Tua -->
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 border-b-2 border-[#3c2a21] pb-8">
                <div>
                    <h1 class="text-5xl font-serif font-bold italic tracking-tighter text-[#e5e5cb]">Buku Hitam</h1>
                    <p class="text-[#3c2a21] uppercase font-black tracking-[0.3em] text-xs mt-2">Arsip pengetahuan yang terlupakan</p>
                </div>
                <div class="mt-6 md:mt-0 text-right">
                    <span class="block text-xs font-bold uppercase tracking-widest text-[#3c2a21]">Total Kesalahan</span>
                    <span class="text-4xl font-serif font-black text-[#e5e5cb]">{{ count($mistakes) }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">

                <!-- Sidebar Informasi: Aturan Penguasaan (Mastery) -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-[#3c2a21] p-8 rounded-sm shadow-2xl border-l-4 border-[#d5cea3]">
                        <h3 class="font-serif text-xl mb-4 italic text-[#e5e5cb]">Jalan Menuju Penguasaan</h3>
                        <p class="text-sm leading-relaxed opacity-80">
                            Kesalahan adalah anak tangga menuju sukses. Untuk menghapus nama dari buku ini, Anda harus menjawab benar <span class="font-bold text-[#e5e5cb]">3 kali berturut-turut</span> dalam sesi Balas Dendam.
                        </p>
                        <form action="{{ route('black_book.start') }}" method="POST" class="mt-8">
                            @csrf
                            <button type="submit" class="w-full py-4 bg-[#d5cea3] hover:bg-[#e5e5cb] text-[#1a120b] font-black uppercase tracking-widest transition-all rounded-sm shadow-lg active:scale-95">
                                Mulai Balas Dendam ⚔️
                            </button>
                        </form>
                    </div>

                    <div class="p-6 border border-[#3c2a21] opacity-40">
                        <p class="text-[10px] font-mono leading-tight">
                            "Seseorang yang melakukan kesalahan dan tidak memperbaikinya, sebenarnya sedang melakukan kesalahan lain." — Confucius
                        </p>
                    </div>
                </div>

                <!-- Daftar Soal yang Belum Dikuasai (Unmastered) -->
                <div class="lg:col-span-3">
                    @if($mistakes->isEmpty())
                    <div class="bg-[#3c2a21] bg-opacity-30 p-20 text-center rounded-sm border-2 border-dashed border-[#3c2a21]">
                        <div class="text-6xl mb-6 opacity-20">📜</div>
                        <h3 class="text-2xl font-serif italic text-[#e5e5cb]">Arsip Anda Kosong</h3>
                        <p class="mt-2 text-sm text-[#d5cea3]/60">Semua kesalahan telah dikuasai. Anda telah mencapai kejernihan pikiran.</p>
                    </div>
                    @else
                    <div class="space-y-4">
                        @foreach($mistakes as $mistake)
                        <div class="bg-[#3c2a21] p-6 rounded-sm flex flex-col md:flex-row justify-between items-center transition-all hover:bg-[#4d3428] border-b-2 border-[#1a120b] group">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <span class="px-2 py-0.5 bg-[#1a120b] text-[10px] font-black uppercase tracking-tighter">Level {{ $mistake->question->level->name }}</span>
                                    <span class="text-xs font-mono opacity-50 italic">Tercatat {{ $mistake->updated_at->diffForHumans() }}</span>
                                </div>
                                <h4 class="text-lg font-serif text-[#e5e5cb] group-hover:pl-2 transition-all italic">
                                    "{{ Str::limit($mistake->question->question_text, 100) }}"
                                </h4>
                            </div>
                            <div class="mt-4 md:mt-0 flex items-center space-x-8">
                                <div class="text-center">
                                    <span class="block text-[8px] uppercase font-black opacity-40">Total Salah</span>
                                    <span class="text-xl font-serif font-black">{{ $mistake->wrong_count }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-[8px] uppercase font-black opacity-40">Progress Lulus</span>
                                    <div class="flex space-x-1 mt-1">
                                        @for($i=1; $i<=3; $i++)
                                            <div class="w-3 h-3 rounded-full {{ $mistake->correct_streak >= $i ? 'bg-[#d5cea3] shadow-[0_0_5px_#d5cea3]' : 'bg-[#1a120b]' }}">
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
</x-app-layout>
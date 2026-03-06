<x-app-layout>
    {{--
        Antarmuka Quiz Engine - Nihongo Odyssey
        Layout: Split Screen (Visual Hint di kiri, Kuis Interaktif di kanan).
        Mendukung Neko-Punch Lifeline dan Mood Difficulty.
    --}}
    <div class="min-h-screen flex flex-col md:flex-row overflow-hidden bg-transparent">

        <!-- Sisi Kiri: Visual Hint & Story Context (50% di Desktop) -->
        <div class="w-full md:w-1/2 h-[40vh] md:h-screen relative flex items-center justify-center p-8 border-b md:border-b-0 md:border-r border-white/20">
            <!-- Decorative backdrop -->
            <div class="absolute inset-0 bg-gradient-to-br from-sakura-300/10 to-matcha-300/10 z-0 pointer-events-none"></div>

            <div class="relative z-10 w-full max-w-lg">
                @if($question->visual_hint_path)
                <!-- Visual Hint Image: Hanya tampil jika ada gambar -->
                <div class="glass-panel p-2 shadow-glow group overflow-hidden mb-12" style="border-radius: 2rem;">
                    <img src="{{ asset('storage/' . $question->visual_hint_path) }}" class="w-full aspect-video object-cover rounded-[1.5rem] transition-transform group-hover:scale-105 duration-1000" alt="Visual Hint">
                </div>
                <!-- Neko-Sensei Reflection Box khusus gambar -->
                <div class="glass-panel p-6 shadow-glass-sm relative group" style="border-radius: 2rem;">
                    <div class="absolute -top-10 -left-6 text-6xl transform group-hover:-rotate-12 transition-transform duration-500 animate-float-slow filter drop-shadow-md z-20">🐱</div>
                    <div class="absolute -top-4 left-6 w-4 h-4 bg-white/60 rotate-45 border-l border-t border-white/40"></div>
                    <p class="text-sm font-serif italic text-slate-700 leading-relaxed pl-6">
                        "Amati gambar di atas dengan seksama. Bahasa Jepang bukan hanya soal kata, tapi juga rasa dan nuansa."
                    </p>
                </div>
                @else
                <!-- Tampilan Default jika tidak ada gambar -->
                <div class="flex flex-col items-center justify-center text-center">
                    <div class="text-[120px] filter drop-shadow-xl animate-float-slow mb-6">🐱</div>
                    <div class="glass-panel p-6 shadow-glass-sm relative group w-full" style="border-radius: 2rem;">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-6 h-6 bg-white/60 rotate-45 border-l border-t border-white/40"></div>
                        <p class="text-base font-serif italic text-slate-700 leading-relaxed font-semibold">
                            "Fokus, muridku! Perhatikan pertanyaan di sebelah kanan. Jawaban yang benar selalu berada di antara pilihan yang ada."
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Sisi Kanan: Panel Kuis Interaktif -->
        <div class="w-full md:w-1/2 h-[60vh] md:h-screen overflow-y-auto flex items-center justify-center p-6 md:p-12 relative">
            @php
            $progress = count($quiz['questions']) > 0 ? ($currentIndex / count($quiz['questions'])) * 100 : 0;
            @endphp
            <div class="w-full max-w-xl glass-panel p-8 md:p-12 shadow-2xl relative z-10" x-data="{ progress: {{ $progress }}, selected: null, punch: {{ session('neko_punch') ? 'true' : 'false' }} }" style="border-radius: 3rem;">
                <!-- Progress Bar: Indikator sejauh mana kuis berlangsung -->
                <div class="mb-10 w-full bg-slate-200 h-2 rounded-full overflow-hidden shadow-inner backdrop-blur-sm"
                    :style="{ '--progress': progress + '%' }">
                    <div class="h-full transition-all duration-700 ease-out bg-gradient-to-r from-sakura-400 to-matcha-400 shadow-[0_0_10px_rgba(242,123,181,0.5)]"
                        style="width: var(--progress);"></div>
                </div>

                <!-- Answer Feedback Animation -->
                @if(session('correct'))
                <div class="mb-6 animate-[bounce_0.5s_ease-in-out_2] flex justify-center items-center text-green-500 bg-green-50/80 px-4 py-2 rounded-2xl border border-green-200">
                    <span class="text-3xl mr-2">✨</span>
                    <span class="font-bold text-sm uppercase tracking-widest">{{ session('correct') }}</span>
                </div>
                @endif

                @if(session('wrong'))
                <div class="mb-6 animate-[shake_0.4s_ease-in-out_1] flex justify-center items-center text-red-500 bg-red-50/80 px-4 py-2 rounded-2xl border border-red-200">
                    <span class="text-3xl mr-2">💢</span>
                    <span class="font-bold text-sm uppercase tracking-widest">{{ session('wrong') }}</span>
                </div>
                @endif

                <!-- Judul Pertanyaan -->
                <div class="mb-10 text-center">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-sakura-600 mb-4 block">Arc {{ $level->order }}: {{ $level->name }}</span>
                    <h2 class="font-serif text-3xl md:text-4xl font-bold text-slate-800 leading-tight">
                        {{ $question->question_text }}
                    </h2>
                </div>

                <!-- Form Jawaban: Mendukung Pilihan Ganda & Isian -->
                <form action="{{ route('quiz.answer') }}" method="POST" class="space-y-8">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->id }}">

                    @if($question->type === 'multiple_choice')
                    <div class="grid grid-cols-1 gap-4">
                        @php
                        // Identifikasi index dari jawaban-jawaban yang salah
                        $wrongIndices = [];
                        foreach($question->options as $idx => $opt) {
                        if(trim(strtolower($opt)) !== trim(strtolower($question->correct_answer))) {
                        $wrongIndices[] = $idx;
                        }
                        }
                        // Pilih hanya SATU jawaban salah untuk dihapus oleh Neko-Punch
                        $targetHideIndex = count($wrongIndices) > 0 ? $wrongIndices[0] : -1;
                        @endphp
                        @foreach($question->options as $key => $option)
                        @php
                        // Sembunyikan hanya 1 opsi salah yang menjadi target
                        $shouldHide = ($loop->index === $targetHideIndex);
                        @endphp
                        <label
                            x-show="!punch || (punch && !{{ $shouldHide ? 'true' : 'false' }})"
                            x-cloak
                            class="relative flex items-center p-5 rounded-[1.5rem] border-2 cursor-pointer transition-all duration-300 transform hover:scale-[1.02] bg-white/40 backdrop-blur-sm group"
                            :class="selected === '{{ $option }}' ? 'border-sakura-400 bg-sakura-50/60 shadow-glow' : 'border-white/40 hover:border-sakura-300 hover:bg-white/60 hover:shadow-glass-sm'">

                            <input type="radio" name="answer" value="{{ $option }}" class="hidden" @change="selected = '{{ $option }}'" required>

                            <div class="w-6 h-6 rounded-full border-2 mr-4 flex items-center justify-center transition-colors"
                                :class="selected === '{{ $option }}' ? 'border-sakura-500' : 'border-gray-300'">
                                <div class="w-3 h-3 rounded-full bg-sakura-500 scale-0 transition-transform duration-300"
                                    :class="selected === '{{ $option }}' ? 'scale-100' : ''"></div>
                            </div>

                            <span class="flex-grow font-bold text-gray-800 text-lg transition-colors"
                                :class="selected === '{{ $option }}' ? 'text-sakura-900' : ''">
                                {{ $option }}
                            </span>
                            <span class="text-[10px] uppercase tracking-widest font-bold opacity-0 group-hover:opacity-40 transition-opacity"
                                :class="selected === '{{ $option }}' ? 'text-sakura-600 opacity-100' : 'text-gray-500'">Select</span>
                        </label>
                        @endforeach
                    </div>
                    @else
                    <!-- Tipe Fill-in (Isian Singkat) -->
                    <div class="relative group">
                        <input type="text" name="answer" placeholder="Tulis jawaban romaji..."
                            class="w-full bg-white/40 backdrop-blur-md border border-white/60 focus:border-sakura-400 focus:bg-white/60 focus:ring-4 focus:ring-sakura-200/50 rounded-[2rem] text-center text-2xl font-black py-6 outline-none transition-all duration-300 shadow-glass-sm placeholder-gray-400 text-gray-800"
                            required autocomplete="off">
                        <div class="absolute -bottom-6 left-0 right-0 text-center text-[10px] uppercase font-bold tracking-widest text-gray-400 opacity-70">Gunakan huruf Romaji sesuai instruksi</div>
                    </div>
                    @endif

                    <!-- Tombol Aksi: Neko-Punch & Kirim -->
                    <div class="pt-8 flex items-center justify-between gap-4">
                        <!-- Neko-Punch Lifeline PROTECTION: Cek paw_points dan session -->
                        @if($question->type === 'multiple_choice')
                        <button type="submit" formnovalidate formaction="{{ route('quiz.paw') }}"
                            class="relative w-16 h-16 rounded-[1.5rem] flex items-center justify-center transition-all duration-300 {{ ($user->paw_points <= 0 || session('neko_punch')) ? 'bg-gray-100/50 opacity-40 cursor-not-allowed border border-gray-200' : 'bg-matcha-50/80 backdrop-blur-sm border border-matcha-300 shadow-glass-sm hover:shadow-glow hover:scale-105 active:scale-95 group' }}"
                            title="Neko-Punch: Eliminasi opsi salah"
                            {{ ($user->paw_points <= 0 || session('neko_punch')) ? 'disabled' : '' }}>

                            <span class="text-3xl filter group-hover:drop-shadow-md transition-all">🐾</span>

                            <!-- Remaining charge -->
                            <div class="absolute -top-2 -right-2 bg-sakura-500 text-white text-[9px] font-black w-6 h-6 rounded-full flex items-center justify-center shadow-md">
                                {{ $user->paw_points }}
                            </div>

                            @if(!($user->paw_points <= 0 || session('neko_punch')))
                                <div class="absolute inset-0 rounded-[1.5rem] border border-matcha-400/30 animate-ping opacity-0 group-hover:opacity-100">
                    </div>
                    @endif
                    </button>
                    @endif

                    <button type="submit" class="flex-grow px-8 py-5 rounded-[1.5rem] bg-gradient-to-r from-sakura-400 to-matcha-400 hover:from-sakura-500 hover:to-matcha-500 text-white font-bold text-lg shadow-glow hover:shadow-lg transition-all duration-300 hover:scale-[1.02] active:scale-95 text-center tracking-wide group overflow-hidden relative">
                        <span class="relative z-10 flex items-center justify-center">
                            Kirim Jawaban
                            <span class="ml-2 opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all">»</span>
                        </span>
                        <!-- Shimmer effect overlay -->
                        <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/30 to-transparent group-hover:animate-[shimmer_1.5s_infinite]"></div>
                    </button>
            </div>
            </form>
        </div>

        <!-- Stats Mengambang: Streak & Koban -->
        <div class="absolute top-6 right-6 flex items-center gap-4 glass-panel p-3 px-5 rounded-full shadow-glass-sm border-white/40">
            <div class="flex items-center text-xs font-black text-gray-700">
                <span class="text-orange-400 mr-2 filter drop-shadow-sm text-base">🔥</span> {{ $user->current_streak }}
            </div>
            <div class="w-px h-4 bg-gray-300/50 mx-2"></div>
            <div class="flex items-center text-xs font-black text-gray-700">
                <span class="text-amber-500 mr-2 filter drop-shadow-sm text-base">🪙</span> {{ number_format($user->koban) }}
            </div>
        </div>
    </div>
    </div>

    <!-- Gaya Kustom Manhua & Feedback -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        .manhua-glow-hover:hover {
            box-shadow: 0 0 25px rgba(236, 72, 153, 0.4);
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-5px);
            }

            40%,
            80% {
                transform: translateX(5px);
            }
        }
    </style>
</x-app-layout>
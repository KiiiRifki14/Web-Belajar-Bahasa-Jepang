<x-app-layout>
    {{--
        Antarmuka Quiz Engine - Nihongo Odyssey
        Layout: Split Screen (Visual Hint di kiri, Kuis Interaktif di kanan).
        Mendukung Neko-Punch Lifeline dan Mood Difficulty.
    --}}
    <div class="min-h-screen flex flex-col md:flex-row overflow-hidden bg-white dark:bg-gray-900">

        <!-- Sisi Kiri: Visual Hint & Story Context (50% di Desktop) -->
        <div class="w-full md:w-1/2 h-[40vh] md:h-screen relative bg-stone-100 dark:bg-gray-800 flex items-center justify-center p-8 border-r-2" style="border-color: var(--theme-border);">
            <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/papyros.png');"></div>

            <div class="relative z-10 w-full max-w-lg">
                <!-- Visual Hint Image: Gambar petunjuk soal -->
                <div class="bg-white dark:bg-gray-700 p-2 rounded-2xl shadow-2xl manhua-outline group overflow-hidden">
                    @if($question->visual_hint_path)
                    <img src="{{ asset('storage/' . $question->visual_hint_path) }}" class="w-full aspect-video object-cover rounded-xl transition-transform group-hover:scale-110 duration-700" alt="Visual Hint">
                    @else
                    <!-- Tampilan default jika tidak ada gambar -->
                    <div class="w-full aspect-video bg-gradient-to-br from-indigo-50 to-pink-50 dark:from-indigo-950 dark:from-gray-900 flex items-center justify-center text-6xl">
                        ⛩️
                    </div>
                    @endif
                </div>

                <!-- Neko-Sensei Reflection Box: Pesan motivasi -->
                <div class="bg-white dark:bg-gray-800 backdrop-blur-md p-6 manhua-outline relative mt-8" style="background-color: rgba(255, 255, 255, 0.8); border-radius: 2rem;">
                    <div class="absolute -top-6 -left-6 text-4xl transform -rotate-12">🐱</div>
                    <p class="text-sm font-serif italic text-[var(--theme-text)] leading-relaxed">
                        "Amati gambar di atas dengan seksama. Bahasa Jepang bukan hanya soal kata, tapi juga rasa dan nuansa."
                    </p>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan: Panel Kuis Interaktif -->
        <div class="w-full md:w-1/2 h-[60vh] md:h-screen overflow-y-auto flex items-center justify-center p-6 md:p-12 relative">
            @php
            $progress = count($quiz['questions']) > 0 ? ($currentIndex / count($quiz['questions'])) * 100 : 0;
            @endphp
            <div class="w-full max-w-md" x-data="{ progress: {{ $progress }}, selected: null, punch: {{ session('neko_punch') ? 'true' : 'false' }} }">
                <!-- Progress Bar: Indikator sejauh mana kuis berlangsung -->
                <div class="mb-10 w-full bg-gray-100 dark:bg-gray-800 h-1.5 rounded-full overflow-hidden"
                    :style="{ '--progress': progress + '%' }">
                    <div class="h-full transition-all duration-500"
                        style="background-color: var(--theme-primary); width: var(--progress);"></div>
                </div>

                <!-- Judul Pertanyaan -->
                <div class="mb-12">
                    <span class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-400 mb-2 block">Level {{ $level->order }}: {{ $level->name }}</span>
                    <h2 class="text-3xl font-black leading-tight tracking-tighter" style="color: var(--theme-text);">
                        {{ $question->question_text }}
                    </h2>
                </div>

                <!-- Form Jawaban: Mendukung Pilihan Ganda & Isian -->
                <form action="{{ route('quiz.answer') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->id }}">

                    @if($question->type === 'multiple_choice')
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($question->options as $key => $option)
                        @php
                        $isWrong = ($option !== $question->correct_answer);
                        // Sembunyikan opsi salah hanya jika punch aktif DAN ini bukan opsi pertama (untuk keamanan UI)
                        $shouldHide = $isWrong && $loop->index > 0;
                        @endphp
                        <label
                            x-show="!punch || (punch && !{{ $shouldHide ? 'true' : 'false' }})"
                            x-cloak
                            class="relative flex items-center p-5 rounded-2xl border-2 cursor-pointer transition-all hover:translate-x-2 bg-transparent group"
                            :style="selected === '{{ $option }}' ? 'border-color: var(--theme-primary); background-color: rgba(var(--theme-primary-rgb), 0.05);' : 'border-color: var(--theme-border);'"
                            :class="selected === '{{ $option }}' ? 'manhua-glow' : ''">

                            <input type="radio" name="answer" value="{{ $option }}" class="hidden" @change="selected = '{{ $option }}'" required>

                            <span class="flex-grow font-bold text-[var(--theme-text)]">{{ $option }}</span>
                            <span class="text-xs opacity-0 group-hover:opacity-30 transition-opacity">Pilih</span>
                        </label>
                        @endforeach
                    </div>
                    @else
                    <!-- Tipe Fill-in (Isian Singkat) -->
                    <div class="relative group">
                        <input type="text" name="answer" placeholder="Tulis jawaban di sini..."
                            class="w-full bg-transparent border-b-4 border-[var(--theme-border)] focus:border-[var(--theme-primary)] text-2xl font-black py-4 outline-none transition-colors"
                            required autocomplete="off">
                        <div class="mt-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Gunakan huruf Romaji sesuai instruksi</div>
                    </div>
                    @endif

                    <!-- Tombol Aksi: Neko-Punch & Kirim -->
                    <div class="pt-10 flex items-center justify-between gap-6">
                        <!-- Neko-Punch Lifeline PROTECTION: Cek paw_points dan session -->
                        @if($question->type === 'multiple_choice')
                        <button type="submit" formaction="{{ route('quiz.use_paw') }}"
                            class="w-16 h-16 rounded-2xl flex items-center justify-center transition-all bg-indigo-50 dark:bg-indigo-900 border-2 border-indigo-200 dark:border-indigo-700 group hover:scale-110 {{ ($user->paw_points <= 0 || session('neko_punch')) ? 'opacity-20 pointer-events-none' : '' }}"
                            title="Neko-Punch: Eliminasi opsi salah">
                            <span class="text-3xl filter" style="filter: drop-shadow(0 0 8px rgba(99, 102, 241, 0.6));">🐾</span>
                            <div class="absolute -top-2 -right-2 bg-indigo-600 text-white text-[8px] font-black w-5 h-5 rounded-full flex items-center justify-center">
                                {{ $user->paw_points }}
                            </div>
                        </button>
                        @endif

                        <button type="submit" class="flex-grow text-white py-5 font-black text-xs uppercase tracking-[0.3em] shadow-xl hover:-translate-y-1 transition-all manhua-glow-hover active:scale-95" style="background-color: var(--theme-text); border-radius: 2rem;">
                            Kirim Jawaban
                        </button>
                    </div>
                </form>
            </div>

            <!-- Stats Mengambang: Streak & Koban -->
            <div class="absolute top-6 right-6 flex items-center gap-4 bg-white/50 dark:bg-gray-800/50 p-3 rounded-full backdrop-blur-sm border border-white/20">
                <div class="flex items-center text-xs font-black">
                    <span class="text-orange-500 mr-2">🔥</span> {{ $user->current_streak }}
                </div>
                <div class="flex items-center text-xs font-black border-l border-gray-300 dark:border-gray-600 pl-4">
                    <span class="text-amber-500 mr-2">🪙</span> {{ number_format($user->koban) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Gaya Kustom Manhua -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        .manhua-glow-hover:hover {
            box-shadow: 0 0 25px rgba(236, 72, 153, 0.4);
        }
    </style>
</x-app-layout>
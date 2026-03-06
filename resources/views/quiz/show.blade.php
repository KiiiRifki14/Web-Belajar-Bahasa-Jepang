<x-app-layout>
    <div class="min-h-screen pt-4 pb-12 flex items-center justify-center">
        <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Desktop: Split Screen | Mobile: Stacked -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

                <!-- Left Side: Visual Hint / Story -->
                <div class="lg:sticky lg:top-24 space-y-4">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-2xl manhua-outline relative group">
                        @if($question->visual_hint_path)
                        <img src="{{ asset('storage/' . $question->visual_hint_path) }}" alt="Visual Hint" class="w-full h-[400px] lg:h-[600px] object-cover transition-transform duration-700 group-hover:scale-105">
                        @else
                        <div class="w-full h-[300px] lg:h-[500px] bg-gradient-to-br from-[var(--theme-primary)] to-[var(--theme-secondary)] flex items-center justify-center opacity-20">
                            <span class="text-9xl opacity-10">🏮</span>
                        </div>
                        @endif

                        <!-- Overlay Story/Context -->
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-8">
                            <h3 class="text-white text-xl font-black tracking-tight mb-2">Desa {{ $level->region->name }}</h3>
                            <p class="text-white/70 text-sm italic">"Focus your spirit. The answers are hidden in the lines."</p>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="px-2">
                        <div class="flex justify-between text-[10px] font-black uppercase tracking-widest mb-1 opacity-50">
                            <span>Level Progress</span>
                            <span>{{ $currentIndex + 1 }} / {{ count($quiz['questions']) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-[var(--theme-primary)] h-full transition-all duration-500 manhua-glow" style="width: {{ (($currentIndex + 1) / count($quiz['questions'])) * 100 }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Quiz Interactive Panel -->
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 lg:p-12 shadow-2xl manhua-outline relative overflow-hidden">
                        <!-- Soft Glow Elements -->
                        <div class="absolute -top-24 -right-24 w-64 h-64 bg-[var(--theme-primary)] opacity-5 blur-[100px] rounded-full"></div>

                        <div class="relative z-10" x-data="{ answer: '', lifelineUsed: {{ session('neko_punch') ? 'true' : 'false' }}, options: {{ json_encode($question->options ?? []) }}, hidden: [] }"
                            x-init="if(lifelineUsed) { let keys = Object.keys(options).filter(k => options[k] !== '{{ $question->correct_answer }}'); hidden = keys.sort(() => 0.5 - Math.random()).slice(0, 2); }">

                            <!-- Question Header -->
                            <div class="flex justify-between items-center mb-10">
                                <span class="px-4 py-1.5 bg-[var(--theme-bg)] border border-[var(--theme-border)] text-[var(--theme-text)] rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm">
                                    {{ $question->type === 'multiple_choice' ? 'Multiple Choice' : 'Direct Answer' }}
                                </span>
                                <div class="flex items-center space-x-2 text-amber-500 font-black">
                                    <span>🔥</span>
                                    <span class="text-xl">{{ Auth::user()->current_streak }}</span>
                                </div>
                            </div>

                            <!-- Question Text -->
                            <h2 class="text-3xl lg:text-4xl font-black text-[var(--theme-text)] leading-tight mb-12">
                                {{ $question->question_text }}
                            </h2>

                            <!-- Quiz Form -->
                            <form action="{{ route('quiz.answer') }}" method="POST" id="quiz-form">
                                @csrf
                                <input type="hidden" name="question_id" value="{{ $question->id }}">
                                <input type="hidden" name="answer" :value="answer">

                                @if($question->type === 'multiple_choice')
                                <div class="grid grid-cols-1 gap-4">
                                    @foreach($question->options as $key => $option)
                                    @if($option)
                                    <button type="button"
                                        x-show="!hidden.includes('{{ $key }}')"
                                        @click="answer = '{{ $option }}'; $nextTick(() => $el.form.submit())"
                                        class="group relative w-full text-left p-6 rounded-2xl border-2 transition-all duration-300 hover:-translate-y-1 active:scale-95 flex items-center border-[var(--theme-border)] hover:border-[var(--theme-secondary)] hover:bg-[var(--theme-bg)]">
                                        <span class="w-10 h-10 rounded-xl bg-[var(--theme-bg)] border border-[var(--theme-border)] flex items-center justify-center font-black mr-4 group-hover:bg-[var(--theme-primary)] group-hover:text-white transition-colors">
                                            {{ strtoupper($key) }}
                                        </span>
                                        <span class="text-lg font-bold">{{ $option }}</span>
                                        <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity">✨</div>
                                    </button>
                                    @endif
                                    @endforeach

                                    <!-- Neko-Punch Lifeline -->
                                    @if(Auth::user()->paw_points > 0)
                                    <div class="mt-8 pt-8 border-t border-[var(--theme-border)] flex flex-col items-center">
                                        <form action="{{ route('quiz.paw') }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="group bg-gradient-to-br from-amber-400 to-orange-500 p-1 rounded-full shadow-lg transition-all hover:scale-110 active:rotate-12 manhua-glow"
                                                x-show="hidden.length === 0">
                                                <div class="bg-white dark:bg-gray-900 rounded-full w-16 h-16 flex items-center justify-center text-3xl">🐾</div>
                                            </button>
                                        </form>
                                        <span class="text-[10px] font-black uppercase tracking-widest mt-2 text-amber-600">Neko-Punch ({{ Auth::user()->paw_points }})</span>
                                    </div>
                                    @endif
                                </div>
                                @else
                                <div class="relative group">
                                    <input type="text" name="quiz_answer" placeholder="Type your answer..." autocomplete="off" autofocus
                                        @keyup.enter="answer = $event.target.value; $el.form.submit()"
                                        class="w-full bg-[var(--theme-bg)] border-2 border-[var(--theme-border)] rounded-2xl p-6 text-2xl font-black focus:border-[var(--theme-primary)] focus:ring-0 transition-all placeholder:opacity-20 text-[var(--theme-text)]">
                                    <button type="button" @click="answer = $el.previousElementSibling.value; $el.form.submit()"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-[var(--theme-primary)] text-white p-4 rounded-xl shadow-lg transition-transform hover:scale-110 active:scale-95">
                                        ⚔️
                                    </button>
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>

                    <!-- Aesthetic footer tip -->
                    <div class="text-center opacity-30 italic text-sm">
                        "Setiap goresan kuas membawa kejernihan pikiran."
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Status Alerts -->
    @if(session('success'))
    <div class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50 animate-bounce">
        <div class="bg-green-500 text-white px-8 py-4 rounded-full shadow-2xl font-black tracking-widest flex items-center">
            <span class="mr-3">🎉</span> {{ session('success') }}
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50">
        <div class="bg-red-500 text-white px-8 py-4 rounded-full shadow-2xl font-black tracking-widest flex items-center">
            <span class="mr-3">🙅</span> {{ session('error') }}
        </div>
    </div>
    @endif

</x-app-layout>
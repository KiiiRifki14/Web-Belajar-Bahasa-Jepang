<x-app-layout>
    <div class="py-6 min-h-screen bg-sakura-light dark:bg-tokyo-night"
        x-data="{ 
            answer: '', 
            lifelineUsed: {{ session('neko_punch') ? 'true' : 'false' }},
            options: {{ json_encode($question->options ?? []) }},
            correctAnswer: '{{ $question->correct_answer }}',
            hiddenOptions: []
         }"
        x-init="
            if(lifelineUsed && options) {
                let keys = Object.keys(options).filter(k => options[k] !== correctAnswer);
                hiddenOptions = keys.sort(() => 0.5 - Math.random()).slice(0, 2);
            }
         ">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Quiz Header: Progress & Mascot -->
            <div class="flex justify-between items-center mb-8 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border dark:border-gray-700">
                <div class="flex flex-col">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $level->region->name }} - {{ $level->name }}</span>
                    <div class="flex items-center mt-1">
                        <div class="w-48 h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden mr-3">
                            <div class="bg-indigo-500 h-full transition-all duration-500" style="width: { (($quiz['current_index']) / count($quiz['questions'])) * 100 }%"></div>
                        </div>
                        <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">{{ $quiz['current_index'] + 1 }} / {{ count($quiz['questions']) }}</span>
                    </div>
                </div>

                <div class="flex items-center space-x-6">
                    <!-- Current Streak -->
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Streak</span>
                        <div class="flex items-center">
                            <span class="text-xl font-black text-orange-500 mr-1">🔥 {{ Auth::user()->current_streak }}</span>
                        </div>
                    </div>

                    <!-- Neko-Sensei Reaction -->
                    <div class="relative group">
                        <div class="absolute -top-10 -left-12 bg-white dark:bg-gray-700 p-2 rounded-lg shadow-md text-[10px] font-bold hidden group-hover:block transition-all border dark:border-gray-600 w-24">
                            "{{ Auth::user()->current_streak > 5 ? 'Ganbatte! You are on fire!' : 'Concentrate, student!' }}"
                        </div>
                        <div class="text-4xl filter drop-shadow-md animate-bounce">
                            {{ Auth::user()->current_streak > 10 ? '✨🐱✨' : (Auth::user()->current_streak > 0 ? '🐱' : '😿') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Split Screen Main Layout (Manhua Style) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

                <!-- Left: Visual/Story Panel -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-2xl border-4 border-pink-100 dark:border-pink-900 aspect-video lg:aspect-square flex items-center justify-center relative">
                    @if($question->visual_hint_path)
                    <img src="{{ Storage::url($question->visual_hint_path) }}" alt="Hint" class="w-full h-full object-contain p-4">
                    @else
                    <div class="flex flex-col items-center p-8 text-center">
                        <div class="text-6xl mb-6 opacity-20">📜</div>
                        <p class="text-2xl font-bold text-gray-700 dark:text-gray-200 leading-relaxed italic">
                            "{{ $question->question_text }}"
                        </p>
                    </div>
                    @endif

                    <!-- Aesthetic Overlays -->
                    <div class="absolute top-4 left-4 text-xs font-mono text-pink-300 dark:text-pink-700 opacity-50">FRAME_0{{ $level->id }}_HINT</div>
                </div>

                <!-- Right: Interaction Panel -->
                <div class="flex flex-col space-y-6">

                    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-xl border dark:border-gray-700 relative">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-8 border-l-4 border-indigo-500 pl-4 tracking-tight">
                            Choose the correct answer:
                        </h2>

                        <form action="{{ route('quiz.answer') }}" method="POST" id="quizForm">
                            @csrf
                            <input type="hidden" name="answer" :value="answer">

                            @if($question->type === 'multiple_choice')
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($question->options as $key => $val)
                                @if($val)
                                <button type="button"
                                    @click="answer = '{{ $val }}'; document.getElementById('quizForm').submit()"
                                    x-show="!hiddenOptions.includes('{{ $key }}')"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:leave="transition ease-in duration-300"
                                    class="w-full p-5 text-left rounded-2xl border-2 transition-all duration-200 flex items-center group
                                                           hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-950
                                                           border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                                    <span class="w-10 h-10 rounded-xl bg-white dark:bg-gray-800 border dark:border-gray-600 flex items-center justify-center font-black text-indigo-500 mr-4 shadow-sm group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                                        {{ $key }}
                                    </span>
                                    <span class="text-lg font-medium text-gray-700 dark:text-gray-200">{{ $val }}</span>
                                </button>
                                @endif
                                @endforeach
                            </div>
                            @else
                            <div class="space-y-4">
                                <input type="text" name="quiz_answer" autofocus
                                    placeholder="Type your answer here..."
                                    @keyup.enter="answer = $event.target.value; document.getElementById('quizForm').submit()"
                                    class="w-full p-6 text-xl font-bold rounded-2xl border-2 border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 dark:focus:ring-indigo-900 transition-all dark:text-white">
                                <p class="text-xs text-gray-400 italic">Press Enter to submit</p>
                            </div>
                            @endif
                        </form>
                    </div>

                    <!-- Actions & Lifelines -->
                    <div class="flex items-center justify-between p-4 bg-indigo-50 dark:bg-indigo-950 rounded-2xl border-2 border-dashed border-indigo-200 dark:border-indigo-800">
                        <div class="flex items-center text-indigo-700 dark:text-indigo-300">
                            <span class="text-2xl mr-3 font-bold">🐾</span>
                            <div>
                                <h4 class="text-xs font-black uppercase">Neko-Punch</h4>
                                <p class="text-[10px] opacity-70">Removes 2 wrong options</p>
                            </div>
                        </div>

                        <form action="{{ route('quiz.paw') }}" method="POST">
                            @csrf
                            <button type="submit"
                                {{ Auth::user()->paw_points <= 0 || $question->type !== 'multiple_choice' ? 'disabled' : '' }}
                                class="bg-white dark:bg-gray-800 px-6 py-2 rounded-xl shadow-md border border-indigo-200 dark:border-indigo-700 flex items-center transition-all hover:scale-105 active:scale-95 disabled:opacity-50 disabled:grayscale disabled:scale-100">
                                <span class="text-indigo-600 font-black mr-2">{{ Auth::user()->paw_points }}</span>
                                <span class="text-xl">🐾</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            <!-- Status Alerts -->
            @if(session('success'))
            <div class="mt-8 p-4 bg-green-50 dark:bg-green-950 border-2 border-green-200 dark:border-green-800 rounded-2xl text-green-700 dark:text-green-300 font-bold flex items-center justify-center animate-bounce">
                <span class="mr-2">🎉</span> {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mt-8 p-4 bg-red-50 dark:bg-red-950 border-2 border-red-200 dark:border-red-800 rounded-2xl text-red-700 dark:text-red-300 font-bold flex items-center justify-center">
                <span class="mr-2">🙅</span> {{ session('error') }}
            </div>
            @endif

        </div>
    </div>

    <!-- Custom Sakura Light & Tokyo Night Styles -->
    <style>
        .bg-sakura-light {
            background-image: radial-gradient(circle at 20% 20%, #fffbfb 0%, #fff1f2 100%);
        }

        .dark .bg-tokyo-night {
            background-image: radial-gradient(circle at 20% 20%, #1a1b26 0%, #16161e 100%);
        }
    </style>
</x-app-layout>
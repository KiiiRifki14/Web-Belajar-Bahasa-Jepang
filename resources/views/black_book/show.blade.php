<x-app-layout>
    <div class="py-12 bg-transparent min-h-screen text-slate-200 flex items-center justify-center relative">
        <!-- Occult ambient backdrop -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-slate-800 opacity-40 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-10 left-10 w-[400px] h-[400px] bg-indigo-900 opacity-30 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-2xl w-full mx-auto sm:px-6 lg:px-8 relative z-10">

            <div class="glass-panel shadow-glow rounded-[3rem] p-12 border border-slate-700/50 bg-slate-900/60 relative overflow-hidden animate-fadeIn">
                <!-- Inner ethereal glow -->
                <div class="absolute inset-0 bg-gradient-to-b from-white/5 to-transparent pointer-events-none"></div>

                <!-- Progress Header -->
                <div class="flex justify-between items-center mb-12 relative z-10">
                    <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-400">Review Session: {{ $rematch['current_index'] + 1 }} / {{ count($rematch['items']) }}</span>
                    <div class="flex space-x-2">
                        @for($i=0; $i < count($rematch['items']); $i++)
                            <div class="w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $i < $rematch['current_index'] ? 'bg-slate-400 shadow-sm' : ($i == $rematch['current_index'] ? 'bg-slate-100 shadow-glow animate-pulse scale-125' : 'bg-slate-800/50 border border-slate-600/50') }}">
                    </div>
                    @endfor
                </div>
            </div>

            <div class="space-y-8 relative z-10">
                <!-- The Question Paper -->
                <div class="bg-slate-800/40 text-slate-200 p-8 rounded-3xl shadow-inner min-h-[160px] flex items-center justify-center text-center relative border border-slate-700/50">
                    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>
                    <div class="absolute -top-4 -left-4 text-4xl opacity-10 blur-[1px]">🖋️</div>
                    <h2 class="text-2xl font-serif font-bold italic leading-relaxed">"{{ $blackBookItem->question->question_text }}"</h2>
                </div>

                <!-- Input Form -->
                <form action="{{ route('black_book.answer') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="relative group">
                        <input type="text" name="answer" placeholder="Transcribe your forgotten knowledge..." autocomplete="off" autofocus
                            class="w-full bg-slate-900/50 border-2 border-slate-700/50 rounded-2xl p-6 text-slate-200 font-serif italic text-xl focus:border-slate-500 focus:bg-slate-800/80 focus:ring-0 transition-all placeholder-slate-600 shadow-inner text-center">
                    </div>

                    <div class="flex justify-between items-center bg-slate-800/30 p-4 rounded-full border border-slate-700/30">
                        <div class="flex items-center space-x-4 pl-4">
                            <span class="text-[10px] uppercase font-bold tracking-[0.2em] text-slate-500">Mastery Streak</span>
                            <div class="flex space-x-2">
                                @for($i=1; $i<=3; $i++)
                                    <div class="w-2 h-2 rounded-full transition-all duration-300 {{ $blackBookItem->correct_streak >= $i ? 'bg-slate-300 shadow-glow' : 'bg-slate-800 border border-slate-700' }}">
                            </div>
                            @endfor
                        </div>
                    </div>
                    <button type="submit" class="bg-slate-200 hover:bg-white text-slate-900 px-8 py-3 rounded-full font-bold uppercase tracking-widest text-xs transition-all shadow-glow hover:scale-[1.02] active:scale-95 flex items-center">
                        Submit <span class="ml-2">→</span>
                    </button>
            </div>
            </form>
            </form>
        </div>

        <!-- Footer Hint -->
        <div class="mt-12 text-center opacity-30">
            <p class="text-[9px] font-mono tracking-widest text-slate-400">NO LIFELINES ALLOWED IN THE ARCHIVE</p>
        </div>
    </div>

    <!-- Toast feedback -->
    @if(session('success'))
    <div class="fixed top-10 right-10 p-6 bg-slate-800/90 backdrop-blur-md text-emerald-400 font-serif italic animate-bounce rounded-2xl border border-emerald-500/30 shadow-glass-sm z-50">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="fixed top-10 right-10 p-6 bg-slate-800/90 backdrop-blur-md text-rose-400 font-serif italic animate-shake rounded-2xl border border-rose-500/30 shadow-glass-sm z-50">
        {{ session('error') }}
    </div>
    @endif

    </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>
</x-app-layout>
<x-app-layout>
    <div class="py-12 bg-[#1a120b] min-h-screen text-[#d5cea3] flex items-center justify-center">
        <div class="max-w-2xl w-full mx-auto sm:px-6 lg:px-8">

            <div class="bg-[#3c2a21] shadow-2xl rounded-sm p-10 border-t-8 border-[#d5cea3] relative overflow-hidden animate-fadeIn">
                <!-- Progress Header -->
                <div class="flex justify-between items-center mb-10">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#d5cea3] opacity-60">Review Session: {{ $rematch['current_index'] + 1 }} / {{ count($rematch['items']) }}</span>
                    <div class="flex space-x-2">
                        @for($i=0; $i < count($rematch['items']); $i++)
                            <div class="w-2 h-2 rounded-full {{ $i < $rematch['current_index'] ? 'bg-[#d5cea3]' : ($i == $rematch['current_index'] ? 'bg-[#e5e5cb] animate-pulse' : 'bg-[#1a120b]') }}">
                    </div>
                    @endfor
                </div>
            </div>

            <div class="space-y-8">
                <!-- The Question Paper -->
                <div class="bg-[#d5cea3] text-[#1a120b] p-8 rounded-sm shadow-inner min-h-[150px] flex items-center justify-center text-center relative">
                    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(#1a120b 1px, transparent 1px); background-size: 20px 20px;"></div>
                    <h2 class="text-2xl font-serif font-bold italic">"{{ $blackBookItem->question->question_text }}"</h2>
                </div>

                <!-- Input Form -->
                <form action="{{ route('black_book.answer') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="relative group">
                        <input type="text" name="answer" placeholder="Transcribe your forgotten knowledge..." autocomplete="off" autofocus
                            class="w-full bg-[#1a120b] border-2 border-[#3c2a21] rounded-sm p-5 text-[#e5e5cb] font-serif italic text-lg focus:border-[#d5cea3] focus:ring-0 transition-all placeholder-[#3c2a21]">
                    </div>

                    <div class="flex justify-between items-center pt-4">
                        <div class="flex items-center space-x-2">
                            <span class="text-[10px] uppercase font-black opacity-40">Current Mastery Streak:</span>
                            <div class="flex space-x-1">
                                @for($i=1; $i<=3; $i++)
                                    <div class="w-3 h-3 rounded-full {{ $blackBookItem->correct_streak >= $i ? 'bg-[#d5cea3]' : 'bg-[#1a120b] border border-[#3c2a21]' }}">
                            </div>
                            @endfor
                        </div>
                    </div>
                    <button type="submit" class="bg-[#d5cea3] hover:bg-[#e5e5cb] text-[#1a120b] px-8 py-3 font-black uppercase tracking-widest text-sm transition-all shadow-lg active:scale-95">
                        Submit Answer
                    </button>
            </div>
            </form>
        </div>

        <!-- Footer Hint -->
        <div class="mt-12 text-center opacity-30">
            <p class="text-[9px] font-mono tracking-widest">NO LIFELINES ALLOWED IN THE ARCHIVE</p>
        </div>
    </div>

    <!-- Toast feedback -->
    @if(session('success'))
    <div class="mt-6 p-4 bg-[#2a3c2a] text-[#a3d5a3] text-center font-bold font-serif italic animate-bounce rounded-sm border-l-4 border-green-500">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mt-6 p-4 bg-[#3c2a2a] text-[#d5a3a3] text-center font-bold font-serif italic animate-shake rounded-sm border-l-4 border-red-500">
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
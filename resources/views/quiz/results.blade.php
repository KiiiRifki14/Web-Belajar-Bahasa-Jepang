<x-app-layout>
    <div class="py-12 min-h-screen flex items-center justify-center bg-transparent">
        <div class="max-w-2xl w-full mx-auto sm:px-6 lg:px-8 relative z-10">
            <div class="glass-panel overflow-hidden shadow-2xl rounded-[3rem] border border-white/60 p-12 text-center relative">

                <!-- Confetti/Petal Decor -->
                <div class="absolute top-0 left-0 w-full h-3 bg-gradient-to-r from-sakura-300 via-white to-matcha-300 opacity-80"></div>

                <!-- Magic Glow backdrop -->
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-sakura-300 opacity-20 blur-[80px] rounded-full pointer-events-none"></div>
                <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-matcha-300 opacity-20 blur-[80px] rounded-full pointer-events-none"></div>

                <div class="mb-12 relative z-10">
                    @if(($correct / $total) >= 0.8)
                    <div class="text-[6rem] mb-6 animate-bounce filter drop-shadow-md">🎌</div>
                    <h1 class="font-serif text-5xl font-bold text-gray-800 capitalize mb-4">Amazing Odyssey!</h1>
                    <p class="text-[10px] font-bold tracking-widest uppercase text-sakura-600 mt-2">Neko-Sensei is very proud of your progress.</p>
                    @elseif(($correct / $total) >= 0.6)
                    <div class="text-[6rem] mb-6 filter drop-shadow-md">💮</div>
                    <h1 class="font-serif text-5xl font-bold text-gray-800 capitalize mb-4">Good Effort!</h1>
                    <p class="text-[10px] font-bold tracking-widest uppercase text-matcha-600 mt-2">You've unlocked the next part of the journey.</p>
                    @else
                    <div class="text-[6rem] mb-6 grayscale opacity-60">🗻</div>
                    <h1 class="font-serif text-5xl font-bold text-gray-600 capitalize mb-4">Keep Training!</h1>
                    <p class="text-[10px] font-bold tracking-widest uppercase text-gray-500 mt-2">The road to Tokyo is long, but you can do it.</p>
                    @endif
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 gap-6 mb-12 relative z-10">
                    <div class="p-8 bg-white/40 backdrop-blur-sm rounded-[2rem] border border-white/60 shadow-glass-sm transition-transform hover:-translate-y-1">
                        <span class="block text-[10px] font-bold uppercase text-gray-500 tracking-widest mb-2">Total Score</span>
                        <span class="font-serif text-4xl font-bold text-matcha-600">{{ number_format($score) }}</span>
                    </div>
                    <div class="p-8 bg-white/40 backdrop-blur-sm rounded-[2rem] border border-white/60 shadow-glass-sm transition-transform hover:-translate-y-1">
                        <span class="block text-[10px] font-bold uppercase text-gray-500 tracking-widest mb-2">Accuracy</span>
                        <span class="font-serif text-4xl font-bold text-sakura-500">{{ round(($correct / $total) * 100) }}%</span>
                    </div>
                </div>

                <!-- Bottom Actions -->
                <div class="space-y-4 relative z-10">
                    <a href="{{ route('dashboard') }}" class="block w-full py-5 bg-gradient-to-r from-sakura-400 to-matcha-400 hover:from-sakura-500 hover:to-matcha-500 text-white font-bold rounded-full shadow-glow transition-all duration-300 hover:scale-[1.02] active:scale-95 text-lg tracking-wide">
                        Return to Map
                    </a>
                    <a href="{{ route('quiz.start', $level) }}" class="block w-full py-5 bg-white/50 backdrop-blur-sm text-gray-600 font-bold rounded-full border-2 border-sakura-200 transition-all duration-300 hover:bg-white/80 hover:border-sakura-300 hover:text-sakura-600 hover:scale-[1.02] active:scale-95 text-lg tracking-wide shadow-glass-sm">
                        Try Again
                    </a>
                </div>

                <div class="mt-12 pt-10 border-t border-gray-200/50 flex justify-center space-x-12 opacity-50 grayscale hover:grayscale-0 transition-all duration-500 relative z-10 animate-float-slow">
                    <span class="text-3xl">🐱</span>
                    <span class="text-3xl text-yellow-500">🪙</span>
                    <span class="text-3xl text-pink-500">🌸</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
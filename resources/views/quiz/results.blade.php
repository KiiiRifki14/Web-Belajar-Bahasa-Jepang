<x-app-layout>
    <div class="py-12 min-h-screen flex items-center justify-center bg-sakura-light dark:bg-tokyo-night">
        <div class="max-w-2xl w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border dark:border-gray-700 p-10 text-center relative">

                <!-- Confetti/Petal Decor -->
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-pink-300 via-indigo-500 to-green-300"></div>

                <div class="mb-10">
                    @if(($correct / $total) >= 0.8)
                    <div class="text-8xl mb-4 animate-bounce">🎌</div>
                    <h1 class="text-4xl font-black text-gray-800 dark:text-white capitalize">Amazing Odyssey!</h1>
                    <p class="text-gray-500 mt-2">Neko-Sensei is very proud of your progress.</p>
                    @elseif(($correct / $total) >= 0.6)
                    <div class="text-8xl mb-4">💮</div>
                    <h1 class="text-4xl font-black text-gray-800 dark:text-white capitalize">Good Effort!</h1>
                    <p class="text-gray-500 mt-2">You've unlocked the next part of the journey.</p>
                    @else
                    <div class="text-8xl mb-4 grayscale">🗻</div>
                    <h1 class="text-4xl font-black text-gray-800 dark:text-white capitalize">Keep Training!</h1>
                    <p class="text-gray-500 mt-2">The road to Tokyo is long, but you can do it.</p>
                    @endif
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 gap-6 mb-12">
                    <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-3xl border-2 border-gray-100 dark:border-gray-700">
                        <span class="block text-[10px] font-black uppercase text-gray-400 tracking-tighter mb-1">Total Score</span>
                        <span class="text-3xl font-black text-indigo-600 dark:text-indigo-400">{{ number_format($score) }}</span>
                    </div>
                    <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-3xl border-2 border-gray-100 dark:border-gray-700">
                        <span class="block text-[10px] font-black uppercase text-gray-400 tracking-tighter mb-1">Accuracy</span>
                        <span class="text-3xl font-black text-pink-500">{{ round(($correct / $total) * 100) }}%</span>
                    </div>
                </div>

                <!-- Bottom Actions -->
                <div class="space-y-4">
                    <a href="{{ route('dashboard') }}" class="block w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 dark:shadow-none transition-all active:scale-95 text-lg">
                        Return to Map
                    </a>
                    <a href="{{ route('quiz.start', $level) }}" class="block w-full py-4 bg-white dark:bg-gray-700 text-indigo-600 dark:text-indigo-400 font-bold rounded-2xl border-2 border-indigo-100 dark:border-indigo-600 transition-all hover:bg-indigo-50 dark:hover:bg-gray-600 text-lg">
                        Try Again
                    </a>
                </div>

                <div class="mt-10 pt-10 border-t dark:border-gray-700 flex justify-center space-x-8 opacity-50 grayscale hover:grayscale-0 transition-all">
                    <span class="text-3xl">🐱</span>
                    <span class="text-3xl text-yellow-500">🪙</span>
                    <span class="text-3xl text-pink-500">🌸</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
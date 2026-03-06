<x-app-layout>
    <div class="py-6" x-data="{ mood: '{{ $user->mood ?? 'neutral' }}' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Top Grid: Countdown & Mood & Secret Note -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <!-- Countdown Widget -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border-b-4 border-pink-300 dark:border-pink-900 flex flex-col items-center justify-center text-center transition-all hover:scale-105">
                    <div class="text-pink-500 text-4xl mb-2">🏯</div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Road to Tokyo</h3>
                    <div class="text-4xl font-extrabold text-gray-800 dark:text-gray-100 my-2">
                        {{ $daysToJLPT }} <span class="text-lg font-normal">Days</span>
                    </div>
                    <p class="text-xs text-gray-500">until JLPT Departure</p>
                </div>

                <!-- Mood Tracker Panel -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border-b-4 border-indigo-300 dark:border-indigo-900 group">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">How are you feeling, {{ explode(' ', $user->name)[0] }}?</h3>
                    <div class="flex justify-around items-center">
                        <form action="{{ route('mood.update') }}" method="POST" class="flex justify-around w-full">
                            @csrf
                            <button type="submit" name="mood" value="happy" class="flex flex-col items-center transition hover:scale-125" :class="mood === 'happy' ? 'opacity-100 scale-110' : 'opacity-40'">
                                <span class="text-3xl">😊</span>
                                <span class="text-[10px] mt-1 text-green-500 font-bold">Happy</span>
                            </button>
                            <button type="submit" name="mood" value="neutral" class="flex flex-col items-center transition hover:scale-125" :class="mood === 'neutral' ? 'opacity-100 scale-110' : 'opacity-40'">
                                <span class="text-3xl">😐</span>
                                <span class="text-[10px] mt-1 text-gray-500 font-bold">Better</span>
                            </button>
                            <button type="submit" name="mood" value="sad" class="flex flex-col items-center transition hover:scale-125" :class="mood === 'sad' ? 'opacity-100 scale-110' : 'opacity-40'">
                                <span class="text-3xl">😢</span>
                                <span class="text-[10px] mt-1 text-blue-500 font-bold">Tired</span>
                            </button>
                            <button type="submit" name="mood" value="angry" class="flex flex-col items-center transition hover:scale-125" :class="mood === 'angry' ? 'opacity-100 scale-110' : 'opacity-40'">
                                <span class="text-3xl">💢</span>
                                <span class="text-[10px] mt-1 text-red-500 font-bold">Frustrated</span>
                            </button>
                        </form>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-4 italic">*Choosing 'Tired' or 'Frustrated' will make quiz questions easier.</p>
                </div>

                <!-- Secret Note / Neko-Sensei Advice -->
                <div class="bg-indigo-50 dark:bg-indigo-950 p-6 rounded-2xl shadow-lg border-b-4 border-indigo-200 dark:border-indigo-800 relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="text-8xl">🐾</span>
                    </div>
                    <h3 class="text-sm font-bold text-indigo-400 uppercase tracking-widest mb-2 flex items-center">
                        <span class="mr-2">🐱</span> Neko-Sensei's Note
                    </h3>
                    @if($secretNote)
                    <p class="text-sm text-indigo-900 dark:text-indigo-200 leading-relaxed italic">
                        "{{ $secretNote->content }}"
                    </p>
                    @else
                    <p class="text-sm text-indigo-900 dark:text-indigo-200 leading-relaxed italic">
                        "Practice every day, and even the highest mountain is just a series of steps."
                    </p>
                    @endif
                </div>
            </div>

            <!-- Main Map Section: Road to Tokyo -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 mb-8 border dark:border-gray-700 min-h-[600px] relative overflow-hidden">

                <!-- Atmosphere Elements -->
                <div class="absolute top-10 left-10 w-32 h-32 bg-pink-100 dark:bg-pink-900 opacity-20 blur-3xl rounded-full"></div>
                <div class="absolute bottom-20 right-20 w-48 h-48 bg-indigo-100 dark:bg-indigo-900 opacity-20 blur-3xl rounded-full"></div>

                <div class="relative z-10 flex flex-col items-center">
                    <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white mb-2 tracking-tight">🗺️ Wilayah Petualangan</h2>
                    <p class="text-gray-500 mb-12">Tap on a level to start your odyssey.</p>

                    <!-- The Map (Timeline/Path) -->
                    <div class="w-full max-w-4xl space-y-16 py-10">
                        @foreach($regions as $index => $region)
                        <div class="relative">
                            <!-- Region Header -->
                            <div class="flex items-center mb-10 {{ $index % 2 == 0 ? 'flex-row' : 'flex-row-reverse' }}">
                                <div class="h-px bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent flex-grow"></div>
                                <h4 class="mx-6 px-4 py-1 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-full text-sm font-bold text-gray-600 dark:text-gray-300 shadow-sm uppercase tracking-widest">
                                    Arc {{ $index + 1 }}: {{ $region->name }}
                                </h4>
                                <div class="h-px bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-600 to-transparent flex-grow"></div>
                            </div>

                            <!-- Levels Grid -->
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-8">
                                @foreach($region->levels as $level)
                                @php
                                $status = $progress[$level->id] ?? 'locked';
                                $isLocked = $status === 'locked';
                                $isPassed = $status === 'passed';
                                @endphp
                                <div class="flex flex-col items-center group">
                                    <a href="{{ $isLocked ? '#' : route('quiz.start', $level) }}"
                                        class="relative w-16 h-16 sm:w-20 sm:h-20 rounded-2xl flex items-center justify-center transition-all duration-300 transform 
                                               {{ $isLocked ? 'bg-gray-200 dark:bg-gray-700 cursor-not-allowed grayscale' : 'hover:scale-110 shadow-lg active:scale-95' }}
                                               {{ $isPassed ? 'bg-green-100 dark:bg-green-900 border-2 border-green-500' : '' }}
                                               {{ $status === 'unlocked' ? 'bg-indigo-500 border-4 border-indigo-200 dark:border-indigo-800 animate-pulse' : '' }}
                                               {{ !$isLocked && !$isPassed && $status !== 'unlocked' ? 'bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600' : '' }}">

                                        @if($level->is_boss_level)
                                        <span class="text-2xl sm:text-3xl">👹</span>
                                        @elseif($isPassed)
                                        <span class="text-2xl sm:text-3xl text-green-600 dark:text-green-400">🉐</span>
                                        @else
                                        <span class="text-xl sm:text-2xl font-black {{ $status === 'unlocked' ? 'text-white' : 'text-gray-400 dark:text-gray-500' }}">{{ $level->order }}</span>
                                        @endif

                                        <!-- Status Badge -->
                                        @if($isLocked)
                                        <div class="absolute -top-2 -right-2 bg-gray-400 text-white rounded-full p-1 text-[10px]">🔒</div>
                                        @elseif($isPassed)
                                        <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full p-1 text-[10px]">⭐</div>
                                        @endif
                                    </a>
                                    <span class="mt-3 text-[10px] sm:text-xs font-bold text-center {{ $isLocked ? 'text-gray-400' : 'text-gray-600 dark:text-gray-300' }}">
                                        {{ $level->name }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Stats Footer -->
            <div class="flex flex-wrap justify-center gap-4 text-sm">
                <div class="px-4 py-2 bg-yellow-100 dark:bg-yellow-900 rounded-full text-yellow-700 dark:text-yellow-200 font-bold border border-yellow-200 dark:border-yellow-700 flex items-center">
                    <span class="mr-2">🪙</span> {{ number_format($user->koban) }} Koban
                </div>
                <div class="px-4 py-2 bg-orange-100 dark:bg-orange-950 rounded-full text-orange-700 dark:text-orange-200 font-bold border border-orange-200 dark:border-orange-800 flex items-center">
                    <span class="mr-2">🔥</span> {{ $user->current_streak }} Streak
                </div>
                <div class="px-4 py-2 bg-pink-100 dark:bg-pink-950 rounded-full text-pink-700 dark:text-pink-200 font-bold border border-pink-200 dark:border-pink-800 flex items-center">
                    <span class="mr-2">🐾</span> {{ $user->paw_points ?? 0 }} Neko-Punches
                </div>
            </div>

        </div>
    </div>

    <!-- Custom Manhua Aesthetic Styles -->
    <style>
        .glow-pink {
            box-shadow: 0 0 20px rgba(244, 114, 182, 0.3);
        }

        .glow-indigo {
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
        }
    </style>
</x-app-layout>
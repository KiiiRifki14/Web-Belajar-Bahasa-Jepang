<x-app-layout>
    <div class="py-12 bg-[#1a120b] min-h-screen text-[#d5cea3]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 border-b-2 border-[#3c2a21] pb-8">
                <div>
                    <h1 class="text-5xl font-serif font-bold italic tracking-tighter text-[#e5e5cb]">Buku Hitam</h1>
                    <p class="text-[#3c2a21] uppercase font-black tracking-[0.3em] text-xs mt-2">The Archive of Forgotten Knowledge</p>
                </div>
                <div class="mt-6 md:mt-0 text-right">
                    <span class="block text-xs font-bold uppercase tracking-widest text-[#3c2a21]">Mastered Mistakes</span>
                    <span class="text-4xl font-serif font-black text-[#e5e5cb]">{{ $masteredCount }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">

                <!-- Sidebar Info -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-[#3c2a21] p-8 rounded-sm shadow-2xl border-l-4 border-[#d5cea3]">
                        <h3 class="font-serif text-xl mb-4 italic text-[#e5e5cb]">The Path to Mastery</h3>
                        <p class="text-sm leading-relaxed opacity-80">
                            Mistakes are merely steps. To cleanse a name from this book, you must answer it correctly <span class="font-bold text-[#e5e5cb]">3 times in a row</span> during a Rematch.
                        </p>
                        <form action="{{ route('black_book.start') }}" method="POST" class="mt-8">
                            @csrf
                            <button type="submit" class="w-full py-4 bg-[#d5cea3] hover:bg-[#e5e5cb] text-[#1a120b] font-black uppercase tracking-widest transition-all rounded-sm shadow-lg active:scale-95">
                                Begin Rematch ⚔️
                            </button>
                        </form>
                    </div>

                    <div class="p-6 border border-[#3c2a21] opacity-40">
                        <p class="text-[10px] font-mono leading-tight">
                            "The man who makes a mistake and does not correct it, is making another mistake." — Confucius
                        </p>
                    </div>
                </div>

                <!-- List of Unmastered Questions -->
                <div class="lg:col-span-3">
                    @if($items->isEmpty())
                    <div class="bg-[#3c2a21] bg-opacity-30 p-20 text-center rounded-sm border-2 border-dashed border-[#3c2a21]">
                        <div class="text-6xl mb-6 opacity-20">📜</div>
                        <h3 class="text-2xl font-serif italic text-[#e5e5cb]">Your Archive is Empty</h3>
                        <p class="mt-2 text-sm">Every mistake has been mastered. You have achieved true clarity.</p>
                    </div>
                    @else
                    <div class="space-y-4">
                        @foreach($items as $item)
                        <div class="bg-[#3c2a21] p-6 rounded-sm flex flex-col md:flex-row justify-between items-center transition-all hover:bg-[#4d3428] border-b-2 border-[#1a120b] group">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <span class="px-2 py-0.5 bg-[#1a120b] text-[10px] font-black uppercase tracking-tighter">Level {{ $item->question->level->name }}</span>
                                    <span class="text-xs font-mono opacity-50 italic">Faded since {{ $item->updated_at->diffForHumans() }}</span>
                                </div>
                                <h4 class="text-lg font-serif text-[#e5e5cb] group-hover:pl-2 transition-all">"{{ Str::limit($item->question->question_text, 100) }}"</h4>
                            </div>
                            <div class="mt-4 md:mt-0 flex items-center space-x-8">
                                <div class="text-center">
                                    <span class="block text-[8px] uppercase font-black opacity-40">Errors</span>
                                    <span class="text-xl font-serif font-black">{{ $item->wrong_count }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-[8px] uppercase font-black opacity-40">Streak</span>
                                    <div class="flex space-x-1 mt-1">
                                        @for($i=1; $i<=3; $i++)
                                            <div class="w-3 h-3 rounded-full {{ $item->correct_streak >= $i ? 'bg-[#d5cea3]' : 'bg-[#1a120b]' }}">
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
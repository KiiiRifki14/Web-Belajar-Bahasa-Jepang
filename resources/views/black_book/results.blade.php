<x-app-layout>
    <div class="py-12 bg-[#1a120b] min-h-screen text-[#d5cea3] flex items-center justify-center">
        <div class="max-w-md w-full mx-auto sm:px-6 lg:px-8 text-center">

            <div class="bg-[#3c2a21] shadow-2xl rounded-sm p-12 border-b-8 border-[#d5cea3] relative">
                <div class="absolute -top-10 left-1/2 -translate-x-1/2 text-7xl bg-[#1a120b] w-24 h-24 rounded-full flex items-center justify-center border-4 border-[#3c2a21] shadow-2xl">
                    📜
                </div>

                <h1 class="text-4xl font-serif font-bold italic text-[#e5e5cb] mt-8">Sesi Berakhir</h1>
                <p class="text-[#3c2a21] uppercase font-black tracking-widest text-[10px] mt-2 mb-8">Session Summary</p>

                <div class="grid grid-cols-2 gap-4 mb-10">
                    <div class="bg-[#1a120b] p-6 rounded-sm">
                        <span class="block text-[8px] uppercase font-black opacity-40">Corrected</span>
                        <span class="text-3xl font-serif font-black text-[#d5cea3]">{{ $correct }}</span>
                    </div>
                    <div class="bg-[#1a120b] p-6 rounded-sm">
                        <span class="block text-[8px] uppercase font-black opacity-40">Total Review</span>
                        <span class="text-3xl font-serif font-black text-[#e5e5cb]">{{ $total }}</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <a href="{{ route('black_book.index') }}" class="block w-full py-4 bg-[#d5cea3] hover:bg-[#e5e5cb] text-[#1a120b] font-black uppercase tracking-widest text-sm transition-all rounded-sm">
                        Return to Archive
                    </a>
                    <a href="{{ route('dashboard') }}" class="block w-full py-4 border-2 border-[#3c2a21] text-[#d5cea3] hover:bg-[#3c2a21] font-black uppercase tracking-widest text-sm transition-all rounded-sm">
                        Back to Village
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
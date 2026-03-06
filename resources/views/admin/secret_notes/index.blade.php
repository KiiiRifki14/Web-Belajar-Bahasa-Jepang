<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Secret Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Secret Notes Pool</h3>
                        <a href="{{ route('admin.secret_notes.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition">
                            + New Secret Note
                        </a>
                    </div>

                    @if(session('success'))
                    <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4 relative z-10">
                        @forelse($notes as $note)
                        <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700 flex flex-col justify-between h-auto mt-2">
                            <div>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-3 py-1 rounded-full dark:bg-blue-900/50 dark:text-blue-300 uppercase tracking-wider">
                                        {{ $note->category }}
                                    </span>
                                    <span class="{{ $note->is_active ? 'text-green-500' : 'text-red-500' }} text-[10px] font-bold uppercase tracking-wider">
                                        {{ $note->is_active ? '● Active' : '● Inactive' }}
                                    </span>
                                </div>
                                <p class="text-gray-700 dark:text-gray-300 mb-6 whitespace-pre-line text-sm leading-relaxed italic border-l-2 border-gray-200 dark:border-gray-700 pl-4">
                                    "{{ $note->content }}"
                                </p>
                            </div>
                            <div class="flex justify-end space-x-4 mt-auto pt-4 border-t border-gray-100 dark:border-gray-700">
                                <a href="{{ route('admin.secret_notes.edit', $note) }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 uppercase tracking-wider transition-colors">Edit</a>
                                <form action="{{ route('admin.secret_notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Delete this note?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-bold text-red-600 dark:text-red-400 hover:text-red-800 uppercase tracking-wider transition-colors">Delete</button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-10">
                            <p class="text-gray-500">No secret notes found. Add some to inspire your students!</p>
                        </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
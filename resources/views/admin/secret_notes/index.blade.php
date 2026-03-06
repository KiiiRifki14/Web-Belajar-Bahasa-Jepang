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
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($notes as $note)
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 uppercase">
                                        {{ $note->category }}
                                    </span>
                                    <span class="{{ $note->is_active ? 'text-green-500' : 'text-red-500' }} text-xs font-bold">
                                        {{ $note->is_active ? '● Active' : '● Inactive' }}
                                    </span>
                                </div>
                                <p class="text-gray-700 dark:text-gray-400 mb-4 whitespace-pre-line overflow-hidden max-h-40 line-clamp-4">
                                    "{{ $note->content }}"
                                </p>
                            </div>
                            <div class="flex justify-end space-x-2 mt-4 pt-4 border-t dark:border-gray-700">
                                <a href="{{ route('admin.secret_notes.edit', $note) }}" class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('admin.secret_notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Delete this note?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
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
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Question ID: ') }} {{ $question->id }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ questionType: '{{ old('type', $question->type) }}' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('admin.questions.update', $question) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="level_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assign to Level</label>
                            <select name="level_id" id="level_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="" disabled>Select a Level</option>
                                @foreach($levels as $level)
                                <option value="{{ $level->id }}" {{ $question->level_id == $level->id ? 'selected' : '' }}>{{ $level->region->name ?? '' }} - {{ $level->name }}</option>
                                @endforeach
                            </select>
                            @error('level_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Question Type</label>
                            <select name="type" id="type" x-model="questionType" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="multiple_choice">Multiple Choice</option>
                                <option value="fill_in">Fill in the Blank</option>
                            </select>
                            @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="question_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Question Text</label>
                            <textarea name="question_text" id="question_text" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('question_text', $question->question_text) }}</textarea>
                            @error('question_text') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Options for Multiple Choice -->
                        <div class="mb-4 p-4 border rounded-md dark:border-gray-700 bg-gray-50 dark:bg-gray-700" x-show="questionType === 'multiple_choice'">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Options (Fill out at least 2)</label>
                            @php $opts = $question->options ?? []; @endphp
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <input type="text" name="options[A]" value="{{ $opts['A'] ?? '' }}" placeholder="Option A" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <input type="text" name="options[B]" value="{{ $opts['B'] ?? '' }}" placeholder="Option B" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <input type="text" name="options[C]" value="{{ $opts['C'] ?? '' }}" placeholder="Option C" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <input type="text" name="options[D]" value="{{ $opts['D'] ?? '' }}" placeholder="Option D" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="correct_answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Correct Answer
                            </label>
                            <input type="text" name="correct_answer" id="correct_answer" value="{{ old('correct_answer', $question->correct_answer) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('correct_answer') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="explanation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Explanation (Optional)</label>
                            <textarea name="explanation" id="explanation" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('explanation', $question->explanation) }}</textarea>
                            @error('explanation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.questions.index') }}" class="inline-block px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 mr-2">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                                Update Question
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
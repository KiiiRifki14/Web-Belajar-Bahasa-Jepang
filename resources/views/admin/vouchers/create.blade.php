<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Generate New Mystery Gift') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ rType: 'koban' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('admin.vouchers.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Voucher Code</label>
                            <div class="flex space-x-2">
                                <input type="text" name="code" id="code" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white font-mono uppercase" placeholder="KADO-SPRING-2024">
                            </div>
                            @error('code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="reward_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reward Type</label>
                            <select name="reward_type" id="reward_type" x-model="rType" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="koban">Koban (Currency)</option>
                                <option value="item">Item (Inventory)</option>
                            </select>
                            @error('reward_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4" x-show="rType === 'koban'">
                            <label for="reward_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reward Amount (Koban)</label>
                            <input type="number" name="reward_amount" id="reward_amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="500">
                            @error('reward_amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4" x-show="rType === 'item'">
                            <label for="item_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reward Item</label>
                            <select name="item_id" id="item_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="" disabled selected>Select an Item</option>
                                @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->type }})</option>
                                @endforeach
                            </select>
                            @error('item_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="expires_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Expiration Date (Optional)</label>
                            <input type="date" name="expires_at" id="expires_at" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('expires_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.vouchers.index') }}" class="inline-block px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 mr-2 transition">
                                Cancel
                            </a>
                            <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded transition shadow-md">
                                Generate Voucher
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
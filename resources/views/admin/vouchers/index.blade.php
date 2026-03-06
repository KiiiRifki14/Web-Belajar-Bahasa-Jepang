<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Mystery Gifts (Vouchers)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Generated Vouchers</h3>
                        <a href="{{ route('admin.vouchers.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded transition shadow-md">
                            + Generate New Voucher
                        </a>
                    </div>

                    @if(session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Code</th>
                                    <th scope="col" class="py-3 px-6">Reward</th>
                                    <th scope="col" class="py-3 px-6">Status</th>
                                    <th scope="col" class="py-3 px-6">Expires At</th>
                                    <th scope="col" class="py-3 px-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vouchers as $voucher)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="py-4 px-6 font-mono font-bold text-gray-900 whitespace-nowrap dark:text-pink-400">
                                        {{ $voucher->code }}
                                    </th>
                                    <td class="py-4 px-6">
                                        @if($voucher->reward_type === 'koban')
                                        <span class="text-yellow-600 font-bold">{{ $voucher->reward_amount }} Koban</span>
                                        @else
                                        <span class="text-blue-600 font-bold">{{ $voucher->quantity }}x {{ $voucher->item->name ?? 'Deleted Item' }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($voucher->is_redeemed)
                                        <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Redeemed</span>
                                        @else
                                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Available</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ $voucher->expires_at ? $voucher->expires_at->format('M d, Y') : 'Never' }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <form action="{{ route('admin.vouchers.destroy', $voucher) }}" method="POST" onsubmit="return confirm('Delete this voucher?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-gray-500 italic">No vouchers generated. Click button above to create one.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard - Nihongo Odyssey') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                    <!-- Regions Card -->
                    <a href="{{ route('admin.regions.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Regions (Wilayah)</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">Manage learning regions and main story arcs.</p>
                    </a>

                    <!-- Levels Card -->
                    <a href="{{ route('admin.levels.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Levels</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">Configure quiz levels and boss battles within regions.</p>
                    </a>

                    <!-- Questions Card -->
                    <a href="{{ route('admin.questions.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Questions Bank</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">Add or edit multiple-choice and fill-in-the-blank questions.</p>
                    </a>

                    <!-- Items Card -->
                    <a href="{{ route('admin.items.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Shop & Items</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">Manage game items, skins, power-ups, and gacha vouchers.</p>
                    </a>

                    <!-- Secret Notes Card -->
                    <a href="{{ route('admin.secret_notes.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-indigo-600 dark:text-indigo-400">Secret Notes</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">Manage pool of dynamic motivational messages and lore notes.</p>
                    </a>

                    <!-- Vouchers Card -->
                    <a href="{{ route('admin.vouchers.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transition">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-pink-600 dark:text-pink-400">Mystery Gifts</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">Generate and manage reward vouchers for your students.</p>
                    </a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
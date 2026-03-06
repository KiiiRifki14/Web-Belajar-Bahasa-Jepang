@props(['class' => ''])

<div {{ $attributes->merge(['class' => "bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-opacity-10 p-6 manhua-outline $class"]) }} style="border-color: var(--theme-border);">
    {{ $slot }}
</div>

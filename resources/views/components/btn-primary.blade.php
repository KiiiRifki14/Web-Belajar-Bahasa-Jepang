@props(['size' => 'md'])

@php
$sizeClasses = [
    'sm' => 'px-4 py-2 text-xs',
    'md' => 'px-6 py-3 text-sm',
    'lg' => 'px-8 py-4 text-base',
];
$sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<button {{ $attributes->merge(['class' => "$sizeClass bg-[var(--theme-primary)] text-white dark:text-gray-900 rounded-xl font-black uppercase tracking-widest shadow-lg hover:scale-105 transition-transform active:scale-95 focus:outline-none focus:ring-2 focus:ring-offset-2" ]) }} style="--theme-primary-ring: var(--theme-primary);">
    {{ $slot }}
</button>

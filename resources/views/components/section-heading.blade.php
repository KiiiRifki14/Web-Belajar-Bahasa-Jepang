@props(['title', 'subtitle' => null])

<div class="flex items-center justify-between mb-6 md:mb-8">
    <div>
        <h2 class="text-heading text-[var(--theme-text)] uppercase tracking-widest italic border-l-4 border-[var(--theme-primary)] pl-4">
            {{ $title }}
        </h2>
        @if($subtitle)
        <p class="text-label text-gray-400 mt-2 opacity-70">
            {{ $subtitle }}
        </p>
        @endif
    </div>
    {{ $slot ?? '' }}
</div>

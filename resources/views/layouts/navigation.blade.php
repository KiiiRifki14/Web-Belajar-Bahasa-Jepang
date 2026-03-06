<nav x-data="{ open: false }" class="sticky top-0 z-50 transition-all duration-300"
    style="background: rgba(255,255,255,0.65); backdrop-filter: blur(24px) saturate(180%); -webkit-backdrop-filter: blur(24px) saturate(180%); border-bottom: 1px solid rgba(255,255,255,0.6); box-shadow: 0 4px 20px rgba(0,0,0,0.04);">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo + Desktop Nav -->
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group shrink-0">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xl transition-all duration-300 group-hover:scale-110 group-hover:rotate-6"
                        style="background: linear-gradient(135deg, #fce7f1, #f0f7f1); border: 1px solid rgba(255,255,255,0.8); box-shadow: 0 2px 8px rgba(242,123,181,0.2);">
                        💮
                    </div>
                    <span class="font-black text-[11px] uppercase tracking-[0.25em] text-slate-700 hidden sm:block">Nihongo Odyssey</span>
                </a>

                <!-- Desktop links -->
                <div class="hidden md:flex items-center gap-1">
                    @php
                    $navItems = [
                    ['route' => 'dashboard', 'label' => 'Beranda', 'icon' => '🏯'],
                    ['route' => 'store.index', 'label' => 'Pasar', 'icon' => '🏮'],
                    ['route' => 'black_book.index', 'label' => 'Buku Hitam', 'icon' => '📜'],
                    ['route' => 'album.index', 'label' => 'Kenangan', 'icon' => '🖼️'],
                    ];
                    @endphp
                    @foreach($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-[11px] font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs($item['route'].'*') ? 'text-pink-600 bg-pink-50/80' : 'text-slate-500 hover:text-slate-800 hover:bg-white/60' }}">
                        <span class="text-sm">{{ $item['icon'] }}</span>
                        {{ $item['label'] }}
                    </a>
                    @endforeach
                    @auth
                    @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-[11px] font-bold uppercase tracking-widest transition-all duration-200 {{ request()->routeIs('admin.*') ? 'text-violet-600 bg-violet-50/80' : 'text-slate-500 hover:text-violet-600 hover:bg-violet-50/60' }}">
                        <span class="text-sm">⚙️</span> Admin
                    </a>
                    @endif
                    @endauth
                </div>
            </div>

            <!-- Right side: User stats + Avatar -->
            <div class="hidden sm:flex items-center gap-3">
                @auth
                <!-- Quick stats pill -->
                <div class="flex items-center gap-3 px-4 py-2 rounded-full text-[11px] font-bold"
                    style="background: rgba(255,255,255,0.7); border: 1px solid rgba(255,255,255,0.8); box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <span title="Streak">🔥 {{ Auth::user()->current_streak }}</span>
                    <span class="w-px h-4 bg-slate-200"></span>
                    <span title="Koban">🪙 {{ number_format(Auth::user()->koban ?? 0) }}</span>
                    <span class="w-px h-4 bg-slate-200"></span>
                    <span title="Paw Points">🐾 {{ Auth::user()->paw_points ?? 0 }}</span>
                </div>

                <!-- User dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-bold text-slate-600 transition-all duration-200 hover:bg-white/60 hover:text-slate-900">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center text-base" style="background: linear-gradient(135deg, #fce7f1, #e8f4ec);">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-[11px] uppercase tracking-widest max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth
            </div>

            <!-- Hamburger -->
            <button @click="open = !open"
                class="sm:hidden p-2.5 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-white/60 transition-all"
                aria-label="Menu">
                <svg class="w-5 h-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-white/40"
        style="background: rgba(255,255,255,0.75); backdrop-filter: blur(20px);">
        <div class="px-4 pt-2 pb-4 space-y-1">
            @php
            $mobileItems = [
            ['route' => 'dashboard', 'label' => 'Beranda', 'icon' => '🏯'],
            ['route' => 'store.index', 'label' => 'Pasar Koban', 'icon' => '🏮'],
            ['route' => 'black_book.index', 'label' => 'Buku Hitam', 'icon' => '📜'],
            ['route' => 'album.index', 'label' => 'Buku Kenangan', 'icon' => '🖼️'],
            ];
            @endphp
            @foreach($mobileItems as $item)
            <a href="{{ route($item['route']) }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs($item['route'].'*') ? 'bg-pink-50 text-pink-700' : 'text-slate-600 hover:bg-white/70 hover:text-slate-900' }}">
                <span>{{ $item['icon'] }}</span> {{ $item['label'] }}
            </a>
            @endforeach
            @auth
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold text-violet-600 hover:bg-violet-50">
                <span>⚙️</span> Kuil Admin
            </a>
            @endif
            @endauth
        </div>
        @auth
        <div class="px-4 pb-4 border-t border-white/40 pt-3">
            <div class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/50">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-lg" style="background: linear-gradient(135deg, #fce7f1, #e8f4ec);">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-bold text-sm text-slate-800">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-2 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>
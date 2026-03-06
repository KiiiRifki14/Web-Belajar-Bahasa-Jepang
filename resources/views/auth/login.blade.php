<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="mb-8">
        <h3 class="text-3xl font-bold text-slate-800 mb-2 font-serif drop-shadow-sm">Selamat Datang 👋</h3>
        <p class="text-sm text-slate-600 font-medium leading-relaxed">Silakan masuk untuk melanjutkan petualangan belajarmu di Nihongo Odyssey.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="relative">
            <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-700 mb-2 block ml-2">Alamat Email</label>
            <input id="email" class="w-full bg-white/80 backdrop-blur-md border border-slate-300 focus:border-sakura-500 focus:ring focus:ring-sakura-200 focus:ring-opacity-50 focus:bg-white rounded-2xl p-4 outline-none transition-all font-semibold text-slate-900 shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="relative">
            <div class="flex items-center justify-between mb-2 ml-2">
                <label for="password" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-700 block">Kata Sandi</label>
                @if (Route::has('password.request'))
                <a class="text-[10px] font-bold text-sakura-600 hover:text-sakura-800 transition-colors uppercase tracking-widest bg-white/50 px-3 py-1 rounded-full" href="{{ route('password.request') }}">
                    Lupa?
                </a>
                @endif
            </div>

            <input id="password" class="w-full bg-white/80 backdrop-blur-md border border-slate-300 focus:border-sakura-500 focus:ring focus:ring-sakura-200 focus:ring-opacity-50 focus:bg-white rounded-2xl p-4 outline-none transition-all font-semibold text-slate-900 shadow-sm"
                type="password"
                name="password"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center ml-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded bg-white border-slate-400 text-sakura-600 shadow-sm focus:border-sakura-400 focus:ring focus:ring-sakura-200 focus:ring-opacity-50 w-5 h-5 transition-all">
                <span class="ms-3 text-sm font-bold text-slate-600 group-hover:text-slate-900 transition-colors">Ingat Saya</span>
            </label>
        </div>

        <div class="pt-6 flex flex-col gap-4">
            <button type="submit" class="w-full bg-sakura-600 border border-sakura-600 text-white font-black py-4 rounded-full text-xs uppercase tracking-[0.3em] shadow-[0_5px_15px_-3px_rgba(242,123,181,0.6)] hover:-translate-y-1 hover:bg-sakura-700 transition-all duration-300 active:scale-95">
                Masuk Sekarang
            </button>

            <p class="text-center text-xs font-bold text-slate-600 mt-2 bg-white/50 py-3 rounded-full border border-white/60">
                Belum punya akun? <a href="{{ route('register') }}" class="text-sakura-700 font-black hover:text-sakura-900 underline decoration-2 underline-offset-4 transition-colors ml-1">Daftar di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>
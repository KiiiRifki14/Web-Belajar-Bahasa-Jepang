<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="mb-8">
        <h3 class="text-2xl font-black text-stone-800 mb-1">Selamat Datang 👋</h3>
        <p class="text-xs text-stone-500 font-medium leading-relaxed">Silakan masuk untuk melanjutkan petualangan belajarmu di Nihongo Odyssey.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400 mb-2 block">Alamat Email</label>
            <input id="email" class="w-full bg-white/50 border-2 border-transparent focus:border-pink-200 focus:bg-white rounded-2xl p-4 outline-none transition-all font-bold text-stone-700" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400 block">Kata Sandi</label>
                @if (Route::has('password.request'))
                <a class="text-[10px] font-black text-pink-400 hover:text-pink-600 transition-colors uppercase tracking-widest" href="{{ route('password.request') }}">
                    Lupa?
                </a>
                @endif
            </div>

            <input id="password" class="w-full bg-white/50 border-2 border-transparent focus:border-pink-200 focus:bg-white rounded-2xl p-4 outline-none transition-all font-bold text-stone-700"
                type="password"
                name="password"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded-lg bg-white/50 border-transparent text-pink-500 focus:ring-pink-200 w-5 h-5 transition-all" name="remember">
                <span class="ms-3 text-xs font-bold text-stone-500 group-hover:text-stone-700 transition-colors">Ingat Saya</span>
            </label>
        </div>

        <div class="pt-4 flex flex-col gap-4">
            <button type="submit" class="w-full bg-stone-800 text-white py-5 rounded-[2rem] font-black text-xs uppercase tracking-[0.3em] shadow-xl hover:-translate-y-1 transition-all active:scale-95 shadow-stone-200">
                Masuk Sekarang
            </button>

            <p class="text-center text-[10px] font-bold text-stone-400">
                Belum punya akun? <a href="{{ route('register') }}" class="text-pink-500 underline decoration-2 underline-offset-4">Daftar di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>
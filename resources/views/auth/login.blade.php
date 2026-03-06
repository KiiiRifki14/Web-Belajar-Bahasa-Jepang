<x-guest-layout>
    <x-auth-session-status class="mb-5 text-center text-sm font-bold text-green-600 bg-green-50/80 py-3 rounded-2xl px-4" :status="session('status')" />

    <div class="mb-8">
        <h3 class="font-serif text-3xl font-bold text-slate-800 leading-tight mb-2">Selamat Datang 👋</h3>
        <p class="text-sm text-slate-500 font-medium leading-relaxed">Masuk untuk melanjutkan petualangan belajarmu.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="text-label text-slate-500 tracking-[0.25em] mb-2 block ml-1">Alamat Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                class="input-manhua w-full" placeholder="nama@contoh.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-500 ml-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2 mx-1">
                <label for="password" class="text-label text-slate-500 tracking-[0.25em]">Kata Sandi</label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-[10px] font-bold uppercase tracking-widest text-pink-500 hover:text-pink-700 transition-colors px-3 py-1 rounded-full hover:bg-pink-50">
                    Lupa?
                </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="input-manhua w-full" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-500 ml-1" />
        </div>

        <!-- Remember me -->
        <div class="flex items-center gap-3 ml-1">
            <input id="remember_me" type="checkbox" name="remember"
                class="w-5 h-5 rounded-lg text-pink-500 border-slate-300 focus:ring-pink-300 transition-all">
            <label for="remember_me" class="text-sm font-bold text-slate-500 cursor-pointer hover:text-slate-700 transition-colors select-none">
                Ingat Saya
            </label>
        </div>

        <!-- Submit -->
        <div class="pt-3 space-y-4">
            <button type="submit" class="btn-primary-manhua">
                Masuk Sekarang
            </button>
            <p class="text-center text-xs font-bold text-slate-500 py-3 rounded-full border border-white/60"
                style="background: rgba(255,255,255,0.5);">
                Belum punya akun?
                <a href="{{ route('register') }}"
                    class="text-pink-600 font-black hover:text-pink-800 underline decoration-2 underline-offset-3 ml-1 transition-colors">
                    Daftar di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
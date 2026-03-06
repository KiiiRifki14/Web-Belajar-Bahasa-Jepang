<x-guest-layout>
    <div class="mb-8">
        <h3 class="text-3xl font-bold text-slate-800 mb-2 font-serif drop-shadow-sm">Mulai Odyssey 🏮</h3>
        <p class="text-sm text-slate-600 font-medium leading-relaxed">Buat akun barumu dan bersiaplah menginjakkan kaki di Tokyo impianmu.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div class="relative">
            <label for="name" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-700 mb-2 block ml-2">Nama Lengkap</label>
            <input id="name" class="w-full bg-white/80 backdrop-blur-md border border-slate-300 focus:border-sakura-500 focus:ring focus:ring-sakura-200 focus:ring-opacity-50 focus:bg-white rounded-2xl p-4 outline-none transition-all font-semibold text-slate-900 shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div class="relative">
            <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-700 mb-2 block ml-2">Alamat Email</label>
            <input id="email" class="w-full bg-white/80 backdrop-blur-md border border-slate-300 focus:border-sakura-500 focus:ring focus:ring-sakura-200 focus:ring-opacity-50 focus:bg-white rounded-2xl p-4 outline-none transition-all font-semibold text-slate-900 shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="relative">
            <label for="password" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-700 mb-2 block ml-2">Kata Sandi</label>
            <input id="password" class="w-full bg-white/80 backdrop-blur-md border border-slate-300 focus:border-sakura-500 focus:ring focus:ring-sakura-200 focus:ring-opacity-50 focus:bg-white rounded-2xl p-4 outline-none transition-all font-semibold text-slate-900 shadow-sm"
                type="password"
                name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="relative">
            <label for="password_confirmation" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-700 mb-2 block ml-2">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" class="w-full bg-white/80 backdrop-blur-md border border-slate-300 focus:border-sakura-500 focus:ring focus:ring-sakura-200 focus:ring-opacity-50 focus:bg-white rounded-2xl p-4 outline-none transition-all font-semibold text-slate-900 shadow-sm"
                type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-6 flex flex-col gap-4">
            <button type="submit" class="w-full bg-sakura-600 border border-sakura-600 text-white font-black py-4 rounded-full text-xs uppercase tracking-[0.3em] shadow-[0_5px_15px_-3px_rgba(242,123,181,0.6)] hover:-translate-y-1 hover:bg-sakura-700 transition-all duration-300 active:scale-95">
                Daftar & Mulai
            </button>

            <p class="text-center text-xs font-bold text-slate-600 mt-2 bg-white/50 py-3 rounded-full border border-white/60">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-sakura-700 font-black hover:text-sakura-900 underline decoration-2 underline-offset-4 transition-colors ml-1">Masuk di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>
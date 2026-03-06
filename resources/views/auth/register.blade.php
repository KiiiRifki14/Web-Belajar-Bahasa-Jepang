<x-guest-layout>
    <div class="mb-8">
        <h3 class="text-2xl font-black text-stone-800 mb-1">Mulai Odyssey 🏮</h3>
        <p class="text-xs text-stone-500 font-medium leading-relaxed">Buat akun barumu dan bersiaplah menginjakkan kaki di Tokyo impianmu.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400 mb-2 block">Nama Lengkap</label>
            <input id="name" class="w-full bg-white/50 border-2 border-transparent focus:border-pink-200 focus:bg-white rounded-2xl p-4 outline-none transition-all font-bold text-stone-700" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400 mb-2 block">Alamat Email</label>
            <input id="email" class="w-full bg-white/50 border-2 border-transparent focus:border-pink-200 focus:bg-white rounded-2xl p-4 outline-none transition-all font-bold text-stone-700" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400 mb-2 block">Kata Sandi</label>
            <input id="password" class="w-full bg-white/50 border-2 border-transparent focus:border-pink-200 focus:bg-white rounded-2xl p-4 outline-none transition-all font-bold text-stone-700"
                type="password"
                name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-400 mb-2 block">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" class="w-full bg-white/50 border-2 border-transparent focus:border-pink-200 focus:bg-white rounded-2xl p-4 outline-none transition-all font-bold text-stone-700"
                type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-4 flex flex-col gap-4">
            <button type="submit" class="w-full bg-stone-800 text-white py-5 rounded-[2rem] font-black text-xs uppercase tracking-[0.3em] shadow-xl hover:-translate-y-1 transition-all active:scale-95 shadow-stone-200">
                Daftar & Mulai
            </button>

            <p class="text-center text-[10px] font-bold text-stone-400">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-pink-500 underline decoration-2 underline-offset-4">Masuk di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>
<x-guest-layout>
    <div class="mb-8">
        <h3 class="font-serif text-3xl font-bold text-slate-800 leading-tight mb-2">Mulai Odyssey 🏮</h3>
        <p class="text-sm text-slate-500 font-medium leading-relaxed">Buat akun dan bersiaplah menginjakkan kaki di Tokyo impianmu.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="text-label text-slate-500 tracking-[0.25em] mb-2 block ml-1">Nama Lengkap</label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                class="input-manhua w-full" placeholder="Nama Pahlawanmu">
            <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-red-500 ml-1" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="text-label text-slate-500 tracking-[0.25em] mb-2 block ml-1">Alamat Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                class="input-manhua w-full" placeholder="nama@contoh.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-500 ml-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="text-label text-slate-500 tracking-[0.25em] mb-2 block ml-1">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="input-manhua w-full" placeholder="Min. 8 karakter">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-500 ml-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="text-label text-slate-500 tracking-[0.25em] mb-2 block ml-1">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="input-manhua w-full" placeholder="Ulangi kata sandi">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-red-500 ml-1" />
        </div>

        <!-- Submit -->
        <div class="pt-3 space-y-4">
            <button type="submit" class="btn-primary-manhua">
                Daftar & Mulai Odyssey 🌸
            </button>
            <p class="text-center text-xs font-bold text-slate-500 py-3 rounded-full border border-white/60"
                style="background: rgba(255,255,255,0.5);">
                Sudah punya akun?
                <a href="{{ route('login') }}"
                    class="text-pink-600 font-black hover:text-pink-800 underline decoration-2 underline-offset-3 ml-1 transition-colors">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
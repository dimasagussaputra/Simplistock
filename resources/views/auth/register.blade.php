<x-guest-layout>
    <div class="text-center mb-4">
        <div style="font-size: 52px; line-height: 1; color: #0d6efd;">
            <i class="bi bi-boxes"></i>
        </div>

        <div style="font-size: 30px; font-weight: 700; color: #0d6efd; margin-top: 8px;">
            Simplistock
        </div>

        <div style="font-size: 14px; color: #6c757d; margin-top: 4px;">
            Sistem Manajemen Stok Barang
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Username')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" placeholder="your_username" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-6">
            <button type="submit"
                class="w-full flex justify-center items-center px-4 py-2 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150"
                style="background-color: #0d6efd;" onmouseover="this.style.backgroundColor='#0b5ed7'"
                onmouseout="this.style.backgroundColor='#0d6efd'">
                {{ __('Register') }}
            </button>
        </div>

        <div class="mt-4 text-center text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium hover:underline" style="color: #0d6efd;">
                Login here
            </a>
        </div>
    </form>
</x-guest-layout>
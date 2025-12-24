<x-guest-layout>
    <div class="login-page">
        <div class="login-card">
            <!-- Logo/Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    Warung Madura Online
                </h1>
                <p class="text-gray-600">Silakan login untuk melanjutkan</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label class="form-label" for="email">Email</label>
                    <input
                        id="email"
                        class="form-input"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="nama@email.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input
                        id="password"
                        class="form-input"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Masukkan password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            class="rounded border-gray-300 text-[#CC561E] focus:ring-[#CC561E]"
                            name="remember"
                        />
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex flex-col gap-4">
                    <button type="submit" class="btn-primary w-full">
                        Masuk
                    </button>

                    @if (Route::has('password.request'))
                        <a
                            class="text-sm text-gray-600 hover:text-[#CC561E] text-center"
                            href="{{ route('password.request') }}"
                        >
                            Lupa password?
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <div class="text-center text-sm text-gray-600">
                            Belum punya akun?
                            <a
                                href="{{ route('register') }}"
                                class="font-semibold text-[#CC561E] hover:text-[#A84518]"
                            >
                                Daftar di sini
                            </a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

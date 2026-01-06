<x-guest-layout>
    <div class="w-full max-w-md mx-auto bg-white rounded-2xl shadow-lg p-8">

        <h2 class="text-2xl font-bold text-center text-gray-800">
            Warung Madura Online
        </h2>

        <p class="text-center text-gray-500 mb-6">
            Silakan daftar untuk melanjutkan
        </p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nama -->
            <div class="mb-4">
                <x-input-label for="name" value="Nama" />
                <x-text-input id="name" name="name" type="text"
                    class="mt-1 block w-full"
                    placeholder="Nama lengkap"
                    required autofocus />
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email"
                    class="mt-1 block w-full"
                    placeholder="nama@email.com"
                    required />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <!-- Role -->
            <div class="mb-4">
                <x-input-label for="role" value="Daftar sebagai" />
                <select name="role" id="role"
                    class="block w-full mt-1 rounded-lg border-gray-300
                    focus:border-[#CC561E] focus:ring-[#CC561E]">
                    <option value="pelanggan">Pelanggan</option>
                    <option value="pembeli">Pembeli</option>
                    <option value="penjual">Penjual</option>
                </select>
                <x-input-error :messages="$errors->get('role')" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" name="password" type="password"
                    class="mt-1 block w-full"
                    placeholder="Masukkan password"
                    required />
            </div>

            <!-- Konfirmasi -->
            <div class="mb-6">
                <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                <x-text-input id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="Ulangi password"
                    required />
            </div>

            <button type="submit"
                class="w-full bg-[#CC561E] hover:bg-[#b84c1a]
                text-white font-semibold py-2 rounded-lg transition">
                Daftar
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-[#CC561E] font-semibold hover:underline">
                Login di sini
            </a>
        </p>
    </div>
</x-guest-layout>
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nama" />
            <x-text-input id="name" name="name" type="text" required autofocus />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" required />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- ROLE -->
        <div class="mt-4">
            <x-input-label for="role" value="Daftar sebagai" />

            <select name="role" id="role"
                class="block mt-1 w-full rounded-lg border-gray-300 focus:border-[#CC561E] focus:ring-[#CC561E]">
                <option value="pembeli">Pembeli</option>
                <option value="penjual">Penjual</option>
            </select>

            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>


        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" name="password" type="password" required />
        </div>

        <!-- Confirm -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" required />
        </div>

        <div class="flex justify-end mt-6">
            <x-primary-button>Daftar</x-primary-button>
        </div>
    </form>
</x-guest-layout>

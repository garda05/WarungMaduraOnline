<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 text-center">
        <div class="bg-white p-10 rounded-xl shadow">
            <div class="text-6xl mb-4">🛒</div>
            <h2 class="text-2xl font-bold mb-2">
                Wah, keranjang belanjamu kosong
            </h2>
            <p class="text-gray-500">
                Yuk pilih menu favoritmu dulu!
            </p>

            <a href="{{ route('dashboard') }}"
               class="inline-block mt-6 bg-[#CC561E] text-white px-6 py-2 rounded-lg">
                Lihat Menu
            </a>
        </div>
    </div>
</x-app-layout>

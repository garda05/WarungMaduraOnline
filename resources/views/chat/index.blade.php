<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">
        <div class="bg-white rounded-xl shadow flex flex-col h-[500px]">

            <!-- CHAT AREA -->
            <div class="flex-1 p-6 overflow-y-auto space-y-2">
                @forelse ($messages as $message)
                    <div class="text-sm">
                        <strong>{{ optional($message->user)->name ?? 'User' }}:</strong>
                        {{ $message->content }}
                    </div>
                @empty
                    <div class="text-center text-gray-500">
                        Belum ada pesan
                    </div>
                @endforelse
            </div>

            <!-- INPUT -->
            <form
                action="{{ route('chat.send') }}"
                method="POST"
                class="border-t p-4 flex gap-2"
            >
                @csrf
                <input
                    type="text"
                    name="content"
                    placeholder="Ketik pesan..."
                    class="flex-1 border rounded-lg px-4 py-2"
                    required
                >
                <button class="bg-[#CC561E] text-white px-5 rounded-lg">
                    Kirim
                </button>
            </form>

        </div>
    </div>
</x-app-layout>

@include('General.header')
<div class="p-8 mt-14">
    <h1 class="text-3xl font-semibold mb-6 text-gray-800">Semua Notifikasi</h1>

    <!-- Tombol Back -->
    <button onclick="window.history.back()"
        class="inline-flex items-center gap-2 mb-6 rounded-md bg-[#183E74] hover:bg-[#1a4a91] px-5 py-2.5 text-white font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
        aria-label="Kembali ke halaman sebelumnya">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali
    </button>

    <div class="bg-white rounded-lg shadow-lg divide-y divide-gray-200">
        @forelse ($notifications as $notif)
            <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between
                                                        {{ !$notif->is_read ? 'bg-blue-50 border-l-4 border-blue-600' : 'hover:bg-gray-50' }}
                                                        transition duration-300 cursor-default" role="listitem"
                tabindex="0" aria-label="Notifikasi dari {{ $notif->sender_name }}">
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 w-full">
                    <div class="flex-shrink-0 mb-2 sm:mb-0">
                        <div
                            class="h-12 w-12 rounded-full bg-gray-600 flex items-center justify-center text-white font-bold text-lg">
                            {{ strtoupper(substr($notif->sender_name, 0, 2)) }}
                        </div>
                    </div>
                    <div class="flex-grow min-w-0">
                        <p class="font-semibold text-gray-900 truncate">{{ $notif->sender_name }}</p>
                        <p class="mt-1 text-gray-700 leading-relaxed line-clamp-2">{!! $notif->message !!}</p>
                    </div>
                </div>
                <div class="mt-3 sm:mt-0 sm:text-right text-gray-400 text-xs whitespace-nowrap">
                    {{ $notif->created_at->diffForHumans() }}
                </div>
            </div>
        @empty
            <p class="p-6 text-center text-gray-500 italic">Tidak ada notifikasi.</p>
        @endforelse
    </div>

    <form method="POST" action="{{ route('notifications.markAllAsRead') }}" class="mt-6 text-left">
        @csrf
        <button type="submit"
            class="inline-block rounded-md bg-[#183E74] hover:bg-[#1a4a91] px-6 py-2 text-white shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            Tandai Semua Telah Dibaca
        </button>
    </form>
</div>

@include('General.footer')
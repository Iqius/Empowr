<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Semua Notifikasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="max-w-2xl mx-auto py-6">
        <h2 class="text-xl font-bold mb-4">Semua Notifikasi</h2>

        <!-- Tombol Back -->
        <button onclick="window.history.back()" class="text-white bg-blue-600 hover:bg-blue-700 rounded-md px-4 py-2 mb-4">
            Kembali
        </button>

        <div class="bg-white shadow-md rounded-md">
            @forelse ($notifications as $notif)
            <div class="border-b p-4 {{ !$notif->is_read ? 'bg-gray-50' : '' }}">
                <p class="font-semibold">{{ $notif->sender_name }}</p>
                <p class="text-gray-700">{!! $notif->message !!}</p>
                <p class="text-xs text-gray-500">{{ $notif->created_at->diffForHumans() }}</p>
            </div>
            @empty
            <p class="p-4 text-gray-500">Tidak ada notifikasi.</p>
            @endforelse
        </div>
        <form method="POST" action="{{ route('notifications.markAllAsRead') }}">
            @csrf
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 rounded-md px-4 py-2 mb-4 mt-3">Tandai Semua sebagai Dibaca</button>
        </form>
    </div>

</body>

</html>
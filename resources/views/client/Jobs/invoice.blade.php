@include('General.header')

<section class="p-4 mt-16">
    <div class="bg-white p-6 rounded-lg shadow max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-blue-600 mb-4">Invoice</h1>

        <div class="space-y-4 text-sm text-gray-700">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="font-semibold">Order ID:</p>
                    <p>#{{ $task->id }}</p>
                </div>
                <div>
                    <p class="font-semibold">Nama Klien:</p>
                    <p>{{ $task->client->nama_lengkap ?? '[Nama tidak tersedia]' }}</p>
                </div>
                <div>
                    <p class="font-semibold">Judul Pekerjaan:</p>
                    <p>{{ $task->title }}</p>
                </div>
                <div>
                    <p class="font-semibold">Deadline:</p>
                    <p>{{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="font-semibold">Jumlah Revisi:</p>
                    <p>{{ $task->revisions }}</p>
                </div>
            </div>

            <hr class="my-4">

            <div>
                <p class="font-semibold text-gray-700 mb-1">Harga:</p>
                <p class="text-2xl font-bold text-green-600">
                    Rp {{ number_format($task->price, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="mt-6 text-sm text-gray-600">
            <p>Terima kasih telah menggunakan layanan Empowr!</p>
        </div>
    </div>
</section>

@include('General.footer')
@include('client.header')

<div class="p-6 max-w-4xl mt-12 mx-auto space-y-6">
    <!-- Title -->
    <h1 class="text-2xl font-bold text-blue-600">{{ $job->title }}</h1>

    <!-- Price -->
    <p class="text-black font-bold text-xl">
        Rp {{ isset($job->price) ? number_format($job->price, 0, ',', '.') : '[Harga belum diisi]' }}
    </p>

    <!-- Author -->
    <p class="text-gray-500 text-sm">
        By {{ $job->user->name ?? 'Unknown' }}
    </p>

    <hr class="my-4">

    <!-- Description -->
    <div>
        <h2 class="text-lg font-semibold text-gray-700">Deskripsi</h2>
        <p class="text-gray-600 mt-1">{{ $job->description ?? '[Belum ada deskripsi]' }}</p>
    </div>

    <!-- Revisions -->
    <div>
        <h2 class="text-lg font-semibold text-gray-700">Jumlah Revisi</h2>
        <p class="text-gray-600 mt-1">{{ $job->revisions ?? '[Belum ditentukan]' }}</p>
    </div>

    <!-- End Date -->
    <div>
        <h2 class="text-lg font-semibold text-gray-700">Tanggal Berakhir</h2>
        <p class="text-gray-600 mt-1">{{ $job->end_date ?? '[Belum ditentukan]' }}</p>
    </div>

    <!-- Type -->
    <div>
        <h2 class="text-lg font-semibold text-gray-700">Tipe Pekerjaan</h2>
        <p class="text-gray-600 mt-1">{{ ucfirst($job->type ?? '[Belum ditentukan]') }}</p>
    </div>

    <!-- Provisions -->
    <div>
        <h2 class="text-lg font-semibold text-gray-700">Ketentuan</h2>
        <p class="text-gray-600 mt-1">{{ $job->provisions ?? '[Belum ada ketentuan]' }}</p>
    </div>

    <!-- File Upload (Placeholder Info) -->
    <div>
        <h2 class="text-lg font-semibold text-gray-700">File Terkait</h2>
        <p class="text-gray-600 mt-1">[Belum ada file yang diunggah]</p>
    </div>
</div>

<!-- Button Daftar -->
<button id="applyBtn" class="fixed bottom-6 right-6 bg-blue-600 text-white px-6 py-3 rounded shadow-lg hover:bg-blue-700 transition">
    Daftar
</button>

@include('client.footer')


<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("applyBtn")?.addEventListener("click", function () {
            Swal.fire({
    title: 'Ajukan Pendaftaran',
    html: `
    <div class="text-left space-y-4">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Nego Harga</label>
            <input id="negoHarga" type="number" class="swal2-input" value="{{ $job->price }}" />
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Catatan (opsional)</label>
            <textarea id="noteField" class="swal2-textarea" placeholder="Tulis catatan tambahan di sini..."></textarea>
        </div>
    </div>
`,

    showCancelButton: true,
    confirmButtonText: 'Daftar',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#2563EB',
    preConfirm: () => {
    const note = document.getElementById('noteField').value;
    const nego = document.getElementById('negoHarga').value;
    return { note, nego };
}

}).then((result) => {
    if (result.isConfirmed) {
        Swal.fire({
            icon: 'success',
            title: 'Pendaftaran Diajukan!',
            text: `Harga yang diajukan: Rp ${Number(result.value.nego).toLocaleString('id-ID')} \n` + 
      (result.value.note ? 'Catatan: ' + result.value.note : 'Tanpa catatan.'),
            confirmButtonColor: '#2563EB'
        });

    }
});

        });
    });
</script>

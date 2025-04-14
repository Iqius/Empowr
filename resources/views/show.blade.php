@include('client.header')

<form id="applyForm" action="{{ route('task.apply', $job->id) }}" method="POST">
    @csrf
    <!-- Hidden Inputs -->
    <input type="hidden" name="bidPrice" id="formBidPrice">
    <input type="hidden" name="catatan" id="formCatatan">
    <div class="p-6 max-w-4xl mt-12 mx-auto space-y-6">
        <!-- Title -->
        <h1 class="text-2xl font-bold text-blue-600">{{ $job->title }}</h1>

        <!-- Price -->
        <p class="text-black font-bold text-xl">
            Rp {{ isset($job->price) ? number_format($job->price, 0, ',', '.') : '[Harga belum diisi]' }}
        </p>

        <!-- Author -->
        <p class="text-gray-500 text-sm">
            By {{ $job->user->nama_lengkap ?? 'Unknown' }}
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
            <p class="text-gray-600 mt-1">{{ $job->deadline ?? '[Belum ditentukan]' }}</p>
        </div>

        @php
            $typeLabels = [
                'it' => 'IT',
                'nonIT' => 'Non IT',
            ];
        @endphp

        <!-- Type -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700">Tipe Pekerjaan</h2>
            <p class="text-gray-600 mt-1">{{ $typeLabels[$job->taskType] ?? '[Belum ditentukan]' }}</p>
        </div>


        <!-- Provisions -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700">Ketentuan</h2>
            <p class="text-gray-600 mt-1">{{ $job->provisions ?? '[Belum ada ketentuan]' }}</p>
        </div>

        <!-- File Upload (Placeholder Info) -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700">File Terkait</h2>

            @if ($job->job_file)
                {{-- Cek apakah file adalah gambar --}}
                @php
                    $ext = pathinfo($job->job_file, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                @endphp

                @if ($isImage)
                    <img src="{{ asset('storage/' . $job->job_file) }}" alt="Preview File"
                        class="w-64 h-auto rounded shadow mt-2">
                @endif

                <p class="mt-2">
                    <a href="{{ asset('storage/' . $job->job_file) }}" download class="text-blue-600 hover:underline">
                        Download File
                    </a>
                </p>
            @else
                <p class="text-gray-600 mt-1">[File belum diunggah]</p>
            @endif
        </div>
        <!-- Button Daftar -->
        @auth
            @if (Auth::user()->role === 'worker')
                <button type="button" id="applyBtn"
                    class="fixed bottom-6 right-6 bg-blue-600 text-white px-6 py-3 rounded shadow-lg hover:bg-blue-700 transition">
                    Daftar
                </button>
            @endif
        @endauth
    </div>
</form>


@include('client.footer')


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("applyForm");

        document.getElementById("applyBtn")?.addEventListener("click", function() {
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
                    return {
                        nego: document.getElementById('negoHarga').value,
                        note: document.getElementById('noteField').value
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Masukkan ke input hidden
                    document.getElementById("formBidPrice").value = result.value.nego;
                    document.getElementById("formCatatan").value = result.value.note;

                    // Submit form
                    form.submit();
                }
            });
        });
    });
</script>

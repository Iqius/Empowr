@include('General.header')

{{-- Konten utama --}}
<div class="max-w-7xl mx-auto bg-white p-6 rounded shadow-md mt-20">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold ">Daftar Semua Worker</h1>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border text-center whitespace-nowrap min-w-[150px]">Worker ID</th>
                    <th class="px-4 py-2 border text-center whitespace-nowrap min-w-[150px]">Nama Worker</th>
                    <th class="px-4 py-2 border text-center whitespace-nowrap min-w-[150px]">Username Worker</th>
                    <th class="px-4 py-2 border text-center whitespace-nowrap min-w-[150px]">Empowr Affiliate</th>
                    <th class="px-4 py-2 border text-center whitespace-nowrap min-w-[150px]">Action Empowr Affiliate</th>
                </tr>
            </thead>
            <tbody>
                @forelse($workers as $worker)
                <tr>
                    <td class="px-4 py-2 border text-center whitespace-nowrap min-w-[150px]">{{ $worker->id }}</td>
                    <td class="px-4 py-2 border text-center whitespace-nowrap min-w-[150px]">{{ $worker->user->nama_lengkap ?? '-' }}</td>
                    <td class="px-4 py-2 border text-center whitespace-nowrap min-w-[150px]">{{ $worker->user->username ?? '-' }}</td>
                    <td class="px-4 py-2 border text-center whitespace-nowrap min-w-[150px]">{{ $worker->empowr_affiliate ? 'Affiliate' : 'Bukan Affiliate' }}</td>


                    {{-- Action Empowr Affiliate --}}
                    <td class="px-4 py-2 border text-center">
                        @if(!$worker->empowr_affiliate)
                        {{-- Tombol Jadikan Affiliate --}}
                        <form action="{{ route('user.updateAffiliate', $worker->id) }}" method="POST" class="inline-block confirm-label-form" data-name="affiliate" data-message="Setuju Memberikan Affiliate?">
                            @csrf
                            <button class="bg-blue-500 text-white px-3 py-1 rounded">
                                Jadikan Affiliate
                            </button>
                        </form>
                        @else
                        {{-- Tombol Hapus Affiliate --}}
                        <form action="{{ route('user.deleteAffiliate', $worker->id) }}" method="POST" class="inline-block delete-label-form" data-name="affiliate">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center p-4">Tidak ada data worker.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Konfirmasi HAPUS Label/Affiliate
    document.querySelectorAll('.delete-label-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const type = form.getAttribute('data-name');
            Swal.fire({
                title: `Yakin mau menghapus ${type}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Konfirmasi Tambah Label/Affiliate
    document.querySelectorAll('.confirm-label-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const message = form.getAttribute('data-message') || 'Yakin?';
            Swal.fire({
                title: message,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, setuju',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@include('General.footer')
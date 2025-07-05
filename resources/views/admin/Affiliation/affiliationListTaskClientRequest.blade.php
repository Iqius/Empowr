@include('General.header')

<div class="p-4 mt-14">
    <!-- TABEL STATIC BERISI PENGAJU, TAHAPAN, AKSI -->
    <div class="bg-white p-6 rounded-xl shadow-md border mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Tahapan</h2>
        <div class="overflow-x-auto rounded-lg border border-gray-200 mb-6">
            <table class="min-w-full w-full table-fixed divide-y divide-gray-200 text-sm">
                <thead class="bg-[#1F4482] text-white text-left">
                    <tr>
                        <th class="w-1/3 px-4 py-3 font-medium tracking-wider">Pengaju</th>
                        <th class="w-1/3 px-4 py-3 font-medium tracking-wider">Nama task</th>
                        <th class="w-1/3 px-4 py-3 font-medium tracking-wider">Aksi</th>
                    </tr>
                </thead>
                @foreach($task as $tasks)
                    <tbody class="bg-white divide-y divide-gray-100"> 
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-4 py-3 flex items-center gap-3">
                                <img src="{{ asset('storage/' . ($tasks->client->profile_image ?? 'default.png')) }}"
                                    class="w-10 h-10 rounded-full object-cover">
                                <span class="font-medium">{{ $tasks->client->nama_lengkap }}</span>
                            </td>
                            <td class="px-4 py-3">{{ $tasks->title }}</td>
                            <td class="px-4 py-3">
                                <div class="flex space-x-2">
                                    {{-- Form Detail Task --}}
                                    <form action="{{ route('jobs.manage', $tasks->id) }}" method="GET">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-full font-semibold transition">
                                            Detail Task
                                        </button>
                                    </form>

                                    {{-- Form Tolak --}}
                                    <form id="formTolak-{{ $tasks->id }}" action="{{ route('rejected.affiliate-task', $tasks->id) }}" method="POST">
                                        @csrf
                                        <button type="button"
                                            onclick="konfirmasiTolak({{ $tasks->id }})"
                                            class="px-4 py-1 bg-red-500 hover:bg-red-600 text-white text-xs rounded-full font-semibold transition">
                                            Tolak
                                        </button>
                                    </form>


                                    {{-- Form Terima --}}
                                    <button onclick="openModalTerima({{ $tasks->id }})" 
                                        class="px-4 py-1 bg-green-500 hover:bg-green-600 text-white text-xs rounded-full font-semibold transition">
                                        Terima
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <!-- Modal Terima affiliate-->
                    <div id="modalTerima-{{ $tasks->id }}" class="fixed inset-0 flex items-center justify-center opacity-0 pointer-events-none bg-black/30 backdrop-blur-sm transition-opacity duration-300 z-50">
                        <div class="bg-white p-6 rounded-lg w-full max-w-md mx-4 shadow-lg transform scale-95 opacity-0 transition duration-300 overflow-y-auto max-h-[80vh]">
                            <!-- Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-semibold">Terima Task Affiliate</h2>
                                <button onclick="closeModalTerima()" class="text-gray-500 hover:text-gray-800 text-xl font-bold">&times;</button>
                            </div>

                            <!-- Form -->
                            <form action="{{ route('approve.affiliate-task', $tasks->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="task_id" value="{{ $tasks->id }}">

                                <!-- Harga Pajak -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Harga Pajak</label>
                                    <input type="number" step="0.01" name="harga_pajak_affiliate" class="w-full border rounded px-3 py-2" required>
                                </div>

                                <!-- Harga Task -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Harga Task</label>
                                    <input type="number" step="0.01" name="harga_task_affiliate" class="w-full border rounded px-3 py-2" required>
                                </div>


                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Catatan</label>
                                    <input type="text" step="0.01" name="catatan" class="w-full border rounded px-3 py-2" value="Saya adalah worker affiliasi yang direkomendasikan oleh admin empowr" required>
                                </div>

                                <!-- Pilih Worker -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Pilih Worker Affiliate</label>
                                    <select name="worker_id" class="w-full border rounded px-3 py-2" required>
                                        <option value="">-- Pilih Worker --</option>
                                        @foreach($workerProfiles as $worker)
                                            <option value="{{ $worker->id }}">{{ $worker->user->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="flex justify-end space-x-2">
                                    <button type="button" onclick="closeModalTerima()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Simpan</button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                @endforeach
            </table>
        </div>
    </div>
</div>






<script>
    function openModalTerima(taskId) {
        const modal = document.getElementById(`modalTerima-${taskId}`);
        const content = modal.querySelector('.modal-content');

        modal.classList.remove('opacity-0', 'pointer-events-none');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModalTerima(taskId) {
        const modal = document.getElementById(`modalTerima-${taskId}`);
        const content = modal.querySelector('.modal-content');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('pointer-events-none');
        }, 300);
    }

    // SweetAlert jika session success ada
    @if(session('success'))
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false,
            confirmButtonColor: '#3085d6',
        });
    });
    @endif
       function konfirmasiTolak(taskId) {
        Swal.fire({
            title: 'Yakin ingin menolak task ini?',
            text: 'Tindakan ini tidak dapat dibatalkan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, tolak',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`formTolak-${taskId}`).submit();
            }
        });
    }
</script>

@include('General.footer')




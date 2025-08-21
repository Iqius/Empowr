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
                        <th class="w-1/3 px-4 py-3 font-medium tracking-wider">Tahapan</th>
                        <th class="w-1/3 px-4 py-3 font-medium tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($data as $item)
                    @php
                    $worker = $item->workerProfile;
                    $user = $worker->user;
                    $profileImage = $user->profile_image
                    ? asset('storage/' . $user->profile_image)
                    : asset('images/default-avatar.png');
                    @endphp
                    @if(($item->status != 'result' && strtolower(trim($item->status_decision)) != 'approve') || strtolower(trim($item->status_decision)) != 'rejected')
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-4 py-3 flex items-center gap-3">
                            <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default-avatar.png') }}"
                                class="w-10 h-10 rounded-full object-cover">
                            <span class="font-medium">{{ $user->nama_lengkap }}</span>
                        </td>
                        <td class="px-4 py-3">{{ $item->status }}</td>
                        <td class="px-4 py-3 space-x-2">
                            @if(strtolower(trim($item->status)) == 'pending')
                                <button type="button"
                                    class="open-modal-button inline-block px-4 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-full font-semibold transition"
                                    data-form-id="form-{{ $item->id }}">
                                    Ubah status menjadi under review
                                </button>
                                <form id="form-{{ $item->id }}"
                                    action="{{ route('List-pengajuan-worker-affiliate.pending-to-under-review', $item->id) }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <a href="{{ route('profile.worker.lamar', $worker->id) }}"
                                    class="inline-block px-4 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-full font-semibold transition">
                                    Lihat Worker
                                </a>
                                <a href="{{ route('progress-affiliate.view', ['id' => $worker->id]) }}"
                                    class="inline-block px-4 py-1 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs rounded-full font-semibold transition">
                                    Progress Tahapan
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="confirmation-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Konfirmasi Perubahan Status</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Apakah Anda yakin ingin mengubah status worker ini menjadi "under review"?</p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirm-button"
                    class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Ya, Yakin
                </button>
                <button id="cancel-button"
                    class="mt-3 px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('confirmation-modal');
        const confirmButton = document.getElementById('confirm-button');
        const cancelButton = document.getElementById('cancel-button');
        let currentForm = null;

        document.querySelectorAll('.open-modal-button').forEach(button => {
            button.addEventListener('click', function () {
                const formId = this.dataset.formId;
                currentForm = document.getElementById(formId);
                modal.classList.remove('hidden');
            });
        });

        confirmButton.addEventListener('click', function () {
            if (currentForm) {
                currentForm.submit();
            }
            modal.classList.add('hidden');
        });

        cancelButton.addEventListener('click', function () {
            modal.classList.add('hidden');
            currentForm = null;
        });

        // Close modal if clicked outside
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                currentForm = null;
            }
        });
    });
</script>
@include('General.footer')
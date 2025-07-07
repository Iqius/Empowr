@include('General.header')

<div class="p-4 mt-16 ">
    <div id="info" class="tab-content space-y-4 mt-4">
        <div class="bg-white p-6 rounded-xl shadow-sm border space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Lamaran Kamu</h2>
            <p class="text-gray-600">Harga Penawaran: <strong>Rp
                    {{ number_format($application->bidPrice) }}</strong>
                    <button class="ml-2 px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm"
                        onclick="openModal('editBidPriceModal_{{ $application->id }}')">Edit</button>
            </p>
            <p class="text-gray-600">Catatan: {{ $application->catatan }}</p>
            <p class="text-gray-600">Status Lamaran:
                <span class="px-2 py-1 rounded" @if($application->status === 'pending') bg-yellow-500
                @elseif($application->status === 'accepted') bg-green-500 @elseif($application->status === 'rejected') bg-red-500
                    @else bg-gray-500 @endif">
                {{ ucfirst($application->status) }}
                </span>
            </p>

        </div>
        {{-- REMOVE THIS BLOCK - THIS WAS THE OLD INLINE EDIT FIELD --}}
        {{-- <div id="bidPriceEdit_{{ $application->id }}" class="hidden">
            <form action="{{ route('applications.updateBidPrice', $application->id) }}" method="POST">
                @csrf
                @method('PUT')
                <label for="bidPrice_{{ $application->id }}" class="block text-gray-700 text-sm font-bold mb-2">
                    Edit Harga Penawaran:
                </label>
                <input type="number" id="bidPrice_{{ $application->id }}" name="bidPrice"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ $application->bidPrice }}" min="0" step="1">
                <div class="mt-2 space-x-2">
                    <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm">Save</button>
                    <button type="button" class="px-3 py-1 bg-gray-400 text-white rounded hover:bg-gray-500 text-sm"
                            onclick="hideEditField('{{ $application->id }}')">Cancel</button>
                </div>
            </form>
        </div> --}}
        {{-- END REMOVE BLOCK --}}

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border space-y-6">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-4">
                            <img src="{{ $task->user->profile_image ? asset('storage/' . $task->user->profile_image) : asset('assets/images/avatar.png') }}"
                                alt="User" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800">{{ $task->title ?? '[Judul belum diisi]' }}
                                </h1>
                                <p class="text-xs flex items-center gap-1">
                                    <i class="fa-solid fa-pen text-gray-500"></i>
                                    <span class="text-gray-500">Task diposting</span>
                                    <span class="text-gray-600 font-semibold">
                                        {{ \Carbon\Carbon::parse($task->created_at)->translatedFormat('d F Y') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-medium text-gray-500">Budget</p>
                            <p class="text-lg font-semibold text-gray-800">IDR
                                {{ number_format($task->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-6 flex-1">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">Tentang Task</h2>
                            <div class="job-description text-sm text-gray-800 leading-relaxed">
                                {!! $task->description !!}
                            </div>
                        </div>

                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">Kualifikasi</h2>
                            <div class="job-qualification text-sm text-gray-800 leading-relaxed">
                                {!! $task->qualification !!}
                            </div>
                        </div>

                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">Aturan Task</h2>
                            <div class="rules text-sm text-gray-800 leading-relaxed">
                                {!! $task->provisions !!}
                            </div>
                        </div>

                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">File Terkait</h2>
                            @if ($task->job_file)
                                <a href="{{ asset('storage/' . $task->job_file) }}" download
                                    class="inline-block mt-2 px-4 py-2 bg-[#1F4482] text-white text-sm rounded-md hover:bg-[#18346a]">
                                    Download File
                                </a>
                            @else
                                <p class="text-sm text-gray-500">No attachment available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white p-6 rounded-xl shadow-sm border space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800">Task Detail</h2>

                    <div>
                        <p class="text-gray-500">Masa Pengerjaan Task (Deadline)</p>
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($task->start_date)->translatedFormat('d F Y') }} -
                            {{ \Carbon\Carbon::parse($task->deadline)->translatedFormat('d F Y') }}
                        </p>
                        <p class="font-semibold">
                            ({{ \Carbon\Carbon::parse($task->start_date)->diffInDays($task->deadline) }} Hari)
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Penutupan Lamaran</p>
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($task->deadline_promotion)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Permintaan Jatah Revisi</p>
                        <p class="font-semibold capitalize">{{ $task->revisions }} kali revisi</p>
                    </div>

                    <div>
                        <p class="text-gray-500 mb-2">Kategori Task</p>
                        <div>
                            @php
                                $categories = json_decode($task->category, true) ?? [];
                            @endphp
                            @foreach($categories as $category)
                                <span
                                    class="inline-block bg-gradient-to-b from-[#1F4482] to-[#2A5DB2] text-white px-3 py-1 rounded-full text-sm mr-2 mb-2">
                                    {{ $category }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- The Modal Structure --}}
<div id="editBidPriceModal_{{ $application->id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Harga Penawaran</h3>
            <div class="mt-2 px-7 py-3">
                <form action="{{ route('applications.updateBidPrice', $application->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Use PUT method for updates --}}

                    <label for="bidPrice_{{ $application->id }}_modal" class="block text-left text-gray-700 text-sm font-bold mb-2">
                        Harga Penawaran Baru:
                    </label>
                    <input type="number" id="bidPrice_{{ $application->id }}_modal" name="bidPrice"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           value="{{ $application->bidPrice }}" min="0" step="1" required>

                    <div class="items-center px-4 py-3 mt-4">
                        <button type="submit"
                                class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                            Simpan Perubahan
                        </button>
                        <button type="button"
                                class="mt-3 px-4 py-2 bg-gray-400 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-300"
                                onclick="closeModal('editBidPriceModal_{{ $application->id }}')">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('General.footer')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatForm = document.getElementById('chat-form');
        if (chatForm) {
            chatForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const input = document.getElementById('chat-input');
                const msg = input.value.trim();
                if (msg && currentWorker) {
                    const timeNow = new Date().toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    chatData[currentWorker].push({
                        sender: 'client',
                        message: msg,
                        time: timeNow
                    });
                    input.value = '';
                    renderChat(currentWorker);
                    renderWorkerList();
                }
            });
        }

        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('text-blue-600', 'font-semibold'));
                button.classList.add('text-blue-600', 'font-semibold');
                document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
                document.getElementById(button.dataset.tab)?.classList.remove('hidden');
            });
        });

        // Ensure this renderWorkerList is only called if applicable to this page
        // renderWorkerList(); 

        document.querySelectorAll('.btn-worker-info').forEach(btn => {
            btn.addEventListener('click', () => {
                // Ensure workerData is defined in this context if used here
                // renderWorkerModal(workerData); 
                showWorkerTab('keahlianTab');
                document.getElementById('workerDetailModal').classList.remove('hidden');
            });
        });
    });

    // Inisialisasi awal (if `applicants` is defined globally or passed to the script)
    // renderApplicants(applicants); 
</script>
<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Optional: Close modal when clicking outside of it
    document.addEventListener('DOMContentLoaded', () => {
        const modals = document.querySelectorAll('[id^="editBidPriceModal_"]');
        modals.forEach(modal => {
            modal.addEventListener('click', function(event) {
                if (event.target === this) {
                    closeModal(this.id);
                }
            });
        });
    });

    // REMOVE THIS FUNCTION if not used elsewhere in this specific script block
    // function hideEditField(applicationId) {
    //     // This function is for the old inline edit, no longer needed with modal
    // }
</script>
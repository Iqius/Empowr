@include('client.header')

<section class="p-4 mt-16 ml-16">
 
    <!-- Tabs -->
    <div class="flex flex-wrap gap-4 border-b pb-2 text-sm sm:text-base overflow-x-auto">
        <button class="tab-button text-blue-600 font-semibold" data-tab="info">Informasi Lengkap</button>
        <button class="tab-button text-gray-600 hover:text-blue-600" data-tab="chat">Chat</button>
    </div>

    <!-- Tab 1: Informasi Lengkap -->
    <div id="info" class="tab-content space-y-4 mt-4">
        <h1 class="text-2xl font-bold text-blue-600">{{ $task->title ?? '[Judul belum diisi]' }}</h1>
        <p class="text-black font-bold text-xl">
            Rp {{ isset($task->price) ? number_format($task->price, 0, ',', '.') : '[Harga belum diisi]' }}
        </p>
        <p class="text-gray-500 text-sm">Dipost oleh: {{ $task->user->nama_lengkap ?? $task->user->name ?? 'Unknown' }}</p>
        <hr>

        @php
            $fields = [
                'Deskripsi' => $task->description ?? null,
                'Jumlah Revisi' => $task->revisions ?? null,
                'Tanggal Berakhir' => $task->deadline ?? null,
                'Tipe Pekerjaan' => $task->taskType ?? null,
                'Ketentuan' => $task->provisions ?? null,
            ];
        @endphp

        @foreach($fields as $label => $value)
            <div>
                <h2 class="text-lg font-semibold text-gray-700">{{ $label }}</h2>
                <p class="text-gray-600 mt-1">{{ $value ?: '[Belum ditentukan]' }}</p>
            </div>
        @endforeach

        <div>
            <h2 class="text-lg font-semibold text-gray-700">File Terkait</h2>
            @if(!empty($task->task_file))
                <a href="{{ asset('storage/' . $task->task_file) }}" class="text-blue-600 hover:underline" target="_blank">
                    Lihat file
                </a>
            @else
                <p class="text-gray-600 mt-1">Belum ada file yang diunggah coki</p>
            @endif
        </div>
@if($application)
    <hr class="my-4">
    <div class="mt-4 space-y-2">
        <h2 class="text-lg font-semibold text-gray-700">Lamaran Kamu</h2>
        <p class="text-gray-600">Harga Penawaran: <strong>Rp {{ number_format($application->bidPrice, 0, ',', '.') }}</strong></p>
        <p class="text-gray-600">Catatan: <strong>{{ $application->catatan }}</strong></p>
        <p class="text-gray-600">Status Lamaran: 
            <span class="px-2 py-1 rounded text-white
                @if($application->status === 'pending') bg-yellow-500
                @elseif($application->status === 'accepted') bg-green-500
                @elseif($application->status === 'rejected') bg-red-500
                @else bg-gray-500
                @endif">
                {{ ucfirst($application->status) }}
            </span>
        </p>
    </div>
@endif

    </div>

    <!-- Tab 3: Chat -->
    <div id="chat" class="tab-content hidden mt-4">
        <h2 class="text-xl font-bold mb-4">Chat</h2>
        <iframe src="{{ route('chat') }}" class="w-full h-[500px] border rounded shadow"></iframe>
    </div>

    <!-- Actions -->
    <div class="flex justify-end gap-2 mt-6">
        <a href="{{ route('myjob.worker') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Back
        </a>
    </div>
</section>



@include('client.footer')

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const chatForm = document.getElementById('chat-form');
    if (chatForm) {
        chatForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const input = document.getElementById('chat-input');
            const msg = input.value.trim();
            if (msg && currentWorker) {
                const timeNow = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                chatData[currentWorker].push({ sender: 'client', message: msg, time: timeNow });
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

    renderWorkerList();

    document.querySelectorAll('.btn-worker-info').forEach(btn => {
        btn.addEventListener('click', () => {
            renderWorkerModal(workerData);
            showWorkerTab('keahlianTab');
            document.getElementById('workerDetailModal').classList.remove('hidden');
        });
    });
  });
  
// Inisialisasi awal
renderApplicants(applicants);
</script>


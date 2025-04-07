@include('client.header')

<section class="p-4 mt-16 lg:ml-64">
    <!-- Tabs -->
    <div class="flex flex-wrap gap-4 border-b pb-2 text-sm sm:text-base overflow-x-auto">
        <button class="tab-button text-blue-600 font-semibold" data-tab="info">Informasi Lengkap</button>
        <button class="tab-button text-gray-600 hover:text-blue-600" data-tab="chat">Chat</button>
    </div>

    <!-- Tab 1: Informasi Lengkap -->
    <div id="info" class="tab-content space-y-4 mt-4">
        <h1 class="text-2xl font-bold text-blue-600">{{ $job->title ?? '[Judul belum diisi]' }}</h1>
        <p class="text-black font-bold text-xl">
            Rp {{ isset($job->price) ? number_format($job->price, 0, ',', '.') : '[Harga belum diisi]' }}
        </p>
        <p class="text-gray-500 text-sm">By {{ $job->user->name ?? 'Unknown' }}</p>
        <hr>

        @foreach([
            'Deskripsi' => 'description',
            'Jumlah Revisi' => 'revisions',
            'Tanggal Berakhir' => 'end_date',
            'Tipe Pekerjaan' => 'type',
            'Ketentuan' => 'provisions'
        ] as $label => $field)
            <div>
                <h2 class="text-lg font-semibold text-gray-700">{{ $label }}</h2>
                <p class="text-gray-600 mt-1">{{ $job->$field ?? '[Belum ditentukan]' }}</p>
            </div>
        @endforeach

        <div>
            <h2 class="text-lg font-semibold text-gray-700">File Terkait</h2>
            <p class="text-gray-600 mt-1">[Belum ada file yang diunggah]</p>
        </div>
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


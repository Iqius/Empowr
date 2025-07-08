@include('General.header')

@if(auth()->user()->role === 'worker' || auth()->user()->role === 'client')
  <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow-md mt-20">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-semibold">Daftar Arbitrase</h1>
      <!-- <button onclick="document.getElementById('modal').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Tambah Arbitrase
      </button> -->
    </div>
    <!-- Tabel -->
    <div class="overflow-x-auto">
      <table class="min-w-full table-auto border border-gray-300">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 border">ID</th>
            <th class="px-4 py-2 border">Task ID</th>
            <th class="px-4 py-2 border">Pelapor</th>
            <th class="px-4 py-2 border">Reason</th>
            <th class="px-4 py-2 border">Status</th>
            <th class="px-4 py-2 border">Created At</th>
          </tr>
        </thead>
        <tbody>
          @forelse($arbitrases as $item)
          <tr>
            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
            <td class="px-4 py-2 border">{{ $item->task_id }}</td>
            <td class="px-4 py-2 border">{{ $item->pelapor }}</td>
            <td class="px-4 py-2 border">{{ $item->reason }}</td>
            <td class="px-4 py-2 border">{{ ($item->status) }}</td>
            <td class="px-4 py-2 border">{{ $item->created_at }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center py-4">Tidak ada data arbitrase.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@elseif (auth()->check() && auth()->user()->role === 'admin') <!-- UNTUK ADMIN -->
  <!-- Tabel -->
  <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow-md mt-20">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-semibold">Daftar Arbitrase</h1>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full table-auto border border-gray-300">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 border">ID</th>
            <th class="px-4 py-2 border">Task ID</th>
            <th class="px-4 py-2 border">Pelapor</th>
            <th class="px-4 py-2 border">Reason</th>
            <th class="px-4 py-2 border">Status</th>
            <th class="px-4 py-2 border">Created At</th>
            <th class="px-4 py-2 border">Action</th>
          </tr>
        </thead>
        <tbody>

          @forelse($arbitrases as $item)
          <tr>
            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
            <td class="px-4 py-2 border">{{ $item->task_id }}</td>
            <td class="px-4 py-2 border">{{ $item->pelapor}}</td>
            <td class="px-4 py-2 border">{{ $item->reason }}</td>
            <td class="px-4 py-2 border">{{ ($item->status) }}</td>
            <td class="px-4 py-2 border">{{ $item->created_at }}</td>
            <td class="px-4 py-2 border text-center">
              <!-- Detail Button -->
              <a href="{{ route('inProgress.jobs', $item->task_id) }}">
                <button
                  class="px-4 py-2 bg-blue-500 text-white rounded">
                  Detail
                </button>
              </a>
              @if ($item->status !== 'resolved' && $item->status != 'cancelled')
              <!-- Tolak Button -->
              <form action="{{ route('arbitrase.reject', $item->id) }}" method="POST" class="inline-block ml-2">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Tolak</button>
              </form>
              <!-- Tindak Lanjut Button -->
              <button type="button" 
                      class="px-4 py-2 bg-green-500 text-white rounded open-modal" 
                      data-id="{{ $item->id }}">
                Tindak Lanjut
              </button>
            </td>
            @endif
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center p-4">Tidak ada data arbitrase.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  </div>
@endif

<!-- Modal Tindak Lanjut Arbitrase -->
<div id="modal-tindak-lanjut" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
  <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
    <button onclick="closeModal()" class="absolute top-2 right-4 text-2xl text-gray-500 hover:text-red-600">&times;</button>
    <h2 class="text-xl font-bold mb-4">Pilih Persentase Pengembalian</h2>
    
    <form method="POST" action="" id="tindakLanjutForm">
      @csrf
      <input type="hidden" name="arbitrase_id" id="arbitrase_id">
      <label class="block mb-2 text-gray-700">Persentase</label>
      <select name="persentase" class="w-full border px-3 py-2 rounded mb-4" required>
          <option value="">-- Pilih Opsi Pembagian --</option>
          <option value="0">Pelapor 0% / Terlapor 100%</option>
          <option value="5">Pelapor 5% / Terlapor 95%</option>
          <option value="10">Pelapor 10% / Terlapor 90%</option>
          <option value="15">Pelapor 15% / Terlapor 85%</option>
          <option value="20">Pelapor 20% / Terlapor 80%</option>
          <option value="25">Pelapor 25% / Terlapor 75%</option>
          <option value="30">Pelapor 30% / Terlapor 70%</option>
          <option value="35">Pelapor 35% / Terlapor 65%</option>
          <option value="40">Pelapor 40% / Terlapor 60%</option>
          <option value="45">Pelapor 45% / Terlapor 55%</option>
          <option value="50">Pelapor 50% / Terlapor 50%</option>
          <option value="55">Pelapor 55% / Terlapor 45%</option>
          <option value="60">Pelapor 60% / Terlapor 40%</option>
          <option value="65">Pelapor 65% / Terlapor 35%</option>
          <option value="70">Pelapor 70% / Terlapor 30%</option>
          <option value="75">Pelapor 75% / Terlapor 25%</option>
          <option value="80">Pelapor 80% / Terlapor 20%</option>
          <option value="85">Pelapor 85% / Terlapor 15%</option>
          <option value="90">Pelapor 90% / Terlapor 10%</option>
          <option value="95">Pelapor 95% / Terlapor 5%</option>
          <option value="100">Pelapor 100% / Terlapor 0%</option>
      </select>
      <div class="flex justify-end">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
      </div>
    </form>
  </div>
</div>
@if(session('success'))
  <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
    {{ session('success') }}
  </div>
@endif

@if($errors->any())
  <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
    @foreach($errors->all() as $error)
      <p>{{ $error }}</p>
    @endforeach
  </div>
@endif





<script>
  const modal = document.getElementById('modal-tindak-lanjut');
  const form = document.getElementById('tindakLanjutForm');

  // Generate template URL dari Blade
  const routeTemplate = @json(route('arbitrase.accept', ['id' => ':id']));

  document.querySelectorAll('.open-modal').forEach(button => {
    button.addEventListener('click', () => {
      const id = button.getAttribute('data-id');

      // Ganti :id dengan id yang sebenarnya
      const actionUrl = routeTemplate.replace(':id', id);
      form.setAttribute('action', actionUrl);

      modal.classList.remove('hidden');
      modal.classList.add('flex');
    });
  });

  function closeModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
</script>


@include('General.footer')
@include('General.header')

@if(auth()->check() && (auth()->user()->role === 'worker' || auth()->user()->role === 'client'))
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
          <th class="px-4 py-2 border">Client ID</th>
          <th class="px-4 py-2 border">Worker ID</th>
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
          <td class="px-4 py-2 border">{{ $item->client_id }}</td>
          <td class="px-4 py-2 border">{{ $item->worker_id }}</td>
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

<!-- Modal Form -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-lg shadow-xl w-full max-w-lg">
    <div class="flex justify-between items-center p-4 border-b">
      <h2 class="text-xl font-bold">Form Tambah Arbitrase</h2>
      <button onclick="document.getElementById('modal').classList.add('hidden')" class="text-gray-500 hover:text-red-500 text-2xl">&times;</button>
    </div>

    <form class="p-4 space-y-4">
      <div>
        <label class="block text-gray-700 mb-1">User ID</label>
        <input type="text" name="user_id" value="USR123" readonly class="w-full border rounded-md px-3 py-2 bg-gray-100">
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Pilih Task</label>
        <select name="task_id" class="w-full border rounded-md px-3 py-2">
          <option value="">-- Pilih Task --</option>
          <option value="TSK001">Desain Logo</option>
          <option value="TSK002">Edit Video</option>
          <option value="TSK003">Penulisan Artikel</option>
        </select>
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Alasan Arbitrase</label>
        <textarea name="reason" rows="3" class="w-full border rounded-md px-3 py-2" placeholder="Jelaskan alasan..."></textarea>
      </div>

      <div>
        <label class="block text-gray-700 mb-1">Upload Bukti</label>
        <input type="file" name="bukti" class="w-full">
      </div>

      <div class="flex justify-end space-x-2 pt-2">
        <button type="button" onclick="document.getElementById('modal').classList.add('hidden')" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md">Batal</button>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Simpan</button>
      </div>
    </form>
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
          <th class="px-4 py-2 border">Client ID</th>
          <th class="px-4 py-2 border">Worker ID</th>
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
          <td class="px-4 py-2 border">{{ $item->client_id }}</td>
          <td class="px-4 py-2 border">{{ $item->worker_id }}</td>
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
            @if ($item->status !== 'resolved')
            <!-- Terima Button -->
            <form action="{{ route('arbitrase.accept', $item->id) }}" method="POST" class="inline-block ml-2">
              @csrf
              <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Terima</button>
            </form>
            <!-- Tolak Button -->
            <form action="{{ route('arbitrase.reject', $item->id) }}" method="POST" class="inline-block ml-2">
              @csrf
              <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Tolak</button>
            </form>
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

@include('General.footer')
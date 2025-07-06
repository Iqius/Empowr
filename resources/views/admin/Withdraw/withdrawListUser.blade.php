@include('General.header')

<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Daftar Pengajuan Withdraw</h1>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Order ID</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">User</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Metode</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($withdrawals as $withdraw)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $withdraw->order_id }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">
                            @if($withdraw->worker)
                                {{ $withdraw->worker->user->nama_lengkap }}
                            @elseif($withdraw->client)
                                {{ $withdraw->client->nama_lengkap }}
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-800">Rp {{ number_format($withdraw->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800 capitalize">{{ $withdraw->withdraw_method }}</td>
                        <td class="px-4 py-2 text-sm">
                            @if($withdraw->status == 'pending')
                                <span class="text-yellow-500 font-semibold">Menunggu</span>
                            @elseif($withdraw->status == 'success')
                                <span class="text-green-600 font-semibold">Disetujui</span>
                            @elseif($withdraw->status == 'reject')
                                <span class="text-red-600 font-semibold">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $withdraw->created_at->format('d-m-Y H:i') }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">
                            @if($withdraw->status == 'pending')
                                <!-- Tombol Modal Info Rekening -->
                                <button onclick="document.getElementById('modalRekening{{ $withdraw->id }}').classList.remove('hidden')" 
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 mb-1">
                                    Info Rekening
                                </button>

                                <!-- Tombol Modal Setujui -->
                                <button onclick="document.getElementById('modalApprove{{ $withdraw->id }}').classList.remove('hidden')" 
                                        class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 mb-1">
                                    Setujui
                                </button>

                                <!-- Tombol Tolak -->
                                <form action="{{ route('withdraw.reject', $withdraw->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Tolak</button>
                                </form>

                                <!-- Modal Info Rekening -->
                                <div id="modalRekening{{ $withdraw->id }}" 
                                    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
                                    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
                                        <button onclick="document.getElementById('modalRekening{{ $withdraw->id }}').classList.add('hidden')" 
                                                class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl font-bold">
                                            ×
                                        </button>
                                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Informasi Rekening</h3>
                                        <p class="mb-2"><strong>Metode:</strong> {{ ucfirst($withdraw->withdraw_method) }}</p>
                                        @php
                                            $paymentAccount = $withdraw->worker->user->paymentAccount ?? $withdraw->client->paymentAccount;
                                        @endphp
                                        @if($withdraw->withdraw_method === 'bank')
                                            <p class="mb-1"><strong>No. Rekening:</strong> {{ $paymentAccount->account_number ?? '-' }}</p>
                                            <p><strong>Atas Nama:</strong> {{ $paymentAccount->bank_account_name ?? '-' }}</p>
                                        @else
                                            <p class="mb-1"><strong>No. Wallet:</strong> {{ $paymentAccount->wallet_number ?? '-' }}</p>
                                            <p><strong>Atas Nama:</strong> {{ $paymentAccount->ewallet_account_name ?? '-' }}</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Modal Setujui dengan Upload -->
                                <div id="modalApprove{{ $withdraw->id }}" 
                                    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
                                    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
                                        <button onclick="document.getElementById('modalApprove{{ $withdraw->id }}').classList.add('hidden')" 
                                                class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl font-bold">
                                            ×
                                        </button>
                                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Upload Bukti Transfer</h3>
                                    <form action="{{ route('withdraw.approve', $withdraw->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <label class="block mb-2 text-sm font-medium text-gray-700">Upload Gambar:</label>
                                            <input type="file" name="bukti_transfer" accept="image/*" 
                                                class="w-full border border-gray-300 rounded p-2 mb-4" required>

                                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                                Kirim
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-4 text-center text-gray-500">Tidak ada pengajuan withdraw.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>




<script>
    document.querySelectorAll('[data-toggle="modal"]').forEach(button => {
        button.addEventListener('click', () => {
            const target = button.getAttribute('data-target');
            document.querySelector(target).classList.remove('hidden');
        });
    });
</script>



@include('General.footer')
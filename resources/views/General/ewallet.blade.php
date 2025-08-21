@include('General.header')

<div class="p-4 mt-16">
    <div class="container mx-auto max-w-5xl">
        <!-- Top Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-stretch">
            <!-- Total Balance Card -->
            <div class="bg-white rounded-lg p-5 shadow-sm">
                <h2 class="text-2xl font-bold mb-1">IDR</h2>
                <p class="text-sm text-gray-500 mb-1">Total Saldo</p>
                <div class="flex justify-between items-center">
                    @if ($ewallet)
                        <p class="text-2xl font-bold">{{ number_format($ewallet->balance, 0, ',', '.') }}</p>
                    @else
                        <p class="text-xl font-bold">Saldo belum tersedia.</p>
                    @endif
                    <div class="flex flex-col space-y-2">
                    <button class="bg-blue-600 text-white px-4 py-1 rounded-full text-sm" onclick="openWithdrawModal()">Tarik Saldo</button>
                    <button class="bg-blue-600 text-white px-4 py-1 rounded-full text-sm" onclick="openTopupModal()">Tambah Saldo</button>
                    </div>
                </div>  
            </div>

            <!-- Bank -->
            <div class="bg-white rounded-lg p-5 shadow-sm flex items-center space-x-4">
                <img src="{{ asset('assets/images/bca.jpg') }}" alt="bca Logo" class="w-10 h-10 object-contain">
                <div>
                    <p class="font-semibold">{{ $paymentAccounts->bank_name ?? 'Tidak ada' }}</p>
                    <p class="text-sm text-gray-600">{{ $paymentAccounts->bank_account_name ?? 'Tidak ada' }}</p>
                    <p class="text-sm">Number: {{ $paymentAccounts->account_number ?? 'Tidak ada' }}</p>
                </div>
            </div>

            <!-- Dana -->
            <div class="bg-white rounded-lg p-5 shadow-sm flex items-center space-x-4">
                <img src="{{ asset('assets/images/dana.jpeg') }}" alt="Dana Logo" class="w-10 h-10 object-contain">
                <div>
                    <p class="font-semibold">{{ $paymentAccounts->ewallet_provider ?? 'Tidak ada' }}</p>
                    <p class="text-sm text-gray-600">{{ $paymentAccounts->ewallet_account_name ?? 'Tidak ada' }}</p>
                    <p class="text-sm">Number: {{ $paymentAccounts->wallet_number ?? 'Tidak ada' }}</p>
                </div>
            </div>
        </div>
        <!-- History Section -->
        <div class="w-full bg-white rounded-lg p-4 shadow-sm mt-6">
        <h2 class="text-2xl font-bold mb-4">History</h2>
        @php
            $user = Auth::user();
        @endphp
        @forelse ($transactions as $transaction)
            <div class="bg-gray-100 rounded-lg p-4 flex items-start mb-4">
                <div class="mr-4">
                    {{-- Icon bisa beda berdasarkan tipe --}}
                    @if($transaction->type === 'payout')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a4 4 0 00-8 0v2M5 13h14l-1 9H6l-1-9z" />
                        </svg>  
                    @elseif($transaction->type === 'payment')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    @elseif($transaction->type === 'topup')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    @else
                        {{-- Icon default --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    @endif
                </div>
                <div>
                    {{-- Judul transaksi berdasarkan type --}}
                    <p class="font-medium">
                        @if($transaction->type === 'payout')
                            Tarik saldo
                        @elseif($transaction->type === 'payment')
                            Pembayaran: {{ $transaction->task->title ?? 'Task tidak ditemukan' }}
                        @elseif($transaction->type === 'topup')
                            Top Up
                        @elseif($transaction->type === 'refund')
                            Refund
                        @else
                            Transaksi
                        @endif
                    </p>

                    {{-- Info tambahan jika payment --}}
                    @if($transaction->type === 'payment')
                        <p class="text-sm text-gray-600">
                            Metode pembayaran: 
                            @if($transaction->payment_method === 'direct')
                                Pembayaran secara langsung
                            @elseif($transaction->payment_method === 'ewallet')
                                Pembayaran menggunakan e-wallet
                            @else
                                {{ ucfirst($transaction->payment_method) }}
                            @endif
                        </p>
                    @endif

                    {{-- Jumlah dan tanggal --}}
                    <p class="text-sm text-gray-500 mt-1">
                        {{ date('d M Y H:i', strtotime($transaction->created_at)) }} — 
                        Rp {{ number_format($transaction->amount, 0, ',', '.') }} - Status {{ $transaction->status ?? 'Error hubungi admin' }}
                    </p>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada riwayat transaksi.</p>
        @endforelse
        </div>
    </div>
</div>





@php
    $user = Auth::user();
@endphp
<!-- Modal Top Up -->
<div id="topupModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300 opacity-0" onclick="handleOutsideClick(event)">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm transform transition-transform duration-300 scale-90" id="topupContent" onclick="event.stopPropagation()">
        <h2 class="text-xl font-bold mb-4">Tambah Saldo</h2>
        <form action="{{ route('client.bayar') }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="topup">
            @if ($user->role === 'client')
                <input type="hidden" name="client_id" value="{{ $user->id }}">
            @elseif ($user->role === 'worker')
                <input type="hidden" name="worker_id" value="{{ $user->workerProfile->id }}">
            @endif
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium">Jumlah tambah saldo</label>
                <input type="number" name="amount" id="amount" min="1000" required class="w-full border rounded px-3 py-2 mt-1" placeholder="Masukkan nominal">
            </div>
            <div class="mb-4">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
                Lanjutkan Pembayaran
            </button>
            <button type="button" onclick="closeTopupModal()" class="mt-2 w-full py-2 rounded bg-red-500 text-white hover:bg-red-600">
                Batal
            </button>
        </form>
    </div>
</div>

<!-- Modal withdraw -->
<div id="withdrawModal" class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 hidden justify-center items-center transition-opacity duration-300">
    <div id="withdrawModalContent"
        class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md scale-95 opacity-0 transform transition-all duration-300 ease-out"
    >
        <h2 class="text-xl font-semibold mb-4 text-center">Ajukan Tarik saldo</h2>

        <form id="withdrawForm" action="{{ route('withdraw.pengajuan') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="amount" class="block text-gray-700 font-medium mb-1">Jumlah Penarikan</label>
                <input type="number" name="amount" id="amount" min="10000"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div class="mb-4">
                <label for="withdraw_method" class="block text-gray-700 font-medium mb-1">Metode Pembayaran</label>
                {{-- Tambahkan 'required' di sini --}}
                <select id="withdraw_method" name="withdraw_method" onchange="togglePaymentFields()"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    @if($paymentAccounts && $paymentAccounts->bank_name !== 'Tidak ada')
                        <option value="bank">Bank ({{ $paymentAccounts->bank_name }})</option>
                    @endif
                    @if($paymentAccounts && $paymentAccounts->ewallet_provider !== 'Tidak ada')
                        <option value="ewallet">E-Wallet ({{ $paymentAccounts->ewallet_provider }})</option>
                    @endif
                </select>

                <div id="bankFields" style="display:none;" class="mt-2 text-sm text-gray-600 p-3 bg-gray-50 rounded-md">
                    <p><strong>No. Rekening:</strong> {{ $paymentAccounts->account_number ?? '-' }}</p>
                    <p><strong>Atas Nama:</strong> {{ $paymentAccounts->bank_account_name ?? '-' }}</p>
                </div>

                <div id="ewalletFields" style="display:none;" class="mt-2 text-sm text-gray-600 p-3 bg-gray-50 rounded-md">
                    <p><strong>No. Wallet:</strong> {{ $paymentAccounts->wallet_number ?? '-' }}</p>
                    <p><strong>Atas Nama:</strong> {{ $paymentAccounts->ewallet_account_name ?? '-' }}</p>
                </div>
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" onclick="closeWithdrawModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Ajukan
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('show_unrated_modal') && session('unrated_tasks'))
    <div id="unratedModal"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white w-full max-w-lg p-6 rounded-xl shadow-xl">
            <h2 class="text-xl font-bold mb-4">Tugas yang Belum Diberi Rating</h2>
            <p class="mb-3 text-sm text-gray-700">
                Anda harus memberikan rating terlebih dahulu sebelum mencairkan dana. Berikut daftar tugasnya:
            </p>
            <ul class="list-disc pl-5 space-y-2 text-gray-800 max-h-[250px] overflow-y-auto">
                @foreach(session('unrated_tasks') as $task)
                    <li>
                        <strong>{{ $task->title ?? 'Tanpa Judul' }}</strong>
                        <a href="{{ route('inProgress.jobs', $task->id) }}" class="text-blue-600 hover:underline">Lihat Detail</a>
                    </li>
                @endforeach
            </ul>
            <div class="mt-6 text-right">
                <button onclick="window.location.reload()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Tutup
                </button>
            </div>
        </div>
    </div>
@endif

<!-- untuk modal topup -->
<script>
    function openTopupModal() {
        const modal = document.getElementById('topupModal');
        const content = document.getElementById('topupContent');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-90');
            content.classList.add('scale-100');
        }, 10);
    }

    function closeTopupModal() {
        const modal = document.getElementById('topupModal');
        const content = document.getElementById('topupContent');

        modal.classList.remove('opacity-100');
        content.classList.remove('scale-100');
        content.classList.add('scale-90');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    function handleOutsideClick(event) {
        const content = document.getElementById('topupContent');
        if (!content.contains(event.target)) {
            closeTopupModal();
        }
    }
</script>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    snap.pay('{{ session('snap_token') }}', {
        onSuccess: function (result) {
            Swal.fire({
                icon: 'success',
                title: 'Pembayaran Berhasil!',
                text: 'Terima kasih, pembayaran Anda telah berhasil.',
                confirmButtonText: 'Lanjut',
            }).then(() => {
                window.location.href = '/ewallet/' + result.user_id;
            });
        },
        onPending: function (result) {
            Swal.fire({
                icon: 'info',
                title: 'Pembayaran Tertunda',
                text: 'Pembayaran Anda masih tertunda, silakan selesaikan prosesnya.',
                confirmButtonText: 'OK',
            }).then(() => {
                window.location.reload();
            });
        },
        onError: function (result) {
            Swal.fire({
                icon: 'error',
                title: 'Pembayaran Gagal',
                text: 'Terjadi kesalahan dalam proses pembayaran. Silakan coba lagi.',
                confirmButtonText: 'OK',
            }).then(() => {
                window.location.reload();
            });
        },
        onClose: function () {
            Swal.fire({
                icon: 'warning',
                title: 'Popup Ditutup',
                text: 'Anda menutup popup tanpa menyelesaikan pembayaran.',
                confirmButtonText: 'OK'
            });
        }
    });
</script>


<!-- JS untuk modal withdraw -->
<script>
    // Fungsi untuk membuka dan menutup modal withdraw
    function openWithdrawModal() {
        const modal = document.getElementById('withdrawModal');
        const content = document.getElementById('withdrawModalContent');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 50); // kecil delay agar animasi smooth

        // Panggil togglePaymentFields() saat modal dibuka
        // Ini memastikan tampilan bank/ewallet sesuai pilihan saat ini
        togglePaymentFields();
    }

    function closeWithdrawModal() {
        const modal = document.getElementById('withdrawModal');
        const content = document.getElementById('withdrawModalContent');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300); // sesuai durasi animasi
    }

    // Fungsi untuk menampilkan/menyembunyikan field bank/ewallet
    function togglePaymentFields() {
        const method = document.getElementById('withdraw_method').value;
        document.getElementById('bankFields').style.display = method === 'bank' ? 'block' : 'none';
        document.getElementById('ewalletFields').style.display = method === 'ewallet' ? 'block' : 'none';
    }

    // Validasi saat form withdraw disubmit
    document.addEventListener('DOMContentLoaded', function() {
        const withdrawForm = document.getElementById('withdrawForm');
        if (withdrawForm) {
            withdrawForm.addEventListener('submit', function(event) {
                const withdrawMethod = document.getElementById('withdraw_method');

                // Jika nilai dropdown masih kosong ("-- Pilih Metode Pembayaran --")
                if (withdrawMethod.value === "") {
                    // Mencegah pengiriman formulir
                    event.preventDefault();

                    // Tampilkan alert
                    Swal.fire({
                        icon: 'warning',
                        title: 'Metode Pembayaran Belum Dipilih',
                        text: 'Mohon pilih metode pembayaran bank atau e-wallet terlebih dahulu.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6',
                    }).then(() => {
                        // Fokuskan kembali ke dropdown
                        withdrawMethod.focus();
                    });
                }
            });
        }
    });

    // Initial call to hide fields if no method is pre-selected on page load
    document.addEventListener('DOMContentLoaded', togglePaymentFields);
</script>


<!-- Js untuk pilih metode withdraw -->
 <script>
    function togglePaymentFields() {
        const method = document.getElementById('withdraw_method').value;
        document.getElementById('bankFields').style.display = method === 'bank' ? 'block' : 'none';
        document.getElementById('ewalletFields').style.display = method === 'ewallet' ? 'block' : 'none';
    }
</script>



<script>
  document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        confirmButtonColor: '#3085d6',
      });
    @endif

    @if(session('error'))
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '{{ session('error') }}',
        confirmButtonColor: '#d33',
      });
    @endif
  });
</script>

@include('General.footer')
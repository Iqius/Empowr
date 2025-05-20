@include('General.header')


@include('General.header')

<div class="p-4 mt-16">
    <div class="container mx-auto max-w-5xl">
        <!-- Top Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <!-- Total Balance Card -->
        <div class="bg-white rounded-lg p-5 shadow-sm">
            <h2 class="text-2xl font-bold mb-1">IDR</h2>
            <p class="text-sm text-gray-500 mb-1">Total Balance</p>
            <div class="flex justify-between items-center">
                @if ($ewallet)
                    <p class="text-2xl font-bold">{{ number_format($ewallet->balance, 0, ',', '.') }}</p>
                @else
                    <p class="text-xl font-bold">Saldo belum tersedia.</p>
                @endif
                <div class="flex flex-col space-y-2">
                <button class="bg-blue-600 text-white px-4 py-1 rounded-full text-sm" onclick="openTopupModal()">Withdraw</button>
                <button class="bg-blue-600 text-white px-4 py-1 rounded-full text-sm" onclick="openTopupModal()">Top Up</button>
                </div>
            </div>  
        </div>

        <!-- Total Found Card -->
        <div class="bg-white rounded-lg p-5 shadow-sm">
            <div class="flex justify-between items-center mb-1">
                <h2 class="text-2xl font-bold">IDR</h2>
                <div class="relative">
                    <button id="totalFoundDropdown" class="bg-gray-200 rounded-full px-2 py-1 text-xs flex items-center hover:bg-gray-300">
                        <span id="totalFoundPeriod">Monthly</span> 
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="totalFoundOptions" class="hidden absolute right-0 mt-1 bg-white rounded-md shadow-lg z-10 w-24 py-1">
                        <a href="#" class="block px-4 py-1 text-xs hover:bg-gray-100" onclick="changePeriod('totalFoundPeriod', 'Monthly'); return false;">Monthly</a>
                        <a href="#" class="block px-4 py-1 text-xs hover:bg-gray-100" onclick="changePeriod('totalFoundPeriod', 'Yearly'); return false;">Yearly</a>
                    </div>
                </div>
            </div>
            <p class="text-sm text-gray-500 mb-1">Total Found</p>
            <p class="text-xl font-bold">Rp 1.500.000</p>
        </div>

        <!-- Graph Card -->
        <div class="bg-white rounded-lg p-5 shadow-sm">
            <div class="flex justify-between items-center mb-1">
                <h2 class="text-2xl font-bold">Graph</h2>
                <div class="relative">
                    <select id="monthSelector" class="text-xs bg-gray-100 border-none rounded px-2 py-1" onchange="updateGraphByMonth()">
                        <option value="0">Januari</option>
                        <option value="1">Februari</option>
                        <option value="2">Maret</option>
                        <option value="3">April</option>
                        <option value="4">Mei</option>
                        <option value="5">Juni</option>
                        <option value="6">Juli</option>
                        <option value="7">Agustus</option>
                        <option value="8">September</option>
                        <option value="9">Oktober</option>
                        <option value="10">November</option>
                        <option value="11">Desember</option>
                    </select>
                </div>
            </div>
            <div class="h-16 mt-2">
                <canvas id="incomeChart" width="100%" height="100%"></canvas>
            </div>
        </div>
    </div>

    <!-- Bank Account Details -->
    <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200">
        <div class="flex items-center justify-between space-x-4">
            <!-- Logo dan Nama -->
            <div class="flex items-center space-x-2 w-1/4">
                <img src="{{ asset('assets/images/bca.jpg') }}" alt="bca Logo" class="w-[40px] h-[40px] object-contain">
                <span class="font-semibold">{{ $paymentAccounts->bank_name ?? 'Tidak ada'}}</span>
            </div>

            <!-- Account (tengah) -->
            <div class="text-center w-1/2">
                <span class="font-medium">{{ $paymentAccounts->bank_account_name ?? 'Tidak ada'}}</span>
            </div>

            <!-- Number (kanan) -->
            <div class="text-right w-1/4">
                <span class="font-medium">Number: {{ $paymentAccounts->account_number ?? 'Tidak ada'}}</span>
            </div>
        </div>
    </div>

    <!-- Dana Account Details -->
    <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200 mt-4">
        <div class="flex items-center justify-between space-x-4">
            <!-- Logo dan Nama -->
            <div class="flex items-center space-x-2 w-1/4">
                <img src="{{ asset('assets/images/dana.jpeg') }}" alt="Dana Logo" class="w-[40px] h-[40px] object-contain">
                <span class="font-semibold">{{ $paymentAccounts->ewallet_provider ?? 'Tidak ada'}}</span>
            </div>

            <!-- Account (tengah) -->
            <div class="text-center w-1/2">
                <span class="font-medium">{{ $paymentAccounts->ewallet_account_name ?? 'Tidak ada'}}</span>
            </div>

            <!-- Number (kanan) -->
            <div class="text-right w-1/4">
                <span class="font-medium">Number: {{ $paymentAccounts->wallet_number ?? 'Tidak ada'}}</span>
            </div>
        </div>
    </div>

    <!-- History Section -->
    <div class="bg-white rounded-lg p-4 shadow-sm mt-6">
    <h2 class="text-2xl font-bold mb-4">History</h2>

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
                        Withdraw
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





@php
    $user = Auth::user();
@endphp
<!-- Modal Top Up -->
<div id="topupModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300 opacity-0" onclick="handleOutsideClick(event)">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm transform transition-transform duration-300 scale-90" id="topupContent" onclick="event.stopPropagation()">
        <h2 class="text-xl font-bold mb-4">Top Up Saldo</h2>
        <form action="{{ route('client.bayar') }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="topup">
            @if ($user->role === 'client')
                <input type="hidden" name="client_id" value="{{ $user->id }}">
            @elseif ($user->role === 'worker')
                <input type="hidden" name="worker_id" value="{{ $user->workerProfile->id }}">
            @endif
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium">Jumlah Top Up</label>
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

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="YOUR_CLIENT_KEY"></script>

<script>
    snap.pay('{{ session('snap_token') }}', {
    onSuccess: function (result) {
        alert('Pembayaran berhasil!');
        window.location.href = '/ewallet/' + result.user_id;;
    },
    onPending: function (result) {
        alert('Pembayaran tertunda, silakan selesaikan pembayaran Anda');
        window.location.reload();
    },
    onError: function (result) {
        alert('Pembayaran gagal, silakan coba lagi');
        window.location.reload();
    },
    onClose: function () {
        alert('Anda menutup popup tanpa menyelesaikan pembayaran');
    }
});

</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Data pendapatan bulanan (dalam ribu rupiah)
      const monthlyData = {
        0: [50, 65, 80, 75, 90, 100, 85, 70, 60, 90, 100, 110, 95, 85, 100, 120, 135, 125, 110, 100, 90, 110, 130, 150, 140, 120, 100, 90, 110, 130, 125], // Jan
        1: [60, 75, 90, 85, 100, 110, 95, 80, 70, 100, 110, 120, 105, 95, 110, 130, 145, 135, 120, 110, 100, 120, 140, 160, 150, 130, 110, 100, 120, 140], // Feb
        2: [70, 85, 100, 95, 110, 120, 105, 90, 80, 110, 120, 130, 115, 105, 120, 140, 155, 145, 130, 120, 110, 130, 150, 170, 160, 140, 120, 110, 130, 150, 145], // Mar
        3: [80, 95, 110, 105, 120, 130, 115, 100, 90, 120, 130, 140, 125, 115, 130, 150, 165, 155, 140, 130, 120, 140, 160, 180, 170, 150, 130, 120, 140, 160], // Apr
        4: [90, 105, 120, 115, 130, 140, 125, 110, 100, 130, 140, 150, 135, 125, 140, 160, 175, 165, 150, 140, 130, 150, 170, 190, 180, 160, 140, 130, 150, 170, 165], // May
        5: [100, 115, 130, 125, 140, 150, 135, 120, 110, 140, 150, 160, 145, 135, 150, 170, 185, 175, 160, 150, 140, 160, 180, 200, 190, 170, 150, 140, 160, 180], // Jun
        6: [110, 125, 140, 135, 150, 160, 145, 130, 120, 150, 160, 170, 155, 145, 160, 180, 195, 185, 170, 160, 150, 170, 190, 210, 200, 180, 160, 150, 170, 190, 185], // Jul
        7: [120, 135, 150, 145, 160, 170, 155, 140, 130, 160, 170, 180, 165, 155, 170, 190, 205, 195, 180, 170, 160, 180, 200, 220, 210, 190, 170, 160, 180, 200, 195], // Aug
        8: [130, 145, 160, 155, 170, 180, 165, 150, 140, 170, 180, 190, 175, 165, 180, 200, 215, 205, 190, 180, 170, 190, 210, 230, 220, 200, 180, 170, 190, 210], // Sep
        9: [140, 155, 170, 165, 180, 190, 175, 160, 150, 180, 190, 200, 185, 175, 190, 210, 225, 215, 200, 190, 180, 200, 220, 240, 230, 210, 190, 180, 200, 220, 215], // Oct
        10: [150, 165, 180, 175, 190, 200, 185, 170, 160, 190, 200, 210, 195, 185, 200, 220, 235, 225, 210, 200, 190, 210, 230, 250, 240, 220, 200, 190, 210, 230], // Nov
        11: [160, 175, 190, 185, 200, 210, 195, 180, 170, 200, 210, 220, 205, 195, 210, 230, 245, 235, 220, 210, 200, 220, 240, 260, 250, 230, 210, 200, 220, 240, 235]  // Dec
      };
      
      // Tanggal untuk grafik (1-31)
      const daysInMonth = 31;
      const labels = Array.from({length: daysInMonth}, (_, i) => `${i+1}`);
      
      // Setup grafik
      const ctx = document.getElementById('incomeChart').getContext('2d');
      let chartInstance;
      
      function createChart(monthIndex) {
        // Jika sudah ada grafik, hancurkan dulu
        if (chartInstance) {
          chartInstance.destroy();
        }
        
        // Ambil data untuk bulan yang dipilih
        const selectedData = monthlyData[monthIndex];
        
        // Buat grafik baru
        chartInstance = new Chart(ctx, {
          type: 'line',
          data: {
            labels: labels.slice(0, selectedData.length),
            datasets: [{
              label: 'Pendapatan Harian (Ribu Rp)',
              data: selectedData,
              backgroundColor: 'rgba(59, 130, 246, 0.2)',
              borderColor: 'rgba(59, 130, 246, 1)',
              borderWidth: 2,
              tension: 0.4,
              fill: true,
              pointRadius: 0,
              pointHoverRadius: 3
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false
              },
              tooltip: {
                enabled: true
              }
            },
            scales: {
              x: {
                display: false
              },
              y: {
                display: false,
                beginAtZero: true
              }
            }
          }
        });
      }
      
      // Buat grafik pertama kali untuk Januari
      createChart(0);
      
      // Fungsi untuk update grafik saat bulan dipilih
      window.updateGraphByMonth = function() {
        const monthSelector = document.getElementById('monthSelector');
        const selectedMonth = parseInt(monthSelector.value);
        createChart(selectedMonth);
      };
      
      // Toggle dropdown untuk Total Found
      const totalFoundDropdown = document.getElementById('totalFoundDropdown');
      const totalFoundOptions = document.getElementById('totalFoundOptions');
      
      totalFoundDropdown.addEventListener('click', function() {
        totalFoundOptions.classList.toggle('hidden');
      });
      
      // Toggle dropdown untuk Graph
      const graphDropdown = document.getElementById('graphDropdown');
      const graphOptions = document.getElementById('graphOptions');
      
      graphDropdown.addEventListener('click', function() {
        graphOptions.classList.toggle('hidden');
      });
      
      // Fungsi untuk mengubah teks periode
      window.changePeriod = function(elementId, value) {
        document.getElementById(elementId).textContent = value;
        // Sembunyikan dropdown setelah memilih
        if (elementId === 'totalFoundPeriod') {
          totalFoundOptions.classList.add('hidden');
        } else if (elementId === 'graphPeriod') {
          graphOptions.classList.add('hidden');
        }
      };
      
      // Tutup dropdown ketika mengklik di luar
      document.addEventListener('click', function(event) {
        if (!totalFoundDropdown.contains(event.target)) {
          totalFoundOptions.classList.add('hidden');
        }
        if (!graphDropdown.contains(event.target)) {
          graphOptions.classList.add('hidden');
        }
      });
    });
  </script>

@include('General.footer')
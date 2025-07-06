@include('General.header')

<div class="p-4">
    <div class="p-4 mt-14">
        <h2 class="text-xl font-semibold mb-2 flex items-center gap-1">
            Ringkasan Admin (Hardcoded Data)
            <span class="text-gray-400 text-base">
                <i class="fas fa-info-circle"></i>
            </span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            {{-- Total Tasks --}}
            <div
                class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <i class="fa fa-list-check text-5xl ml-10"></i>
                <div class="text-right mr-5">
                    <p class="text-base font-medium">Total Tugas</p>
                    <p class="text-4xl font-bold">150</p> {{-- Hardcoded value --}}
                </div>
            </div>

            {{-- Total Pending Withdrawal Requests --}}
            <div
                class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <i class="fa fa-money-bill-transfer text-5xl ml-10"></i>
                <div class="text-right mr-5">
                    <p class="text-base font-medium">Request Pencairan Dana</p>
                    <p class="text-4xl font-bold">7</p> {{-- Hardcoded value --}}
                </div>
            </div>

            {{-- Total Pending Arbitration Requests --}}
            <div
                class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <i class="fa fa-gavel text-5xl ml-10"></i>
                <div class="text-right mr-5">
                    <p class="text-base font-medium">Ajuan Arbitrase</p>
                    <p class="text-4xl font-bold">3</p> {{-- Hardcoded value --}}
                </div>
            </div>

            {{-- Total Workers --}}
            <div
                class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <i class="fa fa-person-digging text-5xl ml-10"></i>
                <div class="text-right mr-5">
                    <p class="text-base font-medium">Total Worker</p>
                    <p class="text-4xl font-bold">85</p> {{-- Hardcoded value --}}
                </div>
            </div>

            {{-- Total Clients --}}
            <div
                class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <i class="fa fa-user-tie text-5xl ml-10"></i>
                <div class="text-right mr-5">
                    <p class="text-base font-medium">Total Client</p>
                    <p class="text-4xl font-bold">42</p> {{-- Hardcoded value --}}
                </div>
            </div>
        </div>

        <div class="mt-2 grid grid-cols-1 sm:grid-cols-1 gap-6">
            <div class="hidden sm:block"></div>
            <div class="bg-white border rounded p-4 shadow-sm col-span-1 sm:col-span-3">
                {{-- Chart --}}
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-lg">Grafik Status Tugas (Keseluruhan - Hardcoded)</h3>
                    <span class="text-sm text-gray-500">{{ now()->year }}</span>
                </div>
                <div class="w-full h-64 relative">
                    <canvas id="statusChart" class="absolute left-0 top-0 w-full h-full"></canvas>
                </div>
            </div>
        </div>

        {{-- Data hardcode untuk list terbaru --}}
        @php
            $hardcodedRecentTasks = [
                ['id' => 'task1', 'title' => 'Desain Landing Page', 'client_name' => 'PT. Inovasi Jaya', 'created_at' => '2025-07-01'],
                ['id' => 'task2', 'title' => 'Penulisan Artikel SEO', 'client_name' => 'CV. Kreatif Solusi', 'created_at' => '2025-06-28'],
                ['id' => 'task3', 'title' => 'Bug Fixing Aplikasi Mobile', 'client_name' => 'Startup Bersama', 'created_at' => '2025-06-25'],
                ['id' => 'task4', 'title' => 'Input Data Spreadsheet', 'client_name' => 'Firma Hukum Adil', 'created_at' => '2025-06-20'],
                ['id' => 'task5', 'title' => 'Terjemahan Dokumen', 'client_name' => 'Global Connections', 'created_at' => '2025-06-18'],
            ];

            $hardcodedWithdrawalRequests = [
                ['id' => 'wd1', 'amount' => 500000, 'worker_name' => 'Budi Santoso', 'status' => 'pending'],
                ['id' => 'wd2', 'amount' => 250000, 'worker_name' => 'Ani Lestari', 'status' => 'pending'],
                ['id' => 'wd3', 'amount' => 750000, 'worker_name' => 'Cahya Ramadhan', 'status' => 'pending'],
            ];

            $hardcodedArbitrationRequests = [
                ['id' => 'arb1', 'task_title' => 'Desain Logo Perusahaan', 'requester_name' => 'Client A', 'status' => 'pending'],
                ['id' => 'arb2', 'task_title' => 'Pembuatan Aplikasi Kasir', 'requester_name' => 'Worker B', 'status' => 'pending'],
            ];
        @endphp


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">

            {{-- RECENT TASKS --}}
            <div class="bg-white border rounded p-4 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Tugas Terbaru (Hardcoded)</h2>
                @if (empty($hardcodedRecentTasks))
                    <p class="text-center text-gray-500">Belum ada tugas yang diposting</p>
                @else
                    <ul class="space-y-4 min-h-[150px]">
                        @foreach ($hardcodedRecentTasks as $task)
                            <li class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                                        <i class="fas fa-briefcase text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-sm md:text-base">{{ $task['title'] }}</p>
                                        <p class="text-gray-400 text-xs">Client: {{ $task['client_name'] }}</p>
                                        <p class="text-gray-400 text-xs">Dibuat {{ \Carbon\Carbon::parse($task['created_at'])->format('d F Y') }}</p>
                                    </div>
                                </div>
                                {{--<a href="{{ route('admin.jobs.show', $task['id']) }}" class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Lihat</a>--}}
                            </li>
                        @endforeach
                    </ul>
                    {{-- Pagination hardcode (opsional, bisa dihapus jika tidak dibutuhkan) --}}
                    <div class="flex justify-end mt-4">
                        <p class="text-gray-500 text-sm">Hanya menampilkan data hardcode.</p>
                    </div>
                @endif
            </div>

            {{-- RECENT WITHDRAWAL REQUESTS --}}
            <div class="bg-white border rounded p-4 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Permintaan Pencairan Dana Terbaru (Hardcoded)</h2>
                @if (empty($hardcodedWithdrawalRequests))
                    <p class="text-center text-gray-500">Belum ada permintaan pencairan dana</p>
                @else
                    <ul class="space-y-4 min-h-[150px]">
                        @foreach ($hardcodedWithdrawalRequests as $withdrawal)
                            <li class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                                        <i class="fas fa-wallet text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-sm md:text-base">Rp{{ number_format($withdrawal['amount'], 0, ',', '.') }}</p>
                                        <p class="text-gray-400 text-xs">Worker: {{ $withdrawal['worker_name'] }}</p>
                                        <p class="text-gray-400 text-xs">Status: {{ ucfirst($withdrawal['status']) }}</p>
                                    </div>
                                </div>
                                {{--<a href="{{ route('admin.withdrawal-requests.show', $withdrawal['id']) }}" class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Lihat</a>--}}
                            </li>
                        @endforeach
                    </ul>
                    {{-- Pagination hardcode (opsional) --}}
                    <div class="flex justify-end mt-4">
                        <p class="text-gray-500 text-sm">Hanya menampilkan data hardcode.</p>
                    </div>
                @endif
            </div>

            {{-- RECENT ARBITRATION REQUESTS --}}
            <div class="bg-white border rounded p-4 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Ajuan Arbitrase Terbaru (Hardcoded)</h2>
                @if (empty($hardcodedArbitrationRequests))
                    <p class="text-center text-gray-500">Belum ada ajuan arbitrase</p>
                @else
                    <ul class="space-y-4 min-h-[150px]">
                        @foreach ($hardcodedArbitrationRequests as $arbitration)
                            <li class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                                        <i class="fas fa-scale-balanced text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-sm md:text-base">{{ $arbitration['task_title'] }}</p>
                                        <p class="text-gray-400 text-xs">Dari: {{ $arbitration['requester_name'] }}</p>
                                        <p class="text-gray-400 text-xs">Status: {{ ucfirst($arbitration['status']) }}</p>
                                    </div>
                                </div>
                                {{--<a href="{{ route('admin.arbitration-requests.show', $arbitration['id']) }}" class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Lihat</a>--}}
                            </li>
                        @endforeach
                    </ul>
                    {{-- Pagination hardcode (opsional) --}}
                    <div class="flex justify-end mt-4">
                        <p class="text-gray-500 text-sm">Hanya menampilkan data hardcode.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Data hardcode untuk chart --}}
@php
    $hardcodedOngoingData = [10, 15, 12, 18, 20, 25, 22, 28, 30, 35, 32, 38]; // Example hardcoded data
    $hardcodedCompletedData = [5, 8, 7, 10, 12, 15, 14, 18, 20, 22, 21, 25]; // Example hardcoded data
@endphp

@include('General.footer')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#1F4482',
            confirmButtonText: 'OK'
        });
        @endif
    });

    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                    label: 'Tugas Sedang Berjalan',
                    data: @json($hardcodedOngoingData), // Using hardcoded data
                    borderColor: '#3b82f6',
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6'
                },
                {
                    label: 'Tugas Selesai',
                    data: @json($hardcodedCompletedData), // Using hardcoded data
                    borderColor: '#10b981',
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#10b981'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
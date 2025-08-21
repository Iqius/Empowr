@include('General.header')

<div class="p-4">
    <div class="p-4 mt-14">
        <h2 class="text-xl font-semibold mb-2 flex items-center gap-1">
            Ringkasan Data Admin
            <span class="text-gray-400 text-base">
                <i class="fas fa-info-circle"></i>
            </span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @php
            use App\Models\Transaction;
            use App\Models\Arbitrase;
            use App\Models\User;

            // Hitung total semua task yang ada (untuk admin)
            $totalTasks = \App\Models\Task::count();

            $totalPendingWithdrawals = Transaction::where('type', 'payout')
            ->count();

            $totalPendingArbitration = Arbitrase::count();

            $totalWorkers = User::where('role', 'worker')->count();

            $totalClients = User::where('role', 'client')->count();
            @endphp

            {{-- Total Tasks --}}
            <div
                class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <i class="fa fa-list-check text-5xl ml-10"></i>
                <div class="text-right mr-5">
                    <p class="text-base font-medium">Total Tugas</p>
                    <p class="text-4xl font-bold">{{ $totalTasks }}</p>
                </div>
            </div>

            {{-- Total Pending Withdrawal Requests --}}
            <div
                class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <i class="fa fa-money-bill-transfer text-5xl ml-10"></i>
                <div class="text-right mr-5">
                    <p class="text-base font-medium">Request Pencairan Dana</p>
                    <p class="text-4xl font-bold">{{ $totalPendingWithdrawals }}</p>
                </div>
            </div>

            {{-- Total Pending Arbitrase Requests --}}
            <div
                class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <i class="fa fa-gavel text-5xl ml-10"></i>
                <div class="text-right mr-5">
                    <p class="text-base font-medium">Ajuan Arbitrase</p>
                    <p class="text-4xl font-bold">{{ $totalPendingArbitration }}</p>
                </div>
            </div>

            {{-- Total Workers --}}
            <div
                class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <i class="fa fa-person-digging text-5xl ml-10"></i>
                <div class="text-right mr-5">
                    <p class="text-base font-medium">Total Worker</p>
                    <p class="text-4xl font-bold">{{ $totalWorkers }}</p>
                </div>
            </div>

            {{-- Total Clients --}}
            <div
                class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <i class="fa fa-user-tie text-5xl ml-10"></i>
                <div class="text-right mr-5">
                    <p class="text-base font-medium">Total Client</p>
                    <p class="text-4xl font-bold">{{ $totalClients }}</p>
                </div>
            </div>
        </div>

      

            @php
            use App\Models\workerAffiliated;
            use Carbon\Carbon;

            $affiliated = workerAffiliated::with('workerProfile.user')
                ->where('status', 'pending')
                ->paginate(5, ['*'], 'affiliated_page');
            @endphp


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">

            {{-- PENDING AFFILIATED WORKERS --}}
            <div class="bg-white border rounded p-4 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Worker Affiliated Pending</h2>
                @if ($affiliated->isEmpty())
                <p class="text-center text-gray-500">Tidak ada worker affiliated pending</p     >
                @else
                <ul class="space-y-4 min-h-[150px]">
                    @foreach ($affiliated as $affiliation)
                    <li class="flex items-center justify-between">
                        <div class="flex items  -center gap-3">
                            <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                                <i class="fas fa-user-check text-gray-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-sm md:text-base">{{ $affiliation->workerProfile->user->nama_lengkap ?? 'Worker #' . $affiliation->worker_id }}</p>
                                <p class="text-gray-400 text-xs">Status: {{ ucfirst($affiliation->status) }}</p>
                                <p class="text-gray-400 text-xs">Tanggal: {{ Carbon::parse($affiliation->created_at)->format('d F Y') }}</p>
                            </div>
                        </div>
                            <a href="{{ url('/admin/List-Request-Affiliasi-Worker') }}" class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Lihat</a>
                    </li>
                    @endforeach
                </ul>   

                {{-- Pagination --}}
                <div class="flex justify-end mt-4">
                    <nav class="inline-flex gap-1">
                        @if ($affiliated->onFirstPage())
                        <button class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded opacity-50" disabled>«</button>
                        @else               
                        <a href="{{ $affiliated->appends(request()->except('affiliated_page'))->previousPageUrl() }}"
                            class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded">«</a>
                        @endif
                        @foreach ($affiliated->getUrlRange(1, $affiliated->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                            class="px-3 py-1 text-sm rounded border {{ $page == $affiliated->currentPage() ? 'bg-[#1F4482] text-white border-[#1F4482]' : 'bg-white text-[#1F4482] border-[#1F4482]' }}">
                            {{ $page }}
                        </a>
                        @endforeach         
                        @if ($affiliated->hasMorePages())
                        <a href="{{ $affiliated->appends(request()->except('affiliated_page'))->nextPageUrl() }}"
                            class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded">»</a>
                        @else
                        <button class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded opacity-50" disabled>»</button>
                        @endif
                    </nav>
                </div>
                @endif
            </div>  


            @php

            $recentWithdrawals = Transaction::with(['worker.user', 'client'])
            ->where('type', 'payout')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'withdrawals_page');
            @endphp


            {{-- RECENT WITHDRAWAL REQUESTS --}}
            <div class="bg-white border rounded p-4 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Permintaan Pencairan Dana Terbaru</h2>

                @if ($recentWithdrawals->isEmpty())
                <p class="text-center text-gray-500">Belum ada permintaan pencairan dana</p>
                @else
                <ul class="space-y-4 min-h-[150px]">
                    @foreach ($recentWithdrawals as $withdrawal)
                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                                <i class="fas fa-wallet text-gray-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-sm md:text-base">Rp{{ number_format($withdrawal->amount, 0, ',', '.') }}</p>
                                <p class="text-gray-400 text-xs">
                                    Worker:
                                    {{ $withdrawal->worker->user->nama_lengkap ?? $withdrawal->client->nama_lengkap ?? '-' }}
                                </p>
                                <p class="text-gray-400 text-xs">Status:
                                    @switch($withdrawal->status)
                                    @case('pending') <span class="text-yellow-500 font-semibold">Menunggu</span> @break
                                    @case('success') <span class="text-green-600 font-semibold">Disetujui</span> @break
                                    @case('reject') <span class="text-red-600 font-semibold">Ditolak</span> @break
                                    @default <span class="text-gray-500">-</span>
                                    @endswitch
                                </p>
                                <p class="text-gray-400 text-xs">Tanggal: {{ \Carbon\Carbon::parse($withdrawal->created_at)->format('d F Y') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('withdraw.view', $withdrawal->id) }}" class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Lihat</a>
                    </li>
                    @endforeach
                </ul>

                {{-- Pagination --}}
                <div class="flex justify-end mt-4">
                    <nav class="inline-flex gap-1">
                        @if ($recentWithdrawals->onFirstPage())
                        <button class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded opacity-50" disabled>«</button>
                        @else
                        <a href="{{ $recentWithdrawals->appends(request()->except('withdrawals_page'))->previousPageUrl() }}"
                            class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded">«</a>
                        @endif

                        @foreach ($recentWithdrawals->getUrlRange(1, $recentWithdrawals->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                            class="px-3 py-1 text-sm rounded border {{ $page == $recentWithdrawals->currentPage() ? 'bg-[#1F4482] text-white border-[#1F4482]' : 'bg-white text-[#1F4482] border-[#1F4482]' }}">
                            {{ $page }}
                        </a>
                        @endforeach

                        @if ($recentWithdrawals->hasMorePages())
                        <a href="{{ $recentWithdrawals->appends(request()->except('withdrawals_page'))->nextPageUrl() }}"
                            class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded">»</a>
                        @else
                        <button class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded opacity-50" disabled>»</button>
                        @endif
                    </nav>
                </div>
                @endif
            </div>

            @php

            $recentArbitrations = Arbitrase::with(['task'])
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'arbitration_page');
            @endphp

            {{-- RECENT ARBITRATION REQUESTS --}}
            <div class="bg-white border rounded p-4 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Ajuan Arbitrase Terbaru</h2>
                @if ($recentArbitrations->isEmpty())
                <p class="text-center text-gray-500">Belum ada ajuan arbitrase</p>
                @else
                <ul class="space-y-4 min-h-[150px]">
                    @foreach ($recentArbitrations as $arbitration)
                    <li class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                                <i class="fas fa-scale-balanced text-gray-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-sm md:text-base">
                                    {{ $arbitration->task->title ?? 'Task #' . $arbitration->task_id }}
                                </p>
                                <p class="text-gray-400 text-xs">Dari:
                                    {{ $arbitration->client_id ? 'Client #' . $arbitration->client_id : 'Worker #' . $arbitration->worker_id }}
                                </p>
                                <p class="text-gray-400 text-xs">Status: {{ ucfirst($arbitration->status) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('inProgress.jobs', $arbitration->task_id) }}" class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Detail</a>
                    </li>
                    @endforeach
                </ul>

                {{-- Pagination --}}
                <div class="flex justify-end mt-4">
                    <nav class="inline-flex gap-1">
                        @if ($recentArbitrations->onFirstPage())
                        <button class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded opacity-50" disabled>«</button>
                        @else
                        <a href="{{ $recentArbitrations->appends([
                        'withdrawals_page' => request('withdrawals_page'),
                        'ongoing_page' => request('ongoing_page'),
                        'applications_page' => request('applications_page')
                    ])->previousPageUrl() }}"
                            class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded">«</a>
                        @endif

                        @foreach ($recentArbitrations->getUrlRange(1, $recentArbitrations->lastPage()) as $page => $url)
                        <a href="{{ $url }}&withdrawals_page={{ request('withdrawals_page') }}&ongoing_page={{ request('ongoing_page') }}&applications_page={{ request('applications_page') }}"
                            class="px-3 py-1 text-sm rounded border {{ $page == $recentArbitrations->currentPage() ? 'bg-[#1F4482] text-white border-[#1F4482]' : 'bg-white text-[#1F4482] border-[#1F4482]' }}">
                            {{ $page }}
                        </a>
                        @endforeach

                        @if ($recentArbitrations->hasMorePages())
                        <a href="{{ $recentArbitrations->appends([
                        'withdrawals_page' => request('withdrawals_page'),
                        'ongoing_page' => request('ongoing_page'),
                        'applications_page' => request('applications_page')
                    ])->nextPageUrl() }}"
                            class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded">»</a>
                        @else
                        <button class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded opacity-50" disabled>»</button>
                        @endif
                    </nav>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

@php
use Illuminate\Support\Facades\DB;

$user = Auth::user();

$ongoingData = [];
$completedData = [];

// Loop setiap bulan
foreach (range(1, 12) as $month) {
$ongoing = \App\Models\Task::where('client_id', $user->id)
->whereMonth('created_at', $month)
->where('status', 'in progress')
->count();

$completed = \App\Models\Task::where('client_id', $user->id)
->whereMonth('created_at', $month)
->where('status', 'completed')
->count();

$ongoingData[] = $ongoing;
$completedData[] = $completed;
}
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
                    label: 'Ongoing',
                    data: @json($ongoingData),
                    borderColor: '#3b82f6',
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6'
                },
                {
                    label: 'Completed',
                    data: @json($completedData),
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
@include('General.header')

<div class="p-4 ">
  <div class="p-4 mt-14">
    <a href="{{ route('add-job-view') }}"
      class="inline-block bg-[#183E74] hover:bg-[#1a4a91] text-white text-sm sm:text-base px-8 py-2 rounded-md shadow mb-6">
      Tambah Tugas
    </a>
    <h2 class="text-xl font-semibold mb-2 flex items-center gap-1">
      Tugas Kamu
      <span class="text-gray-400 text-base">
        <i class="fas fa-info-circle"></i>
      </span>
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      @php
      $user = Auth::user();
      $postTasks = \App\Models\Task::where('client_id', $user->id)->count();
      @endphp

      <!-- Task Diposting -->
      <div
        class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <i class="fa fa-square-plus text-5xl ml-10"></i>
        <div class="text-right mr-5">
          <p class="text-base font-medium">Tugas Diposting</p>
          <p class="text-4xl font-bold">{{ $postTasks }}</p>
        </div>
      </div>



      <!-- Sedang Berjalan -->
      @php
      $user = Auth::user();
      $onTasks = \App\Models\Task::where('client_id', $user->id)
      ->where('status', 'in progress')
      ->count();
      @endphp

      <div
        class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <i class="fa fa-handshake text-5xl ml-10"></i>
        <div class="text-right mr-5">
          <p class="text-base font-medium">Sedang Berjalan</p>
          <p class="text-4xl font-bold">{{ $onTasks }}</p>
        </div>
      </div>

      <!-- Task Selesai -->
      @php
      $user = Auth::user();
      $doneTasks = \App\Models\Task::where('client_id', $user->id)
      ->where('status', 'completed')
      ->count();
      @endphp
      <div
        class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <i class="fa fa-clipboard-check text-5xl ml-10"></i>
        <div class="text-right mr-5">
          <p class="text-base font-medium">Tugas Selesai</p>
          <p class="text-4xl font-bold">{{ $doneTasks }}</p>
        </div>
      </div>

      <!-- Total Pelamar -->
      @php
      $user = Auth::user();

      // Ambil semua task_id milik client
      $taskIds = \App\Models\Task::where('client_id', $user->id)->pluck('id');

      // Hitung total lamaran (task_applications) ke task-task itu
      $totalApplications = \App\Models\TaskApplication::whereIn('task_id', $taskIds)

      ->count();
      @endphp

      <div
        class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <i class="fa fa-user-tie text-5xl ml-10"></i>
        <div class="text-right mr-5">
          <p class="text-base font-medium">Total Lamaran</p>
          <p class="text-4xl font-bold">{{ $totalApplications }}</p>
        </div>
      </div>
    </div>

    <div class="mt-2 grid grid-cols-1 sm:grid-cols-1 gap-6">
      <div class="hidden sm:block"></div>
      <div class="bg-white border rounded p-4 shadow-sm col-span-1 sm:col-span-3">
        <!-- Chart  -->
        <div class="flex items-center justify-between mb-4">
          <h3 class="font-semibold text-lg">Grafik Tugas</h3>
          <span class="text-sm text-gray-500">2025 </span>
        </div>
        <div class="w-full h-64 relative">
          <canvas id="statusChart" class="absolute left-0 top-0 w-full h-full"></canvas>
        </div>
      </div>
    </div>

    @php
    $user = Auth::user();

    $postedTasks = \App\Models\Task::where('client_id', $user->id)
    ->orderBy('created_at', 'desc')
    ->paginate(3, ['*'], 'posted_page');

    $onGoingTasks = \App\Models\Task::where('client_id', $user->id)
    ->where('status', 'in progress')
    ->orderBy('created_at', 'desc')
    ->paginate(3, ['*'], 'ongoing_page');

    $taskIds = \App\Models\Task::where('client_id', $user->id)->pluck('id');

    $applications = \App\Models\TaskApplication::with(['task', 'worker.user'])
    ->whereIn('task_id', $taskIds)
    ->orderBy('applied_at', 'desc')
    ->paginate(3, ['*'], 'applications_page');
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">

      {{-- TUGAS --}}
      <div class="bg-white border rounded p-4 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Tugas</h2>
        @if ($postedTasks->isEmpty())
        <p class="text-center text-gray-500">Belum ada tugas yang diposting</p>
        @else
        <ul class="space-y-4 min-h-[150px]">
          @foreach ($postedTasks as $task)
          <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                <i class="fas fa-briefcase text-gray-600"></i>
              </div>
              <div>
                <p class="font-medium text-sm md:text-base">{{ $task->title }}</p>
                <p class="text-gray-400 text-xs">Created {{ \Carbon\Carbon::parse($task->created_at)->format('d F Y') }}</p>
              </div>
            </div>
            <a href="{{ route('jobs.show', $task->id) }}" class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</a>
          </li>
          @endforeach
        </ul>

        {{-- Pagination TUGAS --}}
        <div class="flex justify-end mt-4">
          <nav class="inline-flex gap-1">
            @if ($postedTasks->onFirstPage())
            <button class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded opacity-50" disabled>«</button>
            @else
            <a href="{{ $postedTasks->appends([
              'ongoing_page' => request('ongoing_page'),
              'applications_page' => request('applications_page')
            ])->previousPageUrl() }}"
              class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded">«</a>
            @endif

            @foreach ($postedTasks->getUrlRange(1, $postedTasks->lastPage()) as $page => $url)
            <a href="{{ $url }}&ongoing_page={{ request('ongoing_page') }}&applications_page={{ request('applications_page') }}"
              class="px-3 py-1 text-sm rounded border {{ $page == $postedTasks->currentPage() ? 'bg-[#1F4482] text-white border-[#1F4482]' : 'bg-white text-[#1F4482] border-[#1F4482]' }}">
              {{ $page }}
            </a>
            @endforeach

            @if ($postedTasks->hasMorePages())
            <a href="{{ $postedTasks->appends([
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

      {{-- SEDANG BERJALAN --}}
      <div class="bg-white border rounded p-4 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Sedang Berjalan</h2>
        @if ($onGoingTasks->isEmpty())
        <p class="text-center text-gray-500">Belum ada tugas yang sedang berjalan</p>
        @else
        <ul class="space-y-4 min-h-[150px]">
          @foreach ($onGoingTasks as $task)
          <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                <i class="fas fa-briefcase text-gray-600"></i>
              </div>
              <div>
                <p class="font-medium text-sm md:text-base">{{ $task->title }}</p>
                <p class="text-gray-400 text-xs">Created {{ \Carbon\Carbon::parse($task->created_at)->format('d F Y') }}</p>
              </div>
            </div>
            <a href="{{ route('jobs.show', $task->id) }}" class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</a>
          </li>
          @endforeach
        </ul>

        {{-- Pagination SEDANG BERJALAN --}}
        <div class="flex justify-end mt-4">
          <nav class="inline-flex gap-1">
            @if ($onGoingTasks->onFirstPage())
            <button class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded opacity-50" disabled>«</button>
            @else
            <a href="{{ $onGoingTasks->appends([
              'posted_page' => request('posted_page'),
              'applications_page' => request('applications_page')
            ])->previousPageUrl() }}"
              class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded">«</a>
            @endif

            @foreach ($onGoingTasks->getUrlRange(1, $onGoingTasks->lastPage()) as $page => $url)
            <a href="{{ $url }}&posted_page={{ request('posted_page') }}&applications_page={{ request('applications_page') }}"
              class="px-3 py-1 text-sm rounded border {{ $page == $onGoingTasks->currentPage() ? 'bg-[#1F4482] text-white border-[#1F4482]' : 'bg-white text-[#1F4482] border-[#1F4482]' }}">
              {{ $page }}
            </a>
            @endforeach

            @if ($onGoingTasks->hasMorePages())
            <a href="{{ $onGoingTasks->appends([
              'posted_page' => request('posted_page'),
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

      {{-- LAMARAN WORKER --}}
      <div class="bg-white border rounded p-4 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Lamaran Worker</h2>
        @if ($applications->isEmpty())
        <p class="text-center text-gray-500">Belum ada lamaran dari worker</p>
        @else
        <ul class="space-y-4 min-h-[150px]">
          @foreach ($applications as $app)
          <li class="flex items-center justify-between hover:bg-gray-100 hover:rounded p-2">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                <i class="fas fa-briefcase text-[#1F4482]"></i>
              </div>
              <div>
                <p class="font-medium text-sm md:text-base">{{ $app->task->title ?? '-' }}</p>
                <p class="text-gray-400 text-xs">Applier {{ $app->worker->user->nama_lengkap ?? '-' }}</p>
              </div>
            </div>
            <a href="{{ route('jobs.show', $app->task->id) }}" class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</a>
          </li>
          @endforeach
        </ul>

        {{-- Pagination LAMARAN WORKER --}}
        <div class="flex justify-end mt-4">
          <nav class="inline-flex gap-1">
            @if ($applications->onFirstPage())
            <button class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded opacity-50" disabled>«</button>
            @else
            <a href="{{ $applications->appends([
              'posted_page' => request('posted_page'),
              'ongoing_page' => request('ongoing_page')
            ])->previousPageUrl() }}"
              class="border border-[#1F4482] text-[#1F4482] bg-white px-3 py-1 text-sm rounded">«</a>
            @endif

            @foreach ($applications->getUrlRange(1, $applications->lastPage()) as $page => $url)
            <a href="{{ $url }}&posted_page={{ request('posted_page') }}&ongoing_page={{ request('ongoing_page') }}"
              class="px-3 py-1 text-sm rounded border {{ $page == $applications->currentPage() ? 'bg-[#1F4482] text-white border-[#1F4482]' : 'bg-white text-[#1F4482] border-[#1F4482]' }}">
              {{ $page }}
            </a>
            @endforeach

            @if ($applications->hasMorePages())
            <a href="{{ $applications->appends([
              'posted_page' => request('posted_page'),
              'ongoing_page' => request('ongoing_page')
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

@php
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // ✅ SweetAlert for Success Message
    @if(session('success'))
    Swal.fire({
      icon: 'success',
      title: 'Berhasil Login!',
      text: "{{ session('success') }}",
      confirmButtonColor: '#1F4482',
      confirmButtonText: 'OK'
    }).then(() => {
      window.location.href = window.location.href;
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
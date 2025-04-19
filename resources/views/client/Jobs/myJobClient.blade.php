@include('General.header')

<section class="p-4 sm:p-6 md:p-8 mt-16">
<div class="flex flex-col md:flex-row gap-4 mb-6">
    <!-- Search Input -->
    <input type="text" placeholder="Search Job" class="p-2 border rounded w-full md:w-1/3" id="searchInput">

    <!-- Status Dropdown -->
    <select class="p-2 border rounded w-full md:w-auto" id="statusFilter">
        <option value="">Semua Status</option>
        <option value="open">Belum Dikerjakan</option>
        <option value="in progress">Sedang Dikerjakan</option>
        <option value="completed">Selesai Dikerjakan</option>
    </select>

</div>



    <!-- Job List -->
    <div class="grid grid-cols-1 sm:grid-cols-2  lg:grid-cols-3 xl:grid-cols-4 gap-4 w-full" id="jobContainer">
        @php
            $task = \App\Models\Task::with('user')->where('client_id', Auth::id())->get();
        @endphp

        @foreach ($task as $index => $job)
            <div class="bg-white p-4 rounded shadow-md hover:shadow-lg transition duration-200" data-status="{{ $job->status }}">
                <a href="{{ route('jobs.manage', $job->id) }}">
                    <p class="text-blue-600 font-semibold text-base sm:text-lg">{{ $job->title }}</p>
                    <p class="text-black font-bold mt-2 text-sm sm:text-base">
                        Rp {{ number_format($job->price, 0, ',', '.') }}
                    </p>
                    <p class="text-gray-500 text-sm">By {{ $job->user->nama_lengkap ?? 'Unknown' }}</p>
                    <p class="text-xs text-gray-400 mt-1">Status: {{ $job->status }}</p>
                </a>
            </div>
        @endforeach
    </div>
</section>

@include('General.footer')

<!-- Script: Filter Tab -->
<script>
    document.getElementById('statusFilter').addEventListener('change', function () {
        const status = this.value;
        document.querySelectorAll('#jobContainer > div').forEach(card => {
            if (!status) {
                card.style.display = 'block';
            } else {
                card.style.display = (card.dataset.status === status) ? 'block' : 'none';
            }
        });
    });
</script>


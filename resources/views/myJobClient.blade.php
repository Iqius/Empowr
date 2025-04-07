@include('client.header')

<section class="p-4 sm:p-6 md:p-8 lg:ml-64 mt-16">
<div class="flex flex-col md:flex-row gap-4 mb-6">
    <!-- Search Input -->
    <input type="text" placeholder="Search Job" class="p-2 border rounded w-full md:w-1/3" id="searchInput">

    <!-- Status Dropdown -->
    <select class="p-2 border rounded w-full md:w-auto" id="statusFilter">
        <option disabled selected>Filter Status</option>
        <option value="belum">Belum Dikerjakan</option>
        <option value="sedang">Sedang Dikerjakan</option>
        <option value="selesai">Selesai Dikerjakan</option>
    </select>

    <!-- Filter Button -->
    <button class="p-2 border rounded bg-blue-600 text-white w-full md:w-auto">Filter</button>
</div>



    <!-- Job List -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 w-full" id="jobContainer">
        @php
            $jobs = \App\Models\Job::where('user_id', Auth::id())->get();
            $statuses = ['belum', 'sedang', 'selesai'];
        @endphp

        @foreach ($jobs as $index => $job)
            @php $status = $statuses[$index % 3]; @endphp
            <div class="bg-white p-4 rounded shadow-md hover:shadow-lg transition duration-200" data-status="{{ $status }}">
                <a href="{{ route('jobs.manage', $job->id) }}">
                    <p class="text-blue-600 font-semibold text-base sm:text-lg">{{ $job->title }}</p>
                    <p class="text-black font-bold mt-2 text-sm sm:text-base">
                        Rp {{ number_format($job->price, 0, ',', '.') }}
                    </p>
                    <p class="text-gray-500 text-sm">By {{ $job->user->name ?? 'Unknown' }}</p>
                    <p class="text-xs text-gray-400 mt-1">Status: {{ ucfirst($status) }}</p>
                </a>
            </div>
        @endforeach
    </div>
</section>

@include('client.footer')

<!-- Script: Filter Tab -->
<script>
 document.getElementById('statusFilter').addEventListener('change', function () {
        const status = this.value;
        document.querySelectorAll('#jobContainer > div').forEach(card => {
            card.style.display = (card.dataset.status === status) ? 'block' : 'none';
        });
    });
</script>

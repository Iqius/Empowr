@include('General.header')

<section class="p-4 sm:p-6 md:p-8  mt-16">
  <div class="flex flex-col md:flex-row gap-4 mb-6">
      <!-- Search Input -->
      <input type="text" placeholder="Search Job" class="p-2 border rounded w-full md:w-1/3" id="searchInput">

      <!-- Status Dropdown -->
      <select class="p-2 border rounded w-full md:w-auto" id="statusFilter">
          <option disabled selected>Filter Status</option>
          <option value="belum">Belum Diterima</option>
          <option value="sedang">Sedang Dikerjakan</option>
          <option value="selesai">Selesai Dikerjakan</option>
      </select>

  </div>

<!-- List Job yang Dilamar oleh Worker (berasal dari task_applications) -->
<div class="grid grid-cols-1 sm:grid-cols-2  lg:grid-cols-3 xl:grid-cols-4 gap-4 w-full" id="jobContainer">

@foreach ($taskApplied as $job)
    <div class="bg-white p-4 rounded shadow-md hover:shadow-lg transition duration-200" data-status="{{ $job->status }}">
        <a href="{{ route('manage.worker', $job->id) }}">
            <p class="text-blue-600 font-semibold text-base sm:text-lg">{{ $job->task->title }}</p>
            <p class="text-black font-bold mt-2 text-sm sm:text-base">
                Rp {{ number_format($job->bidPrice, 0, ',', '.') }}
            </p>
            <p class="text-gray-500 text-sm">By {{ $job->task->client->nama_lengkap ?? 'Unknown' }}</p>
            <p class="text-xs text-gray-400 mt-1">Status: {{ ucfirst($job->status) }}</p>
        </a>
    </div>
@endforeach

</div>


</section>

@include('General.footer')

<!-- Script: Filter -->
<script>
function filterByStatus() {
    const selectedStatus = document.getElementById('statusFilter').value;
    const jobCards = document.querySelectorAll('#jobContainer > div');

    jobCards.forEach(card => {
        card.style.display = card.dataset.status === selectedStatus ? 'block' : 'none';
    });
}
</script>
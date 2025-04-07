@include('client.header')

<section class="p-4 sm:p-6 md:p-8 lg:ml-64 mt-16">
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

      <!-- Filter Button -->
      <button class="p-2 border rounded bg-blue-600 text-white w-full md:w-auto" onclick="filterByStatus()">Filter</button>
  </div>

  <!-- Job List Dummy -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 w-full" id="jobContainer">
      @php
          $dummyJobs = [
              ['title' => 'Desain Logo UMKM', 'price' => 300000, 'by' => 'Client A', 'status' => 'belum'],
              ['title' => 'Landing Page Produk', 'price' => 750000, 'by' => 'Client B', 'status' => 'sedang'],
              ['title' => 'Copywriting Website', 'price' => 500000, 'by' => 'Client C', 'status' => 'selesai'],
              ['title' => 'Social Media Plan', 'price' => 400000, 'by' => 'Client D', 'status' => 'sedang'],
              ['title' => 'UI/UX Redesign', 'price' => 900000, 'by' => 'Client E', 'status' => 'belum'],
              ['title' => 'Edit Video Reels', 'price' => 250000, 'by' => 'Client F', 'status' => 'selesai'],
          ];
      @endphp

      @foreach ($dummyJobs as $job)
          <div class="bg-white p-4 rounded shadow-md hover:shadow-lg transition duration-200" data-status="{{ $job['status'] }}">
              <a href="{{ route('manage.worker') }}"">
                  <p class="text-blue-600 font-semibold text-base sm:text-lg">{{ $job['title'] }}</p>
                  <p class="text-black font-bold mt-2 text-sm sm:text-base">
                      Rp {{ number_format($job['price'], 0, ',', '.') }}
                  </p>
                  <p class="text-gray-500 text-sm">By {{ $job['by'] }}</p>
                  <p class="text-xs text-gray-400 mt-1">Status: {{ ucfirst($job['status']) }}</p>
              </a>
          </div>
      @endforeach
  </div>
</section>

@include('client.footer')

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

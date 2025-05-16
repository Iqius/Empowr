@include('General.header')

<div class="p-4 ">
  <div class="p-4 mt-14">
    <a href="{{ route('add-job-view') }}"
      class="inline-block bg-[#183E74] hover:bg-[#1a4a91] text-white text-sm sm:text-base px-8 py-2 rounded-md shadow mb-6">
      Add New Job
    </a>
    <h2 class="text-xl font-semibold mb-2 flex items-center gap-1">
      Task Kamu
      <span class="text-gray-400 text-base">
        <i class="fas fa-info-circle"></i>
      </span>
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <!-- Task Dilamar -->
      <div
        class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <i class="fa fa-square-plus text-5xl ml-10"></i>
        <div class="text-right mr-5">
          <p class="text-base font-medium">Task Diposting</p>
          <p class="text-4xl font-bold">1</p>
        </div>
      </div>


      <!-- Sedang Berjalan -->
      <div
        class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <i class="fa fa-handshake text-5xl ml-10"></i>
        <div class="text-right mr-5">
          <p class="text-base font-medium">Sedang Berjalan</p>
          <p class="text-4xl font-bold">1</p>
        </div>
      </div>

      <!-- Task Selesai -->
      <div
        class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <i class="fa fa-clipboard-check text-5xl ml-10"></i>
        <div class="text-right mr-5">
          <p class="text-base font-medium">Task Selesai</p>
          <p class="text-4xl font-bold">1</p>
        </div>
      </div>

      <!-- Task Selesai -->
      <div
        class="flex items-center justify-between h-32 bg-white text-[#1F4482] p-6 rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl">
        <i class="fa fa-user-tie text-5xl ml-10"></i>
        <div class="text-right mr-5">
          <p class="text-base font-medium">Total Lamaran</p>
          <p class="text-4xl font-bold">1</p>
        </div>
      </div>
    </div>

    <div class="mt-2 grid grid-cols-1 sm:grid-cols-1 gap-6">
      <div class="hidden sm:block"></div>
      <div class="bg-white border rounded p-4 shadow-sm col-span-1 sm:col-span-3">
        <!-- Chart  -->
        <div class="flex items-center justify-between mb-4">
          <h3 class="font-semibold text-lg">Grafik Task</h3>
          <span class="text-sm text-gray-500">2025 </span>
        </div>
        <div class="w-full h-64 relative">
          <canvas id="statusChart" class="absolute left-0 top-0 w-full h-full"></canvas>
        </div>
      </div>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Jobs -->
      <div class="bg-white border rounded p-4 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Task</h2>
        <ul class="space-y-4">
          <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                <i class="fas fa-briefcase text-gray-600"></i>
              </div>
              <div>
                <p class="font-medium text-sm md:text-base">Visual Designer</p>
                <p class="text-gray-400 text-xs">Applied 24 June 2024</p>
              </div>
            </div>
            <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
          </li>
          <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                <i class="fas fa-briefcase text-gray-600"></i>
              </div>
              <div>
                <p class="font-medium text-sm md:text-base">Graphic Design for Billboard</p>
                <p class="text-gray-400 text-xs">Applied 24 June 2024</p>
              </div>
            </div>
            <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
          </li>
          <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                <i class="fas fa-briefcase text-gray-600"></i>
              </div>
              <div>
                <p class="font-medium text-sm md:text-base">Logo Maker Non AI</p>
                <p class="text-gray-400 text-xs">Applied 24 June 2024</p>
              </div>
            </div>
            <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
          </li>
          <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                <i class="fas fa-briefcase text-gray-600"></i>
              </div>
              <div>
                <p class="font-medium text-sm md:text-base">Designer for Content</p>
                <p class="text-gray-400 text-xs">Applied 24 June 2024</p>
              </div>
            </div>
            <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
          </li>
        </ul>
        <div class="flex justify-between mt-4">
          <div class="mt-4 text-right text-sm text-gray-500">1 to 4 of 16 items</div>
          <nav class="inline-flex gap-1">
            <button class="border px-3 py-1 text-sm rounded">1</button>
            <button class="border px-3 py-1 text-sm rounded">2</button>
            <button class="border px-3 py-1 text-sm rounded">3</button>
            <button class="border px-3 py-1 text-sm rounded">4</button>
          </nav>
        </div>
      </div>
      <!-- On Going Jobs -->
      <div class="bg-white border rounded p-4 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Sedang Berjalan</h2>
        <ul class="space-y-4">
          <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                <i class="fas fa-briefcase text-gray-600"></i>
              </div>
              <div>
                <p class="font-medium text-sm md:text-base">Visual Designer</p>
                <p class="text-gray-400 text-xs">Applied 24 June 2024</p>
              </div>
            </div>
            <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
          </li>
          <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                <i class="fas fa-briefcase text-gray-600"></i>
              </div>
              <div>
                <p class="font-medium text-sm md:text-base">Graphic Design for Billboard</p>
                <p class="text-gray-400 text-xs">Applied 24 June 2024</p>
              </div>
            </div>
            <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
          </li>
        </ul>
        <div class="flex justify-between mt-4">
          <div class="mt-4 text-right text-sm text-gray-500">1 to 2 of 2 items</div>
        </div>
      </div>

      <!-- Worker Applications -->
      <div class="bg-white border rounded p-4 shadow-sm">
        <h2 class="text-lg font-semibold mb-4">Lamaran Worker</h2>
        <ul class="space-y-4">
          <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                <i class="fas fa-briefcase text-gray-600"></i>
              </div>
              <div>
                <p class="font-medium text-sm md:text-base">Visual Designer</p>
                <p class="text-gray-400 text-xs">Applier Fadel Alif</p>
              </div>
            </div>
            <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
          </li>
          <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                <i class="fas fa-briefcase text-gray-600"></i>
              </div>
              <div>
                <p class="font-medium text-sm md:text-base">Visual Designer</p>
                <p class="text-gray-400 text-xs">Applier Dede Rahmat</p>
              </div>
            </div>
            <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
          </li>
          <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                <i class="fas fa-briefcase text-gray-600"></i>
              </div>
              <div>
                <p class="font-medium text-sm md:text-base">Logo Maker Non AI</p>
                <p class="text-gray-400 text-xs">Applier Risky Farhan</p>
              </div>
            </div>
            <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
          </li>
          <li class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                <i class="fas fa-briefcase text-gray-600"></i>
              </div>
              <div>
                <p class="font-medium text-sm md:text-base">Designer for Content</p>
                <p class="text-gray-400 text-xs">Applier David Rahmadana</p>
              </div>
            </div>
            <button class="bg-[#1F4482] text-white px-4 py-1.5 rounded-md text-sm">Open</button>
          </li>
        </ul>

        <!-- Pagination -->
        <div class="flex justify-between mt-4">
          <div class="mt-4 text-right text-sm text-gray-500">1 to 4 of 16 items</div>
          <nav class="inline-flex gap-1">
            <button class="border px-3 py-1 text-sm rounded">1</button>
            <button class="border px-3 py-1 text-sm rounded">2</button>
            <button class="border px-3 py-1 text-sm rounded">3</button>
            <button class="border px-3 py-1 text-sm rounded">4</button>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>


@include('General.footer')

<script>
  document.addEventListener("DOMContentLoaded", function () {
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
      datasets: [
        {
          label: 'Ongoing',
          data: [10, 20, 15, 25, 30, 45, 40, 15, 25, 30, 45, 40],
          borderColor: '#3b82f6',
          fill: false,
          tension: 0.4,
          pointBackgroundColor: '#3b82f6'
        },
        {
          label: 'Completed',
          data: [5, 15, 10, 20, 25, 30, 35, 12, 23, 10, 25, 10],
          borderColor: '#10b981',
          fill: false,
          tension: 0.4,
          pointBackgroundColor: '#10b981'
        },
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
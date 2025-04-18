@include('client.header')
<div class="p-4 mt-16">
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div class="bg-white p-4 rounded shadow flex justify-between items-center">
        <div>
          <p class="text-lg font-semibold">4</p>
          <p class="text-sm text-gray-500">Jobs Posted</p>
        </div>
        <div class="text-blue-500 text-xl">↗</div>
      </div>
      <div class="bg-white p-4 rounded shadow flex justify-between items-center">
        <div>
          <p class="text-lg font-semibold">3</p>
          <p class="text-sm text-gray-500">Ongoing Jobs</p>
        </div>
        <div class="text-blue-500 text-xl">↗</div>
      </div>
      <div class="bg-white p-4 rounded shadow flex justify-between items-center">
        <div>
          <p class="text-lg font-semibold">11</p>
          <p class="text-sm text-gray-500">Completed Jobs</p>
        </div>
        <div class="text-blue-500 text-xl">↗</div>
      </div>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="hidden sm:block"></div>

  <div class="col-span-1 sm:col-span-2 bg-white p-4 rounded shadow">
    <!-- Chart  -->
    <div class="flex items-center justify-between mb-4">
      <h3 class="font-semibold text-lg">Requests by Status</h3>
      <span class="text-sm text-gray-500">2025 </span>
    </div>
    <div class="w-full h-64 relative">
      <canvas id="statusChart" class="absolute left-0 top-0 w-full h-full"></canvas>
    </div>
  </div>

</div>


    <!-- Main Grid -->
  <div class="mt-4 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">

      <!-- Jobs -->
      <div class="bg-white p-4 rounded shadow col-span-1 xl:col-span-1">
        <h3 class="font-semibold text-lg mb-4">Jobs</h3>
        <ul class="space-y-3">
          <li class="flex justify-between items-center border-b pb-2">
            <div>
              <p class="font-medium">Voice-over for Simple Scripts</p>
              <p class="text-sm text-gray-500">Deadline: Monday, 06 May</p>
            </div>
            <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded">Open</span>
          </li>
          <li class="flex justify-between items-center border-b pb-2">
            <div>
              <p class="font-medium">Online Research for Leads</p>
              <p class="text-sm text-gray-500">Deadline: Thursday, 24 April</p>
            </div>
            <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded">Open</span>
          </li>
          <li class="flex justify-between items-center border-b pb-2">
            <div>
              <p class="font-medium">Basic Blog Post Writing</p>
              <p class="text-sm text-gray-500">Deadline: Wednesday, 07 May</p>
            </div>
            <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded">Open</span>
          </li>
          <li class="flex justify-between items-center">
            <div>
              <p class="font-medium">Email Sorting & Filtering</p>
              <p class="text-sm text-gray-500">Deadline: Saturday, 10 May</p>
            </div>
            <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded">Open</span>
          </li>
        </ul>
        <div class="mt-4 text-right text-sm text-gray-500">1 to 4 of 14 items</div>
      </div>

            <!-- Ongoing Jobs -->
            <div class="bg-white p-4 rounded shadow col-span-1 xl:col-span-1">
        <h3 class="font-semibold text-lg mb-4">Ongoing Jobs</h3>
        <ul class="space-y-3">
          <li class="flex justify-between items-center">
            <div>
              <p class="font-medium">Admin Streamer 2 hari</p>
              <p class="text-sm text-gray-500">Applier: testextendbarubaruu</p>
            </div>
            <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded">Open</span>
          </li>
          <li class="flex justify-between items-center">
            <div>
              <p class="font-medium">Testing MVP</p>
              <p class="text-sm text-gray-500">Applier: Worker3</p>
            </div>
            <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded">Open</span>
          </li>
          <li class="flex justify-between items-center">
            <div>
              <p class="font-medium">Admin Streamer 2 hari</p>
              <p class="text-sm text-gray-500">Applier: Worker1</p>
            </div>
            <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded">Open</span>
          </li>
        </ul>
        <div class="mt-4 text-right text-sm text-gray-500">1 to 3 of 3 items</div>
      </div>

     


      <!-- Client Applications -->
      <div class="bg-white p-4 rounded shadow col-span-1 xl:col-span-1">
        <h3 class="font-semibold text-lg mb-4">Client Applications</h3>
        <ul class="space-y-3">
          <li class="flex justify-between items-center">
            <div>
              <p class="font-medium">Admin Streamer 2 hari</p>
              <p class="text-sm text-gray-500">Applier: EmpowrAffiliate</p>
            </div>
            <button class="bg-blue-100 text-blue-700 px-3 py-1 text-sm rounded">Details</button>
          </li>
          <li class="flex justify-between items-center">
            <div>
              <p class="font-medium">Email Sorting & Filtering</p>
              <p class="text-sm text-gray-500">Applier: EmpowrAffiliate</p>
            </div>
            <button class="bg-blue-100 text-blue-700 px-3 py-1 text-sm rounded">Details</button>
          </li>
          <li class="flex justify-between items-center">
            <div>
              <p class="font-medium">Basic Graphic Design</p>
              <p class="text-sm text-gray-500">Applier: EmpowrAffiliate</p>
            </div>
            <button class="bg-blue-100 text-blue-700 px-3 py-1 text-sm rounded">Details</button>
          </li>
          <li class="flex justify-between items-center">
            <div>
              <p class="font-medium">Buat Poster</p>
              <p class="text-sm text-gray-500">Applier: Worker3</p>
            </div>
            <button class="bg-blue-100 text-blue-700 px-3 py-1 text-sm rounded">Details</button>
          </li>
        </ul>
        <div class="mt-4 text-right text-sm text-gray-500">1 to 4 of 4 items</div>
      </div>


    </div>
  </div>
</div>

@include('client.footer')

<script>
    
   const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
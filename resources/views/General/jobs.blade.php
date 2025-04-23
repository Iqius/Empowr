@include('General.header')
<!-- Job List -->
<section class="p-4 md:p-8 mt-16">
    <div class="flex flex-col md:flex-row gap-4 mb-6">
        <input type="text" placeholder="Search Job" class="p-2 border rounded w-full md:w-1/3" id="searchInput">
        <select class="p-2 border rounded w-full md:w-auto" id="sortSelect">
            <option disabled selected>Sort</option>
            <option value="price-asc">Lowest Price</option>
            <option value="price-desc">Highest Price</option>
        </select>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2  lg:grid-cols-3 xl:grid-cols-4 gap-4 w-full" id="jobContainer">
        <!-- Job Card -->
        @php
            $task = \App\Models\Task::all();
        @endphp

        @foreach ($task as $job)
            @if($job->status == 'open') <!-- Cek apakah statusnya 'open' -->
                <div class="bg-white p-4 rounded shadow-md hover:shadow-lg transition duration-200" data-status="{{ $job->status }}">
                    <a href="{{ route('jobs.show', $job->id) }}">
                        <p class="text-blue-600 font-semibold text-base sm:text-lg">{{ $job->title }}</p>
                        <p class="text-black font-bold mt-2 text-sm sm:text-base">
                            Rp {{ number_format($job->price, 0, ',', '.') }}
                        </p>
                        <p class="text-gray-500 text-sm">By {{ $job->user->nama_lengkap ?? 'Unknown' }}</p>
                        <p class="text-xs text-gray-400 mt-1">Status: {{ $job->status }}</p>
                    </a>
                </div>
            @endif
        @endforeach

    </div>
</section>


<!-- Floating Button -->
@auth
    @if (Auth::user()->role === 'client')
        <button id="openModalBtn"
            class="fixed bottom-6 right-6 bg-blue-600 text-white w-12 h-12 flex items-center justify-center rounded-full shadow-lg hover:bg-blue-700 transition duration-300">
            +
        </button>
    @endif
@endauth



<!-- Modal -->
<div id="jobModal" class="fixed inset-0 z-50 flex justify-center items-start overflow-y-auto py-10 bg-gray-800 bg-opacity-50 hidden transition-opacity duration-300 opacity-0">
  <div class="bg-white p-6 rounded shadow-md w-full max-w-lg mx-4">
    <h1 class="text-2xl font-semibold mb-4">Add New Job</h1>
    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="grid grid-cols-3 gap-4">
        <!-- Title -->
        <div class="col-span-2">
          <label class="block text-gray-700">Title</label>
          <input type="text" name="title" class="w-full p-2 border rounded" required>
        </div>

        <!-- Price -->
        <div class="col-span-1">
          <label class="block text-gray-700">Price (Rp)</label>
          <input type="number" name="price" class="w-full p-2 border rounded" required>
        </div>

        <!-- Description -->
        <div class="col-span-3">
          <label class="block text-gray-700">Description</label>
          <textarea name="description" class="w-full p-2 border rounded" required></textarea>
        </div>

        <!-- Revisions -->
        <div class="col-span-1">
          <label class="block text-gray-700">Revisions</label>
          <input type="number" name="revisions" class="w-full p-2 border rounded" required>
        </div>

        <!-- Deadline -->
        <div class="col-span-1">
          <label class="block text-gray-700">Deadline</label>
          <input type="date" name="deadline" class="w-full p-2 border rounded" required>
        </div>

        <!-- Deadline Promotion -->
        <div class="col-span-1">
          <label class="block text-gray-700">Deadline Promotion</label>
          <input type="date" name="deadline_promotion" class="w-full p-2 border rounded" required>
        </div>

        <!-- Task Type -->
        <div class="col-span-1">
          <label class="block text-gray-700">Task Type</label>
          <select name="taskType" class="w-full p-2 border rounded" required>
            <option value="it">IT</option>
            <option value="nonIT">Non-IT</option>
          </select>
        </div>

        <!-- Provisions -->
        <div class="col-span-3">
          <label class="block text-gray-700">Provisions</label>
          <textarea name="provisions" class="w-full p-2 border rounded"></textarea>
        </div>

        <!-- File Upload -->
        <div class="col-span-3">
          <label class="block text-gray-700">Upload File</label>
          <div id="drop-area-job" class="border-2 border-dashed p-4 text-center cursor-pointer">
            <p id="drop-text-job">Drag & Drop file here or click to select</p>
            <input type="file" name="job_file" id="fileInputJob" class="hidden">
            <p id="file-name-job" class="text-gray-500 text-sm mt-2"></p>
          </div>
        </div>
      </div>

      <div class="flex justify-end gap-2 mt-4">
        <button type="button" id="closeModalBtn" class="bg-gray-400 text-white p-2 rounded">Cancel</button>
        <button type="submit" class="bg-blue-600 text-white p-2 rounded">Post</button>
      </div>
    </form>
  </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const openModalBtn = document.getElementById("openModalBtn");
        const closeModalBtn = document.getElementById("closeModalBtn");
        const jobModal = document.getElementById("jobModal");
        const dropAreaJob = document.getElementById("drop-area-job");
        const fileInputJob = document.getElementById("fileInputJob");
        const fileNameDisplayJob = document.getElementById("file-name-job");
        const sortSelect = document.getElementById("sortSelect");
        const jobContainer = document.getElementById("jobContainer");

        // 🟦 Modal Open/Close
        openModalBtn?.addEventListener("click", () => {
        jobModal?.classList.remove("hidden");

            // ⏫ Tambahkan animasi buka
        setTimeout(() => {
              jobModal?.classList.replace("opacity-0", "opacity-100");
              jobModal?.classList.replace("scale-95", "scale-100");
          }, 10);
        });

        closeModalBtn?.addEventListener("click", () => {
          // ⏬ Tambahkan animasi tutup
          jobModal?.classList.replace("opacity-100", "opacity-0");
          jobModal?.classList.replace("scale-100", "scale-95");

          setTimeout(() => {
              jobModal?.classList.add("hidden");
          }, 300);
        });

        jobModal?.addEventListener("click", (e) => {
            if (e.target === jobModal) {
                // ⏬ Tutup saat klik luar modal + animasi
                jobModal?.classList.replace("opacity-100", "opacity-0");
                jobModal?.classList.replace("scale-100", "scale-95");

                setTimeout(() => {
                    jobModal.classList.add("hidden");
                }, 300);
            }
        });

        // 🟩 Drag & Drop File Upload
        dropAreaJob?.addEventListener("click", () => {
            fileInputJob.click();
        });

        fileInputJob?.addEventListener("change", () => {
            if (fileInputJob.files.length > 0) {
                fileNameDisplayJob.textContent = fileInputJob.files[0].name;
            }
        });

        dropAreaJob?.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropAreaJob.classList.add("bg-gray-100");
        });

        dropAreaJob?.addEventListener("dragleave", () => {
            dropAreaJob.classList.remove("bg-gray-100");
        });

        dropAreaJob?.addEventListener("drop", (e) => {
            e.preventDefault();
            dropAreaJob.classList.remove("bg-gray-100");

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInputJob.files = files;
                fileNameDisplayJob.textContent = files[0].name;
            }
        });

    // 🟨 Sort Jobs by Price
    sortSelect?.addEventListener("change", function() {
        const value = this.value;
        if (!jobContainer) return;

        const cards = Array.from(jobContainer.children);
        const sorted = cards.sort((a, b) => {
            const priceA = parseInt(a.dataset.price || "0");
            const priceB = parseInt(b.dataset.price || "0");
            return value === "price-asc" ? priceA - priceB : priceB - priceA;
        });

        jobContainer.innerHTML = "";
        sorted.forEach(card => jobContainer.appendChild(card));
    });

    // ✅ SweetAlert for Success Message
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Diposting!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#2563EB',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = window.location.href;
        });
    @endif
    });
</script>


@include('General.footer')

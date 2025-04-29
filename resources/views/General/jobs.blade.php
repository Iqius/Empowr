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
                <div class="bg-white p-4 rounded-xl shadow-sm border hover:shadow-md transition relative"
                    data-price="{{ $job->price }}">
                    <!-- Save Button -->
                    <button class="absolute top-3 right-3 text-gray-400 hover:text-[#1F4482] transition">
                        <i class="fa-regular fa-bookmark text-lg"></i>
                    </button>

                    <!-- User Info -->
                    <div class="flex items-center gap-3 mb-3">
                        <img src="{{ asset('assets/images/avatar.png') }}" alt="User"
                            class="w-9 h-9 rounded-full object-cover" />
                        <p class="text-sm font-semibold text-gray-800 flex items-center gap-1">
                            {{ $job->user->nama_lengkap ?? 'Unknown' }}
                            <span class="text-[#1F4482]">✔</span>
                        </p>
                    </div>

                    <!-- Job Title -->
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">
                        {{ $job->title }}
                    </h3>

                    <!-- Description -->
                    <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                        {{ Str::limit($job->description, 80, '...') }}
                    </p>

                    <!-- Bottom Row: Price + Button -->
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($job->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">Tanggal</p>
                        </div>
                        <a href="{{ route('jobs.show', $job->id) }}">
                            <button
                                class="bg-[#1F4482] text-white text-sm px-4 py-1.5 rounded-md hover:bg-[#18346a] transition">
                                View
                            </button>
                        </a>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
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
        sortSelect?.addEventListener("change", function () {
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


    @if (session('success-updated'))
        Swal.fire({
            icon: 'success',
            title: 'Pekerjaan kamu telah terselesaikan',
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
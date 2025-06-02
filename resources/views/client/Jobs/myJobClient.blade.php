@include('General.header')

<section class="p-4 sm:p-6 md:p-8 mt-16">
    <a href="{{ route('add-job-view') }}"
        class="inline-block bg-[#183E74] hover:bg-[#1a4a91] text-white text-sm sm:text-base px-8 py-2 rounded-md shadow mb-6">
        Tambah Tugas
    </a>
    <div class="flex flex-col md:flex-row gap-4 mb-6">
        <!-- Search Input -->
        <input type="text" placeholder="Cari Job" class="p-2 border rounded w-full md:w-1/3" id="searchInput">

        <!-- Status Dropdown -->
        <select class="p-2 border rounded w-full md:w-auto" id="statusFilter">
            <option value="">Semua Status</option>
            <option value="open">Belum Dikerjakan</option>
            <option value="in progress">Sedang Dikerjakan</option>
            <!-- <option value="completed">Selesai Dikerjakann</option> -->
        </select>

    </div>
    <!-- Job List -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 w-full" id="jobContainer">
        @php
            $task = \App\Models\Task::with('user')->where('client_id', Auth::id())->get();
        @endphp

        @foreach ($task as $job)
            <div class="bg-white p-4 rounded-xl shadow-sm border hover:shadow-md transition relative"
                data-status="{{ $job->status }}" data-price="{{ $job->price }}">
                <!-- User Info -->
                <div class="flex items-center gap-3 mb-3">
                    <img src="{{ $job->user->profile_image ? asset('storage/' . $job->user->profile_image) : asset('assets/images/avatar.png') }}"
                        alt="User" class="w-9 h-9 rounded-full object-cover" />
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
                <div class="text-xs text-gray-500 mb-4 leading-relaxed">
                    @php
                        // Check if the description contains ordered or unordered lists
                        $hasLists = preg_match('/<ol[^>]*>|<ul[^>]*>/i', $job->description);

                        // Get the text before any list appears
                        $textBeforeLists = preg_split('/<ol[^>]*>|<ul[^>]*>/i', $job->description)[0];

                        // Strip any HTML tags from this text
                        $plainTextBeforeLists = strip_tags($textBeforeLists);

                        // Create the preview - if there are lists, add ellipsis
                        if ($hasLists) {
                            // Limit the text before the list and add ellipsis
                            $previewText = Str::limit($plainTextBeforeLists, 77, '...');
                        } else {
                            // If no lists, just use normal limit
                            $previewText = Str::limit(strip_tags($job->description), 150, '...');
                        }
                    @endphp
                    {{ $previewText }}
                </div>


                <!-- Bottom Row: Price + Button -->
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">
                            Rp {{ number_format($job->price, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-400 capitalize">
                            Status: <span class="text-gray-500 font-semibold">{{ $job->status }}</span>
                        </p>
                    </div>

                    @if ($job->status === 'in progress')
                        <a href="{{ route('inProgress.jobs', $job->id) }}">
                    @elseif ($job->status == 'completed')
                        <a href="{{ route('inProgress.jobs', $job->id) }}">
                    @else
                        <a href="{{ route('jobs.manage', $job->id) }}">
                    @endif
                        <button
                            class="bg-[#1F4482] text-white text-sm px-4 py-1.5 rounded-md hover:bg-[#18346a] transition">
                            Lihat Detail
                        </button>
                    </a>
                </div>
            </div> 
        @endforeach
    </div>
</section>

@include('General.footer')

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
    });
</script>



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
@include('client.header')
   <!-- Job List -->
<section class="p-4 md:p-8 lg:ml-64 mt-16">
    <div class="flex flex-col md:flex-row gap-4 mb-6">
        <input type="text" placeholder="Search Job" class="p-2 border rounded w-full md:w-1/3" id="searchInput">
        <select class="p-2 border rounded w-full md:w-auto" id="sortSelect">
    <option disabled selected>Sort</option>
    <option value="price-asc">Harga Termurah</option>
    <option value="price-desc">Harga Termahal</option>
</select>

        <button class="p-2 border rounded bg-blue-600 text-white w-full md:w-auto">Filter</button>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4" id="jobContainer">
        <!-- Job Card -->
        @php
            $jobs = \App\Models\Job::all();
        @endphp

        @foreach ($jobs as $job)
            <div class="bg-white p-4 rounded shadow-md hover:shadow-lg transition duration-200" data-price="{{ $job->price }}">
                <a href="{{ route('jobs.show', $job->id) }}">
                    <p class="text-blue-600 font-semibold">{{ $job->title }}</p>
                    <p class="text-black font-bold mt-2">Rp {{ number_format($job->price, 0, ',', '.') }}</p>
                    <p class="text-gray-500 text-sm">By {{ $job->user->name ?? 'Unknown' }}</p>
                </a>
            </div>
        @endforeach
    </div>
</section>


        <!-- Floating Button -->
        @auth
            @if(Auth::user()->role === 'client')
                <button id="openModalBtn" class="fixed bottom-6 right-6 bg-blue-600 text-white w-12 h-12 flex items-center justify-center rounded-full shadow-lg hover:bg-blue-700 transition duration-300">
                    +
                </button>
            @endif
        @endauth



    <!-- Modal -->
    <div id="jobModal" class="fixed inset-0 mt-10 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded shadow-md w-full max-w-lg">
        <h1 class="text-2xl font-semibold mb-4">Add New Job</h1>
        <form action="{{ route('jobs.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-3 gap-4">
                <!-- Title (Menggunakan 3 Kolom) -->
                <div class="col-span-2">
                    <label class="block text-gray-700">Title</label>
                    <input type="text" name="title" class="w-full p-2 border rounded" required>
                </div>

                <!-- Price -->
                <div class="col-span-1">
                    <label class="block text-gray-700">Price (Rp)</label>
                    <input type="number" name="price" class="w-full p-2 border rounded" required>
                </div>

                <!-- Description (Menggunakan 3 Kolom) -->
                <div class="col-span-3">
                    <label class="block text-gray-700">Description</label>
                    <textarea name="description" class="w-full p-2 border rounded"></textarea>
                </div>

                <!-- Revisions -->
                <div class="col-span-1">
                    <label class="block text-gray-700">Revisions</label>
                    <input type="number" name="Revisions" class="w-full p-2 border rounded" required>
                </div>


                <!-- End Date -->
                <div class="col-span-1">
                    <label class="block text-gray-700">End Date</label>
                    <input type="date" name="end_date" class="w-full p-2 border rounded" required>
                </div>

                <!-- Type -->
                <div class="col-span-1">
                    <label class="block text-gray-700">Type</label>
                    <select name="type" class="w-full p-2 border rounded" required>
                        <option value="it">IT</option>
                        <option value="non-it">Non IT</option>
                    </select>
                </div>

                <!-- Provisions -->
                <div class="col-span-3">
                    <label class="block text-gray-700">Provisions</label>
                    <textarea name="Provisions" class="w-full p-2 border rounded"></textarea>
                </div>


                <!-- Drag & Drop File Upload -->
                <div class="col-span-3">
                    <label class="block text-gray-700">Upload File</label>
                    <div id="drop-area" class="border-2 border-dashed p-4 text-center cursor-pointer">
                        <p id="drop-text">Drag & Drop file here or click to select</p>
                        <input type="file" name="job_file" id="fileInput" class="hidden">
                        <p id="file-name" class="text-gray-500 text-sm mt-2"></p>
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
    document.addEventListener("DOMContentLoaded", function () {
        const openModalBtn = document.getElementById("openModalBtn");
        const closeModalBtn = document.getElementById("closeModalBtn");
        const jobModal = document.getElementById("jobModal");
        const dropZone = document.getElementById("dropZone");
        const fileInput = document.getElementById("fileInput");

        // Buka modal
        openModalBtn?.addEventListener("click", function () {
            jobModal?.classList.remove("hidden");
        });

        // Tutup modal
        closeModalBtn?.addEventListener("click", function () {
            jobModal?.classList.add("hidden");
        });

        // Tutup modal jika klik di luar kontennya
        jobModal?.addEventListener("click", function (event) {
            if (event.target === jobModal) {
                jobModal.classList.add("hidden");
            }
        });

        // Drag & Drop Upload File
        dropZone?.addEventListener("dragover", function (event) {
            event.preventDefault();
            dropZone.classList.add("border-blue-500");
        });

        dropZone?.addEventListener("dragleave", function () {
            dropZone.classList.remove("border-blue-500");
        });

        dropZone?.addEventListener("drop", function (event) {
            event.preventDefault();
            dropZone.classList.remove("border-blue-500");

            const files = event.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                dropZone.innerHTML = `<p class="text-green-600">${files[0].name}</p>`;
            }
        });

        dropZone?.addEventListener("click", function () {
            fileInput.click();
        });

        fileInput?.addEventListener("change", function () {
            if (fileInput.files.length > 0) {
                dropZone.innerHTML = `<p class="text-green-600">${fileInput.files[0].name}</p>`;
            }
        });

        // ✅ SweetAlert2 untuk session sukses (jika ada)
        @if(session('success'))
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
    document.getElementById("sortSelect")?.addEventListener("change", function () {
    const value = this.value;
    const container = document.getElementById("jobContainer");
    const cards = Array.from(container.children);

    if (value === "price-asc" || value === "price-desc") {
        const sorted = cards.sort((a, b) => {
            const priceA = parseInt(a.dataset.price);
            const priceB = parseInt(b.dataset.price);
            return value === "price-asc" ? priceA - priceB : priceB - priceA;
        });

        // Re-render hasil urut
        container.innerHTML = "";
        sorted.forEach(card => container.appendChild(card));
    }
});

</script>

@include('client.footer')

@include('General.header')

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2500,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        });
    </script>
@endif

<div class="p-4 mt-14">
    <div class="p-4 rounded h-full">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Section -->
            <div class="lg:col-span-2 flex flex-col h-full">
                <div class="bg-white p-6 rounded-xl shadow-sm border flex flex-col h-full space-y-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">{{ $job->title }}</h1>
                        </div>

                        <div class="flex items-center gap-3 flex-wrap">
                            @auth
                                @if (Auth::user()->role === 'worker')
                                    <form id="applyForm" action="{{ route('task.apply', $job->id) }}" method="POST"
                                        class="flex items-center gap-2">
                                        @csrf

                                        @if($hasApplied)
                                            <button type="button"
                                                class="bg-gray-400 cursor-not-allowed text-white text-sm px-8 py-2 rounded-md"
                                                disabled>
                                                Task telah dilamar!
                                            </button>
                                        @else
                                            <button type="button" id="openApplyModalBtn"
                                                class="bg-[#1F4482] text-white text-sm px-8 py-2 rounded-md hover:bg-[#18346a] focus:outline-none">
                                                Apply Now
                                            </button>
                                        @endif

                                        <input type="hidden" name="bidPrice" id="formBidPrice">
                                        <input type="hidden" name="catatan" id="formCatatan">
                                    </form>
                                @endif
                            @endauth


                            <button
                                class="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300 transition">
                                <i class="fa-regular fa-bookmark text-[#1F4482] text-lg"></i>
                            </button>

                            <button
                                class="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300 transition">
                                <i class="fa-solid fa-share-nodes text-[#1F4482] text-lg"></i>
                            </button>
                        </div>
                    </div>

                    <!-- User Info and Budget Info -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-4">
                            <img src="{{ $job->user->profile_image ? asset('storage/' . $job->user->profile_image) : asset('assets/images/avatar.png') }}"
                                alt="User" class="w-16 h-16 sm:w-24 sm:h-24 rounded-full object-cover">

                            <div>
                                <p class="font-semibold text-gray-800 flex items-center gap-1 mb-2">
                                    {{ $job->user->nama_lengkap }}
                                    <span class="text-[#1F4482]">&#10004;</span>
                                </p>
                                <p class="text-xs flex items-center gap-1">
                                    <i class="fa-solid fa-pen text-gray-500"></i>
                                    <span class="text-gray-500">Task diposting</span>
                                    <span class="text-gray-600 font-semibold">
                                        {{ \Carbon\Carbon::parse($job->created_at)->translatedFormat('d F Y') }}
                                    </span>
                                </p>
                            </div>

                        </div>

                        <div class="text-left mr-6">
                            <p class="text-sm font-medium text-gray-500">Budget</p>
                            <p class="text-lg font-semibold text-gray-800">IDR
                                {{ number_format($job->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <!-- About Task -->
                    <div class="space-y-6 flex-1">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">Tentang Task</h2>
                            <div class="job-description text-sm text-gray-800 leading-relaxed">
                                {!! $job->description !!}
                            </div>
                        </div>

                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">Kualifikasi</h2>
                            <div class="job-qualification text-sm text-gray-800 leading-relaxed">
                                {!! $job->qualification !!}
                            </div>
                        </div>

                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">Aturan Task</h2>
                            <div class="rules text-sm text-gray-800 leading-relaxed">
                                {!! $job->provisions !!}
                            </div>
                        </div>

                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">Attachment Files</h2>
                            @if ($job->job_file)
                                <a href="{{ asset('storage/' . $job->job_file) }}" download
                                    class="inline-block mt-2 px-4 py-2 bg-[#1F4482] text-white text-sm rounded-md hover:bg-[#18346a]">
                                    Download File
                                </a>
                            @else
                                <p class="text-sm text-gray-500">No attachment available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div>
                <div class="bg-white p-6 rounded-xl shadow-sm border space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800">Task Detail</h2>

                    <div>
                        <p class="text-gray-500">Masa Pengerjaan Task (Deadline)</p>
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($job->start_date)->translatedFormat('d F Y') }} -
                            {{ \Carbon\Carbon::parse($job->deadline)->translatedFormat('d F Y') }}
                        </p>
                        <p class="font-semibold">
                            ({{ \Carbon\Carbon::parse($job->start_date)->diffInDays($job->deadline) }} Hari)
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Penutupan Lamaran</p>
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($job->deadline_promotion)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Permintaan Jatah Revisi</p>
                        <p class="font-semibold capitalize">{{ $job->revisions }} kali revisi</p>
                    </div>

                    <div>
                        <p class="text-gray-500 mb-2">Kategori Task</p>
                        <div>
                            @php
                                $categories = json_decode($job->kategory, true) ?? [];
                            @endphp
                            @foreach($categories as $category)
                                <span
                                    class="inline-block bg-gradient-to-b from-[#1F4482] to-[#2A5DB2] text-white px-3 py-1 rounded-full text-sm mr-2 mb-2">
                                    {{ $category }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Applicants List -->
        <div class="bg-white p-6 my-6 rounded-xl shadow-sm border">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Daftar Pelamar</h2>

            <div id="applicants-list" class="space-y-4">
                @forelse ($applicants as $applicant)
                    @php
                        $worker = $applicant->worker;
                        $user = $worker->user;
                        $avgRating = 0; // default
                    @endphp

                    <a href="{{ route('profile.worker.lamar', $worker->id) }}"
                        class="block p-4 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition hover:bg-gray-100"
                        data-index="{{ $loop->index }}" data-name="{{ $user->nama_lengkap }}"
                        data-note="{{ $applicant->catatan }}" data-price="{{ $applicant->bidPrice }}"
                        data-experience="{{ $worker->pengalaman_kerja }}" data-rating="{{ number_format($avgRating, 1) }}"
                        data-education="{{ $worker->pendidikan }}" data-cv="{{ $worker->cv }}"
                        data-label="{{ $worker->empowr_label }}" data-affiliate="{{ $worker->empowr_affiliate }}">

                        <div class="flex items-center justify-between gap-4 mb-4">
                            <!-- Left: Profile Section -->
                            <div class="flex items-center gap-4">
                                <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('assets/images/avatar.png') }}"
                                    alt="Profile Image" class="w-16 h-16 rounded-full object-cover border border-gray-300">
                                <div>
                                    <p class="text-lg font-semibold text-gray-800">{{ $user->nama_lengkap }}</p>
                                    <p class="text-sm text-gray-500">
                                        Pengalaman: {{ $worker->pengalaman_kerja ?? '-' }} tahun |
                                        Rating: {{ number_format($avgRating, 1) }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </a>

                @empty
                    <p class="text-gray-500 text-sm">Belum ada pelamar untuk task ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div id="applyModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Ajukan Pendaftaran</h2>

        <label for="negoHargaModal" class="block text-sm font-semibold text-gray-700 mb-1">Nego Harga (IDR)</label>
        <input type="text" id="negoHargaModal" placeholder="Masukkan harga tawaran"
            class="w-full p-2 border rounded-lg mb-4" value="{{ number_format($job->price, 0, ',', '.') }}" />

        <label for="noteInputModal" class="block text-sm font-semibold text-gray-700 mb-1">Catatan (opsional)</label>
        <textarea id="noteInputModal" rows="4" placeholder="Tulis catatan tambahan di sini..."
            class="w-full p-2 border rounded-lg mb-4"></textarea>

        <div class="flex justify-end">
            <button id="submitApplyModal"
                class="py-2 px-4 bg-[#1F4482] text-white rounded-lg hover:bg-[#18346a] focus:outline-none focus:ring-2 focus:ring-blue-300">Daftar</button>
            <button id="closeApplyModal"
                class="ml-2 py-2 px-4 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-300">Batal</button>
        </div>
    </div>
</div>




<!-- buat quilbot -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("Quill Editor Initialized");

        // 🔹 Konfigurasi toolbar Quill
        const toolbarOptions = [
            [{ 'header': [1, 2, false] }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            ['bold', 'italic', 'underline'],
            ['link', 'image'],
            ['clean']
        ];

        // 🔹 Inisialisasi Quill Editor di halaman ini
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: { toolbar: toolbarOptions }
        });

        // Jika ingin memuat data yang sudah ada (misalnya dari database)
        const contentFromDB = "{!! $dataFromDB ?? '' !!}"; // Misalnya isi dari database
        quill.root.innerHTML = contentFromDB; // Menyisipkan HTML dari database
    });
</script>


@include('General.footer')


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const openBtn = document.getElementById("openApplyModalBtn");
        const modal = document.getElementById("applyModal");
        const closeBtn = document.getElementById("closeApplyModal");
        const submitBtn = document.getElementById("submitApplyModal");
        const form = document.getElementById("applyForm");
        const negoInput = document.getElementById("negoHargaModal");
        const noteInput = document.getElementById("noteInputModal");
        const hiddenBidPrice = document.getElementById("formBidPrice");
        const hiddenNote = document.getElementById("formCatatan");

        // Fungsi buka modal
        function openModal() {
            modal.classList.remove("hidden");
        }

        // Fungsi tutup modal dan reset input
        function closeModal() {
            modal.classList.add("hidden");
            // Optional reset inputs
            // negoInput.value = "{{ number_format($job->price, 0, ',', '.') }}";
            // noteInput.value = "";
        }

        // Format input harga dengan pemisah ribuan saat ketik
        negoInput.addEventListener("input", function (e) {
            let value = e.target.value.replace(/[^0-9]/g, "");
            if (value) {
                e.target.value = Number(value).toLocaleString("id-ID");
            } else {
                e.target.value = "";
            }
        });

        // Buka modal saat klik tombol
        openBtn.addEventListener("click", openModal);

        // Tutup modal saat klik tombol batal
        closeBtn.addEventListener("click", closeModal);

        // Submit form saat klik tombol daftar
        submitBtn.addEventListener("click", function () {
            const rawNego = negoInput.value.replace(/[.,]/g, "");
            if (!rawNego || isNaN(rawNego) || Number(rawNego) <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Input',
                    text: 'Harga tawaran harus berupa angka lebih dari 0',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            hiddenBidPrice.value = rawNego;
            hiddenNote.value = noteInput.value.trim();

            form.submit();
        });

        // Opsional: tutup modal dengan ESC key
        window.addEventListener("keydown", function (e) {
            if (e.key === "Escape" && !modal.classList.contains("hidden")) {
                closeModal();
            }
        });
    });
</script>
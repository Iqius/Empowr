@include('General.header')



<div class="p-4 mt-14">
    <div class="p-4 rounded h-full">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Section -->
            <div class="lg:col-span-2 flex flex-col h-full">
                <div class="bg-white p-6 rounded-xl shadow-sm border flex flex-col h-full space-y-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">{{ $job->title }}</h1>
                        </div>

                        <div class="flex items-center gap-3 flex-wrap">
                            @auth
                                @if (Auth::user()->role === 'worker')
                                    <form id="applyForm" action="{{ route('task.apply', $job->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <button type="button" id="applyBtn"
                                            class="bg-[#1F4482] text-white text-sm px-8 py-2 rounded-md hover:bg-[#18346a] focus:outline-none">
                                            Apply Now
                                        </button>
                                        <input type="hidden" name="bidPrice" id="formBidPrice">
                                        <input type="hidden" name="catatan" id="formCatatan">
                                    </form>
                                @endif
                            @endauth

                            <button class="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300 transition">
                                <i class="fa-regular fa-bookmark text-gray-600 text-lg"></i>
                            </button>

                            <button class="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300 transition">
                                <i class="fa-solid fa-share-nodes text-gray-600 text-lg"></i>
                            </button>
                        </div>
                    </div>

                    <!-- User Info and Budget Info -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-4">
                            <img src="{{ $job->user->profile_image ? asset('storage/' . $job->user->profile_image) : asset('assets/images/avatar.png') }}"
                                alt="User" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover">

                            <div>
                                <p class="font-semibold text-gray-800 flex items-center gap-1">
                                    {{ $job->user->nama_lengkap }}
                                    <span class="text-[#1F4482]">&#10004;</span>
                                </p>
                                <p class="text-xs text-gray-400 flex items-center gap-1">
                                    <i class="fa-solid fa-pen text-gray-400"></i>
                                    Task Posted {{ \Carbon\Carbon::parse($job->created_at)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>

                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-500">Budget</p>
                            <p class="text-lg font-semibold text-gray-800">IDR {{ number_format($job->price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- About Task -->
                    <div class="space-y-6 flex-1">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">About Task</h2>
                            <div class="job-description text-sm text-gray-600 leading-relaxed">
                                {!! $job->description ?? '-' !!}
                            </div>
                        </div>

                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">Qualification</h2>
                            <div class="job-qualification text-sm text-gray-600 leading-relaxed">
                                {!! $job->qualification ?? '-' !!}
                            </div>
                        </div>

                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">Rules Task</h2>
                            <div class="rules text-sm text-gray-600 leading-relaxed">
                                {!! $job->provisions ?? '-' !!}
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
            <div class="flex flex-col h-full">
                <div class="bg-white p-6 rounded-xl shadow-sm border flex flex-col h-full space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800">Task Details</h2>

                    <div>
                        <p class="text-gray-400">Task Period (Deadline)</p>
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($job->start_date)->translatedFormat('d F Y') }} -
                            {{ \Carbon\Carbon::parse($job->deadline)->translatedFormat('d F Y') }}
                        </p>
                        <p class="font-semibold">
                            ({{ \Carbon\Carbon::parse($job->start_date)->diffInDays($job->deadline) }} Days)
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400">Task Closed</p>
                        <p class="font-semibold">
                            {{ \Carbon\Carbon::parse($job->deadline_promotion)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400">Task Type</p>
                        <p class="font-semibold capitalize">{{ str_replace('_', ' ', $job->taskType) }}</p>
                    </div>

                    <div>
                        <p class="text-gray-400">Category</p>
                        <p class="font-semibold">{{ $job->category ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-400">Location</p>
                        <p class="font-semibold">{{ $job->location ?? '-' }}</p>
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
                    data-index="{{ $loop->index }}"
                    data-name="{{ $user->nama_lengkap }}"
                    data-note="{{ $applicant->catatan }}"
                    data-price="{{ $applicant->bidPrice }}"
                    data-experience="{{ $worker->pengalaman_kerja }}"
                    data-rating="{{ number_format($avgRating, 1) }}"
                    data-education="{{ $worker->pendidikan }}"
                    data-cv="{{ $worker->cv }}"
                    data-label="{{ $worker->empowr_label }}"
                    data-affiliate="{{ $worker->empowr_affiliate }}">

                        <div class="flex items-center justify-between gap-4 mb-4">
                            <!-- Left: Profile Section -->
                            <div class="flex items-center gap-4">
                                <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('assets/images/avatar.png') }}"
                                    alt="Profile Image"
                                    class="w-16 h-16 rounded-full object-cover border border-gray-300">
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
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("applyForm");

        document.getElementById("applyBtn")?.addEventListener("click", function() {
            Swal.fire({
                title: 'Ajukan Pendaftaran',
                html: `
                    <div class="text-left space-y-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Nego Harga</label>
                            <input id="negoHarga" type="number" class="swal2-input" value="{{ $job->price }}" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Catatan (opsional)</label>
                            <textarea id="noteField" class="swal2-textarea" placeholder="Tulis catatan tambahan di sini..."></textarea>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Daftar',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#2563EB',
                preConfirm: () => {
                    return {
                        nego: document.getElementById('negoHarga').value,
                        note: document.getElementById('noteField').value
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Masukkan ke input hidden
                    document.getElementById("formBidPrice").value = result.value.nego;
                    document.getElementById("formCatatan").value = result.value.note;

                    Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Lamaran berhasil dikirim.',
                    showConfirmButton: false,
                    timer: 1500
                });


                    // Delay submit sedikit agar notifikasi bisa muncul
                    setTimeout(() => {
                        form.submit();
                    }, 800); // 800ms biar notif terlihat
                }

            });
        });
    });
</script>



@include('General.header')


<div class="p-4 mt-14">
    <div class="p-4 rounded h-full">
        <div class="grid grid-cols-1 md:grid-cols-[3fr_2fr]  min-h-screen">
            <div class="p-4 rounded h-full">
                <div class="p-6 bg-white rounded-lg shadow-md h-full">
                    <div class="flex flex-col md:flex-row md:gap-4">
                        <!-- Kiri -->
                        <div class="basis-1/6 md:basis-1/6 p-4 flex flex-col items-center justify-center md:justify-end">
                                @php
                                    $user = $job->client;
                                @endphp 
                                @php
                                    $isClient = Auth::user()->role === 'client';
                                    $imagePath = $isClient
                                        ? (Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('assets/images/avatar.png'))
                                        : (isset($user) && $user->profile_image ? asset('storage/' . $user->profile_image) : asset('assets/images/avatar.png'));
                                @endphp

                                <img id="profile-image" src="{{ $imagePath }}" alt="Profile Picture"
                                    class="w-20 h-20 sm:w-23 sm:h-23 rounded object-cover border border-gray-300">
                        </div>



                        <!-- Tengah -->
                        <div class="basis-4/6 md:basis-4/6 p-4">
                            <h1 class="text-2xl font-bold text-dark">{{ $job->title }}</h1>
                            <div class="text-gray-700 flex flex-col md:flex-row  mt-1" style="font-size:10px">
                                <span>Revisi: <span class="font-semibold text-gray-600">{{ $job->revisions ?? '[Belum ditentukan]' }}</span><br>Deadline: <span class="font-semibold text-gray-600">{{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->translatedFormat('d F Y') : '[Belum ditentukan]' }}</span></span>
                            </div>
                            @php
                                $typeLabels = [
                                    'it' => 'IT',
                                    'nonIT' => 'Non IT',
                                ];
                            @endphp

                            <!-- Type -->
                            <div>
                                <h2 class="text-gray-700" style="font-size:10px">
                                    Tipe:
                                    @if(isset($typeLabels[$job->taskType]))
                                        <span class="inline-block bg-blue-100 text-blue-800 font-semibold px-2.5 py-0.5 rounded-full ml-1" style="font-size:10px">
                                            {{ $typeLabels[$job->taskType] }}
                                        </span>
                                    @else
                                        <span class="text-gray-600 ml-1">[Belum ditentukan]</span>
                                    @endif
                                </h2>
                            </div>
                        </div>
                        <!-- Kanan -->
                        <div class="basis-1/6 md:basis-1/6 p-4 text-right my-auto mx-auto">
                            <div class="inline-block px-4 py-2 ">
                                <p class="text-gray-800 text-2xl">
                                    <span class="mr-1">Rp</span>{{ isset($job->price) ? number_format($job->price, 0, ',', '.') : '[Harga belum diisi]' }}
                                </p>
                            </div>
                        </div>


                    </div>
                    <h1 class="text-xl font-semibold text-gray-700 mt-6">Deskripsi</h1>
                    <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                    <p class="text-gray-600 mt-1">{{ $job->description ?? '[Belum ada deskripsi]' }}</p>
                    <h1 class="text-xl font-semibold text-gray-700 mt-10">Ketentuan</h1>
                    <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                    <p class="text-gray-600 mt-1">{{ $job->description ?? '[Belum ada deskripsi]' }}</p>
                    <h1 class="text-xl font-semibold text-gray-700 mt-10">File Terkait tugas</h1>
                    <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                    @if ($job->job_file)
                        {{-- Cek apakah file adalah gambar --}}
                        @php
                            $ext = pathinfo($job->job_file, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        @endphp
                        <p class="mt-2">
                        <a href="{{ asset('storage/' . $job->job_file) }}" download class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Download File
                        </a>

                        </p>
                    @else
                        <p class="text-gray-600 mt-1">[File belum diunggah]</p>
                    @endif
                </div>
            </div>
            <div class="p-4 rounded h-full">
                <div class="p-6 bg-white rounded-lg shadow-md h-full">
                    <div id="applicants-list" class="space-y-4">
                        <h1 class="text-xl font-semibold text-gray-700 ">Daftar pelamar</h1>
                        <hr class="border-t-1 border-gray-300 mb-7 mt-4">
                        @foreach ($applicants as $applicant)
                            @php
                                $worker = $applicant->worker;
                                $user = $worker->user;
                                $avgRating = 0; // default
                            @endphp
                            <div class="border p-4 rounded"
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
                                <div class="flex items-center gap-4">
                                    <!-- Gambar -->
                                    <label for="profile-pic" class="cursor-pointer">
                                        <img id="profile-image" src="{{asset('storage/' . $user->profile_image) }}" alt="" class="w-12 h-12 sm:w-12 sm:h-12 rounded object-cover border border-gray-300">
                                    </label>

                                    <!-- Teks -->
                                    <div>
                                        <p class="font-semibold text-lg">{{ $user->nama_lengkap }}</p>
                                        <p class="text-sm text-gray-500">
                                            Pengalaman: {{ $worker->pengalaman_kerja }} | Rating: {{ number_format($avgRating, 1) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="applyForm" action="{{ route('task.apply', $job->id) }}" method="POST">
    @csrf
    <input type="hidden" name="bidPrice" id="formBidPrice">
    <input type="hidden" name="catatan" id="formCatatan">
    @auth
        @if (Auth::user()->role === 'worker')
            <button type="button" id="applyBtn"
                class="fixed bottom-6 right-6 bg-blue-600 text-white px-6 py-3 rounded shadow-lg hover:bg-blue-700 transition">
                Daftar
            </button>
        @endif
    @endauth
</form>



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

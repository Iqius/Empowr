@include('General.header')

<section class="p-4 mt-16 ">
    <!-- Tabs button -->
    <div class="flex flex-wrap gap-4 border-b pb-2 text-sm sm:text-base overflow-x-auto">
        <button class="tab-button text-blue-600 font-semibold" data-tab="info">Informasi Lengkap</button>
        <button class="tab-button text-gray-600 hover:text-blue-600" data-tab="applicants">Lamaran Worker</button>
        <button class="tab-button text-gray-600 hover:text-blue-600" data-tab="chat">Chat</button>
    </div>

    <!-- Flash Message -->
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-4" role="alert">
            <strong class="font-bold">Gagal!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @php
        $job = $task;
    @endphp

    <!-- Tab 1: Informasi Lengkap -->
    <div id="info" class="tab-content space-y-4 mt-4">
        <h1 class="text-2xl font-bold text-blue-600">{{ $job->title ?? '[Judul belum diisi]' }}</h1>
        <p class="text-black font-bold text-xl">
            Rp {{ isset($job->price) ? number_format($job->price, 0, ',', '.') : '[Harga belum diisi]' }}
        </p>
        <p class="text-gray-500 text-sm">By {{ $job->user->nama_lengkap ?? 'Unknown' }}</p>
        <hr>

        @php
            $typeLabels = [
                'it' => 'IT',
                'nonIT' => 'Non IT',
            ];
        @endphp

        @foreach ([
            'Deskripsi' => 'description',
            'Jumlah Revisi' => 'revisions',
            'Tanggal Berakhir' => 'deadline',
            'Tipe Pekerjaan' => 'taskType',
            'Ketentuan' => 'provisions',
        ] as $label => $field)
            <div>
                <h2 class="text-lg font-semibold text-gray-700">{{ $label }}</h2>

                @if ($field === 'taskType')
                    <p class="text-gray-600 mt-1">{{ $typeLabels[$job->$field] ?? ucfirst($job->$field) }}</p>
                @else
                    <p class="text-gray-600 mt-1">{{ $job->$field ?? '[Belum ditentukan]' }}</p>
                @endif
            </div>
        @endforeach

        <div>
            <h2 class="text-lg font-semibold text-gray-700">File Terkait</h2>

            @if ($job->job_file)
                {{-- Cek apakah file adalah gambar --}}
                @php
                    $ext = pathinfo($job->job_file, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                @endphp

                @if ($isImage)
                    <img src="{{ asset('storage/' . $job->job_file) }}" alt="Preview File" class="w-64 h-auto rounded shadow mt-2">
                @endif

                <p class="mt-2">
                    <a href="{{ asset('storage/' . $job->job_file) }}" download class="text-blue-600 hover:underline">
                        Download File
                    </a>
                </p>
            @else
                <p class="text-gray-600 mt-1">[File belum diunggah]</p>
            @endif
        </div>
    </div>


    <!-- Tab 2: Lamaran Worker -->
    <div id="applicants" class="tab-content hidden mt-4">
        <h2 class="text-xl font-bold mb-4">Lamaran Worker</h2>


        <!-- Filter -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-2">
            <form method="GET" class="flex items-center gap-2">
                <label for="sortBy" class="font-semibold">Urutkan Berdasarkan:</label>
                <select name="sort" id="sortBy" class="p-2 border rounded" onchange="this.form.submit()">
                    <option value="bidPrice" {{ request('sort') === 'bidPrice' ? 'selected' : '' }}>Harga</option>
                    <option value="experience" {{ request('sort') === 'experience' ? 'selected' : '' }}>Pengalaman</option>
                </select>

                <select name="dir" class="p-2 border rounded" onchange="this.form.submit()">
                    <option value="asc" {{ request('dir') === 'asc' ? 'selected' : '' }}>Naik ↑</option>
                    <option value="desc" {{ request('dir') === 'desc' ? 'selected' : '' }}>Turun ↓</option>
                </select>
            </form>
        </div>

        <!-- List Pelamar -->
        <div id="applicants-list" class="space-y-4">
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
                    <p><strong>{{ $user->nama_lengkap }}</strong> - Rp{{ number_format($applicant->bidPrice) }}</p>
                    <p class="text-gray-600 text-sm">Catatan: {{ $applicant->catatan }}</p>
                    <p class="text-sm text-gray-500">
                        Pengalaman: {{ $worker->pengalaman_kerja }} tahun |
                        Rating: {{ number_format($avgRating, 1) }}
                    </p>
                    <div class="flex gap-2 mt-2">
                        <button class="bg-blue-500 text-white px-3 py-1 rounded">Chat</button>
                        <form action="{{ route('client.hire') }}" method="POST">
                            @csrf
                            <input type="hidden" name="task_id" value="{{ $applicant->task_id }}">
                            <input type="hidden" name="worker_profile_id" value="{{ $worker->id }}">
                            <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded">Terima</button>
                        </form>
                        <form action="{{ route('client.reject') }}" method="POST">
                            @csrf
                            <input type="hidden" name="application_id" value="{{ $applicant->id }}">
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">Tolak</button>
                        </form>
                        <a href="{{ route('profile.worker.lamar', $worker->id) }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow inline-block">
                            Lihat Profil Worker
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Tab 3: Chat -->
    <div id="chat" class="tab-content hidden mt-4">
        <h2 class="text-xl font-bold mb-4">Chat</h2>
        <iframe src="{{ route('chat') }}" class="w-full h-[500px] border rounded shadow"></iframe>
    </div>

    <!-- button delete task -->
    <div class="flex justify-end gap-2 mt-6">
        @if ($task->status === 'open')
            <form id="cancelTaskForm{{ $task->id }}" action="{{ route('jobs.destroy', $task->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" onclick="confirmCancel({{ $task->id }})" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Batalkan
                </button>
            </form>
        @else
            <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed" disabled>
                Tidak Bisa Dibatalkan Task Sudah Di Proses
            </button>
        @endif
        <button onclick="openModal()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            Bayar
        </button>
    </div>

    <!-- Modal bayar -->
    <div id="bayarModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden transition-opacity duration-300 opacity-0">
        <div id="modalContent" class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative transform transition-all duration-300 scale-95">
            <h2 class="text-lg font-semibold mb-4">Pilih Metode Pembayaran</h2>
            <!-- Error Alert -->
            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif
            <form id="bayarForm" action="{{route('client.bayar',$task->id)}}" method="POST">
                @csrf
                <!-- Input Jumlah -->
                <div class="mb-4">
                    <label for="id_order" class="block text-sm font-medium">Order ID</label>
                    <input type="" name="id_order" id="" class="w-full border rounded px-3 py-2 mt-1" value="{{ $task->id }}" readonly>
                </div>
                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium">Jumlah Harga</label>
                    <input type="number" name="amount" id="amount" class="w-full border rounded px-3 py-2 mt-1" placeholder="Contoh: 150000" required>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
                    Bayar Sekarang
                </button>
                <!-- Tombol Close -->
                <button onclick="closeModal()" class="py-2 px-4 mt-4 bg-red-600 rounded hover:bg-red-700 w-full text-white">
                    Tutup
                </button>
            </form>
        </div>
    
    </div>
    @if(session('error'))
    <div class="fixed top-4 right-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md z-50" id="globalAlert" role="alert">
        <div class="flex">
            <div class="py-1">
                <svg class="h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="font-bold">Error</p>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
            <button onclick="document.getElementById('globalAlert').style.display='none'" class="ml-auto">
                <svg class="h-4 w-4 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    @endif
    <!-- Snap -->
    <div id="snap-container"></div>
</section>

@include('General.footer')

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    @if(session('snap_token'))
        // Close modal if open
        if (document.getElementById('bayarModal')) {
            document.getElementById('bayarModal').classList.add('hidden');
            document.getElementById('bayarModal').classList.remove('opacity-100');
            document.getElementById('bayarModal').classList.add('opacity-0');
            document.getElementById('modalContent').classList.remove('scale-100');
            document.getElementById('modalContent').classList.add('scale-95');
        }
        
        // Open Snap payment page
        snap.pay('{{ session('snap_token') }}', {
            onSuccess: function(result) {
                alert('Pembayaran berhasil!');
                window.location.href = '{{ route('jobs.my') }}';
                // window.location.href = '{{route('invoice', $task->id)}}';
            },
            onPending: function(result) {
                alert('Pembayaran tertunda, silakan selesaikan pembayaran Anda');
                window.location.reload();
            },
            onError: function(result) {
                alert('Pembayaran gagal, silakan coba lagi');
                window.location.reload();
            },
            onClose: function() {
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    @endif
    function openModal() {
        const modal = document.getElementById('bayarModal');
        const content = document.getElementById('modalContent');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.replace('opacity-0', 'opacity-100');
            content.classList.replace('scale-95', 'scale-100');
        }, 10); 
    }

    function closeModal() {
        const modal = document.getElementById('bayarModal');
        const content = document.getElementById('modalContent');

        modal.classList.replace('opacity-100', 'opacity-0');
        content.classList.replace('scale-100', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); 
    }

    // Tampilkan opsi berdasarkan pilihan
    function togglePaymentOptions() {
        const selected = document.getElementById('payment_method').value;
        const bank = document.getElementById('bankOptions');
        const ewallet = document.getElementById('ewalletOptions');

        bank.classList.add('hidden');
        ewallet.classList.add('hidden');

        if (selected === 'bank') {
            bank.classList.remove('hidden');
        } else if (selected === 'ewallet') {
            ewallet.classList.remove('hidden');
        }
    }

    // Tutup modal saat klik area luar
    window.onclick = function (event) {
        const modal = document.getElementById('bayarModal');
        if (event.target === modal) {
            closeModal();
        }
    }


    if (document.getElementById('globalAlert')) {
        setTimeout(function() {
            document.getElementById('globalAlert').style.display = 'none';
        }, 5000);
    }
</script>



<script>
    function sortApplicants() {
        const sortBy = document.getElementById("sortBy").value;
        const container = document.getElementById("applicants-list");
        const items = Array.from(container.children);

        // Mapping nilai dropdown ke atribut data HTML
        const dataAttrMap = {
            'price': 'price',
            'experience': 'experience',
            'rating': 'rating',
        };

        if (sortBy === 'default') {
            items.sort((a, b) => parseInt(a.dataset.index) - parseInt(b.dataset.index));
        } else {
            const attr = dataAttrMap[sortBy];
            items.sort((a, b) => {
                const aVal = parseFloat(a.getAttribute(`data-${attr}`)) || 0;
                const bVal = parseFloat(b.getAttribute(`data-${attr}`)) || 0;
                return aVal - bVal;
            });
        }

        container.innerHTML = '';
        items.forEach(item => container.appendChild(item));
    }


function confirmCancel(taskId) {
    Swal.fire({
        title: 'Yakin ingin membatalkan?',
        text: "Tindakan ini tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Ya, batalkan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: 'Task berhasil dibatalkan!',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                document.getElementById(`cancelTaskForm${taskId}`).submit();
            });
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const sortSelect = document.getElementById("sortBy");
    if (sortSelect) {
        sortSelect.addEventListener("change", sortApplicants);
    }

    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', () => {
            console.log("Tab clicked:", button.dataset.tab);
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('text-blue-600', 'font-semibold'));
            button.classList.add('text-blue-600', 'font-semibold');
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
            document.getElementById(button.dataset.tab)?.classList.remove('hidden');
        });
    });

    document.querySelectorAll('.btn-worker-info').forEach(btn => {
        btn.addEventListener('click', () => {
            renderWorkerModal(workerData);
            showWorkerTab('keahlianTab');
            document.getElementById('workerDetailModal').classList.remove('hidden');
        });
    });
});
    function calculateAverageRating(reviews) {
    if (!reviews || reviews.length === 0) return 0;

    const total = reviews.reduce((sum, r) => sum + r.rating, 0);
    return total / reviews.length;
}

    function openWorkerModalFromElement(el) {
    const data = el.closest('div');
    
    const name = data.getAttribute('data-name');
    const note = data.getAttribute('data-note');
    const price = data.getAttribute('data-price');
    const experience = data.getAttribute('data-experience');
    const rating = data.getAttribute('data-rating');
    const education = data.getAttribute('data-education');
    const cv = data.getAttribute('data-cv');
    const label = data.getAttribute('data-label') === '1' ? 'Ya' : 'Tidak';
    const affiliate = data.getAttribute('data-affiliate') === '1' ? 'Ya' : 'Tidak';

    // Inject ke modal
    document.getElementById("worker-name").textContent = name;
    document.getElementById("worker-skills-value").textContent = "-"; // dari backend belum ada
    document.getElementById("worker-label").textContent = label;
    document.getElementById("worker-affiliate").textContent = affiliate;
    document.getElementById("worker-education").textContent = education;
    document.getElementById("worker-experience").textContent = `${experience} tahun`;
    document.getElementById("worker-cv").href = cv ?? "#";

    // Rating Summary
    document.getElementById("worker-rating-summary").innerHTML = `
        <h3 class="text-2xl font-semibold">${rating}</h3>
        <p class="text-yellow-500 text-xl">${"⭐".repeat(Math.floor(rating))}</p>
        <p class="text-sm text-gray-500">Dari rating user</p>
    `;

    // Show modal
    showWorkerTab('keahlianTab');
    document.getElementById('workerDetailModal').classList.remove('hidden');
}



    // Modal Worker
    function openWorkerModal(index) {
        const worker = applicants[index];
        document.getElementById("worker-name").textContent = worker.name;
        document.getElementById("worker-skills-value").textContent = worker.skills.join(", ");
        document.getElementById("worker-label").textContent = worker.empowrLabel ? "Ya" : "Tidak";
        document.getElementById("worker-affiliate").textContent = worker.empowrAffiliate ? "Ya" : "Tidak";
        document.getElementById("worker-education").textContent = worker.education;
        document.getElementById("worker-experience").textContent = `${worker.experience} tahun`;
        document.getElementById("worker-cv").href = worker.cv || "#";

        // Summary
        const avgRating = calculateAverageRating(worker.reviews);
        document.getElementById("worker-rating-summary").innerHTML = `
  <h3 class="text-2xl font-semibold">${avgRating.toFixed(1)}</h3>
  <p class="text-yellow-500 text-xl">${"⭐".repeat(Math.floor(avgRating))}${avgRating % 1 >= 0.5 ? "✩" : ""}</p>
  <p class="text-sm text-gray-500">Berdasarkan ${worker.reviews.length} rating</p>
`;


        // Distribusi
        const dist = calculateRatingDistribution(worker.reviews);
        const distEl = document.getElementById("worker-rating-distribution");
        distEl.innerHTML = "";
        for (let i = 5; i >= 1; i--) {
            const count = dist[i];
            const percent = (count / worker.reviews.length) * 100;
            distEl.innerHTML += `
    <div class="flex items-center space-x-2">
      <span class="w-6 text-sm">${i}★</span>
      <div class="w-full bg-gray-200 h-3 rounded">
        <div class="bg-yellow-400 h-3 rounded" style="width: ${percent}%;"></div>
      </div>
      <span class="w-10 text-sm text-gray-600 text-right">${count}</span>
    </div>
  `;
        }

        // Reviews
        const reviewEl = document.getElementById("worker-rating-reviews");
        reviewEl.innerHTML = "";
        worker.reviews.forEach(r => {
            reviewEl.innerHTML += `
    <div class="border rounded p-4">
      <div class="flex justify-between items-center mb-2">
        <span class="font-semibold">${r.name}</span>
        <span class="text-yellow-500">${"⭐".repeat(r.rating)}</span>
      </div>
      <p class="text-sm text-gray-700">“${r.comment}”</p>
    </div>
  `;
        });

        // Sertifikat Dropdown
        const certSelect = document.getElementById("certSelect");
        const certPreview = document.getElementById("certPreview");
        certSelect.innerHTML = `<option disabled selected>Lihat Sertifikasi</option>`;

        // Cek apakah worker punya sertifikat
        if (worker.certImages && worker.certImages.length > 0) {
            worker.certImages.forEach((cert, i) => {
                const option = document.createElement("option");
                option.value = i;
                option.textContent = cert.caption;
                certSelect.appendChild(option);
            });

            certSelect.onchange = () => {
                const selected = worker.certImages[certSelect.value];
                document.getElementById("certImage").src = selected.image;
                document.getElementById("certCaptionLink").href = selected.image;
                document.getElementById("certCaptionLink").textContent = selected.caption;
                certPreview.classList.remove("hidden");
            };
        } else {
            certPreview.classList.add("hidden");
        }

        // Portofolio Dropdown
        const portfolioSelect = document.getElementById("portfolioSelect");
        const portfolioPreview = document.getElementById("portfolioPreview");

        portfolioSelect.innerHTML = `<option disabled selected>Lihat Portofolio</option>`;

        if (worker.portfolios && worker.portfolios.length > 0) {
            worker.portfolios.forEach((item, i) => {
                const option = document.createElement("option");
                option.value = i;
                option.textContent = item.caption;
                portfolioSelect.appendChild(option);
            });

            portfolioSelect.onchange = () => {
                const selected = worker.portfolios[portfolioSelect.value];
                document.getElementById("portfolioImage").src = selected.image;
                document.getElementById("portfolioCaptionLink").href = selected.image;
                document.getElementById("portfolioCaptionLink").textContent = selected.caption;
                portfolioPreview.classList.remove("hidden");
            };
        } else {
            portfolioPreview.classList.add("hidden");
        }

        showWorkerTab('keahlianTab');
        document.getElementById('workerDetailModal').classList.remove('hidden');
    }

    // Tab Switch Modal
    function showWorkerTab(tabId) {
        document.querySelectorAll(".worker-tab-content").forEach(el => el.classList.add("hidden"));
        document.getElementById(tabId).classList.remove("hidden");
    }

    // Inisialisasi awal
</script>
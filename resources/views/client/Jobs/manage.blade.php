@include('General.header')

<div class="p-4 mt-16 ">
    <!-- Tabs button -->
    <div class="flex flex-wrap gap-4 pb-4 text-sm sm:text-base overflow-x-auto">
        <button
            class="tab-button text-white font-semibold py-2 px-4 rounded-md transition-all duration-300 bg-[#1F4482] focus:outline-none"
            data-tab="info">
            Informasi Lengkap
        </button>
        <button
            class="tab-button text-gray-600 font-semibold py-2 px-4 rounded-md transition-all duration-300 hover:bg-[#1F4482] hover:text-white focus:outline-none active:bg-[#1F4482] active:text-white"
            data-tab="applicants">
            Lamaran Worker
        </button>
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
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Section -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border space-y-6">
                    <!-- Header -->
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-4">
                            <img src="{{ $job->user->profile_image ? asset('storage/' . $job->user->profile_image) : asset('assets/images/avatar.png') }}"
                                alt="User" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800">{{ $job->title ?? '[Judul belum diisi]' }}
                                </h1>
                                <p class="text-xs flex items-center gap-1">
                                    <i class="fa-solid fa-pen text-gray-500"></i>
                                    <span class="text-gray-500">Task diposting</span>
                                    <span class="text-gray-600 font-semibold">
                                        {{ \Carbon\Carbon::parse($job->created_at)->translatedFormat('d F Y') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="text-left">
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
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">File Terkait</h2>
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

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-2">
                        @if ($job->status === 'open')
                            <form id="cancelTaskForm{{ $job->id }}" action="{{ route('jobs.destroy', $job->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmCancel({{ $job->id }})"
                                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                    Hapus Task
                                </button>
                            </form>
                        @else
                            <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed" disabled>
                                Tidak Bisa Dibatalkan Task Sudah Di Proses
                            </button>
                        @endif
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
    </div>



    <!-- Tab 2: Lamaran Worker -->
    <div id="applicants" class="tab-content hidden mt-4">
        <!-- Filter -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-2">
            <form method="GET" class="flex items-center gap-2">
                <label for="sortBy" class="font-semibold">Urutkan Berdasarkan:</label>
                <select name="sort" id="sortBy"
                    class="p-2 border rounded bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1F4482]"
                    onchange="this.form.submit()">
                    <option value="bidPrice" {{ request('sort') === 'bidPrice' ? 'selected' : '' }}>Harga</option>
                    <option value="experience" {{ request('sort') === 'experience' ? 'selected' : '' }}>Pengalaman
                    </option>
                </select>

                <select name="dir"
                    class="p-2 border rounded bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1F4482]"
                    onchange="this.form.submit()">
                    <option value="asc" {{ request('dir') === 'asc' ? 'selected' : '' }}>Naik ↑</option>
                    <option value="desc" {{ request('dir') === 'desc' ? 'selected' : '' }}>Turun ↓</option>
                </select>
            </form>
        </div>

        <!-- List Pelamar (Daftar Pelamar) -->
        <div id="applicants-list" class="space-y-6">
            @foreach ($applicants as $applicant)
                @php
                    $worker = $applicant->worker;
                    $user = $worker->user;
                    $avgRating = 0; // default
                @endphp

                <!-- Kartu Pelamar -->
                <div
                    class="flex flex-col lg:flex-row gap-4 bg-white border rounded-lg shadow-lg p-6 hover:bg-gray-50 transition-all duration-300 hover:shadow-xl">

                    <!-- Kiri: Detail Pelamar -->
                    <div class="flex-1">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('storage/' . ($worker->profile_image ?? 'default.jpg')) }}" alt="Profile"
                                class="w-16 h-16 rounded-full object-cover">
                            <div class="mt-4 text-gray-600 text-sm">
                                <p class="font-semibold text-lg text-gray-800">{{ $user->nama_lengkap }}</p>
                                <p class="text-gray-500 text-sm"><strong>Negoisasi</strong>
                                    Rp{{ number_format($applicant->bidPrice) }}</p>
                                <p class="text-gray-500 text-sm"><strong>Pengalaman</strong>
                                    {{ $worker->pengalaman_kerja ?? 0 }} tahun</p>
                                <p class="text-gray-500 text-sm"><strong>Rating</strong> {{ number_format($avgRating, 1) }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 text-gray-600 text-sm">
                            <p><strong>Catatan: </strong> {{ $applicant->catatan }}</p>
                        </div>
                    </div>


                    <!-- Kanan: Tombol-Tombol Aksi -->
                    <div class="flex flex-col justify-between items-end">
                        <div class="flex gap-2 mt-4">
                            <a href="{{ route('profile.worker.lamar', $worker->id) }}"
                                class="bg-[#1F4482] hover:bg-[#18346a] text-white px-4 py-2 rounded-md shadow inline-block">
                                Lihat Profil
                            </a>
                            <a href="{{ url('chat/' . $user->id) }}"
                                class="bg-[#1F4482] text-white px-4 py-2 rounded-md hover:bg-[#18346a] inline-block">
                                Chat
                            </a>


                            <!-- Tombol yang membuka modal hire -->
                            <button type="button"
                                class="bg-green-700 text-white px-4 py-2 rounded-md hover:bg-green-800"
                                onclick="openPaymentModal()">
                                Hire worker
                            </button>

                            <form action="{{ route('client.reject') }}" method="POST">
                                @csrf
                                <input type="hidden" name="application_id" value="{{ $applicant->id }}">
                                <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded-md hover:bg-red-800">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </div>

                </div>

                <!-- Modal hire pilih metode bayar-->
                <div id="paymentModal"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 z-50"
                    onclick="handleOverlayClick(event)">
                    
                    <!-- Konten Modal -->
                    <div class="bg-white p-6 rounded-md w-full max-w-md transform scale-95 transition-all duration-300"id="modalContent">
                        <h2 class="text-lg font-bold mb-4">Pilih Metode Pembayaran</h2>
                        <div class="flex flex-col gap-2">
                            <button type="button" onclick="openEwalletModal(this)" class="bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700"data-profile-id="{{ $applicant->profile_id }}"data-bid-price="{{ $applicant->bidPrice }}">
                                Bayar dengan E-Wallet
                            </button>
                            <button type="button" onclick="openModal()" class="bg-green-600 text-white py-2 rounded-md hover:bg-green-700">
                                Bayar Langsung
                            </button>
                            <button type="button" onclick="closePaymentModal()" class="bg-gray-300 text-gray-700 py-2 rounded-md hover:bg-gray-400">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    

    <!-- modal bayar ewallet -->
    <div id="ewalletModal" 
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300 opacity-0"
        onclick="handleOutsideClick(event)">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md mx-4 sm:mx-0 transform transition-transform duration-300 scale-90"
            id="ewalletContent" onclick="event.stopPropagation()">
            <h2 class="text-xl font-bold mb-4 text-center">Konfirmasi Pembayaran</h2>

            <form id="ewalletPaymentForm" action="{{ route('client.bayar.ewallet', $task->id) }}" method="POST">
                @csrf
                <input type="hidden" name="task_id" value="{{ $task->id }}">
                <input type="hidden" name="type" value="payment">
                <input type="hidden" name="worker_profile_id" id="worker_profile_id" value="">
                <input type="hidden" name="client_id" value="{{ Auth::id() }}">
                <input type="hidden" name="payment_method" value="ewallet" />
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Anda akan melakukan pembayaran menggunakan saldo E-Wallet.</p>
                    <input type="number" class="mt-2 text-lg font-semibold" name="amount" value=""></input>
                    <p class="text-sm text-gray-500 mt-1">Saldo tersedia: Rp{{ number_format($ewallet->balance ?? 0, 0, ',', '.') }}</p>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                    Bayar Sekarang
                </button>

                <button type="button" onclick="closeEwalletModal()" class="mt-2 w-full py-2 rounded bg-gray-400 text-white hover:bg-gray-500">
                    Batal
                </button>
            </form>
        </div>
    </div>



    <!-- Modal bayar direct-->
    <div id="bayarModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden transition-opacity duration-300 opacity-0">
        <div id="modalContent"
            class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative transform transition-all duration-300 scale-95">
            <h2 class="text-lg font-semibold mb-4">Pilih Metode Pembayaran</h2>
            <!-- Error Alert -->
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @if(!empty($applicant))
                <form id="bayarForm" action="{{ route('client.bayar', $task->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_order" value="{{ $task->id }}">
                    <input type="hidden" name="worker_profile_id" value="{{ $applicant->profile_id }}">
                    <input type="hidden" name="payment_method" value="direct" />
                    <input type="hidden" name="type" value="payment" />
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Order ID</label>
                        <input type="text" class="w-full border rounded px-3 py-2 mt-1" value="{{ $task->id }}" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Jumlah Harga</label>
                        <input type="number" name="amount" class="w-full border rounded px-3 py-2 mt-1"
                            value="{{ $applicant->bidPrice }}" readonly>
                    </div>

                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
                        Bayar Sekarang
                    </button>
                    <button onclick="closeModal()"
                        class="py-2 px-4 mt-4 bg-red-600 rounded hover:bg-red-700 w-full text-white">
                        Tutup
                    </button>
                </form>
            @else
                <div class="text-red-600 font-semibold">
                    Tidak ada pelamar yang tersedia untuk dibayar.
                </div>
            @endif
        </div>
    </div>
    @if(session('error'))
        <div class="fixed top-4 right-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md z-50"
            id="globalAlert" role="alert">
            <div class="flex">
                <div class="py-1">
                    <svg class="h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold">Error</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
                <button onclick="document.getElementById('globalAlert').style.display='none'" class="ml-auto">
                    <svg class="h-4 w-4 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif
</div>

@include('General.footer')

<!-- untuk modal bayar pake ewallet -->
<script>
    function openEwalletModal(button) {
        const modal = document.getElementById('ewalletModal');
        modal.classList.remove('hidden');
        setTimeout(() => modal.classList.remove('opacity-0'), 10);

        // Ambil data dari tombol
        const profileId = button.getAttribute('data-profile-id');
        const bidPrice = button.getAttribute('data-bid-price');

        // Set value ke input hidden dan input amount
        document.getElementById('worker_profile_id').value = profileId;
        document.querySelector('input[name="amount"]').value = bidPrice;
    }

    function closeEwalletModal() {
        const modal = document.getElementById('ewalletModal');
        modal.classList.add('opacity-0');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    function handleOutsideClick(event) {
        if (event.target.id === 'ewalletModal') {
            closeEwalletModal();
        }
    }
</script>


<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>


<!-- JS UNTUK MODAL HIRE -->
<script>
    function openPaymentModal() {
        const modal = document.getElementById('paymentModal');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100');
    }

    function closePaymentModal() {
        const modal = document.getElementById('paymentModal');
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');

        // Tunggu transisi selesai
        setTimeout(() => {
            modal.classList.add('pointer-events-none');
        }, 300);
    }

    function submitWithMethod(method) {
        document.getElementById('payment_method').value = method;
        document.getElementById('paymentForm').submit();
    }

    function handleOverlayClick(event) {
        const content = document.getElementById('modalContent');
        if (!content.contains(event.target)) {
            closePaymentModal();
        }
    }
</script>


<!-- JS UNTUK BAWA METODE PEMBAYARAN -->
<script>
    function submitWithMethod(method) {
        // Set nilai payment_method di hidden input form bayar
        document.querySelector('#bayarForm input[name="payment_method"]').value = method;

        // Submit form bayar langsung (modal bayar muncul setelah)
        document.getElementById('bayarForm').submit();
    }

    function openModal() {
        // Contoh kalau kamu mau buka modal bayar langsung
        const bayarModal = document.getElementById('bayarModal');
        bayarModal.classList.remove('hidden');
        bayarModal.classList.add('flex', 'opacity-100');
    }

    function closeModal() {
        const bayarModal = document.getElementById('bayarModal');
        bayarModal.classList.add('hidden');
        bayarModal.classList.remove('flex', 'opacity-100');
    }
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.tab-button');
        const tabs = document.querySelectorAll('.tab-content');

        // Set the first tab as default active
        buttons[0].classList.add('bg-[#1F4482]', 'text-white');
        tabs[0].classList.remove('hidden');

        buttons.forEach((button, index) => {
            button.addEventListener('click', () => {
                // Reset all tabs
                buttons.forEach((btn) => {
                    btn.classList.remove('bg-[#1F4482]', 'text-white');
                    btn.classList.add('text-gray-600');
                });
                tabs.forEach((tab) => tab.classList.add('hidden'));

                // Set clicked tab as active
                button.classList.add('bg-[#1F4482]', 'text-white');
                tabs[index].classList.remove('hidden');
            });
        });
    });

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
            onSuccess: function (result) {
                alert('Pembayaran berhasil!');
                window.location.href = '{{ route('jobs.my') }}';
                // window.location.href = '{{route('invoice', $task->id)}}';
            },
            onPending: function (result) {
                alert('Pembayaran tertunda, silakan selesaikan pembayaran Anda');
                window.location.reload();
            },
            onError: function (result) {
                alert('Pembayaran gagal, silakan coba lagi');
                window.location.reload();
            },
            onClose: function () {
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
        setTimeout(function () {
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
                const aVal = parseFloat(a.getAttribute(data-${attr})) || 0;
                const bVal = parseFloat(b.getAttribute(data-${attr})) || 0;
                return aVal - bVal;
            });
        }

        container.innerHTML = '';
        items.forEach(item => container.appendChild(item));
    }
    <!-- Untuk hapus task admin -->

    function confirmCancel(taskId) {
        Swal.fire({
            title: 'Yakin ingin menghapus task?',
            text: "Tindakan ini tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Hapus Task',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Task berhasil dibatalkan!',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#1F4482'
                }).then(() => {
                    document.getElementById(cancelTaskForm${taskId}).submit();
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
                button.classList.add('text-white', 'font-semibold');
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
        document.getElementById("worker-experience").textContent = ${experience} tahun;
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
        document.getElementById("worker-experience").textContent = ${worker.experience} tahun;
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
        certSelect.innerHTML = <option disabled selected>Lihat Sertifikasi</option>;

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

        portfolioSelect.innerHTML = <option disabled selected>Lihat Portofolio</option>;

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
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                const tabId = this.getAttribute('data-tab');

                // Sembunyikan semua tab
                tabContents.forEach(content => content.classList.add('hidden'));

                // Tampilkan tab yang sesuai
                document.getElementById(tabId).classList.remove('hidden');

                // Update gaya tombol
                tabButtons.forEach(btn => {
                    btn.classList.remove('bg-[#1F4482]', 'text-white');
                    btn.classList.add('text-gray-600');
                });
                this.classList.remove('text-gray-600');
                this.classList.add('bg-[#1F4482]', 'text-white');
            });
        });
    });
</script>

@include('General.footer')
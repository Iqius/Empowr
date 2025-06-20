@include('General.header')

<div class="p-4 mt-16 ">
    <!-- Tabs button -->
<div class="flex flex-wrap gap-4 text-sm sm:text-base overflow-x-auto">
    <button
        class="tab-button active bg-white text-black font-semibold py-2 px-4 rounded-md border-b-0 transition-all duration-300 focus:outline-none"
        data-tab="info">
        Informasi Lengkap
    </button>
    <button
        class="tab-button bg-white/70 text-gray-400 font-semibold py-2 px-4 rounded-md border-b-0 transition-all duration-300 focus:outline-none"
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
    <div id="info" class="tab-content space-y-4 ">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Section -->
            <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 space-y-6 rounded-tr-xl rounded-br-xl rounded-bl-xl ">
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
                        @if ($job->status === 'open' && (auth()->user()->role != 'admin'))
                            <form id="cancelTaskForm{{ $task->id }}" action="{{ route('jobs.destroy', $task->id) }}" method="POST">
                                
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmCancel({{ $job->id }})"
                                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                    Hapus Task
                                </button>
                            </form>
                        @elseif ($job->status != 'open' && (auth()->user()->role != 'admin'))
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
    <div id="applicants" class="tab-content hidden mt-4 ">
        <!-- Filter -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-2">
            <form method="GET" id="sortForm" class="flex items-center gap-2">
                <label for="sortBy" class="font-semibold">Urutkan Berdasarkan:</label>
                <select name="sort" id="sortBy" class="p-2 border rounded bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1F4482]">
                    <option value="bidPrice" {{ request('sort') === 'bidPrice' ? 'selected' : '' }}>Harga</option>
                    <option value="experience" {{ request('sort') === 'experience' ? 'selected' : '' }}>Pengalaman</option>
                    <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating</option>

                </select>

                <select name="dir" id="dirBy" class="p-2 border rounded bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#1F4482]">
                    <option value="asc" {{ request('dir') === 'asc' ? 'selected' : '' }}>Naik ↑</option>
                    <option value="desc" {{ request('dir') === 'desc' ? 'selected' : '' }}>Turun ↓</option>
                </select>
            </form>

            @if($job->pengajuan_affiliate == 0 && $job->status_affiliate == 0 && (auth()->user()->role != 'admin'))
                <button onclick="openModalAffiliasi()" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Dapatkan worker yang bermitra disini
                </button>
            @elseif ($job->pengajuan_affiliate == 1 && (auth()->user()->role != 'admin'))
                <button onclick="#" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Chat admin
                </button>
            @endif
        </div>

        <!-- List Pelamar (Daftar Pelamar) -->
        <div id="applicants-list" class="space-y-6">
            @foreach ($applicants as $applicant)
                @php
                    $worker = $applicant->worker;
                    $user = $worker->user;
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
                                <p class="text-gray-500 text-sm"><strong>Rating</strong> {{ number_format($applicant->avgRating ?? 0, 1) }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 text-gray-600 text-sm">
                            <p><strong>Catatan: </strong> {{ $applicant->catatan }}</p>
                        </div>
                    </div>


                    @if(auth()->check() && auth()->user()->role != 'admin')
                        <!-- Kanan: Tombol-Tombol Aksi -->
                        <div class="flex flex-col justify-between items-end">
                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('profile.worker.lamar', $worker->id) }}"
                                    class="bg-[#1F4482] hover:bg-[#18346a] text-white px-4 py-2 rounded-md shadow inline-block">
                                    Lihat Profil
                                </a>
                                <a href="{{ url('chat/' . $user->id) }}"
                                    class="bg-[#1F4482] text-white px-4 py-2 rounded-md hover:bg-[#18346a] inline-block " data-task-id="{{ $applicant->task->id }}">
                                    Chat
                                </a>


                                <!-- Tombol yang membuka modal hire -->
                                <button type="button"
                                    class="bg-green-700 text-white px-4 py-2 rounded-md hover:bg-green-800" data-profile-id="{{ $applicant->profile_id }}" data-bid-price="{{ $applicant->bidPrice }}" onclick="openPaymentModal(this)">
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
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    
<!-- Modal hire pilih metode bayar -->
<div id="paymentModal"
    class="fixed inset-0 flex items-center justify-center opacity-0 pointer-events-none backdrop-blur-sm transition-opacity duration-300 bg-black/30"
    onclick="handleOverlayClick(event)">

    <!-- Konten Modal -->
    <div class="relative bg-white p-6 rounded-md w-full max-w-md transform scale-95 transition-all duration-300"
        id="modalContent">

        <!-- Tombol Close (X) -->
        <button type="button" onclick="closePaymentModal()"
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>

        <!-- Gambar di atas judul -->
        <div class="border border-gray-300 rounded-md p-2 mb-4 shadow-sm w-fit mx-auto">
            <img src="{{ asset('assets/images/bill.gif') }}" alt="Metode Pembayaran"
                class="w-auto max-w-full max-h-48 mx-auto mb-4">
        </div>

        <!-- Judul -->
        <h2 class="text-lg font-bold mb-2 text-center">Pilih Metode Pembayaran</h2>

        <!-- Deskripsi -->
        <p class="text-sm text-gray-600 text-center mb-4">
            Silakan pilih metode pembayaran yang ingin Anda gunakan untuk menyelesaikan proses perekrutan.
        </p>

        <!-- Tombol pembayaran -->
        <div class="flex flex-col sm:flex-row justify-between gap-2">
            <button type="button" onclick="openEwalletModal(this)"
                class="flex-1 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700"
                data-profile-id=""
                data-bid-price="">
                Bayar dengan E-Wallet
            </button>

            <button type="button" onclick="openModal()"
                class="flex-1 bg-green-600 text-white py-2 rounded-md hover:bg-green-700">
                Bayar Langsung
            </button>
        </div>
    </div>
</div>

<!-- modal bayar ewallet -->
<div id="ewalletModal" 
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50 transition-opacity backdrop-blur-sm transition-opacity duration-300 opacity-0"
    onclick="handleOutsideClick(event)">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md mx-4 sm:mx-0 transform transition-transform duration-300 scale-90 relative"
        id="ewalletContent" onclick="event.stopPropagation()">

        <!-- Tombol Close -->
        <button onclick="closeEwalletModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-lg font-bold">
            &times;
        </button>

        <!-- gambar -->
        <div class="border border-gray-300 rounded-md p-2 mb-4 shadow-sm w-fit mx-auto">
            <img src="{{ asset('assets/images/ewallet.gif') }}" alt="Metode Pembayaran"
                class="w-auto max-w-full max-h-48 mx-auto mb-4">
        </div>

        <!-- Judul -->
        <h2 class="text-xl font-bold mb-4 text-center">Konfirmasi Pembayaran</h2>

        <!-- Deskripsi -->
        <form id="ewalletPaymentForm" action="{{ route('client.bayar.ewallet', $task->id) }}" method="POST">
            @csrf
            <input type="hidden" name="task_id" value="{{ $task->id }}">
            <input type="hidden" name="type" value="payment">
            <input type="hidden" name="worker_profile_id" id="worker_profile_id" value="">
            <input type="hidden" name="client_id" value="{{ Auth::id() }}">
            <input type="hidden" name="payment_method" value="ewallet" />
            <div class="mb-4">
                <p class="text-sm text-gray-600">Anda akan melakukan pembayaran menggunakan saldo E-Wallet.</p>
                <input type="number" class="mt-2 text-lg font-semibold bg-gray-100 cursor-not-allowed" name="amount" id="paymentAmount" readonly>
                <p class="text-sm text-gray-600 mt-3">
                    Saldo tersedia:
                    <span class="text-[#1F4482] font-bold text-base" id="currentBalance">
                        Rp{{ number_format($ewallet->balance ?? 0, 0, ',', '.') }}
                    </span>
                </p>
            </div>

            <!-- Tombol bayar -->
            <button type="submit" id="payButton"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 mb-2">
                - Rp0
            </button>

            <!-- Saldo tersisa -->
            <p id="saldoTersisa" class="text-sm text-center mt-1">
                Saldo tersisa: Rp0
            </p>


        </form>
    </div>
</div>




    <!-- Modal bayar direct-->
    <div id="bayarModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden transition-opacity backdrop-blur-sm transition-opacity duration-300 opacity-0">
        <div id="modalContent"
            class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative transform transition-all duration-300 scale-95">

            <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-lg font-bold">
                &times;
            </button>

                    <div class="border border-gray-300 rounded-md p-2 mb-4 shadow-sm w-fit mx-auto">
            <img src="{{ asset('assets/images/money.gif') }}" alt="Metode Pembayaran"
                class="w-auto max-w-full max-h-48 mx-auto mb-4">
        </div>
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



<!-- Modal untuk request affiliasi -->
<div id="infoModalAffiliasi" class="fixed inset-0 z-[9999] flex items-center justify-center opacity-0 pointer-events-none backdrop-blur-sm transition-opacity duration-300 bg-black/30">
    <div id="modalContentAffiliasi"class="bg-white p-6 rounded-lg w-full max-w-lg shadow-lg transform scale-95 opacity-0 transition duration-300max-h-[80vh] flex flex-col">
        <form action="{{ route('jobs.request-affiliate', $task->id) }}" method="POST">
            @csrf
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Informasi</h2>
                <button onclick="closeModalAffiliasi()" class="text-gray-500 hover:text-gray-800 text-xl font-bold">&times;</button>
            </div>

            <!-- Modal Body (scrollable bagian ini) -->
            <div class="overflow-y-auto mb-4 text-sm text-gray-700 space-y-2 flex-1 pr-1">
                <p>Ini adalah informasi penting sebelum Anda mengajukan permintaan. Harap dibaca dengan seksama.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                <p>More long content here...</p>
                <!-- Tambahkan banyak paragraf untuk simulasi -->
                <p>Lorem ipsum...</p>
                <p>Lorem ipsum...</p>
                <p>Lorem ipsum...</p>
                <p>Lorem ipsum...</p>
                <p>Lorem ipsum...</p>
                <p>Lorem ipsum...</p>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end space-x-2 pt-2 border-t">
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Ajukan</button>
                <button type="button" onclick="closeModalAffiliasi()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
            </div>
            
        </form>
    </div>
</div>



@include('General.footer')

<!-- modal request affiliasi -->
<script>
  function openModalAffiliasi() {
    const modal = document.getElementById('infoModalAffiliasi');
    const content = document.getElementById('modalContentAffiliasi');

    modal.classList.remove('opacity-0', 'pointer-events-none');
    setTimeout(() => {
      content.classList.remove('scale-95', 'opacity-0');
      content.classList.add('scale-100', 'opacity-100');
    }, 10);
  }

  function closeModalAffiliasi() {
    const modal = document.getElementById('infoModalAffiliasi');
    const content = document.getElementById('modalContentAffiliasi');

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    modal.classList.add('opacity-0');

    setTimeout(() => {
      modal.classList.add('pointer-events-none');
    }, 300);
  }
</script>

<!-- untuk modal bayar pake ewallet -->
<script>
    const userBalance = {{ $ewallet->balance ?? 0 }};

    function openEwalletModal(button) {
        const modal = document.getElementById('ewalletModal');
        modal.classList.remove('hidden');
        setTimeout(() => modal.classList.remove('opacity-0'), 10);

        // Ambil data dari tombol yang diklik
        const profileId = button.getAttribute('data-profile-id') ?? '';
        const rawBidPrice = button.getAttribute('data-bid-price') ?? '0';
        const bidPrice = parseInt(rawBidPrice.replace(/\D/g, '')) || 0;

        // Set ke input hidden
        const inputProfile = document.getElementById('worker_profile_id');
        const inputAmount = document.querySelector('input[name="amount"]');

        if (inputProfile) inputProfile.value = profileId;
        if (inputAmount) inputAmount.value = bidPrice;

        // Update tombol bayar
        const payButton = document.getElementById('payButton');
        if (payButton) {
            payButton.innerText = `- Rp${bidPrice.toLocaleString('id-ID')}`;
        }

        // Hitung saldo tersisa
        const sisa = userBalance - bidPrice;
        const saldoTersisaElement = document.getElementById('saldoTersisa');
        if (saldoTersisaElement) {
            if (sisa >= 0) {
                saldoTersisaElement.innerText = `Saldo tersisa: Rp${sisa.toLocaleString('id-ID')}`;
                saldoTersisaElement.classList.remove('text-red-600');
                saldoTersisaElement.classList.add('text-gray-700');
            } else {
                saldoTersisaElement.innerText = `Saldo tidak mencukupi`;
                saldoTersisaElement.classList.add('text-red-600');
                saldoTersisaElement.classList.remove('text-gray-700');
            }
        }
    }

    function closeEwalletModal() {
        const modal = document.getElementById('ewalletModal');
        if (modal) {
            modal.classList.add('opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }
    }

    function handleOutsideClick(event) {
        const modal = document.getElementById('ewalletModal');
        if (event.target === modal) {
            closeEwalletModal();
        }
    }
</script>



<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>


<!-- JS UNTUK MODAL HIRE -->
<script>
    function openPaymentModal(button) {
        const profileId = button.dataset.profileId;
        const bidPrice = button.dataset.bidPrice;
        
        const modal = document.getElementById('paymentModal');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100');

        // Inject data ke tombol ewallet di dalam modal
        const ewalletBtn = modal.querySelector('[onclick^="openEwalletModal"]');
        ewalletBtn.setAttribute('data-profile-id', profileId);
        ewalletBtn.setAttribute('data-bid-price', bidPrice);

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


<!-- Script midtrans -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.tab-button');
    const tabs = document.querySelectorAll('.tab-content');

    // Set default tab
    buttons[0].classList.add('bg-white', 'text-black', 'font-semibold');
    tabs[0].classList.remove('hidden');

    buttons.forEach((button, index) => {
        button.addEventListener('click', () => {
            // Reset semua tombol
            buttons.forEach(btn => {
                btn.classList.remove('bg-white', 'text-black', 'text-white');
                btn.classList.add('bg-white/70', 'text-gray-400');
            });

            // Reset semua tab
            tabs.forEach(tab => tab.classList.add('hidden'));

            // Aktifkan yang diklik
            button.classList.remove('bg-white/70', 'text-gray-400');
            button.classList.add('bg-white', 'text-black');
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
        Swal.fire({
            icon: 'success',
            title: 'Pembayaran Berhasil!',
            text: 'Transaksi Anda telah berhasil.',
            confirmButtonText: 'Lihat Task Saya'
        }).then(() => {
            window.location.href = '{{ route('jobs.my') }}';
        });
    },
    onPending: function (result) {
        Swal.fire({
            icon: 'info',
            title: 'Pembayaran Tertunda',
            text: 'Silakan selesaikan pembayaran Anda.',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.reload();
        });
    },
    onError: function (result) {
        Swal.fire({
            icon: 'error',
            title: 'Pembayaran Gagal',
            text: 'Silakan coba lagi nanti.',
            confirmButtonText: 'Coba Lagi'
        }).then(() => {
            window.location.reload();
        });
    },
    onClose: function () {
        Swal.fire({
            icon: 'warning',
            title: 'Pembayaran Belum Selesai',
            text: 'Anda menutup jendela pembayaran sebelum menyelesaikannya.',
            confirmButtonText: 'OK'
        });
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

<!-- SCRIPT UNTUK HAPUS TASK -->
 <SCript>
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
                    document.getElementById(`cancelTaskForm${taskId}`).submit();
                });
            }
        });
    }
 </SCript>

<script>
    const sortSelect = document.getElementById('sortBy');
    const dirSelect = document.getElementById('dirBy');
    const applicantsList = document.getElementById('applicants-list');

    function fetchSortedApplicants() {
        const sort = sortSelect.value;
        const dir = dirSelect.value;
        const url = `?sort=${sort}&dir=${dir}`;

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContent = doc.querySelector('#applicants-list');
            applicantsList.innerHTML = newContent.innerHTML;

            // jika kamu punya handler JS lain (seperti modal), panggil ulang di sini
        });
    }

    sortSelect.addEventListener('change', fetchSortedApplicants);
    dirSelect.addEventListener('change', fetchSortedApplicants);
</script>


<!-- script filter worker -->
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
    

    document.addEventListener('DOMContentLoaded', function () {
        const sortSelect = document.getElementById("sortBy");
        if (sortSelect) {
            sortSelect.addEventListener("change", sortApplicants);
        }

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
</script>
<script>
    // Tangani klik tombol Bayar
    document.getElementById('ewalletPaymentForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Cegah submit langsung

        Swal.fire({
            title: 'Konfirmasi Pembayaran',
            text: "Apakah Anda yakin ingin melanjutkan pembayaran ini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Bayar Sekarang'
        }).then((result) => {
            if (result.isConfirmed) {
                // Simulasi loading saat submit
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Simulasi delay submit form (0.5s), lalu submit
                setTimeout(() => {
                    // Submit secara manual
                    event.target.submit();
                }, 500);
            }
        });
    });

    // Jika ingin alert berhasil setelah redirect, tambahkan flash session di Laravel controller:
    // return redirect()->back()->with('success', 'Pembayaran berhasil!');
    @if(session('success-hired'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success-hired') }}',
                confirmButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('jobs.my') }}';
                }
            });
    @endif

</script>


@include('General.footer')
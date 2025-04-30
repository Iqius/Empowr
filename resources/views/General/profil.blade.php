@include('General.header')
<div class="p-4 mt-10">
    <div class="grid grid-cols-1 md:grid-cols-[1fr_3fr] gap-6 min-h-screen">
        <!-- Kolom kiri untuk tab -->
        <div class="p-4 rounded h-full">
            <div class="p-6 bg-white rounded-lg shadow-md h-full">
                <div class="flex flex-col items-center gap-4">
                    <label for="profile-pic" class="cursor-pointer">
                        <img id="profile-image" src="#" alt="Profile Picture" class="w-24 h-24 sm:w-32 sm:h-32 rounded-full object-cover border border-gray-300">
                    </label>
                    <div class="text-center">
                        <h2 class="text-2xl font-bold">{{ Auth::user()->nama_lengkap }}</h2>
                        <span id="verificationBadge" class="text-blue-500">✔ Verified</span>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="mt-6">
                    <button onclick="showTab('dataDiri')" class="tab-button px-4 py-2 text-gray-600 hover:bg-blue-600 hover:text-white w-full text-left rounded"><i class="bi bi-person-fill me-5"></i>Data Diri</button>
                    @if(auth()->user()->role == 'worker')
                        <button onclick="showTab('portofolio')" class="tab-button px-4 py-2 text-gray-600 hover:bg-blue-600 hover:text-white w-full text-left rounded"><i class="bi bi-folder2-open me-5"></i>Portofolio</button>
                        <button onclick="showTab('sertifikasi')" class="tab-button px-4 py-2 text-gray-600 hover:bg-blue-600 hover:text-white w-full text-left rounded"><i class="bi bi-award me-5"></i>Sertifikasi</button>
                    @endif
                    <button onclick="showTab('HistoryTask')" class="tab-button px-4 py-2 text-gray-600 hover:bg-blue-600 hover:text-white w-full text-left rounded"><i class="bi bi-patch-check me-5"></i>History Task</button>
                    <button onclick="showTab('Keahlian')" class="tab-button px-4 py-2 text-gray-600 hover:bg-blue-600 hover:text-white w-full text-left rounded"><i class="bi bi-laptop me-5"></i>Ulasan</button>
                </div>
            </div>
        </div>

        <!-- Kolom kanan untuk konten -->
        <div class="p-4 rounded h-full">
            <div class="p-6 bg-white rounded-lg shadow-md h-full">
                
                <!-- Tab 1 (datadiri) -->
                <div id="dataDiri" class="tab-content p-4">
                    <div class="grid grid-cols-1 md:grid-cols-[8fr_1fr] gap-6 ">
                        <div class="flex flex-col gap-4">
                            <h1 class="text-2xl font-semibold mb-6">Personal Information</h1>
                        </div>

                        @if(auth()->user()->role == 'worker')
                        <div class="flex flex-col gap-4">
                            <button type="button" onclick="openCvModal('{{ asset('storage/' . $workerProfile?->cv) }}')" class="bg-blue-600 text-white px-3 py-1 rounded">
                                Lihat CV
                            </button>
                        </div>
                        @endif
                    </div>

                    <!-- bio -->
                    <div class="flex flex-col gap-4 mb-7">
                        <label class="font-semibold">Bio:</label>
                        <input type="text" value="{{ Auth::user()->bio }}" class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-7 ">
                        <!-- Email -->
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Email:</label>
                            <input type="email" value="{{ Auth::user()->email }}" class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed" readonly>
                        </div>

                        <!-- username -->
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Username:</label>
                            <input type="text" value="{{ Auth::user()->username }}" class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed" readonly>
                        </div>

                        <!-- no hp -->
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">No Telp:</label>
                            <input type="text" value="{{ Auth::user()->nomor_telepon }}" class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed" readonly>
                        </div>

                        <!-- tanggal bergabung -->
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Tgl Bergabung:</label>
                            <input type="text" value="{{ Auth::user()->tanggal_bergabung }}" class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600" readonly>
                        </div>

                        @if(auth()->user()->role == 'worker')
                            <!-- tingkat keahlian -->
                            <div class="flex flex-col gap-4">
                                <label class="font-semibold">Tingkat keahlian</label>
                                <input type="text" value="{{ $workerProfile?->tingkat_keahlian }}" class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed" readonly>
                            </div>

                            <!-- linkedin -->
                            <div class="flex flex-col gap-4">
                                <label class="font-semibold">Tautan</label>
                                <input type="text" value="{{ $workerProfile?->linkedin }}" class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed" readonly>
                            </div>
                        @endif

                        @if(auth()->user()->role == 'worker')
                            <!-- keahlian -->
                            <div class="flex flex-col gap-2">
                                <label class="font-semibold">Keahlian</label>
                                @php
                                    $selectedSkills = json_decode($workerProfile?->keahlian ?? '[]', true);
                                    $skillLabels = [
                                        'web_dev' => 'Web Development',
                                        'mobile_dev' => 'Mobile Development',
                                        'uiux' => 'UI/UX Design',
                                        'data_sci' => 'Data Science',
                                        'marketing' => 'Marketing',
                                    ];
                                    $selectedSkillNames = collect($selectedSkills)
                                        ->filter(fn($s) => isset($skillLabels[$s]))
                                        ->map(fn($s) => $skillLabels[$s])
                                        ->implode(', ');
                                @endphp

                                <input type="text"
                                    class="p-2 border rounded bg-gray-100 text-gray-600 cursor-not-allowed w-full"
                                    value="{{ $selectedSkillNames }}"
                                    readonly>
                            </div>
                        @endif
                    </div>

                    <hr class="border-t-1 border-gray-300 my-7">

                    <h1 class="text-2xl font-semibold mb-6">Payment Account</h1>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-7">
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Bank:</label>
                            <input type="text" readonly class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600" value="{{ strtoupper(Auth::user()->paymentAccount?->bank_name) ?? '-' }}">
                        </div>
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Nama akun Bank:</label>
                            <input type="text" readonly class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600" value="{{ strtoupper(Auth::user()->paymentAccount?->account_name) ?? '-' }}">
                        </div>
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Nomor rekening:</label>
                            <input type="text" readonly class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600" value="{{ strtoupper(Auth::user()->paymentAccount?->account_number) ?? '-' }}">
                        </div>

                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">E-wallet:</label>
                            <input type="text" readonly class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600" value="{{ strtoupper(Auth::user()->paymentAccount?->ewallet_provider) ?? '-' }}">
                        </div>
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Nomor e-wallet</label>
                            <input type="text" readonly class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600" value="{{ strtoupper(Auth::user()->paymentAccount?->wallet_number) ?? '-' }}">
                        </div>
                    </div>
                </div>

                <!-- Tab portofolio -->
                <div id="portofolio" class="tab-content p-4 hidden">
                    @if(auth()->user()->role == 'worker')
                        <button id="portfolioBtn" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 mb-5">Tambahkan Portofolio</button>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 ">
                        <!-- Button to trigger the modal -->
                        @foreach ($portofolio as $porto)
                            <div class="flex flex-col gap-4"> 
                                <div class="bg-white p-4 rounded shadow-md hover:shadow-lg transition duration-200">
                                    @if($porto->images && count($porto->images) > 0)
                                        <div class="w-full h-40 mb-3">
                                            <img src="{{ asset('storage/' . $porto->images[0]->image) }}" alt="Gambar Portofolio" class="w-full h-full object-cover rounded-md">
                                        </div>
                                    @endif

                                    <a href="#">
                                        <p class="text-blue-600 font-semibold text-base sm:text-lg">{{ $porto->title }}</p>
                                        @php
                                            $descriptionWords = explode(' ', $porto->description);
                                            $shortDescription = implode(' ', array_slice($descriptionWords, 0, 10));
                                            $remainingDescription = count($descriptionWords) > 10 ? '...' : '';
                                        @endphp

                                        <p class="text-gray-500 text-sm">{{ $shortDescription . $remainingDescription }}</p>
                                        <p class="text-xs text-gray-400 mt-1">Durasi: {{ $porto->duration }} hari</p>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- tab sertifikasi -->
                <div id="sertifikasi" class="tab-content p-4 hidden">
                    @if(auth()->user()->role == 'worker')
                        <button id="openCertificateModal" class="bg-blue-500 mb-5 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Tambah Sertifikat
                        </button>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 ">
                        @foreach ($sertifikasi as $sertifikat)
                            <div class="flex flex-col gap-4"> 
                                <div class="bg-white p-4 rounded shadow-md hover:shadow-lg transition duration-200">
                                    @if($sertifikat->images && count($sertifikat->images) > 0)
                                        <div class="w-full h-40 mb-3">
                                            <img src="{{ asset('storage/' . $sertifikat->images[0]->image) }}" alt="Gambar Sertifikat" class="w-full h-full object-cover rounded-md">
                                        </div>
                                    @endif
                                    <!-- Menambahkan text-center untuk membuat teks rata tengah -->
                                    <p class="text-blue-600 font-semibold text-base sm:text-lg text-center">{{ $sertifikat->title }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- History task -->
                <div id="HistoryTask" class="tab-content p-4 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 ">
                        <div class="flex flex-col gap-4">
                            <h2 class="text-xl font-semibold mb-4">Riwayat Tugas (Selesai)</h2>
                            @foreach ($tasks as $task)
                                <div class="mb-4 p-4 bg-white rounded shadow flex items-start space-x-4">
                                    @php
                                        $foto = auth()->user()->role == 'worker'
                                            ? ($task->client->foto ?? asset('assets/images/avatar.png'))
                                            : ($task->worker->user->foto ?? asset('assets/images/avatar.png'));
                                    @endphp
                                    <img src="{{ asset('storage/' . $foto) }}" alt=""
                                        class="w-12 h-12 rounded-full object-cover">

                                    {{-- Konten --}}
                                    <div class="flex-1">
                                        <h3 class="text-blue-600 font-semibold text-base sm:text-lg">{{ $task->title }}</h3>
                                        <p class="text-sm text-gray-600">{!! Str::limit(strip_tags($task->description), 30, '...') !!}</p>

                                        @if(auth()->user()->role == 'worker')
                                            <p class="text-sm text-gray-400">Client: {{ $task->client->nama_lengkap }}</p>
                                        @else
                                            <p class="text-sm text-gray-400">Worker: {{ $task->worker->user->nama_lengkap }}</p>
                                        @endif

                                        @if ($task->review)
                                            <div class="flex items-center mt-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $task->review->rating ? 'text-yellow-400' : 'text-gray-300' }} fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <path d="M12 .587l3.668 7.571L24 9.748l-6 5.847 1.417 8.263L12 18.896 4.583 23.858 6 15.595 0 9.748l8.332-1.59z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-400 italic mt-2">Belum ada ulasan</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal CV -->
<div id="cvModal" class="fixed z-50 inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="relative bg-white p-6 rounded shadow-lg w-11/12 md:w-3/4 h-4/5 overflow-auto scale-95 transition-transform duration-300">
        <h2 class="text-lg font-bold mb-4">Preview CV</h2>

        <!-- Pesan jika tidak ada CV -->
        <div id="noCvMessage" class="text-center text-gray-600 hidden">
            Maaf, file tidak tersedia
        </div>

        <!-- Iframe CV -->
        <iframe id="cvFrame" src="" class="w-full h-full rounded border hidden" frameborder="0"></iframe>

        <!-- Tombol Tutup (responsive) -->
        <button onclick="closeCvModal()"
            class="absolute top-4 right-4 text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-sm md:text-base">
            Tutup
        </button>
    </div>
</div>

<!-- Modal Portofolio -->
<div id="portfolioModal" class="fixed inset-0 z-50 bg-gray-900 bg-opacity-50 hidden flex justify-center items-center p-4">
  <div class="bg-white rounded-lg overflow-hidden shadow-lg w-full sm:w-96 p-6 space-y-6 transform opacity-0 scale-95 transition-all duration-300 ease-in-out" id="modalContent">
    <div class="flex justify-between items-center">
      <h5 class="text-xl font-semibold text-gray-800" id="portfolioModalLabel">Tambah Portofolio</h5>
    </div>
    
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-body space-y-4">
        <!-- Input fields for Portfolio details -->
        <input type="hidden" name="nama_lengkap" value="">
        <input type="hidden" name="email" value="">
        <input type="hidden" name="nomor_telepon" value="">
        <input type="hidden" name="bio" value="">
        <input type="hidden" name="keahlian[]" value="">
        <input type="hidden" name="tingkat_keahlian" value="">
        <input type="hidden" name="pengalaman_kerja" value="">
        <input type="hidden" name="pendidikan" value="">
        <input type="hidden" name="account_type" value="">
        <input type="hidden" name="wallet_number" value="">
        <input type="hidden" name="ewallet_name" value="">
        <input type="hidden" name="bank_name" value="">
        <input type="hidden" name="bank_number" value="">
        <input type="hidden" name="pemilik_bank" value="">
        <input type="hidden" name="sertifikat_caption" value="">
        
        <!-- Image Input -->
        <div class="space-y-2">
            <label for="portfolioImageInput" class="block text-sm font-medium text-gray-700">Gambar Portofolio</label>
            <input type="file" id="portofolio" name="portofolio[]" multiple class="w-full border border-1 rounded-md focus:ring-blue-500 focus:border-blue-500 p-2">
        </div>


        <!-- Title Input -->
        <div class="space-y-2">
          <label for="portfolioTitleInput" class="block text-sm font-medium text-gray-700">Judul Portofolio</label>
          <input type="text" id="portfolioTitleInput" name="title" class="w-full border border-1 rounded-md  focus:ring-blue-500 focus:border-blue-500 p-2">
        </div>

        <!-- Description Input -->
        <div class="space-y-2">
          <label for="portfolioDescriptionInput" class="block text-sm font-medium text-gray-700">Deskripsi Portofolio</label>
          <textarea id="portfolioDescriptionInput" name="description" rows="4" class="w-full rounded-md border border-1  focus:ring-blue-500 focus:border-blue-500 p-2"></textarea>
        </div>

        <!-- Duration Input -->
        <div class="space-y-2">
          <label for="portfolioDurationInput" class="block text-sm font-medium text-gray-700">Durasi Pengerjaan</label>
          <input type="text" id="portfolioDurationInput" name="duration" class="w-full  rounded-md border border-1 focus:ring-blue-500 focus:border-blue-500 p-2">
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-end space-x-3 mt-7">
        <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Simpan</button>
        <button type="button" id="closeModal" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Tutup</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal certifikat -->
<div id="certificateModal" class="fixed inset-0 z-50 bg-gray-900 bg-opacity-50 hidden flex justify-center items-center p-4">
  <div class="bg-white rounded-lg overflow-hidden shadow-lg w-full sm:w-96 p-6 space-y-6 transform opacity-0 scale-95 transition-all duration-300 ease-in-out" id="certificateModalContent">
    <div class="flex justify-between items-center">
      <h5 class="text-xl font-semibold text-gray-800" id="certificateModalLabel">
        <i class="bi bi-award me-2"></i> Tambah Sertifikat
      </h5>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-body space-y-4">

        <!-- Image Input -->
        <div class="space-y-2">
            <label for="certificateImageInput" class="block text-sm font-medium text-gray-700">
              <i class="bi bi-image me-1"></i> Gambar Sertifikat
            </label>
            <input type="file" id="certificateImageInput" name="certificate_image" class="w-full border border-1 rounded-md focus:ring-blue-500 focus:border-blue-500 p-2">
        </div>

        <!-- Title Input -->
        <div class="space-y-2">
          <label for="certificateTitleInput" class="block text-sm font-medium text-gray-700">
            <i class="bi bi-type me-1"></i> Judul Sertifikat
          </label>
          <input type="text" id="certificateTitleInput" name="title_sertifikasi" class="w-full border border-1 rounded-md focus:ring-blue-500 focus:border-blue-500 p-2">
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-end space-x-3 mt-7">
        <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
          <i class="bi bi-check-lg me-1"></i> Simpan
        </button>
        <button type="button" id="closeCertificateModal" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
          <i class="bi bi-x-lg me-1"></i> Tutup
        </button>
      </div>
    </form>
  </div>
</div>








<!-- ----------------------------------JS BATAS ------------------------------------------------------------------- -->


<script>
document.addEventListener('DOMContentLoaded', function() {
  const openCertificateModal = document.getElementById('openCertificateModal'); // Pastikan ID ini sesuai dengan tombol
  const certificateModal = document.getElementById('certificateModal');
  const closeCertificateModal = document.getElementById('closeCertificateModal');
  const modalContent = document.getElementById('certificateModalContent');
  
  // Show modal with fadeIn effect
  openCertificateModal.addEventListener('click', function() {
    certificateModal.classList.remove('hidden');
    setTimeout(() => {
      modalContent.classList.remove('opacity-0', 'scale-95');
      modalContent.classList.add('opacity-100', 'scale-100');
    }, 10);
  });
  
  // Close modal with fadeOut effect
  closeCertificateModal.addEventListener('click', function() {
    modalContent.classList.remove('opacity-100', 'scale-100');
    modalContent.classList.add('opacity-0', 'scale-95');
    setTimeout(() => {
      certificateModal.classList.add('hidden');
    }, 300); // Match the transition duration
  });
  
  // Optionally, close the modal if clicking outside of it
  certificateModal.addEventListener('click', function(event) {
    if (event.target === certificateModal) {
      closeCertificateModal.click();
    }
  });
});
</script>




<!-- untuk modal cv -->
 <script>
    function openCvModal(cvUrl) {
        const modal = document.getElementById('cvModal');
        const content = document.querySelector('#cvModal .bg-white');
        const cvFrame = document.getElementById('cvFrame');
        const noCvMessage = document.getElementById('noCvMessage');

        // Cek apakah URL CV ada dan file tersedia
        fetch(cvUrl, { method: 'HEAD' })
            .then(response => {
                if (response.ok) {
                    // Jika file ada, tampilkan iframe
                    cvFrame.src = cvUrl;
                    cvFrame.classList.remove('hidden');
                    noCvMessage.classList.add('hidden');
                } else {
                    // Jika file tidak ada, tampilkan pesan "File tidak tersedia"
                    cvFrame.classList.add('hidden');
                    noCvMessage.classList.remove('hidden');
                }
            })
            .catch(() => {
                // Jika ada error pada fetch (misalnya jaringan), anggap file tidak ada
                cvFrame.classList.add('hidden');
                noCvMessage.classList.remove('hidden');
            });

        modal.classList.remove('hidden');

        // Menambahkan efek animasi setelah modal ditampilkan
        setTimeout(() => {
            modal.classList.replace('opacity-0', 'opacity-100');
            content.classList.replace('scale-95', 'scale-100');
        }, 10);
    }

    // untuk menutup cv
    function closeCvModal() {
        const modal = document.getElementById('cvModal');
        const content = document.querySelector('#cvModal .bg-white');
        const cvFrame = document.getElementById('cvFrame');
        const noCvMessage = document.getElementById('noCvMessage');

        cvFrame.src = '';

        // Menyembunyikan konten atau pesan jika ditutup
        cvFrame.classList.add('hidden');
        noCvMessage.classList.add('hidden');

        modal.classList.replace('opacity-100', 'opacity-0');
        content.classList.replace('scale-100', 'scale-95');

        // Menyembunyikan modal setelah animasi selesai
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
 </script>


<!-- modal upload porto -->
 <script>
    document.addEventListener('DOMContentLoaded', function() {
        const portfolioBtn = document.getElementById('portfolioBtn');
        const portfolioModal = document.getElementById('portfolioModal');
        const closeModal = document.getElementById('closeModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modalContent = document.getElementById('modalContent');

        // Show modal with fadeIn effect
        portfolioBtn.addEventListener('click', function() {
            portfolioModal.classList.remove('hidden');
            setTimeout(() => {
            modalContent.classList.remove('opacity-0', 'scale-95');
            modalContent.classList.add('opacity-100', 'scale-100');
            }, 10);
        });

        // Close modal with fadeOut effect
        closeModal.addEventListener('click', function() {
            modalContent.classList.remove('opacity-100', 'scale-100');
            modalContent.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
            portfolioModal.classList.add('hidden');
            }, 300); // Match the transition duration
        });

        // Close modal with the "Tutup" button
        closeModalBtn.addEventListener('click', function() {
            closeModal.click();
        });

        // Optionally, close the modal if clicking outside of it
        portfolioModal.addEventListener('click', function(event) {
            if (event.target === portfolioModal) {
            closeModal.click();
            }
        });
        });
 </script>


<!-- untuk menutupi konten tab lain -->
 <script>
    // untuk tab-tab profile
    function showTab(tabId) {
        // Menyembunyikan semua tab konten
        const allTabs = document.querySelectorAll('.tab-content');
        allTabs.forEach(tab => tab.classList.add('hidden'));

        // Menampilkan tab yang dipilih
        const selectedTab = document.getElementById(tabId);
        selectedTab.classList.remove('hidden');
    }
 </script>













@include('General.footer')

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
                        <h2 class="text-2xl font-bold">{{ $worker->user->nama_lengkap }}</h2>
                        <span id="verificationBadge" class="text-blue-500">✔ Verified</span>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="mt-6">
                    <button onclick="showTab('dataDiri')" class="tab-button px-4 py-2 text-gray-600 hover:bg-blue-600 hover:text-white w-full text-left rounded"><i class="bi bi-person-fill me-5"></i>Data Diri</button>
                    <button onclick="showTab('Keahlian')" class="tab-button px-4 py-2 text-gray-600 hover:bg-blue-600 hover:text-white w-full text-left rounded"><i class="bi bi-laptop me-5"></i>Keahlian</button>
                    <button onclick="showTab('portofolio')" class="tab-button px-4 py-2 text-gray-600 hover:bg-blue-600 hover:text-white w-full text-left rounded"><i class="bi bi-folder2-open me-5"></i>Portofolio</button>
                    <button onclick="showTab('HistoryTask')" class="tab-button px-4 py-2 text-gray-600 hover:bg-blue-600 hover:text-white w-full text-left rounded"><i class="bi bi-patch-check me-5"></i>History Task</button>
                </div>
            </div>
        </div>

        <!-- Kolom kanan untuk konten -->
        <div class="p-4 rounded h-full">
            <div class="p-6 bg-white rounded-lg shadow-md h-full">
                
                <!-- Tab 1 (datadiri) -->
                <div id="dataDiri" class="tab-content p-4">
                    <h1 class="text-2xl font-semibold mb-6">Personal Information</h1>

                    <!-- bio -->
                    <div class="flex flex-col gap-4 mb-7">
                        <label class="font-semibold">bio:</label>
                        <input type="#" name="#" value="{{ $worker->user->bio }}" class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-7 ">
                        <!-- Email -->
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Email:</label>
                            <input type="email" name="email" value="{{ $worker->user->email }}" class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed" readonly>
                        </div>

                        <!-- username -->
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">username:</label>
                            <input type="#" name="#" value="{{ $worker->user->username }}" class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed" readonly>
                        </div>

                        <!-- no hp -->
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">No Telp:</label>
                            <input type="text" name="nomor_telepon" value="{{ $worker->user->nomor_telepon }}" class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed" readonly>
                        </div>

                        <!-- alamat -->
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Alamat:</label>
                            <input type="text" name="nomor_telepon" value="{{ $worker->user->nomor_telepon }}" class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed" readonly>
                        </div>

                        <!-- tanggal bergabung -->
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Tgl Bergabung:</label>
                            <input type="string" name="tanggal_bergabung" readonly class="col-span-2 p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600" value="{{ $worker->user->tanggal_bergabung }}" readonly>
                        </div>
                    </div>
                    <hr class="my-5 border-2 rounded-xl">
                    <h1 class="text-2xl font-semibold my-6">Data affiliation</h1>
                    @if(auth()->user()->role == 'admin')
                        @foreach ($data as $item)
                            <div class="flex flex-col gap-4 mb-7">
                                <label class="font-semibold">keahlian affiliate: </label>
                                <div>
                                    @php
                                        $categories = json_decode($item->keahlian_affiliate, true) ?? [];
                                    @endphp
                                    @foreach($categories as $category)
                                        <span
                                            class="inline-block bg-gradient-to-b from-[#1F4482] to-[#2A5DB2] text-white px-3 py-1 rounded-full text-sm mr-2 mb-2">
                                            {{ $category }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-7 ">
                                <div class="flex flex-col gap-4">
                                    <label class="font-semibold">Foto identitas</label>
                                    <img src="{{ asset('storage/' . $item->identity_photo) }}" 
                                    alt="Foto Identitas"
                                    class="w-full h-auto rounded border" />
                                </div>
                                <div class="flex flex-col gap-4">
                                    <label class="font-semibold">Foto bersama identitas</label>
                                    <img src="{{ asset('storage/' . $item->identity_photo) }}" 
                                    alt="Foto Identitas"
                                    class="w-full h-auto rounded border" />
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                
                <!-- Tab Keahlian -->
                <div id="Keahlian" class="tab-content p-4 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-[8fr_1fr] gap-6 ">
                        <div class="flex flex-col gap-4">
                            <h1 class="text-2xl font-semibold mb-6">Skill Information</h1>
                        </div>
                        <div class="flex flex-col gap-4">
                            <button type="button" onclick="openCvModal('{{ asset('storage/' . $worker?->cv) }}')" class="bg-blue-600 text-white px-3 py-1 rounded">
                                Lihat CV
                            </button>
                        </div>                    
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-7 ">
                        <!-- tingkat keahlian -->
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Tingkat keahlian</label>
                            <input type="#" name="#" value="{{ $worker->tingkat_keahlian }}" class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed" readonly>
                        </div>

                        <!-- linkedin -->
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Tautan</label>
                            <input type="#" name="#" value="{{ $worker->linkedin }}" class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed" readonly>
                        </div>

                        <!-- keahlian -->
                        <div class="flex flex-col gap-2">
                            <label class="font-semibold">Keahlian</label>
                            @php
                                $selectedSkills = json_decode($worker->keahlian ?? '[]', true);
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
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 ">
                        <!-- sertifikat -->
                        @foreach ($worker->certifications as $sertifikat)
                            <div class="col-md-4 flex items-center justify-center py-3" data-aos="zoom-in">
                                <button class="btn btn-danger btn-sm absolute top-2 right-7 z-10 bg-red-600 text-white p-2 rounded-full hover:bg-red-700" data-bs-toggle="modal" data-type="sertifikat">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <div class="card h-full w-72 bg-white rounded-lg shadow-lg overflow-hidden">
                                    <div class="card-body p-4 text-center">
                                    <img src="{{ $sertifikat->images->first() ? asset('storage/' . $sertifikat->images->first()->path) : asset('images/placeholder.jpg') }}" class="card-img-top w-full h-48 object-cover" alt="Tidak terbaca">
                                        <h5 class="card-title text-blue-500 text-lg font-semibold"></h5>
                                        <p class="card-text text-sm text-gray-600">{{ $sertifikat->title }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tab portofolio -->
                <div id="portofolio" class="tab-content p-4 hidden">
                    
                </div>

                <!-- History task -->
                <div id="HistoryTask" class="tab-content p-4 hidden">
                    <p>Ini adalah konten untuk tab lain serti</p>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal Preview CV -->
<div id="cvModal" class="fixed z-50 inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white p-6 rounded shadow-lg w-3/4 h-3/4 overflow-auto relative scale-95 transition-transform duration-300">
        <h2 class="text-lg font-bold mb-4">Preview CV</h2>
        
        <!-- Message if no CV -->
        <div id="noCvMessage" class="text-center text-gray-600 hidden">
            Maaf, file tidak tersedia
        </div>

        <!-- Iframe untuk CV -->
        <iframe id="cvFrame" src="" class="w-full h-full rounded border hidden" frameborder="0"></iframe>
    </div>
    <button onclick="closeCvModal()" class="absolute bottom-24 right-48 text-white py-2 px-4 bg-red-600 hover:bg-red-700 rounded">
        Tutup
    </button>
</div>

@include('General.footer')

<script>
    // untuk membuka cv
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
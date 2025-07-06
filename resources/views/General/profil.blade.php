@include('General.header')
<div class="p-4 mt-10">
    <div class="grid grid-cols-1 md:grid-cols-[1fr_3fr] gap-6 min-h-screen">
        <!-- Kolom kiri untuk tab -->
        <div class="p-4 rounded sticky top-16 self-start">
            <div class="p-6 bg-white rounded-lg shadow-md h-auto">
                <div class="flex flex-col items-center gap-4">
                    <label for="profile-pic" class="cursor-pointer">
                        <img id="profile-image" src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('images/default-avatar.png') }}" alt="Profile Picture"
                            class="w-24 h-24 sm:w-32 sm:h-32 rounded-full object-cover border border-gray-300">
                    </label>
                    <div class="text-center">
                        <div class="flex items-center space-x-3">
                            <h2 class="text-2xl font-bold">{{ Auth::user()->nama_lengkap }}</h2>
                            <?php if ($countReviews >= 10 && $avgRating > 4 && $workerProfile?->empowr_affiliate !=1): ?>
                                <img src="assets/images/verif.png" alt="verif" class="w-10 h-10">
                            <?php endif; ?>

                            @if($workerProfile?->empowr_affiliate)
                            <img src="{{ asset('assets/images/Affiliasi.png') }}" alt="Affiliasi" class="w-10 h-10">
                            @endif

                        </div>
                    </div>
                </div>


                <!-- Tabs -->
                <div class="mt-6 space-y-2">
                    <button onclick="showTab('dataDiri')"
                        class="tab-button px-4 py-2 sidebar-item flex items-center p-2 rounded-lg w-full"><i
                            class="bi bi-person-fill me-5 text-lg text-[#1F4482]"></i>Data Diri</button>
                    @if(auth()->user()->role == 'worker')
                    <button onclick="showTab('portofolio')"
                        class="tab-button px-4 py-2 sidebar-item flex items-center p-2 rounded-lg w-full"><i
                            class="bi bi-folder2-open me-5 text-lg text-[#1F4482]"></i>Portofolio</button>
                    <button onclick="showTab('sertifikasi')"
                        class="tab-button px-4 py-2 sidebar-item flex items-center p-2 rounded-lg w-full"><i
                            class="bi bi-award me-5 text-lg text-[#1F4482]"></i>Sertifikasi</button>
                    @endif
                    <button onclick="showTab('HistoryTask')"
                        class="tab-button px-4 py-2 sidebar-item flex items-center p-2 rounded-lg w-full"><i
                            class="bi bi-patch-check me-5 text-lg text-[#1F4482]"></i>History Task</button>
                    <button onclick="showTab('ulasan')"
                        class="tab-button px-4 py-2 sidebar-item flex items-center p-2 rounded-lg w-full"><i
                            class="bi bi-laptop me-5 text-lg text-[#1F4482]"></i>Ulasan</button>
                </div>
            </div>
        </div>
        <!-- Kolom kanan untuk konten -->
        <div class="p-4 rounded h-full">
            <div class="p-6 bg-white rounded-lg shadow-md h-full">

                <!-- Tab 1 (datadiri) -->
                <div id="dataDiri" class="tab-content p-4">
                    <div class="grid grid-cols-1 md:grid-cols-[5fr_1fr] gap-6 items-start">
                        <div class="flex flex-col gap-4">
                            <h1 class="text-2xl font-semibold mb-6">Personal Information</h1>
                            {{-- Isi form lainnya bisa di sini --}}
                        </div>

                        <div class="flex flex-row gap-4 self-start justify-end">
                            <!-- Tombol Lihat CV -->
                            <button type="button"
                                onclick="openCvModal('{{ asset('storage/' . $workerProfile?->cv) }}')"
                                class="bg-[#183E74] hover:bg-[#1a4a91] text-white text-sm sm:text-base px-6 py-2 rounded-md shadow min-w-[140px] flex items-center justify-center">
                                Lihat CV
                            </button>

                            <!-- Tombol Ubah Data Diri -->
                            <button type="button"
                                onclick="openEditModalDataDiri()"
                                class="bg-[#183E74] hover:bg-[#1a4a91] text-white text-sm sm:text-base px-6 py-2 rounded-md shadow min-w-[150px] whitespace-nowrap">
                                Ubah Data Diri
                            </button>
                        </div>
                    </div>



                    <div class="flex flex-col gap-4 mb-7">
                        <label class="font-semibold">Bio</label>
                        <textarea id="bioInput"
                            class="p-2 border rounded w-full bg-gray-100 focus:ring-[#1F4482] focus:border-[#1F4482] cursor-not-allowed"
                            rows="4" placeholder="{{ Auth::user()->bio ?? 'Tulis bio Anda di sini' }}"
                            name="bio" readonly>{{ Auth::user()->bio }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-7 mb-7">
                        <!-- Email -->
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Email</label>
                            <input id="emailInput" type="email" value="{{ Auth::user()->email }}"
                                class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600 cursor-not-allowed"
                                readonly placeholder="Email tidak dapat diedit" name="email">
                        </div>

                        <!-- Username -->
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Username</label>
                            <input id="usernameInput" type="text" value="{{ Auth::user()->username }} "
                                class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600"
                                readonly placeholder="Username tidak dapat diedit" name="username">
                        </div>

                        <!-- No HP -->
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">No Telp</label>
                            <input id="phoneInput" type="text" value="{{ Auth::user()->nomor_telepon }} "
                                class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed"
                                placeholder="Masukkan nomor telepon" name="nomor_telepon" readonly>
                        </div>

                        <!-- Tanggal Bergabung -->
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Tgl Bergabung</label>
                            <input type="text"
                                value="{{ \Carbon\Carbon::parse(Auth::user()->tanggal_bergabung)->format('d F Y') }}"
                                class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600"
                                readonly placeholder="Tanggal bergabung tidak dapat diedit" readonly>
                        </div>
                    </div>

                    <!-- Keahlian -->
                    @if(auth()->user()->role == 'worker')
                    <div class="flex flex-col gap-4 mb-7">
                        <label class="font-semibold">Keahlian</label>
                        <div class="w-full p-2 border rounded bg-gray-50">
                            @php
                            $selectedSkills = json_decode(optional(Auth::user()->workerProfile)->keahlian, true) ?? [];
                            @endphp

                            @if(count($selectedSkills) > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($selectedSkills as $skill)
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                    {{ $skill }}
                                </span>
                                @endforeach
                            </div>
                            @else
                            <span class="text-gray-500">Belum ada keahlian yang dipilih</span>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- LinkedIn -->
                    @if(auth()->user()->role == 'worker')
                    <div class="flex flex-col gap-4 mb-7">
                        <label class="font-semibold">Tautan LinkedIn</label>
                        <input id="linkedinInput" type="text" value="{{ $workerProfile?->linkedin}}"
                            class="p-2 border rounded w-full bg-gray-100 focus:ring-[#1F4482] focus:border-[#1F4482] cursor-not-allowed"
                            placeholder="Masukkan LinkedIn Anda" name="linkedin" readonly>
                    </div>
                    @endif




                    <hr class="border-t-1 border-gray-300 my-7">

                    <div class="grid grid-cols-1 md:grid-cols-[5fr_1fr] gap-6 items-start">
                        <div class="flex flex-col gap-4">
                            <h1 class="text-2xl font-semibold mb-6">Payment Account</h1>
                        </div>
                        <div class="flex flex-row gap-4 self-start justify-end">
                            <button type="button" onclick="openModal('editModalRekening')"
                                class="bg-[#183E74] hover:bg-[#1a4a91] text-white px-4 py-2 rounded shadow">
                                Ubah rekening
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-7">
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Bank</label>
                            <input type="text"
                                class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600"
                                value="{{ strtoupper(Auth::user()->paymentAccount?->bank_name) ?? '-' }}">
                        </div>
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Nama akun Bank</label>
                            <input type="text" readonly
                                class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600"
                                value="{{ strtoupper(Auth::user()->paymentAccount?->bank_account_name) ?? '-' }}">
                        </div>
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Nomor rekening</label>
                            <input type="text"
                                class="p-2 border rounded w-full bg-gray-100 text-gray-600"
                                value="{{ strtoupper(Auth::user()->paymentAccount?->account_number) ?? '-' }}">
                        </div>

                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">E-wallet</label>
                            <input type="text"
                                class="p-2 border rounded w-full bg-gray-100 text-gray-600"
                                value="{{ strtoupper(Auth::user()->paymentAccount?->ewallet_provider) ?? '-' }}">
                        </div>
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Nama akun Ewallet</label>
                            <input type="text" readonly
                                class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600"
                                value="{{ strtoupper(Auth::user()->paymentAccount?->ewallet_account_name) ?? '-' }}">
                        </div>
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Nomor E-wallet</label>
                            <input type="text"
                                class="p-2 border rounded w-full bg-gray-100 text-gray-600"
                                value="{{ strtoupper(Auth::user()->paymentAccount?->wallet_number) ?? '-' }}">
                        </div>
                    </div>
                </div>

                <!-- Tab portofolio -->
                <div id="portofolio" class="tab-content p-4 hidden">
                    @if(auth()->user()->role == 'worker')
                    <button id="portfolioBtn"
                        class="inline-block bg-[#183E74] hover:bg-[#1a4a91] text-white text-sm sm:text-base font-semibold px-8 py-2 rounded-md shadow mb-6">
                        Tambahkan Portofolio
                    </button>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($portofolio as $porto)
                        <div class="flex flex-col gap-4 relative cursor-pointer" x-data="{ openModal: false }">
                            <div class="bg-white rounded shadow-md hover:shadow-lg transition duration-200 overflow-hidden">
                                {{-- Area Gambar (hanya trigger modal preview) --}}
                                <div class="relative" style="height: 180px;">
                                    <div onclick='openPortoModal(@json($porto))' class="cursor-pointer w-full h-full">
                                        <img src="{{ url($porto->images[0]->image) }}" alt="Gambar Portofolio"
                                            class="w-full h-full object-cover rounded-t-md" />
                                    </div>
                                </div>

                                {{-- Konten Deskripsi + Tombol Aksi --}}
                                <div class="p-3 flex justify-between items-start gap-2">
                                    {{-- Kiri: Teks --}}
                                    <div class="flex-1">
                                        <p class="text-blue-600 font-semibold text-base sm:text-lg">{{ $porto->title }}</p>
                                        @php
                                        $descriptionWords = explode(' ', $porto->description);
                                        $shortDescription = implode(' ', array_slice($descriptionWords, 0, 10));
                                        $remainingDescription = count($descriptionWords) > 10 ? '...' : '';
                                        @endphp
                                        <p class="text-gray-500 text-sm">{{ $shortDescription . $remainingDescription }}</p>
                                        <p class="text-xs text-gray-400 mt-1">Durasi: {{ $porto->duration }} hari</p>
                                    </div>

                                    {{-- Kanan: Tombol --}}
                                    <div class="flex flex-col items-end gap-2">
                                        <button onclick='event.stopPropagation(); openEditModal(@json($porto))'
                                            class="bg-blue-500 text-white px-2 py-1 rounded text-xs">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <form id="delete-form-{{ $porto->id }}" action="{{ route('portofolio.delete', $porto->id) }}" method="POST" class="hidden">
                                            @csrf
                                        </form>

                                        <button type="button"
                                            onclick="confirmDelete({{ $porto->id }})"
                                            class="bg-red-500 text-white px-2 py-1 rounded text-xs">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>


                <!-- tab sertifikasi -->
                <div id="sertifikasi" class="tab-content p-4 hidden">
                    @if(auth()->user()->role == 'worker')
                    <button id="openCertificateModal"
                        class="inline-block bg-[#183E74] hover:bg-[#1a4a91] text-white text-sm sm:text-base font-semibold px-8 py-2 rounded-md shadow">
                        Tambah Sertifikat
                    </button>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-5">
                        @foreach ($sertifikasi as $sertifikat)
                        <div class="flex flex-col gap-4">
                            <div class="bg-white rounded shadow-md hover:shadow-lg transition duration-200 overflow-hidden">
                                {{-- Gambar Sertifikat --}}
                                @if($sertifikat->images && count($sertifikat->images) > 0)
                                <div class="relative" style="height: 180px;">
                                    <img src="{{ url($sertifikat->images[0]->image) }}" alt="Gambar Sertifikat"
                                        class="w-full h-full object-cover rounded-t-md" />
                                </div>
                                @endif

                                {{-- Judul Sertifikat + Tombol --}}
                                <div class="p-3 flex justify-between items-start gap-2">
                                    {{-- Judul --}}
                                    <div class="flex-1 text-center">
                                        <p class="text-blue-600 font-semibold text-base sm:text-lg">{{ $sertifikat->title ?? 'Tanpa Judul' }}</p>
                                    </div>

                                    {{-- Tombol Hapus --}}
                                    <div class="flex items-center">
                                        <form id="delete-sertif-{{ $sertifikat->id }}" action="{{ route('sertifikasi.hapusFile', $sertifikat->id) }}" method="POST" class="hidden">
                                            @csrf
                                        </form>
                                        <button type="button"
                                            onclick="confirmDeleteSertif({{ $sertifikat->id }})"
                                            class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>
                                </div>
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
                                    <p class="text-sm text-gray-600">
                                        {!! Str::limit(strip_tags($task->description), 30, '...') !!}
                                    </p>

                                    @if(auth()->user()->role == 'worker')
                                    <p class="text-sm text-gray-400">Client: {{ $task->client->nama_lengkap }}</p>
                                    @else
                                    <p class="text-sm text-gray-400">Worker: {{ $task->worker->user->nama_lengkap }}</p>
                                    @endif

                                    @if ($task->review)
                                    <div class="flex items-center mt-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $task->review->rating ? 'text-yellow-400' : 'text-gray-300' }} fill-current"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path
                                                d="M12 .587l3.668 7.571L24 9.748l-6 5.847 1.417 8.263L12 18.896 4.583 23.858 6 15.595 0 9.748l8.332-1.59z" />
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

                <!-- Rating & Reviews Tab Content -->
                <div id="ulasan" class="tab-content p-4 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <!-- Rating Summary Section -->
                        <div class="md:col-span-1">
                            <h2 class="text-xl font-semibold mb-4">Ulasan</h2>

                            <!-- Overall Rating Card -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                                <h3 class="text-gray-500 text-sm font-medium mb-3">Rating Keseluruhan</h3>

                                <div class="flex items-center mb-4">
                                    @php
                                    $avgRating = $ratingData->avg('rating') ?? 0;
                                    $avgRating = round($avgRating, 1);
                                    $fullStars = floor($avgRating);
                                    $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                                    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                                    @endphp

                                    <span class="text-4xl font-light text-gray-900 mr-3">
                                        {{ number_format($avgRating, 1) }}
                                    </span>

                                    <div class="flex items-center mb-1">
                                        {{-- Full Stars --}}
                                        @for ($i = 0; $i < $fullStars; $i++)
                                            <svg class="w-5 h-5 text-orange-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                            </svg>
                                            @endfor

                                            {{-- Half Star --}}
                                            @if ($hasHalfStar)
                                            <svg class="w-5 h-5 text-orange-400 fill-current" viewBox="0 0 20 20">
                                                <defs>
                                                    <linearGradient id="half-fill">
                                                        <stop offset="50%" stop-color="currentColor" />
                                                        <stop offset="50%" stop-color="#D1D5DB" />
                                                    </linearGradient>
                                                </defs>
                                                <path fill="url(#half-fill)" d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                            </svg>
                                            @endif

                                            {{-- Empty Stars --}}
                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                </svg>
                                                @endfor
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    berdasarkan {{ $countReviews }} ulasan
                                </div>
                            </div>
                            <!-- Rating Breakdown -->
                            @php
                            $labels = [
                            5 => ['label' => 'Sangat Baik', 'color' => 'bg-green-500'],
                            4 => ['label' => 'Baik', 'color' => 'bg-blue-500'],
                            3 => ['label' => 'Cukup', 'color' => 'bg-yellow-400'],
                            2 => ['label' => 'Kurang', 'color' => 'bg-orange-400'],
                            1 => ['label' => 'Sangat Buruk', 'color' => 'bg-red-500'],
                            ];
                            @endphp
                            <div class="space-y-2">
                                @foreach ($breakdown as $star => $data)
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-600 w-20 flex-shrink-0">
                                        {{ $labels[$star]['label'] }}
                                    </span>
                                    <div class="flex-1 mx-3 bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all duration-300 {{ $labels[$star]['color'] }}"
                                            style="width: {{ $data['percentage'] }}%">
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500 w-8">{{ $data['percentage'] }}%</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Reviews List Section -->
                    <div class="md:col-span-2">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Ulasan Pengguna</h3>
                        </div>
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                            <div class="text-gray-400 mb-2">
                                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.477 8-9.999 8a9.954 9.954 0 01-5.383-1.62L3 21l2.622-2.622A9.955 9.955 0 011 12C1 7.582 5.477 4 12 4s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <p class="text-gray-500 text-lg font-medium">Belum ada ulasan</p>
                            <p class="text-gray-400 text-sm mt-1">Ulasan akan muncul setelah tugas selesai</p>
                        </div>
                        @foreach ($ratingData as $data)
                        <div class="space-y-4 mt-4" id="reviews-container">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                                <div class="flex items-start space-x-4">
                                    <img src="{{ asset('storage/' . ($data->user->profile_image ?? 'avatar.png')) }}"
                                        alt="pepek"
                                        class="w-10 h-10 rounded-full object-cover flex-shrink-0 border-2 border-gray-100">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="text-gray-900 font-medium text-sm">
                                                {{ $data->user->nama_lengkap }}
                                            </h4>
                                            <span class="text-xs text-gray-500">
                                                {{ $data->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        @if ($data->rating)
                                        <div class="flex items-center mt-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $data->rating ? 'text-yellow-400' : 'text-gray-300' }} fill-current"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 .587l3.668 7.571L24 9.748l-6 5.847 1.417 8.263L12 18.896 4.583 23.858 6 15.595 0 9.748l8.332-1.59z" />
                                                </svg>
                                                @endfor
                                        </div>
                                        @else
                                        <p class="text-sm text-gray-400 italic mt-2">Belum ada ulasan</p>
                                        @endif
                                        <div class="mb-2">
                                            <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full font-medium">
                                                {{$data->comment}}
                                            </span>
                                        </div>
                                        <p class="text-gray-700 text-sm leading-relaxed"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{--<!-- Load More Button -->
                    @if(count($reviews) >= 10)
                    <div class="text-center mt-6">
                        <button onclick="loadMoreReviews()" 
                                id="load-more-btn"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="load-more-text">Muat Lebih Banyak</span>
                            <svg id="load-more-spinner" class="hidden animate-spin ml-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                    @endif--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<!-- Modal CV -->
<div id="cvModal"
    class="fixed z-50 inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div
        class="relative bg-white p-6 rounded shadow-lg w-11/12 md:w-3/4 h-4/5 overflow-auto scale-95 transition-transform duration-300">
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
<div id="portfolioModal"
    class="fixed inset-0 z-50 bg-gray-900 bg-opacity-50 hidden flex justify-center items-center p-4">
    <div class="bg-white rounded-lg overflow-hidden shadow-lg w-full sm:w-96 p-6 space-y-6 transform opacity-0 scale-95 transition-all duration-300 ease-in-out"
        id="modalContent">
        <div class="flex justify-between items-center">
            <h5 class="text-xl font-semibold text-gray-800" id="portfolioModalLabel">Tambah Portofolio</h5>
        </div>

        <form action="{{ route('profile.updatePortofolio') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body space-y-4">

                <!-- Image Input -->
                <div class="space-y-2">
                    <label for="portfolioImageInput" class="block text-sm font-medium text-gray-700">Gambar
                        Portofolio</label>
                    <input type="file" id="portofolio" name="portofolio[]" multiple
                        class="w-full border border-1 rounded-md focus:ring-blue-500 focus:border-blue-500 p-2">
                </div>


                <!-- Title Input -->
                <div class="space-y-2">
                    <label for="portfolioTitleInput" class="block text-sm font-medium text-gray-700">Judul
                        Portofolio</label>
                    <input type="text" id="portfolioTitleInput" name="title"
                        class="w-full border border-1 rounded-md  focus:ring-blue-500 focus:border-blue-500 p-2" required>
                </div>

                <!-- Description Input -->
                <div class="space-y-2">
                    <label for="portfolioDescriptionInput" class="block text-sm font-medium text-gray-700">Deskripsi
                        Portofolio</label>
                    <textarea id="portfolioDescriptionInput" name="description" rows="4"
                        class="w-full rounded-md border border-1  focus:ring-blue-500 focus:border-blue-500 p-2" required></textarea>
                </div>

                <!-- Duration Input -->
                <div class="space-y-2">
                    <label for="portfolioDurationInput" class="block text-sm font-medium text-gray-700">Durasi
                        Pengerjaan (hari)</label>
                    <input type="number" id="portfolioDurationInput" name="duration"
                        class="w-full  rounded-md border border-1 focus:ring-blue-500 focus:border-blue-500 p-2" required>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 mt-7">
                <button type="submit"
                    class="bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Simpan</button>
                <button type="button" id="closeModal"
                    class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Tutup</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal certifikat -->
<div id="certificateModal"
    class="fixed inset-0 z-50 bg-gray-900 bg-opacity-50 hidden flex justify-center items-center p-4">
    <div class="bg-white rounded-lg overflow-hidden shadow-lg w-full sm:w-96 p-6 space-y-6 transform opacity-0 scale-95 transition-all duration-300 ease-in-out"
        id="certificateModalContent">
        <div class="flex justify-between items-center">
            <h5 class="text-xl font-semibold text-gray-800" id="certificateModalLabel">
                <i class="bi bi-award me-2"></i> Tambah Sertifikat
            </h5>
        </div>

        <form action="{{ route('profile.updateSertifikasi') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body space-y-4">

                <!-- Image Input -->
                <div class="space-y-2">
                    <label for="certificateImageInput" class="block text-sm font-medium text-gray-700">
                        <i class="bi bi-image me-1"></i> Gambar Sertifikat
                    </label>
                    <input type="file" id="certificateImageInput" name="certificate_image"
                        class="w-full border border-1 rounded-md focus:ring-blue-500 focus:border-blue-500 p-2">
                </div>

                <!-- Title Input -->
                <div class="space-y-2">
                    <label for="certificateTitleInput" class="block text-sm font-medium text-gray-700">
                        <i class="bi bi-type me-1"></i> Judul Sertifikat
                    </label>
                    <input type="text" id="certificateTitleInput" name="title_sertifikasi"
                        class="w-full border border-1 rounded-md focus:ring-blue-500 focus:border-blue-500 p-2" required>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 mt-7">
                <button type="submit"
                    class="bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <i class="bi bi-check-lg me-1"></i> Simpan
                </button>
                <button type="button" id="closeCertificateModal"
                    class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <i class="bi bi-x-lg me-1"></i> Tutup
                </button>
            </div>
        </form>
    </div>
</div>


<!-- Modal edit portofolio -->
<!-- Modal -->
<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-xl w-full max-w-3xl relative">
        <h2 class="text-lg font-bold mb-4">Edit Portofolio</h2>
        <form action="{{ route('profile.updatePortofolio') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="portofolio_id" id="modalPortofolioId">

            <!-- Title -->
            <div class="mb-3">
                <label class="block">Judul</label>
                <input type="text" name="title" id="modalTitle" class="w-full border p-2 rounded" required/>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="block">Deskripsi</label>
                <textarea name="description" id="modalDescription" rows="3" class="w-full border p-2 rounded" required></textarea>
            </div>

            <!-- Duration -->
            <div class="mb-3">
                <label class="block">Durasi (hari)</label>
                <input type="number" name="duration" id="modalDuration" class="w-full border p-2 rounded" required/>
            </div>

            <!-- Gambar tersimpan (slider) -->
            <div class="mb-3">
                <label class="block mb-1">Gambar Tersimpan</label>
                <div class="swiper mySwiper relative">
                    <div class="swiper-wrapper" id="modalImageSlider">
                        {{-- Diisi lewat JS --}}
                    </div>
                    <!-- Navigasi Swiper -->
                    <div class="swiper-button-next text-gray-800"></div>
                    <div class="swiper-button-prev text-gray-800"></div>
                    <div class="swiper-pagination mt-2"></div>
                </div>
            </div>

            <!-- Upload baru -->
            <div class="mb-3">
                <label class="block">Upload Gambar Baru</label>
                <input type="file" name="portofolio[]" multiple class="w-full border p-2 rounded">
            </div>

            <!-- Tombol -->
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>


<!-- Modal Preview Portofolio -->
<div id="portoModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-60 flex items-center justify-center">
    <div class="relative bg-white rounded-lg w-full max-w-xl shadow-lg">
        <!-- Tombol close -->
        <button onclick="closePortoModal()"
            class="absolute -top-4 -right-4 bg-white text-gray-800 hover:text-red-600 hover:bg-gray-200 rounded-full w-8 h-8 flex items-center justify-center shadow-md z-50 text-xl">
            &times;
        </button>

        <!-- Swiper image -->
        <div class="swiper mySwiper mb-4 rounded-t-lg overflow-hidden">
            <div class="swiper-wrapper" id="modalSwiperWrapper"></div>
            <div class="swiper-button-next text-gray-800"></div>
            <div class="swiper-button-prev text-gray-800"></div>
        </div>

        <!-- Deskripsi -->
        <div class="p-4 text-center">
            <h2 id="modalPortoTitle" class="text-lg font-bold mb-1"></h2>
            <p id="modalPortoDuration" class="text-sm text-gray-500 mb-1"></p>
            <p id="modalPortoDescription" class="text-sm text-gray-700"></p>
        </div>
    </div>
</div>


<!-- Modal edit data diri -->
<div id="editModalDataDiri" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white w-full max-w-3xl p-6 rounded-lg shadow-lg overflow-y-auto max-h-[90vh] relative">
        <!-- Tombol Close -->
        <button type="button" onclick="closeEditModalDataDiri()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>

        <h2 class="text-xl font-semibold mb-4">Ubah Data Diri</h2>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Input File Biasa -->
            <div class="mb-4">
                <label for="profile_image" class="block font-semibold mb-1">Upload Foto Profil</label>
                <input type="file" name="profile_image" id="profile_image" accept="image/*" class="block w-full border p-2 rounded" onchange="previewPhoto(event)">
            </div>

            <!-- Preview Gambar -->
            <div class="mb-4">
                <img id="photoPreview"
                    src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('images/default-avatar.png') }}"
                    alt="Preview Foto Profil"
                    class="w-32 h-32 object-cover border border-gray-300"> <!-- Tidak pakai rounded-full -->
            </div>




            <!-- Bio -->
            <div class="mb-4">
                <label class="font-semibold">Bio</label>
                <textarea name="bio" rows="3" class="w-full p-2 border rounded bg-gray-100">{{ Auth::user()->bio }}</textarea>
            </div>

            <!-- Nama Lengkap dan Email -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="font-semibold">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ Auth::user()->nama_lengkap }}"
                        class="w-full p-2 border rounded bg-gray-100">
                </div>
                <div>
                    <label class="font-semibold">Email</label>
                    <input type="email" value="{{ Auth::user()->email }}"
                        class="w-full p-2 border rounded bg-gray-100 text-gray-600" readonly>
                </div>
            </div>

            <!-- Username dan Nomor Telepon -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="font-semibold">Username</label>
                    <input type="text" value="{{ Auth::user()->username }}"
                        class="w-full p-2 border rounded bg-gray-100 text-gray-600" readonly>
                </div>
                <div>
                    <label class="font-semibold">No Telp</label>
                    <input type="text" name="nomor_telepon" value="{{ Auth::user()->nomor_telepon }}"
                        class="w-full p-2 border rounded bg-gray-100">
                </div>
            </div>

            <!-- LinkedIn -->
            @if(auth()->user()->role == 'worker')
            <div class="mb-4">
                <label class="font-semibold">Tautan LinkedIn</label>
                <input type="text" name="linkedin" value="{{ $workerProfile?->linkedin }}"
                    class="w-full p-2 border rounded bg-gray-100">
            </div>
            @endif

            <!-- Keahlian -->
            @if(auth()->user()->role == 'worker')
            <div class="flex flex-col gap-4 mb-7">
                <label for="keahlian-select" class="font-semibold">Keahlian</label>

                @php
                // Ambil data keahlian yang sudah disimpan (dalam format array)
                $selectedSkills = json_decode(optional(Auth::user()->keahlian)->keahlian, true) ?? [];

                // Semua opsi keahlian yang tersedia
                $keahlianWorker = [
                "Web Development", "Mobile Development", "Game Development", "Software Engineering", "Frontend Development",
                "Backend Development", "Full Stack Development", "DevOps", "QA Testing", "Automation Testing", "API Integration",
                "WordPress Development", "Data Science", "Machine Learning", "AI Development", "Data Engineering", "Data Entry",
                "SEO", "Content Writing", "Technical Writing", "Blog Writing", "Copywriting", "Scriptwriting", "Proofreading",
                "Translation", "Transcription", "Resume Writing", "Ghostwriting", "Creative Writing", "Social Media Management",
                "Digital Marketing", "Email Marketing", "Affiliate Marketing", "Influencer Marketing", "Community Management",
                "Search Engine Marketing", "Branding", "Graphic Design", "UI/UX Design", "IT Support", "Logo Design",
                "Motion Graphics", "Illustration", "Video Editing", "Video Production", "Animation", "3D Modeling",
                "Video Game Design", "Audio Editing", "Photography", "Photo Editing", "Presentation Design", "Project Management",
                "Virtual Assistant", "Customer Service", "Lead Generation", "Market Research", "Business Analysis",
                "Human Resources", "Event Planning", "Bookkeeping", "Accounting", "Tax Preparation", "Financial Analysis",
                "Legal Advice", "Contract Drafting", "Startup Consulting", "Investment Research", "Real Estate Consulting",
                "Personal Assistant", "Clerical Work", "Data Analysis", "Business Coaching", "Career Coaching", "Life Coaching",
                "Consulting", "Other"
                ];
                @endphp

                <select id="keahlian-select" name="keahlian[]" multiple class="w-full p-2 border rounded">
                    @foreach ($keahlianWorker as $keahlian)
                    <option value="{{ $keahlian }}" {{ in_array($keahlian, $selectedSkills) ? 'selected' : '' }}>
                        {{ $keahlian }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="bg-[#183E74] hover:bg-[#1a4a91] text-white font-semibold px-6 py-2 rounded shadow">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Rekening & E-Wallet -->
<div id="editModalRekening" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white w-full max-w-xl p-6 rounded-xl shadow-lg relative">
        <h2 class="text-xl font-semibold mb-4">Edit Rekening & E-Wallet</h2>

        <form id="editAccountForm" action="{{ route('profile-akunPembayaran.update') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="ewallet_provider" class="block font-medium mb-1">Provider E-Wallet</label>
                <select id="ewallet_provider_select" name="ewallet_provider" class="w-full border p-2 rounded">
                    <option value="">-- Pilih E-Wallet --</option>
                    @foreach(['Gopay','OVO','DANA','ShopeePay','LinkAja','Jenius Pay','Sakuku','iSaku','Paytren','Tidak ada'] as $provider)
                    <option value="{{ $provider }}" @selected(Auth::user()->paymentAccount?->ewallet_provider === $provider)>
                        {{ $provider }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="wallet_number_input" class="block font-medium mb-1">Nomor E-Wallet</label>
                <input type="text" id="wallet_number_input" name="wallet_number"
                    value="{{ Auth::user()->paymentAccount?->wallet_number }}"
                    class="w-full border p-2 rounded" placeholder="0812xxxxxxxx">
            </div>

            <div>
                <label for="ewallet_account_name_input" class="block font-medium mb-1">Nama Akun E-Wallet</label>
                <input type="text" id="ewallet_account_name_input" name="ewallet_account_name"
                    value="{{ Auth::user()->paymentAccount?->ewallet_account_name }}"
                    class="w-full border p-2 rounded" placeholder="Nama lengkap sesuai e-wallet">
            </div>

            <hr class="my-4">

            <div>
                <label for="bank_name_select" class="block font-medium mb-1">Nama Bank</label>
                <select id="bank_name_select" name="bank_name" class="w-full border p-2 rounded">
                    <option value="">-- Pilih Bank --</option>
                    @foreach([
                    'BCA', 'BNI', 'BRI', 'Mandiri', 'CIMB Niaga', 'Danamon', 'Permata', 'BTN',
                    'Maybank', 'OCBC NISP', 'Panin', 'Bank Jago', 'BSI', 'Bank DKI', 'Bank Jabar Banten (BJB)',
                    'Bank Sumut', 'Bank Nagari', 'Bank Aceh', 'Bank Kaltimtara', 'Bank Kalsel', 'Bank Kalteng',
                    'Bank Papua', 'Bank NTB Syariah', 'Bank NTT', 'Bank Sulselbar', 'Bank SulutGo', 'Bank Bengkulu',
                    'Bank Riau Kepri', 'Bank Maluku Malut', 'Bank Lampung', 'Bank Sumsel Babel', 'Tidak ada'
                    ] as $bank)
                    <option value="{{ $bank }}" @selected(Auth::user()->paymentAccount?->bank_name === $bank)>
                        {{ $bank }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="account_number_input" class="block font-medium mb-1">Nomor Rekening</label>
                <input type="text" id="account_number_input" name="account_number"
                    value="{{ Auth::user()->paymentAccount?->account_number }}"
                    class="w-full border p-2 rounded" placeholder="1234567890">
            </div>

            <div>
                <label for="bank_account_name_input" class="block font-medium mb-1">Nama Pemilik Rekening</label>
                <input type="text" id="bank_account_name_input" name="bank_account_name"
                    value="{{ Auth::user()->paymentAccount?->bank_account_name }}"
                    class="w-full border p-2 rounded" placeholder="Nama sesuai buku tabungan">
            </div>

            <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="closeModalEditRekening('editModalRekening')"
                    class="px-4 py-2 rounded border text-gray-700 hover:bg-gray-100">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>

        <button onclick="closeModalEditRekening('editModalRekening')"
            class="absolute top-3 right-4 text-gray-500 hover:text-black text-xl font-bold">
            &times;
        </button>
    </div>
</div>

<!-- ----------------------------------JS BATAS ------------------------------------------------------------------- -->

<!-- Swiper JS -->
<!-- SwiperJS CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
    function confirmDelete(id) {
        event.stopPropagation(); // Supaya tidak trigger modal preview
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data portofolio tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>
<script>
    function confirmDeleteSertif(id) {
        event.stopPropagation(); // prevent klik lainnya
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "File dan judul sertifikat akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-sertif-${id}`).submit();
            }
        });
    }
</script>


<script>
    let swiper;

    function openPortoModal(porto) {
        // Tampilkan modal
        const modal = document.getElementById('portoModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Isi teks
        document.getElementById('modalPortoTitle').textContent = porto.title;
        document.getElementById('modalPortoDuration').textContent = "Durasi: " + porto.duration + " hari";
        document.getElementById('modalPortoDescription').textContent = porto.description;

        // Bersihkan gambar lama
        const wrapper = document.getElementById('modalSwiperWrapper');
        wrapper.innerHTML = '';

        // Tambahkan gambar baru
        porto.images.forEach(img => {
            const slide = document.createElement('div');
            slide.className = 'swiper-slide';
            slide.innerHTML = `
                <img src="${window.location.origin}/${img.image}" 
                     class="w-full max-h-[400px] object-contain rounded-t-lg" />
            `;
            wrapper.appendChild(slide);
        });

        // Destroy jika ada instance swiper sebelumnya
        if (swiper) swiper.destroy();

        // Inisialisasi Swiper ulang
        setTimeout(() => {
            swiper = new Swiper(".mySwiper", {
                loop: true,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        }, 100);
    }

    function closePortoModal() {
        const modal = document.getElementById('portoModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

<!-- modal edit rekening pengguna -->
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }

    function closeModalEditRekening(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
    }
    document.addEventListener('DOMContentLoaded', function() {
        const editAccountForm = document.getElementById('editAccountForm');
        if (editAccountForm) {
            editAccountForm.addEventListener('submit', function(event) {
                const ewalletProvider = document.getElementById('ewallet_provider_select').value;
                const walletNumber = document.getElementById('wallet_number_input').value.trim();
                const bankName = document.getElementById('bank_name_select').value;
                const accountNumber = document.getElementById('account_number_input').value.trim();

                let isValid = true;
                let errorMessage = '';

                // Validasi E-Wallet
                if (ewalletProvider !== '' && ewalletProvider !== 'Tidak ada') {
                    if (walletNumber === '') {
                        isValid = false;
                        errorMessage = 'Nomor E-Wallet tidak boleh kosong jika provider E-Wallet dipilih.';
                    } else if (!/^\d+$/.test(walletNumber)) {
                        isValid = false;
                        errorMessage = 'Nomor E-Wallet hanya boleh berisi angka.';
                    }
                }

                // Validasi Bank (hanya jika validasi E-Wallet sukses)
                if (isValid && bankName !== '' && bankName !== 'Tidak ada') {
                    if (accountNumber === '') {
                        isValid = false;
                        errorMessage = 'Nomor Rekening tidak boleh kosong jika Nama Bank dipilih.';
                    } else if (!/^\d+$/.test(accountNumber)) {
                        isValid = false;
                        errorMessage = 'Nomor Rekening hanya boleh berisi angka.';
                    }
                }

                // Tampilkan alert jika validasi gagal
                if (!isValid) {
                    event.preventDefault(); // Mencegah pengiriman formulir
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: errorMessage,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d33',
                    });
                }
            });
        }
    });
</script>

<!-- Untuk modal edit data diri profile -->
<script>
    function openEditModalDataDiri() {
        document.getElementById('editModalDataDiri').classList.remove('hidden');
    }

    function closeEditModalDataDiri() {
        document.getElementById('editModalDataDiri').classList.add('hidden');
    }


    function previewPhoto(event) {
        const input = event.target;
        const preview = document.getElementById('photoPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>




<!-- modal edit portofolio -->
<script>
    const modal = document.getElementById('editModal');
    const sliderContainer = document.getElementById('modalImageSlider');

    function openEditModal(portofolio) {
        const modal = document.getElementById('editModal');

        // Populate input fields
        document.getElementById('modalPortofolioId').value = portofolio.id;
        document.getElementById('modalTitle').value = portofolio.title;
        document.getElementById('modalDescription').value = portofolio.description;
        document.getElementById('modalDuration').value = portofolio.duration;

        // Clear existing slider content
        sliderContainer.innerHTML = '';

        // Add images to the slider
        if (portofolio.images && portofolio.images.length > 0) {
            const isLastImage = portofolio.images.length === 1; // Check if there's only one image

            portofolio.images.forEach(img => {
                const slide = document.createElement('div');
                slide.classList.add('swiper-slide', 'relative');

                // Conditionally add the delete button or disable it
                let deleteButtonHtml = `
                    <form method="POST" action="/portofolio/image/${img.id}/delete" class="absolute top-1 right-1">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 text-white text-xs px-1 rounded-full hover:bg-red-700 ${isLastImage ? 'opacity-50 cursor-not-allowed' : ''}" ${isLastImage ? 'disabled' : ''}>&times;</button>
                    </form>
                `;

                // If it's the last image, you might even consider not showing the button at all,
                // or showing it disabled with a tooltip explaining why.
                // For simplicity, we'll just disable it here.

                slide.innerHTML = `
                    <img src="/${img.image}" class="max-w-full max-h-64 mx-auto rounded border object-contain" />
                    ${deleteButtonHtml}
                `;
                sliderContainer.appendChild(slide);
            });
        }

        // Show the modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Re-initialize Swiper
        setTimeout(() => {
            new Swiper('.mySwiper', {
                slidesPerView: 1,
                spaceBetween: 10,
                loop: true, // Keep loop if you want it to cycle, but be mindful with single images
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        }, 100);
    }

    function closeModal() {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>



<script>
    const profileUpdateURL = "{{ route('profile.update') }}";
</script>

<script>
    new TomSelect('#keahlian-select', {
        plugins: ['remove_button'],
        placeholder: 'Pilih Kategori',
        persist: false,
        create: false,
        maxItems: null
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const saveButton = document.getElementById('saveButton');

        if (saveButton) {
            saveButton.addEventListener('click', function(e) {
                e.preventDefault();

                const bioInput = document.getElementById('bioInput').value;
                const emailInput = document.getElementById('emailInput').value;
                const usernameInput = document.getElementById('usernameInput').value;
                const phoneInput = document.getElementById('phoneInput').value;
                const skillsInput = document.getElementById('skillsInput').value;
                const keahlianLevelInput = document.getElementById('keahlianLevelInput').value;

                const formData = new FormData();
                formData.append('bio', bioInput);
                formData.append('email', emailInput);
                formData.append('username', usernameInput);
                formData.append('nomor_telepon', phoneInput);
                formData.append('keahlian', skillsInput);
                formData.append('tingkat_keahlian', keahlianLevelInput);

                fetch(profileUpdateURL, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Profile Updated Successfully');
                        }
                    }).catch(error => {
                        console.error('Error updating profile:', error);
                    });
            });
        } else {
            console.warn('Element with ID "saveButton" not found.');
        }
    });
</script>
{{--
<script>
let currentOffset = {{ count($reviews) }};
let isLoading = false;

function loadMoreReviews() {
if (isLoading) return;

isLoading = true;
const loadBtn = document.getElementById('load-more-btn');
const loadText = document.getElementById('load-more-text');
const loadSpinner = document.getElementById('load-more-spinner');

// Show loading state
loadBtn.disabled = true;
loadText.textContent = 'Memuat...';
loadSpinner.classList.remove('hidden');

fetch(`{{ route('profile.reviews.load-more') }}?offset=${currentOffset}`, {
method: 'GET',
headers: {
'X-Requested-With': 'XMLHttpRequest',
'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
}
})
.then(response => response.json())
.then(data => {
if (data.success && data.reviews && data.reviews.length > 0) {
const reviewsContainer = document.getElementById('reviews-container');

data.reviews.forEach(review => {
const reviewElement = createReviewElement(review);
reviewsContainer.appendChild(reviewElement);
});

currentOffset += data.reviews.length;

// Hide load more button if no more reviews
if (data.reviews.length < 10) {
    loadBtn.style.display='none' ;
    }
    } else {
    loadBtn.style.display='none' ;
    }
    })
    .catch(error=> {
    console.error('Error loading more reviews:', error);
    alert('Gagal memuat ulasan. Silakan coba lagi.');
    })
    .finally(() => {
    isLoading = false;
    loadBtn.disabled = false;
    loadText.textContent = 'Muat Lebih Banyak';
    loadSpinner.classList.add('hidden');
    });
    }

    function createReviewElement(review) {
    const div = document.createElement('div');
    div.className = 'bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200';

    div.innerHTML = `
    <div class="flex items-start space-x-4">
        <img src="${review.user_avatar}"
            alt="${review.user_name}"
            class="w-10 h-10 rounded-full object-cover flex-shrink-0 border-2 border-gray-100">

        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-gray-900 font-medium text-sm">
                    ${review.user_name}
                </h4>
                <span class="text-xs text-gray-500">
                    ${review.date}
                </span>
            </div>

            <div class="flex items-center mb-3">
                ${generateStars(review.rating)}
                <span class="ml-2 text-sm text-gray-600">
                    (${review.rating}/5)
                </span>
            </div>

            ${review.task_title ? `
            <div class="mb-2">
                <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full font-medium">
                    Task: ${review.task_title.length > 30 ? review.task_title.substring(0, 30) + '...' : review.task_title}
                </span>
            </div>
            ` : ''}

            <p class="text-gray-700 text-sm leading-relaxed">
                ${review.comment}
            </p>

            <div class="flex items-center text-xs text-gray-500 mt-3">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
                <span>${review.location}</span>
            </div>
        </div>
    </div>
    `;

    return div;
    }

    function generateStars(rating) {
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        const color=i <=rating ? 'text-orange-400' : 'text-gray-300' ;
        stars +=`<svg class="w-4 h-4 ${color} fill-current" viewBox="0 0 20 20">
        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" /></svg>`;
        }
        return stars;
        }
        </script>
        --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const openCertificateModal = document.getElementById('openCertificateModal');
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
                fetch(cvUrl, {
                        method: 'HEAD'
                    })
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
                // const closeModalBtn = document.getElementById('closeModalBtn');
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
                // closeModalBtn.addEventListener('click', function () {
                //     closeModal.click();
                // });

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
            document.addEventListener('DOMContentLoaded', function() {
                // Memastikan tab "Data Diri" yang pertama kali ditampilkan saat halaman dimuat
                showTab('dataDiri');

                // Menambahkan kelas 'active' pada tombol Data Diri saat halaman dimuat

            }); // const dataDiriButton = document.getElementById('dataDiriButton');
            // dataDiriButton.classList.add('active');

            // Fungsi untuk menampilkan tab
            function showTab(tabId) {
                // Menyembunyikan semua tab konten
                const allTabs = document.querySelectorAll('.tab-content');
                allTabs.forEach(tab => tab.classList.add('hidden'));

                // Menampilkan tab yang dipilih
                const selectedTab = document.getElementById(tabId);
                selectedTab.classList.remove('hidden');

                // Mengubah status aktif pada tombol tab
                const allButtons = document.querySelectorAll('.tab-button');
                allButtons.forEach(button => button.classList.remove('active')); // Menghapus kelas active dari semua tombol
                const activeButton = document.querySelector(`button[onclick="showTab('${tabId}')"]`);
                activeButton.classList.add('active'); // Menambahkan kelas active pada tombol yang dipilih
            }

            @if(session('success-update'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('
                success - update ') }}',
                confirmButtonColor: '#3085d6'
            });
            @endif
        </script>
        <script>
            const imageInput = document.getElementById('profile-image-input');
            const profileImage = document.getElementById('profile-image');
            const uploadStatus = document.getElementById('upload-status');

            imageInput.addEventListener('change', async function() {
                const file = this.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('profile_image', file);

                uploadStatus.classList.remove('hidden');
                uploadStatus.textContent = "Uploading...";

                try {
                    const response = await fetch("{{ route('profile.image.update') }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        profileImage.src = data.image_url;
                        uploadStatus.textContent = "Upload berhasil!";
                    } else {
                        uploadStatus.textContent = "Upload gagal.";
                    }

                } catch (error) {
                    uploadStatus.textContent = "Terjadi kesalahan.";
                }

                setTimeout(() => uploadStatus.classList.add('hidden'), 3000);
            });
        </script>
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#3085d6'
                    });
                });
            </script>
            @endif

            @if(session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '{{ session('error') }}',
                        confirmButtonColor: '#d33'
                    });
                });
            </script>
        @endif
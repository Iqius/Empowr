@include('General.header')
<div class="p-4 mt-10">
    <div class="grid grid-cols-1 md:grid-cols-[1fr_3fr] gap-6 min-h-screen">
        <!-- Kolom kiri untuk tab -->
        <div class="p-4 rounded h-full">
            <div class="p-6 bg-white rounded-lg shadow-md h-auto">
                <div class="flex flex-col items-center gap-4">
                    <label for="profile-pic" class="cursor-pointer">
                        <img id="profile-image" src="#" alt="Profile Picture"
                            class="w-24 h-24 sm:w-32 sm:h-32 rounded-full object-cover border border-gray-300">
                    </label>
                    <button id="changeProfilePicButton"
                        class="text-sm text-[#1F4482] font-medium hover:underline mt-1 mb-3">
                        Ubah Foto
                    </button>
                    <div class="text-center">
                        <h2 class="text-2xl font-bold">{{ Auth::user()->nama_lengkap }}</h2>
                        <span id="verificationBadge" class="text-blue-500">✔ Verified</span>
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
                    <div class="grid grid-cols-1 md:grid-cols-[8fr_1fr] gap-6 ">
                        <div class="flex flex-col gap-4">
                            <h1 class="text-2xl font-semibold mb-6">Personal Information</h1>
                        </div>

                        @if(auth()->user()->role == 'worker')
                            <div class="flex flex-col gap-4">
                                <button type="button" onclick="openCvModal('{{ asset('storage/' . $workerProfile?->cv) }}')"
                                    class="inline-block bg-[#183E74] hover:bg-[#1a4a91] text-white text-sm sm:text-base px-15 py-2 rounded-md shadow">
                                    Lihat CV
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Form bagian text input bisa di-edit -->
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf <!-- CSRF Token -->
                        <div class="flex flex-col gap-4 mb-7">
                            <label class="font-semibold">Bio</label>
                            <textarea id="bioInput"
                                class="p-2 border rounded w-full bg-gray-100 focus:ring-[#1F4482] focus:border-[#1F4482]"
                                rows="4" placeholder="{{ Auth::user()->bio ?? 'Tulis bio Anda di sini' }}"
                                name="bio">{{ Auth::user()->bio }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-7 mb-7">
                            <!-- Email -->
                            <div class="flex flex-col gap-4">
                                <label class="font-semibold">Email</label>
                                <input id="emailInput" type="email" value="{{ Auth::user()->email }}"
                                    class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600"
                                    readonly placeholder="Email tidak dapat diedit" name="email">
                            </div>

                            <!-- Username -->
                            <div class="flex flex-col gap-4">
                                <label class="font-semibold">Username</label>
                                <input id="usernameInput" type="text" value="{{ Auth::user()->username }}"
                                    class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600"
                                    readonly placeholder="Username tidak dapat diedit" name="username">
                            </div>

                            <!-- No HP -->
                            <div class="flex flex-col gap-4">
                                <label class="font-semibold">No Telp</label>
                                <input id="phoneInput" type="text" value="{{ Auth::user()->nomor_telepon }}"
                                    class="p-2 border rounded w-full bg-gray-100 cursor-pointer"
                                    placeholder="Masukkan nomor telepon" name="nomor_telepon">
                            </div>

                            <!-- Tanggal Bergabung -->
                            <div class="flex flex-col gap-4">
                                <label class="font-semibold">Tgl Bergabung</label>
                                <input type="text"
                                    value="{{ \Carbon\Carbon::parse(Auth::user()->tanggal_bergabung)->format('d F Y') }}"
                                    class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600"
                                    readonly placeholder="Tanggal bergabung tidak dapat diedit">
                            </div>
                        </div>

                        <!-- Keahlian -->
                        @if(auth()->user()->role == 'worker')
                            <div class="flex flex-col gap-4 mb-7">
                                <label class="font-semibold">Keahlian</label>
                                <select id="keahlianInput"
                                    class="p-2 border rounded w-full bg-gray-100 focus:ring-[#1F4482] focus:border-[#1F4482]"
                                    name="keahlian">
                                    <!-- Placeholder jika data keahlian kosong -->
                                    <option value="" {{ is_null($workerProfile?->keahlian) ? 'selected' : '' }}>
                                        Pilih Keahlian
                                    </option>

                                    <!-- Opsi pilihan yang ada -->
                                    <option value="Web Development" {{ $workerProfile?->keahlian == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                                    <option value="Mobile Development" {{ $workerProfile?->keahlian == 'Mobile Development' ? 'selected' : '' }}>Mobile Development</option>
                                    <option value="Game Development" {{ $workerProfile?->keahlian == 'Game Development' ? 'selected' : '' }}>Game Development</option>
                                    <option value="Software Engineering" {{ $workerProfile?->keahlian == 'Software Engineering' ? 'selected' : '' }}>Software Engineering</option>
                                    <option value="Frontend Development" {{ $workerProfile?->keahlian == 'Frontend Development' ? 'selected' : '' }}>Frontend Development</option>
                                    <option value="Backend Development" {{ $workerProfile?->keahlian == 'Backend Development' ? 'selected' : '' }}>Backend Development</option>
                                    <option value="Full Stack Development" {{ $workerProfile?->keahlian == 'Full Stack Development' ? 'selected' : '' }}>Full Stack Development</option>
                                    <option value="DevOps" {{ $workerProfile?->keahlian == 'DevOps' ? 'selected' : '' }}>
                                        DevOps</option>
                                    <option value="QA Testing" {{ $workerProfile?->keahlian == 'QA Testing' ? 'selected' : '' }}>QA Testing</option>
                                    <option value="Automation Testing" {{ $workerProfile?->keahlian == 'Automation Testing' ? 'selected' : '' }}>Automation Testing</option>
                                    <option value="API Integration" {{ $workerProfile?->keahlian == 'API Integration' ? 'selected' : '' }}>API Integration</option>
                                    <option value="WordPress Development" {{ $workerProfile?->keahlian == 'WordPress Development' ? 'selected' : '' }}>WordPress Development</option>
                                    <option value="Data Science" {{ $workerProfile?->keahlian == 'Data Science' ? 'selected' : '' }}>Data Science</option>
                                    <option value="Machine Learning" {{ $workerProfile?->keahlian == 'Machine Learning' ? 'selected' : '' }}>Machine Learning</option>
                                    <option value="AI Development" {{ $workerProfile?->keahlian == 'AI Development' ? 'selected' : '' }}>AI Development</option>
                                    <option value="Data Engineering" {{ $workerProfile?->keahlian == 'Data Engineering' ? 'selected' : '' }}>Data Engineering</option>
                                    <option value="Data Entry" {{ $workerProfile?->keahlian == 'Data Entry' ? 'selected' : '' }}>Data Entry</option>
                                    <option value="SEO" {{ $workerProfile?->keahlian == 'SEO' ? 'selected' : '' }}>SEO
                                    </option>
                                    <option value="Content Writing" {{ $workerProfile?->keahlian == 'Content Writing' ? 'selected' : '' }}>Content Writing</option>
                                    <option value="Technical Writing" {{ $workerProfile?->keahlian == 'Technical Writing' ? 'selected' : '' }}>Technical Writing</option>
                                    <option value="Blog Writing" {{ $workerProfile?->keahlian == 'Blog Writing' ? 'selected' : '' }}>Blog Writing</option>
                                    <option value="Copywriting" {{ $workerProfile?->keahlian == 'Copywriting' ? 'selected' : '' }}>Copywriting</option>
                                    <option value="Scriptwriting" {{ $workerProfile?->keahlian == 'Scriptwriting' ? 'selected' : '' }}>Scriptwriting</option>
                                    <option value="Proofreading" {{ $workerProfile?->keahlian == 'Proofreading' ? 'selected' : '' }}>Proofreading</option>
                                    <option value="Translation" {{ $workerProfile?->keahlian == 'Translation' ? 'selected' : '' }}>Translation</option>
                                    <option value="Transcription" {{ $workerProfile?->keahlian == 'Transcription' ? 'selected' : '' }}>Transcription</option>
                                    <option value="Resume Writing" {{ $workerProfile?->keahlian == 'Resume Writing' ? 'selected' : '' }}>Resume Writing</option>
                                    <option value="Ghostwriting" {{ $workerProfile?->keahlian == 'Ghostwriting' ? 'selected' : '' }}>Ghostwriting</option>
                                    <option value="Creative Writing" {{ $workerProfile?->keahlian == 'Creative Writing' ? 'selected' : '' }}>Creative Writing</option>
                                    <option value="Social Media Management" {{ $workerProfile?->keahlian == 'Social Media Management' ? 'selected' : '' }}>Social Media Management</option>
                                    <option value="Digital Marketing" {{ $workerProfile?->keahlian == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
                                    <option value="Email Marketing" {{ $workerProfile?->keahlian == 'Email Marketing' ? 'selected' : '' }}>Email Marketing</option>
                                    <option value="Affiliate Marketing" {{ $workerProfile?->keahlian == 'Affiliate Marketing' ? 'selected' : '' }}>Affiliate Marketing</option>
                                    <option value="Influencer Marketing" {{ $workerProfile?->keahlian == 'Influencer Marketing' ? 'selected' : '' }}>Influencer Marketing</option>
                                    <option value="Community Management" {{ $workerProfile?->keahlian == 'Community Management' ? 'selected' : '' }}>Community Management</option>
                                    <option value="Search Engine Marketing" {{ $workerProfile?->keahlian == 'Search Engine Marketing' ? 'selected' : '' }}>Search Engine Marketing</option>
                                    <option value="Branding" {{ $workerProfile?->keahlian == 'Branding' ? 'selected' : '' }}>
                                        Branding</option>
                                    <option value="Graphic Design" {{ $workerProfile?->keahlian == 'Graphic Design' ? 'selected' : '' }}>Graphic Design</option>
                                    <option value="UI/UX Design" {{ $workerProfile?->keahlian == 'UI/UX Design' ? 'selected' : '' }}>UI/UX Design</option>
                                    <option value="Logo Design" {{ $workerProfile?->keahlian == 'Logo Design' ? 'selected' : '' }}>Logo Design</option>
                                    <option value="Motion Graphics" {{ $workerProfile?->keahlian == 'Motion Graphics' ? 'selected' : '' }}>Motion Graphics</option>
                                    <option value="Illustration" {{ $workerProfile?->keahlian == 'Illustration' ? 'selected' : '' }}>Illustration</option>
                                    <option value="Video Editing" {{ $workerProfile?->keahlian == 'Video Editing' ? 'selected' : '' }}>Video Editing</option>
                                    <option value="Video Production" {{ $workerProfile?->keahlian == 'Video Production' ? 'selected' : '' }}>Video Production</option>
                                    <option value="Animation" {{ $workerProfile?->keahlian == 'Animation' ? 'selected' : '' }}>Animation</option>
                                    <option value="3D Modeling" {{ $workerProfile?->keahlian == '3D Modeling' ? 'selected' : '' }}>3D Modeling</option>
                                    <option value="Video Game Design" {{ $workerProfile?->keahlian == 'Video Game Design' ? 'selected' : '' }}>Video Game Design</option>
                                    <option value="Audio Editing" {{ $workerProfile?->keahlian == 'Audio Editing' ? 'selected' : '' }}>Audio Editing</option>
                                    <option value="Photography" {{ $workerProfile?->keahlian == 'Photography' ? 'selected' : '' }}>Photography</option>
                                    <option value="Photo Editing" {{ $workerProfile?->keahlian == 'Photo Editing' ? 'selected' : '' }}>Photo Editing</option>
                                    <option value="Presentation Design" {{ $workerProfile?->keahlian == 'Presentation Design' ? 'selected' : '' }}>Presentation Design</option>
                                    <option value="Project Management" {{ $workerProfile?->keahlian == 'Project Management' ? 'selected' : '' }}>Project Management</option>
                                    <option value="Virtual Assistant" {{ $workerProfile?->keahlian == 'Virtual Assistant' ? 'selected' : '' }}>Virtual Assistant</option>
                                    <option value="Customer Service" {{ $workerProfile?->keahlian == 'Customer Service' ? 'selected' : '' }}>Customer Service</option>
                                    <option value="Lead Generation" {{ $workerProfile?->keahlian == 'Lead Generation' ? 'selected' : '' }}>Lead Generation</option>
                                    <option value="Market Research" {{ $workerProfile?->keahlian == 'Market Research' ? 'selected' : '' }}>Market Research</option>
                                    <option value="Business Analysis" {{ $workerProfile?->keahlian == 'Business Analysis' ? 'selected' : '' }}>Business Analysis</option>
                                    <option value="Human Resources" {{ $workerProfile?->keahlian == 'Human Resources' ? 'selected' : '' }}>Human Resources</option>
                                    <option value="Event Planning" {{ $workerProfile?->keahlian == 'Event Planning' ? 'selected' : '' }}>Event Planning</option>
                                    <option value="Bookkeeping" {{ $workerProfile?->keahlian == 'Bookkeeping' ? 'selected' : '' }}>Bookkeeping</option>
                                    <option value="Accounting" {{ $workerProfile?->keahlian == 'Accounting' ? 'selected' : '' }}>Accounting</option>
                                    <option value="Tax Preparation" {{ $workerProfile?->keahlian == 'Tax Preparation' ? 'selected' : '' }}>Tax Preparation</option>
                                    <option value="Financial Analysis" {{ $workerProfile?->keahlian == 'Financial Analysis' ? 'selected' : '' }}>Financial Analysis</option>
                                    <option value="Legal Advice" {{ $workerProfile?->keahlian == 'Legal Advice' ? 'selected' : '' }}>Legal Advice</option>
                                    <option value="Contract Drafting" {{ $workerProfile?->keahlian == 'Contract Drafting' ? 'selected' : '' }}>Contract Drafting</option>
                                    <option value="Startup Consulting" {{ $workerProfile?->keahlian == 'Startup Consulting' ? 'selected' : '' }}>Startup Consulting</option>
                                    <option value="Investment Research" {{ $workerProfile?->keahlian == 'Investment Research' ? 'selected' : '' }}>Investment Research</option>
                                    <option value="Real Estate Consulting" {{ $workerProfile?->keahlian == 'Real Estate Consulting' ? 'selected' : '' }}>Real Estate Consulting</option>
                                    <option value="Personal Assistant" {{ $workerProfile?->keahlian == 'Personal Assistant' ? 'selected' : '' }}>Personal Assistant</option>
                                    <option value="Clerical Work" {{ $workerProfile?->keahlian == 'Clerical Work' ? 'selected' : '' }}>Clerical Work</option>
                                    <option value="Data Analysis" {{ $workerProfile?->keahlian == 'Data Analysis' ? 'selected' : '' }}>Data Analysis</option>
                                    <option value="Business Coaching" {{ $workerProfile?->keahlian == 'Business Coaching' ? 'selected' : '' }}>Business Coaching</option>
                                    <option value="Career Coaching" {{ $workerProfile?->keahlian == 'Career Coaching' ? 'selected' : '' }}>Career Coaching</option>
                                    <option value="Life Coaching" {{ $workerProfile?->keahlian == 'Life Coaching' ? 'selected' : '' }}>Life Coaching</option>
                                    <option value="Consulting" {{ $workerProfile?->keahlian == 'Consulting' ? 'selected' : '' }}>Consulting</option>
                                    <option value="Other" {{ $workerProfile?->keahlian == 'Other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                            </div>
                        @endif

                        <!-- Tingkat Keahlian -->
                        @if(auth()->user()->role == 'worker')
                            <div class="flex flex-col gap-4 mb-7">
                                <label class="font-semibold">Tingkat Keahlian</label>
                                <select id="keahlianLevelInput"
                                    class="p-2 border rounded w-full bg-gray-100 focus:ring-[#1F4482] focus:border-[#1F4482]"
                                    name="tingkat_keahlian">
                                    <!-- Placeholder jika data tingkat_keahlian kosong -->
                                    <option value="" {{ is_null($workerProfile?->tingkat_keahlian) ? 'selected' : '' }}>
                                        Pilih
                                        Tingkat Keahlian</option>

                                    <!-- Opsi pilihan yang ada -->
                                    <option value="Beginner" {{ $workerProfile?->tingkat_keahlian == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="Intermediate" {{ $workerProfile?->tingkat_keahlian == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="Expert" {{ $workerProfile?->tingkat_keahlian == 'Expert' ? 'selected' : '' }}>
                                        Expert</option>
                                </select>
                            </div>
                        @endif

                        <!-- LinkedIn -->
                        @if(auth()->user()->role == 'worker')
                            <div class="flex flex-col gap-4 mb-7">
                                <label class="font-semibold">Tautan LinkedIn</label>
                                <input id="linkedinInput" type="text" value="{{ $workerProfile?->linkedin}}"
                                    class="p-2 border rounded w-full bg-gray-100 focus:ring-[#1F4482] focus:border-[#1F4482]"
                                    placeholder="Masukkan LinkedIn Anda" name="linkedin">
                            </div>
                        @endif

                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="inline-block bg-[#183E74] hover:bg-[#1a4a91] text-white text-sm sm:text-base font-semibold px-8 py-2 rounded-md shadow">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    <hr class="border-t-1 border-gray-300 my-7">

                    <h1 class="text-2xl font-semibold mb-6">Payment Account</h1>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-7">
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Bank</label>
                            <input type="text" readonly
                                class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600"
                                value="{{ strtoupper(Auth::user()->paymentAccount?->bank_name) ?? '-' }}">
                        </div>
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Nama akun Bank</label>
                            <input type="text" readonly
                                class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600"
                                value="{{ strtoupper(Auth::user()->paymentAccount?->account_name) ?? '-' }}">
                        </div>
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Nomor rekening</label>
                            <input type="text" readonly
                                class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600"
                                value="{{ strtoupper(Auth::user()->paymentAccount?->account_number) ?? '-' }}">
                        </div>

                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">E-wallet</label>
                            <input type="text" readonly
                                class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600"
                                value="{{ strtoupper(Auth::user()->paymentAccount?->ewallet_provider) ?? '-' }}">
                        </div>
                        <div class="flex flex-col gap-4">
                            <label class="font-semibold">Nomor E-wallet</label>
                            <input type="text" readonly
                                class="p-2 border rounded w-full bg-gray-100 cursor-not-allowed text-gray-600"
                                value="{{ strtoupper(Auth::user()->paymentAccount?->wallet_number) ?? '-' }}">
                        </div>
                    </div>
                </div>

                <!-- Tab portofolio -->
                <div id="portofolio" class="tab-content p-4 hidden">
                    @if(auth()->user()->role == 'worker')
                        <button id="portfolioBtn"
                            class="inline-block bg-[#183E74] hover:bg-[#1a4a91] text-white text-sm sm:text-base font-semibold px-8 py-2 rounded-md shadow">Tambahkan
                            Portofolio</button>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 ">
                        <!-- Button to trigger the modal -->
                        @foreach ($portofolio as $porto)
                            <div class="flex flex-col gap-4">
                                <div class="bg-white p-4 rounded shadow-md hover:shadow-lg transition duration-200">
                                    @if($porto->images && count($porto->images) > 0)
                                        <div class="w-full h-40 mb-3">
                                            <img src="{{ asset('storage/' . $porto->images[0]->image) }}"
                                                alt="Gambar Portofolio" class="w-full h-full object-cover rounded-md">
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
                        <button id="openCertificateModal"
                            class="inline-block bg-[#183E74] hover:bg-[#1a4a91] text-white text-sm sm:text-base font-semibold px-8 py-2 rounded-md shadow">
                            Tambah Sertifikat
                        </button>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 ">
                        @foreach ($sertifikasi as $sertifikat)
                            <div class="flex flex-col gap-4">
                                <div class="bg-white p-4 rounded shadow-md hover:shadow-lg transition duration-200">
                                    @if($sertifikat->images && count($sertifikat->images) > 0)
                                        <div class="w-full h-40 mb-3">
                                            <img src="{{ asset('storage/' . $sertifikat->images[0]->image) }}"
                                                alt="Gambar Sertifikat" class="w-full h-full object-cover rounded-md">
                                        </div>
                                    @endif
                                    <!-- Menambahkan text-center untuk membuat teks rata tengah -->
                                    <p class="text-blue-600 font-semibold text-base sm:text-lg text-center">
                                        {{ $sertifikat->title }}
                                    </p>
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

                <div id="ulasan" class="tab-content p-4 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 ">
                        <div class="flex flex-col gap-4">
                            <h2 class="text-xl font-semibold mb-4">Ulasan</h2>

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
                        class="w-full border border-1 rounded-md  focus:ring-blue-500 focus:border-blue-500 p-2">
                </div>

                <!-- Description Input -->
                <div class="space-y-2">
                    <label for="portfolioDescriptionInput" class="block text-sm font-medium text-gray-700">Deskripsi
                        Portofolio</label>
                    <textarea id="portfolioDescriptionInput" name="description" rows="4"
                        class="w-full rounded-md border border-1  focus:ring-blue-500 focus:border-blue-500 p-2"></textarea>
                </div>

                <!-- Duration Input -->
                <div class="space-y-2">
                    <label for="portfolioDurationInput" class="block text-sm font-medium text-gray-700">Durasi
                        Pengerjaan</label>
                    <input type="text" id="portfolioDurationInput" name="duration"
                        class="w-full  rounded-md border border-1 focus:ring-blue-500 focus:border-blue-500 p-2">
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

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
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
                        class="w-full border border-1 rounded-md focus:ring-blue-500 focus:border-blue-500 p-2">
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








<!-- ----------------------------------JS BATAS ------------------------------------------------------------------- -->

<script>
    document.getElementById('saveButton').addEventListener('click', function (e) {
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

        // Additional fields if needed, like file uploads
        // formData.append('profile_image', document.getElementById('profile_image').files[0]);

        fetch('{{ route('profile.update') }}', {
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
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openCertificateModal = document.getElementById('openCertificateModal'); // Pastikan ID ini sesuai dengan tombol
        const certificateModal = document.getElementById('certificateModal');
        const closeCertificateModal = document.getElementById('closeCertificateModal');
        const modalContent = document.getElementById('certificateModalContent');

        // Show modal with fadeIn effect
        openCertificateModal.addEventListener('click', function () {
            certificateModal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('opacity-0', 'scale-95');
                modalContent.classList.add('opacity-100', 'scale-100');
            }, 10);
        });

        // Close modal with fadeOut effect
        closeCertificateModal.addEventListener('click', function () {
            modalContent.classList.remove('opacity-100', 'scale-100');
            modalContent.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                certificateModal.classList.add('hidden');
            }, 300); // Match the transition duration
        });

        // Optionally, close the modal if clicking outside of it
        certificateModal.addEventListener('click', function (event) {
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
    document.addEventListener('DOMContentLoaded', function () {
        const portfolioBtn = document.getElementById('portfolioBtn');
        const portfolioModal = document.getElementById('portfolioModal');
        const closeModal = document.getElementById('closeModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modalContent = document.getElementById('modalContent');

        // Show modal with fadeIn effect
        portfolioBtn.addEventListener('click', function () {
            portfolioModal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('opacity-0', 'scale-95');
                modalContent.classList.add('opacity-100', 'scale-100');
            }, 10);
        });

        // Close modal with fadeOut effect
        closeModal.addEventListener('click', function () {
            modalContent.classList.remove('opacity-100', 'scale-100');
            modalContent.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                portfolioModal.classList.add('hidden');
            }, 300); // Match the transition duration
        });

        // Close modal with the "Tutup" button
        closeModalBtn.addEventListener('click', function () {
            closeModal.click();
        });

        // Optionally, close the modal if clicking outside of it
        portfolioModal.addEventListener('click', function (event) {
            if (event.target === portfolioModal) {
                closeModal.click();
            }
        });
    });
</script>


<!-- untuk menutupi konten tab lain -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Memastikan tab "Data Diri" yang pertama kali ditampilkan saat halaman dimuat
        showTab('dataDiri');

        // Menambahkan kelas 'active' pada tombol Data Diri saat halaman dimuat
        const dataDiriButton = document.getElementById('dataDiriButton');
        dataDiriButton.classList.add('active');
    });

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
</script>













@include('General.footer')
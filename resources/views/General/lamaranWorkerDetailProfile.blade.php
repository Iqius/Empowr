@include('General.header')
<div class="p-4 mt-10">
    <div class="grid grid-cols-1 md:grid-cols-[1fr_3fr] gap-6 min-h-screen">
        <!-- Kolom kiri untuk tab -->
        <div class="p-4 rounded h-full">
            <div class="p-6 bg-white rounded-lg shadow-md h-auto">
                <div class="flex flex-col items-center gap-4">
                    <label for="profile-pic" class="cursor-pointer">
                        <img id="profile-image" src="#" alt="Profile Picture" class="w-24 h-24 sm:w-32 sm:h-32 rounded-full object-cover border border-gray-300">
                    </label>
                    <div class="text-center">
                        <div class="flex items-center space-x-3">
                            <h2 class="text-2xl font-bold">{{ $worker->user->nama_lengkap }}</h2>
                                {{-- <?php if ($countReviews > 10 && $avgRating > 4): ?>
                                    <img src="assets/images/verif.png" alt="verif" class="w-10 h-10">
                                <?php endif; ?> --}}

                            <img src="assets/images/Affiliasi.png"  alt="Affiliasi" class="w-10 h-10">
                        </div>
                    </div>
                </div>


                <!-- Tabs -->
                <div class="mt-6 space-y-2">
                    <button onclick="showTab('dataDiri')"
                        class="tab-button px-4 py-2 sidebar-item flex items-center p-2 rounded-lg w-full"><i
                            class="bi bi-person-fill me-5 text-lg text-[#1F4482]"></i>Data Diri</button>
                    <button onclick="showTab('portofolio')"
                        class="tab-button px-4 py-2 sidebar-item flex items-center p-2 rounded-lg w-full"><i
                            class="bi bi-folder2-open me-5 text-lg text-[#1F4482]"></i>Portofolio</button>
                    <button onclick="showTab('sertifikasi')"
                        class="tab-button px-4 py-2 sidebar-item flex items-center p-2 rounded-lg w-full"><i
                            class="bi bi-award me-5 text-lg text-[#1F4482]"></i>Sertifikasi</button>
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
                                    'game_dev' => 'Game Development',
                                    'software_eng' => 'Software Engineering',
                                    'frontend' => 'Frontend Development',
                                    'backend' => 'Backend Development',
                                    'fullstack' => 'Full Stack Development',
                                    'devops' => 'DevOps',
                                    'qa' => 'QA Testing',
                                    'automation' => 'Automation Testing',
                                    'api_integration' => 'API Integration',
                                    'wordpress' => 'WordPress Development',
                                    'data_sci' => 'Data Science',
                                    'ml' => 'Machine Learning',
                                    'ai' => 'AI Development',
                                    'data_eng' => 'Data Engineering',
                                    'data_entry' => 'Data Entry',
                                    'seo' => 'SEO',
                                    'content_writing' => 'Content Writing',
                                    'technical_writing' => 'Technical Writing',
                                    'blog_writing' => 'Blog Writing',
                                    'copywriting' => 'Copywriting',
                                    'scriptwriting' => 'Scriptwriting',
                                    'proofreading' => 'Proofreading',
                                    'translation' => 'Translation',
                                    'transcription' => 'Transcription',
                                    'resume_writing' => 'Resume Writing',
                                    'ghostwriting' => 'Ghostwriting',
                                    'creative_writing' => 'Creative Writing',
                                    'sosmed' => 'Social Media Management',
                                    'digital_marketing' => 'Digital Marketing',
                                    'email_marketing' => 'Email Marketing',
                                    'affiliate_marketing' => 'Affiliate Marketing',
                                    'influencer' => 'Influencer Marketing',
                                    'community_mgmt' => 'Community Management',
                                    'sem' => 'Search Engine Marketing',
                                    'branding' => 'Branding',
                                    'graphic_design' => 'Graphic Design',
                                    'uiux' => 'UI/UX Design',
                                    'logo_design' => 'Logo Design',
                                    'motion_graphics' => 'Motion Graphics',
                                    'illustration' => 'Illustration',
                                    'video_editing' => 'Video Editing',
                                    'video_production' => 'Video Production',
                                    'animation' => 'Animation',
                                    '3d_modeling' => '3D Modeling',
                                    'game_design' => 'Video Game Design',
                                    'audio_editing' => 'Audio Editing',
                                    'photography' => 'Photography',
                                    'photo_editing' => 'Photo Editing',
                                    'presentation' => 'Presentation Design',
                                    'project_mgmt' => 'Project Management',
                                    'virtual_assist' => 'Virtual Assistant',
                                    'customer_service' => 'Customer Service',
                                    'lead_gen' => 'Lead Generation',
                                    'market_research' => 'Market Research',
                                    'business_analysis' => 'Business Analysis',
                                    'hr' => 'Human Resources',
                                    'event_plan' => 'Event Planning',
                                    'bookkeeping' => 'Bookkeeping',
                                    'accounting' => 'Accounting',
                                    'tax' => 'Tax Preparation',
                                    'finance_analysis' => 'Financial Analysis',
                                    'legal_advice' => 'Legal Advice',
                                    'contract' => 'Contract Drafting',
                                    'startup' => 'Startup Consulting',
                                    'investment' => 'Investment Research',
                                    'real_estate' => 'Real Estate Consulting',
                                    'personal_assist' => 'Personal Assistant',
                                    'clerical' => 'Clerical Work',
                                    'data_analysis' => 'Data Analysis',
                                    'business_coaching' => 'Business Coaching',
                                    'career_coaching' => 'Career Coaching',
                                    'life_coaching' => 'Life Coaching',
                                    'consulting' => 'Consulting',
                                    'other' => 'Other',
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
                </div>

                

<!-- ----------------------------------JS BATAS ------------------------------------------------------------------- -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const saveButton = document.getElementById('saveButton');

        if (saveButton) {
            saveButton.addEventListener('click', function (e) {
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
        } else {
            console.warn('Element with ID "saveButton" not found.');
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openCertificateModal = document.getElementById('openCertificateModal'); 
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
        // const closeModalBtn = document.getElementById('closeModalBtn');
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
        // closeModalBtn.addEventListener('click', function () {
        //     closeModal.click();
        // });

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

    });        // const dataDiriButton = document.getElementById('dataDiriButton');
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
</script>

@include('General.footer')
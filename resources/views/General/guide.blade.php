@include('General.header')
<div class="p-4 mt-10">
    <div class="grid grid-cols-1 md:grid-cols-[1fr_3fr] gap-6 min-h-screen">
        <!-- Kolom kiri untuk tab -->
        <div class="p-4 rounded h-full">
            <div class="p-6 bg-white rounded-lg shadow-md h-auto">
                <div class="flex flex-col gap-4">
                    <h1 class="text-2xl font-semibold mb-6">Petunjuk Penggunaan Empowr</h1>
                </div>
                <!-- Tabs -->
                <div class="space-y-2">
                    <button onclick="showTab('petunjukUmum')"
                        class="tab-button px-4 py-2 sidebar-item flex items-center p-2 rounded-lg w-full">
                        <i class="fa-solid fa-book me-5 text-lg text-[#1F4482]"></i>Petunjuk Umum
                    </button>
                    <button onclick="showTab('sebagaiWorker')"
                        class="tab-button px-4 py-2 sidebar-item flex items-center p-2 rounded-lg w-full">
                        <i class="fa-solid fa-user me-5 text-lg text-[#1F4482]"></i>Sebagai Worker
                    </button>
                    <button onclick="showTab('sebagaiClient')"
                        class="tab-button px-4 py-2 sidebar-item flex items-center p-2 rounded-lg w-full">
                        <i class="fa-solid fa-user me-5 text-lg text-[#1F4482]"></i>Sebagai Client
                    </button>
                    <button onclick="showTab('caraKerja')"
                        class="tab-button px-4 py-2 sidebar-item flex items-center p-2 rounded-lg w-full">
                        <i class="fa-solid fa-handshake me-5 text-lg text-[#1F4482]"></i>Cara Kerja
                    </button>
                    <button onclick="showTab('pertanyaanUmum')"
                        class="tab-button px-4 py-2 sidebar-item flex items-center p-2 rounded-lg w-full">
                        <i class="fa-solid fa-question-circle me-5 text-lg text-[#1F4482]"></i>Pertanyaan Umum
                    </button>
                    <button onclick="showTab('tentangArbitrase')"
                        class="tab-button px-4 py-2 sidebar-item flex items-center p-2 rounded-lg w-full">
                        <i class="fa-solid fa-gavel me-5 text-lg text-[#1F4482]"></i>Tentang Arbitrase
                    </button>
                    <button onclick="showTab('pricing')"
                        class="tab-button px-4 py-2 sidebar-item flex items-center p-2 rounded-lg w-full">
                        <i class="fa-solid fa-tags me-5 text-lg text-[#1F4482]"></i>Pricing
                    </button>
                </div>
            </div>

        </div>
        <!-- Kolom kanan untuk konten -->
        <div class="p-4 rounded h-full">
            <div class="p-6 bg-white rounded-lg shadow-md h-full">

                <div id="petunjukUmum" class="tab-content p-4">
                    <div class="flex flex-col gap-4 mb-6">
                        <h1 class="text-2xl font-semibold">Apa itu Empowr?</h1>
                        <p class="text-left text-gray-600 text-sm leading-relaxed">
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,
                            gigasm fărotum kros mei. Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik,
                            ultrassa prens vărade,
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,

                        </p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition"
                            data-aos="fade-up">
                            <div class="flex justify-center mb-4"> <span
                                    class="material-icons bg-[#1F4482] text-white p-4 rounded-full text-4xl">
                                    rocket_launch
                                </span>
                            </div>
                            <h3 class="text-center text-lg font-semibold text-gray-900 mb-2">Memulai</h3>
                            <p class="text-center text-gray-600 text-sm leading-relaxed">
                                Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,
                                gigasm fărotum kros mei.
                            </p>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition"
                            data-aos="fade-up">
                            <div class="flex justify-center mb-4">
                                <span
                                    class="material-icons bg-[#1F4482] text-white p-4 rounded-full text-4xl">person</span>
                            </div>
                            <h3 class="text-center text-lg font-semibold text-gray-900 mb-2">Pilih Role </h3>
                            <p class="text-center text-gray-600 text-sm leading-relaxed">
                                Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,
                                gigasm fărotum kros mei.
                            </p>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition"
                            data-aos="fade-up">
                            <div class="flex justify-center mb-4">
                                <span
                                    class="material-icons bg-[#1F4482] text-white p-4 rounded-full text-4xl">paid</span>
                            </div>
                            <h3 class="text-center text-lg font-semibold text-gray-900 mb-2">Transaksi</h3>
                            <p class="text-center text-gray-600 text-sm leading-relaxed">
                                Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,
                                gigasm fărotum kros mei.
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row justify-center items-start gap-6 mb-12" data-aos="fade-up">
                        <div class="flex justify-center md:justify-end md:w-1/2">
                            <img src="assets/images/Landing Page 2.png" alt="Client working with Empower"
                                class="w-full h-auto object-cover">
                        </div>
                        <div class="text-left md:w-1/2">
                            <h3 class="text-[#252525] text-2xl font-semibold mb-4">Kenapa Harus Kami?</h3>
                            <ul class="text-gray-600 text-sm sm:text-base leading-relaxed mb-6">
                                <li class="mb-2">1. Lorem ipsum eurologi vatapōde krotāvis provis</li>
                                <li class="mb-2">2. Lorem ipsum eurologi vatapōde krotāvis provis</li>
                                <li class="mb-2">3. Lorem ipsum eurologi vatapōde krotāvis provis</li>
                                <li class="mb-2">4. Lorem ipsum eurologi vatapōde krotāvis provis</li>
                                <li class="mb-2">5. Lorem ipsum eurologi vatapōde krotāvis provis</li>
                                <li class="mb-2">6. Lorem ipsum eurologi vatapōde krotāvis provis</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="sebagaiWorker" class="tab-content p-4 hidden">
                    <div class="flex flex-col gap-4 mb-6">
                        <h1 class="text-2xl font-semibold">Sebagai Worker</h1>
                        <p class="text-left text-gray-600 text-sm leading-relaxed">
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,
                            gigasm fărotum kros mei. Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik,
                            ultrassa prens vărade,
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,

                        </p>
                    </div>
                </div>
                <div id="sebagaiClient" class="tab-content p-4 hidden">
                    <div class="flex flex-col gap-4 mb-6">
                        <h1 class="text-2xl font-semibold">Sebagai Client</h1>
                        <p class="text-left text-gray-600 text-sm leading-relaxed">
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,
                            gigasm fărotum kros mei. Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik,
                            ultrassa prens vărade,
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,

                        </p>
                    </div>
                </div>
                <div id="caraKerja" class="tab-content p-4 hidden">
                    <div class="flex flex-col gap-4 mb-6">
                        <h1 class="text-2xl font-semibold">Cara Kerja Layanan Kami</h1>
                        <p class="text-left text-gray-600 text-sm leading-relaxed">
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,
                            gigasm fărotum kros mei. Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik,
                            ultrassa prens vărade,
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,

                        </p>
                    </div>
                </div>
                <div id="pertanyaanUmum" class="tab-content p-4 hidden">Isi Pertanyaan Umum...</div>
                <div id="tentangArbitrase" class="tab-content p-4 hidden">
                    <div class="flex flex-col gap-4 mb-6">
                        <h1 class="text-2xl font-semibold">Tentang Arbitrase</h1>
                        <p class="text-left text-gray-600 text-sm leading-relaxed">
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,
                            gigasm fărotum kros mei. Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik,
                            ultrassa prens vărade,
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,

                        </p>
                    </div>
                </div>
                <div id="pricing" class="tab-content p-4 hidden">
                    <div class="flex flex-col gap-4 mb-6">
                        <h1 class="text-2xl font-semibold">Tentang Pricing</h1>
                        <p class="text-left text-gray-600 text-sm leading-relaxed">
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,
                            gigasm fărotum kros mei. Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik,
                            ultrassa prens vărade,
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,
                            Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade,

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- untuk menutupi konten tab lain -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Memastikan tab "Data Diri" yang pertama kali ditampilkan saat halaman dimuat
        showTab('petunjukUmum');

        // Menambahkan kelas 'active' pada tombol Data Diri saat halaman dimuat
        const petunjukUmumButton = document.getElementById('petunjukUmumButton');
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
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
                            Empowr merupakan sebuah web aplikasi layanan yang bergerak di bidang <span
                                class="italic">outsourcing</span>.
                            Empowr menyediakan wadah bagi para <span class="italic">client</span> untuk mendelegasikan
                            tugasnya kepada pihak lain sekaligus mencari dan mempromosikan tugasnya pada Empowr.
                            Empowr juga menjadi wadah bagi para <span class="italic">worker</span> untuk mencari
                            pekerjaan/tugas yang tepat untuk mereka kerjakan dan mencari pendapatan melalui pengerjaan
                            delegasi tugas oleh <span class="italic">client</span>.
                        </p>
                        <p class="text-left text-gray-600 text-sm leading-relaxed">
                            Empowr menjadi dan menyediakan layanan penengah transaksi antara <span
                                class="italic">client</span> dengan <span class="italic">worker</span>,
                            dengan begitu pengguna akan merasa aman dan nyaman karena dinaungi langsung oleh pihak
                            Empowr.
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
                                Anda ingin mendelegasikan tugas kepada pihak lain(client) atau anda ingin mencari tugas
                                yang ingin anda kerjakan sesuai kemampuan sekaligus mencari pendapatan(worker).
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
                                Daftarkanlah data diri anda ke Empowr, Pilihla role sesuai bisnis apa yang ingin anda
                                lakukan. Terdapat dua role, yakni Client dan Worker
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
                                Mulailah melakukan proses bisnis sesuai dengan role yang anda pilih, dan transaksi tugas
                                dengan pihak lain.
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row items-center gap-6 mb-12" data-aos="fade-up">
                        <div class="flex justify-center  md:justify-end md:w-1/3">
                            <img src="assets/images/Ilust1.png" alt="Client working with Empower"
                                class="w-full h-auto object-cover">
                        </div>
                        <div class="text-left ">
                            <h3 class="text-[#252525] text-2xl font-semibold mb-4">Kenapa Harus Kami?</h3>
                            <ul class="text-gray-600 text-sm sm:text-base leading-relaxed">
                                <li class="mb-2">
                                    <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl p-4 w-full shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                                        data-aos="fade-up">
                                        <div>
                                            <p class="text-lg font-semibold text-white">
                                                Dapat dengan mudah mencari tugas
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl p-4 w-full shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                                        data-aos="fade-up">
                                        <div>
                                            <p class="text-lg font-semibold text-white">
                                                Alur transaksi dan aturan yang mudah dipahami
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl p-4 w-full shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                                        data-aos="fade-up">
                                        <div>
                                            <p class="text-lg font-semibold text-white">
                                                Log aktivitas transaksi transaparan antara kedua belah pihak
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl p-4 w-full shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                                        data-aos="fade-up">
                                        <div>
                                            <p class="text-lg font-semibold text-white">
                                                Terdapat jaminan worker berkategori verified dan mitra Empowr
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl p-4 w-full shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                                        data-aos="fade-up">
                                        <div>
                                            <p class="text-lg font-semibold text-white">
                                                Terdapat admin Empowr yang terhubung langsung dengan pengguna
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl p-4 w-full shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                                        data-aos="fade-up">
                                        <div>
                                            <p class="text-lg font-semibold text-white">
                                                Layanan arbitrase yang diaudit langsung oleh admin Empowr
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl p-4 w-full shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                                        data-aos="fade-up">
                                        <div>
                                            <p class="text-lg font-semibold text-white">
                                                Memiliki banyak opsi metode pembayaran
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl p-4 w-full shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                                        data-aos="fade-up">
                                        <div>
                                            <p class="text-lg font-semibold text-white">
                                                Keamanan data terjamin
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="sebagaiWorker" class="tab-content p-4 hidden">
                    <div class="flex flex-col gap-4 mb-6">
                        <h1 class="text-2xl font-semibold">Sebagai Worker</h1>
                        <p class="text-left text-gray-600 text-sm leading-relaxed mb-6">
                            Jika anda merupakan seorang pekerja yang memiliki kemampuan yang memenuhi kebutuhan client,
                            anda dapat memiliih role sebagai worker. Empowr membantu Anda menemukan peluang kerja
                            terbaik dengan mudah. Apakah Anda mencari tugas
                            paruh waktu, atau lepas, kami menghubungkan Anda dengan klien-klien terbaik.
                        </p>

                        <h1 class="text-2xl font-semibold">Apa Saja Yang Dapat Anda Lakukan</h1>
                        <div class="flex flex-col gap-8 mb-12">
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition flex items-center gap-4"
                                data-aos="fade-up">
                                <div>
                                    <span class="material-icons bg-[#1F4482] text-white p-4 rounded-full text-4xl">
                                        pageview
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Eksplorasi Tugas</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Anda dapat mencari dan mengeksplorasi tugas yang ingin anda kerjakan sesuai
                                        kemampuan sekaligus
                                        mencari
                                        pendapatan(worker). Kami menyediakan banyak kategori tugas yang dapat dikerjakan
                                        dari jarak jauh.
                                    </p>
                                </div>
                            </div>

                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition flex items-center gap-4"
                                data-aos="fade-up">
                                <div>
                                    <span class="material-icons bg-[#1F4482] text-white p-4 rounded-full text-4xl">
                                        input
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Melamar Tugas</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Setelah anda menemukan tugas yang tepat, anda dapat melamar untuk mengerjakan
                                        tugas tersebut. Anda juga dapat melengkapi data diri, CV, portofolio, dan
                                        sertifikat yang dimiliki sebagai bahan pertimbangan client untuk hire anda
                                        ketugasnya.
                                    </p>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition flex items-center gap-4"
                                data-aos="fade-up">
                                <div>
                                    <span class="material-icons bg-[#1F4482] text-white p-4 rounded-full text-4xl">
                                        price_change
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Negosiasi Harga Bayaran</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Jika harga bayaran yang ditawarkan oleh client tidak sesuai menurutmu. Anda
                                        dapat
                                        melakukan negosiasi harga dengan client pada saat melamar tugas, dengan
                                        mengajukan harga yang anda mau,
                                        client akan memulai berkomunikasi denganmu jika ada tindakan lanjut terkait
                                        penetapan harga bayaran.
                                    </p>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition flex items-center gap-4"
                                data-aos="fade-up">
                                <div>
                                    <span class="material-icons bg-[#1F4482] text-white p-4 rounded-full text-4xl">
                                        <span class="material-symbols-outlined">
                                            <span class="material-symbols-outlined">
                                                currency_exchange
                                            </span>
                                        </span>
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Transaksi Pengerjaan Tugas</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Setelah anda diterima oleh client untuk mengerjakan tugasnya, anda mengerjakan
                                        tugas yang diberikan oleh client sesuai dengan perjanjian, spesifikasi, harga,
                                        dan
                                        jangka waktu yang disepakati kedua belah pihak. Selama transaksi berlangsung,
                                        anda akan mencatat progres yang sedang dikerjakan, dan akan menjadi log
                                        aktivitas transaksi.
                                    </p>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition flex items-center gap-4"
                                data-aos="fade-up">
                                <div>
                                    <span class="material-icons bg-[#1F4482] text-white p-4 rounded-full text-4xl">
                                        <span class="material-symbols-outlined">
                                            <span class="material-symbols-outlined">
                                                payments
                                            </span>
                                        </span>
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Menerima Bayaran</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Saat tugas yang anda kerjakan sudah selesai dan diberikan kepada client. client
                                        akan mengkonfirmasi apakah pengerjaan telah selesai atau belum. Jika
                                        dikonfirmasi selesai, maka anda akan dapat menerima bayaran pengerjaan tugas.
                                        Bayaran akan masuk ke saldo e-wallet yang anda punya, e-wallet dapat dilakukan
                                        withdraw ke e-wallet eksternal.
                                    </p>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition flex items-center gap-4"
                                data-aos="fade-up">
                                <div>
                                    <span class="material-icons bg-[#1F4482] text-white p-4 rounded-full text-4xl">
                                        <span class="material-symbols-outlined">
                                            star
                                        </span>
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Memiliki Rating Akun</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Anda juga akan mendapatkan rating dan ulasan dari client pada saat pengerjaan
                                        tugas selesai. Rating dan ulasan akan dicatat ke profil anda, dan akan menjadi
                                        catatan untuk kualitas kemampuan yang anda punya.
                                    </p>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition flex items-center gap-4"
                                data-aos="fade-up">
                                <div>
                                    <span class="material-icons bg-[#1F4482] text-white p-4 rounded-full text-4xl">
                                        <span class="material-symbols-outlined">
                                            how_to_reg
                                        </span>
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Bergabung Menjadi Afiliasi
                                        Mitra Empowr</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Anda juga dapat bergabung menjadi worker yang berafiliasi mitra Empowr. Dengan
                                        bergabung, anda akan mendapatkan beberapa keuntungan sebagai mitra Empowr. Untuk
                                        berafiliasi tentunya terdapat syarat-syarat yang harus dipenuhi terlebih dahulu
                                        oleh worker.
                                    </p>
                                </div>
                            </div>
                            <h1 class="text-2xl font-semibold mt-6">Apa Keuntungan Berafaliasi dengan Empowr?</h1>
                            <p class="text-left text-gray-600 text-sm leading-relaxed">
                                Worker afiliasi mitra Empowr merupakan sebuah layanan bagi worker yang ingin bergabung
                                bersama Empowr. Dengan menjadi afiliasi, maka worker tersebut menyandang status sebagai
                                worker dari Empowr. Untuk bergabung menjadi afiliasi tentu ada syarat dan tahapan yang
                                harus dilakukan, dan harus mengikuti aturan yang ditentukan oleh Empowr.
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                                <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl px-8 py-6 text-center w-full flex flex-col items-center shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                                    data-aos="fade-up">
                                    <div class="flex justify-center mb-4"> <span
                                            class="material-icons bg-white text-[#EEC91C] p-4 rounded-full text-4xl">
                                            handshake
                                        </span>
                                    </div>
                                    <h3 class="text-center text-lg font-semibold text-white mb-2">Mudah Mendapatkan
                                        Tugas</h3>
                                    <p class="text-center text-white text-sm leading-relaxed">
                                        Dengan status anda sebagai mitra Empowr, anda akan dapat mudah mendapatkan
                                        tugas. Admin akan meminta anda untuk mengerjakan suatu tugas pada saat client
                                        meminta worker yang bermitra. Anda juga dapat melamar tugas secara mandiri
                                        dengan membawa status sebagaii mitra, tentu ini akan meningkatkan kepercayaan
                                        client terhadap anda.
                                    </p>
                                </div>

                                <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl px-8 py-6 text-center w-full flex flex-col items-center shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                                    data-aos="fade-up">
                                    <div class="flex justify-center mb-4"> <span
                                            class="material-icons bg-white text-[#EEC91C] p-4 rounded-full text-4xl">
                                            local_atm
                                        </span>
                                    </div>
                                    <h3 class="text-center text-lg font-semibold text-white mb-2">Bayaran Tinggi</h3>
                                    <p class="text-center text-white text-sm leading-relaxed">
                                        Dengan status afiliasi mitra Empowr, anda akan memiliki status worker yang
                                        terpercaya dan berkualitas. Hal ini akan berpengaruh pada harga kemampuan yang
                                        kamu miliki. Anda dapat menerima bayaran yang lebih tinggi dibanding dengan
                                        worker tanpa status mitra Empowr.
                                    </p>
                                </div>

                                <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl px-8 py-6 text-center w-full flex flex-col items-center shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                                    data-aos="fade-up">
                                    <div class="flex justify-center mb-4"> <span
                                            class="material-icons bg-white text-[#EEC91C] p-4 rounded-full text-4xl">
                                            assignment
                                        </span>
                                    </div>
                                    <h3 class="text-center text-lg font-semibold text-white mb-2">Portofolio Bagus</h3>
                                    <p class="text-center text-white text-sm leading-relaxed">
                                        Seiring anda bekerja sama dengan Empowr, anda juga mendapat pengalaman yang
                                        lebih banyak atas tugas dan proyek yang telah dikerjakan. Anda dapat
                                        memasukkannya pada CV dan portofolio.
                                    </p>
                                </div>
                            </div>
                            <h1 class="text-2xl font-semibold">Bagaimana Cara Berafaliasi dengan Empowr?</h1>
                            <p class="text-left text-gray-600 text-sm leading-relaxed">
                                Untuk dapat menjadi worker afiliasi mitra Empowr, tentunya ada beberapa syarat dan
                                tahapan yang harus anda penuhi. Berikut adalah syarat dan tahapan untuk bergabung
                                menjadi afiliasi:
                            </p>
                            <ul class="text-left text-gray-600 text-sm leading-relaxed">
                                <li class="mb-2">1. Setidaknya kamu harus menyelesaikan tugas <span
                                        class="font-semibold">minimal 10 tugas</span></li>
                                <li class="mb-2">2. Dengan menyelesaikan 10 tugas, kamu telah memiliki status "verified"
                                </li>
                                <li class="mb-2">3. Rating akun anda <span class="font-semibold">lebih dari 4.0</span>
                                </li>
                                <li class="mb-2">4. Memiliki <span class="font-semibold">kartu identitas dan foto
                                        diri</span></li>
                                <li class="mb-2">5. Mendaftar dengan mengklik <span class="font-semibold">"Mendaftar
                                        Affiliator"</span></li>
                                <li class="mb-2">6. Mengisi data yang diperlukan untuk bergabung afiliasi</li>
                                <li class="mb-2">7. Setelah mengisi formulir, menunggu review dari admin Empowr</li>
                                <li class="mb-2">8. Jika telah disetujui, admin akan mengirimkan jadwal wawancara</li>
                                <li class="mb-2">9. Melakukan wawancara dengan admin Empowr melalui pertemuan online
                                </li>
                                <li class="mb-2">10. Menunggu hasil apakah kamu diterima atau ditolak menjadi afiliasi
                                    mitra Empowr</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="sebagaiClient" class="tab-content p-4 hidden">
                    <div class="flex flex-col gap-4 mb-6">
                        <h1 class="text-2xl font-semibold">Sebagai Client</h1>
                        <p class="text-left text-gray-600 text-sm leading-relaxed mb-6">
                            Jika anda merupakan seorang client baik secara individu atau grup yang ingin mendelegasikan
                            tugasnya kepada pihak eksternal, anda dapat memilih role client untuk menjalankan proses
                            bisnis anda. Dengan layanan Empowr menyederhanakan proses perekrutan Anda, sehingga Anda
                            dapat menemukan pekerja terbaik
                            dengan cepat dan efisien. Apakah Anda mencari bantuan jangka pendek atau jangka panjang,
                            kami mencocokkan Anda dengan talenta yang tepat untuk pekerjaan tersebut.
                        </p>
                        <h1 class="text-2xl font-semibold">Apa Saja Yang Dapat Anda Lakukan</h1>
                        <div class="flex flex-col gap-8 mb-12">
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition flex items-center gap-4"
                                data-aos="fade-up">
                                <div>
                                    <span class="material-icons bg-[#1F4482] text-white p-4 rounded-full text-4xl">
                                        add_box
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Memposting Tugas</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Jika anda ingin mendelegasikan tugas kepada pihak lain, mulailah dengan
                                        memposting tugas baru. Masukkan informasi mengenai tugas yang ingin anda
                                        delegasikan kepada worker, kemudian postinglah tugas tersebut.
                                    </p>
                                </div>
                            </div>

                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition flex items-center gap-4"
                                data-aos="fade-up">
                                <div>
                                    <span class="material-icons bg-[#1F4482] text-white p-4 rounded-full text-4xl">
                                        ads_click
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Mempromosikan Tugas</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Dengan anda memposting tugas, artinya anda juga mempromosikan tugas anda pada
                                        situs kami. Tugas anda akan otomatis dapat dilihat dan dilamar oleh worker yang
                                        ada di Empowr.
                                    </p>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition flex items-center gap-4"
                                data-aos="fade-up">
                                <div>
                                    <span class="material-icons bg-[#1F4482] text-white p-4 rounded-full text-4xl">
                                        <span class="material-symbols-outlined">
                                            <span class="material-symbols-outlined">
                                                ballot
                                            </span>
                                        </span>
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Menyeleksi Lamaran Worker</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Pada saat ada worker yang melamar tugas, anda dapat menyeleksi worker yang ingin
                                        anda assign. Dengan memperhatikan negosiasi harga yang diajukan oleh worker, dan
                                        juga melihat profil dari worker.
                                    </p>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition flex items-center gap-4"
                                data-aos="fade-up">
                                <div>
                                    <span class="material-icons bg-[#1F4482] text-white p-4 rounded-full text-4xl">
                                        <span class="material-symbols-outlined">
                                            <span class="material-symbols-outlined">
                                                mode_comment
                                            </span>
                                        </span>
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Berkomunikasi Dengan Worker
                                    </h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Anda dapat memulai chat dengan worker pada saat worker tersebut melamar pada
                                        tugas anda. Berkomunikasilah dengan worker untuk mencari lebih detail informasi
                                        profilnya, membicarakan harga tugas, dan lainnya.
                                    </p>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition flex items-center gap-4"
                                data-aos="fade-up">
                                <div>
                                    <span class="material-icons bg-[#1F4482] text-white p-4 rounded-full text-4xl">
                                        <span class="material-symbols-outlined">
                                            <span class="material-symbols-outlined">
                                                currency_exchange
                                            </span>
                                        </span>
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Transaksi Pengerjaan Tugas</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Untuk melakukan transaksi tugas, anda diminta untuk melakukan pembayaran
                                        terlebih dahulu kepada pihak Empowr sesuai dengan penetapan harga bayaran tugas
                                        tersebut. Setelah anda melakukan pembayaran, anda dapat memulai transaksi dengan
                                        worker, dan worker akan mulai mengerjakan tugasmu.
                                    </p>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition flex items-center gap-4"
                                data-aos="fade-up">
                                <div>
                                    <span class="material-icons bg-[#1F4482] text-white p-4 rounded-full text-4xl">
                                        <span class="material-symbols-outlined">
                                            how_to_reg
                                        </span>
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Menggunakan Jasa Worker Mitra
                                        Empowr</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Anda juga dapat meminta worker mitra Empowr untuk mengerjakan tugas anda. Worker
                                        yang disediakan tentunya yang berkualitas dan terpercaya. Anda dapat meminta
                                        pada saat telah memposting tugas, dan berkomunikasilah dengan admin untuk worker
                                        seperti apa yang anda inginkan.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <h1 class="text-2xl font-semibold">Apa Keuntungan Menggunakan Worker Mitra Empowr?</h1>
                        <p class="text-left text-gray-600 text-sm leading-relaxed">
                            Worker yang berafilasi mitra Empowr tentunya memiliki kualitas yang lebih baik, dan dapat
                            dipercaya. Proses perekrutan oleh tim Empowr melalui beberapa tahapan dan syarat yang harus
                            dipenuhi. Seleksi yang dilakukan tentunya sangat berhati-hati dan memperhatikan segalak
                            aspek. Ada kualitas juga ada harga, harga yang ditetapkan untuk worker mitra Empowr berbeda
                            dengan worker biasa.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                            <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl px-8 py-6 text-center w-full flex flex-col items-center shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                                data-aos="fade-up">
                                <div class="flex justify-center mb-4"> <span
                                        class="material-icons bg-white text-[#EEC91C] p-4 rounded-full text-4xl">
                                        person_search
                                    </span>
                                </div>
                                <h3 class="text-center text-lg font-semibold text-white mb-2">Tidak Kesusahan Mencari
                                    Worker</h3>
                                <p class="text-center text-white text-sm leading-relaxed">
                                    Anda dapat langsung meminta kepada admin Empowr untuk assign worker mitra ketugas
                                    anda tanpa kesulitan dan menunggu worker untuk melamar tugasmu. Komunikasikanlah
                                    spesifikasi worker yang kamu inginkan.
                                </p>
                            </div>

                            <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl px-8 py-6 text-center w-full flex flex-col items-center shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                                data-aos="fade-up">
                                <div class="flex justify-center mb-4"> <span
                                        class="material-icons bg-white text-[#EEC91C] p-4 rounded-full text-4xl">
                                        star_rate
                                    </span>
                                </div>
                                <h3 class="text-center text-lg font-semibold text-white mb-2">Worker Berkualitas</h3>
                                <p class="text-center text-white text-sm leading-relaxed">
                                    Dengan melalui proses yang ketat pada saat seleksi, tentu pihak Empowr memilih dan
                                    menerima worker mitra yang terjamin kualitasnya baik secara pengalaman, CV,
                                    portofolio, dan aspek-aspek lainnya.
                                </p>
                            </div>

                            <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl px-8 py-6 text-center w-full flex flex-col items-center shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                                data-aos="fade-up">
                                <div class="flex justify-center mb-4"> <span
                                        class="material-icons bg-white text-[#EEC91C] p-4 rounded-full text-4xl">
                                        verified_user
                                    </span>
                                </div>
                                <h3 class="text-center text-lg font-semibold text-white mb-2">Worker Terpercaya</h3>
                                <p class="text-center text-white text-sm leading-relaxed">
                                    Worker yang bermitra dengan Empowr juga memiliki perjanjian dan aturan yang telah
                                    disepakati oleh pihak Empowr dengan worker. Kami menjamin kepercayaan dan
                                    bertanggung jawab
                                    atas worker mitra Empowr.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="caraKerja" class="tab-content p-4 hidden">
                    <div class="flex flex-col gap-4 mb-6">
                        <h1 class="text-2xl font-semibold">Cara Kerja Layanan Kami</h1>
                        <p class="text-left text-gray-600 text-sm leading-relaxed">
                            Empowr menjadi perantara antara client dengan worker, sebagai pihak yang mempertemukan dan
                            melayani kegiatan dari client dengan worker. Fitur atau layanan utama kami adalah
                            memfasilitasi client untuk mencari worker, dan memfasilitasi worker untuk mencari pekerjaan
                            tugas.
                        </p>
                        <p class="text-left text-gray-600 text-sm leading-relaxed">
                            Untuk menggunakan layanan Empowr, anda harus dapat memahami bagaimana alur transaksi antara
                            client dan worker. Anda dapat memahami alur proses bisnisnya melalui gambar diagram, dan
                            penjelasan tata cara yang akan kami tampilkan.
                        </p>
                        <div class="flex justify-center md:justify-end">
                            <img src="assets/images/CaraKerja1.png" alt="Cara Kerja Empowr"
                                class="w-full h-auto object-cover">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8 mb-12">
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition gap-4"
                                data-aos="fade-up">
                                <div>
                                    <h1 class="text-1xl font-semibold mb-6">Langkah-Langkah Client</h1>
                                    <ul class="text-left text-gray-600 text-sm leading-relaxed">
                                        <li class="mb-2">1. Membuat tugas baru</li>
                                        <li class="mb-2">2. Mengisi informasi tugas: judul, tentang, kualifikasi,
                                            aturan, tanggal tugas, tanggal penutupan lamaran, kategori, jumlah revisi,
                                            dokumen terkait, dan harga bayaran tugas</li>
                                        <li class="mb-2">3. Memposting tugas</li>
                                        <li class="mb-2">4. Menunggu worker melamar tugas anda, atau anda bisa meminta
                                            worker mitra Empowr</li>
                                        <li class="mb-2">5. Menyeleksi lamaran-lamaran dari worker untuk tugas anda
                                            (anda dapat melakukan komunikasi dengan calon-calon worker)</li>
                                        <li class="mb-2">6. Membayar harga bayaran yang disepakati untuk tugas anda
                                            kepada pihak Empowr</li>
                                        <li class="mb-2">7. Menunggu dan memantau tugas yangs sedang dikerjakan oleh
                                            worker</li>
                                        <li class="mb-2">8. Berkomunikasi dengan worker terkait pengerjaan tugas</li>
                                        <li class="mb-2">9. Menerima dan menilai hasil yang dikerjakan oleh worker
                                            sesuai dengan progres yang dikirim oleh worker</li>
                                        <li class="mb-2">10. Mengkonfirmasi tugas telah diselesaikan apabila tugas telah
                                            sesuai</li>
                                        <li class="mb-2">11. Memberi nilai rating dan ulasan untuk worker yang telah
                                            mengerjakan tugas
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition gap-4"
                                data-aos="fade-up">
                                <div>
                                    <h1 class="text-1xl font-semibold mb-6">Langkah-Langkah Worker</h1>
                                    <ul class="text-left text-gray-600 text-sm leading-relaxed">
                                        <li class="mb-2">1. Eksplor dan mencari tugas</li>
                                        <li class="mb-2">2. Memperhatikan detail tugas yang ingin anda lamar</li>
                                        <li class="mb-2">3. Melamar tugas dan mengajukan negoisiasi harga bayaran jika
                                            menurut anda tidak sesuai</li>
                                        <li class="mb-2">4. Menunggu hasil seleksi dari client</li>
                                        <li class="mb-2">5. Berkomunikasi dengan client apabila client ingin mencari
                                            informasi tambahan dari anda</li>
                                        <li class="mb-2">6. Mulai mengerjakan tugas apabila anda telah diterima pada
                                            tugas</li>
                                        <li class="mb-2">7. Memberikan progres pengerjaan tugas kepada client</li>
                                        <li class="mb-2">8. Mengirim hasil akhir tugas dan menunggu konfirmasi selesai
                                            oleh client</li>
                                        <li class="mb-2">9. Menerima pembayaran tugas</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="pertanyaanUmum" class="tab-content p-4 hidden">
                    <div class="flex flex-col gap-8 mb-12">
                        <h1 class="text-2xl font-semibold">Pertanyaan Umum</h1>
                        <!-- Tentang Empowr -->
                        <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] border border-gray-200 rounded-lg p-6 shadow-sm flex flex-col gap-4"
                            data-aos="fade-up">
                            <h1 class="text-2xl text-white font-semibold">Tentang Empowr</h1>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Darimana sumber pendapatan Empowr?
                                    </h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Pendapatan Empowr berasal dari biaya pajak jasa perantara setiap transaksi yang
                                    dilakukan oleh client dengan worker. Empowr juga memiliki sumber pendapatan melalui
                                    program afiliasi yang bekerja sama dengan worker.
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Apakah Empowr dapat digunakan pada
                                        platform mobile?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Sementara ini, Empowr hanya dapat anda gunakan pada web browser. Dapatkan pengalaman
                                    baik menggunakan Empowr dengan memakai device terbaik untuk membuka web browser!
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Bagaimana ketentuan Empowr apabila
                                        ada pihak yang tidak bertanggung jawab?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Empowr akan menindak lanjuti apabila terdapat pihak yang tidak bertanggung jawab
                                    dalam menggunakan layanan kami. Empowr memiliki tim admin yang bertugas dalam
                                    melayani dan berkomunikasi dengan pengguna baik worker ataupun client.<br>
                                    Empowr juga memiliki layanan sistem arbitrase (laporkan) apabila terdapat salah satu
                                    pihak (worker ataupun client) tidak bertanggung jawab pada saat melakukan transaksi.
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Fasilitas pembayaran apa saja yang
                                        Empowr sediakan?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Empowr menyediakan layanan pembayaran melalui banyak opsi. E-wallet Empowr dapat
                                    anda gunakan untuk melakukan pembayaran pada aplikasi kami, atau anda juga dapat
                                    membayar menggunakan layanan eksternal seperti bank, e-wallet, dan QRIS.
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Data diri apa saja yang saya berikan
                                        kepada Empowr?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Data yang anda berikan pada Empowr adalah data umum yang tingkat privasinya tidak
                                    terlalu tinggi, dan data yang anda berikan merupakan data yang berkaitan dan
                                    dibutuhkan dalam melakukan proses bisnis aplikasi. <span class="font-semibold">Data
                                        anda akan kami jamin aman!</span>
                                </div>
                            </div>
                        </div>
                        <!-- Untuk Client -->
                        <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] border border-gray-200 rounded-lg p-6 shadow-sm flex flex-col gap-4"
                            data-aos="fade-up">
                            <h1 class="text-2xl text-white font-semibold">Untuk Client</h1>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Apakah daftar akun di Empowr gratis?
                                    </h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Daftar akun di Empowr sepenuhnya gratis bagi anda secara individual atau grup. Untuk
                                    memposting tugas anda tidak akan dikenakan biaya apapun.
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Tugas seperti apa yang dapat saya
                                        posting?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Tugas yang dapat anda posting adalah jenis tugas yang dapat dikerjakan dengan <span
                                        class="font-semibold">jarak jauh (remote)</span>. Banyak jenis serta kategori
                                    tugas yang dapat dilakukan dari jarak jauh!
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Bagaimana saya mencari worker?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Anda hanya dapat melihat profil worker yang melamar pada tugas anda. Pada profil
                                    worker terdapat informasi yang anda butuhkan untuk mempertimbangkan worker tersebut.
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Bagaimana jika nanti saya transaksi
                                        tanpa melalui Empowr?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Kami tidak akan bertanggung jawab masalah apapun apabila anda melakukan transaksi
                                    dengan worker tanpa melalui Empowr. Anda juga tidak dapat mencari worker melalui
                                    Empowr apabila belum memposting tugas.
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Bagaimana jika nanti worker yang
                                        mengerjakan tugas saya tidak bertanggung jawab?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Jika worker tidak bertanggung jawab, kami menyediakan layanan arbitrase (laporkan)
                                    pada saat transaksi berlangsung. Sistem arbitrase yang kami sediakan melibatkan
                                    admin Empowr yang bertugas menyelesaikan perselisihan yang terjadi. Hasil dari
                                    arbitrase sangat bergantung pada bukti-bukti yang ada dan audit yang dilakukan oleh
                                    admin Empowr.
                                </div>
                            </div>
                        </div>

                        <!-- Untuk Worker -->
                        <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] border border-gray-200 rounded-lg p-6 shadow-sm flex flex-col gap-4"
                            data-aos="fade-up">
                            <h1 class="text-2xl text-white font-semibold">Untuk Worker</h1>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Apakah daftar akun di Empowr gratis?
                                    </h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Daftar akun di Empowr sepenuhnya gratis bagi anda secara individual atau grup. Anda
                                    dapat melamar tugas apapun yang diposting oleh client sesuai dengan kemampuanmu.
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Proyek tugas seperti apa yang dapat
                                        saya kerjakan?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Jenis tugas yang dapat anda kerjakan adalah pekerjaan yang dapat dilakukan secara
                                    <span class="font-semibold">jarak jauh (remote)</span>. Empowr tidak dapat melayani
                                    pekerjaan tugas yang harus anda lakukan secara on location. Banyak jenis serta
                                    kategori tugas seperti IT, Design & Creative, dan lainnya.
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Bagaimana menyakinkan client untuk
                                        merekrut saya?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Anda dapat melengkapi data diri seperti pengalaman, CV, portofolio, sertifikat, dan
                                    lainnya pada bagian profil agar client dapat menilaimu. Anda juga dapat menyakinkan
                                    client saat proses komunikasi.
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Apa yang saya dapatkan jika
                                        menggunakan Empowr?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Dengan menjadi worker di Empowr, anda akan menghasilkan uang per proyek serta
                                    mendapatkan pengalaman profesional. Pekerjaan ini juga fleksibel dan dapat dilakukan
                                    dengan bebas seperti layaknya freelancer.
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Apa itu program afiliasi bagi
                                        worker?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Program afiliasi mitra Empowr adalah program bagi worker yang ingin bekerja sama
                                    dengan Empowr dan disediakan langsung oleh tim Empowr.
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Bagaimana saya dapat bergabung
                                        program afiliasi?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Syaratnya anda harus telah menyelesaikan minimal 10 tugas dan memiliki rating di
                                    atas 4.0. Setelah itu, anda akan menjalani proses interview dengan tim Empowr.
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Apa yang saya lakukan jika telah
                                        bergabung menjadi afiliasi?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Anda harus mematuhi peraturan dari Empowr dan siap menerima tugas dari client yang
                                    dikirim langsung oleh pihak Empowr.
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Apa yang saya dapatkan jika
                                        bergabung afiliasi?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Anda akan lebih mudah mendapatkan tugas tanpa proses lamaran, serta bayaran lebih
                                    tinggi dibandingkan worker biasa karena dinilai memiliki tanggung jawab lebih
                                    tinggi.
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Bagaimana jika saya transaksi dengan
                                        client tanpa melalui Empowr?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Kami tidak akan bertanggung jawab atas masalah apa pun jika anda melakukan transaksi
                                    dan perjanjian dengan client di luar layanan Empowr.
                                </div>
                            </div>

                            <div
                                class="faq-item cursor-pointer bg-white border border-gray-200 rounded-lg p-4 shadow-sm transition flex flex-col gap-2">
                                <div class="faq-question">
                                    <h3 class="text-lg font-semibold text-gray-900">Bagaimana jika nanti client yang
                                        merekrut saya tidak bertanggung jawab?</h3>
                                </div>
                                <div class="faq-answer hidden text-gray-600 text-sm leading-relaxed">
                                    Jika client tidak bertanggung jawab, kami menyediakan layanan arbitrase (laporkan)
                                    pada saat transaksi berlangsung. Sistem ini melibatkan admin Empowr dan keputusan
                                    didasarkan pada bukti-bukti serta audit oleh admin.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tentangArbitrase" class="tab-content p-4 hidden">
                    <div class="flex flex-col gap-4 mb-6">
                        <h1 class="text-2xl font-semibold">Tentang Arbitrase</h1>
                        <p class="text-left text-gray-600 text-sm leading-relaxed">
                            Untuk menjaga kenyamanan dan keamanan selama transaksi berlangsung, kami menyediakan layanan
                            sistem arbitrase(laporkan). Arbitrase adalah sebuah sistem untuk menyelesaikan sengketa yang
                            terjadi yang antara kedua belah pihak. Pengajuan arbitrase dapat dilakukan baik oleh client
                            ataupun worker, tentunya melaporkan dengan masalah yang jelas dan telah menyiapkan
                            bukti-bukti.
                        </p>
                        <p class="text-left text-gray-600 text-sm leading-relaxed">
                            Sistem arbitrase akan kami jamin aman dan akan membuat keputusan yang seadilnya. Alur yang
                            dilakukan juga dijamin telah sesuai tanpa celah, dan ini tidak akan berat sebelah pada pihak
                            manapun. Perhatikan gambar diagram berikut untuk memahami alur dari sistem arbitrase:
                        </p>
                        <div class="flex justify-center md:justify-end mb-6">
                            <img src="assets/images/CaraKerja2.png" alt="Cara Kerja Empowr"
                                class="w-full h-auto object-cover">
                        </div>
                        <h1 class="text-2xl font-semibold">Bagaimana langkah-langkah saya mengajukan laporan?</h1>
                        <ul class="text-left text-gray-600 text-sm leading-relaxed">
                            <li class="mb-2">1. Sedang melakukan transaksi tugas</li>
                            <li class="mb-2">2. Menekan "Laporkan" pada halaman transaksi</li>
                            <li class="mb-2">3. Pastikan kamu mengalami masalah yang jelas dan telah menyiapkan bukti
                            </li>
                            <li class="mb-2">4. Mengisi form catatan pengajuan laporan dan disubmit</li>
                            <li class="mb-2">5. Menunggu hasil tanggapan dari admin Empowr, dan admin akan berkomunikasi
                                dengan anda untuk detail lebih lanjut</li>
                            <li class="mb-2">6. Admin akan menilai dan membuat keputusan dalam beberapa waktu</li>
                            <li class="mb-2">7. Menerima keputusan dari admin Empowr</li>
                        </ul>
                    </div>
                </div>
                <div id="pricing" class="tab-content p-4 hidden">
                    <div class="flex flex-col gap-4 mb-6">
                        <h1 class="text-2xl font-semibold">Tentang Pricing</h1>
                        <p class="text-left text-gray-600 text-sm leading-relaxed">
                            Kami menetapkan harga pajak layanan kami untuk setiap transaksi, dan juga keuangan(top up
                            ataupun withdraw saldo) pada e-wallet. Berikut tabel aturan pricing pada layanan Empowr:
                        </p>
                        <table class="min-w-full border border-gray-300 text-sm shadow-lg rounded-lg overflow-hidden">
                            <thead class="bg-[#1F4482] text-white">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-center font-semibold tracking-wide text-base border border-gray-300">
                                        Role</th>
                                    <th
                                        class="px-6 py-4 text-center font-semibold tracking-wide text-base border border-gray-300">
                                        Layanan Empowr</th>
                                    <th
                                        class="px-6 py-4 text-center font-semibold tracking-wide text-base border border-gray-300">
                                        Penetapan Harga</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <!-- Sebagai Client -->
                                <tr>
                                    <td class="px-6 py-4 text-gray-800 font-semibold align-top border border-gray-300"
                                        rowspan="4">Sebagai Client</td>
                                    <td class="px-6 py-4 text-gray-700 border border-gray-300">Memposting tugas</td>
                                    <td class="px-6 py-4 border border-gray-300">
                                        <span
                                            class="bg-gradient-to-br from-green-500 to-green-700 text-white px-4 py-1 rounded-md inline-block text-sm font-medium shadow">Gratis</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 text-gray-700 border border-gray-300">Potongan pembayaran tugas
                                        (e-wallet Empowr)</td>
                                    <td class="px-6 py-4 text-gray-600 border border-gray-300">Tidak ada potongan jika
                                        menggunakan e-wallet Empowr</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 text-gray-700 border border-gray-300">Potongan pembayaran tugas
                                        (metode pembayaran eksternal)</td>
                                    <td class="px-6 py-4 text-gray-600 border border-gray-300">Metode transfer apa saja
                                        akan dikenakan 2,5% dari total pembayaran</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 text-gray-700 border border-gray-300">Pajak jasa perantara
                                        transaksi</td>
                                    <td class="px-6 py-4 text-gray-600 border border-gray-300">Akan dipotong dari total
                                        bayaran tugas</td>
                                </tr>

                                <!-- Sebagai Worker -->
                                <tr>
                                    <td class="px-6 py-4 text-gray-800 font-semibold align-top border border-gray-300"
                                        rowspan="2">Sebagai Worker</td>
                                    <td class="px-6 py-4 text-gray-700 border border-gray-300">Melamar tugas</td>
                                    <td class="px-6 py-4 border border-gray-300">
                                        <span
                                            class="bg-gradient-to-br from-green-500 to-green-700 text-white px-4 py-1 rounded-md inline-block text-sm font-medium shadow">Gratis</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 text-gray-700 border border-gray-300">Pajak jasa perantara
                                        transaksi</td>
                                    <td class="px-6 py-4 text-gray-600 border border-gray-300">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>5% dari total bayaran tugas untuk tugas dengan bayaran Rp 0,- s/d Rp
                                                1.000.000,-</li>
                                            <li>10% dari total bayaran tugas untuk tugas dengan bayaran lebih dari Rp
                                                1.000.000,-</li>
                                        </ul>
                                    </td>
                                </tr>

                                <!-- E-Wallet Empowr -->
                                <tr>
                                    <td class="px-6 py-4 text-gray-800 font-semibold align-top border border-gray-300"
                                        rowspan="2">E-Wallet Empowr</td>
                                    <td class="px-6 py-4 text-gray-700 border border-gray-300">Top Up</td>
                                    <td class="px-6 py-4 border border-gray-300">
                                        <span
                                            class="bg-gradient-to-br from-green-500 to-green-700 text-white px-4 py-1 rounded-md inline-block text-sm font-medium shadow">Gratis
                                            tanpa potongan</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 text-gray-700 border border-gray-300">Withdraw</td>
                                    <td class="px-6 py-4 border border-gray-300">
                                        <span
                                            class="bg-gradient-to-br from-green-500 to-green-700 text-white px-4 py-1 rounded-md inline-block text-sm font-medium shadow">Gratis
                                            tanpa potongan</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- untuk menutupi konten tab lain -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const hash = window.location.hash;

    if (hash) {
        const tabId = hash.substring(1); // Buang '#' dari hash
        showTab(tabId);

        // Tambahkan kelas aktif ke tombol tab sesuai ID hash (jika pakai)
        const activeButton = document.getElementById(tabId + 'Button');
        if (activeButton) {
            activeButton.classList.add('active');
        }
    } else {
        // Default: tampilkan tab petunjukUmum
        showTab('petunjukUmum');
        const defaultBtn = document.getElementById('petunjukUmumButton');
        if (defaultBtn) {
            defaultBtn.classList.add('active');
        }
    }
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');

            question.addEventListener('click', () => {
                answer.classList.toggle('hidden');
                item.classList.toggle('border-blue-500');
                item.classList.toggle('shadow-md');
            });
        });
    });
</script>
@include('General.footer')
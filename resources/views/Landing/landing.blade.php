@include('Landing.header')

<!-- Hero Section -->
<section class="container mx-auto mt-20">
    <section class="container mx-auto mt-20 md:mt-24 py-12 px-6 md:px-12 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            <div data-aos="fade-up" data-aos-duration="1000">
                <h1
                    class="text-[#183E74] font-extrabold text-4xl sm:text-5xl md:text-6xl leading-tight mb-6 drop-shadow-lg">
                    Tempat Tugas Bertemu Talenta, dan Talenta Menemukan Kesempatan!
                </h1>
                <p class="text-gray-700 text-base sm:text-lg leading-relaxed mb-8">
                    Temukan peluang terbaik, posting dan dapatkan tugas dengan mudah. Bergabunglah sekarang dan
                    raih kesuksesan bersama!
                </p>
                <a href="{{ route('login') }}" class="inline-block bg-gradient-to-r from-[#1F4482] to-[#2A5DB2]
              hover:from-[#2A5DB2] hover:to-[#1F4482] text-white font-semibold text-base sm:text-lg
              px-16 py-4 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
                    Segera Mulai
                </a>
            </div>

            <div class="flex justify-center md:justify-end" data-aos="fade-left" data-aos-duration="1000">
                <img src="assets/images/Landing Page 1.png" alt="Hero Image" class="max-w-full h-auto object-contain ">
            </div>
        </div>
    </section>

    <!-- Cards Section with Scroll Animations -->
    <section class="w-full bg-gradient-to-b from-[#f9f9f9] to-white py-16 px-6 md:px-12">
        <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-center items-stretch gap-8">
            <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl px-8 py-6 text-center w-full md:w-1/3 flex flex-col justify-between items-center shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                data-aos="zoom-in" data-aos-duration="700">
                <p class="text-base mb-2 opacity-90">Total Client</p>
                <h3 class="text-4xl font-extrabold">1k+</h3>
            </div>

            <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl px-8 py-6 text-center w-full md:w-1/3 flex flex-col justify-between items-center shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                data-aos="zoom-in" data-aos-duration="900">
                <p class="text-base mb-2 opacity-90">Total Worker</p>
                <h3 class="text-4xl font-extrabold">500+</h3>
            </div>

            <div class="bg-gradient-to-br from-[#1F4482] to-[#2A5DB2] text-white rounded-xl px-8 py-6 text-center w-full md:w-1/3 flex flex-col justify-between items-center shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                data-aos="zoom-in" data-aos-duration="1100">
                <p class="text-base mb-2 opacity-90">Total Tasks</p>
                <h3 class="text-4xl font-extrabold">2k+</h3>
            </div>
        </div>
    </section>
</section>

<!-- Why Choose Us Section with Scroll Animations -->
<section class="w-full bg-white py-16 px-6 md:px-12">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-[#252525] font-bold text-3xl sm:text-4xl mb-12 text-center" data-aos="fade-up"
            data-aos-duration="800">
            Mengapa Harus Memilih Kami
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white border border-gray-200 rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
                data-aos="fade-right" data-aos-duration="1000">
                <div class="flex justify-center mb-6">
                    <img src="assets/images/Icon LP1.png" alt="Trusted Icon" class="w-20 h-20 object-contain">
                </div>
                <h3 class="text-center text-xl font-semibold text-gray-900 mb-3">Trusted</h3>
                <p class="text-center text-gray-600 text-base leading-relaxed">
                    Kami menghubungkan Anda dengan talenta yang terverifikasi dan pembayaran yang aman, memastikan
                    rasa nyaman dan aman untuk setiap proyek.
                </p>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
                data-aos="fade-up" data-aos-duration="1000">
                <div class="flex justify-center mb-6">
                    <img src="assets/images/Icon LP2.png" alt="Quality Icon" class="w-20 h-20 object-contain">
                </div>
                <h3 class="text-center text-xl font-semibold text-gray-900 mb-3">Quality</h3>
                <p class="text-center text-gray-600 text-base leading-relaxed">
                    Akses kumpulan profesional yang sangat terampil dan pastikan hasil terbaik untuk semua tugas Anda.
                </p>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
                data-aos="fade-left" data-aos-duration="1000">
                <div class="flex justify-center mb-6">
                    <img src="assets/images/Icon LP3.png" alt="Flexibility Icon" class="w-20 h-20 object-contain">
                </div>
                <h3 class="text-center text-xl font-semibold text-gray-900 mb-3">Flexibility</h3>
                <p class="text-center text-gray-600 text-base leading-relaxed">
                    Pekerjakan untuk tugas jangka pendek, jangka panjang, atau apapun di antaranya, dengan persyaratan
                    yang anda buat.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- How Empowr Works Section -->
<section class="w-full bg-white py-16 px-6 md:px-12">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-[#252525] font-bold text-2xl sm:text-3xl mb-8">Bagaimana Empowr Berkerja</h2>

        <!-- Client Section -->
        <div class="flex flex-col md:flex-row justify-center items-center gap-6 mb-12" data-aos="fade-up">
            <div class="md:justify-end md:w-1/2">
                <img src="assets/images/Landing Page 2.png" alt="Client working with Empower"
                    class="w-[605px] h-96 rounded-[10px] shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)]">
            </div>
            <div class="text-left md:w-1/2">
                <h3 class="text-[#252525] text-4xl font-semibold mb-4">Sebagai Client</h3>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed mb-6">
                    Empowr menyederhanakan proses perekrutan Anda, sehingga Anda dapat menemukan pekerja terbaik dengan
                    cepat dan efisien. Apakah Anda mencari bantuan jangka pendek atau jangka panjang, kami mencocokkan
                    Anda dengan talenta yang tepat untuk pekerjaan tersebut. Perekrutan tidak pernah semudah ini!
                </p>
                <a href="{{ route('login') }}"
                    class="inline-block bg-gradient-to-r from-[#1F4482] to-[#2A5DB2] hover:from-[#2A5DB2] hover:to-[#1F4482] text-white font-semibold text-sm sm:text-base px-14 py-3 rounded-md shadow transition-all duration-200 hover:shadow-lg">
                    Cari Pekerja Sekarang!
                </a>
            </div>
        </div>

        <!-- Worker Section -->
        <div class="flex flex-col md:flex-row justify-center items-center gap-6 mb-24" data-aos="fade-up">
            <div class="text-left md:w-1/2">
                <h3 class="text-[#252525] text-4xl font-semibold mb-4">Sebagai Worker</h3>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed mb-6">
                    Empowr membantu Anda menemukan peluang kerja terbaik dengan mudah. Apakah Anda mencari tugas
                    paruh waktu, atau lepas, kami menghubungkan Anda dengan klien-klien terbaik. Mulailah
                    hari ini dan kendalikan karir Anda!
                </p>
                <a href="{{ route('login') }}"
                    class="inline-block bg-gradient-to-r from-[#1F4482] to-[#2A5DB2] hover:from-[#2A5DB2] hover:to-[#1F4482] text-white font-semibold text-sm sm:text-base px-14 py-3 rounded-md shadow transition-all duration-200 hover:shadow-lg">
                    Cari Tugas Sekarang!
                </a>
            </div>
            <div class="md:justify-end md:w-1/2">
                <img src="assets/images/Landing Page 3.png" alt="Worker using Empower"
                    class="w-[605px] h-96 rounded-[10px] shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)]">
            </div>
        </div>

        <!-- Arbitrase System Section -->
        <div class="flex flex-col justify-center items-center mb-12" data-aos="fade-up">
            <div class="flex justify-center">
                <img src="assets/images/Landing Page 4.png" alt="Arbitrase System Image"
                    class="w-full h-auto object-cover max-w-96">
            </div>
            <div class="text-center mb-6">
                <h2 class="text-[#1F4482] font-bold text-3xl sm:text-4xl mb-4">
                    Kami Menyediakan Anda Sistem Arbitrase
                </h2>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed mb-6">
                    Kami menjadi penghubung serta melayani kedua belah pihak dalam menjalankan bisnisnya. Kami juga
                    menyediakan sistem arbitrase bagi anda sebagai bentuk membangun kepercayaan kepada pengguna kami.
                    Arbitrase yang kami sediakan membantu anda dalam melakukan bisnis dengan rasa nyaman dan aman.
                </p>
            </div>
        </div>
    </div>
</section>
<!-- Footer Section -->
<section class="w-full bg-[#f9f9f9] py-16 px-6 md:px-12">
    <div class="max-w-7xl mx-auto text-center">
        <div class="mb-8">
            <img src="assets/images/logo.png" alt="Empowr Logo" class="w-32 h-auto mx-auto">
        </div>
        <div class="flex justify-center space-x-6">
            <a href="#" class="text-[#1F4482] font-semibold text-base hover:text-[#2A5DB2]">About Us</a>
            <a href="#" class="text-[#1F4482] font-semibold text-base hover:text-[#2A5DB2]">Contact</a>
            <a href="#" class="text-[#1F4482] font-semibold text-base hover:text-[#2A5DB2]">FAQs</a>
        </div>
    </div>
</section>

@include('Landing.footer')
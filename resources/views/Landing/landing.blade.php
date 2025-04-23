@include('Landing.header')

<!-- Hero Section -->
<section class="container mx-auto mt-20">
    <section class="w-full bg-white py-8 px-6 md:px-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

            <!-- Left: Text with Scroll Animation -->
            <div data-aos="fade-up">
                <h2
                    class="text-[#183E74] font-extrabold text-3xl sm:text-4xl md:text-5xl leading-tight mb-4 drop-shadow-md">
                    Where Tasks Find Talent,<br>
                    and Talent Finds Opportunity!
                </h2>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed mb-6 drop-shadow-md">
                    Find the best opportunities, post and accept jobs easily. Join now and<br class="hidden sm:block">
                    achieve success together!
                </p>
                <a href="{{ route('login') }}" class="inline-block bg-gradient-to-r from-[#1F4482] to-[#2A5DB2]
                  hover:from-[#2A5DB2] hover:to-[#1F4482] text-white font-semibold text-sm sm:text-base
                  px-14 py-3 rounded-md shadow transition-all duration-200 hover:shadow-lg">
                    Get Started
                </a>
            </div>

            <!-- Right: Image with Scroll Animation -->
            <div class="flex justify-center md:justify-end" data-aos="fade-left">
                <img src="assets/images/Landing Page 1.png" alt="Hero Image"
                    class="max-w-30 w-full h-auto object-cover">
            </div>
        </div>
    </section>

    <!-- Cards Section with Scroll Animations -->
    <section class="w-full bg-[#f9f9f9] py-16 px-6 md:px-12">
        <div class="max-w-5xl mx-auto px-6 flex flex-col md:flex-row justify-center items-center gap-6">
            <!-- Card 1 -->
            <div class="bg-gradient-to-b from-[#1F4482] to-[#2A5DB2] text-white rounded-md px-6 py-4 text-center w-full md:w-1/3"
                data-aos="zoom-in">
                <p class="text-sm mb-1">Total Client</p>
                <h3 class="text-2xl font-bold">1k+</h3>
            </div>

            <!-- Card 2 -->
            <div class="bg-gradient-to-b from-[#1F4482] to-[#2A5DB2] text-white rounded-md px-6 py-4 text-center w-full md:w-1/3"
                data-aos="zoom-in">
                <p class="text-sm mb-1">Total Worker</p>
                <h3 class="text-2xl font-bold">500+</h3>
            </div>

            <!-- Card 3 -->
            <div class="bg-gradient-to-b from-[#1F4482] to-[#2A5DB2] text-white rounded-md px-6 py-4 text-center w-full md:w-1/3"
                data-aos="zoom-in">
                <p class="text-sm mb-1">Total Tasks</p>
                <h3 class="text-2xl font-bold">2k+</h3>
            </div>
        </div>
    </section>
</section>

<!-- Why Choose Us Section with Scroll Animations -->
<section class="w-full bg-[#f9f9f9] py-16 px-6 md:px-12">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-[#252525] font-bold text-2xl sm:text-3xl mb-8" data-aos="fade-up">
            Why Choose Us
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Card: Trusted -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition"
                data-aos="fade-right">
                <div class="flex justify-center mb-4">
                    <img src="assets/images/Icon LP1.png" alt="Trusted Icon" class="w-14 h-14">
                </div>
                <h3 class="text-center text-lg font-semibold text-gray-900 mb-2">Trusted</h3>
                <p class="text-center text-gray-600 text-sm leading-relaxed">
                    Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade, gigasm fărotum
                    kros mei.
                </p>
            </div>

            <!-- Card: Quality -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition"
                data-aos="fade-up">
                <div class="flex justify-center mb-4">
                    <img src="assets/images/Icon LP2.png" alt="Quality Icon" class="w-14 h-14">
                </div>
                <h3 class="text-center text-lg font-semibold text-gray-900 mb-2">Quality</h3>
                <p class="text-center text-gray-600 text-sm leading-relaxed">
                    Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade, gigasm fărotum
                    kros mei.
                </p>
            </div>

            <!-- Card: Flexibility -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition"
                data-aos="fade-left">
                <div class="flex justify-center mb-4">
                    <img src="assets/images/Icon LP3.png" alt="Flexibility Icon" class="w-14 h-14">
                </div>
                <h3 class="text-center text-lg font-semibold text-gray-900 mb-2">Flexibility</h3>
                <p class="text-center text-gray-600 text-sm leading-relaxed">
                    Lorem ipsum eurologi vatapōde krotāvis provis kavat depigisik, ultrassa prens vărade, gigasm fărotum
                    kros mei.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- How Empowr Works Section -->
<section class="w-full bg-white py-16 px-6 md:px-12">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-[#252525] font-bold text-2xl sm:text-3xl mb-8">How Empowr Works</h2>

        <!-- Client Section -->
        <div class="flex flex-col md:flex-row justify-center items-center gap-6 mb-12" data-aos="fade-up">
            <div class="flex justify-center md:justify-end md:w-1/2">
                <img src="assets/images/Landing Page 2.png" alt="Client working with Empower"
                    class="w-full h-auto object-cover">
            </div>
            <div class="text-left md:w-1/2">
                <h3 class="text-[#252525] text-4xl font-semibold mb-4">As Client</h3>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed mb-6">
                    Empower streamlines your hiring process, allowing you to find the best workers quickly and
                    efficiently.
                    Whether you’re looking for short-term or long-term help, we match you with the right talent for the
                    job.
                    Hiring has never been this easy!
                </p>
                <a href="{{ route('login') }}"
                    class="inline-block bg-gradient-to-r from-[#1F4482] to-[#2A5DB2] hover:from-[#2A5DB2] hover:to-[#1F4482] text-white font-semibold text-sm sm:text-base px-14 py-3 rounded-md shadow transition-all duration-200 hover:shadow-lg">
                    Hire Worker Now!
                </a>
            </div>
        </div>

        <!-- Worker Section -->
        <div class="flex flex-col md:flex-row justify-center items-center gap-6 mb-24" data-aos="fade-up">
            <div class="text-left md:w-1/2">
                <h3 class="text-[#252525] text-4xl font-semibold mb-4">As Worker</h3>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed mb-6">
                    Empower helps you find the best job opportunities with ease. Whether you're looking for part-time,
                    full-time, or freelance work, we connect you with top clients. Start today and take control of your
                    career!
                </p>
                <a href="{{ route('login') }}"
                    class="inline-block bg-gradient-to-r from-[#1F4482] to-[#2A5DB2] hover:from-[#2A5DB2] hover:to-[#1F4482] text-white font-semibold text-sm sm:text-base px-14 py-3 rounded-md shadow transition-all duration-200 hover:shadow-lg">
                    Search Job Now!
                </a>
            </div>
            <div class="flex justify-center md:justify-end md:w-1/2">
                <img src="assets/images/Landing Page 3.png" alt="Worker using Empower"
                    class="w-full h-auto object-cover">
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
                    We Provide You Arbitrase System
                </h2>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed mb-6">
                    Lorem ipsum korrarade sask i belg dirän, ifall plaplada, den och setressade i nybel för diryn.
                    Tyrrade eplahat röde kände betesvyis subonät att tenera. Dasanas plapabubel, monoppp måvaliga seng
                    ifall tevesem.
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
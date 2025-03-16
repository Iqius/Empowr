<!-- SWIPER LOREM -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1, // Menampilkan 1 card dalam 1 waktu
        spaceBetween: 10, // Jarak antar card
        loop: true, // Looping carousel
        autoplay: {
        delay: 3000, // AutopKlay setiap 3 detik
        disableOnInteraction: false,
        },
        breakpoints: {
        640: { slidesPerView: 2 },
        768: { slidesPerView: 3 }, // Saat layar >=768px, tampilkan 2 card
        1024: { slidesPerView: 4 }, // Saat layar >=1024px, tampilkan 3 card
        },
    });
    });
</script>

<!-- SWIPER LOREM -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
    var swiper = new Swiper(".swiperComment", {
        slidesPerView: 1, // Menampilkan 1 card dalam 1 waktu
        spaceBetween: 10, // Jarak antar card
        loop: true, // Looping carousel
        autoplay: {
        delay: 3000, // AutopKlay setiap 3 detik
        disableOnInteraction: false,
        },
        breakpoints: {
        640: { slidesPerView: 1 },
        768: { slidesPerView: 2 }, // Saat layar >=768px, tampilkan 2 card
        1024: { slidesPerView: 3 }, // Saat layar >=1024px, tampilkan 3 card
        },
    });
    });
</script>

<!-- JS FLOWBITE -->
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>


<!-- Footer -->
<footer class="bg-gray-800 text-white text-center py-6 mt-20">
    <p>&copy; 2025 Empowr. All rights reserved.</p>
</footer>
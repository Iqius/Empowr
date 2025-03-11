<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empowr - Connect, Collaborate, Succeed!</title>
    @vite('resources/css/app.css') {{-- Jika menggunakan Laravel Vite --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-blue-600">Empowr</h1>
            <a href="/login" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Get Started
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="text-center py-20 bg-blue-500 text-white">
        <h2 class="text-4xl font-bold">Empowr. Connect, Collaborate, Succeed!</h2>
        <p class="mt-4 text-lg">Temukan peluang terbaik, posting dan terima pekerjaan dengan mudah. Bergabung sekarang dan raih kesuksesan bersama!</p>
        <a href="/login" class="mt-6 inline-block bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">
            Get Started
        </a>
    </section>

    <!-- Features Section -->
    <section class="container mx-auto my-16 px-4">
        <h3 class="text-3xl font-bold text-center text-gray-800">Fitur Utama</h3>
        <div class="grid md:grid-cols-3 gap-8 mt-8">
            <div class="bg-white p-6 shadow-lg rounded-lg text-center">
                <h4 class="text-xl font-semibold text-blue-600">Sistem Milestone</h4>
                <p class="mt-2 text-gray-600">Pengerjaan proyek dengan sistem milestone untuk memastikan pembayaran aman.</p>
            </div>
            <div class="bg-white p-6 shadow-lg rounded-lg text-center">
                <h4 class="text-xl font-semibold text-blue-600">Sistem Arbitrase</h4>
                <p class="mt-2 text-gray-600">Mekanisme arbitrase untuk menyelesaikan perselisihan antara klien dan pekerja.</p>
            </div>
            <div class="bg-white p-6 shadow-lg rounded-lg text-center">
                <h4 class="text-xl font-semibold text-blue-600">Pemilihan Worker</h4>
                <p class="mt-2 text-gray-600">Klien dapat memilih pekerja terbaik berdasarkan pendaftaran dan portofolio.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-6">
        <p>&copy; 2025 Empowr. All rights reserved.</p>
    </footer>

</body>
</html>

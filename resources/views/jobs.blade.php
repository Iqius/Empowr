<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow p-4 flex justify-between items-center relative">
        <div class="flex items-center gap-4">
            <img id="logoPreview" src="assets/images/Logo.png" alt="Logo" class="w-20 h-5">
            <button id="menuBtn" class="md:hidden text-gray-600 focus:outline-none">☰</button>
            <div id="menu" class="hidden md:flex gap-6 ml-4 flex-col md:flex-row absolute md:relative bg-white md:bg-transparent top-16 left-4 md:top-0 md:left-0 w-40 md:w-auto shadow md:shadow-none rounded-md p-2 md:p-0">
                <a href="/jobs" class="text-blue-600 border-b-2 border-blue-600">Jobs</a>
                <!-- <a href="/new" class="text-gray-600 hover:text-blue-600">New Job</a> -->
            </div>
        </div>
        <div class="relative">
            <button id="clientMenuBtn" class="flex items-center gap-2 focus:outline-none">
                <img src="{{  Auth::user()->profile_image ? asset('storage/' .  Auth::user()->profile_image) : asset('assets/images/avatar.png') }}" 
                alt="Avatar" class="w-8 h-8 rounded-full">
                <span class="text-gray-600 hidden md:inline">{{ Auth::user()->name }}</span>
            </button>
            <div id="clientMenu" class="absolute right-0 mt-2 w-32 bg-white shadow-lg rounded hidden">
                <a href="/profil" class="block px-4 py-2 text-gray-600 hover:bg-gray-200">Profile</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button id="logoutBtn" type="button" class="block w-full text-left px-4 py-2 text-gray-600 hover:bg-gray-200">Log Out</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Logout Modal -->
    <div id="logoutModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded shadow-md w-80">
            <h2 class="text-lg font-semibold mb-4">Confirm Logout</h2>
            <p class="mb-4">Are you sure you want to log out?</p>
            <div class="flex justify-end gap-2">
                <button id="cancelLogout" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                <button id="confirmLogout" class="px-4 py-2 bg-red-600 text-white rounded">Log Out</button>
            </div>
        </div>
    </div>

    <!-- Job List -->
    <section class="p-4 md:p-8">
        <h1 class="text-2xl md:text-3xl font-semibold mb-4">Jobs List</h1>
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <input type="text" placeholder="Search Job" class="p-2 border rounded w-full md:w-1/3" id="searchInput">
            <select class="p-2 border rounded w-full md:w-auto" id="sortSelect">
                <option>Sort</option>
                <option value="price">Price</option>
            </select>
            <button class="p-2 border rounded bg-blue-600 text-white w-full md:w-auto">Filter</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4" id="jobContainer">
            <!-- Job Card -->
            <div class="bg-white p-4 rounded shadow-md hover:shadow-lg transition duration-200">
                <a href="/job-detail" class="block">
                    <p class="text-blue-600 font-semibold">Poster Designer</p>
                    <p class="text-gray-600 text-sm">Desain suatu poster...</p>
                    <p class="text-black font-bold mt-2">Rp 200000</p>
                    <p class="text-gray-500 text-sm">By Jim</p>
                </a>
            </div>
        </div>

    </section>
    <script src="js/jobs.js"></script>

</body>
</html>
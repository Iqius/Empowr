<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Job</title>
    <script src="https://cdn.tailwindcss.com"></script>

    @php echo '<script>' . file_get_contents(resource_path('js/new.js')) . '</script>'; @endphp

    </head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow p-4 flex justify-between items-center relative">
        <div class="flex items-center gap-4">
            <img id="logoPreview" src="assets/images/Logo.png" alt="Logo" class="w-20 h-5">
            <button id="menuBtn" class="md:hidden text-gray-600 focus:outline-none">☰</button>
            <div id="menu" class="hidden md:flex gap-6 ml-4 flex-col md:flex-row absolute md:relative bg-white md:bg-transparent top-16 left-4 md:top-0 md:left-0 w-40 md:w-auto shadow md:shadow-none rounded-md p-2 md:p-0">
                <a href="/jobs" class="text-gray-600 hover:text-blue-600">Jobs</a>
                <a href="/new" class="text-blue-600 border-b-2 border-blue-600">New Job</a>
            </div>
        </div>
        <div class="relative">
            <button id="clientMenuBtn" class="flex items-center gap-2 focus:outline-none">
                <img src="assets/images/avatar.png" alt="Avatar" class="w-8 h-8 rounded-full">
                <span class="text-gray-600 hidden md:inline">Dede Rahmat</span>
            </button>
            <div id="clientMenu" class="absolute right-0 mt-2 w-32 bg-white shadow-lg rounded hidden">
                <a href="/profil" class="block px-4 py-2 text-gray-600 hover:bg-gray-200">Profile</a>
                <button id="logoutBtn" class="block w-full text-left px-4 py-2 text-gray-600 hover:bg-gray-200">Log Out</button>
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

    <!-- New Job Form -->
    <section class="p-4 md:p-8 flex justify-center">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-lg">
            <h1 class="text-2xl font-semibold mb-4">Add New Job</h1>
            <form id="newJobForm">
                <div class="mb-4">
                    <label class="block text-gray-700">Title</label>
                    <input type="text" id="jobTitle" class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Description</label>
                    <textarea id="jobDescription" class="w-full p-2 border rounded"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Price (Rp)</label>
                    <input type="number" id="jobPrice" class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">End Date</label>
                    <input type="date" id="jobDateEnd" class="w-full p-2 border rounded">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Save</button>
            </form>
        </div>
    </section>
</body>
</html>
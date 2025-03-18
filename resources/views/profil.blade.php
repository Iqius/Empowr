<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4 text-center">Profile</h2>
        <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col items-center mb-4">
                <label for="profile-pic" class="cursor-pointer">
                    <img id="profile-image" src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('assets/images/avatar.png') }}" alt="Profile Picture" class="w-24 h-24 sm:w-32 sm:h-32 rounded-full object-cover border border-gray-300">
                </label>
                <input type="file" name="profile_image" id="profile-pic" accept="image/*" class="hidden" onchange="previewImage(event)">
            </div>

            <div class="mb-4">
                <label class="block text-gray-600">Nama</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full p-2 border rounded">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-600">Email</label>
                    <input type="email" value="{{ Auth::user()->email }}" disabled class="w-full p-2 border rounded bg-gray-200">
                </div>
                <div>
                    <label class="block text-gray-600">No HP</label>
                    <input type="text" name="phone" value="{{ Auth::user()->phone }}" class="w-full p-2 border rounded">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-gray-600">Tanggal Lahir</label>
                    <input type="date" value="{{ Auth::user()->date }}" disabled class="w-full p-2 border rounded bg-gray-200">
                </div>
                <div>
                    <label class="block text-gray-600">LinkedIn</label>
                    <input type="url" name="linkedin" value="{{ Auth::user()->linkedin }}" class="w-full p-2 border rounded">
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 w-full sm:w-auto" onclick="window.history.back()">Back</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full sm:w-auto">Save</button>
            </div>
        </form>

    </div>
    @if(session('success'))
<div id="successModal" class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded shadow-md text-center">
        <h2 class="text-lg font-semibold text-green-600">Update Berhasil</h2>
        <p class="mt-2 text-gray-700">{{ session('success') }}</p>
        <button id="closeModal" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">OK</button>
    </div>
</div>
@endif

<!-- Tambahkan script setelah modal -->
<script >document.addEventListener("DOMContentLoaded", function () {
    let closeModal = document.getElementById("closeModal");
    let successModal = document.getElementById("successModal");

    if (closeModal && successModal) {
        closeModal.addEventListener("click", function () {
            successModal.style.display = "none"; // Menutup modal tanpa reload
        });
    }
});
</script>


</body>
</html>
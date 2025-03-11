<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Profile</h2>
        <form id="profile-form">
            <div class="flex flex-col items-center mb-4">
                <label for="profile-pic" class="cursor-pointer">
                    <img id="profile-image" src="assets/images/avatar.png" alt="Profile Picture" class="w-24 h-24 rounded-full object-cover border border-gray-300">
                </label>
                <input type="file" id="profile-pic" accept="image/*" class="hidden" onchange="previewImage(event)">
            </div>
            <div class="mb-4">
                <label class="block text-gray-600">Username</label>
                <input type="text" value="Dede Rahmat" disabled class="w-full p-2 border rounded bg-gray-200">
            </div>
            <div class="mb-4">
                <label class="block text-gray-600">Password</label>
                <div class="relative">
                    <input type="password" value="pujakerangajaib" id="password" class="w-full p-2 border rounded pr-10">
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 px-3 flex items-center">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 3C4 3 0 10 0 10s4 7 10 7 10-7 10-7-4-7-10-7zm0 12a5 5 0 110-10 5 5 0 010 10zM10 7a3 3 0 100 6 3 3 0 000-6z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-600">Email</label>
                <input type="email" value="ryunee@example.com" disabled class="w-full p-2 border rounded bg-gray-200">
            </div>
            <div class="mb-4">
                <label class="block text-gray-600">No HP</label>
                <input type="text" value="08123456789" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label class="block text-gray-600">Tanggal Lahir</label>
                <input type="date" value="2000-01-01" disabled class="w-full p-2 border rounded bg-gray-200">
            </div>
            <div class="mb-4">
                <label class="block text-gray-600">LinkedIn</label>
                <input type="url" value="https://linkedin.com/in/Dede" class="w-full p-2 border rounded">
            </div>
            <div class="flex justify-between">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600" onclick="window.location.href='/jobs'">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const imgElement = document.getElementById("profile-image");
                imgElement.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function togglePassword() {
            const passwordField = document.getElementById("password");
            const eyeIcon = document.getElementById("eye-icon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.innerHTML = '<path d="M10 3C4 3 0 10 0 10s4 7 10 7 10-7 10-7-4-7-10-7zm0 12a5 5 0 110-10 5 5 0 010 10z"/>';
            } else {
                passwordField.type = "password";
                eyeIcon.innerHTML = '<path d="M10 3C4 3 0 10 0 10s4 7 10 7 10-7 10-7-4-7-10-7zm0 12a5 5 0 110-10 5 5 0 010 10zM10 7a3 3 0 100 6 3 3 0 000-6z"/>';
            }
        }

        document.getElementById("profile-form").addEventListener("submit", function(event) {
            event.preventDefault();
            alert("Perubahan tersimpan!");
            window.location.href = "/jobs";
        });
    </script>
</body>
</html>
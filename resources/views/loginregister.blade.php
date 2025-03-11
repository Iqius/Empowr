<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <section class="relative w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden flex flex-col md:flex-row">
        <!-- LOGIN FORM -->
        <div id="login-container" class="w-full md:w-1/2 p-8 flex flex-col items-center transition-all duration-700 ease-in-out">
            <h2 class="text-3xl font-semibold text-gray-700">Login</h2>
            <input type="text" placeholder="Username" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            <input type="password" placeholder="Password" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            <div class="flex items-center mt-3">
                <input type="checkbox" id="remember" class="mr-2">
                <label for="remember" class="text-sm text-gray-600">Remember Me</label>
            </div>
            <button class="w-full mt-4 bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Login</button>
        </div>

        <!-- REGISTER FORM -->
        <div id="register-container" class="w-full md:w-1/2 p-8 flex flex-col items-center transition-all duration-700 ease-in-out">
            <h2 class="text-3xl font-semibold text-gray-700">Register</h2>
            <input type="text" placeholder="Username" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            <input type="email" placeholder="Email" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            <select class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option>Client</option>
                <option>Worker</option>
            </select>
            <input type="password" placeholder="Password" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            <input type="date" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            <input type="text" placeholder="No HP" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            <button class="w-full mt-4 bg-green-500 text-white py-2 rounded hover:bg-green-600">Sign Up</button>
        </div>

        <!-- OVERLAY -->
        <div id="overlay-container" class="absolute inset-0 w-full md:w-1/2 h-1/2 md:h-full flex items-center justify-center bg-blue-700 text-white transition-all duration-700 ease-in-out">
            <div id="overlay-content" class="text-center">
                <h2 class="text-2xl font-semibold">Don't have an account?</h2>
                <button onclick="toggleForms()" class="mt-4 px-6 py-2 bg-white text-blue-700 rounded-lg">Sign Up</button>
            </div>
        </div>
    </section>

    <script>
        function toggleForms() {
            const overlay = document.getElementById('overlay-container');
            const overlayContent = document.getElementById('overlay-content');
            
            if (window.innerWidth >= 768) {
                // Desktop: Geser overlay kanan/kiri
                if (overlay.classList.contains('left-0')) {
                    overlay.classList.replace('left-0', 'left-1/2');
                    overlayContent.innerHTML = `
                        <h2 class='text-2xl font-semibold'>Already have an account?</h2>
                        <button onclick='toggleForms()' class='mt-4 px-6 py-2 bg-white text-blue-700 rounded-lg'>Sign In</button>
                    `;
                } else {
                    overlay.classList.replace('left-1/2', 'left-0');
                    overlayContent.innerHTML = `
                        <h2 class='text-2xl font-semibold'>Don't have an account?</h2>
                        <button onclick='toggleForms()' class='mt-4 px-6 py-2 bg-white text-blue-700 rounded-lg'>Sign Up</button>
                    `;
                }
            } else {
                // Mobile: Geser overlay atas/bawah
                if (overlay.classList.contains('top-0')) {
                    overlay.classList.replace('top-0', 'top-1/2');
                    overlayContent.innerHTML = `
                        <h2 class='text-2xl font-semibold'>Already have an account?</h2>
                        <button onclick='toggleForms()' class='mt-4 px-6 py-2 bg-white text-blue-700 rounded-lg'>Sign In</button>
                    `;
                } else {
                    overlay.classList.replace('top-1/2', 'top-0');
                    overlayContent.innerHTML = `
                        <h2 class='text-2xl font-semibold'>Don't have an account?</h2>
                        <button onclick='toggleForms()' class='mt-4 px-6 py-2 bg-white text-blue-700 rounded-lg'>Sign Up</button>
                    `;
                }
            }
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/images/logosaja.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .background-blue {
            background-color: #1F4482;
        }

        /* Animation for sliding in */
        .slide-left {
            animation: slideInLeft 1s ease-out forwards;
        }

        .slide-right {
            animation: slideInRight 1s ease-out forwards;
        }

        /* Keyframes for the slide-in effect */
        @keyframes slideInLeft {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="flex justify-center items-center h-screen bg-gray-100 px-0">
    <div class="flex w-full h-full">

        <!-- Left Section with Image and Text (Full Height) -->
        <div class="hidden md:flex w-1/2 background-blue p-12 justify-center items-center text-white slide-left">
            <div class="flex flex-col justify-center items-center space-y-6">
                <!-- Logo Placeholder -->
                <img src="assets/images/Login 1.png" alt="Logo" class="w-240 mb-4">
                <!-- Connect, Collaborate, Succeed Text as Image -->
            </div>
        </div>

        <!-- Right Section with Login Form (Full Height) -->
        <div class="w-full md:w-1/2 p-8 flex flex-col justify-center items-center slide-right">
            <form method="POST" action="{{ route('login') }}" class="w-full max-w-md">
                @csrf
                <h2 class="text-4xl font-extrabold text-[#1F4482] mb-2 ">Selamat Datang di Empowr</h2>
                <p class="block text-sm font-medium text-gray-600 mb-11">Masuk ke akunmu untuk mengakses layanan dari
                    kami!</p>

                <!-- Email Input -->
                <div class="relative mb-8">
                    <!-- Email Label -->
                    <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email Address</label>
                    <!-- Email Input -->
                    <input id="email" type="email" name="email" placeholder="Masukkan Email" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 
                @error('email') border-red-500 @enderror" value="{{ old('email') }}">

                    @error('email')
                    <p class="text-red-500 text-sm absolute mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="relative mb-4">
                    <!-- Password Label -->
                    <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                    <!-- Password Input -->
                    <input id="password" type="password" name="password" placeholder="Masukkan Password" class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 
                @error('password') border-red-500 @enderror">

                    <!-- Eye Icon for password visibility toggle -->
                    <button type="button" onclick="togglePassword()"
                        class="absolute right-3 top-1/2 transform -translate-y-1">
                        <i id="eye-icon" class="fa-solid fa-eye text-gray-500"></i>
                    </button>

                    @error('password')
                    <p class="text-red-500 text-sm absolute mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Forgot Password Link -->
                <div class="text-right mb-4">
                    <a href="{{ route('forgot-password.form') }}"
                        class="text-sm font-semibold text-[#1F4482] hover:underline">
                        Lupa Password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full mt-4 inline-block bg-[#183E74] font-semibold hover:bg-[#1a4a91] text-white text-sm sm:text-base px-8 py-2 rounded-md shadow">
                    Masuk
                </button>

                <!-- Register Link -->
                <p class="text-sm text-gray-600 mt-3">Belum memiliki akun?
                    <a href="{{ route('register') }}"
                        class="text-sm font-semibold text-[#1F4482] hover:underline">Daftar</a>
                </p>
            </form>
        </div>

        <script>
            document.getElementById("closeModal").addEventListener("click", function() {
                document.getElementById("errorModal").style.display = "none";
            });

            function togglePassword() {
                let passwordField = document.getElementById("password");
                let eyeIcon = document.getElementById("eye-icon");

                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    eyeIcon.classList.remove("fa-eye");
                    eyeIcon.classList.add("fa-eye-slash");
                } else {
                    passwordField.type = "password";
                    eyeIcon.classList.remove("fa-eye-slash");
                    eyeIcon.classList.add("fa-eye");
                }
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('
                success ') }}',
                confirmButtonColor: '#1F4482',
            });
            @endif

            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '{{ session('
                error ') }}',
                confirmButtonColor: '#1F4482',
            });
            @endif

            // ✅ SweetAlert for Success Message
            @if(session('kicked'))
            Swal.fire({
                icon: 'success',
                title: 'Kamu Ter-logout Paksa',
                text: "Anda telah login pada browser / device lain, anda akan dialihkan ke halaman login.",
                confirmButtonColor: '#1F4482',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = window.location.href;
            });
            @endif
        </script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    <link rel="icon" href="{{ asset('assets/images/logosaja.png') }}" type="image/png">

</head>

<body class="flex justify-center items-center h-screen bg-gray-100 px-0 overflow-auto">
    <div class="flex w-full h-full overflow-y-auto">

        <!-- Left Section with Image and Text (Full Height) -->
        <div class="hidden md:flex w-1/2 background-blue p-12 justify-center items-center text-white slide-left">
            <div class="flex flex-col justify-center items-center space-y-6">
                <!-- Logo Placeholder -->
                <img src="assets/images/Login 1.png" alt="Logo" class="w-240 mb-4">
                <!-- Connect, Collaborate, Succeed Text as Image -->
            </div>
        </div>

        <!-- Right Section with Register Form (Full Height) -->
        <div class="w-full md:w-1/2 p-8 flex flex-col justify-start items-center slide-right overflow-y-auto">
            <form method="POST" action="{{ route('register') }}" class="w-full max-w-md">
                @csrf
                <!-- Text Header -->
                <h2 class="text-4xl font-extrabold text-[#1F4482] mb-4">Daftar</h2>
                <p class="block text-sm font-medium text-gray-600 mb-6">Buat akun baru jika kamu belum punya!</p>

                <!-- Name Input -->
                <div class="relative mt-8 mb-8">
                    <label for="name" class="block text-sm font-medium text-gray-600 mb-1">Nama Panjang</label>
                    <input id="name" type="text" name="nama_lengkap" placeholder="Masukkan Nama Panjang"
                        class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nama_lengkap') border-red-500 @enderror"
                        value="{{ old('nama_lengkap') }}">
                    @error('nama_lengkap') <p class="text-red-500 text-sm absolute mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Username Input -->
                <div class="relative mb-8">
                    <label for="username" class="block text-sm font-medium text-gray-600 mb-1">Username</label>
                    <input id="username" type="text" name="username" placeholder="Masukkan Username"
                        class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 @error('username') border-red-500 @enderror"
                        value="{{ old('username') }}">
                    @error('username') <p class="text-red-500 text-sm absolute mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email Input -->
                <div class="relative mb-8">
                    <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email Address</label>
                    <input id="email" type="email" name="email" placeholder="Masukkan Email"
                        class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}">
                    @error('email') <p class="text-red-500 text-sm absolute mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Role Input -->
                <div class="relative mb-8">
                    <label for="role" class="block text-sm font-medium text-gray-600 mb-1">Role</label>
                    <select name="role" required
                        class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option>Pilih Role</option>
                        <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                        <option value="worker" {{ old('role') == 'worker' ? 'selected' : '' }}>Worker</option>
                    </select>
                    @error('role') <p class="text-red-500 text-sm absolute mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Password Input -->
                <div class="relative mb-8">
                    <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                    <input id="password" type="password" name="password" placeholder="Masukkan Password"
                        class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                        autocomplete="new-password" required>
                    <button type="button" onclick="togglePassword()"
                        class="absolute right-3 top-1/2 transform -translate-y-1">
                        <i id="eye-icon" class="fa-solid fa-eye text-gray-500"></i>
                    </button>
                    @error('password') <p class="text-red-500 text-sm absolute mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Confirm Password Input -->
                <div class="relative mb-8">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-600 mb-1">Confirm
                        Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        placeholder="Masukkan Password"
                        class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                        autocomplete="new-password" required>
                    <button type="button" onclick="togglePassword()"
                        class="absolute right-3 top-1/2 transform -translate-y-1">
                        <i id="eye-icon-confirm" class="fa-solid fa-eye text-gray-500"></i>
                    </button>
                    @error('password_confirmation') <p class="text-red-500 text-sm absolute mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Input -->
                <div class="relative mb-8">
                    <label for="nomor_telepon" class="block text-sm font-medium text-gray-600 mb-1">Nomor
                        Telepon</label>
                    <input id="nomor_telepon" type="text" name="nomor_telepon" placeholder="Masukkan Nomor Telepon"
                        class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ old('nomor_telepon') }}" required>
                    @error('phone') <p class="text-red-500 text-sm absolute mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Submit Button -->
                <button id="submitBtn" type="submit"
                    class="w-full mt-4 inline-block bg-[#183E74] font-semibold hover:bg-[#1a4a91] text-white text-sm sm:text-base px-8 py-2 rounded-md shadow">Daftar
                    </button>

                <!-- Login Link -->
                <p class="text-sm text-gray-600 mt-3 mb-6">Sudah punya akun? <a href="{{ route('login') }}"
                        class="text-sm font-semibold text-[#1F4482] hover:underline">Masuk</a></p>
            </form>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function () {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = 'Tunggu Sebentar...';
        });

        function togglePassword() {
            let passwordField = document.getElementById("password");
            let passwordConfirmField = document.getElementById("password_confirmation");
            let eyeIcon = document.getElementById("eye-icon");
            let eyeIconConfirm = document.getElementById("eye-icon-confirm");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                passwordConfirmField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
                eyeIconConfirm.classList.remove("fa-eye");
                eyeIconConfirm.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                passwordConfirmField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
                eyeIconConfirm.classList.remove("fa-eye-slash");
                eyeIconConfirm.classList.add("fa-eye");
            }
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Register!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#1F4482',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '{{ route('login') }}';
            });
        @endif
    </script>
</body>

</html>
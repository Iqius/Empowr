<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- font-awesome -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        .background-blue {
            background-color: #1F4482;
        }

        .slide-left {
            animation: slideInLeft 1s ease-out forwards;
        }

        .slide-right {
            animation: slideInRight 1s ease-out forwards;
        }

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

<body class="bg-gray-100">

    <div class="flex w-full h-screen">
        <!-- Left Section -->
        <div class="hidden md:flex w-1/2 background-blue p-12 justify-center items-center text-white slide-left">
            <div class="flex flex-col justify-center items-center space-y-6">
                <img src="assets/images/Login 1.png" alt="Logo" class="w-240 mb-4">
            </div>
        </div>

        <!-- Right Section -->
        <div class="w-full md:w-1/2 p-8 flex flex-col justify-center items-center slide-right overflow-y-auto">
            <form method="POST" action="{{ route('forgot-password.set-new-password') }}" class="w-full max-w-md">
                @csrf
                <input type="hidden" name="email" value="{{ session('email') }}">

                <h2 class="text-4xl font-extrabold text-[#1F4482] mb-4">Set New Password</h2>
                <p class="block text-sm font-medium text-gray-600 mb-6">Please enter your new password</p>

                @if(session('error'))
                    <div class="mb-4 text-red-500 text-sm">{{ session('error') }}</div>
                @endif

                <!-- New Password -->
              <div class="relative mb-8">
                    <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                    <input id="password" type="password" name="password" placeholder="Masukkan Password"
                        class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                        autocomplete="new-password" required>
                    <button type="button" onclick="togglePassword()"
                        class="absolute right-3 top-1/2 transform -translate-y-1">
                        <i id="eye-icon" class="fa-solid fa-eye text-gray-500"></i>
                    </button>
                </div>

                <!-- Confirm Password -->
                <div class="relative mb-8">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-600 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password"
                        class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base pr-10"
                        required>
                    <button type="button" onclick="togglePassword()"
                        class="absolute right-3 top-1/2 transform -translate-y-1">
                        <i id="eye-icon-confirm" class="fa-solid fa-eye text-gray-500"></i>
                    </button>
                    @error('password')
                        <div class="text-red-500 text-sm mt-2">Password konfirmasi tidak sesuai dengan password.</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full mt-4 inline-block bg-[#183E74] font-semibold hover:bg-[#1a4a91] text-white text-sm sm:text-base px-8 py-2 rounded-md shadow">
                    Submit
                </button>
            </form>
        </div>
    </div>

<script>
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

    // Show SweetAlert if session success exists
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            confirmButtonText: 'OK',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('login') }}";
            }
        });
    @endif
</script>


</body>

</html>

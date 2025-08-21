<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
    <link rel="icon" href="{{ asset('assets/images/logosaja.png') }}" type="image/png">
</head>

<body class="bg-gray-100">

    <div class="flex w-full h-screen">

        <!-- Left Section with Image and Text (Full Height) -->
        <div class="hidden md:flex w-1/2 background-blue p-12 justify-center items-center text-white slide-left">
            <div class="flex flex-col justify-center items-center space-y-6">
                <!-- Logo Placeholder -->
                <img src="assets/images/Login 1.png" alt="Logo" class="w-240 mb-4">
                <!-- Connect, Collaborate, Succeed Text as Image -->
            </div>
        </div>

        <!-- Right Section with Forgot Password Form (Full Height) -->
        <div class="w-full md:w-1/2 p-8 flex flex-col justify-center items-center slide-right overflow-y-auto">
            <form method="POST" action="{{ route('forgot-password.send-otp') }}" class="w-full max-w-md">
                @csrf
                <h2 class="text-4xl font-extrabold text-[#1F4482] mb-4 text-center">Lupa Password</h2>
                <p class="block text-sm font-medium text-gray-600 mb-6 text-center">masukkan email untuk menerima kode verifikasi</p>

                <!-- Email Input -->
                <div class="relative mb-8">
                    <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Alamat Email</label>
                    <input id="email" type="email" name="email" placeholder="Enter Email"
                        class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}" required>
                    @error('email') <p class="text-red-500 text-sm absolute mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full mt-4 inline-block bg-[#183E74] font-semibold hover:bg-[#1a4a91] text-white text-sm sm:text-base px-8 py-2 rounded-md shadow">Kirim
                    OTP</button>

                <!-- Back to Login Link -->
                <p class="text-sm text-gray-600 mt-3 text-center">Ingat Password anda? <a href="{{ route('login') }}"
                        class="text-sm font-semibold text-[#1F4482] hover:underline">Masuk</a></p>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("closeModal")?.addEventListener("click", function () {
            window.location.href = "{{ route('login') }}";
        });

        // SweetAlert2 for success message
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'OTP Sent Successfully!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#2563EB',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = "{{ route('forgot-password.form') }}"; // Redirect after alert
            });
        @endif
    </script>
</body>

</html>
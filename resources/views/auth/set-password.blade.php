<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- font-awesome -->
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
            <form method="POST" action="{{ route('forgot-password.set-new-password') }}" class="w-full max-w-md">
                @csrf
                <h2 class="text-4xl font-extrabold text-[#1F4482] mb-4 ">Set New Password</h2>
                <p class="block text-sm font-medium text-gray-600 mb-6 ">Please enter your new password</p>

                @if(session('error'))
                    <div class="mb-4 text-red-500 text-sm">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="mb-4 text-green-500 text-sm">{{ session('success') }}</div>
                @endif

                <!-- Password Input -->
                <div class="relative mb-8">
                    <label for="password" class="block text-sm font-medium text-gray-600 mb-1">New Password</label>
                    <input type="password" name="password" id="password" placeholder="New Password"
                        class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base pr-10"
                        required>
                    <button type="button" onclick="toggleVisibility('password', 'iconPass')"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600">
                        <i id="iconPass" class="fas fa-eye"></i>
                    </button>
                    @error('password') <div class="text-red-500 text-sm mt-2">{{ $message }}</div> @enderror
                </div>

                <!-- Confirm Password Input -->
                <div class="relative mb-8">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-600 mb-1">Confirm
                        Password</label>
                    <input type="password" name="password_confirmation" id="passwordConfirm"
                        placeholder="Confirm Password"
                        class="w-full p-3 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base pr-10"
                        required>
                    <button type="button" onclick="toggleVisibility('passwordConfirm', 'iconConfirm')"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600">
                        <i id="iconConfirm" class="fas fa-eye"></i>
                    </button>
                    @error('password_confirmation') <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full mt-4 inline-block bg-[#183E74] font-semibold hover:bg-[#1a4a91] text-white text-sm sm:text-base px-8 py-2 rounded-md shadow">Submit</button>

            </form>
        </div>
    </div>

    <script>
        function toggleVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>
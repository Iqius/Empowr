<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Atur Ulang Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- font-awesome -->
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-sm sm:max-w-md md:max-w-lg lg:max-w-md xl:max-w-md p-6 sm:p-8 bg-white rounded-lg shadow text-center">
        <h2 class="text-2xl sm:text-3xl font-semibold text-gray-700 mb-6">Set New Password</h2>

        @if(session('error'))
            <div class="mb-4 text-red-500 text-sm">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="mb-4 text-green-500 text-sm">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('forgot-password.set-new-password') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">

            <!-- Password -->
            <div class="relative mb-4">
                <input type="password" name="password" id="password" placeholder="New Password"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base pr-10" required>
                <button type="button" onclick="toggleVisibility('password', 'iconPass')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600">
                    <i id="iconPass" class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
            @enderror

            <!-- Confirm Password -->
            <div class="relative mb-6">
                <input type="password" name="password_confirmation" id="passwordConfirm" placeholder="Confirm Password"
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base pr-10" required>
                <button type="button" onclick="toggleVisibility('passwordConfirm', 'iconConfirm')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600">
                    <i id="iconConfirm" class="fas fa-eye"></i>
                </button>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium transition">
                Submit
            </button>
        </form>
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

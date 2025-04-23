<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- ✅ responsive meta -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-sm sm:max-w-md md:max-w-lg lg:max-w-md xl:max-w-md p-6 sm:p-8 bg-white rounded-lg shadow-md text-center">
        <h2 class="text-2xl sm:text-3xl font-semibold text-gray-700 mb-6">Forgot Password</h2>

        @if(session('success'))
            <div class="mb-4 text-green-600 text-sm">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('forgot-password.send-otp') }}">
            @csrf
            <input type="email" name="email" placeholder="Masukkan email"
                   class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 mb-4 text-sm sm:text-base"
                   value="{{ old('email') }}" required>
            @error('email')
                <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
            @enderror

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 transition-colors text-white py-2 rounded-lg text-sm sm:text-base">
                Kirim OTP
            </button>
        </form>
    </div>
</body>
</html>

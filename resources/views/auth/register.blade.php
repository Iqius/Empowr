<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center min-h-screen bg-gray-100 p-4">
    <div class="w-full max-w-sm p-8 bg-white shadow-md rounded-md">
    @if(session('success'))
    <div id="successModal" class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-md text-center">
            <h2 class="text-lg font-semibold text-green-600">Registration Successful</h2>
            <p class="mt-2 text-gray-700">{{ session('success') }}</p>
            <button id="closeModal" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">OK</button>
        </div>
    </div>
@endif


        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h2 class="text-3xl font-semibold text-gray-700 text-center">Register</h2>

            <input type="text" name="name" placeholder="Name" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ old('name') }}" required>
            @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            <input type="text" name="username" placeholder="Username" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ old('username') }}" required>
            @error('username') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            <input type="email" name="email" placeholder="Email" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ old('email') }}" required>
            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            <select name="role" required class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                <option value="worker" {{ old('role') == 'worker' ? 'selected' : '' }}>Worker</option>
            </select>
            @error('role') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            <input type="password" name="password" placeholder="Password" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" autocomplete="new-password" required>
            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" autocomplete="new-password" required>
            @error('password_confirmation') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror


            <label class="text-sm text-gray-600">Tanggal Lahir</label>
            <input type="date" name="date" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ old('date') }}" required>
            @error('date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            <input type="text" name="phone" placeholder="No HP" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ old('phone') }}" required>
            @error('phone') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            <button type="submit" class="w-full mt-4 bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Sign Up</button>
        </form>
        <p class="text-sm text-gray-600 mt-3 text-center">Already have an account? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a></p>
    </div>
</body>
    <script>
        document.getElementById("closeModal")?.addEventListener("click", function () {
            window.location.href = "{{ route('login') }}"; // Redirect ke halaman login
        });
    </script>

</html>

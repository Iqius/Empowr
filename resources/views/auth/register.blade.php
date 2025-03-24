<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body class="flex justify-center items-center min-h-screen bg-gray-100 p-4">
    <div class="w-full max-w-sm p-8 bg-white shadow-md rounded-md">
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

            <div class="relative w-full mt-3">
                <input id="password" type="password" name="password" placeholder="Password"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" 
                    autocomplete="new-password" required>
                <button type="button" onclick="togglePassword()" 
                    class="absolute inset-y-0 right-3 flex items-center">
                    <i id="eye-icon" class="fa-solid fa-eye text-gray-500"></i>
                </button>
            </div>
            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            <div class="relative w-full mt-3">
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" 
                    autocomplete="new-password" required>
                <button type="button" onclick="togglePassword()" 
                    class="absolute inset-y-0 right-3 flex items-center">
                    <i id="eye-icon-confirm" class="fa-solid fa-eye text-gray-500"></i>
                </button>
            </div>
            @error('password_confirmation') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror


            <!-- <label class="text-sm text-gray-600">Tanggal Lahir</label>
            <input type="date" name="date" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ old('date') }}" required>
            @error('date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror -->

            <input type="text" name="phone" placeholder="No HP" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ old('phone') }}" required>
            @error('phone') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

            <button type="submit" class="w-full mt-4 bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Sign Up</button>
        </form>
        <p class="text-sm text-gray-600 mt-3 text-center">Already have an account? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a></p>
    </div>
</body>

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

    document.addEventListener("DOMContentLoaded", function () {
        // Redirect button if closeModal exists (fallback dari alert sebelumnya)
        document.getElementById("closeModal")?.addEventListener("click", function () {
            window.location.href = "{{ route('login') }}";
        });

        // SweetAlert2 untuk session success (jika ada)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Registrasi Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#2563EB',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = "{{ route('login') }}"; // Redirect setelah alert ditutup
            });
        @endif
    });
</script>


</html>

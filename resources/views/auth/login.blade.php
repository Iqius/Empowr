<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="flex justify-center items-center h-screen bg-gray-100 px-4">
    <div class="w-full max-w-sm p-8 bg-white shadow-md rounded-md text-center">
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- <img src="assets/images/logo.png" alt="Logo" class="w-24 mx-auto mb-4"> -->
            <h2 class="text-3xl font-semibold text-gray-700">Login</h2>
            <!-- Username Input -->
            <div class="relative mb-4">
            <input type="text" name="username" placeholder="Username" 
                    class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 
                    @error('username') border-red-500 @enderror" 
                    value="{{ old('username') }}">
                @error('username')
                    <p class="text-red-500 text-sm absolute mt-1">{{ $message }}</p>
                @enderror
            </div>
             <!-- Password Input -->
             <div class="relative mb-4">
             <input id="password" type="password" name="password" placeholder="Password"
        class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 
        @error('password') border-red-500 @enderror">
    
        <button type="button" onclick="togglePassword()"         
            class="absolute right-3 top-1/2 transform -translate-y-1 flex items-center">
            <i id="eye-icon" class="fa-solid fa-eye text-gray-500"></i>
        </button>


    @error('password')
        <p class="text-red-500 text-sm absolute mt-1">{{ $message }}</p>
    @enderror
            </div>
            <!-- <div class="flex items-center mt-3">
                <input type="checkbox" name="remember" id="remember" class="mr-2">
                <label for="remember" class="text-sm text-gray-600">Remember Me</label>
            </div> -->
            <!-- Forgot Password -->
<div class="text-right mb-4">
    <a href="{{ route('forgot-password.form') }}" class="text-sm text-blue-500 hover:underline">
        Forgot Password?
    </a>
</div>
            <button type="submit" class="w-full mt-4 bg-blue-500 text-white py-2 rounded hover:bg-blue-600" >Login</button>
        </form>
        @if(session('error'))
        <div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-4 rounded shadow-md w-80 text-center">
                <h2 class="text-lg font-semibold text-red-600 mb-2">Login Failed</h2>
                <p>{{ session('error') }}</p>
                <button id="closeModal" class="mt-4 px-4 py-2 bg-gray-300 rounded">Close</button>
            </div>
        </div>

        @endif

        <p class="text-sm text-gray-600 mt-3">Don't have an account? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register</a></p>
    </div>
    
    <script>
            document.getElementById("closeModal").addEventListener("click", function () {
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
</body>
</html>
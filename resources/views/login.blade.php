<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center h-screen bg-gray-100 px-4">
    <div class="w-full max-w-sm p-8 bg-white shadow-md rounded-md text-center">
        <img src="assets/images/logo.png" alt="Logo" class="w-24 mx-auto mb-4">
        <h2 class="text-3xl font-semibold text-gray-700">Login</h2>
        <input type="text" placeholder="Username" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        <input type="password" placeholder="Password" class="w-full mt-3 p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        <div class="flex items-center mt-3">
            <input type="checkbox" id="remember" class="mr-2">
            <label for="remember" class="text-sm text-gray-600">Remember Me</label>
        </div>
        <button onclick="window.location.href='/jobs'" class="w-full mt-4 bg-blue-500 text-white py-2 rounded hover:bg-blue-600" >Login</button>
        <p class="text-sm text-gray-600 mt-3">Don't have an account? <a href="/register" class="text-blue-500 hover:underline">Register</a></p>
    </div>
</body>
</html>